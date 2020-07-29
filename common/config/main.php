<?php

return [
    'aliases'        => [
        '@bower'         => '@vendor/bower-asset',
        '@npm'           => '@vendor/npm-asset',
        '@app'           => dirname(__DIR__),
        '@recoveryLinks' => '@common/mail/recoveryLinks.txt',
        '@verifyLinks'   => '@common/mail/verifyLinks.txt',
    ],
    'sourceLanguage' => 'ru-RU',
    'language'       => 'ru-RU',
    'vendorPath'     => dirname(dirname(__DIR__)) . '/vendor',
    'components'     => [
        'i18n'         => [
            'translations' => [
                '*' => [
                    'class'    => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
            ],
        ],
        'user'         => [
            'identityClass'   => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie'  => ['name' => '_identity-frontend', 'httpOnly' => true],
            'loginUrl'        => ['/auth'],
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'js'         => [
                        'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'
                    ],
                ],
            ],
        ],
        'cache'        => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
