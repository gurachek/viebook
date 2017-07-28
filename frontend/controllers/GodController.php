<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Review;

class GodController extends Controller
{
    public function actionReviews()
    {
        $reviews = Review::find()->where(['active' => 0])->orderBy('created_at DESC')->all();

        return $this->render('reviews', [
            'reviews' => $reviews,
        ]);
    }

    public function actionPublish()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();

            $review = Review::findOne(['id' => $data['review_id']]);
            $review->active = 1;
            $review->save();

            return json_encode([
                'success' => true,
                'data' => $data
            ]);
        }

        return false;
    }
}