$(document).ready(function() {
    $(document).on('change', '#group-activity', function(e) {
        e.preventDefault();
        const group = $(this).val();

        $.ajax({
            url: 'index.php?r=permission/load',
            data: {group},
            dataType: 'json',
            type: 'post',
            beforeSend: function () {
                $.blockUI();
            },
            success: function (data) {
                $('#table-permission tbody').html(data.body)
            },
            complete: function () {
                $.unblockUI();
            },
            error: function (r1, r2) {
                console.log(r1.responseText)
            }
        });
    })

    $(document).on('click', '#btn-save-permission', function(e) {
        e.preventDefault();
        SaveObject("permission/save", $("#form-permision").serializeArray(), function (data) {});
    })
})