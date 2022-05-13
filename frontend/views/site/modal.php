<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
    <button class="how-pos3 hov3 trans-04 js-hide-modal1">
        <img src="<?= Yii::$app->urlManager->baseUrl . '/frontend/assets/template/images/icons/icon-close.png' ?>" alt="CLOSE">
    </button>

    <div class="row">
        <div class="col-md-6 col-lg-7 p-b-30">
            <div class="p-l-25 p-r-30 p-lr-0-lg">
                <div class="wrap-slick3 flex-sb flex-w">
                    <div class="wrap-slick3-dots"></div>
                    <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

                    <div class="slick3 gallery-lb">
                        <div class="item-slick3" data-thumb="<?= Yii::$app->urlManager->baseUrl . '/images/product/' . $product->representation ?>">
                            <div class="wrap-pic-w pos-relative">
                                <img src="<?= Yii::$app->urlManager->baseUrl . '/images/product/' . $product->representation ?>" alt="IMG-PRODUCT">

                                <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="<?= Yii::$app->urlManager->baseUrl . '/images/product/' . $product->representation ?>">
                                    <i class="fa fa-expand"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-5 p-b-30">
            <div class="p-r-50 p-t-5 p-lr-0-lg">
                <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                    <?= $product->name ?>
                </h4>

                <span class="mtext-106 cl2">
                    <?= number_format($product->price, 0, ',', '.').' VNĐ' ?>
                </span>

                <p class="stext-102 cl3 p-t-23">
                    <?= $product->short_description ?>
                </p>
                
                <!--  -->
                <div class="p-t-33">
                    <div class="flex-w flex-r-m p-b-10">
                        <div class="size-204 flex-w flex-m respon6-next">
                            <?php ActiveForm::begin(['options' => ['id' => 'form-add-to-cart']]); ?>
                                <?= Html::hiddenInput('product_id', $product->id) ?>
                                <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                    <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                        <i class="fs-16 zmdi zmdi-minus"></i>
                                    </div>

                                    <input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product" value="1">

                                    <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                        <i class="fs-16 zmdi zmdi-plus"></i>
                                    </div>
                                </div>

                                <?= Html::a('Thêm vào giỏ hàng', '#', ['class' => 'flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail']) ?>
                                <!-- <button class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                                    Add to cart
                                </button> -->
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>	
                </div>
            </div>
        </div>
    </div>
</div>