<?php
/* @var $searchModel common\models\searchs\UserSearch */

use common\models\myAPI;
use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;

return [
    [
        'class' => 'yii\grid\CheckboxColumn',
        'headerOptions' => ['width' => '1%'],
        'checkboxOptions' => function ($model, $key, $index, $column) {
            /** @var $model User */
            return [
                'value' => $model->id,
            ];
        },
        'contentOptions' => ['class' => 'td-user']
    ],
    [
        'header' => 'STT',
        'headerOptions' => ['class' => 'text-primary'],
        'contentOptions' => ['class' => 'td-user'],
        'class' => 'kartik\grid\SerialColumn',
        'width' => '1%',
    ],
    [
        'header' => '',
        'headerOptions' => ['class' => 'text-primary', 'width' => '1%'],
        'contentOptions' => ['class' => 'text-center'],
        'value' => function($model){
            /** @var $model User */
            $str = '<div class="btn-group dropup">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-cogs"></i> Chức năng <i class="fas fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu list-inline">
                            '.implode('', [
                            '<li><a href="#" class="btn-detail" data-value="'.$model->id.'" title="Chi tiết"><i class="fa fa-eye"></i> Chi tiết</a></li>',
                        ]).'
                        </ul>                       
                    </div>';
            return implode('', [
                $str,
            ]);
        },
        'format' => 'raw',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'contentOptions' => ['class' => 'td-user'],
        'attribute'=>'username',
        'width' => '1%',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'contentOptions' => ['class' => 'td-user'],
        'attribute'=>'name',
        'width' => '1%',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'contentOptions' => ['class' => 'td-user'],
        'attribute'=>'phone',
        'width' => '1%',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'contentOptions' => ['class' => 'td-user'],
        'attribute'=>'email',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'contentOptions' => ['class' => 'td-user'],
        'attribute'=>'role',
        'width' => '1%',
    ],
     [
         'class'=>'\kartik\grid\DataColumn',
         'contentOptions' => ['class' => 'td-user'],
         'attribute'=>'status',
         'value' => function($model){
             /** @var $model User */
             return User::getListStatus()[$model->status];
         },
        'width' => '1%',
         'filter' => Html::activeDropDownList($searchModel, 'status', User::getListStatus(),
             ['class' => 'form-control', 'prompt' => '- Chọn -'])
     ],
     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'created_at',
         'contentOptions' => ['class' => 'text-center td-user'],
         'value' => function($model){
            /** @var $model User */
            return date('d/m/Y', strtotime($model->created_at));
         },
        'width' => '1%',
         'filter' => myAPI::activeDateFieldNoLabel($searchModel,'created_at')
     ],
    [
        'header' => 'Sửa',
        'value' => function($model) {
            /** @var $model User */
            return $model->id != 1 ? Html::a('<i class="fas fa-edit"></i>', Url::toRoute(['user/update', 'id' => $model->id]),
                ['role' => 'modal-remote', 'data-toggle' => 'tooltip', 'title' => 'Cập nhật']) : '';
        },
        'format' => 'raw',
        'headerOptions' => ['width' => '1%', 'class' => 'text-center text-primary'],
        'contentOptions' => ['class' => 'text-center']
    ],
    [
        'header' => 'Xoá',
        'value' => function($model) {
            /** @var $model User */
            return $model->id != 1 ? Html::a('<i class="fas fa-trash-restore"></i>','#', ['class' => 'btn-delete text-danger',
                'data-value'=> $model->id, 'data-url' => 'user/delete-user','title' => 'Xóa']) : '';
        },
        'format' => 'raw',
        'headerOptions' => ['width' => '1%', 'class' => 'text-center text-primary'],
        'contentOptions' => ['class' => 'text-center']
    ],
];
