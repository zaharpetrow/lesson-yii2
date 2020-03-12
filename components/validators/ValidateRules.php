<?php

namespace app\components\validators;

use app\models\auth\Auth;
use app\models\auth\SignUp;
use app\models\profile\ProfileData;
use Yii;

class ValidateRules
{

    public static function getSignUpRules(): array
    {
        $signup = new SignUp();

        $rules = [
            [
                'email',
                'unique',
                'targetClass' => 'app\models\User',
                'message'     => Yii::t('error', 'Такой Email уже существует!'),
            ],
        ];

        return array_merge(
                ValidateRules::getNameRules(),
                $rules,
                ValidateRules::getPasswordRepeatRules(),
                ValidateRules::createRequiredRules($signup->attributeLabels(), ['name', 'passwordRepeat']),
                ValidateRules::createTrimRules($signup->attributes()));
    }

    public static function getSignInRules(): array
    {
        $rules = [
            [['remember'], 'boolean']
        ];

        return $rules;
    }

    public static function getUpdateProfileRules(): array
    {
        $profileData = new ProfileData();

        return array_merge(
                ValidateRules::getNameRules(),
                ValidateRules::getPasswordRules(),
                ValidateRules::getPasswordRepeatRules(),
                ValidateRules::createTrimRules($profileData->attributes())
                );
    }

    public static function getNameRules(): array
    {
        return [
            [
                ['name'],
                'string',
                'min'      => Auth::MIN_NAME,
                'max'      => Auth::MAX_NAME,
                'tooShort' => Yii::t('error', "Имя должно содержать минимум "
                        . Auth::PLURAL_STR, ['count' => Auth::MIN_NAME]),
                'tooLong'  => Yii::t('error', "Имя должно содержать максимум "
                        . Auth::PLURAL_STR, ['count' => Auth::MAX_NAME]),
            ],
            [
                ['name'],
                'match',
                'pattern' => '/^[а-яa-z0-9_-]+$/iu',
                'message' => Yii::t('error', 'Имя может содержать символы '
                        . 'нижнего и верхнего регистра a-z, а-я, 0-9, -_'),
            ],
        ];
    }

    public static function getPasswordRules(): array
    {
        return [
            [
                ['password'],
                'string',
                'min'      => Auth::MIN_PASS,
                'tooShort' => Yii::t('error', "Пароль должен содержать минимум "
                        . Auth::PLURAL_STR, ['count' => Auth::MIN_PASS]),
            ],
            [
                ['password'],
                PassValidator::className(),
            ],
        ];
    }

    public static function getPasswordRepeatRules(): array
    {
        return [
            [
                ['passwordRepeat'],
                'compare',
                'compareAttribute' => 'password',
                'message'          => 'Пароли не совпадают',
                'skipOnEmpty'      => false,
            ],
        ];
    }

    public static function createTrimRules(array $items = []): array
    {
        $resultArray = [];

        foreach ($items as $item) {
            $resultArray[] = [[$item], 'trim'];
        }

        return $resultArray;
    }

    public static function createRequiredRules(array $attributeLabels, array $required = []): array
    {
        $resultArray = [];

        foreach ($required as $item) {
            $attrLabel     = $attributeLabels[$item];
            $requiredItem  = (isset($attrLabel)) ? mb_strtolower($attrLabel) : $item;
            $resultArray[] = [
                [$item],
                'required',
                'message' => Yii::t('error', "Пожалуйста, введите $requiredItem")
            ];
        }

        return $resultArray;
    }

}
