<?php
use yii\helpers\Html;
use common\models\myAPI;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use dosamigos\ckeditor\CKEditor;

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

    <?= $form->field($model, 'description')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'full'
    ]) ?>

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

    <?= $form->field($model, 'features')->checkbox() ?>

    <?= $form->field($model, 'newest')->checkbox() ?>

    <?= $form->field($model, 'sellest')->checkbox() ?>

    <?= $form->field($model, 'trademark_id')->dropDownList($trademarks, ['prompt' => '- Chọn -']) ?>

    <?= $form->field($model, 'images[]')->fileInput(['accept' => 'image/*', 'multiple' => 'multiple']) ?>

    <?php if (!$model->isNewRecord):  ?>
        <div class="row">
            <?php foreach ($product_images as $product_image): ?>
                <div class="col-md-2 picture-preview text-center">
                    <img src="../images/product/<?= $product_image->file ?>" width="150px">
                    <div class="picture-preview-activity">
                        <a class="example-image-link text-muted" href="../images/product/<?= $product_image->file ?>" data-lightbox="example-set">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="#" class="delete-picture-preview text-muted" data-value="<?= $product_image->id ?>">
                            <i class="fas fa-trash-restore"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? '<i class="fas fa-save"></i> Thêm mới' : '<i class="fas fa-save"></i> Cập nhật', 
                ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
</div>
