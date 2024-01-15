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
<div class="col-md-6 grid-margin">
        <div class="card">
            <div class="card-body">
            <h4>Buscar Cliente</h4>
                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label">Nombre del Cliente</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="name" placeholder="Servicio">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mr-2" onclick="registrarServicio()">Buscar</button>
            </div>
        </div>
    </div>
</div>

<div class="row">


    <div class="col-lg-6 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tabla de liquidaciones</h4>
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <!-- Agrega un estilo para limitar la altura y agregar una barra de desplazamiento -->
                    <table class="table tabla-programaciones">
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
    <div class="col-lg-6 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tabla de programaciones</h4>
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <!-- Agrega un estilo para limitar la altura y agregar una barra de desplazamiento -->
                    <table class="table tabla-programaciones">
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

<div class="row">
<div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tabla Temporal para liquidar</h4>
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <!-- Agrega un estilo para limitar la altura y agregar una barra de desplazamiento -->
                    <table class="table tabla-liquidartemp">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Cantidad</th>
                                <th>Total</th>
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