<?php

namespace app\tests\unit\models;

use app\models\User;
use Codeception\Test\Unit;
use Yii;

/**
 * @property User $user
 */
class UserTest extends Unit
{

    public $user;

    public function _before()
    {
        parent::_before();
        $this->user = new User();
    }

    public function testValidateWrongValues()
    {
        $this->user->name     = Yii::$app->security->generateRandomString(21);
        $this->user->email    = 'bad_email@ya.';
        $this->user->password = 'pass';
        $this->user->validate();

        expect($this->user->getErrors())->hasKey('name');
        expect($this->user->getErrors())->hasKey('email');

        $this->user->name     = 'Name';
        $this->user->email    = Yii::$app->security->generateRandomString(50) . '@gmail.com';
        $this->user->password = 'pass';
        $this->user->validate();
        expect($this->user->getErrors())->hasKey('email');
    }

    public function testValidateEmptyValues()
    {
        $this->user->validate();

        expect($this->user->getErrors())->hasKey('name');
        expect($this->user->getErrors())->hasKey('email');
        expect($this->user->getErrors())->hasKey('password');

        $this->user->name     = 'Vasya';
        $this->user->email    = 'saffasya@gmail.com';
        $this->user->password = 'pass';
        $this->user->validate();
        expect_not($this->user->getErrors());
    }

    public function testValidateCorrectValues()
    {
        $this->user->name     = 'Vasya';
        $this->user->email    = 'ahahah@gmail.com';
        $this->user->password = 'pass';
        $this->user->validate();

        expect_not($this->user->getErrors());
    }

    public function testValidateUniqueEmail()
    {
        $this->user->email = 'ivan@gmail.com';
        $this->user->validate();

        expect($this->user->getErrors())->hasKey('email');

        $this->user->email = 'true@mail.ru';
        $this->user->validate();
        expect($this->user->getErrors())->hasntKey('email');
    }

    public function testFindByEmail()
    {
        expect(User::findByEmail('lion@gmail.com')->name)->equals('Lion');
        expect_not(User::findByEmail('not_exist@gmail.com'));
    }

    public function testFindById()
    {
        expect(User::findOne(1)->name)->equals('Вася');
        expect_not(User::findOne(1000));
    }

    public function testUserOptions()
    {
        expect_not(User::findOne(1)->userOptions);
        expect_that(User::findOne(8)->userOptions);
    }

    public function testToken()
    {
        expect_not(User::findOne(1)->token);
        expect_that(User::findOne(8)->token);
    }

}
