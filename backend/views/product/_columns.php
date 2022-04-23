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
            return '<a class="example-image-link" href="../images/product/'.$model->representation.'" data-lightbox="example-'.$model->id.'">
                        <img class="example-image" src="../images/product/'.$model->representation.'" alt="Ảnh đại diện" width="100px" />
                    </a>';
        },
        'format' => 'raw',
        'width' => '1%',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'trademark_name',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'cost',
        'contentOptions' => ['class' => 'text-right'],
        'value' => function($model) {
            return number_format($model->cost, 0, ',', '.') . ' VN';
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'price',
        'contentOptions' => ['class' => 'text-right'],
        'value' => function($model) {
            return number_format($model->price, 0, ',', '.') . ' VN';
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'features',
        'contentOptions' => ['class' => 'text-center'],
        'width' => '1%',
        'value' => function($model) {
            return $model->features == 1 ? '<i class="far fa-check-square"></i>' : '';
        },
        'format' => 'raw',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'newest',
        'contentOptions' => ['class' => 'text-center'],
        'width' => '1%',
        'value' => function($model) {
            return $model->newest == 1 ? '<i class="far fa-check-square"></i>' : '';
        },
        'format' => 'raw',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'sellest',
        'contentOptions' => ['class' => 'text-center'],
        'width' => '1%',
        'value' => function($model) {
            return $model->sellest == 1 ? '<i class="far fa-check-square"></i>' : '';
        },
        'format' => 'raw',
    ],
    [
        'header' => 'Sửa',
        'value' => function($model) {
            return Html::a('<i class="fas fa-edit"></i>', Url::toRoute(['product/update', 'id' => $model->id]),
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
                'data-value'=> $model->id, 'data-url' => 'product/delete','title' => 'Xóa']);
        },
        'format' => 'raw',
        'headerOptions' => ['width' => '1%', 'class' => 'text-center text-primary'],
        'contentOptions' => ['class' => 'text-center']
    ],
];   