<?= $this->extend('Layout/Dashboard'); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Datos del Cliente y Código de Guía</h4>
                <p class="card-description">Ingrese los datos requeridos</p>

                <!-- Cliente con botón de búsqueda -->
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cliente" aria-label="Cliente">
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-primary" type="button">Buscar Cliente</button>
                        </div>
                    </div>
                </div>

                <!-- Código de Guía con botón de búsqueda -->
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Código de Guía" aria-label="Código de Guía">
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-primary" type="button">Buscar Guía</button>
                        </div>
                    </div>
                </div>

               
            </div>
        </div>
    </div>
    <div class="col-lg-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tabla de Datos</h4>
                
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Guía</th>
                                <th>Código</th>
                                <th>Peso Hum (KG)</th>
                                <th>Humedad (%)</th>
                                <th>Peso Seco (KG)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Ejemplo de fila -->
                            <tr>
                                <td>1</td>
                                <td>Guía #1</td>
                                <td>Código #1</td>
                                <td>Valor Peso Hum</td>
                                <td>Valor Humedad</td>
                                <td>Valor Peso Seco</td>
                            </tr>
                            <!-- Puede agregar más filas según sea necesario -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- oro -->
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tabla de Análisis Au</h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Peso Seco (Kg.)</th>
                                <th>Ley Oroan (grs./Kg. Carbón)</th>
                                <th>Ley Cliente</th>
                                <th>Dirimencia</th>
                                <th>Ley Final</th>
                                <th>Neto (Kg.)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Ejemplo de fila -->
                            <tr>
                                <td>1</td>
                                <td>Valor Peso Seco</td>
                                <td>Valor Ley Oroan</td>
                                <td>Valor Ley Cliente</td>
                                <td>Valor Dirimencia</td>
                                <td>Valor Ley Final</td>
                                <td>Valor Neto</td>
                            </tr>
                            <!-- Puede agregar más filas según sea necesario -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tabla de Análisis AG</h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Peso Seco (Kg.)</th>
                                <th>Ley Oroan (grs./Kg. Carbón)</th>
                                <th>Ley Cliente</th>
                                <th>Dirimencia</th>
                                <th>Ley Final</th>
                                <th>Neto (Kg.)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Ejemplo de fila -->
                            <tr>
                                <td>1</td>
                                <td>Valor Peso Seco</td>
                                <td>Valor Ley Oroan</td>
                                <td>Valor Ley Cliente</td>
                                <td>Valor Dirimencia</td>
                                <td>Valor Ley Final</td>
                                <td>Valor Neto</td>
                            </tr>
                            <!-- Puede agregar más filas según sea necesario -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>