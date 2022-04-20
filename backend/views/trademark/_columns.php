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
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'file',
        'width' => '1%',
        'value' => function($model) {
            if ($model->file == 'no-image.jpeg') {
                return Html::img('../images/'.$model->file, ['width' => '100px', 'alt' => 'Không có ảnh']);
            } else {
                return '<a class="example-image-link" href="../images/trademark/'.$model->file.'" data-lightbox="example-'.$model->id.'">
                            <img class="example-image" src="../images/trademark/'.$model->file.'" alt="Ảnh đại diện" width="100px" />
                        </a>';
            }
        },
        'format' => 'raw',
        'filter' => false,
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
    ],
    [
        'header' => 'Sửa',
        'value' => function($model) {
            return Html::a('<i class="fas fa-edit"></i>', Url::toRoute(['trademark/update', 'id' => $model->id]),
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
                'data-value'=> $model->id, 'data-url' => 'trademark/delete','title' => 'Xóa']);
        },
        'format' => 'raw',
        'headerOptions' => ['width' => '1%', 'class' => 'text-center text-primary'],
        'contentOptions' => ['class' => 'text-center']
    ],
];   