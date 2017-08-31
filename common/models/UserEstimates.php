<?php

namespace common\models;

use yii\db\ActiveRecord;

class UserEstimates extends ActiveRecord
{
	public static function tableName()
	{
		return 'user_estimates';
	}    

	public function numberOfPositive()
	{
		return static::find()->where(['estimate' => 1, 'entry_id' => $this->entry_id])->count();
	}

	public function numberOfNegative()
	{
		return static::find()->where(['estimate' => 0, 'entry_id' => $this->entry_id])->count();
	}

}
