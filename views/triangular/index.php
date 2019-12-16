<?php

use yii\widgets\LinkPager;
use yii\helpers\Url;
?>
<h1>Triangular</h1>
<table>
    <tr>
        <th>Number</th>
        <th>Triangular</th>
        <th>Divides</th>
    </tr>
    <?php foreach ($triangulars as $tri): ?>
        <tr class="mylink" href="<?= Url::to(['triangular/integer', 'id' => $tri->id]) ?>">
            <td class="center"><?= $tri->number ?></td>
            <td class="center"><?= $tri->triangular ?></td>
            <td><?= preg_replace('/,/', ' ', preg_replace('/[\[\]]/', '', json_encode($tri->divided))) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php
echo LinkPager::widget([
    'pagination'     => $pages,
    'firstPageLabel' => true,
    'lastPageLabel'  => true,
]);
