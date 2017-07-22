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

			if ($this->image) {
				$this->image->saveAs(Yii::getAlias('@webroot') . '/images/users/' . time() . '.' . $this->image->extension);
				$user->image = time() .'.'. $this->image->extension;
			}

			$user->save();

			return true;
		}

		return false;
	}
}
