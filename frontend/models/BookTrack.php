<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class BookTrack extends ActiveRecord
{
	public static function tableName()
	{
		return 'book_track';
	}
}