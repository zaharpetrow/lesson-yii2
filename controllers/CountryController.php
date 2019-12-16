<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Country;
use app\components\Hello;

//\Yii::$container->set();

class CountryController extends Controller
{

    private $hello;

    public function __construct($id, $module, Hello $hello, $config = [])
    {
        $this->hello = $hello;
        parent::__construct($id, $module, $config);
    }

    public function actions()
    {
        return [
            'with-text' => [
                'class'      => \app\components\actions\IndexAction::className(),
                'view'       => 'withTextBlock',
                'modelClass' => 'app\models\Country',
            ],
        ];
    }

    public function actionIndex()
    {
        $query = Country::find();

        $countries = $query->orderBy('name')->all();

        return $this->render('index', ['countries' => $countries]);
    }

}
