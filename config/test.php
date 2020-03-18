<?php

$params = require __DIR__ . '/params.php';
$db     = require __DIR__ . '/test_db.php';

/**
 * Application configuration shared by all test types
 */
return [
    'id'             => 'basic-tests',
    'basePath'       => dirname(__DIR__),
    'aliases'        => [
        '@bower'         => '@vendor/bower-asset',
        '@npm'           => '@vendor/npm-asset',
        '@app'           => dirname(__DIR__),
        '@tests'          => '@app/tests',
        '@recoveryLinks' => '@app/mail/recoveryLinks.txt',
        '@verifyLinks'   => '@app/mail/verifyLinks.txt',
    ],
    'sourceLanguage' => 'ru-RU',
    'language'       => 'ru-RU',
    'components'     => [
        'i18n'         => [
            'translations' => [
                '*' => [
                    'class'    => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                ],
            ],
        ],
        'db'           => $db,
        'mailer'       => [
            'useFileTransport' => true,
        ],
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'urlManager'   => [
            'showScriptName' => true,
            'normalizer'     => [
                'class'  => 'yii\web\UrlNormalizer',
                'action' => yii\web\UrlNormalizer::ACTION_REDIRECT_TEMPORARY,
            ],
            'rules'          => [
                'triangular/<id:\d+>' => 'triangular/integer',
                'auth'                => 'site/auth',
                'recovery'            => 'site/recovery',
                'logout'              => 'profile/logout',
            ],
        ],
        'user'         => [
            'identityClass' => 'app\models\User',
            'loginUrl'      => ['/auth'],
        ],
        'request'      => [
            'cookieValidationKey'  => 'test',
            'scriptFile'           => dirname(__DIR__) . '/web/index-test.php',
            'enableCsrfValidation' => false,
        // but if you absolutely need it set cookie domain to localhost
        /*
          'csrfCookie' => [
          'domain' => 'localhost',
          ],
         */
        ],
    ],
    'params'         => $params,
];
