<?php

namespace common\models;

use yii\db\ActiveRecord;

class UserEstimates extends ActiveRecord
{
	public static function tableName()
	{
		return 'user_estimates';
	}    
}
