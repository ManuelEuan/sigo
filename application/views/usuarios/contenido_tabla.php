<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered display" style="width:100%" id="grid">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Rol</th>
                                <th>Nombre completo</th>
                                <th>Usuario</th>                               
                                <th>Dependencia</th>
                                <!--<th>Correo institucional</th>
                                <th>Telefono</th>-->
                                <th width="130px"> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($consulta as $value){ ?>
                            <tr>
                                <td><?= $value->iIdUsuario; ?></td>
                                <td><?= $value->vRol ?></td>
                                <td><?= $value->vNombre." ".$value->vPrimerApellido." ".$value->vSegundoApellido ?></td>
                                <td><?= $value->vUsuario ?></td>                                
                                <td><?= $value->vDependencia ?></td>
                                <!--<td><?= $value->vCorreo ?></td>
                                <td><?= $value->vTelefono ?></td>-->
                                <td align="center">
                                    <button type="button" class="btn btn-xs waves-effect waves-light btn-warning" data-toggle="tooltip" data-placement="top" title="Editar" onclick="modificar_usuario(<?= $value->iIdUsuario ?>)"><i class="mdi mdi-border-color"></i></button>
                                    <?php
                                    if($value->iIdUsuario != $_SESSION[PREFIJO.'_idusuario']){ ?>
                                        <button type="button" class="btn btn-xs waves-effect waves-light btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar" onclick="confirmar('¿Esta usted seguro?',EliminarUsuario,<?= $value->iIdUsuario ?>)"><i class="mdi mdi-close"></i></button>
                                    <?php } ?>                    
                                    <button type="button" class="btn btn-xs waves-effect waves-light btn-info" data-toggle="tooltip" data-placement="top" title="Cambiar contraseña" onclick="modificar_password(<?= $value->iIdUsuario ?>)"><i class="mdi mdi-key-variant"></i></button>
                                    <button type="button" class="btn btn-xs waves-effect waves-light btn-success" data-toggle="tooltip" data-placement="top" title="Editar permisos" onclick="asignar_permisos(<?= $value->iIdUsuario ?>)"><i class="mdi mdi-account-key"></i></button>
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
        table = $('#grid').DataTable({
            "displayStart":parseInt($('#start').val()),
            "pageLength": parseInt($('#length').val()),
            "order": [[ 0, "asc" ]]
        });
    });

    function EliminarUsuario(id) {
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_usuarios/delete", //Nombre del controlador
            data: {
                'id': id
            },
            success: function(resp) {
                if (resp == true) {
                    buscarUsuario(event);
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