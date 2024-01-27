<?= $this->extend('Layout/Dashboard'); ?>
<?= $this->section('content'); ?>

<style>
.editable-field {
    padding: 5px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.editable-field:focus {
    outline: none;
    border-color: #66afe9;
    box-shadow: 0 0 5px #66afe9;
}
.table tbody tr {
    height: 30px; /* Ajusta la altura según sea necesario */
}

.table tbody td {
    padding: 5px; /* Ajusta el espaciado interno según sea necesario */
}

</style>


<div class="row">
    <div class="col-md-3 grid-margin">
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

        <!-- muestras -->
        <div class="col-lg-9 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Lista de Registro de los Usuarios</h4>
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <!-- Agrega un estilo para limitar la altura y agregar una barra de desplazamiento -->
                    <table class="table tabla-usuarios">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Rol</th>
                                <th>DNI/RUC</th>
                                <th>Ley_Oro</th>
                                <th>Ley_Plata</th>
                                <th>Oro fino</th>
                                <th>Plata piña</th>
                                <th>Oro_desc</th>
                                <th>Plata_desc</th>
                                <th>Acción</th>

                            </tr>
                        </thead>
                        <tbody>
                            <!-- Ejemplo de fila -->
                            <!-- Puede agregar más filas según sea necesario -->
                        </tbody>
                    </table>
                </div>
            </div>
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