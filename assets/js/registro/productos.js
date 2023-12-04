function registrarProductos() {
    if ($("#name").val() == "") {
        swal.fire('Error!', 'El campo Nombre de producto: no puede estar vacio', 'error');
        return false;
    }
    if ($("#price").val() == "") {
        swal.fire('Error!', 'El campo Precio: no puede estar vacio', 'error');
        return false;
    }

    var stockValue = $("#stock").val();

    // Verificar si el campo está vacío o si el valor es menor o igual a cero
    if (stockValue === "" || parseFloat(stockValue) <= 0) {
        // Mostrar alerta si está vacío o si es menor o igual a cero
        swal.fire('Error!', 'El campo Stock no puede estar vacío o ser menor o igual a cero', 'error');
        return false;
    }

    var model = {};

    model.name=$("#name").val();
    model.price=$("#price").val();
    model.stock=$("#stock").val();


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
                url: 'http://localhost:8182/practica/Productos/registrar', // Asegúrese de que esta ruta sea correcta
                type: "POST",
                data: model,
                dataType: 'json'
            }).done(function (data) {
                if (data.estado == 200) {
                    obtenerDatosProductos();
                    swal.fire('Registrado!', data.mssg, 'success');
                    // Restablecer los valores de los campos después del registro exitoso
                    $("#name").val('');
                    $("#price").val('');
                    $("#stock").val('');
                }
                else {
                    swal.fire('Error!', data.mssg, 'error');
                }
            });
        }
    });
}
function obtenerDatosProductos() {
    
    $.ajax({
        url: 'http://localhost/practica/Productos/obtenerTodos',
        type: "GET",
        dataType: 'json'
    }).done(function (datos) {
        // Limpiar la tabla actual
        $(".table tbody").empty();
        // Iterar sobre los datos y añadirlos a la tabla
        datos.forEach(function (item) {
            var fila = '<tr>' +
                '<td>' + item.name + '</td>' +
                '<td>' + item.price + '</td>' +
                '<td>' + item.stock + '</td>' +
                // Agrega más columnas según sea necesario
                '</tr>';
            $(".table tbody").append(fila);
        });
    });
}

/*
$(document).ready(function () {
    // Llamada inicial para cargar la lista de productos al cargar la página
    obtenerDatosProductos();

    // Agrega un evento de clic al botón "Registrar" para que también llame a obtenerDatosActualizados.
    $("#registrarButton").on("click", function () {
        registrarProductos();
    });
});
*/