<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Author;

class AuthorController extends Controller
{
  public function actionIndex($id = null)
  {
      if ($id !== null) return Yii::$app->runAction('author/view', ['id' => $id]);

      $authors = Author::find()->all();

      return $this->render('index', [
          'authors' => $authors,
      ]);
  }

  public function actionView($id = null)
  {
      if ($id == null || empty($id)) return $this->render('no-authorid');

      $author = Author::findOne(['id' => $id]);

      if ($author == null) return $this->render('no-author');

      return $this->render('view', [
          'author' => $author,
      ]);
  }
}
