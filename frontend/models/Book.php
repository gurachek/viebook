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

class Book extends ActiveRecord
{
    public static function tableName()
    {
        return 'books';
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
        return $this->hasMany(Review::className(), ['book_id' => 'id']);
    }
}
