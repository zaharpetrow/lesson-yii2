<?php

namespace app\models;

use yii\base\Model;

class TestSession extends Model
{

    public $sessionField;

    public function rules()
    {
        return [
            [['sessionField'], 'required'],
        ];
    }

}
