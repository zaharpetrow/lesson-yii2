<?php

namespace app\tests\unit\models;

use app\models\recovery\Token;
use app\models\User;
use Codeception\Test\Unit;

class TokenTest extends Unit
{

    public function testCreateToken()
    {
        $token = new Token();
        expect(mb_strlen($token->createToken()) > 10)->true();
    }

    public function testValidateEmptyValues()
    {
        $token = new Token();
        $token->validate();

        expect($token->getErrors())->hasKey('user_id');
        expect($token->getErrors())->hasntKey('token');
        expect($token->getErrors())->hasntKey('created_at');
    }

    public function testValidateCorrectValues()
    {
        $token             = new Token();
        $token->user_id    = 16;
        $token->token      = $token->createToken();
        $token->created_at = time();

        $token->validate();
        expect_not($token->getErrors());
    }

    public function testUniqueUserId()
    {
        $token = new Token();

        expect_that(User::findOne(8));
        $token->user_id = 8;

        $token->validate();
        expect($token->getErrors())->hasKey('user_id');

        $token->user_id = 18;

        $token->validate();
        expect($token->getErrors())->hasntKey('user_id');
    }

    public function testExistUser()
    {
        $token = new Token();

        $token->user_id = 99;

        $token->validate();
        expect($token->getErrors())->hasKey('user_id');

        $token->user_id = 18;

        $token->validate();
        expect($token->getErrors())->hasntKey('user_id');
    }

    public function testUser()
    {
        $token = new Token();

        $token->user_id = 99;

        expect_not($token->user);

        $token->user_id = 8;

        expect($token->user->name)->equals('Владимир');
    }

}
