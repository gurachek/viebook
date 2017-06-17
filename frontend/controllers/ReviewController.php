<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Review;
use frontend\models\Category;
use yii\helpers\Json;

class ReviewController extends Controller
{

    public function beforeAction($action)
    {
        return true;
    }

    public function actionIndex($id = null)
    {
        if ($id !== null) return Yii::$app->runAction('review/view', ['id' => $id]);

        $reviews = Review::find()->where(['active' => '1'])
            ->where(['shedule_date' => null])
            ->orderBy('rating DESC')
            ->asArray()
            ->all();

        $category = Category::find()->all();

        return $this->render('index', [
            'reviews' => $reviews,
            'category' => $category,
        ]);
    }

    public function actionAjax($id = null)
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->get();
            $review_id = $data['review_id'];

            $review = Review::find()->where(['id' => $review_id])->asArray()->one();

            return Json::encode($review);
        }

        // if ($id == null || empty($id)) return $this->render('no-reviewid');
        //
        // $review = Review::findOne(['id' => $id]);
        //
        // if ($review == null) return $this->render('no-review');
        //
        // return $this->render('view', [
        //     'review' => $review,
        // ]);
    }

}
