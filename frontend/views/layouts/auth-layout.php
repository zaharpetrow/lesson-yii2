<?php
/* @var $this \yii\web\View */
/* @var $content string */

use common\assets\AuthAsset;
use yii\helpers\Html;

AuthAsset::register($this);
$this->registerLinkTag([
    'rel'   => 'icon',
    'type'  => 'image/png',
    'sizes' => '32x32',
    'href'  => Yii::getAlias("@frontend/logo.png"),
]);

$this->title = Yii::$app->name . " | " . Yii::t('app', 'Аутентификация');
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags(); ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head(); ?>
    </head>
    <body>
        <?php $this->beginBody(); ?>
        <div class="container">
            <?= $content ?>

            <a id="refresh" value="Refresh" onClick="history.go()">
                <svg class="refreshicon"   version="1.1" id="Capa_1"  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     width="25px" height="25px" viewBox="0 0 322.447 322.447" style="enable-background:new 0 0 322.447 322.447;"
                     xml:space="preserve">
                <path  d="M321.832,230.327c-2.133-6.565-9.184-10.154-15.75-8.025l-16.254,5.281C299.785,206.991,305,184.347,305,161.224
                       c0-84.089-68.41-152.5-152.5-152.5C68.411,8.724,0,77.135,0,161.224s68.411,152.5,152.5,152.5c6.903,0,12.5-5.597,12.5-12.5
                       c0-6.902-5.597-12.5-12.5-12.5c-70.304,0-127.5-57.195-127.5-127.5c0-70.304,57.196-127.5,127.5-127.5
                       c70.305,0,127.5,57.196,127.5,127.5c0,19.372-4.371,38.337-12.723,55.568l-5.553-17.096c-2.133-6.564-9.186-10.156-15.75-8.025
                       c-6.566,2.134-10.16,9.186-8.027,15.751l14.74,45.368c1.715,5.283,6.615,8.642,11.885,8.642c1.279,0,2.582-0.198,3.865-0.614
                       l45.369-14.738C320.371,243.946,323.965,236.895,321.832,230.327z"/>
                </svg>
            </a>
        </div>
        <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage(); ?>