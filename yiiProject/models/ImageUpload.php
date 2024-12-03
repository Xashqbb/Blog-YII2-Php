<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class ImageUpload extends Model
{
    public $imageFile;
    private $uploadedFilePath;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'extensions' => 'jpg, jpeg, png', 'checkExtensionByMimeType' => true, 'maxSize' => 1024 * 1024 * 2],
        ];
    }

    public function upload($postId)
    {
        if ($this->validate()) {
            $uploadPath = Yii::getAlias('@webroot/uploads/images');
            if (!is_dir($uploadPath)) {
                if (!mkdir($uploadPath, 0777, true)) {
                    throw new \Exception('Failed to create directory for uploads.');
                }
            }
            $fileName = Yii::$app->security->generateRandomString(10) . '.' . $this->imageFile->extension;
            $filePath = $uploadPath . '/' . $fileName;

            if ($this->imageFile->saveAs($filePath)) {
                $this->uploadedFilePath = '/uploads/images/' . $fileName;
                return true;
            } else {
                $this->addError('imageFile', 'Failed to save file.');
            }
        }
        return false;
    }


    public function getUploadedFilePath()
    {
        return $this->uploadedFilePath;
    }
}
