<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
?>
<div class="product-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'short_description',
            'description:ntext',
            'cost',
            'price',
            'price_sale',
            'exist_day',
            'features',
            'newest',
            'sellest',
            'trademark_id',
            'trademark',
            'user_created_id',
            'user_created',
            'user_updated_id',
            'user_updated',
        ],
    ]) ?>

</div>
