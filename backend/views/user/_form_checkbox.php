<?php
use yii\helpers\Html;
?>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th width="1%">STT</th>
            <th>Tên đăng nhập</th>
            <th>Điện thoại</th>
            <th width="1%">Xóa</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $index => $user): ?>
            <tr>
                <td class="text-center"><?= $index + 1 ?></td>
                <td><?= $user->username ?></td>
                <td><?= $user->phone ?></td>
                <td class="text-center">
                    <?= Html::a('<i class="fa fa-minus-circle"></i></a>', '#', ['class' => 'btn-delete-row text-danger']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>