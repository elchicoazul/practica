<?= $this->extend('Layout/Dashboard'); ?>
<?= $this->section('content'); ?>


<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Registro de Productos</h4>

                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Nombre del producto</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" placeholder="Producto">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="price" class="col-sm-3 col-form-label">Precio</label>
                        <div class="col-sm-9">
                            <input type="number" step="0.01" min="0" class="form-control" id="price" placeholder="Precio">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="stock" class="col-sm-3 col-form-label">Stock</label>
                        <div class="col-sm-9">
                        <input type="number" pattern="\d+" class="form-control" id="stock" name="stock" placeholder="stock">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2" onclick="registrarProductos()">Registrar</button>
                    <button type="reset" class="btn btn-dark">Cancelar</button>

            </div>
        </div>
    </div>

    <!-- muestras -->
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Pre visualización</h4>
                <button class="btn btn-primary" onclick="btnTransferirDatos()">Guardar</button>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre_Producto</th>
                                <th>Precio (S/.)</th>
                                <th>Stock (Uds)</th>
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

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?= $this->endSection(); ?>