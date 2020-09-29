<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => ['comments', 'rave'],
    'language' => 'en-US',
    'sourceLanguage' => 'en-US',
    'components' => [
        'rave' => [
            'class' => 'ravesoft\Rave',
        ],
        'settings' => [
            'class' => 'ravesoft\components\Settings'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'class' => 'ravesoft\components\User',
            'on afterLogin' => function ($event) {
                \ravesoft\models\UserVisitLog::newVisitor($event->identity->id);
            }
        ],
    ],
    'modules' => [
        'comments' => [
            'class' => 'ravesoft\comments\Comments',
            'userModel' => 'ravesoft\models\User',
            'userAvatar' => function ($user_id) {
                $user = ravesoft\models\User::findIdentity((int)$user_id);
                if ($user instanceof ravesoft\models\User) {
                    return $user->getAvatar();
                }
                return false;
            }
        ],
    ],
];
