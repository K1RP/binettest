<?php

namespace app\models;

use yii\db\ActiveRecord;

class RefLinks extends ActiveRecord
{
	public static function tableName()
    {
        return '{{reflinks}}';
    }
}