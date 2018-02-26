<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\models\Review;

class EditReviewModel extends Model
{
	public $title;
	public $text;
	public $preview;
	public $reviewid;

	public function rules()
	{
		return [
			['title', 'required', 'message' => 'Нельзя оставить это поле пустым'],
			['text', 'required', 'message' => 'Рецензия не может быть пустой. Зайдите в личный кабинет, если хотите удалить рецензию'],
			['preview', 'required', 'message' => 'Это поле не может быть пустым'],
			['reviewid', 'required'],
		];
	}

	public function edit()
	{
		$review = Review::findOne(['id' => $this->reviewid]);

		$review->title = $this->title;
		$review->preview = $this->preview;
		$review->text = $this->text;
		$review->active = 0;

		if (Yii::$app->user->identity->verified)
			$review->active = 1;

		if ($review->save()) {
			return true;
		}

		return false;
	}
}