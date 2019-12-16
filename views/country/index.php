<?php
use app\components\TestGetSet;

$testClass= new TestGetSet();
$testClass->value=123;
print_r($testClass->value);
?>

<h1>Countries</h1>
<ul>
    <?php foreach ($countries as $country): ?>
        <li>
            <?= "{$country->code}  ({$country->name})" ?>:
        </li>
    <?php endforeach; ?>
</ul>