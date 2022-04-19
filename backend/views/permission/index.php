<?php
/** @var $this View */
/** @var $groups [] */
/** @var $roles [] */

use yii\web\View;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Phân quyền';
?>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <?= Html::dropDownList('Nhóm chức năng', '', $groups, ['id' => 'group-activity', 'class' => 'form-control', 'prompt' => '- Chọn chức năng']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::begin(['options' => ['id' => 'form-permision']]) ?>
    <table class="table table-striped table-bordered text-nowrap" id="table-permission">
        <thead>
        <tr>
            <th width="1%">STT</th>
            <th>Chức năng</th>
            <?php foreach ($roles as $role): ?>
                <th width="1%"><?= $role ?></th>
            <?php endforeach ?>
        </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="4"><?= Html::a('<i class="glyphicon glyphicon-plus"></i> Thêm chức năng', '#',
                    ['class' => 'btn btn-primary', 'title' => 'Thêm chức năng']) ?></td>
        </tr>
        </tfoot>
    </table>
    <div class="form-group text-right">
        <?= Html::a('<i class="fas fa-save"></i> Lưu lại', '#', ['class' => 'btn btn-primary', 'id' => 'btn-save-permission']) ?>
    </div>
<?php ActiveForm::end(); ?>

<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/../backend/assets/js/permission.js', ['depends' => ['backend\assets\AppAsset'],
    'position' => View::POS_END]); ?>
