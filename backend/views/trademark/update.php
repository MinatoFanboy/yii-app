<?php

use yii\web\View;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Trademark */

$this->title = 'Cập nhật thương hiệu: '. $model->name;
?>
<div class="trademark-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php $this->registerCssFile(Yii::$app->request->baseUrl.'/../backend/assets/plugins/lightbox2/dist/css/lightbox.min.css'); ?>

<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/../backend/assets/plugins/lightbox2/dist/js/lightbox.min.js', 
    ['depends' => ['backend\assets\AppAsset'], 'position' => View::POS_END]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/../backend/assets/js/trademark.js', ['depends' => ['backend\assets\AppAsset'],
    'position' => View::POS_END]); ?>
