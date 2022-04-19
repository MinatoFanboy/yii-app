<?php
/* @var $searchModel common\models\searchs\ActivitySearch */

use common\models\Activity;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

return [
    [
        'header' => 'STT',
        'headerOptions' => ['class' => 'text-primary'],
        'class' => 'kartik\grid\SerialColumn',
        'width' => '1%',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'controller_action',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'group',
        'filter' => Html::activeDropDownList($searchModel, 'group', ArrayHelper::map(Activity::find()
            ->distinct('group')->all(), 'group', 'group'), ['class' => 'form-control', 'prompt' => '- Chọn -']),
    ],
    [
        'header' => 'Sửa',
        'value' => function($model) {
            /** @var $model ChucNang */
            return Html::a('<i class="fas fa-edit"></i>', Url::toRoute(['activity/update', 'id' => $model->id]),
                ['role' => 'modal-remote', 'data-toggle' => 'tooltip', 'title' => 'Cập nhật']);
        },
        'format' => 'raw',
        'headerOptions' => ['width' => '1%', 'class' => 'text-center text-primary'],
        'contentOptions' => ['class' => 'text-center']
    ],
    [
        'header' => 'Xoá',
        'value' => function($model) {
            /** @var $model ChucNang */
            return Html::a('<i class="fas fa-trash-restore"></i>','#', ['class' => 'btn-delete text-danger',
                'data-value'=> $model->id, 'data-url' => 'activity/delete','title' => 'Xóa']);
        },
        'format' => 'raw',
        'headerOptions' => ['width' => '1%', 'class' => 'text-center text-primary'],
        'contentOptions' => ['class' => 'text-center']
    ],
];
