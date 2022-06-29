<?php
/* @var $this View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="shortcut icon" href="favicon.ico" />
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
</head>
<body class="sidebar-mini layout-fixed" style="height: auto">
<?php $this->beginBody() ?>

<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button" id="active-sidebar"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="<?= Url::toRoute(['site/index']) ?>" class="nav-link">Trang chủ</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="<?= Url::toRoute(['user/index']) ?>" class="nav-link">Người dùng</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">

            <!-- Messages Dropdown Menu -->
            <!-- <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-comments"></i>
                    <span class="badge badge-danger navbar-badge">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="#" class="dropdown-item">
                        <div class="media">
                            <img src="<?= Yii::$app->request->baseUrl.'/../backend/assets/img/user1-128x128.jpg' ?>" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Brad Diesel
                                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">Call me whenever you can...</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <div class="media">
                            <img src="<?= Yii::$app->request->baseUrl.'/../backend/assets/img/user8-128x128.jpg' ?>" alt="User Avatar" class="img-size-50 img-circle mr-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    John Pierce
                                    <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">I got your message bro</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <div class="media">
                            <img src="<?= Yii::$app->request->baseUrl.'/../backend/assets/img/user3-128x128.jpg' ?>" alt="User Avatar" class="img-size-50 img-circle mr-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Nora Silvester
                                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">The subject goes here</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                </div>
            </li> -->

            <!-- Notifications Dropdown Menu -->
            <!-- <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li> -->
        </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="<?= Url::toRoute(['site/index']) ?>" class="brand-link">
            <img src="<?= Yii::$app->request->baseUrl.'/../backend/assets/img/AdminLTELogo.png' ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">My Application</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="<?= Yii::$app->request->baseUrl.'/../backend/assets/img/user2-160x160.jpg' ?>" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block"><?= Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->username ?></a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <!-- <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Dashboard v1</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Dashboard v2</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Dashboard v3</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Widgets
                                <span class="right badge badge-danger">New</span>
                            </p>
                        </a>
                    </li> -->
                    <li class="nav-header">DANH MỤC</li>
                    <li class="nav-item">
                        <a href="<?= Url::toRoute(['/notification/index']) ?>" class="nav-link">
                        <i class="nav-icon fas fa-bell"></i>
                            <p>
                                Thông báo
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= Url::toRoute(['/product-type/index']) ?>" class="nav-link">
                            <i class="nav-icon fas fa-align-justify"></i>
                            <p>
                                Loại sản phẩm
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= Url::toRoute(['/keyword/index']) ?>" class="nav-link">
                            <i class="nav-icon fas fa-tags"></i>
                            <p>
                                Từ khóa
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= Url::toRoute(['/trademark/index']) ?>" class="nav-link">
                            <i class="nav-icon fas fa-images"></i>
                            <p>
                                Thương hiệu
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= Url::toRoute(['/slider/index']) ?>" class="nav-link">
                            <i class="nav-icon fas fa-photo-video"></i>
                            <p>
                                Slider
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">BÁN HÀNG</li>
                    <li class="nav-item">
                        <a href="<?= Url::toRoute(['/product/index']) ?>" class="nav-link">
                            <i class="nav-icon fas fa-box-open"></i>
                            <p>
                                Sản phẩm
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= Url::toRoute(['/order/index']) ?>" class="nav-link">
                            <i class="nav-icon fab fa-first-order"></i>
                            <p>
                                Đơn hàng
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">HỆ THỐNG</li>
                    <li class="nav-item">
                        <a href="<?= Url::toRoute(['/user/index']) ?>" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Người dùng
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= Url::toRoute(['/role/index']) ?>" class="nav-link">
                            <i class="nav-icon fas fa-user-tag"></i>
                            <p>
                                Vai trò
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= Url::toRoute(['/activity/index']) ?>" class="nav-link">
                            <i class="nav-icon fas fa-filter"></i>
                            <p>
                                Chức năng
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= Url::toRoute(['/permission/index']) ?>" class="nav-link">
                            <i class="nav-icon fas fa-key"></i>
                            <p>
                                Phân quyền
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= Url::toRoute(['/table/index']) ?>" class="nav-link">
                            <i class="nav-icon fas fa-table"></i>
                            <p>
                                Bảng
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= Url::toRoute(['/gii']) ?>" class="nav-link" target="_blank">
                            <i class="nav-icon fas fa-code"></i>
                            <p>
                                Gii
                            </p>
                        </a>
                    </li>
                    <li class="nav-item" id="logout-contaier">
                        <a href="<?= Url::toRoute(['site/logout']) ?>" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>
                                Đăng xuất
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <?= $content ?>
            </div>
        </section>
        <!-- /.content -->
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
