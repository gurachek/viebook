<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;
use frontend\models\BookTrack;
use frontend\models\AuthorTrack;
use frontend\models\ReviewTrack;
use frontend\models\Book;
use frontend\models\Author;
use frontend\models\UserSettingsModel;
use yii\web\UploadedFile;
use frontend\models\UserConfirmation;

class UserController extends Controller
{

  // user account
  public function actionIndex($content = 'reviews')
  {
      if (Yii::$app->user->isGuest) {
        return $this->redirect(['site/login']);
      }

      $userId = Yii::$app->user->getId();

      $user = User::find()->where(['id' => $userId])->one();

      $data = null;

      switch($content) {
        case 'books':
          $books = BookTrack::find()->where(['user_id' => Yii::$app->user->getId()])->asArray()->all();
          $booksId = array_column($books, 'book_id');
          $data = Book::find()->where(['id' => $booksId])->asArray()->all();
          break;

        case 'authors':
          $authors = AuthorTrack::find()->where(['user_id' => Yii::$app->user->getId()])->asArray()->all();
          $authorsId = array_column($authors, 'author_id');
          $data = Author::find()->where(['id' => $authorsId])->asArray()->all();
          break;

        case 'settings':
          $data = new UserSettingsModel();
          break;

        default:
          $data = $user;
          $content = 'reviews';
          break;
      }

      if ($data instanceof \yii\base\Model) {
        if ($data->load(Yii::$app->request->post())) {

          $data->image = UploadedFile::getInstance($data, 'image');

          if ($data->save()) {
            return $this->redirect(['user/index']);
          }
        }
      }

      return $this->render('index', [
          'user' => $user,
          'content' => $content,
          'data' => $data,
      ]);
  }

  public function actionView($id = null)
  {
      if ($id == Yii::$app->user->getId()) {
        return $this->redirect(['user/index']);
      }

      if ($id == null || empty($id)) return $this->render('no-userid');

      $user = User::findOne(['id' => $id]);

      if ($user == null) return $this->render('no-user');

      $booksAdded = BookTrack::find()->where(['user_id' => $user->id])->count();
      $authorsAdded = AuthorTrack::find()->where(['user_id' => $user->id])->count();
      $reviewsWrote = ReviewTrack::find()->where(['user_id' => $user->id])->count();


      return $this->render('view', [
          'user' => $user,
          'booksAdded' => $booksAdded,
          'authorsAdded' => $authorsAdded,
          'reviewsWrote' => $reviewsWrote,
      ]);
  }

  public function actionList()
  {
    $users = User::find()->all();
    return $this->render('list', [
      'users' => $users
    ]);
  }

  public function actionConfirm($code = null)
  {
    if ($code === null || $code == false) {
      return $this->render('no-confirm-code');
    }

    if ($confirm = UserConfirmation::findOne(['code' => $code])) {
      $user = User::findIdentity($confirm->user_id);
      $user->active = 1;
      if ($user->save()) {
        if ($confirm->delete()) {
          return $this->render('confirm');
        }
      }
    }

    return $this->render('invalid-confirm-code');
  }

}
