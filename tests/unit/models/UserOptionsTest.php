<?php

namespace app\tests\unit\models;

use app\models\User;
use app\models\UserOptions;
use Codeception\Test\Unit;
use Yii;

/**
 * @property UserOptions $userOpt
 */
class UserOptionsTest extends Unit
{

    public $userOpt;

    public function _before()
    {
        parent::_before();
        $this->userOpt = new UserOptions();
    }

    public function testValidateEmptyValues()
    {
        $this->userOpt->validate();

        expect($this->userOpt->getErrors())->hasKey('user_id');
        expect($this->userOpt->getErrors())->hasKey('dir_name');
        expect($this->userOpt->getErrors())->hasntKey('img');
    }

    public function testValidateCorrectValues()
    {
        $this->userOpt->user_id  = 18;
        $this->userOpt->dir_name = Yii::$app->security->generateRandomString();
        $this->userOpt->img      = Yii::$app->security->generateRandomString();

        $this->userOpt->validate();
        expect_not($this->userOpt->getErrors());
    }

    public function testUniqueUserId()
    {
        expect_that(User::findOne(8));
        $this->userOpt->user_id = 8;

        $this->userOpt->validate();
        expect($this->userOpt->getErrors())->hasKey('user_id');

        $this->userOpt->user_id = 18;

        $this->userOpt->validate();
        expect($this->userOpt->getErrors())->hasntKey('user_id');
    }

    public function testExistUser()
    {
        $this->userOpt->user_id = 99;

        $this->userOpt->validate();
        expect($this->userOpt->getErrors())->hasKey('user_id');

        $this->userOpt->user_id = 18;

        $this->userOpt->validate();
        expect($this->userOpt->getErrors())->hasntKey('user_id');
    }

    public function testUser()
    {
        $this->userOpt->user_id = 99;

        expect_not($this->userOpt->user);

        $this->userOpt->user_id = 8;

        expect_that($this->userOpt->user);
    }

}
