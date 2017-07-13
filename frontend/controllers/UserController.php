<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;

class UserController extends Controller
{

  // user account
  public function actionIndex()
  {
      if (Yii::$app->user->isGuest) {
        return $this->redirect(['site/login']);
      }

      $userId = Yii::$app->user->getId();

      $user = User::find()->where(['id' => $userId])->asArray()->one();

      return $this->render('index', [
          'user' => $user,
      ]);
  }

  public function actionView($id = null)
  {
      if ($id == null || empty($id)) return $this->render('no-userid');

      $user = User::findOne(['id' => $id]);

      if ($user == null) return $this->render('no-user');

      return $this->render('view', [
          'user' => $user
      ]);
  }

}
