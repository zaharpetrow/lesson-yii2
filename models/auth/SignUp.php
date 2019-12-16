<?php

namespace app\models\auth;

use app\models\User;
use Yii;

class SignUp extends Auth
{

    public $email;
    public $passwordRepeat;

    public function rules()
    {
        $rules = [
            [
                ['passwordRepeat'],
                'compare',
                'compareAttribute' => 'password',
                'message'          => 'Пароли должны совпадать',
            ],
            [
                ['email'],
                'string',
                'max'     => self::MAX_EMAIL,
                'tooLong' => Yii::t('error/app', 
                        "E-mail должен содержать максимум " . self::PLURAL_STR, 
                        ['count' => self::MAX_EMAIL]),
            ],
            [
                'email',
                'email',
                'message' => 'Введите валидный E-mail',
            ],
            [
                'email',
                'unique',
                'targetClass' => 'app\models\User',
                'message'     => Yii::t('app', 'Такой Email уже существует!'),
            ],
        ];

        return array_merge(parent::rules(), 
                $rules, 
                $this->createRequiredRules(['email', 'passwordRepeat']), 
                $this->createTrimRules($this->attributes()));
    }

    public function attributeLabels()
    {
        $attrLabels = [
            'email'          => Yii::t('app', 'E-mail'),
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
            $user->password = $this->passwordHash($this->password);
            if ($user->validate() && $user->save()) {
                return ['success' => true];
            }
            $models[] = $user;
        }
//        var_dump($this->attributes());die;
        return ['validation' => $this->validationErrors($models)];
    }

    protected function passwordHash($pass)
    {
        return Yii::$app->getSecurity()->generatePasswordHash($pass);
    }

}
