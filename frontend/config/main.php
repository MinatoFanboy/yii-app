<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                '<action:(san-pham|product|keyword)>-<path:.*?>' => 'site/<action>',
                'them-vao-gio-hang' => 'site/add-to-cart',
                'cap-nhat-gio-hang' => 'site/update-cart',
                'product-detail' => 'site/product-detail`',
                'lien-he' => 'site/lien-he',
                'cua-hang' => 'site/cua-hang',
                'gio-hang' => 'site/gio-hang',
                'user' => 'site/user',
                'timkiem' => 'site/timkiem',
                'thanh-toan' => 'site/thanh-toan',
                'yeu-cau-doi-mat-khau' => 'site/request-password-reset',
            ],
        ],
    ],
    'params' => $params,
];
