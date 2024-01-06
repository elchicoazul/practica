function FiltrarGuia() {

    // Validación de campos
    var cliente = $('#cliente').val();
    var fechaInicio = $('#fecha-inicio').val();
    var fechaFin = $('#fecha-fin').val();
    var codigoGuia = $('#codigo-guia').val();

    if (cliente == '' && fechaInicio == '' && fechaFin == '' && codigoGuia == '') {
        swal.fire('Error!', 'Al menos un campo debe ser completado', 'error');
        return false;
    }

    // Verificar si se ingresó la fecha de inicio sin fecha de fin
    if (fechaInicio != '' && fechaFin == '') {
        swal.fire('Error!', 'Debes ingresar la fecha de fin', 'error');
        return false;
    }

    // Verificar si se ingresó la fecha de fin sin fecha de inicio
    if (fechaFin != '' && fechaInicio == '') {
        swal.fire('Error!', 'Debes ingresar la fecha de inicio', 'error');
        return false;
    }

    // Creación del objeto model con los datos del formulario
    var filtro = document.getElementById("id-filtro").value;
    var cliente = document.getElementById("cliente").value;
    var fechaInicio = document.getElementById("fecha-inicio").value;
    var fechaFin = document.getElementById("fecha-fin").value;
    var codigoGuia = document.getElementById("codigo-guia").value;

    // Construct the search parameters object
    var model = {
        filtro: filtro,
        cliente: cliente,
        fechaInicio: fechaInicio,
        fechaFin: fechaFin,
        codigoGuia: codigoGuia
    };

    // Limpiar la tabla actual antes de realizar la nueva consulta
    $('.tabla-reportes tbody').empty();

    // Realizar la consulta AJAX
    $.ajax({
        url: 'http://localhost/practica/Reportes/ReporteGL',
        type: 'POST',
        data: model,
        dataType: 'json',
    }).done(function (datos) {
        // Verificar si hay datos en la respuesta
        if (datos && datos.length > 0) {
            // Iterar sobre los datos y añadirlos a la tabla
            datos.forEach(function (item) {
                var fila =
                    '<tr>' +
                    '<td>' + item.username + '</td>' +
                    '<td>' + item.date + '</td>' +
                    '<td>' + item.guide_code + '</td>' +
                    '<td>' + item.shipment_guide + '</td>' +
                    '<td>' + item.guideStatus + '</td>' +
                    '<td>' +
                    '<button type="button" class="btn btn-primary btn-icon mb-1" onclick="imprimir()">' +
                    '<i class="mdi mdi-printer"></i>' +
                    '</button>' +
                    '</td>' +
                    '</tr>';
                $('.tabla-reportes tbody').append(fila);
            });
        } else {
            // Mostrar mensaje de error cuando no hay datos
            swal.fire('Error!', 'No hay datos encontrados.', 'error');
        }
    }).fail(function () {
        // Manejar error de la consulta AJAX
        swal.fire('Error!', 'Hubo un problema al realizar la consulta.', 'error');
    });
}
