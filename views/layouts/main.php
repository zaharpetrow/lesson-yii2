<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

Yii::$app->name = 'Приложение';
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="wrap">
            <?php
            NavBar::begin([
                'brandLabel' => Yii::$app->name,
                'brandUrl'   => Yii::$app->homeUrl,
                'options'    => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items'   => [
                    ['label' => Yii::t('menu', 'Главная'), 'url' => Yii::$app->homeUrl],
                    ['label' => Yii::t('menu', 'Страны'), 'items' => [
                            ['label' => 'index', 'url' => ['/country/index']],
                            ['label' => 'text-block', 'url' => ['/country/with-text']],
                        ]],
                    ['label' => Yii::t('menu', 'Триугольные числа'), 'url' => ['/triangular/index']],
                    ['label' => 'Entry', 'url' => ['/site/entry']],
                    ['label' => Yii::t('menu', 'Авторизация'), 'url' => ['/site/auth']],
                    ['label' => 'Login', 'url' => ['/site/login']],
                ],
            ]);
            NavBar::end();
            ?>

            <div class="container">
                <?=
                Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

                <p class="pull-right"><?= Yii::powered() ?></p>
            </div>
        </footer>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
