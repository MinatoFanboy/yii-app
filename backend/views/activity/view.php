<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ChucNang */
?>
<div class="phan-quyen-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'controller_action',
        ],
    ]) ?>

</div>
