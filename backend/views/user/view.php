<?php

use common\models\User;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */
?>
<div class="user-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'password_hash',
            'email:email',
            [
                'label' => 'Trạng thái',
                'value' => User::getListStatus()[$model->status],
            ],
            [
                'label' => 'Trạng thái',
                'value' => date('d/m/Y', strtotime($model->created_at)),
            ],
        ],
    ]) ?>

</div>
