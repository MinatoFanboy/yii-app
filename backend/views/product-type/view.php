<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ProductType */
?>
<div class="product-type-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'slug',
        ],
    ]) ?>

</div>
