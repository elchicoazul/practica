
var pagProductos = function () {

    gvProductos: null;
    var gridProductos = $("#grid-productos");

    function llenarEstado() {

        //$.post(rutaAplicativo + 'Instalaciones/GetCrmTipo',
        //    { codtipo: '21' },
        //    function (data) {
        //        $.each(data, function (id, value) {

        //            $("#cboestado").append('<option value="' + value.codigo + '">' + value.descripcion + '</option>');

        //        });
        //        $('#cboestado').selectpicker({ noneSelectedText: 'Seleccionar estado ...' });
        //        $('#cboestado').val('1');
        //        $('.selectpicker').selectpicker('refresh');
        //    }, 'json');

        $.ajax({
            url: rutaAplicativo + 'Instalaciones/GetCrmTipo',
            type: "POST",
            data: { codtipo: '83' },
            async: false,
            dataType: 'json'
        }).done(function (data, textStatus, jqXHR) {

            $.each(data, function (id, value) {

                $("#cboestado").append('<option value="' + value.codigo + '">' + value.descripcion + '</option>');

            });

            $('#cboestado').selectpicker({ noneSelectedText: 'Seleccionar estado ...' });
            $('#cboestado').val('1');
            $('.selectpicker').selectpicker('refresh');

        });

    };

    function llenarCboAdicional() {

        //$.post(rutaAplicativo + 'Instalaciones/GetCrmTipo',
        //    { codtipo: '75' },
        //    function (data) {
        //        $.each(data, function (id, value) {
        //            $("#cboAdicional").append('<option value="' + value.codigo + '">' + value.descripcion + '</option>');
        //        });
        //        $('#cboAdicional').val('1');
        //        $('.selectpicker').selectpicker('refresh');
        //    }, 'json');

        $.ajax({
            url: rutaAplicativo + 'Instalaciones/GetCrmTipo',
            type: "POST",
            data: { codtipo: '75' },
            async: false,
            dataType: 'json'
        }).done(function (data, textStatus, jqXHR) {

            $.each(data, function (id, value) {

                $("#cboAdicional").append('<option value="' + value.codigo + '">' + value.descripcion + '</option>');

            });

            //$('#cboAdicional').val('1');
            $('.selectpicker').selectpicker('refresh');

        });


    };

    function llenarCboCargoEdit() {

        $.post(rutaAplicativo + 'Instalaciones/GetCrmTipo',
            { codtipo: '79' },
            function (data) {
                $.each(data, function (id, value) {
                    $("#txt-cargo").append('<option value="' + value.codigo + '">' + value.descripcion + '</option>');
                });

                $("#txt-cargo").selectpicker('refresh');

            }, 'json');

    };

    function llenarCboTipoRenta() {

        $.post(rutaAplicativo + 'Instalaciones/GetCrmTipo',
            { codtipo: '37' },
            function (data) {
                $.each(data, function (id, value) {
                    $("#cbotiporenta").append('<option value="' + value.codigo + '">' + value.descripcion + '</option>');
                });

                $("#cbotiporenta").selectpicker('refresh');

            }, 'json');

    };

    $(document).on('click', '.close', function (e) {
        limpiarControles();
    });

    function generarGridProductos() {

        //debugger;

        /*--var CodEstado = $('#cboestado').val();
        var tipoVenta = $('#cboAdicional').val();

        if (CodEstado != null) {
            CodEstado = $("#cboestado").val().toString();
        }
        else {
            CodEstado = "1";
        }--*/

        nombreCompleto = $("#txt-razonsocial").val();

        var formDataGrid = {
            //--estado: CodEstado,
            nombre: nombreCompleto
            //--tipoVenta: tipoVenta
        }

        this.gvProductos = gridProductos.kendoGrid({
            dataSource: {
                transport: {

                    read: {
                        url: rutaAplicativo + "Productos/ProductosListado",
                        contentType: "application/json; charset=utf-8",
                        type: "POST",
                        dataType: "json"
                    },
                    parameterMap: function (options) {

                        formDataGrid.take = options.take;
                        formDataGrid.skip = options.skip;
                        formDataGrid.sort = options.sort;
                        formDataGrid.filter = options.filter;
                        return kendo.stringify(formDataGrid);
                    }

                },
                pageSize: 20,
                serverPaging: true,
                schema: {
                    data: "listado",
                    total: "cantidad"
                }
            },
            pageable: {
                refresh: true,
                pageSizes: true,
                buttonCount: 5
            },
            height: 550,
            columns: [

                {
                    field: "codigoProducto",
                    title: "Codigo",
                    hidden: true
                }, {
                    //template: `<a style="border-radius: 7px;" class="btn btn-blues btn-sm text-center" href="${rutaAplicativo}Productos/actualizar/#:codigoProducto#"><i class ="fa fa-pencil fa-1"></i></a>`,
                    template: `<a style="border-radius: 7px;" class="btn btn-blues btn-sm text-center" id="btnList" data-toggle="modal" onClick="openModalEdit(#:codigoProducto#)"><i class ="fa fa-pencil fa-1"></i></a>`,
                    //<a style="border-radius: 7px;" class="btn btn-danger btn-sm text-center" id="btnList" data-toggle="modal" onClick="eliminarProducto(#:codigoProducto#)"><i class ="fa fa-minus fa-1"></i></a>`,
                    field: "codigoProducto",
                    title: "&nbsp;",
                    width: "7%",
                    attributes: { class: "text-center" }
                },
                {
                    field: "nombre",
                    title: "Nombre",
                    width: "25%"
                },
                //{
                //    field: "velocidad",
                //    title: "Velocidad",
                //    //--template: `#if( estadoEntero == 1) {#<span class='label label-green-sure'> #: estado # </span>#}else if(estadoEntero == 2){#<span class='label label-yellow'> #: estado # </span>#}else{#<span class='label label-danger-mod'> #: estado # </span>#}#`,
                //    //template: "<span class='label label-green-sure'> #: estado # </span>",
                //    width: "20%",
                //    headerAttributes: { style: "text-align: center" },
                //    attributes: { style: "text-align:center;" }
                //},
                //{
                //    field: "precio",
                //    title: "Precio",
                //    width: "8%",
                //    headerAttributes: { style: "text-align: center" },
                //    attributes: { style: "text-align:center;" }
                //},
                {
                    field: "usuarioCreacion",
                    title: "Usuario Creación",
                    width: "12%",
                    headerAttributes: { style: "text-align: center" },
                    attributes: { style: "text-align:center;" }
                }, {
                    field: "fechaCreacion",
                    title: "Fecha de Creación",
                    width: "13%",
                    headerAttributes: { style: "text-align:center" },
                    attributes: { class: "text-center" }
                }, {
                    field: "codigoECOM",
                    title: "Codigo ECOM",
                    width: "13%",
                    headerAttributes: { style: "text-align:center" },
                    attributes: { class: "text-center" }
                }],
        });

    };

    $('#txt-razonsocial').keypress(function (e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
            BuscarProducto();
        }
    })

    $(document).on('click', '.close', function (e) {
        limpiarControles();
    });

    function BuscarProducto() {

        //debugger;

        /*--var CodEstado = $('#cboestado').val();
        var tipoVenta = $('#cboAdicional').val();

        if (CodEstado != null) {
            CodEstado = $("#cboestado").val().toString();
        }
        else {
            CodEstado = "1";
        }--*/

        nombreCompleto = $("#txt-razonsocial").val();

        var formDataGrid = {
            //--estado: CodEstado,
            nombre: nombreCompleto
            //--tipoVenta: tipoVenta
        }

        var search = new kendo.data.DataSource({
            transport: {

                read: {
                    url: rutaAplicativo + "Productos/productosListado",
                    contentType: "application/json; charset=utf-8",
                    type: "POST",
                    dataType: "json"
                },
                parameterMap: function (options) {

                    formDataGrid.take = options.take;
                    formDataGrid.skip = options.skip;
                    formDataGrid.sort = options.sort;
                    formDataGrid.filter = options.filter;
                    return kendo.stringify(formDataGrid);
                }

            },
            pageSize: 20,
            serverPaging: true,
            schema: {
                data: "listado",
                total: "cantidad"
            }
        });

        gridProductos.data("kendoGrid").setDataSource(search);
    };

    function buscarGridProductos() {
        BuscarProducto();
    };

    function generarControles() {
        $("#btn-buscar").click(buscarGridProductos);
        $("#btn-exportar").click(exportarExcel);
    };

    $("#btn-buscar").click(function () {
        /*swal({
            title: 'Cargando Datos',
            html: 'Listando los Productos, espere unos segundos.',
            allowOutsideClick: false,
            onOpen: () => {
                swal.showLoading()
            }
        });*/

        buscarGridProductos();
        //swal.close();

    });

    function limpiarControles() {
        $("#modalNuevo").modal("hide");
        $('#codigo-vendedor').val(0);
        $('#usuario-vendedor').val('');
        $('#nombres-apellidos').val('');
        $("#cbocargo").val('');
        $("#cbocargo").val(0);
        $("#cboEstadoEdit").val('');
        $("#cboEstadoEdit").val(0);
        $('.selectpicker').selectpicker('refresh');
    };

    return {
        init: function () {
            //--llenarEstado();
            //--llenarCboAdicional();
            //llenarCboCargoEdit();
            llenarProductos();
            llenarTipoRenta();
            llenarPlazo();
            llenarCuotasProductosAdicionales();
            llenarCboTipoRenta();
            llenarProductosAnidados();
            llenarProductosAnidadosEditar();
            generarControles();
            generarGridProductos();
        }
    };
};

