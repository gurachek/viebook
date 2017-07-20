<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Review;
use frontend\models\Category;
use yii\helpers\Json;
use common\models\UserEstimates;
use common\models\WriteReviewModel;
use frontend\models\Book;
use frontend\models\EditReviewModel;
use common\models\User;
use frontend\models\ReviewTrack;

class ReviewController extends Controller
{

    public function beforeAction($action)
    {
        return true;
    }

    public function actionIndex($id = null)
    {
        if ($id !== null) return Yii::$app->runAction('review/view', ['id' => $id]);

        return $this->redirect(['book/index']);

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

            $user_estimate = UserEstimates::findOne(['user_id' => $data['userId'], 'entry_id' => $data['reviewId']]);

            if ($user_estimate === null) {

                $review = Review::findOne(['id' => $data['reviewId']]);

                if ($data['estimate']) {

                    $review->rating += 10;
                    Yii::$app->user->identity->increaseRating(2);

                } else {

                    $review->rating -= 5;
                    Yii::$app->user->identity->reduceRating(1);
                }

                $estimate = new UserEstimates();
                $estimate->user_id = $data['userId'];
                $estimate->entry_id = $data['reviewId'];
                $estimate->estimate = $data['estimate'];
                $estimate->time = time();

                if ($estimate->save() && $review->save()) {
                    return true;
                }
            }

        }

        return false;
    }

    public function actionWrite($bookid = null)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login', 'a' => 'write_review', 'id' => $bookid]);
        }

        if ($bookid === null || $bookid == false) {
            return $this->render('write_instructions');
        }

        if ($checkReview = ReviewTrack::findOne(['user_id' => Yii::$app->user->getId(), 'book_id' => $bookid])) {
            return $this->redirect(['review/edit', 'id' => $checkReview->book_id]);
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

    public function actionEdit($id = null)
    {

        $book = Book::findOne(['id' => intval($id)]);
        $model = new EditReviewModel();

        if (!$checkReview = ReviewTrack::findOne(['user_id' => Yii::$app->user->getId(), 'book_id' => $id])) {
            return $this->redirect(['review/write', 'bookid' => $id]);
        } else {
            $review = Review::findOne(['id' => $checkReview->review_id]);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->edit())
                Yii::$app->session->setFlash('success_edit_review', 'Рецензия отредактирована');
            else
                Yii::$app->session->setFlash('failure_edit_review', 'Не удалось редактировать рецензию');
        }

        return $this->render('edit', [
            'model' => $model,
            'book' => $book,
            'review' => $review,
        ]);
    }

    public function actionDelete($id = null, $sure = null)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login', 'a' => 'delete_review', 'id' => $id]);
        }

        if ($id === null || $id === false) {
            return $this->render('no-reviewid');
        }

        if ($review = Review::findOne(['book_id' => $id, 'user_id' => Yii::$app->user->getId()])) {
            if ($sure && $sure == '1') {
                
                if ($reviewTrack = ReviewTrack::findOne(['user_id' => Yii::$app->user->getId(), 'review_id' => $review->id])) {
                    $reviewTrack->delete();
                }

                UserEstimates::deleteAll(['entry_id' => $review->id]);

                $review->delete();

                return $this->render('deleted');
            }
        } else {
           return $this->render('u_havnt_review', ['id' => $id]);
        }

        return $this->render('delete', [
            'id' => $id,
        ]);
    }

}
