<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class Topic extends ActiveRecord
{
	public static function tableName()
	{
		return 'topics';
	}
}