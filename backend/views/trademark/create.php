<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Trademark */

$this->title = 'Thêm thương hiệu';
?>
<div class="trademark-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
