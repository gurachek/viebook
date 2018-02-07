<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class ActionTrack extends ActiveRecord 
{
	public static function tableName()
	{
		return 'action_track';
	}
}