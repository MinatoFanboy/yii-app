<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Thông tin cá nhân';
?>

<?php $form = ActiveForm::begin() ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'password')->textInput(['type' => 'password']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'new_password')->textInput(['type' => 'password']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'repeat_new_password')->textInput(['type' => 'password']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Xác nhận', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end() ?>