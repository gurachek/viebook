<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class UserInterested extends ActiveRecord
{
	public static function tableName()
	{
		return 'user_interested';
	}
}