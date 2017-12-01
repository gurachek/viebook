<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Review;
use frontend\models\UserInterested;
use frontend\models\Tag;
use frontend\models\BookTags;
use frontend\models\Book;
use frontend\models\SearchModel;

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

  public function actionBooks()
  {

    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    if (Yii::$app->request->isAjax) {

      $data = Yii::$app->request->post();

      if ($data['text']) {

        $return_data = [];

        $book = Book::find()->where(['like', 'name', $data['text']])->one();

        $reviews_count = Review::find()->where(['book_id' => $book->id])->count();
        $book_level = $book->level['name'];
        $category = $book->cat['name'];
        $author = $book->author['name'];

        $return_data['book'] = $book;
        $return_data['reviews_count'] = $reviews_count;
        $return_data['book_level'] = $book_level;
        $return_data['category'] = $category;
        $return_data['author'] = $author;

        return $return_data;
      }
    } 

    return false;
  }

  public function actionWrite()
  {
    $model = new SearchModel();
    $search_results = [];
    $search_query = '';

    if (Yii::$app->request->isAjax) {
      if ($model->load(Yii::$app->request->post())) {
        if ($search_results = $model->search_book()) {
          $search_query = $model->search;
        } else {
          $search_results = 'No books';
        }
      }
    }

    $allBooks = Book::find()->asArray()->all();
    $booksName = [];

    foreach ($allBooks as $singleBook) {
        $booksName[] = [
            'value' => $singleBook['name'],
            'label' => $singleBook['name'],
        ];
    }

    return $this->render('write', [
      'model' => $model,
      'search_results' => $search_results,
      'books' => $booksName,
      'search_query' => $search_query,
    ]);
  }

}
