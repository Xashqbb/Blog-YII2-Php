<?php

namespace app\models;

use yii\base\Model;
use app\models\User;


class SignupForm extends Model
{
    public $name;
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['name', 'email', 'password'], 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::class, 'targetAttribute' => 'email', 'message' => 'This email is already registered. Please use a different one.'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->name = $this->name;
            $user->email = $this->email;
            $user->password = \Yii::$app->getSecurity()->generatePasswordHash($this->password);
            if ($user->save()) {
                return true;
            } else {
                $this->addErrors($user->errors);
            }
        }
        return false;
    }
}

