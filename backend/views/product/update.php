<?php

use yii\web\View;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = 'Cập nhật sản phẩm: '.$model->name;
?>
<div class="product-update">

    <?= $this->render('_form', [
        'model' => $model,
        'trademarks' => $trademarks,
        'product_types' => $product_types,
        'product_images' => $product_images,
    ]) ?>

</div>

<?php $this->registerCssFile(Yii::$app->request->baseUrl.'/../backend/assets/plugins/lightbox2/dist/css/lightbox.min.css'); ?>

<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/../backend/assets/plugins/lightbox2/dist/js/lightbox.min.js', 
    ['depends' => ['backend\assets\AppAsset'], 'position' => View::POS_END]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/../backend/assets/js/slider.js', ['depends' => ['backend\assets\AppAsset'],
    'position' => View::POS_END]); ?>
