<?php

namespace frontend\tests\unit\fixtures;

use yii\test\ActiveFixture;

class TokenFixture extends ActiveFixture
{

    public $modelClass = 'common\models\recovery\Token';
    public $dataFile   = '@frontend/tests/unit/fixtures/data/token.php';
//    public $depends    = [
//        'frontend\tests\unit\fixtures\UserFixture',
//    ];

}
