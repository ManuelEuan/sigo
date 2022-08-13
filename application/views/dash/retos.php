<br><br>
<div class="card">
    <div class="card-body">
        <h1 class="card-title">Retos</h1>
    </div>
</div>

<div id="contenedor">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered display" style="width:100%" id="grid">
                            <thead>
                                <tr>
                                    <th>Reto</th>
                                    <th>Eje</th>
                                    <th>Fuente</th>
                                    <th>Año/Periodo</th>
                                    <th>Última Medición</th>
                                    <th>Año/Periodo</th>
                                    <th>Meta</th>
                                    <th>Avance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($ods as $value) { ?>
                                    <tr>
                                        <td><?= $value->vOds ?></td>
                                        <td><?= $value->vDependencia ?></td>
                                        <td><?= $value->vActividad ?></td>
                                        <td>$<?= number_format(round($value->nPresupuestoAutorizado, 2, PHP_ROUND_HALF_UP), 2, ".", ","); ?></td>
                                        <td><?= $value->iIdOds ?></td>
                                        <td><?= $value->beneficiarios ?></td>
                                        <td><?= $value->beneficiarios ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    /* $(document).ready(function() {
        $('#grid').DataTable();
    }); */
</script>
