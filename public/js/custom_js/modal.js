$("body").on("click", ".btn_modal", function () {
    var $this = $(this);
    $.ajax({
        url: $this.attr("data-route"),
        type: "get",
    })
        .done(function (response) {
            $("#modalLabel").html(response.titulo);
            $("#contenido_modal").html(response.html);
            $("#modal").modal("show");
        })
        .fail(function (response) {
            console.log("fallo");
            console.log(response);
            toastr.error("Error al enviar los datos", "Error", {
                closeButton: !0,
                tapToDismiss: !0.3,
                progressBar: !0,
            });
        });
});
//Limpiar los imputs
$("body").on("click", "#btn_cancelar", function () {
    $("#modal").modal("hide");
    $("#form")[0].reset();
});

$("body").on("click", ".btn_modal_admin", function () {
    var $this = $(this);
    $.ajax({
        url: $this.attr("data-route"),
        type: "get",
    })
        .done(function (response) {
            $("#modalLabel").html(response.titulo);
            $("#contenido_modal").html(response.html);
            $("#modaladmin").modal("show");
        })
        .fail(function (response) {
            console.log("fallo");
            console.log(response);
            toastr.error("Error al enviar los datos", "Error", {
                closeButton: !0,
                tapToDismiss: !0.3,
                progressBar: !0,
            });
        });
});
//Limpiar los imputs
$("body").on("click", "#btn_cancelar", function () {
    $("#modal").modal("hide");
});
