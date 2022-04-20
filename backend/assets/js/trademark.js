$(document).ready(function() {
    $(document).on('click', '.delete-picture-preview', function(e) {
        e.preventDefault();
        const id = $(this).attr('data-value');

        $.ajax({
            url: 'index.php?r=trademark/delete-picture',
            data: {id},
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $.blockUI();
            },
            success: function (data) {
                $.dialog({
                    content: data.content,
                    title: data.title,
                    type: 'blue',
                });
                $('#img-representation').html('<img src="../images/no-image.jpeg" width="150px">');
            },
            error: function (r1, r2){
                $.dialog({
                    content: getMessage(r1.responseText),
                    title: 'Thông báo',
                    type: 'red',
                });
                return false;
            },
            complete: function () {
                $.unblockUI();
            }
        });
    })
})