$(function () {
    function pageLoad() {

        var pag = pagProductos();
        pag.init();

    }

    pageLoad();
    swal.close();
});

function openModal() {
    $('#modalNuevoProducto').modal('show');
    $('#divProducto').css('display', 'block');
    $('#divAtributo').css('display', 'none');

    $('#cuentacontableMRCcod').val('');
    $('#cuentacontableNRCcod').val('');
    $('#nombre').val('');
    $('#cuentacontableMRC').val('');
    $('#cuentacontableNRC').val('');
    $('#cbo-ObligatorioProducto').val('').change();

    $("body").removeClass("modal-open");
    $(".modal-backdrop").css("z-index", "-1");
    $(".modal-content").css("margin-top", "54px");
    ///listarAdjuntos(codigo);

}

//RECIEN------------------------------------------------------------------
function openModalProductos() {
    $('#modalAgregarProductoSva').modal('show');
}

function closeModalPreConfiguracion() {
    $('#modalAgregarProductoSva').modal('hide');
}

function val() {
    var valor = $('#tipoRentaSva').val();

    if (valor == '01') {
        $('#control-cuotas').css('display', 'none');
        $('#control-plazo').css('display', 'block');
        $('#cuotasSVA').val('');
        $('#cuotasSVA').selectpicker('refresh')
    }
    else {
        $('#control-cuotas').css('display', 'block');
        $('#control-plazo').css('display', 'none');
        $('#plazoSva').val('');
        $('#plazoSva').selectpicker('refresh')
    }
}

