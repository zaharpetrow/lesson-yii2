<?php

namespace app\tests\unit\models;

use app\models\auth\SignIn;
use app\models\User;
use Codeception\Test\Unit;
use Yii;

class SigninTest extends Unit
{

    public function testValidateCorrectValues()
    {
        $signin = new SignIn();

        $signin->email    = 'poul@ya.ru';
        $signin->password = 'truePass2';
        $signin->remember = false;
        $signin->validate();

        expect($signin->getErrors())->hasntKey('email');
        expect($signin->getErrors())->hasntKey('password');
    }

    public function testValidateEmptyValues()
    {
        $signin = new SignIn();
        $signin->validate();

        expect($signin->getErrors())->hasKey('email');
        expect($signin->getErrors())->hasKey('password');
    }

    public function testValidateWrongValues()
    {
        $signin = new SignIn();

        $signin->remember = 'asd';
        $signin->validate();

        expect($signin->getErrors())->hasKey('remember');
    }

    public function testLogin()
    {
        $signin = new SignIn();
        expect_that(User::findByEmail('gregory@gmail.com'));



        $data = [
            basename($signin::className()) => [
                'email'    => 'gregory@gmail.com',
                'password' => '1234Zz512',
            ],
        ];

        $response = $signin->run($data);
        expect($signin->getErrors())->hasntKey('email');
        expect($signin->getErrors())->hasntKey('password');
        expect($response)->hasntKey('validation');
        expect($response)->hasKey('success');
        expect_that(Yii::$app->user->identity);
        Yii::$app->user->logout();



        $data     = [
            basename($signin::className()) => [
                'email'    => 'gregory@gmail.com',
                'password' => 'FalsePass123',
            ],
        ];
        $response = $signin->run($data);
        expect($signin->hasErrors())->true();
        expect($signin->getErrors())->hasKey('email');
        expect($signin->getErrors())->hasKey('password');
        expect($response)->hasntKey('success');
        expect($response)->hasKey('validation');
        expect_not(Yii::$app->user->identity);



        $data     = [
            basename($signin::className()) => [
                'email'    => 'false-email@gmail.com',
                'password' => '1234Zz512',
            ],
        ];
        $response = $signin->run($data);
        expect($signin->hasErrors())->true();
        expect($signin->getErrors())->hasKey('email');
        expect($signin->getErrors())->hasKey('password');
        expect($response)->hasntKey('success');
        expect($response)->hasKey('validation');
        expect_not(Yii::$app->user->identity);
    }

}
