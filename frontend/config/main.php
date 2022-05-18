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
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'encryption' => 'tls',
                'host' => 'smtp.gmail.com',
                'port' => '587',
                'username' => 'thanhpt.work@gmail.com',
                'password' => '31299t@T',
            ],             
        ],
        'request' => [
            // 'csrfParam' => '_csrf-frontend',
            'enableCsrfValidation' => false,
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
            // 'suffix' => '.html', // Hậu tố
            'rules' => [
                /** Tên chuyển đổi => controller/action */
                /** '<action:(san-pham|product|tu-khoa)>-<path:.*?>' => 'site/<action>', */
                '' => 'site/index',
                'about.html' => 'site/about',
                'login.html' => 'site/login',
                'signup.html' => 'site/signup',
                'logout.html' => 'site/logout',
                'view-modal-product.html' => 'site/view-modal-product',
                'request-password-reset.html' => 'site/request-password-reset',
                'reset-password.html' => 'site/reset-password',
                'product-<path:.*?>.html' => 'product/detail',
                'product.html' => 'product/index',
                'feature.html' => 'product/feature',
                'keyword-<path:.*?>.html' => 'keyword/index',
                'add-to-cart.html' => 'shopping-cart/add-product',
                'update-to-cart.html' => 'shopping-cart/update-product',
                'shopping-cart.html' => 'shopping-cart/index',
                // ['class' => 'yii\rest\UrlRule', 'controller' => 'api'],
            ],
        ],
    ],
    'params' => $params,
];
