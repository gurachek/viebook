<?php
/**
 * Created by PhpStorm.
 * User: gallant
 * Date: 7/10/17
 * Time: 4:03 PM
 */

namespace frontend\models;


use yii\db\ActiveRecord;
use frontend\models\Tag;

class BookTags extends ActiveRecord
{
	public static function tableName()
	{
		return 'book_tags';
	}

	public function getName()
	{
		return $this->hasMany(Tag::className(), ['id' => 'tag_id']);
	}
}