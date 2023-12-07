$(document).ready(function () {
    obtenerDatosProductos(); // Muestra la tabla al cargar la página

});

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
                url: 'http://localhost/practica/Productos/registrar', // Asegúrese de que esta ruta sea correcta
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
        $(".tabla-productos tbody").empty();

        // Iterar sobre los datos y añadirlos a la tabla
        datos.forEach(function (item) {
            var fila = '<tr id="producto-' + item.id + '">' +
                '<td data-editable="true">' + item.name + '</td>' + // Atributo data-editable para identificar la celda del nombre
                '<td data-editable="true">' + item.price + '</td>' + // Atributo data-editable para identificar la celda del precio
                '<td data-editable="true">' + item.stock + '</td>' + // Atributo data-editable para identificar la celda del stock
                '<td>' +
                '<span class="btn btn-icon mb-1 text-primary" onclick="editarProducto(' + item.id + ')">' +
                '<i class="mdi mdi-pencil"></i>' +
                '</span>' +
                '<span class="btn btn-icon mb-1 text-danger" onclick="eliminarProducto(' + item.id + ')">' +
                '<i class="mdi mdi-delete"></i>' +
                '</span>' +
                '</td>' +
                '</tr>';
            $(".tabla-productos tbody").append(fila);
        });
    }).fail(function (error) {
        console.log("Error al obtener los datos: ", error);
    });
}

function eliminarProducto(id) {
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
                url: 'http://localhost/practica/Productos/eliminar/'+ id, // Ajuste la URL a su ruta de API
                
                type: 'POST', // O 'DELETE', dependiendo de su implementación en el servidor
                success: function(response) {
                    // Comprobar respuesta del servidor
                    if (response.estado == 200) {
                        // Eliminar la fila del DOM
                        $('#fila-' + id).remove();
                        swal.fire('Eliminado!', 'El registro ha sido eliminado.', 'success');
                        obtenerDatosProductos();
                    } else {
                        swal.fire('Error!', 'No se pudo eliminar el registro.', 'error');
                        obtenerDatosProductos();
                    }
                },
                error: function() {
                    swal.fire('Error!', 'Hubo un problema al comunicarse con el servidor.', 'error');
                    obtenerDatosProductos();
                }
            });
        }
    });
}

function guardarProducto(id) {
    var fila = $('#producto-' + id);

    // Recoger los datos editados
    var datosEditados = {
        name: fila.find('td[data-editable="true"]').eq(0).text(), // Primera celda editable
        price: fila.find('td[data-editable="true"]').eq(1).text(), // Segunda celda editable
        stock: fila.find('td[data-editable="true"]').eq(2).text() // Tercera celda editable
    };

    // Llamar a GuardarDatosProductos para guardar los datos
    GuardarDatosProductos(id, datosEditados);

    // Resto del código para cambiar el ícono y el manejador de eventos
    fila.find('td[data-editable="true"]').removeClass('editable-field').attr('contenteditable', 'false');
    var icono = fila.find('.mdi-check');
    icono.removeClass('mdi-check').addClass('mdi-pencil');
    icono.closest('.btn').off('click').click(function() {
        editarProducto(id);
    });
}
function GuardarDatosProductos(id, datos) {
    swal.fire({
        title: "Guardar registro",
        text: "¿Está seguro de guardar los datos ingresados?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, Guardar',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: 'http://localhost/practica/Productos/guardar/' + id, // Asegúrese de que esta ruta sea correcta
                type: "POST",
                contentType: "application/json",
                data: JSON.stringify(datos),
                dataType: 'json'
            }).done(function (data) {
                if (data.estado == 200) {
                    obtenerDatosProductos();
                    swal.fire('Registrado!', data.mssg, 'success');
                    // Aquí puede incluir cualquier lógica adicional después de un registro exitoso
                } else {
                    swal.fire('Error!', data.mssg, 'error');
                }
            });
        }
    });
}
function editarProducto(id) {
    var fila = $('#producto-' + id);
    fila.find('td[data-editable="true"]').addClass('editable-field').attr('contenteditable', 'true');

    // Obtenemos el elemento del ícono directamente y cambiamos la clase
    var icono = fila.find('.mdi-pencil');
    icono.removeClass('mdi-pencil').addClass('mdi-check');

    // Asignamos el nuevo manejador de eventos
    icono.closest('.btn').off('click').click(function() {
        guardarProducto(id);
    });
}