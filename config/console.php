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
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests'
    ],
	  'modules' => [
  		'yii2images' => [
              'class' => 'rico\yii2images\Module',
              //be sure, that permissions ok
              //if you cant avoid permission errors you have to create "images" folder in web root manually and set 777 permissions
              'imagesStorePath' => '@app/web/yii2images/store', //path to origin images
              'imagesCachePath' => '@app/web/yii2images/cache', //path to resized copies
              'graphicsLibrary' => 'GD', //but really its better to use 'Imagick'
              'placeHolderPath' => '@app/web/images/noimage.png', // if you want to get placeholder when image not exists, string will be processed by Yii::getAlias
         //     'imageCompressionQuality' => 100, // Optional. Default value is 85.
  		],
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
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
