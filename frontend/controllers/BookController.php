<?php

namespace frontend\controllers;

use Yii;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\Response;
use frontend\models\AddbookModel;
use frontend\models\BooksVisit;
use frontend\models\Author;
use frontend\models\Book;
use frontend\models\Tag;
use frontend\models\Category;
use yii\helpers\ArrayHelper;
use frontend\models\BookLevel;

class BookController extends Controller
{
  public function actionIndex($id = null)
  {
    return $this->redirect(['book/list']);

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

    if (!Yii::$app->user->identity->isActive()) {
      return $this->render('unconfirmed');
    }

    $model = new AddbookModel();

    if ($model->load(Yii::$app->request->post())) {
        
        $model->image = UploadedFile::getInstance($model, 'image');
        
        if ($model->add()) {
            Yii::$app->session->setFlash('success_book_add', 'Книга добавлена');
        } else {
            Yii::$app->session->setFlash('failure_book_add', 'Не получилось добавить книгу. Возможно, эта книга уже есть на сайте.');
        }
    }

    $allAuthors = Author::find()->all();
    $authorsFullName = [];

    foreach ($allAuthors as $singleAuthor) {
       $authorsFullName[] = $singleAuthor['name'];
     } 

     $tags = Tag::find()->asArray()->all();
     $tags = array_column($tags, 'name');

     $category = Category::find()->all();
     $categoryList = [];

     foreach ($category as $single) {
       $categoryList[$single['id']] = $single['name'];
     }

     $bookLevels = BookLevel::find()->all();
     $bookLevelsList =  ArrayHelper::map($bookLevels, 'id', 'name');

     return $this->render('add', [
         'model' => $model,
         'authors' => $authorsFullName,
         'tags' => $tags,
         'categoryList' => $categoryList,
         'bookLevelsList' => $bookLevelsList, 
     ]);
  }

  public function actionList() 
  {
    $books = Book::find()->all();
    return $this->render('list', [
      'books' => $books,
    ]);
  }

  public function actionTags()
  {
    Yii::$app->response->format = Response::FORMAT_JSON;
    
    $tags = Tag::find()->asArray()->all();
    $return = [];

    foreach ($tags as $tag) {
      $return[]['name'] = $tag['name'];
    }

    return $return;
  }

  public function actionVisit()
  {
    if (Yii::$app->request->isAjax) {
      if ($userId = Yii::$app->user->getId()) {
        $data = Yii::$app->request->get();
        $bookId = $data['bookId'];

        $visit = new BooksVisit();
        $visit->user_id = $userId;
        $visit->book_id = $bookId;
        $visit->time = time();

        $visit->save();
      }
    }

  }
}
