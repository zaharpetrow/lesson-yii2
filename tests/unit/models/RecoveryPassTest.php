<?php

namespace app\tests\unit\models;

use app\models\recovery\RecoveryPass;
use app\models\recovery\Token;
use app\models\User;
use app\tests\unit\fixtures\TokenFixture;
use Yii;
use yii\codeception\DbTestCase;

//use Codeception\Test\Unit;

/**
 * @property TokenFixture $tokens
 */
class RecoveryPassTest extends DbTestCase
{

    public function fixtures()
    {
        return [
            'tokens' => TokenFixture::className(),
        ];
    }

    public function testValidateCorrectValues()
    {
        $rPass = new RecoveryPass();

        $rPass->email = 'gregory@gmail.com';
        $rPass->validate();

        expect_that(User::findByEmail('gregory@gmail.com'));
        expect($rPass->getErrors())->hasntKey('email');
    }

    public function testValidateEmptyValues()
    {
        $rPass = new RecoveryPass();
        $rPass->validate();

        expect($rPass->getErrors())->hasKey('email');
    }

    /**
     * @dataProvider getWrongValues
     */
    public function testValidateWrongValues($email)
    {
        $rPass = new RecoveryPass();

        $rPass->email = $email;
        $rPass->validate();

        expect($rPass->getErrors())->hasKey('email');
    }

    public function getWrongValues()
    {
        return [
            'email1' => ['hhh.ru'],
            'email2' => ['hhh@ru'],
            'email3' => ['hhh@.ru'],
            'email4' => ['@hhhr.u'],
            'email5' => ['hhh@mail.'],
            'email6' => ['not-exist@mail.ru'],
        ];
    }

    public function testRecovery()
    {
        $rPass = new RecoveryPass();
        expect_that(User::findByEmail('gregory@gmail.com'));



        $data = [
            basename($rPass::className()) => [
                'email' => 'gregory@gmail.com',
            ],
        ];

        $response = $rPass->recovery($data);
        expect($rPass->getErrors())->hasntKey('email');
        expect($response)->hasntKey('validation');
        expect($response)->hasKey('success');



        $data     = [
            basename($rPass::className()) => [
                'email' => 'false-email@gmail.com',
            ],
        ];
        $response = $rPass->recovery($data);
        expect($rPass->hasErrors())->true();
        expect($rPass->getErrors())->hasKey('email');
        expect($response)->hasntKey('success');
        expect($response)->hasKey('validation');
    }

    public function testValidateDataGet()
    {
        $rPass = new RecoveryPass();

        $data = [
            'id'    => $this->tokens[0]['user_id'],
            'token' => $this->tokens[0]['token'],
        ];

        expect($rPass->validateToken($data))->true();

        $data = [
            'id'    => $this->tokens[1]['user_id'],
            'token' => $this->tokens[1]['token'],
        ];

        expect($rPass->validateToken($data))->false();
    }

    public function testLoginToken()
    {
        $rPass = new RecoveryPass();

        $data = [
            'id'    => $this->tokens[0]['user_id'],
            'token' => $this->tokens[0]['token'],
        ];

        expect(Token::findOne(['user_id' => 16]));
        $rPass->loginToken($data);
        expect(Yii::$app->user->identity);
        expect_not(Token::findOne(['user_id' => 16]));
    }

    /**
     * @expectedException \yii\web\NotFoundHttpException
     */
    public function testErrorLoginToken()
    {
        $rPass = new RecoveryPass();

        $data = [
            'not id'    => $this->tokens[0]['user_id'],
            'not token' => $this->tokens[0]['token'],
        ];

        $rPass->loginToken($data);
    }

}
