<?php
use yii\helpers\Url;
use yii\helpers\Html;

return [
    [
        'header' => 'STT',
        'headerOptions' => ['class' => 'text-primary'],
        'class' => 'kartik\grid\SerialColumn',
        'width' => '1%',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'total',
        'value' => function($model) {
            return number_format($model->total, 0, ',', '.').' VNĐ';
        },
    ],
    [
        'width' => '1%',
        'class'=>'\kartik\grid\DataColumn',
        'contentOptions' => ['class' => 'text-nowrap'],
        'attribute'=>'created_at',
        'value' => function($model) {
            return date('Y-m-d H:i:s', strtotime($model->created_at));
        },
    ],
    [
        'header' => 'Sửa',
        'value' => function($model) {
            /** @var $model User */
            return  Html::a('<i class="fas fa-edit"></i>', Url::toRoute(['', 'id' => $model->id]),
                ['title' => 'Cập nhật']);
        },
        'format' => 'raw',
        'headerOptions' => ['width' => '1%', 'class' => 'text-center text-primary'],
        'contentOptions' => ['class' => 'text-center']
    ],
    [
        'header' => 'Xoá',
        'value' => function($model) {
            /** @var $model User */
            return Html::a('<i class="fas fa-trash-restore"></i>','#', ['class' => 'btn-delete text-danger',
                'data-value'=> $model->id, 'data-url' => '','title' => 'Xóa']);
        },
        'format' => 'raw',
        'headerOptions' => ['width' => '1%', 'class' => 'text-center text-primary'],
        'contentOptions' => ['class' => 'text-center']
    ],
];   