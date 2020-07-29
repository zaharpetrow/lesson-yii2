<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl  = '@web';
    public $css      = [
        'asset-profile/css/fontawesome.min.css',
        'asset-profile/css/bootstrap.min.css',
        'asset-profile/css/templatemo-style.css',
        'css/site.css',
        'css/mycss.css',
    ];
    public $js       = [
//        'profile-asset/js/moment.min.js',
//        'profile-asset/js/Chart.min.js',
        'asset-profile/js/bootstrap.min.js',
//        'profile-asset/js/tooplate-scripts.js',
        'js/main.js',
    ];
    public $depends  = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
