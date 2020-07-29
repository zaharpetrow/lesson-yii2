<?php

namespace common\components\helpers;

use common\models\User;
use Yii;
use yii\helpers\Url;
use yii\web\UnauthorizedHttpException;

class UrlHelper extends Url
{

    const PROFILE_DIR_NAME = "user";
    const AVATAR_DIR_NAME  = "avatar";

    public static function profileRoot(): string
    {
        return Yii::getAlias("@frontend/web/" . static::PROFILE_DIR_NAME);
    }

    public static function profileWeb(): string
    {
        return Yii::getAlias("@web/" . static::PROFILE_DIR_NAME);
    }

    public static function profileUserRoot(): string
    {
        return static::profileRoot() . '/' . static::getUserDirName();
    }

    public static function profileUserWeb(): string
    {
        return static::profileWeb() . '/' . static::getUserDirName();
    }

    public static function avatarUserRoot(): string
    {
        return static::profileUserRoot() . '/' . static::AVATAR_DIR_NAME;
    }

    public static function avatarUserWeb(): string
    {
        return static::profileUserWeb() . '/' . static::AVATAR_DIR_NAME;
    }

    public static function createUserDirName(User $user): string
    {
        return md5($user->id . $user->email);
    }

    protected static function getUserDirName(): string
    {
        if (Yii::$app->user->isGuest) {
            throw new UnauthorizedHttpException('Пользователь не авторизован');
        }

        return Yii::$app->user->identity->userOptions->dir_name;
    }

}
