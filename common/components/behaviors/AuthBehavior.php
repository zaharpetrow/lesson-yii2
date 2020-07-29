<?php

namespace common\components\behaviors;

use common\components\helpers\UrlHelper;
use common\models\auth\SignIn;
use yii\base\Behavior;

class AuthBehavior extends Behavior
{

    public function events()
    {
        return [
            SignIn::EVENT_AFTER_SIGN_IN => 'afterSignIn',
        ];
    }

    public function afterSignIn()
    {
        $this->userDirectoriesExists();
    }

    public function userDirectoriesExists()
    {
        $this->checkFiles([
            UrlHelper::profileUserRoot(),
            UrlHelper::avatarUserRoot(),
        ]);
    }

    protected function checkFiles(array $files)
    {
        foreach ($files as $file) {
            if (!file_exists($file)) {
                mkdir($file);
            }
        }
    }

}
