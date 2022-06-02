<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model LoginForm */

use backend\assets\LoginAsset;
use yii\helpers\Html;

$this->title = 'Đăng nhập';
LoginAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="container-fluid">
    <div class="row">
        <main class="col-md-6 mx-sm-auto px-4">

            <?= \yii\bootstrap\Html::beginForm('', '', ['class' => 'form-signin']) ?>

            <h1 class="h3 mb-3 font-weight-normal text-center">Đăng nhập</h1>

            <?= Html::activeTextInput($model, 'username', ['type' => 'text', 'placeholder' => 'Tên đăng nhập', 'autofocus' => 'autofocus', 'class' => 'form-control']) ?>
            <?= $model->hasErrors() ? $model->getFirstError('username') : '' ?>

            <?= Html::activeTextInput($model, 'password', ['type' => 'password', 'placeholder' => 'Mật khẩu', 'autocomplete' => 'new-password', 'class' => 'form-control']) ?>
            <?= $model->hasErrors() ? $model->getFirstError('password') : '' ?>

            <?= Html::submitButton('Đăng nhập', ['class' => 'btn btn-lg btn-primary btn-block']) ?>
            <?= \yii\bootstrap\Html::endForm() ?>

        </main>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
