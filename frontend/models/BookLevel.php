<?php 

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class BookLevel extends ActiveRecord 
{
	public static function tableName()
	{
		return 'book_levels';
	}

	public static function getById($id)
	{
		if (!$id) return null;

		return static::findOne(['id' => $id]);
	}
}