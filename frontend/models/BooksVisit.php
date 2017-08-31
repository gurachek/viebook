<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class BooksVisit extends ActiveRecord
{
	public static function tableName()
	{
		return 'books_visit';
	}
}