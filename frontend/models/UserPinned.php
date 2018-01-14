<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class UserPinned extends ActiveRecord 
{
	public static function tableName()
	{
		return 'user_favorites';
	}
}