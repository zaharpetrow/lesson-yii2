<?php

use app\components\Avatar;

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Yii приложение');
?>
<?php if (!Yii::$app->user->isGuest): ?>
    <img src="<?= Avatar::getThumbnail() ?>" alt="">
<?php endif; ?>