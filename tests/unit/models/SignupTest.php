<?php

namespace app\tests\unit\models;

use app\models\auth\SignUp;
use app\models\User;
use Codeception\Test\Unit;

/**
 * @property SignUp $signUp
 */
class SignupTest extends Unit
{

    public $signUp;

    public function _before()
    {
        parent::_before();
        $this->signUp = new SignUp();
    }

    public function testValidateCorrectValues()
    {
        $this->signUp->name           = 'Poul';
        $this->signUp->email          = 'poul@ya.ru';
        $this->signUp->password       = 'truePass2';
        $this->signUp->passwordRepeat = 'truePass2';
        $this->signUp->validate();

        expect($this->signUp->getErrors())->hasntKey('name');
        expect($this->signUp->getErrors())->hasntKey('email');
        expect($this->signUp->getErrors())->hasntKey('password');
        expect($this->signUp->getErrors())->hasntKey('passwordRepeat');
    }

    public function testPasswordRepeat()
    {
        $this->signUp->password       = 'truePass2';
        $this->signUp->passwordRepeat = 'truePass2';
        $this->signUp->validate();

        expect($this->signUp->getErrors())->hasntKey('passwordRepeat');

        $this->signUp->passwordRepeat = 'falsePass2';
        $this->signUp->validate();

        expect($this->signUp->getErrors())->hasKey('passwordRepeat');
    }

    public function testUniqueEmail()
    {
        expect_that(User::findByEmail('ivan@gmail.com'));

        $this->signUp->email = 'ivan@gmail.com';
        $this->signUp->validate();

        expect($this->signUp->getErrors())->hasKey('email');

        $this->signUp->email = 'free-email@mail.com';
        $this->signUp->validate();

        expect($this->signUp->getErrors())->hasntKey('email');
    }

    public function testRegister()
    {
        $data = [
            basename($this->signUp::className()) => [
                'name'           => 'Stas',
                'email'          => 'stasyan@ya.ru',
                'password'       => '12345Aa',
                'passwordRepeat' => '12345Aa',
            ],
        ];

        $response = $this->signUp->run($data);
        expect($this->signUp->getErrors())->hasntKey('name');
        expect($this->signUp->getErrors())->hasntKey('email');
        expect($this->signUp->getErrors())->hasntKey('password');
        expect($this->signUp->getErrors())->hasntKey('passwordRepeat');
        expect($response)->hasntKey('validation');
        expect($response)->hasKey('success');

        $data     = [
            basename($this->signUp::className()) => [
                'name'           => 'Stas',
                'email'          => 'stasyanj',
                'password'       => '12345Aajj',
                'passwordRepeat' => '12345Aa',
            ],
        ];
        $response = $this->signUp->run($data);
        expect($response)->hasntKey('success');
        expect($response)->hasKey('validation');
    }

    /**
     * @dataProvider getWrongValues
     */
    public function testValidateWrongValues($propName, $propVal)
    {
        $this->signUp->$propName = $propVal;
        $this->signUp->validate();

        expect($this->signUp->getErrors())->hasKey($propName);
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
