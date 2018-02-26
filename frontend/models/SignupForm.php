<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use frontend\models\UserConfirmation;

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
            ['username', 'required', 'message' => 'Это обязательное поле'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required', 'message' => 'Нам нужно знать ваш email'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required', 'message' => 'Это обязательное поле'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->verified = 0;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        if ($user->save()) {
            if ($confirmation = $this->setConfirmCode($user->id)) {
                $link = Yii::$app->getUrlManager()->createAbsoluteUrl(['user/confirm', 'code' => $confirmation->code]);
                $this->sendMail($link);
                return $user;
            }
        }

        return false;
    }

    private function setConfirmCode($userId)
    {
        $confirmation = new UserConfirmation();
        $confirmation->user_id = $userId;
        $confirmation->code = md5($this->email.time());
        $confirmation->time = time();

        return $confirmation->save() ? $confirmation : false;
    }

    private function sendMail($link)
    {
        Yii::$app->mail->compose(['html' => 'userConfirmation-html'], ['link' => $link])
            ->setFrom(['no-reply@viebook.ru' => 'Viebook'])
            ->setTo($this->email)
            ->setSubject('Подтверждение регистрации')
            ->send();
    }
}
