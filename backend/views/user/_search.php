<?php
/** @var $model UserSearch */

use common\models\myAPI;
use common\models\searchs\UserSearch;
use common\models\User;
use yii\bootstrap\ActiveForm;

?>

<div class="modal fade bs-modal-lg" id="modal-search" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Tìm kiếm</h4>
            </div>
            <div class="modal-body">
                <div class="content-body">
                    <?php $form = ActiveForm::begin(['options' => ['id' => 'form-search']]); ?>
                    <div class="row">
                        <div class="col-md-4">
                            <?=$form->field($model, 'username')?>
                        </div>

                        <div class="col-md-4">
                            <?= $form->field($model, 'email') ?>
                        </div>

                        <div class="col-md-4">
                            <?=$form->field($model, 'status')->dropDownList(User::getListStatus(),
                                ['class' => 'form-control', 'prompt' => '- Chọn -', 'id' => 'quanlyusersearch-status1']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <div class="modal-footer">
                <?= myAPI::getBtnCloseModal(). myAPI::getBtnSearch() ?>
            </div>
        </div>
    </div>
</div>
