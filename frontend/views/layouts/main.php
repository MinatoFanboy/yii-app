<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\assets\AppAsset;
use common\models\Keyword;
use common\models\myAPI;

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
</head>
<body>
<?php $this->beginBody() ?>

<body class="animsition">
	<!-- Header -->
	<header>
		<!-- Header desktop -->
		<div class="container-menu-desktop">
			<div class="wrap-menu-desktop">
				<nav class="limiter-menu-desktop container">
					
					<!-- Logo desktop -->		
					<a href="<?= Url::toRoute('site/index') ?>" class="logo">
						<img src="<?= Yii::$app->urlManager->baseUrl . '/frontend/assets/template/images/icons/logo-01.png' ?>" alt="IMG-LOGO">
					</a>

					<!-- Menu desktop -->
					<div class="menu-desktop">
						<ul class="main-menu">
							<li class="active-menu">
								<a href="<?= Url::toRoute('site/index') ?>">Trang chủ</a>
							</li>

							<li>
								<a href="<?= Url::toRoute('product/index') ?>">Cửa hàng</a>
							</li>

							<li class="label1" data-label1="hot">
								<a href="<?= Url::toRoute('product/feature') ?>">Nổi bật</a>
							</li>

							<li>
								<a href="<?= Url::toRoute('site/about') ?>">Liên hệ</a>
							</li>

							<?php if (Yii::$app->user->isGuest): ?>
								<li>
									<a href="<?= Url::toRoute('site/login') ?>">Đăng nhập</a>
								</li>
							<?php else: ?>
								<li>
									<a href="<?= Url::toRoute('site/logout') ?>">Đăng xuất (<?= Yii::$app->user->identity->name ?>)</a>
								</li>
							<?php endif; ?>
						</ul>
					</div>	

					<!-- Icon header -->
					<div class="wrap-icon-header flex-w flex-r-m">
						<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
							<i class="zmdi zmdi-search"></i>
						</div>

						<div class="cart_wrapper">
							<?php if (isset(Yii::$app->session['product'])): ?>
								<?= $this->render('../shopping-cart/_cart_wrapper', ['num_product' => Yii::$app->session['total']]) ?>
							<?php else: ?>
								<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" 
									data-notify="0">
									<i class="zmdi zmdi-shopping-cart"></i>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</nav>
			</div>	
		</div>

		<!-- Header Mobile -->
		<div class="wrap-header-mobile">
			<!-- Logo moblie -->		
			<div class="logo-mobile">
				<a href="<?= Url::toRoute('site/index') ?>"><img src="<?= Yii::$app->urlManager->baseUrl . '/frontend/assets/template/images/icons/logo-01.png' ?>" alt="IMG-LOGO"></a>
			</div>

			<!-- Icon header -->
			<div class="wrap-icon-header flex-w flex-r-m m-r-15">
				<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
					<i class="zmdi zmdi-search"></i>
				</div>

				<div class="cart_wrapper">
					<?php if (isset(Yii::$app->session['product'])): ?>
						<?= $this->render('../shopping-cart/_cart_wrapper', ['num_product' => Yii::$app->session['total']]) ?>
					<?php else: ?>
						<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" 
							data-notify="0">
							<i class="zmdi zmdi-shopping-cart"></i>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<!-- Button show menu -->
			<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</div>
		</div>


		<!-- Menu Mobile -->
		<div class="menu-mobile">
			<ul class="main-menu-m">
				<li>
					<a href="<?= Url::toRoute('site/index') ?>">Trang chủ</a>
				</li>

				<li>
					<a href="<?= Url::toRoute('product/index') ?>">Cửa hàng</a>
				</li>

				<li>
					<a href="<?= Url::toRoute('product/feature') ?>" class="label1 rs1" data-label1="hot">Nổi bật</a>
				</li>

				<li>
					<a href="<?= Url::toRoute('site/about') ?>">Liên hệ</a>
				</li>

				<?php if (Yii::$app->user->isGuest): ?>
					<li>
						<a href="<?= Url::toRoute('site/login') ?>">Đăng nhập</a>
					</li>
				<?php else: ?>
					<li>
						<a href="<?= Url::toRoute('site/logout') ?>">Đăng xuất (<?= Yii::$app->user->identity->name ?>)</a>
					</li>
				<?php endif; ?>
			</ul>
		</div>

		<!-- Modal Search -->
		<div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
			<div class="container-search-header">
				<button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
					<img src="<?= Yii::$app->urlManager->baseUrl . '/frontend/assets/template/images/icons/icon-close2.png' ?>" alt="CLOSE">
				</button>

				<?= Html::beginForm(['product/search'], 'get', ['class' => 'wrap-search-header flex-w p-l-15']) ?>
					<input class="plh3" type="text" name="keyword" placeholder="Search...">
					<button class="flex-c-m trans-04" type="submit">
						<i class="zmdi zmdi-search"></i>
					</button>
				<?= Html::endForm() ?>
			</div>
		</div>
	</header>

	<!-- Cart -->
	<div class="wrap-header-cart js-panel-cart">
		<div class="s-full js-hide-cart"></div>

		<div class="header-cart flex-col-l p-l-65 p-r-25">
			<div class="header-cart-title flex-w flex-sb-m p-b-8">
				<span class="mtext-103 cl2">
					Giỏ hàng
				</span>

				<div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
					<i class="zmdi zmdi-close"></i>
				</div>
			</div>
			
			<div class="header-cart-content flex-w js-pscroll">
				<?= $this->render('../shopping-cart/_cart', [
					'products' => Yii::$app->session['product'],
					'quantity' => Yii::$app->session['quantity'],
					'total_money' => Yii::$app->session['total_money'],
					'total' => Yii::$app->session['total'],
				]) ?>
			</div>
		</div>
	</div>

	<?= Yii::$app->session->getFlash('notification'); ?>
    <?= $content ?>

	<!-- Footer -->
	<footer class="bg3 p-t-75 p-b-32">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						TỪ KHÓA
					</h4>
					
					<ul>
						<?php $keywords = $this->params['keywords'] ?>
						<?php foreach($keywords as $keyword): ?>
							<li class="p-b-10">
								<a href="<?= Url::toRoute(['keyword/index', 'path' => $keyword->id.'_'.$keyword->slug]) ?>" class="stext-107 cl7 hov-cl1 trans-04">
									<?= $keyword->name ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						TRỢ GIÚP
					</h4>

					<ul>
						<li class="p-b-10">
							<a href="<?= Url::toRoute(['order/index']) ?>" class="stext-107 cl7 hov-cl1 trans-04">
								Trạng thái đơn hàng
							</a>
						</li>

						<li class="p-b-10">
							<a href="<?= Url::toRoute(['product/index']) ?>" class="stext-107 cl7 hov-cl1 trans-04">
								Mua sắm
							</a>
						</li>

						<li class="p-b-10">
							<a href="<?= Url::toRoute(['site/help']) ?>" class="stext-107 cl7 hov-cl1 trans-04">
								FAQs
							</a>
						</li>
					</ul>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						LIÊN LẠC
					</h4>

					<p class="stext-107 cl7 size-201">
						Nếu bạn có bất cứ câu hỏi nào vui lòng gửi về số điện thoại (+84) 399 325 199
					</p>

					<div class="p-t-27">
						<a href="facebook.com/minatofanboy" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-facebook"></i>
						</a>

						<a href="instagram/minato99" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-instagram"></i>
						</a>
					</div>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						GÓP Ý
					</h4>

					<form>
						<div class="wrap-input1 w-full p-b-4">
							<input class="input1 bg-none plh1 stext-107 cl7" type="text" name="email" placeholder="email@example.com">
							<div class="focus-input1 trans-04"></div>
						</div>

						<div class="p-t-18">
							<button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04">
								ĐĂNG KÝ
							</button>
						</div>
					</form>
				</div>
			</div>

			<div class="p-t-40">
				<div class="flex-c-m flex-w p-b-18">
					<a href="#" class="m-all-1">
						<img src="<?= Yii::$app->urlManager->baseUrl . '/frontend/assets/template/images/icons/icon-pay-01.png' ?>" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="<?= Yii::$app->urlManager->baseUrl . '/frontend/assets/template/images/icons/icon-pay-02.png' ?>" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="<?= Yii::$app->urlManager->baseUrl . '/frontend/assets/template/images/icons/icon-pay-03.png' ?>" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="<?= Yii::$app->urlManager->baseUrl . '/frontend/assets/template/images/icons/icon-pay-04.png' ?>" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="<?= Yii::$app->urlManager->baseUrl . '/frontend/assets/template/images/icons/icon-pay-05.png' ?>" alt="ICON-PAY">
					</a>
				</div>

				<p class="stext-107 cl6 txt-center">
					<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a> &amp; distributed by <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->

				</p>
			</div>
		</div>
	</footer>


	<!-- Back to top -->
	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
		</span>
	</div>

	<!-- Modal1 -->
	<div class="wrap-modal1 js-modal1 p-t-60 p-b-20">
		<div class="overlay-modal1 js-hide-modal1"></div>

		<div class="container">
		</div>
	</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>