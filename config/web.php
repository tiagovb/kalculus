<?php

use app\components\Formatter;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'language' => 'pt-BR',
    'timezone' => 'America/Sao_Paulo',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@layouts' => __DIR__ . '/../views/layouts/',
    ],
    'components' => [
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'forceCopy' => YII_ENV == 'dev',
        ],
        'authClientCollection' => [
            'class'   => \yii\authclient\Collection::className(),
            'clients' => [
                'facebook' => [
                    'class'        => 'dektrium\user\clients\Facebook',
                    'clientId'     => '',
                    'clientSecret' => '',
                ],
                'google' => [
                    'class'        => 'dektrium\user\clients\Google',
                    'clientId'     => '',
                    'clientSecret' => '',
                ],
            ],
        ],
        'db' => $db,
        'formatter' => [
            'class' => Formatter::class,
        ],
        'request' => [
            'cookieValidationKey' => '4b20dfbca80ff0ba41faa379e5d026a7e45540f2',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Usuario',
            'enableAutoLogin' => true,
            'loginUrl' => ['/user/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/mail',
            'messageConfig' => [
                'from' => ['teste@example.net' => 'Teste AWS SES'],
            ],
            'useFileTransport' => true,
//            'transport' => [
//                'class' => 'Swift_SmtpTransport',
//                'host' => 'email-smtp.us-west-2.amazonaws.com',
//                'username' => '',
//                'password' => '',
//                'port' => '587',
//                'encryption' => 'tls',
//            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
//        's3bucket' => [
//            'class' => \frostealth\yii2\aws\s3\Storage::className(),
//            'region' => 'us-east-1',
//            'credentials' => [
//                    'key' => '',
//                    'secret' => '',
//            ],
//            'bucket' => '',
//        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/user-module',
                ],
            ],
        ],
    ],
    'modules' => [
        'datecontrol' => [
            'class' => \kartik\datecontrol\Module::class,
            'ajaxConversion' => false,
            'displaySettings' => [
                \kartik\datecontrol\Module::FORMAT_DATE => 'dd/MM/yyyy',
                \kartik\datecontrol\Module::FORMAT_TIME => 'HH:mm',
                \kartik\datecontrol\Module::FORMAT_DATETIME => 'dd/MM/yyyy HH:mm',
            ],
            'saveSettings' => [
                \kartik\datecontrol\Module::FORMAT_DATE => 'php:Y-m-d',
                \kartik\datecontrol\Module::FORMAT_TIME => 'php:H:i:s',
                \kartik\datecontrol\Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
            ],
        ],
        'gridview' => [
            'class' => \kartik\grid\Module::class,
            'downloadAction' => 'gridview/export/download',
        ],
        'rbac' => [
            'class' => 'dektrium\rbac\RbacWebModule',
        ],
        'user' => [
            'class' => 'dektrium\user\Module',
            'adminPermission' => 'admin',
            'controllerMap' => [
                'security' => [
                    'class' => 'dektrium\user\controllers\SecurityController',
                    'layout' => '@app/views/layouts/main-login',
                ],
                'registration' => [
                    'class' => 'dektrium\user\controllers\RegistrationController',
                    'layout' => '@app/views/layouts/main-login',
                ],
                'recovery' => [
                    'class' => 'dektrium\user\controllers\RecoveryController',
                    'layout' => '@app/views/layouts/main-login',
                ],
            ],
            'enableConfirmation' => false,
            'enableRegistration' => false,
        ],
    ],
    'as filter' => \app\components\filters\AppAccessControl::class,
    'params' => $params,
];

if (YII_ENV === 'dev') {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1'],
        'generators' => [
            'crud' => [
                'class' => 'yii\gii\generators\crud\Generator',
                'templates' => [
                    'adminlte' => '@app/components/gii/templates/crud',
                ],
            ],
        ],
    ];
}

if (YII_DEBUG !== 'false') {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
