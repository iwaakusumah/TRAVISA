"use strict";

$("[data-checkboxes]").each(function () {
    var me = $(this),
        group = me.data("checkboxes"),
        role = me.data("checkbox-role");

    me.change(function () {
        var all = $(
                '[data-checkboxes="' +
                    group +
                    '"]:not([data-checkbox-role="dad"])'
            ),
            checked = $(
                '[data-checkboxes="' +
                    group +
                    '"]:not([data-checkbox-role="dad"]):checked'
            ),
            dad = $(
                '[data-checkboxes="' + group + '"][data-checkbox-role="dad"]'
            ),
            total = all.length,
            checked_length = checked.length;

        if (role == "dad") {
            if (me.is(":checked")) {
                all.prop("checked", true);
            } else {
                all.prop("checked", false);
            }
        } else {
            if (checked_length >= total) {
                dad.prop("checked", true);
            } else {
                dad.prop("checked", false);
            }
        }
    });
});

$("#table-all").dataTable({
    columnDefs: [{ sortable: false, targets: [3] }],
});
$("#table-4").dataTable({
    columnDefs: [{ sortable: false, targets: [3] }],
});
$("#table-5").dataTable({
    columnDefs: [{ sortable: false, targets: [4] }],
});
$("#table-6").dataTable({
    columnDefs: [{ sortable: false, targets: [5] }],
});
$("#table-7").dataTable({
    columnDefs: [{ sortable: false, targets: [6] }],
});
$("#table-8").dataTable();
$(document).ready(function () {
    $(".datatable").DataTable({
        columnDefs: [{ orderable: false, targets: [4] }],
    });
});
$(document).ready(function () {
    $(".datatable").each(function () {
        if (!$.fn.DataTable.isDataTable(this)) {
            $(this).DataTable(); // tanpa columnDefs
        }
    });
});