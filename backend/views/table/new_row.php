<?php
/** @var $count int */

use yii\helpers\Html; ?>

<tr>
    <td class="text-center stt"></td>
    <td><?= Html::textInput("Text[$count]", '', ['class' => 'form-control', 'type' => 'text']) ?></td>
    <td><?= Html::textInput("Date[$count]", '', ['class' => 'form-control hasDatePicker', 'type' => 'text']) ?></td>
    <td><?= Html::fileInput("FileDinhKem[$count]", '', ['class' => 'form-control']) ?></td>
    <td class="text-center">
        <a href="#" class="btn-add-row-after text-success"><i class="fa fa-plus-circle"></i></a><br/>
        <a href="#" class="btn-delete-row text-danger"><i class="fa fa-minus-circle"></i></a>
    </td>
</tr>
