<?php

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $roles [] */

?>
<div class="user-create">
    <?= $this->render('_form', [
        'model' => $model,
        'roles' => $roles
    ]) ?>
</div>
