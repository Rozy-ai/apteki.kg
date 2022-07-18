<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class RegisterForm extends Model
{
    public $name;
    public $email;
    public $password;
    public $password_repeat;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['name', 'email', 'password', 'password_repeat'], 'required'],
            ['email', 'email'],
            [['name'], 'string', 'max' => 255],
            ['password_repeat', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if ($this->password != $this->password_repeat) {
                $this->addError($attribute, 'Пароли не совпадают');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function register()
    {
        if ($this->validate()) {
            $user = new Users([
              "name" => $this->name,
              "email" => $this->email,
              "password" => Yii::$app->getSecurity()->generatePasswordHash($this->password),
              "token" => Yii::$app->getSecurity()->generateRandomString()]);

            if(!$user->save()) return false;
            return Yii::$app->user->login($user, 3600*24*30);
        }
        return false;
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'email' => 'Электронная почта',
            'password' => 'Пароль',
            'password_repeat' => 'Пароль (еще раз)',
        ];
    }
}
