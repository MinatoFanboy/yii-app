<?php

use common\models\VaiTro;
use yii\helpers\Html;
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '1%',
        'header' => 'STT',
        'headerOptions' => ['class' => 'text-primary']
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
    ],
    [
        'header' => 'Sửa',
        'value' => function($model) {
            /** @var $model VaiTro */
            return Html::a('<i class="fas fa-edit"></i>', Url::toRoute(['role/update', 'id' => $model->id]),
                ['role' => 'modal-remote', 'data-toggle' => 'tooltip', 'title' => 'Cập nhật']);
        },
        'format' => 'raw',
        'headerOptions' => ['width' => '1%', 'class' => 'text-center text-primary'],
        'contentOptions' => ['class' => 'text-center']
    ],
    [
        'header' => 'Xoá',
        'value' => function($model) {
            /** @var $model VaiTro */
            return Html::a('<i class="fas fa-trash-restore"></i>','#', ['class' => 'btn-delete text-danger',
                'data-value'=> $model->id, 'data-url' => 'vai-tro/delete','title' => 'Xóa']);
        },
        'format' => 'raw',
        'headerOptions' => ['width' => '1%', 'class' => 'text-center text-primary'],
        'contentOptions' => ['class' => 'text-center']
    ],
];
