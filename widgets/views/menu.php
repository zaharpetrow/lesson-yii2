<?php

use yii\bootstrap\NavBar;
use yii\widgets\Menu;

/* @var $this \yii\web\View */
?>

<?php

NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl'   => Yii::$app->homeUrl,
    'options'    => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);
echo Menu::widget([
    'options'         => ['class' => 'navbar-nav navbar-right nav'],
    'submenuTemplate' => "\n<ul class='dropdown-menu' role='menu'>\n{items}\n</ul>\n",
    'items'           => [
        ['label' => Yii::t('menu', 'Главная'), 'url' => Yii::$app->homeUrl],
        ['label'    => Yii::t('menu', 'Страны'),
            'options'  => ['class' => 'dropdown'],
            'template' => '<a href="#" data-toggle="dropdown">{label}</a>',
            'items'    => [
                ['label' => 'index', 'url' => ['/country/index']],
                ['label' => 'text-block', 'url' => ['/country/with-text']],
            ]],
        ['label' => Yii::t('menu', 'Триугольные числа'), 'url' => ['/triangular/index']],
        ['label' => 'Entry', 'url' => ['/site/entry']],
        Yii::$app->user->isGuest ? (
                ['label' => Yii::t('menu', 'Авторизация'), 'url' => ['/site/auth']]
                ) : (
                $profileMenuItem
                )
    ],
]);
NavBar::end();
