<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Posts extends ActiveRecord
{
    public $date;
    public $imageFile;
    public $categoryName;

    public static function tableName()
    {
        return 'posts';
    }

    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['title', 'content', 'category_id', 'user_id'], 'required'],
            [['title', 'content'], 'string'],
            [['category_id', 'user_id'], 'integer'],
            [['imageFile'], 'file', 'extensions' => 'jpg, jpeg, png', 'checkExtensionByMimeType' => true],
        ];
    }

    public function savePost()
    {
        $this->user_id = Yii::$app->user->id;
        if ($this->save(false)) {
            // Manage the tags
            if (is_array($this->tags)) {
                $this->saveTags($this->tags);
            }
        }
        if ($this->imageFile) {
            $imageUpload = new ImageUpload();
            $imageUpload->imageFile = $this->imageFile;

            if ($imageUpload->upload($this->id)) {
                $this->image = '/uploads/images/' . $this->imageFile->name;
            } else {
                Yii::$app->session->setFlash('error', 'File upload failed.');
            }
        }

        return $this->save(false);
    }

    public function saveTags($tags)
    {
        // First, delete the old tags associated with this post
        PostTags::deleteAll(['post_id' => $this->id]);

        // Then, associate the new tags
        foreach ($tags as $tagId) {
            $postTag = new PostTags();
            $postTag->post_id = $this->id;
            $postTag->tag_id = $tagId;
            $postTag->save();
        }
    }

    // Get tags associated with the post
    public function getTags()
    {
        return $this->hasMany(Tags::class, ['id' => 'tag_id'])
            ->viaTable('post_tags', ['post_id' => 'id']);
    }

    public function getDate()
    {
        return Yii::$app->formatter->asDate($this->created_at, 'long');
    }


    public function getImage()
    {
        return Yii::getAlias('@web') . $this->image;
    }

    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    public function getCategory()
    {
        return $this->hasOne(Categories::class, ['id' => 'category_id']);
    }
    public function getCategoryName()
    {
        return $this->category ? $this->category->name : null;
    }



    public function getComments()
    {
        return $this->hasMany(Comments::class, ['post_id' => 'id']);
    }

    public function viewedCounter()
    {
        $this->viewed += 1;
        return $this->save(false);
    }
    // Action to create a new post
    public function actionCreate()
    {
        $model = new Posts();

        if ($model->load(Yii::$app->request->post()) && $model->savePost()) {
            return $this->redirect(['site/view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

// Action to edit an existing post
    public function actionEdit($id)
    {
        $model = Posts::findOne($id);

        if ($model === null || $model->user_id != Yii::$app->user->id) {
            // Only the author can edit the post
            throw new \yii\web\ForbiddenHttpException('You do not have permission to edit this post.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->savePost()) {
            return $this->redirect(['site/view', 'id' => $model->id]);
        }

        return $this->render('edit', [
            'model' => $model,
        ]);
    }

// Action to delete a post
    public function actionDelete($id)
    {
        $model = Posts::findOne($id);

        if ($model === null || $model->user_id != Yii::$app->user->id) {
            // Only the author can delete the post
            throw new \yii\web\ForbiddenHttpException('You do not have permission to delete this post.');
        }

        $model->delete();
        return $this->redirect(['site/index']);
    }

}
