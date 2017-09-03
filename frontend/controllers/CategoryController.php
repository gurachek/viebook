<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Book;
use frontend\models\Review;
use frontend\models\Category;

class CategoryController extends Controller
{
  public function actionIndex($id = null)
  {
      if ($id == null || empty($id)) return Yii::$app->runAction('review/index');

      $books = Book::find()->where(['category' => $id])->all();

      if ($books == null) return $this->render('no-books');

      return $this->render('index', [
          'books' => $books,
      ]);
  }

}
