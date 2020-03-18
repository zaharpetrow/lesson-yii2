<?php

namespace app\tests\unit\models;

use app\components\helpers\UrlHelper;
use app\models\auth\SignIn;
use app\models\profile\UploadAvatar;
use Codeception\Test\Unit;
use Yii;
use yii\web\UploadedFile;

/**
 * @property UploadAvatar $uploadAvatar
 */
class UploadAvatarTest extends Unit
{

    public $uploadAvatar;

    public function _before()
    {
        parent::_before();
        $this->uploadAvatar = new UploadAvatar();
    }

//    public function testUpload()
//    {
//        $signin = new SignIn();
//        $data   = [
//            basename($signin::className()) => [
//                'email'    => 'olegTT@gmail.com',
//                'password' => '1234Zz512',
//            ],
//        ];
//        $signin->run($data);
//
//        $userRoot   = UrlHelper::profileUserRoot();
//        $avatarRoot = UrlHelper::avatarUserRoot();
//        $this->assertFileExists($userRoot);
//        $this->assertFileExists($avatarRoot);
//
//        $image = new UploadedFile([
//            'name'     => 'test_image.jpg',
//            'tempName' => Yii::getAlias('@tests/unit/files/test_image.jpg'),
//            'type'     => 'image/jpeg',
//            'size'     => 225443,
//        ]);
//
//        $uploadAvatar = new UploadAvatar([
//            'imageFile' => $image
//        ]);
//
////        $uploadAvatar->imageFile = UploadedFile::getInstance($uploadAvatar, 'imageFile');
//
//        $uploadAvatar->upload();
//        $filePath = $avatarRoot . '/' . Yii::$app->user->identity->userOptions->img;
//        $this->assertFileExists($filePath);
//
//        unlink($filePath);
//        rmdir($avatarRoot);
//        rmdir($userRoot);
//        $this->assertFileNotExists($userRoot);
//        $this->assertFileNotExists($avatarRoot);
//        $this->assertFileNotExists($filePath);
//    }

}
