<?php

namespace frontend\controllers;

use common\models\auth\Auth;
use common\models\auth\SignIn;
use common\models\auth\SignUp;
use common\models\recovery\RecoveryPass;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{

    public static $authLayout = 'auth-layout';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['auth', 'recovery'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['auth', 'recovery'],
                        'roles'   => ['?'],
                    ],
                    [
                        'allow'        => false,
                        'actions'      => ['auth', 'recovery'],
                        'roles'        => ['@'],
                        'denyCallback' => function($rule, $action) {
                            Yii::$app->response->redirect('/');
                        }
                    ]
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAuth()
    {
        $this->layout = static::$authLayout;

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

        return $this->render('auth', compact('modelSignIn', 'modelSignUp'));
    }

    public function actionRecovery()
    {
        $recoveryModel = new RecoveryPass();

        $dataGet = Yii::$app->request->get();
        if ($dataGet) {
            $recoveryModel->loginToken($dataGet);
            Yii::$app->response->redirect('profile');
        }

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $recoveryModel->recovery(Yii::$app->request->post());
        }

        $this->layout = static::$authLayout;
        return $this->render('recovery', compact('recoveryModel'));
    }

}
