<?php

namespace common\assets;

use yii\web\AssetBundle;

class AuthAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl  = '@web';
    public $css      = [
        'asset-auth/css/auth-style.css',
    ];
    public $js       = [
        'asset-auth/js/auth-script.js',
    ];
    public $depends  = [
        'common\assets\AppAsset',
        'common\assets\AngularAsset',
    ];

}
