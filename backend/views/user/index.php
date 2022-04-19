<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchs\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Danh sách người dùng';

CrudAsset::register($this);
?>

<?php ActiveForm::begin([
    'options' => ['id' => 'form-select-user']
]) ?>
    <p id="label-user-selected" class="hidden">Người dùng đã chọn: </p>
    <ul id="user-selected" class="list-inline list-unstyled"></ul>
<?php ActiveForm::end(); ?>

<div class="user-index">
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
                    Html::a('<i class="glyphicon glyphicon-plus"></i> Thêm người dùng', ['create'],
                    ['role' => 'modal-remote', 'title' => 'Thêm người dùng', 'class' => 'btn btn-primary']).
                    Html::a('<i class="fas fa-check"></i> Checkbox', '#', ['title'=> 'Checkbox', 'class'=>'btn btn-primary blue', 'id' => 'btn-checkbox']).
                    Html::a('<i class="fas fa-search"></i> Tìm kiếm', '#',
                    ['title'=> 'Tìm kiếm', 'class'=>'btn btn-primary', 'data-target' => '#modal-search', 'data-toggle' => 'modal']).
                    Html::a('<i class="fas fa-download"></i> Tải xuống', '#',
                    ['class'=>'btn blue btn-primary btn-download', 'data-url' => 'user/download']).
                    Html::a('<i class="fas fa-upload"></i> Tải lên', '#',
                    ['class'=>'btn blue btn-warning btn-upload', 'data-url' => 'user/upload']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i> Khôi phục lưới', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Khôi phục lưới'])
                ],
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'responsiveWrap' => false,
            'tableOptions' => ['class' => 'text-nowrap'],
//            'floatHeader' => true,
            'panel' => [
                'type' => 'primary',
                'heading' => '<i class="glyphicon glyphicon-list"></i> Danh sách người dùng',
            ],
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",
    "size" => Modal::SIZE_LARGE
])?>
<?php Modal::end(); ?>

<?=$this->render('_search', ['model' => $searchModel]) ?>

<!--$this->registerCssFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/admin/pages/css/profile-old.css');-->

<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/../backend/assets/js/user.js', ['depends' => ['backend\assets\AppAsset'],
    'position' => View::POS_END]); ?>
