<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        "frontend/assets/template/vendor/bootstrap/css/bootstrap.min.css",
        "frontend/assets/template/fonts/font-awesome-4.7.0/css/font-awesome.min.css",
        "frontend/assets/template/fonts/iconic/css/material-design-iconic-font.min.css",
        "frontend/assets/template/fonts/linearicons-v1.0.0/icon-font.min.css",
        "frontend/assets/template/vendor/animate/animate.css",
        "frontend/assets/template/vendor/css-hamburgers/hamburgers.min.css",
        "frontend/assets/template/vendor/animsition/css/animsition.min.css",
        "frontend/assets/template/vendor/select2/select2.min.css",
        "frontend/assets/template/vendor/daterangepicker/daterangepicker.css",
        "frontend/assets/template/vendor/slick/slick.css",
        "frontend/assets/template/vendor/MagnificPopup/magnific-popup.css",
        "frontend/assets/template/vendor/perfect-scrollbar/perfect-scrollbar.css",
        "frontend/assets/template/css/util.css",
        "frontend/assets/template/css/main.css",
    ];
    public $js = [
        "frontend/assets/js/script.js",
        "frontend/assets/template/vendor/jquery/jquery-3.2.1.min.js",
        "frontend/assets/template/vendor/animsition/js/animsition.min.js",
        "frontend/assets/template/vendor/bootstrap/js/popper.js",
        "frontend/assets/template/vendor/bootstrap/js/bootstrap.min.js",
        "frontend/assets/template/vendor/select2/select2.min.js",
        "frontend/assets/template/vendor/daterangepicker/moment.min.js",
        "frontend/assets/template/vendor/daterangepicker/daterangepicker.js",
        "frontend/assets/template/vendor/slick/slick.min.js",
        "frontend/assets/template/js/slick-custom.js",
        "frontend/assets/template/vendor/parallax100/parallax100.js",
        "frontend/assets/template/vendor/MagnificPopup/jquery.magnific-popup.min.js",
        "frontend/assets/template/vendor/isotope/isotope.pkgd.min.js",
        "frontend/assets/template/vendor/sweetalert/sweetalert.min.js",
        "frontend/assets/template/vendor/perfect-scrollbar/perfect-scrollbar.min.js",
        "frontend/assets/template/js/main.js",
    ];
    public $depends = [
//        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
