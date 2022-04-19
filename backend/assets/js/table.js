function createSTT() {
    $('.stt').each(function (key, value) {
        $(this).text(key + 1);
    });
}

function createDatePicker(target) {
    const currentTime = new Date();
    const start_year = currentTime.getFullYear() - 3;
    const end_year = currentTime.getFullYear() + 1;

    $(target).datepicker($.extend({}, $.datepicker.regional['vi'], {"dateFormat":"dd/mm/yy", "changeMonth":true, "yearRange":`${start_year}:${end_year}`, "changeYear":true}));
}

$(document).ready(function () {
    $(document).on('click', '#btn-add-row', function (e) {
        e.preventDefault();
        const count = $('#count').attr('data-value');

        $.ajax({
            url: 'index.php?r=table/add-new-row',
            type: 'post',
            dataType: 'json',
            data: {count},
            beforeSend: function () {
                $.blockUI();
            },
            success: function (data) {
                $('#table tbody').append(data.content);
                createSTT();
                createDatePicker('.hasDatePicker');
                $('#count').attr('data-value', parseInt(count) + 1);
            },
            complete: function () {
                $.unblockUI();
            },
            error: function (r1, r2) {
                self.setContent(getMessage(r1.responseText));
                self.setTitle('Thông báo');
                self.setType('red');
                return false;
            },
        });

        // $('#table tbody').append(
        //     `
        //         <tr>
        //             <td class="text-center stt"></td>
        //             <td><input type="text" name="Text[${count}]" class="form-control"></td>
        //             <td><input type="text" name="Date[${count}]" class="form-control hasDatePicker"></td>
        //             <td><input type="file" name="FileDinhKem[${count}]" class="form-control"></td>
        //             <td>
        //                 <a href="#" class="btn-add-row-after text-success"><i class="fa fa-plus-circle"></i></a><br/>
        //                 <a href="#" class="btn-delete text-danger"><i class="fa fa-minus-circle"></i></a>
        //             </td>
        //         </tr>
        //     `
        // );
        // createSTT();
        // createDatePicker('.hasDatePicker');
        // $('#count').attr('data-value', parseInt(count) + 1);;
    });

    $(document).on('click', '.btn-add-row-after', function (e) {
        e.preventDefault();
        const pointer = $(this).parent().parent();
        const count = $('#count').attr('data-value');

        $.ajax({
            url: 'index.php?r=table/add-new-row',
            data: {count},
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $.blockUI();
            },
            success: function (data) {
                pointer.after(data.content);
                createSTT();
                createDatePicker('.hasDatePicker');
                $('#count').attr('data-value', parseInt(count) + 1);
            },
            error: function (r1, r2){
                console.log(getMessage(r1.responseText));
                return false;
            },
            complete: function () {
                $.unblockUI();
            }
        });
    });

    $(document).on('click', '.btn-delete-row', function (e) {
        e.preventDefault();
        const id = $(this).attr('data-value');
        if(id !== undefined) {
            $.ajax({
                url: 'index.php?r=table/delete',
                data: {id},
                type: 'post',
                dataType: 'json',
                beforeSend: function () {
                    $.blockUI();
                },
                success: function (data) {},
                error: function (r1, r2){
                    console.log(getMessage(r1.responseText));
                    return false;
                },
                complete: function () {
                    $.unblockUI();
                }
            });
        }

        $(this).parent().parent().remove();
        createSTT();
    });

    $(document).on('click', '#btn-save-table', function (e) {
        e.preventDefault();

        const data = new FormData($('#form-table')[0]);
        SaveObjectUploadFile("table/save", data, function (data) {
            $('#table tbody').html(data.body);
            createDatePicker('.hasDatePicker');
        });
    });

    $(document).on('click', '.btn-delete-file', function (e) {
        e.preventDefault();
        const id = $(this).attr('data-value');
        const pointer = $(this);

        $.ajax({
            url: 'index.php?r=table/delete-file',
            data: {id},
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $.blockUI();
            },
            success: function (data) {
                pointer.parent().remove();
            },
            error: function (r1, r2){
                console.log(getMessage(r1.responseText));
                return false;
            },
            complete: function () {
                $.unblockUI();
            }
        });
    });
});
