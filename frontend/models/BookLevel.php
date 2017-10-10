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
}