<?php

namespace app\models\auth;

class SignIn extends Auth
{

    public $remember;

    public function rules()
    {
        $rules = [
            [['remember'], 'boolean',]
        ];

        return array_merge(parent::rules(), $rules);
    }

    public function run(array $dataPost):array
    {
        return [];
    }
}
