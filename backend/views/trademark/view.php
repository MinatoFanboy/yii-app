<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Trademark */
?>
<div class="trademark-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'slug',
            'picture:ntext',
            'active',
        ],
    ]) ?>

</div>
