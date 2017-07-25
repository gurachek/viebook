<?php

namespace frontend\models;

use Yii;
use common\models\User;
use yii\base\Model;

class ResetPasswordRequestForm extends Model
{
	public $email;

	public function rules()
	{
		return [
			['email', 'required', 'message' => 'Это обязательное поле'],
			['email', 'email'],
			['email', 'string'],
			['email', 'trim'],
		];
	}

	public function createResetToken()
	{
		if ($user = User::findByEmail($this->email)) {
			$user->generatePasswordResetToken();	
			if ($user->save()) {
				$link = Yii::$app->getUrlManager()->createAbsoluteUrl(['user/reset-password', 'code' => $user->getPasswordResetToken()]);
				$this->sendMail($link);
				return true;
			}
		}

		return false;		
	}

	private function sendMail($link)
    {
        Yii::$app->mail->compose(['html' => 'userResetPassword-html'], ['link' => $link])
            ->setFrom(['no-reply@viebook.ru' => 'Viebook'])
            ->setTo($this->email)
            ->setSubject('Восстановление пароля')
            ->send();
    }
}