<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>Xin chào <?= Html::encode($user->username) ?>,</p>

    <p>Click vào link bên dưới để khôi phục mật khẩu:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
