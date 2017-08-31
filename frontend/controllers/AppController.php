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

}
