<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered display" style="width:100%" id="grid">
                        <thead>
                            <tr>
                                <th>Rol</th>                       
                                <th width="160px"> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($consulta as $value){ ?>
                            <tr>
                                <td><?= $value->vRol ?></td>
                                <td>
                                    <button type="button" class="btn btn-xs waves-effect waves-light btn-warning" data-toggle="tooltip" data-placement="top" title="Editar" onclick="modificar_rol(<?= $value->iIdRol ?>)"><i class="mdi mdi-border-color"></i></button>
                                    <button type="button" class="btn btn-xs waves-effect waves-light btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar" onclick="confirmar('¿Esta usted seguro?',EliminarRol,<?= $value->iIdRol ?>)"><i class="mdi mdi-close"></i></button>
                                    <button type="button" class="btn btn-xs waves-effect waves-light btn-success" data-toggle="tooltip" data-placement="top" title="Editar permisos" onclick="asignar_permisos(<?= $value->iIdRol ?>)"><i class="mdi mdi-key-variant"></i></button>                  
                                </td>
                             </tr> 
                             <?php }?>
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
<script>
    function EliminarRol(id) {
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_roles/delete", //Nombre del controlador
            data: {
                'id': id
            },

            success: function(resp) {
                if (resp == true) {

                    regresar();
                    alerta('Eliminado exitosamente', 'success');

                } else {
                    alerta('Error al eliminar', 'error');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {

            }
        });
    }
</script>