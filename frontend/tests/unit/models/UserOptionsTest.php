<?php

namespace frontend\tests\unit\models;

use common\models\User;
use common\models\UserOptions;
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
        $user_id = 14;
        expect_that(User::findOne($user_id));

        $this->userOpt->user_id  = $user_id;
        $this->userOpt->dir_name = Yii::$app->security->generateRandomString();
        $this->userOpt->img      = Yii::$app->security->generateRandomString();

        $this->userOpt->validate();
        expect_not($this->userOpt->getErrors());
    }

    public function testUniqueUserId()
    {
        $user_id = 8;

        expect_that(User::findOne($user_id));
        $this->userOpt->user_id = $user_id;

        $this->userOpt->validate();
        expect($this->userOpt->getErrors())->hasKey('user_id');

        $user_id = 14;

        expect_that(User::findOne($user_id));
        $this->userOpt->user_id = $user_id;

        $this->userOpt->validate();
        expect($this->userOpt->getErrors())->hasntKey('user_id');
    }

    public function testExistUser()
    {
        $this->userOpt->user_id = 999999;

        $this->userOpt->validate();
        expect($this->userOpt->getErrors())->hasKey('user_id');

        $this->userOpt->user_id = 14;

        $this->userOpt->validate();
        expect($this->userOpt->getErrors())->hasntKey('user_id');
    }

    public function testUser()
    {
        $this->userOpt->user_id = 999999;

        expect_not($this->userOpt->user);

        $this->userOpt->user_id = 8;

        expect_that($this->userOpt->user);
    }

}