function generarGridProductosSva() {
    var codProducto = $("#codigo-producto").val();

    var element = $("#grid-detalle_SVA").kendoGrid({
        dataSource: {
            type: "json",
            transport: {
                read: rutaAplicativo + 'Productos/listarProductosSva_PreConf?codigoProducto=' + codProducto
            },
            pageSize: 50
        },
        height: 300,
        scrollable: true,
        dataBinding: function () {
            record = (this.dataSource.page() - 1) * this.dataSource.pageSize();
        },
        columns: [
            {
                field: "codigoProductoSva",
                hidden: true
            },
            {
                field: "codigoProducto",
                hidden: true
            },
            {
                field: "nombre",
                title: "Producto Sva",
                width: "15%"
            },
            {
                field: "tipoRenta",
                title: "T. Renta",
                width: "10%"
            },
            {
                field: "precioTexto",
                title: "Precio",
                width: "10%"
            },
            {
                field: "cantidad",
                title: "Cantidad",
                width: "7%"
            },
            {
                field: "cuotasSVA",
                title: "Cuotas",
                width: "7%"
            },
            {
                field: "porcentajeDescuentoTexto",
                title: "Descuento %",
                width: "10%"
            },
            {
                field: "meses",
                title: "Meses Descuento",
                width: "12%"
            },
            {
                template: `<button style="border-radius: 7px;" class="btn btn-danger text-center" onClick="quitarProductoSva(#:codigoProductoSva#)"><i class ="fa fa-times fa-1"></i></button>`,
                field: "codigoProductoSva",
                title: "&nbsp;",
                width: "10%",
                attributes: { class: "text-center" }
            }
        ]
    });
};

function llenarProductos() {
    $.ajax({
        url: rutaAplicativo + 'Productos/listaProductos',
        type: "POST",
        data: { codtipo: '82' },
        async: false,
        dataType: 'json'
    }).done(function (data, textStatus, jqXHR) {
        $.each(data, function (id, value) {
            $("#productosSva").append('<option value="' + value.codigoProducto + '" data-indicador="' + value.indicador + '" data-tipo="' + value.tipoRenta + '"  data-origen="' + value.origen + '" data-velocidad="' + value.velocidad + '" >' + value.nombre + '</option>');
        });
        $('.selectpicker').selectpicker('refresh');
    });
};

function llenarTipoRenta() {

    $.ajax({
        url: rutaAplicativo + 'Instalaciones/GetCrmTipo',
        type: "POST",
        data: { codtipo: '45' },
        async: false,
        dataType: 'json'
    }).done(function (data, textStatus, jqXHR) {
        $.each(data, function (id, value) {
            $("#tipoRentaSva").append('<option value="' + value.codigo + '">' + value.descripcion + '</option>');
        });
        $('.selectpicker').selectpicker('refresh');
    });
};

function llenarPlazo() {
    $.ajax({
        url: rutaAplicativo + 'Instalaciones/GetCrmTipo',
        type: "POST",
        data: { codtipo: '82' },
        async: false,
        dataType: 'json'
    }).done(function (data, textStatus, jqXHR) {
        $.each(data, function (id, value) {
            $("#plazoSva").append('<option value="' + value.codigo + '">' + value.descripcion + '</option>');
        });
        $('.selectpicker').selectpicker('refresh');
    });
};

function llenarCuotasProductosAdicionales() {

    $.ajax({
        url: rutaAplicativo + 'Instalaciones/GetCrmTipo',
        type: "POST",
        data: { codtipo: '48' },
        async: true,
        dataType: 'json'
    }).done(function (data, textStatus, jqXHR) {

        $.each(data, function (id, value) {

            $("#cuotasSVA").append('<option value="' + value.codigo + '">' + value.descripcion + '</option>');

            $('#cuotasSVA').selectpicker('refresh');

        });

    });

};

function agregarMin(cantidadMax) {

    var cantidadActual = parseInt($("#cantidadSva").val());

    if (cantidadActual == cantidadMax) {
        swal('Productos', 'La cantidad máxima de este producto es de ' + cantidadMax + '.', 'warning');
        return;
    } else {
        cantidadActual = cantidadActual + 1;
        $("#cantidadSva").val(cantidadActual);
    }
}

function restarMin(cantidadMin) {

    var cantidadActual = parseInt($("#cantidadSva").val());

    if (cantidadActual == cantidadMin) {
        swal('Productos', 'La cantidad mínima de este producto es de ' + cantidadMin + '.', 'warning');
        return;
    } else {
        cantidadActual = cantidadActual - 1;
        $("#cantidadSva").val(cantidadActual);
    }
}

