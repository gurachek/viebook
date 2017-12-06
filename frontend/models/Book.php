<?php
/**
 * Created by PhpStorm.
 * User: gallant
 * Date: 3/26/17
 * Time: 9:59 PM
 */

namespace frontend\models;

use yii\db\ActiveRecord;
use frontend\models\Category;
use frontend\models\Author;
use frontend\models\Review;
use frontend\models\BookTags;
use frontend\models\BookTrack;
use frontend\models\BookLevel;

class Book extends ActiveRecord
{

    public function getAuthorIdByName($name)
    {

        $author = Author::find()->where(['name' => $name])->asArray()->one();

        return $author['id'];
    }

    public static function tableName()
    {
        return 'books';
    }

    public function getTags()
    {
        return $this->hasMany(BookTags::className(), ['book_id' => 'id' ]);
    }

    public function getCat()
    {
        return $this->hasOne(Category::className(), ['id' => 'category']);
    }

    public function getAuthor()
    {
        return $this->hasOne(Author::className(), ['id' => 'author_id']);
    }

    public function getReviews()
    {
        return $this->hasMany(Review::className(), ['book_id' => 'id'])->orderBy('rating DESC')->where(['active' => 1]);
    }

    public static function getUserBooks($userId, $limit = null) 
    {

        $books = BookTrack::find()->where(['user_id' => $userId])->asArray()->all();
        $booksId = array_column($books, 'book_id');
        $data = static::find()->where(['id' => $booksId])->limit($limit)->asArray()->all();

        return $data;
    }

    public function getLevel()
    {
        return $this->hasOne(BookLevel::className(), ['id' => 'level_id']);
    }

}
