<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;

class UserController extends Controller
{
  public function actionIndex($id = null)
  {
      if ($id !== null) return Yii::$app->runAction('user/view', ['id' => $id]);

      $users = User::find()->all();

      return $this->render('index', [
          'users' => $users,
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
