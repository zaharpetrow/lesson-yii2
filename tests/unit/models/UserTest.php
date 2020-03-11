<?php

namespace app\tests\unit\models;

use app\models\User;
use Codeception\Test\Unit;
use Yii;

class UserTest extends Unit
{

    public function testValidateWrongValues()
    {
        $user = new User([
            'name'     => Yii::$app->security->generateRandomString(21),
            'email'    => 'bad_email@ya.',
            'password' => 'pass',
        ]);
        $user->validate();

        expect($user->getErrors())->hasKey('name');
        expect($user->getErrors())->hasKey('email');

        $user = new User([
            'name'     => 'Name',
            'email'    => Yii::$app->security->generateRandomString(50) . '@gmail.com',
            'password' => 'pass',
        ]);
        $user->validate();
        expect($user->getErrors())->hasKey('email');
    }

    public function testValidateEmptyValues()
    {
        $user = new User();
        $user->validate();

        expect($user->getErrors())->hasKey('name');
        expect($user->getErrors())->hasKey('email');
        expect($user->getErrors())->hasKey('password');

        $user = new User([
            'name'     => 'Vasya',
            'email'    => 'saffasya@gmail.com',
            'password' => 'pass',
        ]);
        $user->validate();
        expect_not($user->getErrors());
    }

    public function testValidateCorrectValues()
    {
        $user = new User([
            'name'     => 'Vasya',
            'email'    => 'ahahah@gmail.com',
            'password' => 'pass',
        ]);
        $user->validate();

        expect($user->hasErrors())->false();
    }

    public function testValidateUniqueEmail()
    {
        $user = new User([
            'name'     => 'Vasya',
            'email'    => 'ivan@gmail.com',
            'password' => 'pass',
        ]);
        $user->validate();

        expect($user->getErrors())->hasKey('email');

        $user->email = 'true@mail.ru';
        $user->validate();
        expect_not($user->getErrors());
    }

    public function testFindByEmail()
    {
        expect(User::findByEmail('lion@gmail.com')->name)->equals('Lion');
        expect_not(User::findByEmail('vasya@gmail.com'));
    }

    public function testFindById()
    {
        expect(User::findOne(1)->name)->equals('Вася');
        expect_not(User::findOne(1000));
    }

    public function testUserOptions()
    {
        expect_not(User::findOne(1)->userOptions);
        expect_not(User::findOne(8)->userOptions == null);
    }

    public function testToken()
    {
        expect_not(User::findOne(1)->token);
        expect_not(User::findOne(8)->token == null);
    }

}
