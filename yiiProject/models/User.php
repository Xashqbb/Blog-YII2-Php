<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'users';  // Назва вашої таблиці користувачів
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // Реалізація для знаходження користувача за токеном (необхідно за бажанням)
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        // Для реалізації авторизації через ключ (необхідно за бажанням)
    }

    public function validateAuthKey($authKey)
    {
        // Для перевірки authKey (необхідно за бажанням)
    }

    public static function findByUsername($username)
    {
        return self::find()->where(['name' => $username])->one();
    }

    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);  // Перевірка пароля через хешування
    }

    public function getUsername()
    {
        return $this->username;
    }
    public function create()
    {
        return $this->save(false);
    }
    public function getDate()
    {
        return Yii::$app->formatter->asDate($this->created_at, 'long');
    }
}
