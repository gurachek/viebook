<?php 

namespace frontend\models;

use Yii;
use yii\base\Model;

class ResetPasswordForm extends Model
{
	public $password;
	public $passwordRepeat;

	public function rules()
	{
		return [
			['password', 'required', 'message' => 'Это обязятельно'],
			['password', 'string', 'min' => 6],
			['passwordRepeat', 'required', 'message' => 'Подтвердите пароль'],
			[['password', 'passwordRepeat'], 'trim'],
			['passwordRepeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают'],
			['password', 'compare', 'compareAttribute' => 'passwordRepeat', 'message' => 'Пароли не совпадают'],
		];
	}

	public function setNewPassword($user)
	{
		$user->setPassword($this->password);
		$user->removePasswordResetToken();
	
		return $user->save() ? true : false;
	}
}