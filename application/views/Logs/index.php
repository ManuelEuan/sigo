<div class="row" id="divbusqueda">
        <div class="col-md-12">
            <div class="card card-body">
                <h1 class="card-title">Logs</h1>
                <hr class="m-t-0">
                <div class="form-body">
                    <div class="card-body">
                        <form class="r-separator" name="frmbusqueda" id="frmbusqueda" onsubmit="search(event);">
                            <input type="hidden" id="start" value="0">
                            <input type="hidden" id="length" value="10">
                                <div class="col">
                                    <div class="form-group">
                                        <!--<button type="submit" class="btn waves-effect waves-light btn-light" style="margin-top:30px" id="btn_buscar">Buscar</button>-->
                                        <?php if($acceso > 1) { ?>
                                        <button type="button" class="btn waves-effect waves-light btn-primary" style="margin-top:30px" onclick="agregarAct();">+ Nueva</button>
                                        <?php } 
                                        if($p_clonar > 0){ ?>
                                            <button type="button" class="btn btn-warning" data-toggle="modal" style="margin-top:30px" data-target="#clonarModal" data-whatever="@getbootstrap"><i class="far fa-copy"></i>&nbsp;Clonar</button>
                                        <?php } ?>

                                        <button type="button" class="btn waves-effect waves-light btn-outline-info" style="margin-top:30px" onclick="updatePOAS();">
                                            <i class="fa-solid fa-arrows-rotate"></i>&nbsp;Sincronizar con Picaso
                                        </button>
                                        <button type="button" class="btn waves-effect waves-light btn-outline-info" style="margin-top:30px" onclick="actualizarNuevos();">
                                            <i class="fa-solid fa-arrows-rotate"></i>&nbsp;Alineación con Picaso 
                                        </button>
                                    
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered display" style="width:100%" id="grid">
                        <thead>
                            <tr>
                                <th>Tipo Cambio</th>
                                <th>Antes</th>
                                <th>Despues</th>
                                <th>Fecha</th>
                                <th>Aprobado</th>
                                <th>idUsuario</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($logs as $p){ ?>
                                <tr>
                                    
                                    <td><?= $p->iTipoCambio ?></td>
                                    <td><?= $p->iAntesCambio ?></td>
                                    <td><?= $p->iDespuesCambio ?></td>
                                    <td><?= $p->iFechaCambio ?></td>
                                    <td><?= $p->iAprovacion ?></td>
                                    <td><?= $p->iIdUsuario ?></td>
                                    <td>
                                        <select class="form-control" name="" id="">
                                            <option value="">seleccione</option>
                                            <option value="<?= $p->iIdLog ?>">Aprobar</option>
                                        </select>
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
        table = $('#grid').DataTable({
            "displayStart":parseInt($('#start').val()),
            "pageLength": parseInt($('#length').val()),
            "order": [[ 2, "asc" ]]
        });

    });
</script>