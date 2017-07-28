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
use common\models\User;
use frontend\models\Analytics;
use common\models\UserEstimates;

class Review extends ActiveRecord
{
    const ACTIVE = 1;
    const MODERATION = 0;

    public static function tableName()
    {
        return 'reviews';
    }

    public function rules()
    {
        return [
            ['active', 'default', 'value' => self::ACTIVE],
            ['active', 'in', 'range' => [self::MODERATION, self::ACTIVE]],
        ];
    }

    public function getBook()
    {
        return $this->hasOne(Book::className(), ['id' => 'book_id']);
    }

    public function getAnalytics()
    {
        return $this->hasMany(Analytics::className(), ['review_id' => 'id']);
    }

    public function getAuthor()
    {
      return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getEstimates()
    {
        return $this->hasMany(UserEstimates::className(), ['entry_id' => 'id']);
    }
}
