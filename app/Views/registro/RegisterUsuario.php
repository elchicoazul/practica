<?= $this->extend('Layout/Dashboard'); ?>
<?= $this->section('content'); ?>

    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
            <h4 class="card-title">Registro de Clientes</h4>
                <div class="form-group">
                <label for="username">Nombre del Usuario: </label>
                <input type="text" class="form-control" id="username" placeholder="Username">
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                    <label for="rol">Rol del Usuario</label>
                    <select id="rol" class="form-control" onchange="frm_validar()">
                    
                        <option value="admin">Administrativo</option>
                        <option value="cliente">Cliente</option>
                    </select>
                    </div>

                    <div class="form-group col-md-6">
                    <label for="dni_ruc">DNI/RUC: </label>
                    <input type="text" class="form-control" id="dni_ruc" placeholder="DNI/RUC">
                    </div>
                </div>


                <div id="camposCliente" class="form-group hidden">

                    <div class="row">               
                        <div class="form-group col-md-6">
                        <label for="gold_law">Ley general de cola de Au  (grs/Kg.): </label>
                        <input type="number" step="0.01" min="0" max="9999999.99" class="form-control" id="gold_law" name="gold_law" placeholder="0.00">
                        </div>
                        
                        <div class="form-group col-md-6">
                        <label for="tailings_law">Ley general de cola de Ag (grs/Kg.): </label>
                        <input type="number" step="0.01" min="0" max="9999999.99" class="form-control" id="tailings_law" name="tailings_law" placeholder="0.00">
                        </div>  
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                        <label for="fine_gold_to_deliver">Oro fino por entregar: </label>
                        <input type="number" step="0.01" min="0" max="9999999.99" class="form-control" id="fine_gold_to_deliver" name="fine_gold_to_deliver" placeholder="0.00">
                        </div>  

                        <div class="form-group col-md-6">
                        <label for="pine_silver_to_deliver">Plata piña por entregar:</label>
                        <input type="number" step="0.01" min="0" max="9999999.99" class="form-control" id="pine_silver_to_deliver" name="pine_silver_to_deliver" placeholder="0.00">
                        </div>  
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="gold_discount">Descuento Au</label>
                            <input type="number" step="0.01" min="0" max="9999999.99" class="form-control" id="gold_discount" name="gold_discount" placeholder="0.00">
                            </div>  

                            <div class="form-group col-md-6">
                            <label for="silver_discount">Descuento Ag</label>
                            <input type="number" step="0.01" min="0" max="9999999.99" class="form-control" id="silver_discount" name="silver_discount" placeholder="0.00">
                        </div> 
                    </div>
                </div>

                <div class="form-group hidden" id="camposAdmin">
                    <div class="row">
                        <div class="form-group col-md-6">
                        <label for="password1">Contraseña</label>
                        <input type="password" class="form-control" id="password1" placeholder="Contraseña">
                        </div>
                        <div class="form-group col-md-6">
                        <label for="password2">Confirmar contraseña</label>
                        <input type="password" class="form-control" id="password2" placeholder="Contraseña">
                        </div>
                    </div>
                </div>


                <button type="submit" class="btn btn-primary mr-2" onclick="registrarUsuario()">Registrar</button>
                <button class="btn btn-dark">Cancelar</button>

            </div>
        </div>
    </div>

    <style>
        #camposCliente {
            display: none;
        }
    </style>

    <script> 
        document.getElementById('rol').addEventListener('change', function() {

            var valorSeleccionado = this.value;

            var div1 = document.getElementById('camposCliente');
            var div2 = document.getElementById('camposAdmin');


            if (valorSeleccionado === 'cliente') {
                div1.style.display = 'block'; // Muestra el div
                div2.style.display = 'none';

            } else {
                div1.style.display = 'none' // Oculta el div
                div2.style.display = 'block';
            }
        });
    </script>

<?= $this->endSection(); ?>