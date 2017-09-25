<?php
/**
 * Created by PhpStorm.
 * User: gallant
 * Date: 3/26/17
 * Time: 9:09 PM
 */

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Review;
use frontend\models\SearchModel;
use frontend\models\Book;
use frontend\models\Tag;
use frontend\models\Email;
use common\models\User;

class AppController extends Controller
{
    public function beforeAction($action)
    {
        return true;
    }

    public function actionIndex()
    {
        $model = new SearchModel();
        $search_results = [];
        $search_query = '';

        if (Yii::$app->request->isAjax) {
            if ($model->load(Yii::$app->request->post())) {
                if ($search_results = $model->search_book()) {
                    $search_query = $model->search;
                } else {
                    $search_results = 'No books';
                }
            }
        }

        $allBooks = Book::find()->asArray()->all();
        $booksName = [];

        foreach ($allBooks as $singleBook) {
            $booksName[] = [
                'value' => $singleBook['name'],
                'label' => $singleBook['name'],
            ];
        }

        // Daily Books

        $dailyBooks = Book::find()->with('reviews')->all();
        
        return $this->render('index', [
            'model' => $model,
            'search_results' => $search_results,
            'books' => $booksName,
            'dailyBooks' => $dailyBooks,
            'search_query' => $search_query,
        ]);
    }

    /*
        Algorithm for main page reviews.
        Get all reviews was wrote during the week, calculate average rating and display only reviews where rating >= average rating.
        Save this for days when site will be popular :DD
    */
    public function actionTest()
    {

        $dailyBooks = [];

        $pastWeekTime = strtotime("-1 week");
        $currentTime = time();

        $duringWeekReviews = Review::find()->where(['between', 'created_at', $pastWeekTime, $currentTime])->all();

        $dailyBooks = [];

        $averageRating = 0;

        foreach($duringWeekReviews as $review) {
            $averageRating += $review->rating;
        }

        $averageRating /= count($duringWeekReviews);

        foreach($duringWeekReviews as $review) {
            if ($review->rating >= $averageRating) {
                $dailyBooks[] = $review;
            }
        }

        return $this->render('test', [
            'dailyBooks' => $dailyBooks,
        ]);
    }

    public function actionEmail()
    {

        $emails = Email::find()->asArray()->all();
        $users = User::find()->where(['status' => User::STATUS_ACTIVE, 'active' => 1])->asArray()->all();

        $emailsList = array_column($emails, 'email');
        $usersEmailList = array_column($users, 'email');

        $common = array_merge($emailsList, $usersEmailList);

        $finalEmailsBase = array_unique($common);

        return $this->render('sendEmail', [
            'emails' => $finalEmailsBase,
        ]);
    }

}
