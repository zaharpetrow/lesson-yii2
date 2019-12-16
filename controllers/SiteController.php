<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use app\models\Country;
use app\models\EntryForm;
use app\models\auth\Auth;
use app\models\auth\SignUp;
use app\models\auth\SignIn;

class SiteController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionEntry()
    {
        $model = new EntryForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $view = 'entry-confirm';
        } else {
            $view = 'entry';
        }

        return $this->render($view, ['model' => $model]);
    }

    public function actionTestDb()
    {
        $countries     = Country::find()->orderBy('name')->all();
        $country       = Country::findOne('US');
        $country->name = 'U.S.A.';
        $country->save();
        return $this->render('testdb', ['countries' => $country]);
    }

    public function actionAuth()
    {
        $modelSignIn = new SignIn();
        $modelSignUp = new SignUp();
        if (Yii::$app->request->isAjax) {
            $dataPost = Yii::$app->request->post();
            if (isset($dataPost[basename($modelSignIn::className())])) {
                $activeModel = $modelSignIn;
            } elseif (isset($dataPost[basename($modelSignUp::className())])) {
                $activeModel = $modelSignUp;
            }
            if ($activeModel instanceof Auth) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $activeModel->run($dataPost);
            }
        }

        return $this->renderPartial('auth', compact('modelSignIn', 'modelSignUp'));
    }

}
