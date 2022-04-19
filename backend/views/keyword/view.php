<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Keyword */
?>
<div class="keyword-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'slug',
        ],
    ]) ?>

</div>
