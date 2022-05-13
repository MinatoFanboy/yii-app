<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Order */
?>
<div class="order-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'customer_id',
            'total',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
