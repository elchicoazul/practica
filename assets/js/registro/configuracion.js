function registrarConfiguracion() {
    if ($("#name").val() == "") {
        swal.fire('Error!', 'El campo Nombre: no puede estar vacio', 'error');
        return false;
    }
    if ($("#value").val() == "") {
        swal.fire('Error!', 'El campo Valor: no puede estar vacio', 'error');
        return false;
    }

    var model = {};

    model.name=$("#name").val();
    model.value=$("#value").val();


    swal.fire({
        title: "Guardar registro",
        text: "¿Está seguro de guardar los datos ingresados?",
        icon: 'question', // 'type' ha sido reemplazado por 'icon' en versiones más recientes de SweetAlert2
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Guardar',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: 'http://localhost/practica/Configuraciones/registrar', // Asegúrese de que esta ruta sea correcta
                type: "POST",
                data: model,
                dataType: 'json'
            }).done(function (data) {
                if (data.estado == 200) {
                    swal.fire('Registrado!', data.mssg, 'success');

                    // Restablecer los valores de los campos después del registro exitoso
                    $("#name").val('');
                    $("#value").val('');
                }
                else {
                    swal.fire('Error!', data.mssg, 'error');
                }
            });
        }
    });
}