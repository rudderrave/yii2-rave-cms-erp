<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'frontend',
    'homeUrl' => '/',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'auth' => [
            'class' => 'ravesoft\auth\AuthModule',
        ],
    ],
    'components' => [
        'view' => [
            'theme' => [
                'class' => 'frontend\components\Theme',
                'theme' => 'readable', //cerulean, cosmo, default, flatly, readable, simplex, united
            ],
            'as seo' => [
                'class' => 'ravesoft\seo\components\SeoViewBehavior',
            ]
        ],
        'seo' => [
            'class' => 'ravesoft\seo\components\Seo',
        ],
        'request' => [
            'baseUrl' => '',
        ],
        'urlManager' => [
            'class' => 'ravesoft\web\MultilingualUrlManager',
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'rules' => array(
                '<module:auth>/<action:(logout|captcha)>' => '<module>/default/<action>',
                '<module:auth>/<action:(oauth)>/<authclient:\w+>' => '<module>/default/<action>',
            ),
            'multilingualRules' => [
                '<module:auth>/<action:\w+>' => '<module>/default/<action>',
                '<controller:(category|tag)>/<slug:[\w \-]+>' => '<controller>/index',
                '<controller:(category|tag)>' => '<controller>/index',
                '<slug:[\w \-]+>' => 'site/index/',
                '/' => 'site/index',
                '<action:[\w \-]+>' => 'site/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
            'nonMultilingualUrls' => [
                'auth/default/oauth',
            ],
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
