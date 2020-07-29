<?php

namespace common\assets;

use yii\web\AssetBundle;

class AngularAsset extends AssetBundle
{

    public $sourcePath = null;
    public $js         = [
        'https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.7.8/angular-animate.min.js',
    ];

}
