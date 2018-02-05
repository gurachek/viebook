<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class DesignToughts extends ActiveRecord
{
	public static function tableName()
	{
		return 'design_toughts';
	}
}