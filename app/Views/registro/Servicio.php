<?= $this->extend('Layout/Dashboard'); ?>
<?= $this->section('content'); ?>
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

<?= $this->endSection(); ?>