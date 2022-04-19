<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Slider */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="slider-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'link')->textInput() ?>
        </div>
    </div>

    <?= $form->field($model, 'content')->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'pictures[]')->fileInput(['accept' => 'image/*', 'multiple' => 'multiple']) ?>
  
	<div class="form-group text-right">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fas fa-save"></i> Thêm mới' : '<i class="fas fa-save"></i> Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	</div>

    <?php ActiveForm::end(); ?>
    
</div>
