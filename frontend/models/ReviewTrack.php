<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class ReviewTrack extends ActiveRecord
{
	public static function tableName()
	{
		return 'review_track';
	}
}