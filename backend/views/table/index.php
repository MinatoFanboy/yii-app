<?php
/** @var $this View */
/** @var $ghiChus GhiChu[] */

use common\models\GhiChu;
use common\models\myAPI;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

$this->title = 'Bảng';
?>

<?php ActiveForm::begin(['options' => ['id' => 'form-table', 'enctype' => 'multipart/form-data']]) ?>
<div class="hidden" data-value="0" id="count"></div>
<table class="table table-striped table-bordered" style="padding: 20px" id="table">
    <thead>
    <tr>
        <th class="text-center" width="1%">STT</th>
        <th class="text-center">Tên</th>
        <th class="text-center text-nowrap">Ngày tháng</th>
        <th class="text-center text-nowrap">File đính kèm</th>
        <th class="text-center" width="1%">CN</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($ghiChus as $index => $ghiChu): ?>
            <tr>
                <td class="text-center stt"><?= $index + 1 ?></td>
                <td>
                    <?= Html::hiddenInput("OldId[$ghiChu->id]", $ghiChu->id, ['class' => 'form-control']) ?>
                    <?= Html::textInput("OldText[$ghiChu->id]", $ghiChu->name, ['class' => 'form-control']) ?>
                </td>
                <td><?= myAPI::dateField2("OldDate[$ghiChu->id]", $ghiChu->ngay_thuc_hien) ?></td>
                <td>
                    <?php if ($ghiChu->file): ?>
                        <?= Html::a($ghiChu->file, '../uploads/'.$ghiChu->file, ['target' => '_blank']) ?>
                        <?= Html::a('<i class="fas fa-trash"></i>', '#', ['class' => 'btn-delete-file text-danger']) ?><br />
                    <?php endif; ?>
                    <?= Html::fileInput("OldFileDinhKem[$ghiChu->id]", '', ['class' => 'form-control']) ?>
                </td>
                <td class="text-center">
                    <a href="#" class="btn-add-row-after text-success" data-value="<?= $ghiChu->id ?>"><i class="fa fa-plus-circle"></i></a><br/>
                    <a href="#" class="btn-delete-row text-danger" data-value="<?= $ghiChu->id ?>"><i class="fa fa-minus-circle"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="4"><?= Html::a('<i class="fas fa-plus"></i> Thêm', '#', ['class' => 'btn btn-primary',
                'id' => 'btn-add-row']) ?></td>
    </tr>
    </tfoot>
</table>

<div class="form-group text-right">
    <?= Html::a('<i class="fas fa-save"></i> Lưu lại', '#', ['class' => 'btn btn-primary', 'id' => 'btn-save-table']) ?>
</div>

<?php ActiveForm::end() ?>

<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/../backend/assets/js/table.js', ['depends' => ['backend\assets\AppAsset'],
    'position' => View::POS_END]); ?>
