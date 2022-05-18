function getMessage(str) {
    return str.replace('Internal Server Error (#500):','');
}

function search(gridReload, form) {
    setTimeout(function () {
        $.pjax.reload({container: gridReload, data: $(form).serializeArray()});
    }, 300);
}

function viewData($controller_action, $dataInput, $size, callbackSuccess){
    $.confirm({
        content: function () {
            var self = this;
            return $.ajax({
                url: 'index.php?r=' + $controller_action,
                data: $dataInput,
                type: 'post',
                dataType: 'json',
                success: function (data){
                    self.setContent(data.content);
                    self.setTitle(data.title);
                    self.setType('blue');
                    if(typeof callbackSuccess != "undefined") {
                        callbackSuccess(data);
                    }
                },
                error: function (r1, r2) {
                    self.setContent(getMessage(r1.responseText));
                    self.setTitle('Lỗi');
                    self.setType('red');
                    return false;
                }
            });
        },
        columnClass: $size,
        buttons: {
            btnClose: {
                text: '<i class="fas fa-times"></i> Đóng lại'
            }
        }
    });
}

function downloadExcel(controller_action, data){
    $.ajax({
        url: 'index.php?r='+controller_action,
        data: data,
        dataType: 'json',
        type: 'post',
        beforeSend: function () {
            $.blockUI({ message: 'Vui lòng chờ ...' });
        },
        success: function (data) {
            $.dialog({
                title: data.title,
                content: data.link,
            });
        },
        complete: function () {
            $.unblockUI();
        },
        error: function (r1, r2) {
            console.log(r1.responseText)
        }
    });
}

function loadForm($dataInput, $size = 'm', callbackSuccess, callbackSave) {
    $.confirm({
        content: function () {
            var self = this;
            return $.ajax({
                url: 'index.php?r=site/loadform',
                data: $dataInput,
                type: 'post',
                dataType: 'json',
                success: function (data) {
                    self.setContent(data.content);
                    self.setTitle(data.title);
                    self.setType('blue');
                    callbackSuccess(data);
                },
                error: function (r1, r2){
                    self.setContent(getMessage(r1.responseText));
                    self.setTitle('Thông báo');
                    self.setType('red');
                    self.$$btnSave.prop('disabled', true);
                    return false;
                }
            });
        },
        columnClass: $size,
        buttons: {
            btnSave: {
                text: '<i class="fa fa-save"></i> Lưu lại',
                btnClass: 'btn-primary',
                action: function () {
                    if(typeof callbackSave !== "undefined") {
                        return callbackSave();
                    }
                }
            },
            btnClose: {
                text: '<i class="fa fa-close"></i> Đóng lại'
            }
        }
    });
}

function SaveObject($url_controller_action, $dataInput, callbackSuccess, columnClass){
    if(typeof columnClass == "undefined")
        columnClass = 's';

    $.dialog({
        columnClass: columnClass,
        content: function () {
            var self = this;
            return $.ajax({
                url: 'index.php?r=' + $url_controller_action,
                type: 'post',
                dataType: 'json',
                data: $dataInput,
                success: function (data){
                    self.setContent(data.content);
                    self.setTitle(data.title);
                    self.setType('blue');
                    if(typeof callbackSuccess == "function")
                        callbackSuccess(data);
                },
                error: function (r1, r2) {
                    self.setContent(getMessage(r1.responseText));
                    self.setTitle('Thông báo');
                    self.setType('red');
                    return false;
                },
            });
        }
    });
}

