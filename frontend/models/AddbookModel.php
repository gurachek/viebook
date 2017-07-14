<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class AddbookModel extends Model
{
	public $name;
	public $image;
	public $author;
	public $publish_date;
	public $tags;

	public function rules()
	{
		return [
			['name', 'required', 'message' => 'Люди часто ищут книги по названию. Пожалуйста, не игнорируйте это'],
			['author', 'required', 'message' => 'Нам нужно знать кто автор этой книги'],
			['publish_date', 'required', 'message' => 'Не знаю зачем, но это тоже нам нужно'],
			['tags', 'required', 'message' => 'На основе тагов мы составляем фид-ленту и разделы, введите пожалуйста'],
			['image', 'required', 'message' => 'Вы должны загрузить обложку, чтобы добавить книгу на сайт'],
			[['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg'],
			[['image'], 'file', 'maxSize' => '50000'],
			[['image'], 'file', 'maxFiles'=> 1],
		];
	}

	public function add()
	{
		if ($this->validate()) {
			$this->image->saveAs(Yii::getAlias('@webroot') . '/images/books/' . $this->image->baseName . '.' . $this->image->extension);
			return true;
		}

		return false;
	}
}