function guardarProductoSva() {
    var codProducto = $("#codigo-producto").val();

    var producto = $('#productosSva').val();
    var tipoRenta = $('#tipoRentaSva').val();
    var precio = $('#precioSva').val();
    var plazo = parseInt($('#plazoSva').val());
    var cuotasSVA = $('#cuotasSVA').val();
    var cantidad = parseInt($('#cantidadSva').val());
    var porcentajeDescuento = $('#porcentajeSva').val();
    var meses = $('#mesesSva').val();

    if (producto == '' || producto == null) {
        swal('Error!', 'Es necesario seleccionar un producto', 'error');
        return false;
    }

    producto = $('#productosSva').val().toString();

    if (tipoRenta == '' || tipoRenta == null) {
        swal('Error!', 'Es necesario seleccionar el tipo de renta', 'error');
        return false;
    }

    if (precio == '' || precio == null) {
        swal('Error!', 'Es necesario ingresar el precio para el cobro en los recibos', 'error');
        return false;
    }

    if (precio >= 1000) {
        swal('Error!', 'El precio no puede ser mayor a 999.', 'error');
        return false;
    }

    if ((plazo == 'NaN' || plazo == null) && tipoRenta == '01') {
        swal('Error!', 'Es necesario seleccionar el plazo del producto', 'error');
        return false;
    }

    if ((cuotasSVA == '' || cuotasSVA == null) && tipoRenta == '02') {
        swal('Error!', 'Es necesario seleccionar el máximo de cuotas del producto', 'error');
        return false;
    }

    if (cantidad < 0 || cantidad == 0) {
        swal('Error!', 'La cantidad mínima no puede ser 0 o menor que 0', 'error');
        return false;
    }

    if (porcentajeDescuento == "") {
        swal('Error!', 'Ingresar cantidad de descuento.', 'error');
        return false;
    }

    if (porcentajeDescuento > 100) {
        swal('Error!', 'El descuento aplicado no es correcto, la cantidad máxima es del 100%', 'error');
        return false;
    }

    if (porcentajeDescuento < 0) {
        swal('Error!', 'El descuento aplicado no es correcto, la cantidad minuma debe ser 1%', 'error');
        return false;
    }

    if (parseFloat($('#porcentajeSva').val()) > 0 && meses == 0) {
        swal('Error!', 'Es necesario ingresar cuantos meses de descuento se va a aplicar.', 'error');
        return false;
    }

    if (meses == "") {
        swal('Error!', 'Ingresar meses de descuento.', 'error');
        return false;
    }

    if (parseInt(meses) > plazo && tipoRenta == '01') {
        swal('Error!', 'Los meses de descuento no puede ser mayor al plazo, plazo del producto seleccionado es de ' + plazo + ' meses.', 'error');
        return false;
    }

    if (parseInt(meses) > cuotasSVA && tipoRenta == '02') {
        swal('Error!', 'Los meses de descuento no puede ser mayor al máximo de cuotas del producto.', 'error');
        return false;
    }

    if (tipoRenta == '02') {
        plazo = cuotasSVA;
    }

    var model = {};
    model.codigoProductoSva = codProducto;
    model.codigoProductoString = producto;
    model.precio = precio;
    model.cantidad = cantidad;
    model.tipoRenta = tipoRenta;
    model.plazo = plazo;
    model.porcentajeDescuento = porcentajeDescuento;
    model.meses = meses;
    model.cuotasSVA = cuotasSVA;

    swal({
        title: "Agregar Pre-Configuracion SVA",
        text: "Se agregará la Pre-Configuracion SVA al producto.",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, estoy de acuerdo',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.value) {

            $.ajax({
                url: rutaAplicativo + 'Productos/insertarProductoSvaAtributo',
                type: "POST",
                data: model,
                dataType: 'json'
            }).done(function (data, textStatus, jqXHR) {
                if (data.estado == 200) {

                    swal('Registrado!', data.mssg, 'success');

                    /* Agregar listaro de la grilla */

                    $('#control-grid-detalle-sva').css('display', 'block');
                    $('#btnProductosAdd-sva').css('display', 'initial');
                    $('#control-grid-mascara-sva').css('display', 'none');

                    generarGridProductosSva();

                    $('#precioSva').val('');
                    $('#cantidadSva').val(1);

                    $('#porcentajeSva').val(0);
                    $('#mesesSva').val(0);

                    $("#productosSva").val('');
                    $("#productosSva").val(0);
                    $('#productosSva').selectpicker('refresh');

                    $("#plazoSva").val('');
                    $('#plazoSva').selectpicker('refresh');

                    $('#cuotasSVA').val('');
                    $('#cuotasSVA').selectpicker('refresh')

                    $("#tipoRentaSva").val('');
                    $("#tipoRentaSva").val(0);
                    $('#tipoRentaSva').selectpicker('refresh');

                    $('#modalAgregarProductoSva').modal('hide');

                }
                else {
                    swal('Error!', data.mssg, 'error');
                }
            })

        }
    })

}

function quitarProductoSva(codigoProducto) {

    var model = {};
    model.codigoProductoSva = codigoProducto;

    swal({
        title: "¿Está seguro de esta operación? ",
        text: "Se retirará el producto SVA.",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, estoy de acuerdo',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.value) {

            $.ajax({
                url: rutaAplicativo + 'Productos/quitarProductoSva',
                type: "POST",
                data: model,
                dataType: 'json'
            }).done(function (data, textStatus, jqXHR) {
                if (data.estado == 200) {

                    swal('Registrado!', data.mssg, 'success');
                    generarGridProductosSva();
                }
                else {
                    swal('Error!', data.mssg, 'error')
                }
            })

        }
    })
};

