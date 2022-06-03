<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered display" style="width:100%" id="grid">
                        <thead>
                            <tr>
                                <th>Unidades de Medida</th>
                                <th width="150px">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($consulta as $value) { ?>
                                <tr>
                                    <td><?= $value->vUnidadMedida ?></td>
                                    <td>
                                        <button type="button" class="btn btn-xs waves-effect waves-light btn-warning " onclick="modificarUM(<?= $value->iIdUnidadMedida ?>)"><i class="mdi mdi-border-color"></i></button>
                                        <button type="button" class="btn btn-xs waves-effect waves-light btn-danger " onclick="confirmar('¿Está seguro de eliminar?', eliminarUM,<?= $value->iIdUnidadMedida ?>);"><i class="mdi mdi-close"></i></button>
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
        $('#grid').DataTable();
    });

    function eliminarUM(key) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_unidadesmedida/eliminar",
            data: {
                'key': key
            },
            //contentType: 'json',
            success: function(resp) {
                if (resp == true) {
                    filter2();
                    alerta('Eliminado exitosamente', 'success');
                } else {
                    alerta('Error al eliminar', 'error');
                }
            },
            error: function(XMLHHttRequest, textStatus, errorThrown) {

            }
        });
    }
</script>