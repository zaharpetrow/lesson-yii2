<?php

namespace app\models\auth;

use app\components\validators\ValidateRules;
use app\components\VerifyAccount;
use app\models\User;
use Yii;

class SignUp extends Auth
{

    public $name;
    public $passwordRepeat;

    public function rules()
    {
        return array_merge(parent::rules(), ValidateRules::getSignUpRules());
    }

    public function attributeLabels()
    {
        $attrLabels = [
            'name'           => Yii::t('app', 'Имя'),
            'passwordRepeat' => Yii::t('app', 'Подтверждение пароля'),
        ];

        return array_merge(parent::attributeLabels(), $attrLabels);
    }

    public function run(array $dataPost): array
    {
        $models = [];
        if ($this->load($dataPost) && $this->validate()) {
            $user           = new User();
            $user->name     = $this->name;
            $user->email    = $this->email;
            $user->password = User::getPassHash($this->password);

            if ($user->validate() && $user->save()) {
                VerifyAccount::sendVerifyMail($this->email);
                return ['success' => true];
            }

            $models[] = $user;
        }

        return ['validation' => $this->validationErrors($models)];
    }

}
