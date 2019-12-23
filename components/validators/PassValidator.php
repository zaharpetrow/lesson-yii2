<?php

namespace app\components\validators;

use Yii;
use yii\validators\Validator;

class PassValidator extends Validator
{

    public $passPatterns = [
        '/[A-ZА-Я]/u',
        '/[a-zа-я]/u',
        '/[0-9]/u',
    ];
    public $message;

    public function validateAttribute($model, $attribute)
    {
        $message = $this->getMessage();
        foreach ($this->passPatterns as $pattern) {
            if (!preg_match($pattern, $model->$attribute)) {
                $model->addError($attribute, $message);
                break;
            }
        }
    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
        $passPatterns = $this->passPatterns;
        foreach ($passPatterns as $key => $pattern) {
            $passPatterns[$key] = preg_replace('/u$/', '', $pattern);
        }
        $message      = $this->json_encode($this->getMessage());
        $passPatterns = $this->json_encode($passPatterns);

        return <<<JS
        $.each($passPatterns, function (i, e) {
            if ((value.match(e) || {}).length < 1) {
                messages.push($message);
            }
        });
JS;
    }

    protected function getMessage()
    {
        return ($this->message) ? $this->message : Yii::t('app', 'Пароль должен содержать хотя бы один: '
                        . 'заглавный и прописной символ латинского или киррилического алфавита, а так же цифру');
    }

    protected function json_encode($value)
    {
        return json_encode($value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

}
