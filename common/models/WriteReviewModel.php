<?php

namespace common\models;

use yii\base\Model;
use frontend\models\Review;
use frontend\models\Analytics;
use frontend\models\ReviewTrack;

class WritereviewModel extends Model
{
    public $title;
    public $bookid;
    public $text;
    public $userid;

    public function rules()
    {
    	return [
    		['title', 'required', 'message' => 'Вы должны ввести заголовок'],
    		['text', 'required', 'message' => 'Рецензия без текста?'],
    		[['bookid', 'userid'], 'required']
    	];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Введите заголовок',
            'text' => 'Здесь текст рецензии',
        ];
    }

    public function save()
    {
    	$review = new Review();
    	$review->title = htmlspecialchars($this->title);
    	$review->user_id = $this->userid;
    	$review->created_at = time();
    	$review->active = 0;
    	$review->book_id = $this->bookid;
    	$review->text = htmlspecialchars($this->text);

        if ($review->save()) {
            $reviewTrack = new ReviewTrack();

            $reviewTrack->user_id = $this->userid;
            $reviewTrack->book_id = $this->bookid;
            $reviewTrack->review_id = $review->id;
            $reviewTrack->time = time();

            $reviewTrack->save();

            return true;
        }

    	return false;
    }
}
