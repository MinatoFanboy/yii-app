$(document).ready(function() {
    $(document).on('click', '.duyet-san-pham', function(e) {
        e.preventDefault();
        const target = $(this);

        const id = $(this).attr('data-value');
        const value = target.parent().parent().find('.td-select > .select-input').val();

        $.ajax({
            url: 'index.php?r=product-type/update-status',
            method: 'post',
            data: {id, value},
            dataType: 'json',
            beforeSend: function() {

            },
            success: function() {
                if (value == 1) {
                    target.parent().parent().find('.td-select').html('<p class="text-primary">Duyệt</p>');
                } else {
                    target.parent().parent().find('.td-select').html('<p class="text-danger">Không duyệt</p>');
                }
            },
            complete: function() {

            },
            error: function() {

            }
        })
    })
})