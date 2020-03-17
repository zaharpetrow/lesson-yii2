<?php

namespace app\tests\unit\models;

use app\models\profile\ProfileData;
use app\models\User;
use Codeception\Test\Unit;
use Yii;

/**
 * @property ProfileData $profileData
 */
class ProfileDataTest extends Unit
{

    public $profileData;

    public function _before()
    {
        parent::_before();
        $this->profileData = new ProfileData();
    }

    public function testValidateCorrectValues()
    {
        $this->profileData->name           = 'Poul';
        $this->profileData->password       = 'truePass2';
        $this->profileData->passwordRepeat = 'truePass2';
        $this->profileData->validate();

        expect($this->profileData->getErrors())->hasntKey('name');
        expect($this->profileData->getErrors())->hasntKey('password');
        expect($this->profileData->getErrors())->hasntKey('passwordRepeat');
    }

    public function testUpdateProfile()
    {
        expect($user = User::findOne(8));
        Yii::$app->user->login($user);

        $oldName = $user->name;
        $oldPass = $user->password;

        $this->profileData->name     = 'New name';
        $this->profileData->password = 'NewPass123';

        $this->profileData->updateProfile();

        expect($oldName === $user->name)->false();
        expect($oldPass === $user->password)->false();
    }

    /**
     * @expectedException \yii\web\UnauthorizedHttpException
     */
    public function testUpdateProfileError()
    {
        $this->profileData->name           = 'Poul';
        $this->profileData->password       = 'truePass2';
        $this->profileData->passwordRepeat = 'truePass2';
        $this->profileData->updateProfile();
    }

    public function testPasswordRepeat()
    {
        $this->profileData->password       = 'truePass2';
        $this->profileData->passwordRepeat = 'truePass2';
        $this->profileData->validate();

        expect($this->profileData->getErrors())->hasntKey('passwordRepeat');

        $this->profileData->passwordRepeat = 'falsePass2';
        $this->profileData->validate();

        expect($this->profileData->getErrors())->hasKey('passwordRepeat');
    }

    /**
     * @dataProvider getWrongValues
     */
    public function testValidateWrongValues($propName, $propVal)
    {
        $this->profileData->$propName = $propVal;
        $this->profileData->validate();

        expect($this->profileData->getErrors())->hasKey($propName);
    }

    public function getWrongValues()
    {
        return [
            'name2'   => ['name', 'g'],
            'name3'   => ['name', 'hhh*^&><""'],
            'name4'   => ['name', 'hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh'],
            'passwd1' => ['password', '123'],
            'passwd2' => ['password', '123abc'],
            'passwd3' => ['password', '12345abc'],
            'passwd4' => ['password', '12Ab'],
            'passwd5' => ['password', 'abcdEFg'],
        ];
    }

}
