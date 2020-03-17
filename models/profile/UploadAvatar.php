<?php

namespace app\models\profile;

use app\components\Avatar;
use app\components\helpers\UrlHelper;
use app\components\validators\UploadAvatarValidator;
use app\models\UserOptions;
use app\traits\AjaxValidationResponseTrait;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadAvatar extends Model
{

    use AjaxValidationResponseTrait;

    const MAX_SIZE_AVATAR = 5; //MB
    const MIME_TYPES      = ['image/jpeg', 'image/png'];

    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'required'],
            [
                ['imageFile'],
                'image',
                'skipOnEmpty' => false,
                'extensions'  => 'png, jpg, jpeg',
                'mimeTypes'   => implode(', ', static::MIME_TYPES),
            ],
            [
                ['imageFile'],
                'image',
                'maxSize' => static::MAX_SIZE_AVATAR * 1024 * 1024,
            ],
            [
                ['imageFile'],
                UploadAvatarValidator::className(),
                'maxSize'   => static::MAX_SIZE_AVATAR * 1024 * 1024,
                'mimeTypes' => static::MIME_TYPES,
            ],
        ];
    }

    public function upload(): array
    {
        if ($this->validate()) {
            $userOptions      = UserOptions::findOne(['user_id' => Yii::$app->user->id]);
            $fileName         = uniqid() . '.' . $this->imageFile->extension;
            $userOptions->img = $fileName;
            $userOptions->update();

            Yii::$app->user->identity->userOptions->img = $fileName;

            static::clearDir();
            $filePath = UrlHelper::avatarUserRoot() . '/' . $fileName;
            $this->imageFile->saveAs($filePath);
            Avatar::transformToSquareImage($filePath);


            return ['success' => true];
        }

        return ['validation' => $this->validationResponse()];
    }

    public static function clearDir()
    {
        $avatarRoot = UrlHelper::avatarUserRoot();
        $files      = array_diff(scandir($avatarRoot), ['.', '..']);

        foreach ($files as $file) {
            $filePath = "$avatarRoot/$file";
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }

}
