<?php

return [
    // [
    //     'class' => 'kartik\grid\CheckboxColumn',
    //     'width' => '20px',
    // ],
    [
        'headerOptions' => ['class' => 'text-primary text-nowrap'],
        'contentOptions' => ['class' => 'text-nowrap'],
        'header' => 'STT',
        'class' => 'kartik\grid\SerialColumn',
        'width' => '1%',
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'id',
    // ],
    [
        'headerOptions' => ['class' => 'text-nowrap'],
        'contentOptions' => ['class' => 'text-nowrap'],
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'title',
        'width' => '1%',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'content',
    ],
    [
        'headerOptions' => ['class' => 'text-nowrap'],
        'contentOptions' => ['class' => 'text-nowrap'],
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'unread',
        'width' => '1%',
        'value' => function ($model) {
            return $model->unread == 0 ? '<span class="text-primary"><i class="fas fa-eye"></i> Chưa đọc</span>' : '<span class="text-primary"><i class="fas fa-eye-slash"></i> Đã đọc</span>';
        },
        'format' => 'raw',
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'created_at',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'updated_at',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'received_id',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'user_id',
    // ],
    // [
    //     'class' => 'kartik\grid\ActionColumn',
    //     'dropdown' => false,
    //     'vAlign'=>'middle',
    //     'urlCreator' => function($action, $model, $key, $index) {
    //             return Url::to([$action,'id'=>$key]);
    //     },
    //     'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
    //     'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
    //     'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete',
    //                       'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
    //                       'data-request-method'=>'post',
    //                       'data-toggle'=>'tooltip',
    //                       'data-confirm-title'=>'Are you sure?',
    //                       'data-confirm-message'=>'Are you sure want to delete this item'],
    // ],
];
