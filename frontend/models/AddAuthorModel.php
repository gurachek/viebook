<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use frontend\models\Author;
use frontend\models\AuthorTrack;

class AddAuthorModel extends Model
{
	public $name;
	public $image;

	public function rules()
	{
		return [
			['name', 'required', 'message' => 'Это обязательно'],
			['image', 'required', 'message' => 'Это тоже обязательно'],
			['name', 'unique', 'targetClass' => 'frontend\models\Author', 'message' => 'Этот автор уже есть на сайте'],

			[['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg'],
			[['image'], 'file', 'maxSize' => '5000000'],
			[['image'], 'file', 'maxFiles'=> 1],
		];
	}

	public function add()
	{
		if ($this->validate()) {

			$author = new Author();
			$author->name = $this->name;
			$author->image = time() . '.' . $this->image->extension;

			$author->save();

			$track = new AuthorTrack();
			$track->user_id = Yii::$app->user->getId();
			$track->author_id = $author->id;
			$track->time = time();

			$track->save();

			Yii::$app->user->identity->increaseRating(2);

			$this->image->saveAs(Yii::getAlias('@webroot') . '/images/authors/' . time() . '.' . $this->image->extension);

			return true;
		}

		return false;
	}
}
