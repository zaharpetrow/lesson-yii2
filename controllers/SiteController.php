<?php

namespace app\controllers;

use app\components\VerifyAccount;
use app\models\auth\Auth;
use app\models\auth\SignIn;
use app\models\auth\SignUp;
use app\models\Country;
use app\models\EntryForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['entry', 'auth'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['auth'],
                        'roles'   => ['?'],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['entry'],
                        'roles'   => ['@'],
                    ],
                    [
                        'allow'        => false,
                        'actions'      => ['auth'],
                        'roles'        => ['@'],
                        'denyCallback' => function($rule, $action) {
                            Yii::$app->response->redirect('/');
                        }
                    ]
                ],
            ],
        ];
    }

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

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect('/');
    }

    public function actionVerification()
    {
        $dataGet = Yii::$app->request->get();
        extract($dataGet);

        if (!isset($id) || !isset($hash)) {
            throw new Exception('Не корректные данные');
        }


        if (VerifyAccount::activateAccount($id, $hash)) {
            $response = 'Аккаунт активирован';
        } else {
            $response = 'Произошла ошибка при активации аккаунта';
        }

        return $this->render('verification', compact('response'));
    }

}
