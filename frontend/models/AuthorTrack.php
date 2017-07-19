<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class AuthorTrack extends ActiveRecord 
{
	public static function tableName()
	{
		return 'author_track';
	}
}