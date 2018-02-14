<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class SearchHistory extends ActiveRecord
{
	public static function tableName()
	{
		return 'search_history';
	}
}