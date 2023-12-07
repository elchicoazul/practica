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
    <div class="col-md-5 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Registro de Servicios</h4>

                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label">Nombre del servicio</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="name" placeholder="Servicio">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="price" class="col-sm-3 col-form-label">Precio</label>
                    <div class="col-sm-9">
                        <input type="number" step="0.01" min="0" class="form-control" id="price" placeholder="Precio">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mr-2" onclick="registrarServicio()">Registrar</button>
                <button type="reset" class="btn btn-dark">Cancelar</button>
            </div>
        </div>
    </div>

    <div class="col-lg-7 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Lista de Registro de los Servicios</h4>
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <!-- Agrega un estilo para limitar la altura y agregar una barra de desplazamiento -->
                    <table class="table tabla-servicio">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre_Servicio</th>
                                <th>Precio</th>
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


<?= $this->endSection(); ?>