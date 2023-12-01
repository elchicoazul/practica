<?= $this->extend('Layout/Dashboard'); ?>
<?= $this->section('content'); ?>
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

<?= $this->endSection(); ?>