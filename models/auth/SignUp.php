<?php

namespace app\models\auth;

use app\components\VerifyAccount;
use Yii;
use app\models\User;

class SignUp extends Auth
{

    public $name;
    public $passwordRepeat;

    public function rules()
    {
        $rules = [
            [
                ['name'],
                'string',
                'min'      => self::MIN_NAME,
                'max'      => self::MAX_NAME,
                'tooShort' => Yii::t('error', 
                        "Имя должно содержать минимум " . self::PLURAL_STR, 
                        ['count' => self::MIN_NAME]),
                'tooLong'  => Yii::t('error', 
                        "Имя должно содержать максимум " . self::PLURAL_STR, 
                        ['count' => self::MAX_NAME]),
            ],
            [
                ['name'],
                'match',
                'pattern' => '/^[а-яa-z0-9_-]+$/iu',
                'message' => Yii::t('error', 
                        'Имя может содержать символы нижнего и верхнего регистра a-z, а-я, 0-9, -_'),
            ],
            [
                ['passwordRepeat'],
                'compare',
                'compareAttribute' => 'password',
                'message'          => 'Пароли не совпадают',
            ],
            [
                'email',
                'unique',
                'targetClass' => 'app\models\User',
                'message'     => Yii::t('error', 'Такой Email уже существует!'),
            ],
        ];

        return array_merge(parent::rules(), 
                $rules, 
                $this->createRequiredRules(['name', 'passwordRepeat']), 
                $this->createTrimRules($this->attributes()));
    }

    public function attributeLabels()
    {
        $attrLabels = [
            'name'          => Yii::t('app', 'Имя'),
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
                VerifyAccount::sendVerifyMail($this->email);
                return ['success' => true];
            }

            $models[] = $user;
        }

        return ['validation' => $this->validationErrors($models)];
    }

    protected function passwordHash($pass)
    {
        return Yii::$app->getSecurity()->generatePasswordHash($pass);
    }

}
