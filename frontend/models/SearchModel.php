<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\models\Book;
use frontend\models\SearchHistory;

class SearchModel extends Model
{
    public $search;

    public function rules()
    {
        return[
            ['search', 'required', 'message' => 'Нужно что-то ввести. Например, Лолита']
        ];
    }


    private function saveSearchQuery()
    {
        $searchHistory = new SearchHistory();

        $searchHistory->user_id = @Yii::$app->user->getId() ?? 0;
        $searchHistory->query = htmlspecialchars($this->search);
        $searchHistory->time = time();

        $searchHistory->save();
    }

    public function search_book()
    {

        $this->saveSearchQuery();

        $book = Book::find()->where(['like', 'name', $this->search])->all();

        return $book;
    }

}
