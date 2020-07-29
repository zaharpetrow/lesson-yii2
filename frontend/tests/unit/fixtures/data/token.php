<?php

use common\models\recovery\Token;

return [
    [
        'user_id'    => 15,
        'token'      => Token::createToken(),
        'created_at' => time(),
    ],
    [
        'user_id'    => 16,
        'token'      => Token::createToken(),
        'created_at' => time() - 2000,
    ],
];
