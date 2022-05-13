<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Đăng nhập';
?>

<div class="p-t-165 p-b-85">
    <div class="container">
        <div class="site-login">
            <div class="row">
                <div class="col-lg-5">
                    <?php $form = ActiveForm::begin(['id' => 'login-form']);?>

                        <?=$form->field($model, 'username')->textInput(['autofocus' => true])?>

                        <?=$form->field($model, 'password')->passwordInput()?>

                        <div style="color:#999;margin:1em 0">
                            Quên mật khẩu ? <?= Html::a('Khôi phục mật khẩu', ['site/request-password-reset']) ?>
                        </div>

                        <div class="form_group">
                            <?= Html::submitButton('Đăng nhập', ['name' => 'login-button', 'class' => 'btn-login size-103 hov-btn2 bg1 bor1 cl0 stext-101']) ?>
                            <?= Html::a('Đăng ký', ['site/signup'], ['class' => 'text-center', 'class' => 'btn-register size-103 stext-101 bor1']) ?>
                        </div>

                    <?php ActiveForm::end();?>
                </div>
            </div>
        </div>
    </div>
</div>
