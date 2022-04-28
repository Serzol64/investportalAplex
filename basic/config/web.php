<?php

$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'enableCookieValidation' => false,
            'baseUrl' => ''
        ],
        'errorHandler' => [
			'errorAction' => 'site/error',
		],
        'sessionRedis' => [
			'class' => 'yii\redis\Session'
		],
		'cacheRedis' => [
			'class' => 'yii\redis\Cache'
		],
        'imageCreator' => [
			'class' => 'app\components\ImageCreator'
        ],
        'urlManager' => [
			 'class' => 'yii\web\UrlManager',
			 'showScriptName' => false,
			 'enablePrettyUrl' => true,
			 'rules' => [
				'defaultRoute' => 'site/index',
				'about' => 'site/about',
				'services' => 'site/services',
				'services/<serviceId:\d+>/<operation>' => 'site/services-api',
				'investors' => 'objects/investors',
				'accounts/<service>' => '/site/account-service',
				'accounts/accept/<service>' => '/site/service-code-center',
				'admin' => 'admin/index',
				'admin/auth' => 'admin/auth',
				'admin/logout' => 'admin/signout',
				'admin/api/dataServices/filters/<svc>/send' => '/admin/admin-data-filters-send-service',
				'admin/api/dataServices/filters/<svc>/update' => '/admin/admin-data-filters-update-service',
				'admin/api/dataServices/filters/<svc>/delete' => '/admin/admin-data-filters-delete-service',
				'admin/api/dataServices/filters/<svc>/show' => '/admin/admin-data-filters-res-service',
				'admin/api/dataServices/newsService/<svc>/send' => '/admin/news-send-service',
				'admin/api/dataServices/newsService/<svc>/update' => '/admin/news-update-service',
				'admin/api/dataServices/newsService/<svc>/delete' => '/admin/news-delete-service',
				'admin/api/dataServices/newsService/<svc>/show' => '/admin/news-res-service',
				'services/api/<serviceId:\d+>/<operation>' => '/site/services-api',
				'objects/api/<type>' => 'objects/objectsservice',
				'investors/api/<type>' => 'objects/investorsservice',
				'experts/api/<type>' => 'objects/expertsservice',
				'news/api/<type>' => 'news/newsservice',
				'analytics/api/<type>' => 'news/analyticsservice',
				'events/api/<type>' => 'news/eventsservice',
				'news' => 'news/index',
				'news/<contentId:\d+>' => 'news/view',
				'events' => 'news/events-feed',
				'events/<contentId:\d+>' => 'news/event',
				'analytics' => 'news/analytics-feed',
				'analytics/<contentId:\d+>' => 'news/analytics-view',
				'passport' => 'passport/service',
				'passport/cart' => 'passport/cart',
				'passport/offers' => 'passport/offer',
				'passport/profile' => 'passport/accountedit',
				'passport/services' => 'passport/eventsedit',
				'passport/api/<type>' => 'passport/passportservice',
				'objects' => 'objects/index',
				'objects/search' => 'objects/object',
				'objects/<objectId:\d+>' => 'objects/view',
				'experts' => 'objects/experts',
				'experts/<objectId:\d+>' => 'objects/experts-view'
			 ]
        ],
        'view' => [
            'class' => 'yii\web\View'
        ],
        'adminCMSData' => ['class' => 'app\components\ContentData'],
        'adminCMSHeader' => ['class' => 'app\components\ContentTitle'],
        'portalReg' => ['class' => 'app\components\SignUp'],
		'portalLogin' => ['class' => 'app\components\SignIn'],
		'asReg' => ['class' => 'app\components\adminSignUp'],
		'asLogin' => ['class' => 'app\components\adminSignIn'],
		'portalExit' => ['class' => 'app\components\SignOut'],
		'asExit' => ['class' => 'app\components\adminSignOut'],
		'autoLogin' => ['class' => 'app\components\autoSignIn'],
		'portalPass' => ['class' => 'app\components\Forgot'],
        'smsCoder' => ['class' => 'app\components\SMSCode'],
        'regionDB' => ['class' => 'app\components\CountriesList'],
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
    ]
];
if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '192.168.10.20'],
    ];
}


return $config;
