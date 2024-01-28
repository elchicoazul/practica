<?= $this->extend('Layout/Dashboard'); ?>
<?= $this->section('content'); ?>

<h1>hola mundo </h1>
<form method="post" action="<?php echo base_url();?>descargar">

<button>submit</button>
</form>

<form method="get" action="<?php echo base_url();?>Liquidacion/obtenerDetalleGuia/4">

<button>submit</button>
</form>
<?= $this->endSection(); ?>