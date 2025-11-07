<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required'],
            [['username'], 'string', 'min' => 2, 'max' => 15],
            [['email'], 'email'],
            [['email'], 'unique', 'targetClass' => User::class],
            [['username'], 'unique', 'targetClass' => User::class],
            [['password'], 'string', 'min' => 6],
        ];
    }

    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->password = $this->password;
        $user->created_at = time();
        $user->updated_at = time();

        return $user->save();
    }
}