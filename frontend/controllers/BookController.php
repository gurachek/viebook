<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Book;

class BookController extends Controller
{
  public function actionIndex($id = null)
  {
      if ($id !== null) return Yii::$app->runAction('book/view');

      $books = Book::find()->all();

      return $this->render('index', [
          'books' => $books,
      ]);
  }

  public function actionView($id = null)
  {
      if ($id == null || empty($id)) return $this->render('no-bookid');

      $book = Book::findOne(['id' => $id]);

      if ($book == null) return $this->render('no-book');

      return $this->render('view', [
          'book' => $book,
      ]);
  }
}
