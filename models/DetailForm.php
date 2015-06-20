<?php

namespace app\models;

use yii\base\Model;

class DetailForm extends Model
{
	public $fname;
	public $lname;

	public function rules()
	{
		return [
			[['fname','lname'],'required'],
		];
	}
}

?>