$(document).on('click', '#btn-nuevo', function (e) {

    $('#divProducto').css('display', 'block');
    $('#divAtributo').css('display', 'none');

    /*llenarProductosAnidados();*/

    $('#cuentacontableMRCcod').val('');
    $('#cuentacontableNRCcod').val('');
    $('#nombre').val('');
    $('#cuentacontableMRC').val('');
    $('#cuentacontableNRC').val('');
    $('#cbo-ObligatorioProducto').val('').change();
    $('#modalNuevoProducto').modal('show');

});

$(document).on('click', '.close', function (e) {
    limpiarControles();
});

function limpiarControles() {
    $('#precioSva').val('');
    $('#cantidadSva').val(1);

    $('#porcentajeSva').val(0);
    $('#mesesSva').val(0);

    $("#productosSva").val('');
    $("#productosSva").val(0);
    $('#productosSva').selectpicker('refresh');

    $("#plazoSva").val('');
    $("#plazoSva").val(0);
    $('#plazoSva').selectpicker('refresh');

    $('#cuotasSVA').val('');
    $('#cuotasSVA').selectpicker('refresh')

    $("#tipoRentaSva").val('');
    $("#tipoRentaSva").val(0);
    $('#tipoRentaSva').selectpicker('refresh');
};

function exportarExcel() {

    swal({
        title: 'Cargando Datos',
        html: 'Exportando..., espere unos segundos.',
        allowOutsideClick: false,
        onOpen: () => {
            swal.showLoading()
        }
    });

    $.ajax({
        url: rutaAplicativo + "Productos/DocumentoListarExcel",
        type: "POST",
        dataType: 'json'
    }).done(function (data, textStatus, jqXHR) {

        swal.close();
        window.open(rutaAplicativo + "Productos/ExportarExcel", '_blank');

    }).fail(function (data, textStatus, jqXHR) {
        swal.close();
    });
};
//------------------------------------------------------------------------

function soloNumeros(e) {
    var key = e.keyCode || e.which,
        tecla = String.fromCharCode(key).toLowerCase(),
        numeros = " 0123456789",
        especiales = [8, 37, 39, 46],
        tecla_especial = false;

    //if (($("#cbotipodoc_e").val() == '04') || ($("#cbotipodoc").val() == '04')) numeros = " 0123456789abcdefghijklmnopqrstuvwxyz";

    for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if (numeros.indexOf(tecla) == -1 && !tecla_especial) {
        return false;
    }
}

function mCerrar() {
    $("#modalNuevoProducto").modal("hide");
}

function mRegistro() {
    if ($("#cbo-ObligatorioProducto").val() == "") {
        swal('Error!', 'Indique si es o no un servicio de Telefonia', 'error');
        return false;
    }

    if ($("#nombre").val() == "") {
        swal('Error!', 'Es necesario ingresar el nombre del producto.', 'error');
        return false;
    }
    if ($("#cuentacontableMRCcod").val() == "") {
        swal('Error!', 'Es necesario ingresar una cuenta contable MRC.', 'error');
        return false;
    }
    if ($("#cuentacontableNRCcod").val() == "") {
        swal('Error!', 'Es necesario ingresar una cuenta contable NRC.', 'error');
        return false;
    }
    if ($("#cbo-ObligatorioCategoria").val() == "") {
        swal('Error!', 'Es necesario ingresar una categoria de producto.', 'error');
        return false;
    }
    var habilitatOT = 0;

    if ($('#habilitado').prop('checked')) {
        habilitatOT = 1;
    }

    var validacionAutomatica = 0;

    if ($('#validacionAutomatica').prop('checked')) {
        validacionAutomatica = 1;
    }

    var productosAnidados = $('#productosAnidados').val();
    if (productosAnidados != null) { productosAnidados = productosAnidados.join(";"); }

    var model = {};
    model.nombre = $("#nombre").val();
    model.obligatorio = $("#cbo-ObligatorioProducto").val();
    //model.velocidad = $("#velocidad").val();
    //model.tipoRenta = $("#cbotiporenta :selected").val();
    //model.precio = precio;
    model.cuentacontableMRC = $("#cuentacontableMRCcod").val();
    model.cuentacontableNRC = $("#cuentacontableNRCcod").val();
    model.cuentacontableNRC = $("#cuentacontableNRCcod").val();
    model.habilitarOT = habilitatOT;
    model.noMostrarEnDetallePedido = $('#noMostrarEnPedido').is(':checked');
    model.validacionAutomatica = validacionAutomatica;
    model.productosAnidados = productosAnidados;
    model.descripcionOferta = $("#descripciones").val();
    model.obligatorioCategoria = $("#cbo-ObligatorioCategoria").val();
    model.tipo_sva = $("#svas").val();
    model.linkimg = $("#imagenes").val();

    //debugger;

    swal({
        title: "Guardar registro",
        text: "¿Está seguro de guardar los datos ingresados?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Guardar',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: rutaAplicativo + 'Productos/RegistroProducto',
                type: "POST",
                data: model,
                dataType: 'json'
            }).done(function (data, textStatus, jqXHR) {
                if (data.estado == 200) {
                    swal('Registrado!', data.mssg, 'success')

                    //debugger;

                    $("#producto_id").val(data.id);


                    $('#divProducto').css('display', 'none');
                    $('#divAtributo').css('display', 'block');

                    //$("#modalNuevoProducto").modal("hide");

                    $('#nombre').val('');
                    $("#cuentacontableMRC").val('');
                    $("#cuentacontableNRC").val('');
                    $("#svas").val('');
                    $("#imagenes").val('');
                    $("#descripciones").val('');
                    $("#habilitadoEdit").prop("checked", false);
                    //$('#velocidad').val('');
                    //$("#cbotiporenta").val(0);
                    //$("#precio").val(0);
                    //$('.selectpicker').selectpicker('refresh');

                    $('#modalNuevoProducto').modal('hide');
                    //generarGridAtributos();

                    $("#btn-buscar").click();
                }
                else {
                    swal('Error!', data.mssg, 'error')
                }
            })
        }
    })
}

