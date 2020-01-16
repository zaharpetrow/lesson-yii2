<?php

namespace app\components\helpers;

use app\models\User;
use Exception;
use Yii;
use yii\helpers\Url;

class UrlHelper extends Url
{

    const PROFILE_DIR_NAME = "user";

    public static function profileRoot()
    {
        return Yii::getAlias("@webroot/" . static::PROFILE_DIR_NAME);
    }

    public static function profileWeb()
    {
        return Yii::getAlias("@web/" . static::PROFILE_DIR_NAME);
    }

    public static function profileUserRoot()
    {
        if (Yii::$app->user->isGuest) {
            $error = "Метод " . __METHOD__
                    . " можно вызывать только "
                    . "для авторизованных пользователей.";
            throw new Exception($error);
        }

        return static::profileRoot() . '/' . Yii::$app->user->identity->userOptions->dir_name;
    }

    public static function createUserDirName(User $user)
    {
        return md5($user->id . $user->email);
    }

}
