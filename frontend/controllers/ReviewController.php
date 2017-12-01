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
use frontend\models\BookLevel;

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

        $review = Review::findOne(['id' => $id, 'active' => 1]);

        if ($review == null) return $this->render('no-review');

        $level = BookLevel::getById($review->book->level);

        return $this->render('view', [
            'review' => $review,
            'level' => $level,
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
            
            if (!Yii::$app->user->getId()) return false;

            $data = Yii::$app->request->post();

            $user_estimate = UserEstimates::findOne(['user_id' => $data['userId'], 'entry_id' => $data['reviewId']]);

            if ($user_estimate === null) {

                $review = Review::findOne(['id' => $data['reviewId']]);

                if ($data['estimate']) {

                    $review->rating += 5;

                } else {

                    $review->rating -= 10;
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

        if (!Yii::$app->user->identity->isActive()) {
            return $this->render('unconfirmed');
        }

        if ($checkReview = ReviewTrack::findOne(['user_id' => Yii::$app->user->getId(), 'book_id' => $bookid])) {
            return $this->redirect(['review/edit', 'id' => $checkReview->book_id]);
        }

        $book = Book::findOne(['id' => intval($bookid)]);
        $model = new WritereviewModel;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save())
                Yii::$app->session->setFlash('success_review_post', 'Рецензия отправлена на модерацию. Спасибо за помощь в развитии сайта!');
            else
                Yii::$app->session->setFlash('failure_review_post', 'Что-то пошло не так :(');
        }

        if ($bookid === null || $bookid == false) {
            return $this->redirect(['search/write']);
            //
            return $this->render('write_instructions', [
                'model' => $model,
            ]);
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
            if ($model->edit()) {
                Yii::$app->session->setFlash('success_edit_review', 'Рецензия отредактирована и отправлена на модерацию');
                $review = Review::findOne(['id' => $checkReview->review_id]);
            }
            else {
                Yii::$app->session->setFlash('failure_edit_review', 'Не удалось редактировать рецензию');
            }
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
                    Yii::$app->user->identity->reduceRating(10);
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

    public function actionAjaxView()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->get();
            $reviewId = $data['reviewId'];

            if ($review = Review::findOne(['id' => $reviewId])) {
                $review->updateCounters(['views' => '1']);
                $review->save();
            }
        }
    }

    public function actionWriteAjax()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->get();

            return Json::encode($data);
        }
    }

}
