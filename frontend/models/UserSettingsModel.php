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
	public $about;

	public function rules()
	{
		return [
			[['nicename', 'image', 'about'], 'default'],
			[['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
			[['image'], 'file', 'maxSize' => '5000000'],
			[['image'], 'file', 'maxFiles'=> 1],
		];
	}

	public function save()
	{
		if ($this->validate()) {

			$user = User::findOne(['id' => Yii::$app->user->getId()]);
			$nicename = htmlspecialchars(trim($this->nicename));

			if (empty($user->nicename) && $nicename != '')
				Yii::$app->user->identity->increaseRating(5);

			if ($user->image == 'no-photo.jpg' || $user->image == '')
				Yii::$app->user->identity->increaseRating(5);

			$user->nicename = $nicename ?? $user->username;
			if (!empty($this->about)) {
				$user->about = $this->about;
				Yii::$app->user->identity->increaseRating(10);
			}

			if ($this->image) {

				$image = time() . '.' . $this->image->extension;

				$this->image->saveAs(Yii::getAlias('@webroot') . '/images/users/' . $image);
				$user->image = $image;
			}

			$user->save();

			return true;
		}

		return false;
	}
}
