<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/mail',
            'useFileTransport' => true,
            //            'messageConfig' => [
            //                'from' => ['sigskills@worldskillsportugal.pt' => 'SigSkills - WorldSkills Portugal'],
            //            ],
            //            'transport' => [
            //                'class' => 'Swift_SmtpTransport',
            //                'host' => 'email-smtp.us-east-1.amazonaws.com',
            //                'username' => 'AKIAJHPLXK6LP3OVB4OQ',
            //                'password' => 'AqGRzTPsm8AuEvJoQJcspeQNWbS1DYxQm+shgX7O6qFa',
            //                'port' => '587',
            //                'encryption' => 'tls',
            //            ],
        ],
    ],
    'params' => $params,
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
        ],
        'rbac' => [
            'class' => 'dektrium\rbac\RbacConsoleModule',
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
