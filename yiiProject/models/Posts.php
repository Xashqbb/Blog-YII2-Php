<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Posts extends ActiveRecord
{
    public $imageFile;

    public static function tableName()
    {
        return 'posts';
    }

    public function rules()
    {
        return [
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
                $this->image = '/uploads/' . $this->imageFile->name;
            } else {
                Yii::$app->session->setFlash('error', 'File upload failed.');
            }
        }

        return $this->save(false);
    }
}
