<?php

namespace app\tests\unit\models;

use app\models\User;
use app\models\UserOptions;
use Codeception\Test\Unit;
use Yii;

class UserOptionsTest extends Unit
{

    public function testValidateEmptyValues()
    {
        $userOpt = new UserOptions();
        $userOpt->validate();

        expect($userOpt->getErrors())->hasKey('user_id');
        expect($userOpt->getErrors())->hasKey('dir_name');
        expect($userOpt->getErrors())->hasntKey('img');
    }

    public function testValidateCorrectValues()
    {
        $userOpt           = new UserOptions();
        $userOpt->user_id  = 18;
        $userOpt->dir_name = Yii::$app->security->generateRandomString();
        $userOpt->img      = Yii::$app->security->generateRandomString();

        $userOpt->validate();
        expect_not($userOpt->getErrors());
    }

    public function testUniqueUserId()
    {
        $userOpt = new UserOptions();

        expect_that(User::findOne(8));
        $userOpt->user_id = 8;

        $userOpt->validate();
        expect($userOpt->getErrors())->hasKey('user_id');

        $userOpt->user_id = 18;

        $userOpt->validate();
        expect($userOpt->getErrors())->hasntKey('user_id');
    }

    public function testExistUser()
    {
        $userOpt = new UserOptions();

        $userOpt->user_id = 99;

        $userOpt->validate();
        expect($userOpt->getErrors())->hasKey('user_id');

        $userOpt->user_id = 18;

        $userOpt->validate();
        expect($userOpt->getErrors())->hasntKey('user_id');
    }

    public function testUser()
    {
        $userOpt = new UserOptions();

        $userOpt->user_id = 99;

        expect_not($userOpt->user);

        $userOpt->user_id = 8;

        expect_that($userOpt->user);
    }

}
