var offset = 0;

function dataAjax() {
    $.ajax({
        url: 'index.php?r=',
        type: 'post',
        dataType: 'json',
        data: {offset},
        beforeSend: function () {
            $.blockUI();
        },
        success: function (data) {
            // Gán data table
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
}

$(document).ready(function () {
    dataAjax();

    $(document).on('click', '.btn-increa', function (e) {
        e.preventDefault();

        offset++;
        dataAjax();
    });

    $(document).on('click', '.btn-decrease', function (e) {
        e.preventDefault();
        
        if (offset > 0) {
            offset--;
            dataAjax();
        }
    });
});
