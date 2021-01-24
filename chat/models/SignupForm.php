<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{

    public $username;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required', 'message' => 'Заполните поле'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Уже существует'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required', 'message' => 'Заполните поле'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Уже существует'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }
    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'email' => 'Электронная почта',
            'password' => 'Пароль',
        ];
    }


    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        $auth = Yii::$app->security->generateRandomString();
        Yii::$app
            ->mailer
            ->compose(
                ['html' => 'letterForAdmin-html', 'text' => 'letterForAdmin-text'],
                ['user' => $this->username, 'auth' =>$auth]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Подтверждение email')
            ->send();

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->status = User::STATUS_DELETED;
        $user->setPassword($this->password);
        $user->auth_key = $auth;
        $user->save();

        if ($user)
           {

                $auth = Yii::$app->authManager;
                $editor = $auth->getRole('editor'); // Получаем роль editor
                $auth->assign($editor, $user->id); // Назначаем пользователю, которому принадлежит модель User
                return $user;

           }
        return null;
    }

}