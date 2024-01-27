function FiltrarReporte() {
    // Validación de campos
    var cliente = $('#cliente').val();
    var fechaInicio = $('#fecha-inicio').val();
    var fechaFin = $('#fecha-fin').val();
    var codigo = $('#codigo').val();
    
    if (cliente == '' && fechaInicio == '' && fechaFin == '' && codigo == '') {
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
    var codigo = document.getElementById("codigo").value;
    
    // Construct the search parameters object
    var model = {
        filtro: filtro,
        cliente: cliente,
        fechaInicio: fechaInicio,
        fechaFin: fechaFin,
        codigo: codigo
    };
    
    // Limpiar la tabla actual antes de realizar la nueva consulta
    if (filtro === 'guia') {
        $('.tabla-reportes-guia tbody').empty();
    } else if (filtro === 'liquidacion') {
        $('.tabla-reportes-liquidacion tbody').empty();
    }

    // Realizar la consulta AJAX
    $.ajax({
        url: 'http://localhost/practica/Reportes/ReporteGL',
        type: 'POST',
        data: model,
        dataType: 'json',
    }).done(function (datos) {
        // Verificar si hay datos en la respuesta
        console.log(datos);
        if (datos && datos.length > 0) {
            // Iterar sobre los datos y añadirlos a la tabla correspondiente
            datos.forEach(function (item) {
                // Construir la fila según el grupo de datos
                var fila = '';
                if (filtro === 'guia') {
                    fila = '<tr>' +
                        '<td>' + item.username + '</td>' +
                        '<td>' + item.date + '</td>' +
                        '<td>' + item.guide_code + '</td>' +
                        '<td>' + item.shipment_guide + '</td>' +
                        '<td>' + item.guideStatus + '</td>' +
                        '<td>' +
                        '<button type="button" class="btn btn-primary btn-icon mb-1" onclick="exportarAPDFguia(' + item.id + ')">' +
                        '<i class="mdi mdi-printer"></i>' +
                        '</button>' +
                        '</td>' +
                        '</tr>';
                    // Agregar la fila a la tabla de guías
                    $('.tabla-reportes-guia tbody').append(fila);
                } else if (filtro === 'liquidacion') {
                    fila = '<tr>' +
                        '<td>' + item.username + '</td>' +
                        '<td>' + item.fecha_create + '</td>' +
                        '<td>' + item.id_guide + '</td>' +
                        '<td>' + item.total_liquidation + '</td>' +
                        '<td>' +
                        '<button type="button" class="btn btn-primary btn-icon mb-1" onclick="exportarAPDF(' + item.id + ')">' +
                        '<i class="mdi mdi-printer"></i>' +
                        '</button>' +
                        '</td>' +
                        '</tr>';
                    // Agregar la fila a la tabla de liquidaciones
                    $('.tabla-reportes-liquidacion tbody').append(fila);
                }
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
