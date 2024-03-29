function Temporal() {
  // Validación de campos
  if ($('#codigo_client').val() == '') {
    swal.fire('Error!', 'Debe  seleccionar un  Cliente', 'error');
    return false;
  }
  if ($('#pesoBruto').val() == '') {
    swal.fire('Error!', 'El campo Peso Bruto KG no puede estar vacío', 'error');
    return false;
  }
  if ($('#tara').val() == '') {
    swal.fire('Error!', 'El campo Tara KG no puede estar vacío', 'error');
    return false;
  }
  if ($('#pesoMuestra').val() == '') {
    swal.fire('Error!', 'El campo Peso Muestra KG no puede estar vacío', 'error');
    return false;
  }
  if ($('#pesoHumedo').val() == '') {
    swal.fire('Error!', 'El campo Peso Húmedo KG no puede estar vacío', 'error');
    return false;
  }
  if ($('#humedad').val() == '') {
    swal.fire('Error!', 'El campo Humedad % no puede estar vacío', 'error');
    return false;
  }
  if ($('#pesoSeco').val() == '') {
    swal.fire('Error!', 'El campo Peso Seco KG no puede estar vacío', 'error');
    return false;
  }

  // Creación del objeto model con los datos del formulario
  var model = {
    pesoBruto: $('#pesoBruto').val(),
    tara: $('#tara').val(),
    pesoMuestra: $('#pesoMuestra').val(),
    pesoHumedo: $('#pesoHumedo').val(),
    humedad: $('#humedad').val(),
    pesoSeco: $('#pesoSeco').val(),
    codigo: $('#codigo_client').val(),
  };

  console.log(model);

  id_cod = $('#codigo_client').val();
  // Confirmación antes de enviar los datos
  swal
    .fire({
      title: 'Guardar registro',
      text: '¿Está seguro de guardar los datos ingresados?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Guardar',
      cancelButtonText: 'No',
    })
    .then((result) => {
      if (result.value) {
        $.ajax({
          url: 'http://localhost/practica/Recepcion/registrarTemp', // Modifique la URL según su ruta
          type: 'POST',
          data: model,
          dataType: 'json',
        }).done(function (data) {
          if (data.estado == 200) {
            obtenerDatosActualizados(id_cod);
            swal.fire('Registrado!', data.mssg, 'success');
          } else {
            swal.fire('Error!', data.mssg, 'error');
          }
        });
      }
    });
}
function obtenerDatosActualizados(id) {
  $.ajax({
    url: 'http://localhost/practica/Recepcion/obtenerDatos/' + id, // La URL de su nuevo método
    type: 'GET',
    dataType: 'json',
  }).done(function (datos) {
    // Limpiar la tabla actual
    $('.table tbody').empty();

    // Iterar sobre los datos y añadirlos a la tabla
    datos.forEach(function (item) {
      var fila =
        '<tr>' +
        '<td>' +
        item.gross_weight +
        '</td>' + // Asegúrese de que estos nombres coincidan
        '<td>' +
        item.tare_weight +
        '</td>' + // con los nombres de las propiedades en
        '<td>' +
        item.sample_weight +
        '</td>' + // el objeto JSON que recibe del servidor
        '<td>' +
        item.wet_weight +
        '</td>' +
        '<td>' +
        item.moisture_percentage +
        '</td>' +
        '<td>' +
        item.dry_weight +
        '</td>' +
        '<td>' +
        '<button type="button" class="btn btn-danger btn-icon mb-1" onclick="eliminarTemporal(' +
        item.id +
        ')">' +
        '<i class="mdi mdi-delete"></i>' +
        '</button>' +
        '</td>' +
        '</tr>';
      $('.table tbody').append(fila);
    });
  });
}
function eliminarTemporal(id) {
  id_cod = $('#codigo').val();
  // Confirmación antes de la eliminación
  swal
    .fire({
      title: '¿Está seguro?',
      text: 'No podrá revertir esta acción',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'No, cancelar',
    })
    .then((result) => {
      if (result.value) {
        $.ajax({
          url: 'http://localhost/practica/Recepcion/eliminar/' + id, // Ajuste la URL a su ruta de API
          type: 'POST', // O 'DELETE', dependiendo de su implementación en el servidor
          success: function (response) {
            // Comprobar respuesta del servidor
            if (response.estado == 200) {
              // Eliminar la fila del DOM
              $('#fila-' + id).remove();
              swal.fire('Eliminado!', 'El registro ha sido eliminado.', 'success');
              obtenerDatosActualizados(id_cod);
            } else {
              swal.fire('Error!', 'No se pudo eliminar el registro.', 'error');
              obtenerDatosActualizados(id_cod);
            }
          },
          error: function () {
            swal.fire('Error!', 'Hubo un problema al comunicarse con el servidor.', 'error');
            obtenerDatosActualizados(id_cod);
          },
        });
      }
    });
}

function btnTransferirDatos() {
  // Validación de los campos
  if ($('#codigo_client').val() == '') {
    swal.fire('Error!', 'Debe seleccionar un Cliente', 'error');
    return false;
  }
  if ($('#codigo_guia').val() == '') {
    swal.fire('Error!', 'Debe tener código de guía', 'error');
    return false;
  }
  if ($('#fecha').val() == '') {
    swal.fire('Error!', 'Debe tener Fecha', 'error');
    return false;
  }

  // Creación del objeto userData
  var userData = {
    codigo: $('#codigo_client').val(),
    codigo_guia: $('#codigo_guia').val(),
    fecha: $('#fecha').val(),
    guia: $('#guia').val(),
    // Añade otros campos según sea necesario
  };

  // Confirmación para transferir los datos
  swal
    .fire({
      title: 'Transferir Datos',
      text: '¿Está seguro de que desea transferir los datos desde la tabla temporal a la tabla real?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, Transferir',
      cancelButtonText: 'No, Cancelar',
    })
    .then((result) => {
      if (result.value) {
        // Realizar la solicitud AJAX para transferir los datos
        $.ajax({
          url: 'http://localhost/practica/Recepcion/transferir', // Ajuste esta URL a su ruta de API
          type: 'POST',
          dataType: 'json',
          data: userData, // Enviar userData como parte de la solicitud
          success: function (response) {
            if (response.estado == 200) {
              swal.fire('Transferido!', 'Los datos han sido transferidos con éxito.', 'success');
              obtenerDatosActualizados(); // Llamar a una función para actualizar la vista
            } else {
              swal.fire('Error!', 'Error al transferir los datos.', 'error');
            }
          },
          error: function () {
            swal.fire('Error!', 'Error al realizar la solicitud.', 'error');
          },
        });
      }
    });
}
