<?php
/**
 * Created by PhpStorm.
 * User: gallant
 * Date: 3/26/17
 * Time: 9:59 PM
 */

namespace frontend\models;

use yii\db\ActiveRecord;
use frontend\models\AuthorTrack;
use frontend\models\Book;

class Author extends ActiveRecord
{
    public static function tableName()
    {
        return 'authors';
    }

    public static function getUserAuthors($userId, $limit = null)
    {
		$authors = AuthorTrack::find()->where(['user_id' => $userId])->asArray()->all();
		$authorsId = array_column($authors, 'author_id');
		$data = static::find()->where(['id' => $authorsId])->limit($limit)->asArray()->all();

		return $data;
    }

    public function getBooks()
    {
        return $this->hasMany(Book::className(), ['author_id' => 'id']);
    }
}