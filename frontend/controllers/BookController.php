<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Book;
use frontend\models\AddbookModel;
use yii\web\UploadedFile;
use frontend\models\Author;

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

  public function actionAdd()
  {

    if (Yii::$app->user->isGuest) {
        return $this->redirect(['site/login', 'a' => 'add_book']);
    }

    $model = new AddbookModel();

    if ($model->load(Yii::$app->request->post())) {
        
        $model->image = UploadedFile::getInstance($model, 'image');
        
        if ($model->add()) {
            Yii::$app->session->setFlash('success_book_add', 'Книга добавлена');
        }
    }

    $allAuthors = Author::find()->all();
    $authorsFullName = [];

    foreach ($allAuthors as $singleAuthor) {
       $authorsFullName[] = $singleAuthor->getFullname();
     } 


    return $this->render('add', [
        'model' => $model,
        'authors' => $authorsFullName
    ]);
  }
}