function mRegistroAtributo() {


    if ($("#nombreAtributo").val() == "") {
        swal('Error!', 'Es necesario ingresar el nombre del atributo.', 'error');
        return false;
    }
    if ($("#valorAtributo").val() == "") {
        swal('Error!', 'Es necesario ingresar el valor del atributo.', 'error');
        return false;
    }

    //debugger;

    var model = {};

    model.codigoProducto = $("#producto_id").val();
    model.nombre = $("#nombreAtributo").val();
    model.valor = $("#valorAtributo").val();
    model.tipoValor = 1;

    $.ajax({
        url: rutaAplicativo + 'Productos/RegistroAtributo',
        type: "POST",
        data: model,
        dataType: 'json'
    }).done(function (data, textStatus, jqXHR) {
        if (data.estado == 200) {
            swal('Registrado!', data.mssg, 'success')


            $('#nombreAtributo').val('');
            $("#valorAtributo").val('');

            generarGridAtributos();
            //$("#btn-buscar").click();
        }
        else {
            swal('Error!', data.mssg, 'error')
        }
    })

}

function generarGridAtributos() {

    var codProducto = $("#producto_id").val();

    var element = $("#grid-atributos").kendoGrid({
        dataSource: {
            type: "json",
            transport: {
                read: rutaAplicativo + "Productos/GetListarAtributos/" + codProducto
            },
            pageSize: 10
        },
        height: 250,
        //selectable: true,
        scrollable: true,
        dataBinding: function () {
            record = (this.dataSource.page() - 1) * this.dataSource.pageSize();
        },


        columns: [
            {
                field: "codigoProductoAtriburto",
                title: "Codigo",
                hidden: true
            },
            {
                field: "nombre",
                title: "Nombre",
                width: "44%"
            },
            {
                field: "valor",
                title: "Valor",
                width: "44%"
            },
            {
                template: `<a style="border-radius: 7px;" class="btn btn-danger btn-sm text-center" id="btnListNuevo" data-toggle="modal" onClick="eliminarAtributo(#:codigoProductoAtributo#)"><i class="fa fa-times fa-1"></i></a>`,
                field: "codigoProductoAtributo",
                title: "&nbsp;",
                width: "12%",
                attributes: { class: "text-center" }
            }]


    });
};


function mRegistroAtributoEdit() {


    if ($("#txt-nombreAtributo").val() == "") {
        swal('Error!', 'Es necesario ingresar el nombre del atributo.', 'error');
        return false;
    }
    if ($("#txt-valorAtributo").val() == "") {
        swal('Error!', 'Es necesario ingresar el valor del atributo.', 'error');
        return false;
    }

    //debugger;

    var model = {};

    model.codigoProducto = $("#codigo-producto").val();
    model.nombre = $("#txt-nombreAtributo").val();
    model.valor = $("#txt-valorAtributo").val();
    model.tipoValor = 1;

    $.ajax({
        url: rutaAplicativo + 'Productos/RegistroAtributo',
        type: "POST",
        data: model,
        dataType: 'json'
    }).done(function (data, textStatus, jqXHR) {
        if (data.estado == 200) {
            swal('Registrado!', data.mssg, 'success')

            $("#txt-nombreAtributo").val('');
            $("#txt-valorAtributo").val('');

            generarGridAtributosEdit();
        }
        else {
            swal('Error!', data.mssg, 'error')
        }
    })

}


function generarGridAtributosEdit() {

    var codProducto = $("#codigo-producto").val();

    var element = $("#grid-atributos-edit").kendoGrid({
        dataSource: {
            type: "json",
            transport: {
                read: rutaAplicativo + "Productos/GetListarAtributos/" + codProducto
            },
            pageSize: 10
        },
        height: 250,
        //selectable: true,
        scrollable: true,
        dataBinding: function () {
            record = (this.dataSource.page() - 1) * this.dataSource.pageSize();
        },


        columns: [
            {
                field: "codigoProductoAtriburto",
                title: "Codigo",
                hidden: true
            },
            {
                field: "nombre",
                title: "Nombre",
                width: "44%"
            },
            {
                field: "valor",
                title: "Valor",
                width: "44%"
            },
            {
                template: `<a style="border-radius: 7px;" class="btn btn-danger btn-sm text-center" id="btnListEditar" data-toggle="modal" onClick="eliminarAtributoEdit(#:codigoProductoAtributo#)"><i class="fa fa-times fa-1"></i></a>`,
                field: "codigoProductoAtributo",
                title: "&nbsp;",
                width: "12%",
                attributes: { class: "text-center" }
            }]


    });
};


