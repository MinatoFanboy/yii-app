<?php
use yii\web\View;
use yii\helpers\Html;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchs\TrademarkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Thương hiệu';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="trademark-index">
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
                    Html::a('<i class="glyphicon glyphicon-plus"></i> Thêm thương hiệu', ['create'],
                    ['title'=> 'Thêm thương hiệu','class'=>'btn btn-primary']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i> Khôi phục lưới', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Khôi phục lưới'])
                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'primary', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> Danh sách Thương hiệu',
            ]
        ])?>
    </div>
</div>

<?php $this->registerCssFile(Yii::$app->request->baseUrl.'/../backend/assets/plugins/lightbox2/dist/css/lightbox.min.css'); ?>

<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/../backend/assets/plugins/lightbox2/dist/js/lightbox.min.js', 
    ['depends' => ['backend\assets\AppAsset'], 'position' => View::POS_END]); ?>