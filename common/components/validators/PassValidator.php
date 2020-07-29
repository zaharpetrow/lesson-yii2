<?php

namespace common\components\validators;

use Yii;
use yii\validators\Validator;

class PassValidator extends Validator
{

    public $passPatterns = [
        '[A-ZА-Я]',
        '[a-zа-я]',
        '[0-9]',
    ];
    public $message;

    public function validateAttribute($model, $attribute)
    {
        $message = $this->getMessage();
        foreach ($this->passPatterns as $pattern) {
            if (!preg_match("~$pattern~u", $model->$attribute)) {
                $model->addError($attribute, $message);
                break;
            }
        }
    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
        $message      = $this->json_encode($this->getMessage());
        $passPatterns = $this->json_encode($this->passPatterns);

        return <<<JS
        if(value.length > 0){
            $.each($passPatterns, function (i, e) {
                    e = new RegExp(e);
                if (value.search(e) === -1) {
                    messages.push($message);
                }
            });
        }
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