function mActualizar() {

    if ($("#txt-nombre").val() == "") {
        swal('Error!', 'Es necesario ingresar el nombre del producto.', 'error');
        return false;
    }
    if ($("#txt-cuentacontableMRCcod").val() == "") {
        swal('Error!', 'Es necesario ingresar una cuenta contable MRC.', 'error');
        return false;
    }
    if ($("#txt-cuentacontableNRCcod"
    ).val() == "") {
        swal('Error!', 'Es necesario ingresar una categoria.', 'error');
        return false;
    }
    if ($("#cbo-ObligatorioCategoria1").val() == "") {
        swal('Error!', 'Es necesario ingresar una categoria de producto.', 'error');
        return false;
    }
    var habilitatOT = 0;

    if ($('#habilitadoEdit').prop('checked')) {
        habilitatOT = 1;
    }
    var validacionAutomatica = 0;

    if ($('#validacionAutomaticaEdit').prop('checked')) {
        validacionAutomatica = 1;
    }

    var productosAnidados = $('#productosAnidadosEdit').val();
    if (productosAnidados != null) {
        productosAnidados = productosAnidados.join(";");
    }




    var model = {};
    model.codigoProducto = $('#codigo-producto').val();
    model.nombre = $("#txt-nombre").val();
    model.cuentacontableMRC = $("#txt-cuentacontableMRCcod").val();
    model.obligatorio = $("#cbo-ObligatorioProducto1").val();
    model.cuentacontableNRC = $("#txt-cuentacontableNRCcod").val();
    model.habilitarOT = habilitatOT;
    model.noMostrarEnDetallePedido = $('#noMostrarEnPedidoEdit').is(':checked');
    model.validacionAutomatica = validacionAutomatica;
    model.productosAnidados = productosAnidados;
    model.obligatorioCategoria = $("#cbo-ObligatorioCategoria1").val();
    model.descripcionOferta = $("#descripcion").val();
    swal({
        title: "Actualizar registro",
        text: "¿Está seguro de actualizar el dato ingresado?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Guardar',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: rutaAplicativo + 'Productos/ActualizarProducto',
                type: "POST",
                data: model,
                dataType: 'json'
            }).done(function (data, textStatus, jqXHR) {
                if (data.estado == 200) {
                    swal('Actualizado!', data.mssg, 'success')
                    $("#modalEditarProducto").modal("hide");

                    $('#codigo-producto').val(0);
                    $('#txt-nombre').val('');
                    $('#txt-cuentacontableMRC').val('');
                    $('#txt-cuentacontableNRC').val('');
                    $("#txt-nombreAtributo").val('');
                    $("#txt-valorAtributo").val('');
                    $("#habilitadoEdit").prop("checked", false);
                    $("#btn-buscar").click();
                }
                else {
                    swal('Error!', data.mssg, 'error')
                }
            })
        }
    })
}

function eliminarAtributo(codigo) {

    var model = {};

    model.codigoProductoAtributo = codigo;

    $.ajax({
        url: rutaAplicativo + 'Productos/eliminarAtributo',
        type: "POST",
        data: model,
        dataType: 'json'
    }).done(function (data, textStatus, jqXHR) {
        if (data.estado == 200) {
            swal('Eliminado!', data.mssg, 'success')

            generarGridAtributos();
        }
        else {
            swal('Error!', data.mssg, 'error')
        }
    })

}

function eliminarAtributoEdit(codigo) {

    var model = {};

    model.codigoProductoAtributo = codigo;

    $.ajax({
        url: rutaAplicativo + 'Productos/eliminarAtributo',
        type: "POST",
        data: model,
        dataType: 'json'
    }).done(function (data, textStatus, jqXHR) {
        if (data.estado == 200) {
            swal('Eliminado!', data.mssg, 'success')

            generarGridAtributosEdit();
        }
        else {
            swal('Error!', data.mssg, 'error')
        }
    })

}


function openModalEdit(codigo) {

    $('#modalEditarProducto').modal('show');

    //$("body").removeClass("p.ñmodal-open");
    //$(".modal-backdrop").css("z-index", "-1");
    //$(".modal-content").css("margin-top", "54px");

    //listarAdjuntos(codigo);

    $.ajax({
        url: rutaAplicativo + 'Productos/detalleProducto',
        type: "POST",
        data: { codigoProducto: codigo },
        async: false,
        dataType: 'json'
    }).done(function (data, textStatus, jqXHR) {

        $('#codigo-producto').val(codigo);
        $('#txt-nombre').val(data.nombre);
        $('#cbo-ObligatorioProducto').val(data.obligatorio).change();
        $('#cbo-ObligatorioProducto1').val(data.obligatorio).change();

        //$('#txt-velocidad').val(data.velocidad);
        //$('#txt-cbotiporenta').val(data.tipoRenta);
        //$('#txt-precio').val(data.precio);
        $('#productosAnidadosEdit').val(data.productosAnidados.split(";")).change();

        $('#txt-cuentacontableMRC').val(data.cuentaContableMRC);
        $('#txt-cuentacontableNRC').val(data.cuentaContableNRC);
        $('#txt-cuentacontableMRCcod').val(data.cuentaContableMRC);
        $('#txt-cuentacontableNRCcod').val(data.cuentaContableNRC);
        $('#sva').val(data.tipo_sva);
        $('#imagen').val(data.linkimg);

        $('#productosAnidadosEdit').selectpicker('refresh');
        //Autoventa
        if (data.obligatorioCategoria != "") {
            $("#cbo-ObligatorioCategoria1").val(data.obligatorioCategoria).change();

        } else {

            $("#cbo-ObligatorioCategoria1").val("").change();
        }
        $("#descripcion").val(data.descripcionOferta);
       
      
        if (data.habilitarOT == "1") {
            $("#habilitadoEdit").prop("checked", true);
        }

        if (data.noMostrarEnDetallePedido == true) {
            $("#noMostrarEnPedidoEdit").prop("checked", true);
        }

        if (data.validacionAutomatica == 1) {
            $("#validacionAutomaticaEdit").prop("checked", true);
        }

        generarGridAtributosEdit();
        generarGridProductosSva();
    });

}

