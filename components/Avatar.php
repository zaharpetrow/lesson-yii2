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
    const L_ICON = [
        'prefix' => 'l-icon-',
        'height' => 350,
        'width'  => 350,
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

    public static function getIconL(): string
    {
        return static::getIcon(static::L_ICON);
    }

    public static function getThumbnail(): string
    {

        return static::getIcon(static::THUMB);
    }

    protected static function getIcon(array $iconOptions): string
    {
        $imageName = static::getImage();
        $iconName  = $iconOptions['prefix'] . $imageName;
        $iconPath  = static::getPath($iconName);

        if (!static::avatarExists($iconPath)) {
            static::createIcon([
                'imageName' => $imageName,
                'filePath'  => $iconPath,
                'width'     => $iconOptions['width'],
                'height'    => $iconOptions['height'],
            ]);
        }

        return static::getWebPath($iconName);
    }

    protected static function getWebPath(string $iconName): string
    {
        $basePath = Url::base(true) . "/avatar";
        if (static::userImageExists()) {
            return "$basePath/" . md5(Yii::$app->user->identity->email) . "/$iconName";
        }
        return "$basePath/$iconName";
    }

    protected static function createIcon(array $options)
    {
        Image::thumbnail(
                static::getPath($options['imageName']), 
                $options['width'], 
                $options['height']
                )
                ->save($options['filePath']);
    }

    protected static function getImage(): string
    {
        $imageName = (static::userImageExists()) ?
                Yii::$app->user->identity->img : static::DEFAULT_AVATAR;

        return $imageName;
    }

    protected static function userImageExists(): bool
    {
        if (Yii::$app->user->identity->img !== null) {
            return true;
        }
        return false;
    }

    protected static function avatarExists(string $filePath)
    {
        if (file_exists($filePath)) {
            return true;
        }

        $defaultFilePath = static::getPath(static::DEFAULT_AVATAR);
        if (!file_exists($defaultFilePath)) {
            $error = "Не найдены: аватар пользователя и аватар по умолчанию\n"
                    . "Аватар по умолчанию: $defaultFilePath\n"
                    . "Аватар пользователя: $filePath";
            throw new \Exception($error);
        }


        return false;
    }

    protected static function getPath(string $fileName): string
    {
        $avatarRoot = Yii::getAlias("@avatarRoot");

        if (static::userImageExists()) {
            return "$avatarRoot/" . md5(Yii::$app->user->identity->email) . "/$fileName";
        }
        return Yii::getAlias("@avatarRoot/$fileName");
    }

}
