<br><br>
<div class="card">
    <div class="card-body">
        <h1 class="card-title">ODS</h1>
        <!-- <h5 class="card-subtitle"> Administración del catálogo de fuentes de financiamiento. </h5> -->
        <br><br>
        <!-- <form onsubmit="buscarfinanciamiento(event);">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="validationTooltip02">Fuentes</label>
                    <input class="form-control" id="fuente" type="text" placeholder="Ingresar fuentes">
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <div class="button-group">
                            <button type="submit" class="btn waves-effect waves-light btn-light" style="margin-top:35px">Buscar</button>
                            <button type="button" class="btn waves-effect waves-light btn-primary" style="margin-top:35px" onclick="agregar_financiamiento()">Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form> -->
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
                                    <th>ODS</th>
                                    <th>Dependencia</th>
                                    <th>Acciones</th>
                                    <th>Presupuesto</th>
                                    <th>Presupuesto Ejercido</th>
                                    <th>Personas beneficiadas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($items as $value) { ?>
                                    <tr>
                                        <td><?= $value->vOds ?></td>
                                        <td><?= $value->vDependencia ?></td>
                                        <td><?= $value->vActividad ?></td>
                                        <td>$<?= number_format(round($value->nPresupuestoAutorizado, 2, PHP_ROUND_HALF_UP), 2, ".", ","); ?></td>
                                        <td><?= $value->iIdOds ?></td>
                                        <td><?= $value->hombres + $value->mujeres ?></td>
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