function AutocompletarCuentaMRC() {

    var _cuenta = $('#cuentacontableMRC').val();

    $("#cuentacontableMRC").autocomplete({
        source: function (request, response) {
            $.getJSON(rutaAplicativo + 'Productos/listarCuenta',
                {
                    cuenta: _cuenta
                },
                function (data) {
                    response($.map(data, function (item) {
                        return {
                            descripcion: item.descripcion,
                            label: item.descripcion,
                            codigo: item.codigo,
                        }
                    }));
                });
        },
        minLength: 3,
        messages: {
            noResults: '',
            results: function () { }
        },
        select: function (event, ui) {
            event.preventDefault();
            console.log(ui.item);
            $('#cuentacontableMRC').val(ui.item.descripcion);
            $('#cuentacontableMRCcod').val(ui.item.codigo);
        }
    });
}

function AutocompletarCuentaNRC() {

    var _cuenta = $('#cuentacontableNRC').val();

    $("#cuentacontableNRC").autocomplete({
        source: function (request, response) {
            $.getJSON(rutaAplicativo + 'Productos/listarCuenta',
                {
                    cuenta: _cuenta
                },
                function (data) {
                    response($.map(data, function (item) {
                        return {
                            descripcion: item.descripcion,
                            label: item.descripcion,
                            codigo: item.codigo,
                        }
                    }));
                });
        },
        minLength: 3,
        messages: {
            noResults: '',
            results: function () { }
        },
        select: function (event, ui) {
            event.preventDefault();
            $('#cuentacontableNRC').val(ui.item.descripcion);
            $('#cuentacontableNRCcod').val(ui.item.codigo);
        }
    });
}

function txt_AutocompletarCuentaMRC() {

    var _cuenta = $('#txt-cuentacontableMRC').val();

    $("#txt-cuentacontableMRC").autocomplete({
        source: function (request, response) {
            $.getJSON(rutaAplicativo + 'Productos/listarCuenta',
                {
                    cuenta: _cuenta
                },
                function (data) {
                    response($.map(data, function (item) {
                        return {
                            descripcion: item.descripcion,
                            label: item.descripcion,
                            codigo: item.codigo,
                        }
                    }));
                });
        },
        minLength: 3,
        messages: {
            noResults: '',
            results: function () { }
        },
        select: function (event, ui) {
            event.preventDefault();
            console.log(ui.item);
            $('#txt-cuentacontableMRC').val(ui.item.descripcion);
            $('#txt-cuentacontableMRCcod').val(ui.item.codigo);
        }
    });
}

function txt_AutocompletarCuentaNRC() {

    var _cuenta = $('#txt-cuentacontableNRC').val();

    $("#txt-cuentacontableNRC").autocomplete({
        source: function (request, response) {
            $.getJSON(rutaAplicativo + 'Productos/listarCuenta',
                {
                    cuenta: _cuenta
                },
                function (data) {
                    response($.map(data, function (item) {
                        return {
                            descripcion: item.descripcion,
                            label: item.descripcion,
                            codigo: item.codigo,
                        }
                    }));
                });
        },
        minLength: 3,
        messages: {
            noResults: '',
            results: function () { }
        },
        select: function (event, ui) {
            event.preventDefault();
            $('#txt-cuentacontableNRC').val(ui.item.descripcion);
            $('#txt-cuentacontableNRCcod').val(ui.item.codigo);
        }
    });
}

function llenarProductosAnidados() {

    $.ajax({
        url: rutaAplicativo + 'OrdenTrabajo/productoListado',
        type: "POST",
        data: { codtipo: 0 },
        async: false,
        dataType: 'json'
    }).done(function (data, textStatus, jqXHR) {

        $.each(data, function (id, value) {
            $("#productosAnidados").append('<option value="' + value.codigo + '">' + value.nombre + '</option>');

        });

        $('#productosAnidados').selectpicker('refresh');

    });

};

function llenarProductosAnidadosEditar() {

    $.ajax({
        url: rutaAplicativo + 'OrdenTrabajo/productoListado',
        type: "POST",
        data: { codtipo: 0 },
        async: false,
        dataType: 'json'
    }).done(function (data, textStatus, jqXHR) {

        $.each(data, function (id, value) {
            $("#productosAnidadosEdit").append('<option value="' + value.codigo + '">' + value.nombre + '</option>');

        });

        $('#productosAnidadosEdit').selectpicker('refresh');

    });

};

