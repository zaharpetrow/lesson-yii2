<?php

namespace app\components\behaviors;

use app\components\helpers\UrlHelper;
use app\models\auth\SignIn;
use yii\base\Behavior;

class AuthBehavior extends Behavior
{

    public function events()
    {
        return [
            SignIn::EVENT_AFTER_SIGN_IN => 'userDirExists',
        ];
    }

    public function userDirExists()
    {
        $dirName = UrlHelper::profileUserRoot();

        if (!file_exists($dirName)) {
            mkdir($dirName);
        }
    }

}
