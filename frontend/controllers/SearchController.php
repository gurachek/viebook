<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Review;

class SearchController extends Controller
{
  public function actionIndex($q = null)
  {
    if ($q == null || empty($q) || !is_string($q)) return $this->render('no-query');

    $reviews = Review::find()->where(['like', 'text', $q])->orWhere(['like', 'title', $q])->asArray()->all();

    return $this->render('index', [
      'reviews' => $reviews,
      'q' => $q,
    ]);
  }

  public function actionTag($id = null)
  {
  	if ($id == null || $id == false) {
  		return $this->redirect(['app/index']);
  	}

  	return $this->render('tag', [

  	]);
  }
}
