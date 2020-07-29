<?php
/* @var $this \yii\web\View */
/* @var $modelSignIn app\models\auth\SignIn */
/* @var $modelSignUp app\models\auth\SignUp */

use common\components\helpers\UrlHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="frame">
    <div class="nav">
        <ul class="links">
            <li class="sign signin sign-active"><a class="btn active"><?= Yii::t('app', 'Войти') ?></a></li>
            <li class="sign signup"><a class="btn"><?= Yii::t('app', 'Регистрация') ?></a></li>
        </ul>
    </div>
    <div ng-app ng-init="checked = false">
        <?php
        $formSignIn = ActiveForm::begin([
                    'options' => [
                        'class' => 'form-signin',
                        'name'  => 'form',
                    ],
        ]);
        ?>
        <?=
                $formSignIn->field($modelSignIn, 'email')
                ->textInput(['class' => 'form-styling', 'value' => 'gregory@gmail.com'])
                ->label(Yii::t('app', 'E-mail'))->error(['class' => 'help-block hidden'])
        ?>
        <?=
                $formSignIn->field($modelSignIn, 'password')
                ->passwordInput(['class' => 'form-styling', 'value' => '1234Zz512'])
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
        $formSignUp = ActiveForm::begin([
                    'options' => [
                        'class' => 'form-signup',
                        'name'  => 'form',
                    ],
        ]);
        ?>
        <?=
                $formSignUp->field($modelSignUp, 'name')
                ->textInput(['class' => 'form-styling', 'value' => 'Gregory'])
                ->label(Yii::t('app', 'Ваше имя'))->error(['class' => 'help-block hidden'])
        ?>
        <?=
                $formSignUp->field($modelSignUp, 'email')
                ->textInput(['class' => 'form-styling', 'value' => 'gregory@gmail.com'])
                ->label(Yii::t('app', 'E-mail'))->error(['class' => 'help-block hidden'])
        ?>
        <?=
                $formSignUp->field($modelSignUp, 'password')
                ->passwordInput(['class' => 'form-styling', 'value' => '11111zZ'])
                ->label(Yii::t('app', 'Пароль'))->error(['class' => 'help-block hidden'])
        ?>
        <?=
                $formSignUp->field($modelSignUp, 'passwordRepeat')
                ->passwordInput(['class' => 'form-styling', 'value' => '11111zZ'])
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
        <a href="<?= UrlHelper::to(['site/recovery']) ?>"><?= Yii::t('app', 'Забыли пароль?') ?></a>
    </div>

    <div>
        <div class="cover-photo"></div>
        <div class="profile-photo"></div>
        <h1 class="welcome"><?= Yii::t('app', 'Добро пожаловать') ?>
            <div class="username"></div>
        </h1>
        <a href="<?= UrlHelper::home() ?>" class="btn-goback"><?= Yii::t('app', 'На главную') ?></a>
    </div>
</div>