$(document).ready(function () {
    obtenerDatosUsuarios(); // Muestra la tabla al cargar la página

});
function registrarUsuario() {
    if ($("#username").val() == "") {
        swal.fire('Error!', 'El campo nombre: no puede estar vacio', 'error');
        return false;
    }

    if ($("#rol").val() == "") {
        swal.fire('Error!', 'El campo rol: no puede estar vacio', 'error');
        return false;
    }

    if ($("#dni_ruc").val() == "") {
        swal.fire('Error!', 'El campo DNI/RUCa: no puede estar vacio', 'error');
        return false;
    }

    if ($("#rol").val() == "admin") {
        if ($("#password1").val() == "") {
            swal.fire('Error!', 'El campo Contraseña: no puede estar vacio', 'error');
            return false;
        }

        if ($("#password2").val() == "") {
            swal.fire('Error!', 'El campo Confirmar contraseña: no puede estar vacio', 'error');
            return false;
        }

        if ($("#password1").val() !== $("#password2").val()) {
            swal.fire('Error!', 'Las contraseñas deben ser iguales', 'error');
            return false;
        }
    } else {
        if ($("#gold_law").val() == "") {
            swal.fire('Error!', 'El campo Ley general de cola de Au: no puede estar vacio', 'error');
            return false;
        }

        if ($("#tailings_law").val() == "") {
            swal.fire('Error!', 'El campo Ley general de cola de Ag: no puede estar vacio', 'error');
            return false;
        }

        if ($("#fine_gold_to_deliver").val() == "") {
            swal.fire('Error!', 'El campo Oro piña por entregar: no puede estar vacio', 'error');
            return false;
        }

        if ($("#pine_silver_to_deliver").val() == "") {
            swal.fire('Error!', 'El campo Plata piña por entregar: no puede estar vacio', 'error');
            return false;
        }

        if ($("#gold_discount").val() == "") {
            swal.fire('Error!', 'El campo Descuento Au: no puede estar vacio', 'error');
            return false;
        }

        if ($("#silver_discount").val() == "") {
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
            var fila = '<tr>' +
                '<td>' + item.username + '</td>' +
                '<td>' + item.role + '</td>' +
                '<td>' + item.dni_ruc + '</td>' +
                '<td>' + item.gold_law + '</td>' +
                '<td>' + item.tailings_law + '</td>' +
                '<td>' + item.fine_gold_to_deliver + '</td>' +
                '<td>' + item.pine_silver_to_deliver + '</td>' +
                '<td>' + item.gold_discount + '</td>' +
                '<td>' + item.silver_discount + '</td>' +
                '<td>' +
                '<span class="btn btn-icon mb-1 text-primary" onclick="editarProducto(' + item.id + ')">' +
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
