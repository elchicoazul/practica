
$(document).ready(function () {
    obtenerDatosUsuarios(); // Muestra la tabla al cargar la página

});
function registrarUsuario() {
  if ($('#username').val() == '') {
    swal.fire('Error!', 'El campo nombre: no puede estar vacio', 'error');
    return false;
  }

  if ($('#rol').val() == '') {
    swal.fire('Error!', 'El campo rol: no puede estar vacio', 'error');
    return false;
  }

  if ($('#dni_ruc').val() == '') {
    swal.fire('Error!', 'El campo DNI/RUCa: no puede estar vacio', 'error');
    return false;
  }

  if ($('#rol').val() == 'admin') {
    if ($('#password1').val() == '') {
      swal.fire('Error!', 'El campo Contraseña: no puede estar vacio', 'error');
      return false;
    }

    if ($('#password2').val() == '') {
      swal.fire('Error!', 'El campo Confirmar contraseña: no puede estar vacio', 'error');
      return false;
    }

    if ($('#password1').val() !== $('#password2').val()) {
      swal.fire('Error!', 'Las contraseñas deben ser iguales', 'error');
      return false;
    }
  } else {
    if ($('#gold_law').val() == '') {
      swal.fire('Error!', 'El campo Ley general de cola de Au: no puede estar vacio', 'error');
      return false;
    }

    if ($('#tailings_law').val() == '') {
      swal.fire('Error!', 'El campo Ley general de cola de Ag: no puede estar vacio', 'error');
      return false;
    }


    if ($('#fine_gold_to_deliver').val() == '') {
      swal.fire('Error!', 'El campo Oro piña por entregar: no puede estar vacio', 'error');
      return false;
    }

    if ($('#pine_silver_to_deliver').val() == '') {
      swal.fire('Error!', 'El campo Plata piña por entregar: no puede estar vacio', 'error');
      return false;
    }

    if ($('#gold_discount').val() == '') {
      swal.fire('Error!', 'El campo Descuento Au: no puede estar vacio', 'error');
      return false;
    }

    if ($('#silver_discount').val() == '') {
      swal.fire('Error!', 'El campo Descuento Ag: no puede estar vacio', 'error');
      return false;
    }
  }

    // Construct user data object
    var userData = {
        username: $("#username").val(),
        rol: $("#rol").val(),
        dni_ruc: $("#dni_ruc").val(),
        // Add other fields as needed
    };

        // If the role is admin, add password fields to userData
        userData.password = $("#password1").val();
        userData.confirmPassword = $("#password2").val();

        // Add other fields for non-admin roles
        userData.gold_law = $("#gold_law").val();
        userData.tailings_law = $("#tailings_law").val();
        userData.fine_gold_to_deliver = $("#fine_gold_to_deliver").val();
        userData.pine_silver_to_deliver = $("#pine_silver_to_deliver").val();
        userData.gold_discount = $("#gold_discount").val();
        userData.silver_discount = $("#silver_discount").val();

        

    // Ajax request to register the user
    $.ajax({
        url: 'http://localhost/practica/Usuarios/registrar', // Replace with your server endpoint
        type: "POST",
        data: userData,
        dataType: 'json',
        success: function (data) {
            if (data.estado == 200) {
                obtenerDatosUsuarios();
                swal.fire('Registrado!', data.mssg, 'success');

                // Reset form fields after successful registration
                $("#username").val('');
                $("#rol").val('');
                $("#dni_ruc").val('');
                $("#password1").val('');
                $("#password2").val('');
                // Reset other fields as needed

                // Additional logic after successful registration
            } else {
                swal.fire('Error!', data.mssg, 'error');
            }
        },
        error: function () {
            swal.fire('Error!', 'Hubo un error al procesar la solicitud', 'error');
        }
    });

}

