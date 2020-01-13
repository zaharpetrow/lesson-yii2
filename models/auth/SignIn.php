<?php

namespace app\models\auth;

use app\components\Avatar;
use app\models\User;
use Yii;

class SignIn extends Auth
{

    public $remember;

    public function rules()
    {
        $rules = [
            [['email', 'password'], 'string'],
            [['remember'], 'boolean']
        ];

        $required = ['email', 'password'];
        return array_merge($this->createTrimRules($required), 
                $rules, 
                $this->createRequiredRules($required));
    }

    public function run(array $dataPost): array
    {
        $models = [];

        if ($this->load($dataPost) && $this->validate()) {
            $user = $this->getUser()
                    ->find()
                    ->where(['email' => $this->email])
                    ->one();

            if ($this->authValidate($user)) {
                Yii::$app->user->login($user, $this->remember ? 3600 * 24 * 30 : 0);
                $authAttrs = [
                    'name' => $user->attributes['name'],
                    'img'  => Avatar::getThumbnail(),
                ];

                $this->userDirExists();

                return ['success' => $authAttrs];
            }
        }

        return ['validation' => $this->validationErrors($models)];
    }

    protected function authValidate($user): bool
    {
        if ($user !== null && $user instanceof User && $user->validate()) {
            if (Yii::$app->security->validatePassword($this->password, $user->password)) {
                return true;
            }
        }
        $error = Yii::t('error/app', 'Неверный E-mail или пароль.');

        $this->addError('password', $error);
        $this->addError('email', $error);
        return false;
    }

    protected function userDirExists()
    {
        $dirName = Yii::getAlias('@webroot/avatar/' . md5(Yii::$app->user->identity->email));

        if (!file_exists($dirName)) {
            mkdir($dirName);
        }
    }

}
