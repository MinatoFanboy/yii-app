<?php
/** @var $ghiChus GhiChu[] */

use common\models\GhiChu;
use common\models\myAPI;
use yii\helpers\Html;

?>
<?php foreach ($ghiChus as $index => $ghiChu): ?>
    <tr>
        <td class="text-center stt"><?= $index + 1 ?></td>
        <td>
            <?= Html::hiddenInput("OldId[$ghiChu->id]", $ghiChu->id, ['class' => 'form-control']) ?>
            <?= Html::textInput("OldText[$ghiChu->id]", $ghiChu->name, ['class' => 'form-control']) ?>
        </td>
        <td>
            <?= Html::textInput("OldDate[$ghiChu->id]", date('d/m/Y', strtotime($ghiChu->ngay_thuc_hien)), ['class' => 'form-control hasDatePicker', 'type' => 'text']) ?>
        </td>
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
