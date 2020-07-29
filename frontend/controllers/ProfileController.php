<?php

namespace frontend\controllers;

use common\components\VerifyAccount;
use common\models\profile\ProfileData;
use common\models\profile\UploadAvatar;
use common\models\UserOptions;
use Exception;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

class ProfileController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'logout', 'delete-avatar'],
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
        $uploadModel = new UploadAvatar();
        $profileData = new ProfileData();

        if (Yii::$app->request->isAjax) {
            $uploadModel->imageFile = UploadedFile::getInstance($uploadModel, 'imageFile');

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $uploadModel->upload();
        }

        if ($profileData->load(Yii::$app->request->post()) && $profileData->validate()) {
            $profileData->updateProfile();
            $this->refresh();
        }

        return $this->render('index', compact('profileData'));
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

    public function actionDeleteAvatar()
    {
        $userIdentity = Yii::$app->user->identity;

        $userIdentity->userOptions->img = null;
        UploadAvatar::clearDir();

        $userOptions      = UserOptions::find()->where(['user_id' => $userIdentity->id])->one();
        $userOptions->img = null;
        $userOptions->save();



        return $this->redirect(['profile/']);
    }

}
