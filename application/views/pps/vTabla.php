<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered display" style="width:100%" id="grid">
                        <thead>
                            <tr>
                                <th width="100px;">Id</th>
                                <th>Número</th>
                                <th>Programa presupuestario</th>
                                <th width="150px">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($consulta as $value) { ?>
                                <tr>
                                    <td><?= $value->iIdProgramaPresupuestario ?></td>
                                    <td><?= $value->iNumero ?></td>
                                    <td><?= $value->vProgramaPresupuestario ?></td>
                                    <td>
                                        <button title="Editar" type="button" class="btn btn-xs waves-effect waves-light btn-warning " onclick="capturar(<?= $value->iIdProgramaPresupuestario ?>)"><i class="mdi mdi-border-color"></i></button>
                                        <button title="Eliminar" type="button" class="btn btn-xs waves-effect waves-light btn-danger " onclick="confirmar('¿Está seguro de eliminar?', eliminar,<?= $value->iIdProgramaPresupuestario ?>);"><i class="mdi mdi-close"></i></button>
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
<div id="holi"></div>

<script>
    $(document).ready(function() {
        tabla = $('#grid').DataTable({
            "displayStart":parseInt($('#start').val()),
            "pageLength": parseInt($('#length').val()),
            "order": [[ 0, "asc" ]]
        });
    });
</script>