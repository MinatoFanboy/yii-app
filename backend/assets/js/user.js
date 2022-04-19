$(document).ready(function () {
  // $(document).on('shown.bs.modal', '#modal-search', function () {
  //     $('#usersearch-status1').select2(); // Chú ý bị lặp id
  // })

  $(document).on("keypress", "#user-phone", function (event) {
    const keycode = event.which;
    if (!(keycode >= 48 && keycode <= 57)) {
      event.preventDefault();
    }
  });

  $(document).on("pjax:success", "#crud-datatable-pjax", function () {
    const currentTime = new Date();
    const start_year = currentTime.getFullYear() - 3;
    const end_year = currentTime.getFullYear() + 1;

    $("#usersearch-created_at").datepicker(
      $.extend({}, $.datepicker.regional["vi"], {
        dateFormat: "dd/mm/yy",
        changeMonth: true,
        yearRange: `${start_year}:${end_year}`,
        changeYear: true,
      })
    );
  });

  $(document).on("click", ".btn-detail", function (e) {
    e.preventDefault();
    const id = $(this).attr("data-value");
    viewData("user/detail", { id }, "m");
  });

  $(document).ready(function () {
    $(document).on("change", ".td-user input", function (e) {
      var $selected = false;
      if ($(this).is(":checked")) $selected = true;
      if ($selected) {
        if ($("#user-selected li#user-" + $(this).val()).length === 0) {
          $("#user-selected").append(
            `<li id="user-` +
              $(this).val() +
              `" class="margin-bottom-10">
                        <label class="label label-primary">
                            <a href="#" class="text-danger btn-remove-user" data-value="` +
              $(this).val() +
              `"><i class="fas fa-times"></i></a> Người dùng ` +
              $(this).val() +
              `
                        </label>
                        <input type="hidden" value="` +
              $(this).val() +
              `" name="User[` +
              $(this).val() +
              `]">
                    </li>`
          );
        }
      } else {
        $("#user-selected li#user-" + $(this).val()).remove();
      }
      if ($('input[name="selection[]"]:checked').length > 0) {
        $("#label-user-selected").removeClass("hidden");
      } else {
        $("#label-user-selected").addClass("hidden");
      }
    });

    $(document).on("click", ".btn-remove-user", function (e) {
      e.preventDefault();
      const user = $(this).attr("data-value");
      $(this).parent().parent().remove();
      $("input[value=" + user + "]").prop("checked", false);
    });

    $(document).on("click", ".td-user", function (e) {
      if (e.target == this) {
        const checkbox = $(this).parent().find("input:checkbox");
        if (checkbox.is(":checked")) {
          checkbox.prop("checked", false);
          $("#user-selected li#user-" + checkbox.val()).remove();
        } else {
          checkbox.prop("checked", true);
          if ($("#user-selected li#user-" + checkbox.val()).length === 0) {
            $("#user-selected").append(
              `<li id="user-` +
                checkbox.val() +
                `" class="margin-bottom-10">
                        <label class="label label-primary">
                            <a href="#" class="text-danger btn-remove-user" data-value="` +
                checkbox.val() +
                `"><i class="fas fa-times"></i></a> Người dùng ` +
                checkbox.val() +
                `
                        </label>
                        <input type="hidden" value="` +
                checkbox.val() +
                `" name="User[` +
                checkbox.val() +
                `]">
                    </li>`
            );
          }
        }
        if ($('input[name="selection[]"]:checked').length > 0) {
          $("#label-user-selected").removeClass("hidden");
        } else {
          $("#label-user-selected").addClass("hidden");
        }
      }
    });

    $(document).on("click", "#btn-checkbox", function (e) {
      e.preventDefault();
      if ($("#user-selected li").length === 0)
        $.alert("Vui lòng chọn ít nhất một người dùng");
      else {
        var data = $("#form-select-user").serializeArray();
        data.push({ name: "type", value: "checkbox" });

        loadForm(
          data,
          "l",
          function (data) {},
          function () {
            let loi = 0;
            $(".help-block").html("");
            $(".required input, .required select").each(function () {
              if ($(this).val() === "") {
                loi++;
                $(this)
                  .parent()
                  .find(".help-block")
                  .addClass("text-danger")
                  .html(
                    $(this).parent().find("label").html() +
                      " không được để trống"
                  );
                $(this).parent().addClass("has-error");
              }
            });

            if (loi === 0) {
              SaveObject(
                "controller/save",
                $("#form").serializeArray(),
                function (data) {}
              );
            } else {
              return false;
            }
          }
        );
      }
    });

    $(document).on("click", ".btn-delete-row", function (e) {
      e.preventDefault();
      $(this).parent().parent().remove();
    });
  });
});
