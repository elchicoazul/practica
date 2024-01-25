<?= $this->extend('Layout/Dashboard'); ?>
<?= $this->section('content'); ?>

<h1>hola mundo </h1>
<div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Codigo" id="codDetail" >
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-primary" id="searchDetail">Buscar Detalle</button>
                        </div>
                    </div>
                </div>
<!-- importar el archivo impresioon.js -->
<script src="<?php echo base_url('assets/js/impresion/impresion.js'); ?>"></script>
<?= $this->endSection(); ?>