<?php

namespace app\components;

use Yii;
use yii\helpers\Url;
use yii\imagine\Image;

class Avatar
{

    const DEFAULT_AVATAR = 'default-avatar.jpg';
    
    const XS_ICON = [
        'prefix' => 'xs-icon-',
        'height' => 35,
        'width'  => 35,
    ];
    const THUMB   = [
        'prefix' => 'thumb-',
        'height' => 120,
        'width'  => 120,
    ];

    public static function getIconXS(): string
    {
        return static::getIcon(static::XS_ICON);
    }

    public static function getThumbnail(): string
    {

        return static::getIcon(static::THUMB);
    }

    protected static function getIcon(array $iconOptions): string
    {
        $imageName = static::getImage();
        $iconName  = $iconOptions['prefix'] . $imageName;
        $iconPath  = static::createPath($iconName);

        if (!static::avatarExists($iconName)) {
            static::createIcon([
                'imageName' => $imageName,
                'filePath'  => $iconPath,
                'width'     => $iconOptions['width'],
                'height'    => $iconOptions['height'],
            ]);
        }

        return Url::base(true) . "/avatar/$iconName";
    }

    protected static function createIcon(array $options)
    {
        Image::thumbnail(
                static::createPath($options['imageName']), 
                $options['width'], 
                $options['height']
                )
                ->save($options['filePath']);
    }

    protected static function getImage(): string
    {
        $userImg   = Yii::$app->user->identity->img;
        $imageName = ($userImg) ? $userImg : static::DEFAULT_AVATAR;

        return $imageName;
    }

    protected static function avatarExists(string $filename)
    {
        $filePath = static::createPath($filename);

        if ($filename !== null && file_exists($filePath)) {
            return true;
        }

        $defaaultFilePath = static::createPath(static::DEFAULT_AVATAR);
        IF (!file_exists($defaaultFilePath)) {
            $error = "Не найдены: аватар пользователя и аватар по умолчанию\n"
                    . "Аватар по умолчанию: $defaaultFilePath\n"
                    . "Аватар пользователя: $filePath";
            throw new \Exception($error);
        }


        return false;
    }

    protected static function createPath(string $fileName): string
    {
        return Yii::getAlias("@avatarRoot/$fileName");
    }

}
