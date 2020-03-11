<?php

namespace app\tests\unit\models;

use app\models\auth\SignUp;
use app\models\User;
use Codeception\Test\Unit;

class SignupTest extends Unit
{

    public function testValidateCorrectValues()
    {
        $signup = new SignUp();

        $signup->name           = 'Poul';
        $signup->email          = 'poul@ya.ru';
        $signup->password       = 'truePass2';
        $signup->passwordRepeat = 'truePass2';
        $signup->validate();

        expect($signup->getErrors())->hasntKey('name');
        expect($signup->getErrors())->hasntKey('email');
        expect($signup->getErrors())->hasntKey('password');
        expect($signup->getErrors())->hasntKey('passwordRepeat');
    }

    public function testPasswordRepeat()
    {
        $signup = new SignUp();

        $signup->password       = 'truePass2';
        $signup->passwordRepeat = 'truePass2';
        $signup->validate();

        expect($signup->getErrors())->hasntKey('passwordRepeat');

        $signup->passwordRepeat = 'falsePass2';
        $signup->validate();

        expect($signup->getErrors())->hasKey('passwordRepeat');
    }

    public function testUniqueEmail()
    {
        $signup = new SignUp();

        expect_that(User::findByEmail('ivan@gmail.com'));

        $signup->email = 'ivan@gmail.com';
        $signup->validate();

        expect($signup->getErrors())->hasKey('email');

        $signup->email = 'free-email@mail.com';
        $signup->validate();

        expect($signup->getErrors())->hasntKey('email');
    }

    public function testRegister()
    {
        $signup = new SignUp();

        $data = [
            basename($signup::className()) => [
                'name'           => 'Stas',
                'email'          => 'stasyan@ya.ru',
                'password'       => '12345Aa',
                'passwordRepeat' => '12345Aa',
            ],
        ];

        $response = $signup->run($data);
        expect($signup->getErrors())->hasntKey('name');
        expect($signup->getErrors())->hasntKey('email');
        expect($signup->getErrors())->hasntKey('password');
        expect($signup->getErrors())->hasntKey('passwordRepeat');
        expect($response)->hasntKey('validation');
        expect($response)->hasKey('success');

        $data     = [
            basename($signup::className()) => [
                'name'           => 'Stas',
                'email'          => 'stasyanj',
                'password'       => '12345Aajj',
                'passwordRepeat' => '12345Aa',
            ],
        ];
        $response = $signup->run($data);
        expect($response)->hasntKey('success');
        expect($response)->hasKey('validation');
    }

    /**
     * @dataProvider getWrongValues
     */
    public function testValidateWrongValues($propName, $propVal)
    {
        $signup = new SignUp();

        $signup->$propName = $propVal;
        $signup->validate();

        expect($signup->getErrors())->hasKey($propName);
    }

    public function getWrongValues()
    {
        return [
            'name1'   => ['name', ''],
            'name2'   => ['name', 'g'],
            'name3'   => ['name', 'hhh*^&><""'],
            'name4'   => ['name', 'hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh'],
            'email1'  => ['email', 'hhh.ru'],
            'email2'  => ['email', 'hhh@ru'],
            'email3'  => ['email', 'hhh@.ru'],
            'email4'  => ['email', '@hhhr.u'],
            'email5'  => ['email', 'hhh@mail.'],
            'passwd1' => ['password', '123'],
            'passwd2' => ['password', '123abc'],
            'passwd3' => ['password', '12345abc'],
            'passwd4' => ['password', '12Ab'],
            'passwd5' => ['password', 'abcdEFg'],
        ];
    }

}
