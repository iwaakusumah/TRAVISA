$(document).ready(function () {
    $("#btn-save-data").click(function (e) {
        e.preventDefault();

        // Ambil data yang sudah ditaruh di Blade
        const appData = window.AppData || {};
        const periodId = appData.periodId;
        const allResults = appData.allResults;
        const saveUrl = appData.saveUrl;
        const csrfToken = appData.csrfToken;

        if (!periodId || !allResults) {
            alert("Data tidak lengkap untuk disimpan!");
            return;
        }

        $.ajax({
            url: saveUrl,
            method: "POST",
            contentType: "application/json",
            headers: {
                "X-CSRF-TOKEN": csrfToken
            },
            data: JSON.stringify({
                period_id: periodId,
                results: allResults,
            }),
            success: function (response) {
                alert(response.message || "Data berhasil disimpan!");
            },
            error: function (xhr) {
                alert("Terjadi kesalahan saat menyimpan data.");
                console.error(xhr.responseText);
            }
        });
    });
});


$(document).ready(function () {
    $(".accordion-body").not(".show").hide();

    $('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
        $(e.target).addClass("active").siblings().removeClass("active");
    });

    $(".datatable").DataTable({
        responsive: true,
    });
});
