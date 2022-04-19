<?php

namespace backend\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '../backend/assets/plugins/fontawesome-free-5.15.4-web/css/all.css',
        '../backend/assets/plugins/jquery-confirm-v3.3.3/dist/jquery-confirm.min.css',
        '../backend/assets/plugins/select2-develop/dist/css/select2.min.css',
        '../backend/assets/plugins/jquery-ui-1.13.0/jquery-ui.min.css',
        'css/site.css',
        '../backend/assets/css/main.css',
        '../backend/assets/css/styles.css',
    ];
    public $js = [
        '../backend/assets/plugins/jquery-migrate-3.3.1.min.js',
        '../backend/assets/plugins/jquery.blockUI.js',
        '../backend/assets/plugins/jquery-confirm-v3.3.3/dist/jquery-confirm.min.js',
        '../backend/assets/plugins/select2-develop/dist/js/select2.min.js',
        '../backend/assets/plugins/jquery-ui-1.13.0/jquery-ui.min.js',
        '../backend/assets/js/main.js',
        '../backend/assets/js/script.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
