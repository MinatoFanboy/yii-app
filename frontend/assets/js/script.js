function tinhTongTien(){
    var $thanh_tien = 0;
    $("#gio-hang tbody tr").each(function () {
        var $myTr = $(this);
        var $so_luong = parseInt($myTr.find('td.product_quantity input').val(), 10);
        var $gia_ban = parseInt($myTr.find('td.product-price input').val(), 10);
        var $tong_tien = $so_luong * $gia_ban;
        $thanh_tien += $tong_tien;
    })
    $('.cart_amount').text($thanh_tien.toLocaleString('vi'));
}

$(document).ready(function () {
    $(document).on('click', '.add_to_cart a, .product_cart_button a, #san-pham-tim-kiem', function (e) {
        e.preventDefault();
        // console.log($(this).attr('data-value'))
        $.ajax({
            // type: 'post',
            url: 'them-vao-gio-hang.html',
            data: {code: $(this).attr('data-value')},
            beforeSend: function() {
                $('.thong-bao').html('');
                $.blockUI({message: "Vui lòng chờ trong giây lát"});
            },
            success:function( data ) {
                alert(data.message);
                $('.mini_cart').html(data.mini_cart);
                $('.mini_cart_wrapper').html(data.mini_cart_wrapper);
            },
            complete: function() {
                $.unblockUI();
            },
            dataType: 'json',
        });
    });

    $(document).on('click', '.them-san-pham', function (e) {
        e.preventDefault();
        $.ajax({
            // type: 'post',
            url: 'them-vao-gio-hang.html',
            data: $("#form-add-to-cart").serializeArray(),
            beforeSend: function() {
                $('.thong-bao').html('');
                $.blockUI({message: "Vui lòng chờ trong giây lát"});
            },
            success:function( data ) {
                alert(data.message);
                $('.mini_cart').html(data.mini_cart);
                $('.mini_cart_wrapper').html(data.mini_cart_wrapper);
            },
            complete: function() {
                $.unblockUI();
            },
            dataType: 'json',
        });
    });

    $(document).on('change', '.product_quantity input', function (e) {
        var $so_luong = parseInt($(this).val(), 10);
        var $myTr = $(this).parent().parent();
        var $gia_ban = parseInt($myTr.find('td.product-price input').val(), 10);
        var $tong_tien = $so_luong * $gia_ban;
        $myTr.find('td.product_total').text($tong_tien.toLocaleString('vi'));

        tinhTongTien();
    });

    $(document).on('click', '.cart_submit a', function (e) {
        e.preventDefault();
        // console.log($(this).attr('data-value'))
        $.ajax({
            // type: 'post',
            url: 'cap-nhat-gio-hang.html',
            data: $("#form-cap_nhat_gio_hang").serializeArray(),
            beforeSend: function() {
                $('.thong-bao').html('');
                $.blockUI({message: "Vui lòng chờ trong giây lát"});
            },
            success:function( data ) {
                alert(data.message);
            },
            complete: function() {
                $.unblockUI();
            },
            dataType: 'json',
        });
    });
})