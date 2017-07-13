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

	public function rules()
	{
		return [
			[['name', 'author', 'publish_date'], 'required'],
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