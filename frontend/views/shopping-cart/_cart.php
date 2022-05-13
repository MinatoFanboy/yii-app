<?php 
use yii\helpers\Url;
 ?>

<?php if (empty($products)): ?>
    <h3>Bạn chưa chọn sản phẩm nào!</h3>
<?php else: ?>
    <ul class="header-cart-wrapitem w-full">
        <?php foreach ($products as $product): ?>
            <li class="header-cart-item flex-w flex-t m-b-12">
                <div class="header-cart-item-img">
                    <img src="<?= Yii::$app->urlManager->baseUrl . '/images/product/' . $product->representation ?>" alt="IMG">
                </div>

                <div class="header-cart-item-txt p-t-8">
                    <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                        <?= $product->name ?>
                    </a>

                    <span class="header-cart-item-info">
                        <?= $quantity[$product->id] ?> x <?= number_format($product->price, 0, ',', '.'). ' VNĐ' ?>
                    </span>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>

    <div class="w-full">
        <div class="header-cart-total w-full p-tb-40">
            Tổng tiền: <?= number_format($total_money, 0, ',', '.').' VNĐ' ?>
        </div>

        <div class="header-cart-buttons flex-w w-full">
            <a href="<?= Url::toRoute(['shopping-cart/index']) ?>" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
                Xem giỏ hàng
            </a>

            <a href="<?= Url::toRoute(['shopping-cart/index']) ?>" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
                Thanh toán
            </a>
        </div>
    </div>
<?php endif; ?>
