<?php
/* @var $this \yii\web\View */
/* @var $content string */
/* @var $modelSignIn app\models\auth\SignIn */
/* @var $modelSignUp app\models\auth\SignUp */

use yii\helpers\Html;
use app\assets\AuthAsset;
use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

AuthAsset::register($this);

$this->title = Yii::t('app', 'Аутентификация');

$this->params['breadcrumbs'][] = $this->title;
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
        <?=
        Breadcrumbs::widget([
            'homeLink' => [
                'label' => Yii::t('app', 'Главная'),
                'url'   => Yii::$app->homeUrl,
            ],
            'links'    => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ])
        ?>
        <div class="container">
            <div class="frame">
                <div class="nav">
                    <ul class="links">
                        <li class="sign signin sign-active"><a class="btn active"><?= Yii::t('app', 'Войти') ?></a></li>
                        <li class="sign signup"><a class="btn"><?= Yii::t('app', 'Регистрация') ?></a></li>
                    </ul>
                </div>
                <div ng-app ng-init="checked = false">
                    <?php
                    $formSignIn                    = ActiveForm::begin([
                                'options' => [
                                    'class' => 'form-signin',
                                    'name'  => 'form',
                                ],
                    ]);
                    ?>
                    <?=
                            $formSignIn->field($modelSignIn, 'name')
                            ->textInput(['class' => 'form-styling', 'value' => 'Вася'])
                            ->label(Yii::t('app', 'Ваше имя'))->error(['class' => 'help-block hidden'])
                    ?>
                    <?=
                            $formSignIn->field($modelSignIn, 'password')
                            ->passwordInput(['class' => 'form-styling', 'value' => '22222'])
                            ->label(Yii::t('app', 'Пароль'))->error(['class' => 'help-block hidden'])
                    ?>
                    <?=
                            $formSignIn->field($modelSignIn, 'remember', [
                                'template' => '{input}<label for="checkbox"><span class="ui"></span>' . Yii::t('app', 'Запомнить меня') . '</label>{hint}{error}'
                            ])
                            ->checkbox(['id' => 'checkbox'], false)->error(['class' => 'help-block hidden'])
                    ?>
                    <div class="btn-animate">
                        <?= Html::submitButton(Yii::t('app', 'Войти'), ['class' => 'btn-signin']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                    <?php
                    $formSignUp                    = ActiveForm::begin([
                                'options' => [
                                    'class' => 'form-signup',
                                    'name'  => 'form',
                                ],
                    ]);
                    ?>
                    <?=
                            $formSignUp->field($modelSignUp, 'name')
                            ->textInput(['class' => 'form-styling', 'value' => 'Вася'])
                            ->label(Yii::t('app', 'Ваше имя'))->error(['class' => 'help-block hidden'])
                    ?>
                    <?=
                            $formSignUp->field($modelSignUp, 'email')
                            ->textInput(['class' => 'form-styling', 'value' => 'vasya@gmail.com'])
                            ->label(Yii::t('app', 'E-mail'))->error(['class' => 'help-block hidden'])
                    ?>
                    <?=
                            $formSignUp->field($modelSignUp, 'password')
                            ->passwordInput(['class' => 'form-styling', 'value' => '22222'])
                            ->label(Yii::t('app', 'Пароль'))->error(['class' => 'help-block hidden'])
                    ?>
                    <?=
                            $formSignUp->field($modelSignUp, 'passwordRepeat')
                            ->passwordInput(['class' => 'form-styling', 'value' => '22222'])
                            ->label(Yii::t('app', 'Подтверждение пароля'))->error(['class' => 'help-block hidden'])
                    ?>
                    <?= Html::submitButton('Регистрация', ['ng-click' => 'checked = !checked', 'class' => 'btn-signup']) ?>

                    <?php ActiveForm::end(); ?>
                    <div  class="success">
                        <svg width="270" height="270" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 60 60" id="check" ng-class="checked ? 'checked' : ''">
                        <path fill="#ffffff" d="M40.61,23.03L26.67,36.97L13.495,23.788c-1.146-1.147-1.359-2.936-0.504-4.314
                              c3.894-6.28,11.169-10.243,19.283-9.348c9.258,1.021,16.694,8.542,17.622,17.81c1.232,12.295-8.683,22.607-20.849,22.042
                              c-9.9-0.46-18.128-8.344-18.972-18.218c-0.292-3.416,0.276-6.673,1.51-9.578" />
                        <div class="successtext">
                            <p><?= Yii::t('app', 'Регистрация прошла успешно! Проверьте свою почту, чтобы активировать аккаунт!') ?></p>
                        </div>
                    </div>
                </div>

                <div class="forgot">
                    <a href="#"><?= Yii::t('app', 'Забыли пароль?') ?></a>
                </div>

                <div>
                    <div class="cover-photo"></div>
                    <div class="profile-photo"></div>
                    <h1 class="welcome"><?= Yii::t('app', 'Добро пожаловать') ?>
                        <div class="username">Chris</div>
                    </h1>
                    <a class="btn-goback" value="Refresh" onClick="history.go()"><?= Yii::t('app', 'На главную') ?></a>
                </div>
            </div>

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