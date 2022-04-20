<?php
use yii\helpers\Html;
use common\models\myAPI;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'short_description')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="row">
        <div class="col-md-6">
            <?= myAPI::activeDateField2($form, $model, 'exist_day', 'Ngày hàng về') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'cost')->widget(MaskedInput::className(), [
                'clientOptions' => [
                    'alias' => 'numeric',
                    'allowMinus'=>false,
                    'groupSize'=>3,
                    'radixPoint'=> ",",
                    'groupSeparator' => '.',
                    'autoGroup' => true,
                    'removeMaskOnSubmit' => true
                ], 'options' => ['min' => 0]
            ]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'price')->widget(MaskedInput::className(), [
                'clientOptions' => [
                    'alias' => 'numeric',
                    'allowMinus'=>false,
                    'groupSize'=>3,
                    'radixPoint'=> ",",
                    'groupSeparator' => '.',
                    'autoGroup' => true,
                    'removeMaskOnSubmit' => true
                ], 'options' => ['min' => 0]
            ]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'price_sale')->widget(MaskedInput::className(), [
                'clientOptions' => [
                    'alias' => 'numeric',
                    'allowMinus'=>false,
                    'groupSize'=>3,
                    'radixPoint'=> ",",
                    'groupSeparator' => '.',
                    'autoGroup' => true,
                    'removeMaskOnSubmit' => true
                ], 'options' => ['min' => 0]
            ]); ?>
        </div>
    </div>

    <?= $form->field($model, 'features')->textInput() ?>

    <?= $form->field($model, 'newest')->textInput() ?>

    <?= $form->field($model, 'sellest')->textInput() ?>

    <?= $form->field($model, 'trademark_id')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? '<i class="fas fa-save"></i> Thêm mới' : '<i class="fas fa-save"></i> Cập nhật', 
                ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
</div>
