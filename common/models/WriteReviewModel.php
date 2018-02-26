<?php

namespace common\models;

use Yii;
use yii\base\Model;
use frontend\models\Review;
use frontend\models\Analytics;
use frontend\models\ReviewTrack;

class WritereviewModel extends Model
{
    public $title;
    public $bookid;
    public $text;
    public $preview;
    public $userid;

    public function rules()
    {
    	return [
    		['title', 'required', 'message' => 'Вы должны ввести заголовок'],
            ['title', 'unique', 'targetClass' => 'frontend\models\Review', 'message' => 'На сайте уже существует рецензия с таким заголовком. Выберите другой'],
            ['text', 'required', 'message' => 'Рецензия без текста?'],
    		['preview', 'required', 'message' => 'Это поле не может быть пустым'],
    		[['bookid', 'userid'], 'required']
    	];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Введите заголовок',
            'text' => 'Здесь текст рецензии',
            'preview' => 'Краткое описание рецензии',
        ];
    }

    public function save()
    {
    	$review = new Review();
    	$review->title = $this->title;
    	$review->user_id = $this->userid;
    	$review->created_at = time();
        $review->active = 0;

        if (Yii::$app->user->identity->verified)
            $review->active = 1;
        
        $review->book_id = $this->bookid;
        $review->preview = $this->preview;
    	$review->text = $this->text;

        if ($review->save()) {
            $reviewTrack = new ReviewTrack();

            $reviewTrack->user_id = $this->userid;
            $reviewTrack->book_id = $this->bookid;
            $reviewTrack->review_id = $review->id;
            $reviewTrack->time = time();

            $reviewTrack->save();

            Yii::$app->user->identity->increaseRating(80);

            return true;
        }

    	return false;
    }
}
