<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered display" style="width:100%" id="grid">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Edad</th>
                                <th>Sexo</th>
                                <th>Dirección</th>
                                <th>Municipio</th>
                                <th>Problema</th>
                                <th width="150px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($consulta as $value) { ?>
                                <tr>
                                    <td><?= $value->iIdRegistro ?></td>
                                    <td><?= $value->vNombre.' '.$value->vPrimerApellido.' '.$value->vSegundoApellido ?></td>
                                    <td><?= $value->iEdad ?></td>
                                    <td><?= $value->vSexo ?></td>
                                    <td><?= $value->vCalleNum.' '.$value->vColonia.' '.$value->vCP;?></td>
                                    <td><?= $value->vMunicipio ?></td>
                                    <td><?= $value->vMotivoCC ?></td>
                                    <td>
                                        <button type="button" class="btn btn-xs waves-effect waves-light btn-warning" onclick="capturar(<?= $value->iIdRegistro ?>)"><i class="mdi mdi-border-color"></i></button>
                                        <button type="button" class="btn btn-xs waves-effect waves-light btn-danger"><i class="mdi mdi-close" onclick="confirmar('¿Esta usted seguro?',eliminar,<?= $value->iIdRegistro ?>)"></i></button>
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
        tabla = $('#grid').DataTable({
            "displayStart":parseInt($('#start').val()),
            "pageLength": parseInt($('#length').val()),
            "order": [[ 0, "asc" ]]
        });
    });
</script>

