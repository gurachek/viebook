<?php

namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;
use common\models\User;
use Yii;

class UserSettingsModel extends Model
{
	public $nicename;
	public $image;

	public function rules()
	{
		return [
			[['nicename', 'image'], 'default'],
			[['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
			[['image'], 'file', 'maxSize' => '50000'],
			[['image'], 'file', 'maxFiles'=> 1],
		];
	}

	public function save()
	{
		if ($this->validate()) {

			$this->image->saveAs(Yii::getAlias('@webroot') . '/images/users/' . $this->image->baseName . '.' . $this->image->extension);

			$user = User::findOne(['id' => Yii::$app->user->getId()]);

			if (empty($user->nicename))
				Yii::$app->user->identity->increaseRating(5);

			if ($user->image == 'no-photo.jpg')
				Yii::$app->user->identity->increaseRating(5);

			$user->nicename = htmlspecialchars($this->nicename);
			$user->image = $this->image->baseName .'.'. $this->image->extension;

			$user->save();

			return true;
		}

		return false;
	}
}