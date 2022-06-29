<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\myAPI;

return [
    [
        'header' => 'STT',
        'headerOptions' => ['class' => 'text-primary'],
        'contentOptions' => ['class' => 'td-user'],
        'class' => 'kartik\grid\SerialColumn',
        'width' => '1%',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
    ],
    // [
    //     'contentOptions' => ['class' => 'td-select'],
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'active',
    //     'width' => '1%',
    //     'value' => function($model) {
    //         return Html::dropDownList('active', '',[
    //             0 => 'Duyệt',
    //             1 => 'Không duyệt',
    //         ], ['class' => 'form-control select-input', 'prompt' => '- Hình thức -']);
    //     },
    //     'format' => 'raw',
    // ],
    // [
    //     'header' => 'Duyệt',
    //     'value' => function($model) {
    //         return Html::a('<i class="fas fa-check"></i>', '#', ['title' => 'Duyệt', 'class' => 'duyet-san-pham', 'data-value' => $model->id]);
    //     },
    //     'format' => 'raw',
    //     'headerOptions' => ['width' => '1%', 'class' => 'text-center text-primary'],
    //     'contentOptions' => ['class' => 'text-center']
    // ],
    [
        'header' => 'Sửa',
        'value' => function($model) {
            return Html::a('<i class="fas fa-edit"></i>', Url::toRoute(['product-type/update', 'id' => $model->id]),
                ['role' => 'modal-remote', 'data-toggle' => 'tooltip', 'title' => 'Cập nhật']);
        },
        'format' => 'raw',
        'headerOptions' => ['width' => '1%', 'class' => 'text-center text-primary'],
        'contentOptions' => ['class' => 'text-center']
    ],
    [
        'header' => 'Xoá',
        'value' => function($model) {
            return Html::a('<i class="fas fa-trash-restore"></i>','#', ['class' => 'btn-delete text-danger',
                'data-value'=> $model->id, 'data-url' => 'product-type/delete','title' => 'Xóa']);
        },
        'format' => 'raw',
        'headerOptions' => ['width' => '1%', 'class' => 'text-center text-primary'],
        'contentOptions' => ['class' => 'text-center']
    ],
];   