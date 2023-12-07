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
                    swal.fire('Registrado!', data.mssg, 'success');
                    // Restablecer los valores de los campos después del registro exitoso
                    $("#search-cliente").val('');
                    $("#search-product").val('');
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