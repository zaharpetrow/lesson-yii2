<?php

namespace frontend\tests\unit\models;

use common\models\recovery\Token;
use common\models\User;
use Codeception\Test\Unit;

/**
 * @property Token $token
 */
class TokenTest extends Unit
{

    public $token;

    public function _before()
    {
        parent::_before();
        $this->token = new Token();
    }

    public function testCreateToken()
    {
        expect(mb_strlen($this->token->createToken()) === 32)->true();
    }

    public function testValidateEmptyValues()
    {
        $this->token->validate();

        expect($this->token->getErrors())->hasKey('user_id');
        expect($this->token->getErrors())->hasntKey('token');
        expect($this->token->getErrors())->hasntKey('created_at');
    }

    public function testValidateCorrectValues()
    {
        $this->token->user_id    = 16;
        $this->token->token      = $this->token->createToken();
        $this->token->created_at = time();

        $this->token->validate();
        expect_not($this->token->getErrors());
    }

    public function testUniqueUserId()
    {
        expect_that(User::findOne(8));
        $this->token->user_id = 8;

        codecept_debug(Token::find()->all());

        $this->token->validate();
        expect($this->token->getErrors())->hasKey('user_id');

        $this->token->user_id = 16;

        $this->token->validate();
        expect($this->token->getErrors())->hasntKey('user_id');
    }

    public function testExistUser()
    {
        $this->token->user_id = 99;

        $this->token->validate();
        expect($this->token->getErrors())->hasKey('user_id');

        $this->token->user_id = 16;

        $this->token->validate();
        expect($this->token->getErrors())->hasntKey('user_id');
    }

    public function testUser()
    {
        $this->token->user_id = 99;

        expect_not($this->token->user);

        $this->token->user_id = 8;

        expect($this->token->user->name)->equals('Владимир');
    }

}
