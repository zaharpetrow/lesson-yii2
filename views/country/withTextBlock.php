<?php

use app\components\TestGetSet;
use app\components\HelloWidget;

$testClass        = new TestGetSet();
$testClass->value = 123;
print_r($testClass->value);

/* @var $this \yii\web\View */
/* @var $model app\models\TestSession */
?>

<h1>Countries</h1>
<h2>
    <?php HelloWidget::begin(['model' => $model]); ?>
    Content: !
    <?php HelloWidget::end(); ?>
</h2>
<ul>
    <?php foreach ($countries as $country): ?>
        <li>
            <?= "{$country->code}  ({$country->name})" ?>:
        </li>
    <?php endforeach; ?>
</ul>