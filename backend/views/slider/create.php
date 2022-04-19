<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Slider */

$this->title = 'Thêm slider';

?>
<div class="slider-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
