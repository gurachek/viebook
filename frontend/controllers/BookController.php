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
use yii\helpers\Json;
use yii\validators\Validator;
use common\models\UserEstimates;

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

      /* Review rating 
          1. like + dislike = sum
          2. like / sum = sum2
          3. sum2 * 100 = rating
      */

      // Need to place it in cron tasks
      foreach($book->reviews as $review) {
        if ($estimates = $review->estimates) {
          $positive = $review->estimates[0]->numberOfPositive(); 
          $negative = $review->estimates[0]->numberOfNegative();

          $sum = $positive + $negative;
          $sum2 = $positive / $sum;
          $rating = $sum2 * 100;

          $review->rating = $rating; 
          $review->save();
        }
      }

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

  public function actionAjax()
  {
    if (Yii::$app->request->isAjax) {
      $data = Yii::$app->request->get();

      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

      $allAuthors = Author::find()->all();
      $authorsFullName = [];

      foreach ($allAuthors as $singleAuthor) {
         if (strpos($singleAuthor['name'], $data['term']) !== false) {
           $authorsFullName[] = $singleAuthor['name'];
         }
       }

       return $authorsFullName;

    }
  }

  public function actionLevel($id = null, $catid = null)
  {

    $validator = new Validator();
    
    $integer = new Validator::$builtInValidators['integer']['class'];

    if (!$integer->validate($id) && !$integer->validate($catid)) {
      return $this->render('level-no-params');
    }

    $level = BookLevel::getById($id);
    $category = Category::getById($catid);

    $bookQuery = [];

    if ($id != null && $integer->validate($id)) {
      if ($catid != null && $integer->validate($id)) {
        $bookQuery['category'] = $catid;
      }
        
      $bookQuery['level_id'] = $id;

    } else {
      if ($catid != null && $integer->validate($catid)) {
        return $this->redirect(['category/index', 'id' => $catid]);
      }
    }

    $books = Book::find()->where($bookQuery)->all();

    return $this->render('level', [
      'books' => $books,
      'level' => $level,
      'category' => $category,
    ]);
  }
}
