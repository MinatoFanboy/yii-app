<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$form = ActiveForm::begin([
    'options' => [
        'enctype' => 'multipart/form-data',
        'id' => 'form-upload'
    ]]) ?>
<div class="form-group">
    <?= Html::label('File', 'file' )?>
    <?= Html::fileInput('file','', ['id' => 'file', 'accept' => '.xlsx'] )?>
</div>

<?php ActiveForm::end(); ?>