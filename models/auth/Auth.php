<?php

namespace app\models\auth;

use app\components\validators\PassValidator;
use Yii;
use yii\base\Model;
use yii\helpers\Html;

abstract class Auth extends Model
{

    const PLURAL_STR = '{count, number} {count, plural, one{символ} few{символа} many{символов} other{символа}}';
    const MIN_NAME   = 2;
    const MAX_NAME   = 20;
    const MIN_PASS   = 5;
    const MAX_EMAIL  = 50;

    public $email;
    public $password;

    public function rules()
    {
        $rules = [
            [
                ['email'],
                'string',
                'max'     => self::MAX_EMAIL,
                'tooLong' => Yii::t('error', 
                        "E-mail должен содержать максимум " . self::PLURAL_STR, 
                        ['count' => self::MAX_EMAIL]),
            ],
            [
                'email',
                'email',
                'message' => 'Введите валидный E-mail',
            ],
            [
                ['password'],
                'string',
                'min'      => self::MIN_PASS,
                'tooShort' => Yii::t('error', 
                        "Пароль должен содержать минимум " . self::PLURAL_STR, 
                        ['count' => self::MIN_PASS]),
            ],
            [
                ['password'],
                PassValidator::className(),
            ],
        ];

        return array_merge($this->createRequiredRules(['email', 'password']), 
                $this->createTrimRules(['email', 'password']), 
                $rules);
    }

    public function attributeLabels()
    {
        return [
            'email'    => Yii::t('app', 'E-mail'),
            'password' => Yii::t('app', 'Пароль'),
        ];
    }

    protected function createRequiredRules(array $required = []): array
    {
        $resultArray = [];

        foreach ($required as $item) {
            $attrLabel     = $this->attributeLabels()[$item];
            $requiredItem  = (isset($attrLabel)) ? mb_strtolower($attrLabel) : $item;
            $resultArray[] = [
                [$item],
                'required',
                'message' => Yii::t('error', "Пожалуйста, введите $requiredItem")
            ];
        }

        return $resultArray;
    }

    protected function createTrimRules(array $itens = []): array
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

    abstract public function run(array $dataPost): array;
}
