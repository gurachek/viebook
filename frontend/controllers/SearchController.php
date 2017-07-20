<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Review;
use frontend\models\UserInterested;
use frontend\models\Tag;
use frontend\models\BookTags;
use frontend\models\Book;

class SearchController extends Controller
{
  public function actionIndex($q = null)
  {
    if ($q == null || empty($q) || !is_string($q)) return $this->render('no-query');

    $reviews = Review::find()->where(['like', 'text', $q])->orWhere(['like', 'title', $q])->asArray()->all();

    return $this->render('index', [
      'reviews' => $reviews,
      'q' => $q,
    ]);
  }

  public function actionTag($id = null)
  {
  	if ($id == null || $id == false) {
  		return $this->redirect(['app/index']);
  	}

    $books = null;

    if ($tag = Tag::findOne(['id' => $id])) {
      if ($bookTags = BookTags::find()->where(['tag_id' => $tag->id])->asArray()->all()) {
        $books_id = array_column($bookTags, 'book_id');

        $books = Book::find()->where(['id' => $books_id])->all();
      }
    }

  	return $this->render('tag', [
      'tag' => $tag,
      'books' => $books
  	]);
  }
}
