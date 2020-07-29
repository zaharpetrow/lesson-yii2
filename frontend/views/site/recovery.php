<?php
/* @var $this \yii\web\View */
/* @var $recoveryModel RecoveryPass */

use common\components\helpers\UrlHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="frame">
    <div ng-app ng-init="checked = false">
        <?php
        $formRecovery = ActiveForm::begin([
                    'options' => [
                        'class' => 'form-recovery',
                        'name'  => 'form',
                    ],
        ]);
        ?>
        <p class="hint"><?= Yii::t('app', 'Пожалуйста, введите почту, которую указывали при регистрации!') ?></p>
        <?=
                $formRecovery->field($recoveryModel, 'email')
                ->textInput(['class' => 'form-styling', 'value' => 'gregory@gmail.com'])
                ->label(Yii::t('app', 'E-mail'))->error(['class' => 'help-block hidden'])
        ?>
        <div class="btn-animate">
            <?= Html::submitButton(Yii::t('app', 'Восстановить'), ['class' => 'btn-signin']) ?>
        </div>

        <?php ActiveForm::end(); ?>

        <div class="success success-top">
            <svg width="270" height="270" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 viewBox="0 0 60 60" id="check" ng-class="checked ? 'checked' : ''">
                <path fill="#ffffff" d="M40.61,23.03L26.67,36.97L13.495,23.788c-1.146-1.147-1.359-2.936-0.504-4.314
                      c3.894-6.28,11.169-10.243,19.283-9.348c9.258,1.021,16.694,8.542,17.622,17.81c1.232,12.295-8.683,22.607-20.849,22.042
                      c-9.9-0.46-18.128-8.344-18.972-18.218c-0.292-3.416,0.276-6.673,1.51-9.578" />
                <div class="successtext">
                    <p><?= Yii::t('app', 'На вашу почту было отправлено сообщение!') ?></p>
                </div>
        </div>
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
