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
use frontend\models\Topic;

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

        $pastMonthTime = strtotime("-1 month");
        $currentTime = time();

        $duringMonthReviews = Review::find()->where(['between', 'created_at', $pastMonthTime, $currentTime])->where(['active' => 1])->orderBy('rating ASC')->all();

        $weeklyReviews = [];
        
        if ($duringMonthReviews != null) {

            $averageRating = 0;

            foreach($duringMonthReviews as $review) {
                $averageRating += $review->rating;
            }

            $averageRating /= count($duringMonthReviews);

            foreach($duringMonthReviews as $review) {
                if ($review->rating >= $averageRating) {
                    $weeklyReviews[] = $review;
                }
            }

        }

        return $this->render('index', [
            'model' => $model,
            'search_results' => $search_results,
            'books' => $booksName,
            'weeklyReviews' => $weeklyReviews,
            'search_query' => $search_query,
        ]);
    }

    /*
        Function used once when I needed to send emails ;) 
    */
    public function actionEmailDelivery($done = 0)
    {

        // $emails = Email::find()->asArray()->all();
        // $users = User::find()->where(['status' => User::STATUS_ACTIVE, 'active' => 1])->asArray()->all();

        // $emailsList = array_column($emails, 'email');
        // $usersEmailList = array_column($users, 'email');

        // $common = array_merge($emailsList, $usersEmailList);

        // $finalEmailsBase = array_unique($common);

        // if ($done != 0) {
        //     $finalEmailsBase = array_slice($finalEmailsBase, $done);
        // }

        $email = "webcrash091@gmail.com";

        // foreach ($finalEmailsBase as $email) {
            if (
            Yii::$app->mail->compose(['html' => 'weeklyMailDelivery-html'])
            ->setFrom(['no-reply@viebook.ru' => 'Viebook'])
            ->setTo($email)
            ->setSubject('Программисты не читают книги, должны ли вы?')
            ->send()) {

            echo "Email send to: ". $email ." <br>";
            }
        // }

    }

    public function actionFindBook()
    {
        $model = new SearchModel();

        return $this->renderAjax('_find_book', [
            'model' => $model,
        ]);
    }

}
