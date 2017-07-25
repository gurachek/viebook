<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class UserConfirmation extends ActiveRecord
{
	public static function tableName()
	{
		return 'user_confirmation';
	}
}