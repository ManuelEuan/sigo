<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered display" style="width:100%" id="grid">
                        <thead>
                            <tr>
                                <th>Clave</th>
                                <th>Fuente de Financiamiento</th>
                                <th>Año</th>
                                <th width="150px"> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($consulta as $value) { ?>
                                <tr>
                                    <td><?= $value->vClave ?></td>
                                    <td><?= $value->vFinanciamiento ?></td>
                                    <td><?= $value->iAnio ?></td>
                                    <td>
                                        <button type="button" class="btn btn-xs waves-effect waves-light btn-warning" onclick="modificar_financiamiento(<?= $value->iIdFinanciamiento ?>)"><i class="mdi mdi-border-color"></i></button>
                                        <button type="button" class="btn btn-xs waves-effect waves-light btn-danger"><i class="mdi mdi-close" onclick="confirmar('¿Esta usted seguro?',EliminarFinanciamiento,<?= $value->iIdFinanciamiento ?>)"></i></button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#grid').DataTable();
    });
</script>

