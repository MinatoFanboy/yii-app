<?php
/** @var $this View */
$this->title = 'Table';

use yii\web\View;

?>

<div class="table-responsive table-container">
    <table class="table table-bordered table-striped text-nowrap">
        <thead>
        <tr>
            <th class="text-center" width="1%">STT</th>
            <th class="text-center">Tên</th>
            <th class="text-center">Ngày sinh</th>
            <th class="text-center">Điện thoại</th>
            <th>Mô tả</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="text-center">1</td>
            <td>Phạm Trung Thành</td>
            <td class="text-center">03/12/1999</td>
            <td>0399325199</td>
            <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</td>
        </tr>
        <tr>
            <td class="text-center">2</td>
            <td>Nguyễn Huy Hùng</td>
            <td class="text-center">08/05/1999</td>
            <td>0214536845</td>
            <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</td>
        </tr>
        <tr>
            <td class="text-center">3</td>
            <td>Nguyễn Duy Tùng</td>
            <td class="text-center">05/12/1999</td>
            <td>0157634485</td>
            <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</td>
        </tr>
        <tr>
            <td class="text-center">4</td>
            <td>Đào Thị Lành</td>
            <td class="text-center">14/02/1999</td>
            <td>0245475555</td>
            <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</td>
        </tr>
        <tr>
            <td class="text-center">5</td>
            <td>Nguyễn Thị Hương</td>
            <td class="text-center">23/06/1999</td>
            <td>0241245575</td>
            <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</td>
        </tr>
        <tr>
            <td class="text-center">6</td>
            <td>Trần Văn Chung</td>
            <td class="text-center">25/01/1999</td>
            <td>0325477456</td>
            <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</td>
        </tr>
        <tr>
            <td class="text-center">7</td>
            <td>Nguyễn Quang Anh</td>
            <td class="text-center">30/07/1999</td>
            <td>03148745554</td>
            <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</td>
        </tr>
        <tr>
            <td class="text-center">8</td>
            <td>Trần Anh Dũng</td>
            <td class="text-center">20/10/1999</td>
            <td>0245475555</td>
            <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</td>
        </tr>
        <tr>
            <td class="text-center">9</td>
            <td>Vũ Văn Thái</td>
            <td class="text-center">13/07/1999</td>
            <td>0245475555</td>
            <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</td>
        </tr>
        <tr>
            <td class="text-center">10</td>
            <td>Trần Văn Phong</td>
            <td class="text-center">24/04/1999</td>
            <td>0245475555</td>
            <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</td>
        </tr>
        </tbody>
    </table>
</div>

<?php $this->registerCssFile(Yii::$app->request->baseUrl . '/../backend/assets/css/table.css'); ?>
