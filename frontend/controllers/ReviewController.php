<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Review;
use frontend\models\Category;
use yii\helpers\Json;
use common\models\User_estimates;
use common\models\WritereviewModel;
use frontend\models\Book;

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

    public function actionView($id = null)
    {
        if ($id == null || empty($id)) return $this->render('no-reviewid');

        $review = Review::findOne(['id' => $id]);

        if ($review == null) return $this->render('no-review');

        return $this->render('view', [
            'review' => $review,
        ]);
    }

    public function actionAjax()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->get();
            $review_id = $data['review_id'];

            $review = Review::find()->where(['id' => $review_id])->asArray()->one();

            return Json::encode($review);
        }

        return false;
    }

    public function actionEstimate()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();

            $user_estimate = User_estimates::findOne(['user_id' => $data['userId'], 'entry_id' => $data['reviewId']]);

            if ($user_estimate === null) {

                $review = Review::findOne(['id' => $data['reviewId']]);

                if ($data['estimate']) {

                    $review->rating += 1;

                } else {

                    $review->rating -= 1;

                }

                $estimate = new User_estimates();
                $estimate->user_id = $data['userId'];
                $estimate->entry_id = $data['reviewId'];
                $estimate->estimate = $data['estimate'];

                if ($estimate->save() && $review->save()) {
                    return true;
                }
            }

        }

        return false;
    }

    public function actionWrite($bookid = null)
    {

        if(!Yii::$app->user->getId()) {
            return $this->render('write_need_login', [
                'bookid' => $bookid,
            ]);
        }

        if ($bookid === null || $bookid === false) {
            return $this->render('write_instructions');
        }

        $book = Book::findOne(['id' => intval($bookid)]);
        $model = new WritereviewModel;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save())
                Yii::$app->session->setFlash('success_review_post', 'Рецензия добавлена на сайт');
            else
                Yii::$app->session->setFlash('failure_review_post', 'Что-то пошло не так');
        }

        return $this->render('write', [
            'model' => $model,
            'book' => $book,
        ]);
    }

}
