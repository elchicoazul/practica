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
        url: 'http://localhost/practica/Programaciones/obtenerTodasProgramacionesTemp/' + id,
        type: "GET",
        dataType: 'json'
    }).done(function (datos) {
        // Limpiar la tabla actual
        $(".tabla-programaciones tbody").empty();
        // Iterar sobre los datos y añadirlos a la tabla
        datos.forEach(function (item) {
            var fila = '<tr>' +
                '<td>' + item.ids + '</td>' +
                '<td>' + item.name + '</td>' +
                '<td>' + item.amount + '</td>' +
                '<td>' + item.total + '</td>' +
                '<td>' +
                '<span class="btn btn-icon mb-1 text-danger" onclick="eliminarProgramacion(' + item.ids + ')">' +
                '<i class="mdi mdi-delete"></i>' +
                '</span>' +
                '</td>' +
                '</tr>';
            $(".tabla-programaciones tbody").append(fila);
        });
    });    
}

// para liquidar

function obtenerDatosProgramacionLiquidar(id) {
    $.ajax({
        url: 'http://localhost/practica/Programaciones/obtenerTodasProgramacionesTemp/' + id,
        type: "GET",
        dataType: 'json'
    }).done(function (datos) {
        // Limpiar la tabla actual
        
        $(".tabla-programaciones-liquidar tbody").empty();
        // Iterar sobre los datos y añadirlos a la tabla
        datos.forEach(function (item) {
            console.log(item);
            var fila = '<tr>' +
                '<td>' + item.ids + '</td>' +
                '<td>' + item.name + '</td>' +
                '<td>' + item.total + '</td>' +
                '<td>' +
                '<button class="btn btn-success btn-sm btn-icon mb-1" onclick="tempadd(' + item.ids + ')" style="line-height: 1;">' +
                '<i class="mdi mdi-plus" style="margin-top: -2px;"></i>' +
                '</button>' +
                '</td>' +
                '</tr>';
            $(".tabla-programaciones-liquidar tbody").append(fila);
        });
    });    
}

function tempadd(id){
    $.ajax({
        url: 'http://localhost/practica/Programaciones/tempAdd/' + id,
        type: "GET",
        dataType: 'json'
    }).done(function (datos) {
        obtenerDatosTemporalesFac(datos.id_user);
        obtenerDatosProgramacionLiquidar(datos.id_user);
    });    
}

function tempdelete(id,id_scheduling){
    
    $.ajax({
        url: 'http://localhost/practica/Programaciones/tempDelete/' + id + '/' + id_scheduling,
        type: "GET",
        dataType: 'json'
    }).done(function (datos) {
        obtenerDatosTemporalesFac(datos[0]['client_id']);
        obtenerDatosProgramacionLiquidar(datos[0]['client_id']);
        obtenerDatosLiquidacionLiquidar(datos[0]['client_id']);
    });    
}

function obtenerDatosTemporalesFac(id) {
    $.ajax({
        url: 'http://localhost/practica/Liquidarfac/obtenerDatosTemporalesFac/' + id,
        type: "GET",
        dataType: 'json'
    }).done(function (datos) {
        // Limpiar la tabla actual
        $(".tabla-liquidartemp tbody").empty();

        // Variables para almacenar la suma total y las filas con id_liquidation diferente de cero
        var sumaTotal = 0;
        var filasConIdLiquidation = [];

        // Iterar sobre los datos y añadirlos a las filas correspondientes
        datos.forEach(function (item) {
            // Calcular el total, negativo si id_scheduling es diferente de cero
            let indenti;
            var total = parseFloat(item.total);
            if (item.identification == 'P') {
                total *= -1;
                identi = item.id_scheduling;
            }else{
                identi = item.id_liquidation;
            }


            var fila = '<tr>' +
                '<td>' + item.nombre + '</td>' +
                '<td>' + item.cantidad + '</td>' +
                '<td>' + total + '</td>' +
                '<td>' +
                '<button class="btn btn-danger btn-sm btn-icon mb-1" onclick="tempdelete(' + item.id + ',' + identi + ')" style="line-height: 1;">' +
                '<i class="mdi mdi-minus" style="margin-top: -2px;"></i>' +
                '</button>' +
                '</td>' +
                '</tr>';

            // Añadir el total de la fila actual a la suma total
            sumaTotal += total;

            // Separar las filas según el valor de id_liquidation
            if (item.identification == 'L') {
                filasConIdLiquidation.push(fila);
            } else {
                $(".tabla-liquidartemp tbody").append(fila);
            }
        });

        // Agregar las filas con id_liquidation diferente de cero al inicio de la tabla
        filasConIdLiquidation.forEach(function (fila) {
            $(".tabla-liquidartemp tbody").prepend(fila);
        });

        // Agregar la fila "Final" con el campo de suma total al final de la tabla
        var filaFinal = '<tr>' +
            '<td></td>' +
            '<td colspan="1"><strong>Final:</strong></td>' +
            '<td><strong><span id="sumaTotal">' + sumaTotal.toFixed(2) + '</span></strong></td>' +
            '</tr>';
        $(".tabla-liquidartemp tbody").append(filaFinal);

        // Agregar console.log para mostrar los datos obtenidos
        console.log(datos);
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

//para liquidaciones
function obtenerDatosLiquidacionLiquidar(id) {
    $.ajax({
        url: 'http://localhost/practica/Programaciones/obtenerTodasLiquidacionesTemp/' + id ,
        type: "GET",
        dataType: 'json'
    }).done(function (datos) {

        // Limpiar la tabla actual
        $(".tabla-liquidaciones tbody").empty();
        // Iterar sobre los datos y añadirlos a la tabla
        datos.forEach(function (item) {
            console.log(item);
            var fila = '<tr>' +
                '<td>' + item.id + '</td>' +
                '<td>' + item.reception_id + '</td>' +
                '<td>' + item.price + '</td>' +
                '<td>' +
                '<button class="btn btn-success btn-sm btn-icon mb-1" onclick="tempAddLiq(' + item.id + ')" style="line-height: 1;">' +
                '<i class="mdi mdi-plus" style="margin-top: -2px;"></i>' +
                '</button>' +
                '</td>' +
                '</tr>';
            $(".tabla-liquidaciones tbody").append(fila);
        });
    });    
}

function tempAddLiq(id){
    $.ajax({
        url: 'http://localhost/practica/Liquidaciones/tempAddLiq/' + id,
        type: "GET",
        dataType: 'json'
    }).done(function (datos) {
        obtenerDatosTemporalesFac(datos.id_user);
        obtenerDatosLiquidacionLiquidar(datos.id_user);
    });    
}

//metodos para transferir los datos de la tabla temporalfac

function btnTransferirDatosfac() {
    // Confirmación para transferir los datos
    id_client = search_cliente=$("#search-cliente").val();
    alert(id_client);
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
            url: 'http://localhost/practica/LiquidarFac/transferir/'+id_client, // Ajuste esta URL a su ruta de API
            type: 'GET',
            dataType: 'json',
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