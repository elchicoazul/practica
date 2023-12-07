$(document).ready(function () {
    obtenerDatosConfiguracion(); // Muestra la tabla al cargar la página
});

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
                    obtenerDatosConfiguracion();
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

function obtenerDatosConfiguracion() {
    $.ajax({
        url: 'http://localhost/practica/Configuraciones/obtenerTodasConfiguraciones',
        type: "GET",
        dataType: 'json'
    }).done(function (datos) {
        // Limpiar la tabla actualw
        $(".tabla-configuracion tbody").empty();
        // Iterar sobre los datos y añadirlos a la tabla
        datos.forEach(function (item) {
            var fila = '<tr  id="configuracion-' + item.id + '">' +
                '<td>' + item.id + '</td>' +
                '<td data-editable="true">' + item.name + '</td>' +
                '<td data-editable="true">' + item.value + '</td>' +
                '<td>' +
                '<span class="btn btn-icon mb-1 text-primary" onclick="editarConfiguracion(' + item.id + ')">' +
                '<i class="mdi mdi-pencil"></i>' +
            '</span>' +
            '<span class="btn btn-icon mb-1 text-danger" onclick="eliminarConfiguracion(' + item.id + ')">' +
                '<i class="mdi mdi-delete"></i>' +
            '</span>'
             +
                '</td>' +
                '</tr>';
            $(".tabla-configuracion tbody").append(fila);
        });
    });
}


function eliminarConfiguracion(id) {
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
                url: 'http://localhost/practica/Configuraciones/eliminar/'+ id, // Ajuste la URL a su ruta de API
                
                type: 'POST', // O 'DELETE', dependiendo de su implementación en el servidor
                success: function(response) {
                    // Comprobar respuesta del servidor
                    if (response.estado == 200) {
                        // Eliminar la fila del DOM
                        $('#fila-' + id).remove();
                        swal.fire('Eliminado!', 'El registro ha sido eliminado.', 'success');
                        obtenerDatosConfiguracion();
                    } else {
                        swal.fire('Error!', 'No se pudo eliminar el registro.', 'error');
                        obtenerDatosConfiguracion();
                    }
                },
                error: function() {
                    swal.fire('Error!', 'Hubo un problema al comunicarse con el servidor.', 'error');
                    obtenerDatosConfiguracion();
                }
            });
        }
    });
}

function guardarConfiguracion(id) {
    var fila = $('#configuracion-' + id);

    // Recoger los datos editados
    var datosEditados = {
        name: fila.find('td[data-editable="true"]').eq(0).text(), // Primera celda editable
        value: fila.find('td[data-editable="true"]').eq(1).text() // Segunda celda editable
    };

    // Llamar a guardarDatosConfiguracion para guardar los datos
    guardarDatosConfiguracion(id, datosEditados);

    // Resto del código para cambiar el ícono y el manejador de eventos
    fila.find('td[data-editable="true"]').removeClass('editable-field').attr('contenteditable', 'false');
    var icono = fila.find('.mdi-check');
    icono.removeClass('mdi-check').addClass('mdi-pencil');
    icono.closest('.btn').off('click').click(function() {
        editarConfiguracion(id);
    });
}


function guardarDatosConfiguracion(id, datos) {
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
                url: 'http://localhost/practica/Configuraciones/guardar/' + id,
                type: "POST",
                contentType: "application/json",
                data: JSON.stringify(datos),
                dataType: 'json',
                success: function (data) {
                    if (data.estado == 200) {
                        obtenerDatosConfiguracion();
                        swal.fire('Registrado!', data.mssg, 'success');
                        // Aquí puede incluir cualquier lógica adicional después de un registro exitoso
                    } else {
                        swal.fire('Error!', data.mssg, 'error');
                    }
                },
                error: function (error) {
                    swal.fire('Error!', 'Hubo un problema al comunicarse con el servidor.', 'error');
                    console.log(error); // Agregar log para ver detalles del error en la consola
                }
            });
        }
    });
}


function editarConfiguracion(id) {
    console.log('Editando configuración con ID: ' + id);

    var fila = $('#configuracion-' + id);
    fila.find('td[data-editable="true"]').addClass('editable-field').attr('contenteditable', 'true');

    // Obtenemos el elemento del ícono directamente y cambiamos la clase
    var icono = fila.find('.mdi-pencil');
    icono.removeClass('mdi-pencil').addClass('mdi-check');

    // Asignamos el nuevo manejador de eventos
    icono.closest('.btn').off('click').click(function() {
        guardarConfiguracion(id);
    });
}

