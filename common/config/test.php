<?php

return [
    'id'             => 'app-common-tests',
    'basePath'       => dirname(__DIR__),
    'aliases'        => [
        '@app'           => dirname(__DIR__),
        '@tests'         => '$common/tests',
        '@recoveryLinks' => '$common/mail/recoveryLinks.txt',
        '@verifyLinks'   => '$common/mail/verifyLinks.txt',
    ],
    'sourceLanguage' => 'ru-RU',
    'language'       => 'ru-RU',
    'components'     => [
        'i18n' => [
            'translations' => [
                '*' => [
                    'class'    => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
            ],
        ],
        'user' => [
            'class'         => 'yii\web\User',
            'identityClass' => 'common\models\User',
            'loginUrl'      => ['/auth'],
        ],
    ],
];
