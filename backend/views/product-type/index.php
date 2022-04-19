<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchs\ProductTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Loại sản phẩm';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="product-type-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'summary' => "Hiển thị {begin} - {end} trong số {totalCount}",
            'emptyText' => 'Không có bản ghi nào',
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i> Thêm loại sản phẩm', ['create'],
                    ['role'=>'modal-remote','title'=> 'Thêm loại sản phẩm','class'=>'btn btn-primary']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i> Khôi phục lưới', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Khôi phục lưới'])
                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'primary', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> Danh sách loại sản phẩm',
            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
