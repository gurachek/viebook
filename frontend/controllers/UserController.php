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
use frontend\models\ResetPasswordForm;
use frontend\models\UserPinned;
use frontend\models\Review;

class UserController extends Controller
{

  // user account
  public function actionIndex($content = 'index')
  {
      if (Yii::$app->user->isGuest) {
        return $this->redirect(['site/login']);
      }

      $userId = Yii::$app->user->getId();

      $user = User::find()->where(['id' => $userId])->one();

      $data = null;

      $pinned = UserPinned::find()->where(['user_id' => $userId])->asArray()->all();

      $pinnedReviewsArray = array_column($pinned, 'review_id');

      $pinnedReviews = Review::find()->where(['id' => $pinnedReviewsArray])->all();

      switch($content) {

        case 'settings':
          $data = new UserSettingsModel();
          break;

        case 'pinned':
          $data = $pinnedReviews;
          break;

        case 'reviews':
          $data = $user;
          break;

        default:
          $content = 'index';
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

  public function actionResetPassword($code = null)
  {
    if ($code === null || $code == false) {
      return $this->render('no-password-reset-code');
    }
    if ($user = User::findByPasswordResetToken($code)) {
      
      $model = new ResetPasswordForm();
      
      if ($model->load(Yii::$app->request->post())) {
        if ($model->setNewPassword($user)) {
          return $this->render('password-is-set');
        } else {
          return $this->render('password-set-error');
        }
      }

      return $this->render('password-reset', [
        'model' => $model
      ]);    
    }
    
    return $this->render('invalid-reset-code');
  }

  public function actionUnsubsribe($email = null)
  {

    $user = User::findUserByEmail($email);

    if ($email == null or $email == false or $user == false)
      return $this->render('unsubscribe-error');

    if ($user->subscribe == 0)
      return $this->render('already-unsubscribed');

    $user->subscribe = 0;
    $user->save();

    return $this->render('unsubscribe', [

    ]);
  
  }

}