function SaveObjectUploadFile($url_controller_action, $dataInput, callbackSuccess, columnClass){
    if(typeof columnClass == "undefined")
        columnClass = 's';
    // data = new FormData($(modalForm)[0]);
    $.dialog({
        columnClass: columnClass,
        content: function () {
            var self = this;
            return $.ajax({
                url: 'index.php?r=' + $url_controller_action,
                type: 'post',
                dataType: 'json',
                data: $dataInput,
                contentType: false,
                processData: false,
                success: function (data) {
                    self.setContent(data.content);
                    self.setTitle(data.title);
                    self.setType('blue');
                    if(typeof callbackSuccess == "function")
                        callbackSuccess(data);
                },
                error: function (r1, r2) {
                    self.setContent(getMessage(r1.responseText));
                    self.setTitle('Thông báo');
                    self.setType('red');
                    return false;
                },
            });
        }
    })
}

$(document).ready(function () {
    $(document).on('click', '.nav-sidebar>.nav-item', function (e) {
        e.preventDefault();
        if($(this).has('.nav.nav-treeview').length > 0){
            if($(this).has('.active').length > 0){
                $(this).children('.nav.nav-treeview.active').removeClass('active');
                $(this).find('.right.fas.fa-angle-left').css("transform", "rotate(0)");
            }else{
                $(this).children('.nav.nav-treeview').addClass('active');
                $(this).find('.right.fas.fa-angle-left').css("transform", "rotate(-90deg)");
            }
        }else{
            window.location.href = $(this).find('a.nav-link').attr('href');
        }
    });

    $(document).on('click', '.btn-delete', function (e) {
        const id = $(this).attr('data-value');
        const url = $(this).attr('data-url');
        e.preventDefault();

        $.confirm({
            title: 'Xóa dữ liệu!',
            content: 'Bạn có chắc muốn xóa bản ghi này?',
            buttons: {
                cancel: {
                    text: '<i class="fas fa-times"></i> Hủy'
                },
                confirm: {
                    text: '<i class="fa fa-check"></i> Đồng ý',
                    btnClass: 'btn-primary',
                    action: function () {
                        $.ajax({
                            url: 'index.php?r=' + url,
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
                                $.pjax.reload({container: "#crud-datatable-pjax"});
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
                    }
                }
            }
        });
    });

    $(document).on('click', '.btn-search', function () {
        search('#crud-datatable-pjax', "#form-search");
    });

    $(document).on('click', '.btn-download', function (e) {
        const url = $(this).attr('data-url');
        e.preventDefault();

        downloadExcel(url, {});
    });

    $(document).on('click', '.btn-upload', function (e) {
        e.preventDefault();
        loadForm({type: 'upload_user'}, 'm', function (data) {}, function () {
            const data = new FormData($('#form-upload')[0]);
            SaveObjectUploadFile("user/upload", data, function (data) {
                $.pjax.reload('#crud-datatable-pjax');
            });
        });
    });

    $(document).on('click', '.btn-loadform', function (e){
        e.preventDefault();
        const index = $(this).attr('data-index');

        loadForm({type: 'type'},'l',function (data) {
            setTimeout(function () {
                $('#id').select2();
            }, 500);
        },function () {
            let loi = 0
            $('.help-block').html('');
            $('.required input, .required select').each(function () {
                if($(this).val() === ''){
                    loi++;
                    $(this).parent().find('.help-block').addClass('text-danger').html(
                        $(this).parent().find('label').html() + ' không được để trống'
                    )
                    $(this).parent().addClass('has-error');
                }
            });

            if(loi === 0){
                SaveObject("controller/save", $("#form").serializeArray(), function (data) {});

                // const data = new FormData($('#form-upload')[0]);
                // SaveObjectUploadFile("user/luu-upload-file", data, function (data) {
                //     $.pjax.reload({container: '#crud-datatable-pjax'});
                // });
            }else{
                return false;
            }
        });
    });

    $(document).on('click', '.btn-view-data', function (e) {
        e.preventDefault();

        const id = $(this).attr('data-value');
        viewData('controller/action',{id},'xl');
    });

    $(document).on('click', '.btn-link', function (e) {
        e.preventDefault();

        const id = $(this).attr('data-value');
        window.location = `index.php?r=controller/action&id=${id}`;
    });
})
