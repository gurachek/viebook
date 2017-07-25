<?php

namespace frontend\models;

use Yii;
use common\models\User;
use yii\base\Model;

class RestorePasswordForm extends Model
{
	public $email;

	public function rules()
	{
		return [
			['email', 'required', 'message' => ''],
		];
	}
}