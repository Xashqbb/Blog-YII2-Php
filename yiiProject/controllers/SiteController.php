<?php

    namespace app\controllers;

    use app\models\Categories;
    use app\models\Comments;
    use app\models\ImageUpload;
    use app\models\Posts;
    use app\models\PostsSearch;
    use app\models\Tags;
    use app\models\Users;
    use Yii;
    use yii\data\Pagination;
    use yii\filters\AccessControl;
    use yii\filters\VerbFilter;
    use yii\helpers\ArrayHelper;
    use yii\web\Controller;
    use yii\web\UploadedFile;

    class SiteController extends Controller
    {
        public function behaviors()
        {
            return [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['createPost', 'editPost', 'deletePost', 'editProfile'],
                    'rules' => [
                        [
                            'actions' => ['createPost', 'editPost', 'deletePost', 'editProfile'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'logout' => ['POST'],
                        'create-post' => ['GET', 'POST'],
                        'edit-post' => ['GET', 'POST'],
                        'delete-post' => ['POST'],
                        'edit-profile' => ['GET', 'POST'],
                    ],
                ],

            ];
        }

        public function actions()
        {
            return [
                'error' => [
                    'class' => 'yii\web\ErrorAction',
                ],
                'captcha' => [
                    'class' => 'yii\captcha\CaptchaAction',
                    'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                ],
            ];
        }

        // Дія для відображення списку постів
        public function actionIndex()
        {
            $query = Posts::find();
            $searchModel = new \app\models\PostsSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $pagination = new Pagination([
                'defaultPageSize' => 5,
                'totalCount' => $query->count(),
            ]);

            $posts = $query->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();

            // Популярні пости за кількістю коментарів
            $popularPosts = Posts::find()
                ->joinWith('comments')
                ->groupBy('posts.id')
                ->orderBy(['COUNT(comments.id)' => SORT_DESC])
                ->limit(5)
                ->all();

            return $this->render('index', [
                'posts' => $posts,
                'pagination' => $pagination,
                'popularPosts' => $popularPosts,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider
            ]);
        }

        // Дія для перегляду конкретного поста
        public function actionView($id)
        {
            $post = Posts::findOne($id);
            if ($post === null) {
                throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
            }

            $category = Categories::findOne($post->category_id);
            $comments = Comments::find()->where(['post_id' => $id])->all();
            $commentsPagination = new \yii\data\Pagination(['totalCount' => count($comments), 'pageSize' => 10]);

            $posts = Posts::find()
                ->orderBy(['created_at' => SORT_DESC])
                ->limit(5)
                ->all();

            $recent = Posts::find()
                ->orderBy(['updated_at' => SORT_DESC])
                ->limit(5)
                ->all();

            return $this->render('single', [
                'post' => $post,
                'category' => $category,
                'comments' => $comments,
                'pagination' => $commentsPagination,
                'popular' => $posts,
                'recent' => $recent,
            ]);
        }

        // Дія для перегляду постів за категорією
        public function actionTopic($id)
        {
            $category = Categories::findOne($id);

            if (!$category) {
                throw new \yii\web\NotFoundHttpException('Category not found');
            }

            $query = Posts::find()->where(['category_id' => $id]);
            $pagination = new \yii\data\Pagination([
                'totalCount' => $query->count(),
                'pageSize' => 10,
            ]);

            $posts = $query->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();

            // For the sidebar
            $popular = Posts::find()->orderBy('created_at DESC')->limit(5)->all();
            $recent = Posts::find()->orderBy('created_at DESC')->limit(5)->all();

            // Search model initialization
            $searchModel = new PostsSearch();

            return $this->render('topic', [
                'posts' => $posts,
                'category' => $category,
                'pagination' => $pagination,
                'popular' => $popular,
                'recent' => $recent,
                'searchModel' => $searchModel, // Pass searchModel to the view
            ]);
        }

        public function actionLogout()
        {
            Yii::$app->user->logout();
            return $this->goHome();
        }

        // Дія для коментування
        public function actionComment($postId)
        {
            if (Yii::$app->request->isPost) {
                $comment = new Comments();
                $comment->post_id = $postId;
                $comment->user_id = Yii::$app->user->id;
                $comment->content = Yii::$app->request->post('content');
                $comment->created_at = date('Y-m-d H:i:s');
                $comment->updated_at = date('Y-m-d H:i:s');

                if ($comment->save()) {
                    return $this->redirect(['site/view', 'id' => $postId]);
                } else {
                    Yii::$app->session->setFlash('error', 'Не вдалося зберегти коментар.');
                }
            }
        }

        // Дія для пошуку постів
        public function actionSearch()
        {
            $searchModel = new PostsSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            // Популярні пости
            $popularPosts = Posts::find()
                ->orderBy(['created_at' => SORT_DESC])
                ->limit(5)
                ->all();

            return $this->render('search', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'popularPosts' => $popularPosts,

            ]);
        }

        // Дія для відповіді на коментар
        public function actionReply($postId, $parentId)
        {
            $comment = new Comments();
            $comment->post_id = $postId;
            $comment->parent_id = $parentId; // Відповідь на конкретний коментар
            $comment->user_id = Yii::$app->user->id;
            $comment->content = Yii::$app->request->post('content');
            $comment->created_at = date('Y-m-d H:i:s');
            $comment->updated_at = date('Y-m-d H:i:s');

            if ($comment->save()) {
                return $this->redirect(['site/view', 'id' => $postId]);
            } else {
                Yii::$app->session->setFlash('error', 'Failed to post the comment.');
            }
        }

    // Action to display the create post form
        // actionCreatePost method
        public function actionCreatePost()
        {
            $model = new Posts();
            $categories = Categories::find()->select(['name', 'id'])->indexBy('id')->column();
            $tags = Tags::find()->all(); // Fetch available tags
            $imageUploadModel = new ImageUpload();

            if ($model->load(Yii::$app->request->post())) {
                // Set additional data for the post
                $model->user_id = Yii::$app->user->id;
                $model->created_at = date('Y-m-d H:i:s');
                $model->updated_at = date('Y-m-d H:i:s');

                // Save the post
                if ($model->save(false)) {
                    // Handle image upload
                    $imageUploadModel->imageFile = UploadedFile::getInstance($imageUploadModel, 'imageFile');
                    if ($imageUploadModel->imageFile && $imageUploadModel->upload($model->id)) {
                        $model->image = $imageUploadModel->getUploadedFilePath();
                        $model->save();
                    }

                    // Handle tags
                    if ($tags = Yii::$app->request->post('tags')) {
                        foreach ($tags as $tagId) {
                            // Assuming you have a method to save tags in the junction table
                            $model->link('tags', Tags::findOne($tagId));
                        }
                    }

                    Yii::$app->session->setFlash('success', 'Post successfully created.');
                    return $this->redirect(['site/profile']);
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to save the post.');
                }
            }

            return $this->render('create-post', [
                'model' => $model,
                'categories' => $categories,
                'tags' => $tags, // Pass tags to the view
                'imageUploadModel' => $imageUploadModel,
            ]);
        }

    // actionEditPost method
        public function actionEditPost($id)
        {
            $model = Posts::findOne($id);
            $categories = Categories::find()->select(['name', 'id'])->indexBy('id')->column();
            $tags = Tags::find()->all(); // Fetch available tags
            $imageUploadModel = new ImageUpload();

            if ($model->load(Yii::$app->request->post())) {
                // Handle image upload
                $imageUploadModel->imageFile = UploadedFile::getInstance($model, 'imageFile');
                if ($imageUploadModel->imageFile && $imageUploadModel->upload($id)) {
                    $model->image = $imageUploadModel->getUploadedFilePath();
                }

                // Save the post
                if ($model->savePost()) {
                    // Handle tags using the saveTags method
                    if ($tags = Yii::$app->request->post('tags')) {
                        $model->saveTags($tags); // Save tags via the method
                    }

                    Yii::$app->session->setFlash('success', 'Post updated successfully.');
                    return $this->redirect(['site/profile']);
                }
            }

            return $this->render('edit-post', [
                'model' => $model,
                'categories' => $categories,
                'tags' => $tags, // Pass tags to the view
                'imageUploadModel' => $imageUploadModel,
            ]);
        }




        // Дія для видалення поста
        public function actionDeletePost($id)
        {
            $model = Posts::findOne($id);
            if ($model && $model->user_id == Yii::$app->user->id) {
                $model->delete();
            }

            return $this->redirect(['site/index']);
        }

        // Дія для профілю користувача
        public function actionProfile()
        {
            $userId = Yii::$app->user->id;
            $user = Users::findOne($userId);

            if ($user === null) {
                throw new \yii\web\NotFoundHttpException('User not found.');
            }

            $posts = Posts::find()->where(['user_id' => $userId])->all();

            return $this->render('profile', [
                'user' => $user,
                'posts' => $posts,
            ]);
        }

        // Дія для редагування профілю
        public function actionEditProfile()
        {
            $userId = Yii::$app->user->id;
            $user = Users::findOne($userId);

            if ($user->load(Yii::$app->request->post()) && $user->save()) {
                Yii::$app->session->setFlash('success', 'Profile updated successfully.');
                return $this->redirect(['site/profile']);
            }

            return $this->render('edit-profile', ['user' => $user]);
        }
    }
