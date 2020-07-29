<?php

namespace common\models\auth;

use common\components\helpers\UrlHelper;
use common\components\validators\ValidateRules;
use common\models\User;
use common\models\UserOptions;
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

    public $user;
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
            [['email', 'password'], 'string'],
        ];

        return array_merge(
                ValidateRules::createRequiredRules($this->attributeLabels(), ['email', 'password']), 
                ValidateRules::createTrimRules(['email', 'password']), 
                ValidateRules::getPasswordRules(), 
                $rules
                );
    }

    public function attributeLabels()
    {
        return [
            'email'    => Yii::t('app', 'E-mail'),
            'password' => Yii::t('app', 'Пароль'),
        ];
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

    protected function checkUserOptions(User $user)
    {
        $userOptions = UserOptions::findOne(['user_id' => $user->id]);

        if (!$userOptions) {
            $userOptions          = new UserOptions();
            $userOptions->user_id = $user->id;
            $userOptions->save();
        }

        if (!$userOptions->dir_name) {
            $newDirName            = UrlHelper::createUserDirName($user);
            $userOptions->dir_name = $newDirName;
            $userOptions->save();
        }
    }

    abstract public function run(array $dataPost): array;
}
