$("body").on("submit", ".form_guardar", function (e) {
    e.preventDefault();

    formData = new FormData(document.getElementById($(this).attr("id")));
    var url = $(`#${$(this).attr("id")}`).attr("action");

    $.ajax({
        type: "POST",
        url: url,
        contentType: false,
        processData: false,
        datatype: "JSON",
        data: formData,
        beforeSend: function () {
            formData.forEach(function (value, key) {
                console.log(key, value);
            });
            console.log(url);
            $("#btn_guardar").val("Enviando..");
            $("#btn_guardar").attr("disabled", "disabled");
        },
    })
        .done(function (response) {
            if (response.route_error != null) {
                $(location).attr("href", response.route_error);
            } else {
                if (response.falla != null && response.falla == true) {
                    $("#btn_guardar").val("Guardar");
                    $("#btn_guardar").attr("disabled", false);
                    // Swal.fire({
                    //     icon: response.icon,
                    //     title: response.title,
                    //     text: response.text,
                    // });
                } else {
                    // Swal.fire({
                    //     icon: response.icon,
                    //     title: response.title,
                    //     text: response.text,
                    // });

                    $("#btn_guardar").val("Guardar");
                    $("#btn_guardar").attr("disabled", false);
                    // $(".borrar_input").val("");
                    // $("#" + response.dtable)
                    //     .DataTable()
                    //     .ajax.reload();

                    // if (response.ruta != null) {
                    //     $("#form_guardar").attr("action", response.ruta);
                    // }
                    // if (response.route != null) {
                    //     $(location).attr("href", response.route);
                    // }
                }
            }
            // $(".mjs_error").remove();

            console.log(response.route);
        })
        .fail(function (response) {
            console.log("fallo");
            console.log(response);

            $(".mjs_error").remove();
            toastr.error("Error al enviar los datos", "Error", {
                closeButton: !0,
                tapToDismiss: !0.3,
                progressBar: !0,
            });

            $.each(response.responseJSON.errors, function (index, value) {
                $("#" + index).after(
                    "<span class='text-danger mjs_error'>" + value + "</span>"
                );

                toastr.error("Mensaje: " + value, "Error", {
                    closeButton: !0,
                    tapToDismiss: !0.3,
                    progressBar: !0,
                });
            });
            $("#btn_guardar").val("Guardar");
            $("#btn_guardar").attr("disabled", false);
        });
});
