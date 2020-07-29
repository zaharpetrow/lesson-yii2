<?php

namespace frontend\tests\unit\models;

use common\models\recovery\RecoveryPass;
use common\models\recovery\Token;
use common\models\User;
use frontend\tests\unit\fixtures\TokenFixture;
use Yii;

/**
 * @property RecoveryPass $rPass
 */
class RecoveryPassTest extends \Codeception\Test\Unit
{

    public $rPass;

    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    public function _before()
    {
        parent::_before();
        $this->rPass = new RecoveryPass();
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
        $this->tester->haveFixtures([
            'token' => TokenFixture::className()
        ]);

        $token0 = $this->tester->grabFixture('token', 0);
        $token1 = $this->tester->grabFixture('token', 1);

        $data = [
            'id'    => $token0->user_id,
            'token' => $token0->token,
        ];
        codecept_debug($data);
        codecept_debug($this->tester->grabFixture('token', 0)->user_id);
        codecept_debug(Token::find()->all());
        expect($this->rPass->validateToken($data))->true();

        $data = [
            'id'    => $token1->user_id,
            'token' => $token1->token,
        ];

        expect($this->rPass->validateToken($data))->false();
    }

    public function testLoginToken()
    {
        $this->tester->haveFixtures([
            'token' => TokenFixture::className()
        ]);

        $token = $this->tester->grabFixture('token', 0);
        codecept_debug('DEBUG');
        codecept_debug($token);

        $data = [
            'id'    => $token->user_id,
            'token' => $token->token,
        ];

        codecept_debug($data);
        codecept_debug(\common\models\UserOptions::find()->all());
        expect(Token::findOne(['user_id' => $token->user_id]));
        $this->rPass->loginToken($data);
        expect(Yii::$app->user->identity);
        expect_not(Token::findOne(['user_id' => $token->user_id]));
    }

    public function testErrorLoginToken()
    {
        $data = [
            'not id'    => 'not id',
            'not token' => 'not token',
        ];

        $this->expectException(\yii\web\NotFoundHttpException::class);
        $this->rPass->loginToken($data);
    }

}
