<?php $this->title = 'Đơn hàng' ?>

<div class="m-t-125">
    <div class="container">
        <div class="row">
            <div class="m-lr-auto m-b-50">
                <div class="m-lr-0-xl">
                    <div class="wrap-table-shopping-cart">
                        <table class="table-shopping-cart">
                            <tr class="table_head">
                                <th class="column-1">Đơn hàng</th>
                                <th class="column-2">Thành tiền</th>
                                <th class="column-3">Thời gian</th>
                            </tr>

                            <?php foreach ($orders as $order): ?>
                                <tr class="table_row">
                                    <td class="column-1">
                                        # <?= $order->id ?>
                                    </td>
                                    <td class="column-2"><?= number_format($order->total, 0, ',', '.'). ' VNĐ' ?></td>
                                    <td class="column-3">
                                        <?= date('d/m/Y H:i:s', strtotime($order->created_at)) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>