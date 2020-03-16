<?php

namespace app\tests\unit\models;

use app\models\recovery\RecoveryPass;
use app\models\recovery\Token;
use app\models\User;
use app\tests\unit\fixtures\TokenFixture;
use Yii;
use yii\codeception\DbTestCase;

/**
 * @property TokenFixture $tokens
 * @property RecoveryPass $rPass
 */
class RecoveryPassTest extends DbTestCase
{

    public $rPass;

    public function _before()
    {
        parent::_before();
        $this->rPass = new RecoveryPass();
    }

    public function fixtures()
    {
        return [
            'tokens' => TokenFixture::className(),
        ];
    }

    public function testValidateCorrectValues()
    {
        $this->rPass->email = 'gregory@gmail.com';
        $this->rPass->validate();

        expect_that(User::findByEmail('gregory@gmail.com'));
        expect($this->rPass->getErrors())->hasntKey('email');
    }

    public function testValidateEmptyValues()
    {
        $this->rPass->validate();

        expect($this->rPass->getErrors())->hasKey('email');
    }

    /**
     * @dataProvider getWrongValues
     */
    public function testValidateWrongValues($email)
    {
        $this->rPass->email = $email;
        $this->rPass->validate();

        expect($this->rPass->getErrors())->hasKey('email');
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
        expect_that(User::findByEmail('gregory@gmail.com'));



        $data = [
            basename($this->rPass::className()) => [
                'email' => 'gregory@gmail.com',
            ],
        ];

        $response = $this->rPass->recovery($data);
        expect($this->rPass->getErrors())->hasntKey('email');
        expect($response)->hasntKey('validation');
        expect($response)->hasKey('success');



        $data     = [
            basename($this->rPass::className()) => [
                'email' => 'false-email@gmail.com',
            ],
        ];
        $response = $this->rPass->recovery($data);
        expect($this->rPass->hasErrors())->true();
        expect($this->rPass->getErrors())->hasKey('email');
        expect($response)->hasntKey('success');
        expect($response)->hasKey('validation');
    }

    public function testValidateDataGet()
    {
        $data = [
            'id'    => $this->tokens[0]['user_id'],
            'token' => $this->tokens[0]['token'],
        ];

        expect($this->rPass->validateToken($data))->true();

        $data = [
            'id'    => $this->tokens[1]['user_id'],
            'token' => $this->tokens[1]['token'],
        ];

        expect($this->rPass->validateToken($data))->false();
    }

    public function testLoginToken()
    {
        $data = [
            'id'    => $this->tokens[0]['user_id'],
            'token' => $this->tokens[0]['token'],
        ];

        expect(Token::findOne(['user_id' => 16]));
        $this->rPass->loginToken($data);
        expect(Yii::$app->user->identity);
        expect_not(Token::findOne(['user_id' => 16]));
    }

    /**
     * @expectedException \yii\web\NotFoundHttpException
     */
    public function testErrorLoginToken()
    {
        $data = [
            'not id'    => $this->tokens[0]['user_id'],
            'not token' => $this->tokens[0]['token'],
        ];

        $this->rPass->loginToken($data);
    }

}
