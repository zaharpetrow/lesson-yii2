<?php

namespace common\widgets;

use common\models\profile\UploadAvatar;
use yii\base\Widget;

class UploadAvatarPopup extends Widget
{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $avatarModel = new UploadAvatar();
        $maxSize     = $avatarModel::MAX_SIZE_AVATAR;
        $mimeTypes   = json_encode($avatarModel::MIME_TYPES);
        return $this->render('popup', compact('avatarModel', 'maxSize', 'mimeTypes'));
    }

}
