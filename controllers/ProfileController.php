<?php

namespace app\controllers;

use app\components\VerifyAccount;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class ProfileController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'logout'],
                'rules' => [
                    [
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
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
