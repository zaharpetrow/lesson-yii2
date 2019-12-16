<?php

namespace app\models\auth;

use Yii;
use yii\base\Model;
use yii\helpers\Html;

abstract class Auth extends Model
{

    const PLURAL_STR = '{count, number} {count, plural, one{символ} few{символа} many{символов} other{символа}}';
    const MIN_NAME   = 2;
    const MAX_NAME   = 20;
    const MIN_PASS   = 5;
    const MAX_PASS   = 20;
    const MAX_EMAIL  = 50;

    public $name;
    public $password;
    protected $passPatterns = [
        '/^[A-ZА-Я]$/u',
        '/^[a-zа-я]$/u',
        '/^[0-9]$/u',
    ];

    public function rules()
    {
        $rules = [
            [
                ['name'],
                'string',
                'min'      => self::MIN_NAME,
                'max'      => self::MAX_NAME,
                'tooShort' => Yii::t('error/app', 
                        "Имя должно содержать минимум " . self::PLURAL_STR, 
                        ['count' => self::MIN_NAME]),
                'tooLong'  => Yii::t('error/app', 
                        "Имя должно содержать максимум " . self::PLURAL_STR, 
                        ['count' => self::MAX_NAME]),
            ],
            [
                ['name'],
                'match',
                'pattern' => '/^[а-яa-z0-9_-]+$/iu',
                'message' => Yii::t('error/app', 
                        'Имя может содержать символы нижнего и верхнего регистра a-z, а-я, 0-9, -_'),
            ],
            [
                ['password'],
                'string',
                'min'      => self::MIN_PASS,
                'tooShort' => Yii::t('error/app', 
                        "Пароль должен содержать минимум " . self::PLURAL_STR, 
                        ['count' => self::MIN_PASS]),
            ],
            [
                ['password'],
                'validatePassword',
                'message' => Yii::t('error/app', 'Error'),
            ],
        ];

        return array_merge($this->createRequiredRules(['name', 'password']), 
                $this->createTrimRules(['name', 'password']), 
                $rules);
    }

    public function attributeLabels()
    {
        return [
            'name'     => Yii::t('app', 'Имя'),
            'password' => Yii::t('app', 'Пароль'),
        ];
    }

    public function createRequiredRules(array $required = []): array
    {
        $resultArray = [];

        foreach ($required as $item) {
            $attrLabel     = $this->attributeLabels()[$item];
            $requiredItem  = (isset($attrLabel)) ? mb_strtolower($attrLabel) : $item;
            $resultArray[] = [
                [$item],
                'required',
                'message' => Yii::t('error/app', "Пожалуйста, введите $requiredItem")
            ];
        }

        return $resultArray;
    }

    public function createTrimRules(array $itens = []): array
    {
        $resultArray = [];

        foreach ($itens as $item) {
            $resultArray[] = [[$item], 'trim'];
        }

        return $resultArray;
    }

    /**
     * Кастомный ActiveForm::validate()
     * 
     * Метод собирает ошибки, полученные методом Model::validate(),<br> 
     * этой модели и моделей перечисленных в массиве $models <br>
     * и выдает их за ошибки этой модели для обновления полей посредством AJAX
     * 
     * @param array $models Массив должен содержать реализации yii\db\ActiveRecord и/или yii\base\Model
     * @return array Ошибки этой модели и моделей $models
     */
    protected function validationErrors(array $models = []): array
    {
        $models[] = $this;
        $result   = [];

        foreach ($models as $model) {
            foreach ($model->getErrors() as $attribute => $errors) {
                $result[Html::getInputId($this, $attribute)] = $errors;
            }
        }

        return $result;
    }

    public function validatePassword($attribute, $params)
    {
//        var_dump($attribute, $params);
        $msg = 'Пароль должен содержать хотя бы одну: '
                . 'заглавную и прописную букву латинского или киррилического алфавита, а так же цифру';
        foreach ($this->passPatterns as $pattern) {
            if (!preg_match($pattern, $this->$attribute)) {
                $this->addError($attribute, $msg);
            }
        }
    }

    abstract public function run(array $dataPost):array;

}
