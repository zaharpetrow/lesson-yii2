<?php

namespace app\components\validators;

use app\models\User;
use Yii;
use yii\validators\Validator;

class EmailExistValidator extends Validator
{

    public $message;

    public function validateAttribute($model, $attribute)
    {
        $message = $this->getMessage();
        if (!User::findByEmail($model->$attribute)) {
            $model->addError($attribute, $message);
        }
    }

    protected function getMessage()
    {
        return ($this->message) ? $this->message : Yii::t('app', 'Email не существует!');
    }

}
