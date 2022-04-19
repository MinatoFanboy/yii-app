<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchs\VaiTroSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vai trò';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="vai-tro-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'summary' => "Hiển thị {begin} - {end} Trên tổng số {totalCount}",
            'emptyText' => 'Không có bản ghi nào',
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i> Thêm vai trò', ['create'],
                    ['role'=>'modal-remote','title'=> 'Thêm vai trò','class'=>'btn btn-primary']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i> Khôi phục lưới', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Khôi phục lưới'])
                ],
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'panel' => [
                'type' => 'primary',
                'heading' => '<i class="glyphicon glyphicon-list"></i> Danh sách vai trò',
            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",
])?>
<?php Modal::end(); ?>
