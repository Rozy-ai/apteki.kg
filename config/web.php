<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
	  'timeZone' => 'Europe/Moscow',
	  'language' => 'ru-RU',
   	'name' => 'Apteki.kg',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
	  'modules' => [
      'admin' => [
          'class' => 'app\modules\admin\Module',
      ],
      'rbac' => [
          'class' => 'mdm\admin\Module',
          'layout' => '@app/modules/admin/views/layouts/admin',
          'controllerMap' => [
              'assignment' => [
                  'class' => 'mdm\admin\controllers\AssignmentController',
                  'idField' => 'id',
                  'usernameField' => 'email',
                  'fullnameField' => '',
              ],
          ],
      ],
  		'api' => [
              'class' => 'app\modules\api\Module',
      ],
  		'yii2images' => [
              'class' => 'rico\yii2images\Module',
              //be sure, that permissions ok
              //if you cant avoid permission errors you have to create "images" folder in web root manually and set 777 permissions
              'imagesStorePath' => '@webroot/yii2images/store', //path to origin images
              'imagesCachePath' => '@webroot/yii2images/cache', //path to resized copies
              'graphicsLibrary' => 'GD', //but really its better to use 'Imagick'
              'placeHolderPath' => '@webroot/images/placeholder.jpeg', // if you want to get placeholder when image not exists, string will be processed by Yii::getAlias
         //     'imageCompressionQuality' => 100, // Optional. Default value is 85.
  		],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'WQSHndHUg5xwSgB2y-CBOCXloqZe-PuH',
        ],
        'authManager' => [
          'class' => 'yii\rbac\DbManager',
          'cache' => 'cache'
        ],
        'user' => [
            'identityClass' => 'app\models\Users',
            'enableAutoLogin' => true
        ],
        'global' => [
            'class' => 'app\components\globalComponent'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
            'dateFormat' => 'dd.MM.yyyy',
        ],
		    'authManager' => [
            'class' => 'yii\rbac\DbManager',
			      'cache' => 'cache'
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
      				'page/<name:[\w_-]+>' => 'page/index',
            ],
        ],
    ],
    'controllerMap' => [
  		'elfinder' => [
  			'class' => 'mihaildev\elfinder\Controller',
  			'access' => ['@'], //глобальный доступ к фаил менеджеру @ - для авторизорованных , ? - для гостей , чтоб открыть всем ['@', '?']
  			'disabledCommands' => ['netmount'], //отключение ненужных команд https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#commands
  			'roots' => [
  				[
  					'baseUrl'=>'/files',
  					'basePath'=>'@webroot/files',
  					'path' => 'global',
  					'name' => 'Global'
  				]
  			]
  		]
  	],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
            'gii/*',
            'page/*',
            'api/*',
            'yii2images/*',
            'debug/*',
            'category/*',
            'product/*',
            'map/*',
            'company/*',
            'search/*'
        ]
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
        //'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
        'allowedIPs' => ['*'],
    ];
}

return $config;
