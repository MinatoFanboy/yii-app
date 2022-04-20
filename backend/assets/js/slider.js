$(document).ready(function() {
    $(document).on('click', '.delete-picture-preview', function(e) {
        e.preventDefault();
        const id = $(this).attr('data-value');
        const link = $(this);

        $.ajax({
            url: 'index.php?r=slider/delete-picture',
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
                link.parent().parent().remove();
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