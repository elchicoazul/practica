function registrarProgramacion() {

    var cantidad = $("#cantidad").val();

    // Obtener el valor de stock
    var stock = $("#product-stock").val();
  
    // Validar que la cantidad no sea mayor al stock
    if (parseFloat(cantidad) > parseFloat(stock)) {
      swal.fire('Error!', 'La cantidad no puede ser mayor al stock disponible', 'error');
      return false;
    }

    var model = {};

    model.search_cliente=$("#search-cliente").val();
    model.search_product=$("#search-product").val();
    model.cantidad=$("#cantidad").val();
    model.price=$("#product-price").val();
    model.total=$("#total").val();



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
                url: 'http://localhost/practica/Programaciones/registrar', // Asegúrese de que esta ruta sea correcta
                type: "POST",
                data: model,
                dataType: 'json'
            }).done(function (data) {
                if (data.estado == 200) {

                    obtenerDatosProgramacion($("#search-cliente").val());

                    swal.fire('Registrado!', data.mssg, 'success');
                    // Restablecer los valores de los campos después del registro exitoso

                    $("#product-stock").val($("#product-stock").val() - $("#cantidad").val());
                    $("#cantidad").val('');
                    $("#total").val('');
                }
                else {
                    swal.fire('Error!', data.mssg, 'error');
                }
            });
        }
    });
}


function obtenerDatosProgramacion(id) {
    $.ajax({
        url: 'http://localhost/practica/Programaciones/obtenerTodasProgramaciones/' + id,
        type: "GET",
        dataType: 'json'
    }).done(function (datos) {
        // Limpiar la tabla actual
        $(".tabla-programaciones tbody").empty();
        // Iterar sobre los datos y añadirlos a la tabla
        datos.forEach(function (item) {
            var fila = '<tr>' +
                '<td>' + item.id + '</td>' +
                '<td>' + item.client_id + '</td>' +
                '<td>' + item.product_id + '</td>' +
                '<td>' + item.amount + '</td>' +
                '<td>' + item.total + '</td>' +
                '<td>' +
                '<span class="btn btn-icon mb-1 text-danger" onclick="eliminarProgramacion(' + item.id + ')">' +
                '<i class="mdi mdi-delete"></i>' +
                '</span>' +
                '</td>' +
                '</tr>';
            $(".tabla-programaciones tbody").append(fila);
        });
    });    
}
function eliminarProgramacion(id) {
    // Confirmación antes de la eliminación
    swal.fire({
        title: "¿Está seguro?",
        text: "No podrá revertir esta acción",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'No, cancelar'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: 'http://localhost/practica/Programaciones/eliminar/'+ id, // Ajuste la URL a su ruta de API
                
                type: 'POST', // O 'DELETE', dependiendo de su implementación en el servidor
                success: function(response) {
                    // Comprobar respuesta del servidor
                    if (response.estado == 200) {
                        // Eliminar la fila del DOM
                        $('#fila-' + id).remove();
                        swal.fire('Eliminado!', 'El registro ha sido eliminado.', 'success');
                        obtenerDatosProgramacion($("#search-cliente").val());

                    } else {
                        swal.fire('Error!', 'No se pudo eliminar el registro.', 'error');
                        obtenerDatosProgramacion($("#search-cliente").val());
                    }
                },
                error: function() {
                    swal.fire('Error!', 'Hubo un problema al comunicarse con el servidor.', 'error');
                    obtenerDatosProgramacion($("#search-cliente").val());
                }
            });
        }
    });
}

