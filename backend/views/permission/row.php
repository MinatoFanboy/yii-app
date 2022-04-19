<?php

use yii\helpers\Html;
?>

<?php foreach ($activities as $index => $activity): ?>
    <tr>
        <td class="text-center"><?= $index + 1 ?></td>
        <td><?= $activity->name ?></td>
        <?php foreach ($roles as $role_id => $role): ?>
            <td class="text-center">
                <label class="form-control">
                    <?= Html::checkbox("Permission[{$activity->id}][{$role_id}]", "")?>
                </label>
            </td>
        <?php endforeach;?>
    </tr>
<?php endforeach; ?>
