<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Trademark */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trademark-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*']) ?>

	<?php if (!$model->isNewRecord):  ?>
		<div id="img-representation">
			<?php if ($model->file == 'no-image.jpeg'): ?>
				<img src="../images/<?= $model->file ?>" width="150px">
			<?php else: ?>
				<div class="row">
					<div class="col-md-2 picture-preview text-center">
						<img src="../images/trademark/<?= $model->file ?>" width="150px">
						<div class="picture-preview-activity">
							<a class="example-image-link text-muted" href="../images/trademark/<?= $model->file ?>" data-lightbox="example-set">
								<i class="fas fa-eye"></i>
							</a>
							<a href="#" class="delete-picture-preview text-muted" data-value="<?= $model->id ?>">
								<i class="fas fa-trash-restore"></i>
							</a>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	<?php endif; ?>
  
	<hr />
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group text-right">
	        <?= Html::submitButton($model->isNewRecord ? '<i class="fas fa-save"></i> Thêm mới' : '<i class="fas fa-save"></i> Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
