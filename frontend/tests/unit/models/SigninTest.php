<?php

namespace frontend\tests\unit\models;

use common\components\helpers\UrlHelper;
use common\models\auth\SignIn;
use common\models\User;
use Codeception\Test\Unit;
use Yii;

/**
 * @property SignIn $signin
 */
class SigninTest extends Unit
{

    public $signin;

    public function _before()
    {
        parent::_before();
        $this->signin = new SignIn();
    }

    public function testValidateCorrectValues()
    {
        $this->signin->email    = 'poul@ya.ru';
        $this->signin->password = 'truePass2';
        $this->signin->remember = false;
        $this->signin->validate();

        expect($this->signin->getErrors())->hasntKey('email');
        expect($this->signin->getErrors())->hasntKey('password');
        expect($this->signin->getErrors())->hasntKey('remember');
    }

    public function testValidateEmptyValues()
    {
        $this->signin->validate();

        expect($this->signin->getErrors())->hasKey('email');
        expect($this->signin->getErrors())->hasKey('password');
    }

    public function testValidateWrongValues()
    {
        $this->signin->remember = 'asd';
        $this->signin->validate();

        expect($this->signin->getErrors())->hasKey('remember');
    }

    public function testLogin()
    {
        expect_that(User::findByEmail('olegTT@gmail.com'));



        $data = [
            basename($this->signin::className()) => [
                'email'    => 'olegTT@gmail.com',
                'password' => '1234Zz512',
            ],
        ];

        $response = $this->signin->run($data);

        $userRoot   = UrlHelper::profileUserRoot();
        $avatarRoot = UrlHelper::avatarUserRoot();

        $this->assertFileExists($userRoot);
        $this->assertFileExists($avatarRoot);

        rmdir($avatarRoot);
        rmdir($userRoot);

        $this->assertFileNotExists($userRoot);
        $this->assertFileNotExists($avatarRoot);

        expect($this->signin->getErrors())->hasntKey('email');
        expect($this->signin->getErrors())->hasntKey('password');
        expect($response)->hasntKey('validation');
        expect($response)->hasKey('success');
        expect_that(Yii::$app->user->identity);
        Yii::$app->user->logout();



        $data     = [
            basename($this->signin::className()) => [
                'email'    => 'gregory@gmail.com',
                'password' => 'FalsePass123',
            ],
        ];
        $response = $this->signin->run($data);
        expect($this->signin->hasErrors())->true();
        expect($this->signin->getErrors())->hasKey('email');
        expect($this->signin->getErrors())->hasKey('password');
        expect($response)->hasntKey('success');
        expect($response)->hasKey('validation');
        expect_not(Yii::$app->user->identity);



        $data     = [
            basename($this->signin::className()) => [
                'email'    => 'false-email@gmail.com',
                'password' => '1234Zz512',
            ],
        ];
        $response = $this->signin->run($data);
        expect($this->signin->hasErrors())->true();
        expect($this->signin->getErrors())->hasKey('email');
        expect($this->signin->getErrors())->hasKey('password');
        expect($response)->hasntKey('success');
        expect($response)->hasKey('validation');
        expect_not(Yii::$app->user->identity);
    }

}
