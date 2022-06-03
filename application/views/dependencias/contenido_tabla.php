<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered display" style="width:100%" id="grid">
                        <thead>
                            <tr>
                                <th width="50px">ID</th>
                                <th>Dependencia</th>
                                <th>Nombre corto</th>
                                <th width="150px"> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($consulta as $value){ ?>
                            <tr>
                                <td><?= $value->iIdDependencia ?></td>
                                <td><?= $value->vDependencia ?></td>
                                <td><?= $value->vNombreCorto ?></td>
                                <td>
                                    <button type="button" title="Editar" class="btn btn-xs waves-effect waves-light btn-warning" onclick="modificar_dependencia(<?= $value->iIdDependencia ?>)"><i class="mdi mdi-border-color"></i></button>
                                    <button type="button" title="Eliminar" class="btn btn-xs waves-effect waves-light btn-danger"><i class="mdi mdi-close" onclick="confirmar('¿Esta usted seguro?',EliminarDependencia,<?= $value->iIdDependencia ?>)"></i></button>
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
            "displayStart": parseInt($('#start').val()),
            "pageLength": parseInt($('#length').val()),
            "order": [[ 0, "asc" ]]
        });
    });

    function EliminarDependencia(id){
        event.preventDefault();

        $.ajax({         
            type: "POST",
            url: "<?=base_url()?>C_dependencias/delete", //Nombre del controlador
            data: {'id' : id},

            success: function(resp) {
                 if(resp == true){
                
                 cargar('<?= base_url() ?>C_dependencias/show', '#contenedor'); //Opcion para redirigir a la tabla principal
                 alerta('Eliminado exitosamente','success');

              } else {
                alerta('Error al eliminar','success');
              }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              
            }
        });
    }
</script>

