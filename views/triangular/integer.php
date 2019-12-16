<h1>Triangular integer</h1>
<div>
    <span>Number: </span><?= $integer->number ?>
</div>
<div>
    <span>Triangular: </span><?= $integer->triangular ?>
</div>
<div>
    <span>Dividers: </span><?= preg_replace('/,/', ' ', preg_replace('/[\[\]]/', '', json_encode($integer->divided))) ?>
</div>