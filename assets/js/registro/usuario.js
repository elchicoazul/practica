const URL = 'http://localhost/practica';

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
    username: $('#username').val(),
    rol: $('#rol').val(),
    dni_ruc: $('#dni_ruc').val(),
    // Add other fields as needed
  };

  // If the role is admin, add password fields to userData
  userData.password = $('#password1').val();
  userData.confirmPassword = $('#password2').val();

  // Add other fields for non-admin roles
  userData.gold_law = $('#gold_law').val();
  userData.tailings_law = $('#tailings_law').val();
  userData.fine_gold_to_deliver = $('#fine_gold_to_deliver').val();
  userData.pine_silver_to_deliver = $('#pine_silver_to_deliver').val();
  userData.gold_discount = $('#gold_discount').val();
  userData.silver_discount = $('#silver_discount').val();

  // Ajax request to register the user
  $.ajax({
    url: URL + '/Usuarios/registrar', // Replace with your server endpoint
    type: 'POST',
    data: userData,
    dataType: 'json',
    success: function (data) {
      if (data.estado == 200) {
        swal.fire('Registrado!', data.mssg, 'success');

        // Reset form fields after successful registration
        $('#username').val('');
        $('#rol').val('');
        $('#dni_ruc').val('');
        $('#password1').val('');
        $('#password2').val('');
        // Reset other fields as needed

        // Additional logic after successful registration
      } else {
        swal.fire('Error!', data.mssg, 'error');
      }
    },
    error: function () {
      swal.fire('Error!', 'Hubo un error al procesar la solicitud', 'error');
    },
  });
}
