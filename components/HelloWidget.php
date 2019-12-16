<?php

namespace app\components;

use yii\base\Widget;

class HelloWidget extends Widget
{

    public $model;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('BigBlockText', ['model' => $this->model]);
    }

}
