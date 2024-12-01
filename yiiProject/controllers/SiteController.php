<?php

namespace app\controllers;

use app\models\Categories;
use app\models\Posts;
use app\models\Comments;  // Додано модель для коментарів
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\data\Pagination;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
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
        // Створюємо запит для отримання всіх постів з пагінацією
        $query = Posts::find();

        // Пагінація
        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        // Отримуємо пости з пагінацією
        $posts = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        // Отримуємо популярні пости за кількістю коментарів
        $popularPosts = Posts::find()
            ->joinWith('comments')  // Приєднуємо таблицю коментарів
            ->groupBy('posts.id')   // Групуємо за постами
            ->orderBy(['COUNT(comments.id)' => SORT_DESC])  // Сортуємо за кількістю коментарів
            ->limit(5)
            ->all();

        // Повертаємо вигляд з даними
        return $this->render('index', [
            'posts' => $posts,
            'pagination' => $pagination,
            'popularPosts' => $popularPosts,
        ]);
    }



    // Дія для перегляду конкретного поста
    // Дія для перегляду конкретного поста
    // SiteController.php

    public function actionView($id)
    {
        $post = Posts::findOne($id);
        if ($post === null) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }
        $category = Categories::findOne($post->category_id);
        $query = Posts::find();
        $comments = Comments::find()->where(['post_id' => $id])->all();
        $commentsPagination = new \yii\data\Pagination(['totalCount' => count($comments), 'pageSize' => 10]);
        $pagination = new \yii\data\Pagination([
            'totalCount' => $query->count(),
            'pageSize' => 5,
        ]);

        $posts = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $popular = \app\models\Posts::find()
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(5)
            ->all();

        $recent = \app\models\Posts::find()
            ->orderBy(['updated_at' => SORT_DESC])
            ->limit(5)
            ->all();

        return $this->render('single', [
            'post' => $post,
            'category' => $category,
            'posts' => $posts,
            'comments' => $comments,
            'pagination' => $commentsPagination,
            'popular' => $popular,
            'recent' => $recent,
        ]);
    }

    


    public function actionTopic($id)
    {
        $category = Categories::findOne($id);

        if (!$category) {
            throw new \yii\web\NotFoundHttpException('Category not found');
        }

        // Retrieve posts belonging to this category
        $query = Posts::find()->where(['category_id' => $id]);

        $pagination = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => 5,
        ]);

        $posts = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $popular = \app\models\Posts::find()
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(5)
            ->all();

        // Fetch recent topics/posts
        $recent = \app\models\Posts::find()
            ->orderBy(['updated_at' => SORT_DESC])
            ->limit(5)
            ->all();

        // Fetch all categories
        $topics = \app\models\Categories::find()->all();

        // Ensure $posts is passed to the view
        return $this->render('topic', [
            'posts' => $posts,
            'category' => $category,
            'pagination' => $pagination,
            'popular' => $popular,
            'recent' => $recent,
            'topics' => $topics
        ]);
    }


}
