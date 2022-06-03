<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered display" style="width:100%" id="grid">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Permiso</th>
                                <th>Tipo</th>
                                <th>Estatus</th>
                                <th width="130px"> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php                            
                            foreach($result as $row)
                            {
                                $tipo = ($row->iTipo == 1) ? 'Módulo':'Acción'; 
                                $estatus = ($row->iActivo > 0) ? '<span class="text-success">Activo</span>':'<span class="text-danger">Inactivo</span>'; ?>
                            <tr>
                                <td><?= $row->iIdPermiso; ?></td>
                                <td><?= $row->vPermiso ?></td>
                                <td><?= $tipo ?></td>
                                <td><?= $estatus ?></td>
                                <td align="center">
                                    <button type="button" class="btn btn-xs waves-effect waves-light btn-warning" data-toggle="tooltip" data-placement="top" title="Editar" onclick="capturar(<?= $row->iIdPermiso ?>)"><i class="mdi mdi-border-color"></i></button>
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
</script>