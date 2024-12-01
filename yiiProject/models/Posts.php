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

    public function getTags()
    {
        return $this->hasMany(Tags::class, ['id' => 'tag_id'])
            ->viaTable('post_tags', ['post_id' => 'id']);
    }

    public function getComments()
    {
        return $this->hasMany(Comments::class, ['post_id' => 'id']);
    }
}
