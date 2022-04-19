<?php

use common\models\User;

/* @var $model User */
?>
<div class="user-detail">

    <p><strong>Tên đăng nhập: </strong><?= $model->username ?></p>
    <p><strong>Email: </strong><?= $model->email ?></p>
    <p><strong>Trạng thái: </strong><?= User::getListStatus()[$model->status] ?></p>
    <p><strong>Ngày tạo: </strong><?= date('d/m/Y', strtotime($model->created_at)) ?></p>

</div>
