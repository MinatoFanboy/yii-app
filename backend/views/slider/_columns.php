<?php
use yii\helpers\Url;
use yii\helpers\Html;

return [
    [
        'header' => 'STT',
        'headerOptions' => ['class' => 'text-primary'],
        'contentOptions' => ['class' => 'td-user'],
        'class' => 'kartik\grid\SerialColumn',
        'width' => '1%',
    ],
    [
        'header'=>'Ảnh đại diện',
        'headerOptions' => ['class' => 'text-primary'],
        'value' => function($model) {
            return '<a class="example-image-link" href="../images/slider/'.$model->representation.'" data-lightbox="example-'.$model->id.'">
                        <img class="example-image" src="../images/slider/'.$model->representation.'" alt="image-1" width="100px" />
                    </a>';
        },
        'format' => 'raw',
        'width' => '1%',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'title',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'content',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'link',
    ],
    [
        'header' => 'Sửa',
        'value' => function($model) {
            return Html::a('<i class="fas fa-edit"></i>', Url::toRoute(['slider/update', 'id' => $model->id]),
                ['title' => 'Cập nhật']);
        },
        'format' => 'raw',
        'headerOptions' => ['width' => '1%', 'class' => 'text-center text-primary'],
        'contentOptions' => ['class' => 'text-center']
    ],
    [
        'header' => 'Xoá',
        'value' => function($model) {
            return Html::a('<i class="fas fa-trash-restore"></i>','#', ['class' => 'btn-delete text-danger',
                'data-value'=> $model->id, 'data-url' => 'slider/delete','title' => 'Xóa']);
        },
        'format' => 'raw',
        'headerOptions' => ['width' => '1%', 'class' => 'text-center text-primary'],
        'contentOptions' => ['class' => 'text-center']
    ],
];   