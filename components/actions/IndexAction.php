<?php

namespace app\components\actions;

use yii\base\Action;
use app\models\TestSession;

//use yii\helpers\Url;

class IndexAction extends Action
{

    public $view;
    public $modelClass;

    public function run()
    {
        $session = \Yii::$app->session;
        $session->open();
//        $session->remove('testSession');
        $model   = new TestSession();

        $query = $this->modelClass::find();

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $session->set('testSession', $model->sessionField);
            $session->setFlash('accessTest', 'Успех!');
            $this->controller->redirect(\Yii::$app->request->url);
        }

        $countries = $query->orderBy('name')->all();

        return $this->controller->render($this->view, compact('countries', 'model'));
    }

}
