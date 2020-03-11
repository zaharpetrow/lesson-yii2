<?php

use app\models\recovery\Token;

return [
    [
        'user_id'    => 16,
        'token'      => Token::createToken(),
        'created_at' => time(),
    ],
    [
        'user_id'    => 18,
        'token'      => Token::createToken(),
        'created_at' => time() - 2000,
    ],
];
