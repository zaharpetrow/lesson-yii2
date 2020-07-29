<?php
/* @var $avatarModel \app\models\UploadAvatar */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="window-alert cancel hide">
    <div class="box-upload dark-bg">
        <?php
        $form = ActiveForm::begin([
                    'options' => [
                        'id' => 'upload-avatar'
                    ]
        ]);
        ?>
        <div class="box-line box-header pos-r light-bg">
            <div class="title-upload header-item"><?= Yii::t('app', 'Загрузка новой фотографии') ?></div>
            <div class="close-cross header-item btn-orange cancel"><i class="fas fa-times cancel"></i></div>
        </div>
        <div class="box-main-upload pos-r">
            <div class="required">
                <ul>
                    <li class="extensions"><?= Yii::t('app', 'Изображение может быть в формате JPG или PNG.') ?></li>
                    <li class="max-size"><?= Yii::t('app', 'Изображение не должно превышать') ?> <?= $maxSize ?> MB.</li>
                    <li class="ratio"><?= Yii::t('app', 'Рекомендуется изображение с одинаковым соотношением сторон.') ?></li>
                </ul>
            </div>
            <div class="image-place">
                <div class="preview-image container-preview">
                    <img class="hidden">
                    <div id="progressbar">
                        <svg
                            class="progress-ring"
                            width="120"
                            height="120">
                        <circle
                            class="progress-ring__circle op0"
                            stroke-width="4"
                            fill="transparent"
                            r="52"
                            cx="60"
                            cy="60"/>
                        </svg>
                    </div>
                </div>
                <?=
                        $form->field($avatarModel, 'imageFile', ['template' => '{input}{label}'])
                        ->label(Yii::t('app', 'Выбрать'), [
                            'class' => 'image-placeholder preview-image'
                        ])
                        ->fileInput([
                            'accept' => 'image/png, image/jpeg',
                            'style'  => 'display: none',
                        ])
                ?>
            </div>
        </div>
        <div class="box-line box-footer pos-r light-bg">
            <?=
            Html::submitButton(Yii::t('app', 'Сохранить'), [
                'class'    => 'btn btn-primary text-uppercase disabled',
                'disabled' => 'disabled',
            ])
            ?>
            <button type="button" class="btn btn-primary text-uppercase cancel"><?= Yii::t('app', 'Отмена') ?></button>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>