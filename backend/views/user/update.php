<?php

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $roles [] */
?>
<div class="user-update">

    <?= $this->render('_form', [
        'model' => $model,
        'roles' => $roles
    ]) ?>

</div>
