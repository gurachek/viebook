<?php
/**
 * Created by PhpStorm.
 * User: gallant
 * Date: 3/26/17
 * Time: 9:59 PM
 */

namespace frontend\models;

use yii\db\ActiveRecord;

class Author extends ActiveRecord
{
    public static function tableName()
    {
        return 'authors';
    }
}