function obtenerDatosUsuarios() {
    
    $.ajax({
        url: 'http://localhost/practica/Usuarios/obtenerTodosUsuarios',
        type: "GET",
        dataType: 'json'
    }).done(function (datos) {
        // Limpiar la tabla actual
        $(".tabla-usuarios tbody").empty();
        // Iterar sobre los datos y añadirlos a la tabla
        datos.forEach(function (item) {
            var fila = '<tr id="usuario-' + item.id + '">' +
                '<td data-editable="true">' + item.username + '</td>' +
                '<td data-editable="true">' + item.role + '</td>' +
                '<td data-editable="true">' + item.dni_ruc + '</td>' +
                '<td data-editable="true">' + item.gold_law + '</td>' +
                '<td data-editable="true">' + item.tailings_law + '</td>' +
                '<td data-editable="true">' + item.fine_gold_to_deliver + '</td>' +
                '<td data-editable="true">' + item.pine_silver_to_deliver + '</td>' +
                '<td data-editable="true">' + item.gold_discount + '</td>' +
                '<td data-editable="true">' + item.silver_discount + '</td>' +
                '<td>' +
                '<span class="btn btn-icon mb-1 text-primary" onclick="editarUsuario(' + item.id + ')">' +
                '<i class="mdi mdi-pencil"></i>' +
            '</span>' +
            '<span class="btn btn-icon mb-1 text-danger" onclick="eliminarUsuario(' + item.id + ')">' +
                '<i class="mdi mdi-delete"></i>' +
            '</span>'
             +
                '</td>' +
                '</tr>';
            $(".tabla-usuarios tbody").append(fila);
        });
    });
}


function eliminarUsuario(id) {
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
                url: 'http://localhost/practica/Usuarios/eliminar/'+ id, // Ajuste la URL a su ruta de API
                
                type: 'POST', // O 'DELETE', dependiendo de su implementación en el servidor
                success: function(response) {
                    // Comprobar respuesta del servidor
                    if (response.estado == 200) {
                        // Eliminar la fila del DOM
                        $('#fila-' + id).remove();
                        swal.fire('Eliminado!', 'El registro ha sido eliminado.', 'success');
                        obtenerDatosUsuarios();
                    } else {
                        swal.fire('Error!', 'No se pudo eliminar el registro.', 'error');
                        obtenerDatosUsuarios();
                    }
                },
                error: function() {
                    swal.fire('Error!', 'Hubo un problema al comunicarse con el servidor.', 'error');
                    obtenerDatosUsuarios();
                }
            });
        }
    });
}

function guardarUsuario(id) {
    var fila = $('#usuario-' + id);

    // Recoger los datos editados
    var datosEditados = {
        username: fila.find('td[data-editable="true"]').eq(0).text(), // Primera celda editable
        role: fila.find('td[data-editable="true"]').eq(1).text(), // Segunda celda editable
        dni_ruc: fila.find('td[data-editable="true"]').eq(3).text(),
        gold_law: fila.find('td[data-editable="true"]').eq(4).text(),
        tailings_law: fila.find('td[data-editable="true"]').eq(5).text(),
        fine_gold_to_deliver: fila.find('td[data-editable="true"]').eq(6).text(),
        pine_silver_to_deliver: fila.find('td[data-editable="true"]').eq(7).text(),
        gold_discount: fila.find('td[data-editable="true"]').eq(8).text(),
        silver_discount: fila.find('td[data-editable="true"]').eq(9).text(),
    };

    // Llamar a guardarDatosUsuario para guardar los datos
    guardarDatosUsuario(id, datosEditados);

    // Resto del código para cambiar el ícono y el manejador de eventos
    fila.find('td[data-editable="true"]').removeClass('editable-field').attr('contenteditable', 'false');
    var icono = fila.find('.mdi-check');
    icono.removeClass('mdi-check').addClass('mdi-pencil');
    icono.closest('.btn').off('click').click(function() {
        editarUsuario(id);
    });
}


function guardarDatosUsuario(id, datos) {
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
                url: 'http://localhost/practica/Usuarios/guardar/' + id,
                type: "POST",
                contentType: "application/json",
                data: JSON.stringify(datos),
                dataType: 'json',
                success: function (data) {
                    if (data.estado == 200) {
                        obtenerDatosUsuarios();
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


function editarUsuario(id) {
    console.log('Editando usuario con ID: ' + id);

    var fila = $('#usuario-' + id);
    fila.find('td[data-editable="true"]').addClass('editable-field').attr('contenteditable', 'true');

    // Obtenemos el elemento del ícono directamente y cambiamos la clase
    var icono = fila.find('.mdi-pencil');
    icono.removeClass('mdi-pencil').addClass('mdi-check');

    // Asignamos el nuevo manejador de eventos
    icono.closest('.btn').off('click').click(function() {
        guardarUsuario(id);
    });
}
