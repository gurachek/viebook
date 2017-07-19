<?php
/**
 * Created by PhpStorm.
 * User: gallant
 * Date: 7/10/17
 * Time: 4:03 PM
 */

namespace frontend\models;


use yii\db\ActiveRecord;

class BookTags extends ActiveRecord
{
	public static function tableName()
	{
		return 'book_tags';
	}
}