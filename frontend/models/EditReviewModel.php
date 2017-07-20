<?php

namespace frontend\models;

use yii\base\Model;
use frontend\models\Review;

class EditReviewModel extends Model
{
	public $title;
	public $text;
	public $reviewid;

	public function rules()
	{
		return [
			['title', 'required', 'message' => 'Нельзя оставить это поле пустым'],
			['text', 'required', 'message' => 'Рецензия не может быть пустой. Зайдите в личный кабинет, если хотите удалить рецензию'],
			['reviewid', 'required'],
		];
	}

	public function edit()
	{
		$review = Review::findOne(['id' => $this->reviewid]);

		$review->title = htmlspecialchars($this->title);
		$review->text = htmlspecialchars($this->text);

		if ($review->save()) {
			return true;
		}

		return false;
	}
}