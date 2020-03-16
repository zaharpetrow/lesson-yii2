<?php

namespace app\components;

use app\components\helpers\UrlHelper;
use Exception;
use Imagine\Image\Box;
use Yii;
use yii\imagine\Image;

class Avatar
{

    const DEFAULT_AVATAR = 'default-avatar.jpg';
    const XS_ICON        = [
        'prefix' => 'xs-icon-',
        'height' => 35,
        'width'  => 35,
    ];
    const L_ICON         = [
        'prefix' => 'l-icon-',
        'height' => 350,
        'width'  => 350,
    ];
    const THUMB          = [
        'prefix' => 'thumb-',
        'height' => 120,
        'width'  => 120,
    ];

    protected static $options = [
        'imgName'   => '',
        'pathToImg' => '',
        'urlToImg'  => '',
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

    public static function transformToSquareImage(string $filePath)
    {
        $img  = Image::getImagine()->open($filePath);
        $size = $img->getSize();

        if ($size->getHeight() > $size->getWidth()) {
            $squareSide = $size->getWidth();
        } else {
            $squareSide = $size->getHeight();
        }

        Image::thumbnail($filePath, $squareSide, $squareSide)->save($filePath);
    }

    protected static function getIcon(array $iconOptions): string
    {
        $dataImg   = static::getDataImg();
        $imageName = $dataImg['imgName'];
        $iconName  = $iconOptions['prefix'] . $imageName;
        $iconPath  = $dataImg['pathToImg'] . "/$iconName";

        if (!static::iconExists($iconPath)) {
            static::createIcon([
                'imagePath'   => $dataImg['pathToImg'] . "/$imageName",
                'newFilePath' => $iconPath,
                'width'       => $iconOptions['width'],
                'height'      => $iconOptions['height'],
            ]);
        }

        return $dataImg['urlToImg'] . "/$iconName";
    }

    protected function getDataImg(): array
    {
        if (Yii::$app->user->isGuest) {
            throw new UnauthorizedHttpException('Пользователь не авторизован');
        }

        if (static::userImageExists()) {
            static::$options['imgName']   = Yii::$app->user->identity->userOptions->img;
            static::$options['pathToImg'] = UrlHelper::avatarUserRoot();
            static::$options['urlToImg']  = UrlHelper::avatarUserWeb();
        } else {
            static::$options['imgName']   = static::DEFAULT_AVATAR;
            static::$options['pathToImg'] = UrlHelper::profileRoot();
            static::$options['urlToImg']  = UrlHelper::profileWeb();
        }

        return static::$options;
    }

    protected static function createIcon(array $options)
    {
        $img = Image::getImagine()->open($options['imagePath']);
        $box = new Box($options['width'], $options['height']);
        $img->resize($box)->save($options['newFilePath']);
    }

    protected static function userImageExists(): bool
    {
        $imageName         = Yii::$app->user->identity->userOptions->img;
        $defaultAvatarPath = UrlHelper::profileRoot() . "/" . static::DEFAULT_AVATAR;

        if (!file_exists($defaultAvatarPath)) {
            $error = "Не найден аватар по умолчанию: $defaultAvatarPath";
            throw new Exception($error);
        }

        if ($imageName !== null &&
                file_exists(UrlHelper::avatarUserRoot() . "/$imageName")) {
            return true;
        }
        return false;
    }

    protected static function iconExists(string $filePath)
    {
        if (file_exists($filePath)) {
            return true;
        }
        return false;
    }

}
