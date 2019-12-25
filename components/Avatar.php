<?php

namespace app\components;

use Yii;
use yii\helpers\Url;
use yii\imagine\Image;

class Avatar
{

    const DEFAULT_AVATAR = 'default-avatar.jpg';
    const PREFIX_THUMB   = 'thumb-';
    const THUMB_WIDTH   = 120;
    const THUMB_HEIGHT   = 120;

    public static function getThumbnail(): string
    {
        $imageName = static::getImage();
        $thumbName = static::PREFIX_THUMB . $imageName;
        $thumbPath = Yii::getAlias("@avatarRoot/$thumbName");

        if (!static::avatarExists($thumbName)) {
            static::createThumbnail($imageName, $thumbPath);
        }

        return Url::base(true) . "/avatar/$thumbName";
    }

    protected static function createThumbnail(string $imageName, string $filePath)
    {
        Image::thumbnail(Yii::getAlias("@avatarRoot/$imageName"), 
                static::THUMB_WIDTH, 
                static::THUMB_HEIGHT)
                ->save($filePath);
    }

    protected static function getImage(): string
    {
        $userImg   = Yii::$app->user->identity->img;
        $imageName = (static::avatarExists($userImg)) ?
                $userImg : static::DEFAULT_AVATAR;

        return $imageName;
    }

    protected static function avatarExists($filename)
    {
        $filePath = Yii::getAlias("@avatarRoot/$filename");
//        var_dump("!!!$filePath", $filename !== null, file_exists($filePath));
        if ($filename !== null && file_exists($filePath)) {
            return true;
        }

        $defaaultFilePath = Yii::getAlias("@avatarRoot/" . static::DEFAULT_AVATAR);
        IF (!file_exists($defaaultFilePath)) {
            $error = "Не найдены: аватар пользователя и аватар по умолчанию\n"
                    . "Аватар по умолчанию: $defaaultFilePath\n"
                    . "Аватар пользователя: $filePath";
            throw new \Exception($error);
        }


        return false;
    }

}
