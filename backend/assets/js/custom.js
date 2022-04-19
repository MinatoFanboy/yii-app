$(document).ready(function () {
    $('#ajaxCrudModal').on('shown.bs.modal', function () {
        initiateSelect2();
    })

    $("#crud-datatable-pjax").on('pjax:success', function() {
        initiateSelect2();
    });
})
