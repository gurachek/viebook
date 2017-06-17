<?php
/**
 * Created by PhpStorm.
 * User: gallant
 * Date: 3/26/17
 * Time: 9:59 PM
 */

namespace frontend\models;

use yii\db\ActiveRecord;
use frontend\models\Book;

class Category extends ActiveRecord
{
    public static function tableName()
    {
        return 'categories';
    }

    public function getBooks()
    {
        return $this->hasMany(Book::className(), ['book_id' => 'id']);
    }
}
