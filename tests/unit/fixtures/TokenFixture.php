<?php

namespace app\tests\unit\fixtures;

use yii\test\ActiveFixture;

class TokenFixture extends ActiveFixture
{

    public $modelClass = 'app\models\recovery\Token';
    public $dataFile   = '@app/tests/unit/fixtures/data/token.php';

}
