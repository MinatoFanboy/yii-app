<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Slider */
?>
<div class="slider-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'content:ntext',
            'link:ntext',
        ],
    ]) ?>

</div>
