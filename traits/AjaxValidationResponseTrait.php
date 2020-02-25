<?php

namespace app\traits;

use yii\helpers\Html;

trait AjaxValidationResponseTrait
{

    public function validationResponse()
    {
        $result = [];

        foreach ($this->getErrors() as $attribute => $errors) {
            $result[Html::getInputId($this, $attribute)] = $errors;
        }

        return $result;
    }

}
