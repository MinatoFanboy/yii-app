<?php

use common\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
/* @var $roles [] */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if ($model->isNewRecord): ?>
        <?= $form->field($model, 'username')->textInput() ?>
    <?php endif; ?>
    <?= $form->field($model, 'password_hash')->textInput(['type' => 'password']) ?>

    <?= $form->field($model, 'name')->textInput(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'phone')->textInput(); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'email')->textInput(['type' => 'email']); ?>
        </div>
    </div>

    <?= $form->field($model, 'status')->dropDownList(User::getListStatus(), ['prompt' => '- Chọn -']) ?>

    <?= $form->field($model, 'roles')->checkboxList($roles) ?>

	<?php if (!Yii::$app->request->isAjax): ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php endif; ?>

    <?php ActiveForm::end(); ?>
</div>
