<?php

use common\assets\ProfileAsset;
use common\components\Avatar;
use common\widgets\UploadAvatarPopup;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $profileData app\models\profile\ProfileData */

ProfileAsset::register($this);
$this->title = Yii::$app->name . " | " . Yii::t('app', 'Профиль');
?>
<div class="container mt-5">
    <!-- row -->
    <div class="row tm-content-row">
        <div class="tm-block-col tm-col-avatar">
            <div class="tm-bg-primary-dark tm-block tm-block-avatar">
                <h2 class="tm-block-title"><?= Yii::t('app', 'Сменить фото') ?></h2>
                <div class="tm-avatar-container">
                    <div class="tm-avatar-container">
                        <img
                            src="<?= Avatar::getIconL() ?>"
                            alt="Avatar"
                            class="tm-avatar-l img-fluid mb-4"
                            />
                            <?php if (Yii::$app->user->identity->userOptions->img !== null): ?>
                            <a href="<?= Url::to(['profile/delete-avatar']) ?>" 
                               class="tm-avatar-delete-link delete-avatar">
                                <i class="far fa-trash-alt tm-product-delete-icon"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <button id="update-avatar" class="btn btn-primary btn-block text-uppercase">
                    <?= Yii::t('app', 'Загрузить') ?>
                </button>
            </div>
        </div>
        <div class="tm-block-col tm-col-account-settings">
            <div class="tm-bg-primary-dark tm-block tm-block-settings">
                <h2 class="tm-block-title"><?= Yii::t('app', 'Настройки аккаунта') ?></h2>
                <?php
                $formProfile = ActiveForm::begin([
                            'options' => [
                                'class' => 'tm-signup-form row',
                                'name'  => 'form',
                            ],
                ]);
                ?>
                <div class="col-12 section"><?= Yii::t('app', 'Сменить имя') ?></div>
                <?=
                $formProfile->field($profileData, 'name', [
                    'options' => [
                        'class' => 'form-group col-lg-12',
                    ],
                ])->textInput([
                    'class' => 'form-control validate',
                    'value' => Yii::$app->user->identity->name,
                ])->error(['class' => 'help-block'])
                ?>
                <div class="col-12 section"><?= Yii::t('app', 'Сменить пароль') ?></div>
                <?=
                $formProfile->field($profileData, 'password', [
                    'options' => [
                        'class' => 'form-group col-lg-6',
                    ],
                ])->passwordInput([
                    'class' => 'form-control validate',
                ])->error(['class' => 'help-block'])
                ?>
                <?=
                $formProfile->field($profileData, 'passwordRepeat', [
                    'options' => [
                        'class' => 'form-group col-lg-6',
                    ],
                ])->passwordInput([
                    'class' => 'form-control validate',
                ])->error(['class' => 'help-block'])
                ?>
                <div class="col-12">
                    <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary btn-block text-uppercase']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<div class="popup">
    <?= UploadAvatarPopup::widget() ?>
</div>