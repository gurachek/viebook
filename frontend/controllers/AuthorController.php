<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Author;
use frontend\models\AddAuthorModel;
use yii\web\UploadedFile;

class AuthorController extends Controller
{
  public function actionIndex($id = null)
  {
    return $this->redirect(['author/list']);
      
    /*
      if ($id !== null) return Yii::$app->runAction('author/view', ['id' => $id]);

      $authors = Author::find()->all();

      return $this->render('index', [
          'authors' => $authors,
      ]);
    */
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

  public function actionAdd()
  {
    if (Yii::$app->user->isGuest) {
        return $this->redirect(['site/login', 'a' => 'add_author']);
    }

    if (!Yii::$app->user->identity->isActive()) {
      return $this->render('unconfirmed');
    }

    $model = new AddAuthorModel();

    if ($model->load(Yii::$app->request->post())) {

      $model->image = UploadedFile::getInstance($model, 'image');

      if ($model->add()) {
        Yii::$app->session->setFlash('success_author_add', 'Автор добавлен на сайт. Спасибо за помощь');
      } else {
        Yii::$app->session->setFlash('failure_author_add', 'Не получилось добавить автора. Возможно, он уже есть.');
      }

    }

    return $this->render('add', [
      'model' => $model,
    ]);
  }


  public function actionList()
  {
    $authors = Author::find()->all();

    return $this->render('list', [
      'authors' => $authors
    ]);
  }
}
