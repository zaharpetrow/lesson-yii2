<?php

namespace app\components;

use yii\base\BaseObject;

class TestGetSet extends BaseObject
{

    private $_value;

    public function setValue($value)
    {
        $this->_value = $value;
    }

    public function getValue()
    {
        return $this->_value;
    }

}
