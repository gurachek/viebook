<?php

namespace frontend\models;

use yii\base\Model;
use frontend\models\Book;

class SearchModel extends Model
{
    public $search;

    public function rules()
    {
        return[
            ['search', 'required'],
        ];
    }

    public function search_book()
    {
        $book = Book::find()->where(['like', 'name', $this->search])->all();

        return $book;
    }

}
