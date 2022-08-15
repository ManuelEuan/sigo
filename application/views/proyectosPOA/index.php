<div class="row" id="divbusqueda">
        <div class="col-md-12">
            <div class="card card-body">
                <h1 class="card-title">Picasso</h1>
                <hr class="m-t-0">
                <div class="form-body">
                    <div class="card-body">
                        <h4 class="card-title">Filtrar por:</h4>
                        <form class="r-separator" name="frmbusqueda" id="frmbusqueda" onsubmit="search(event);">
                            <input type="hidden" id="start" value="0">
                            <input type="hidden" id="length" value="10">
                            <div class="row">
                                <div class="col-2">
                                    <select class="form-control" name="filtro" id="filtro">
                                        <option value="todos">Todos</option>
                                        <option value="noguardado">No asignados</option>
                                    </select>
                                </div>
                            </div>
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
                                            <button onclick="cargar('//localhost/Trabajo/SIGO-QRO/index.php/C_logs','#contenido');">Logs</button>
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
                                <th>Numero de Proyecto</th>
                                <th>Aprobado</th>
                                <th>Pagado</th>
                                <th>Dependencia</th>
                                <th>Nombre Proyecto</th>
                                <th>Fecha Aprobacion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($proyectos as $p){ ?>
                                <tr>
                                    
                                    <td><?= $p->numeroProyecto?></td>
                                    <td><?= $p->aprobado ?></td>
                                    <td><?= $p->pagado ?></td>
                                    <td><?= $p->dependenciaEjecutora ?></td>
                                    <td><?= $p->nombreProyecto ?></td>
                                    <td><?= $p->fechaAprobacion ?></td>
                                    
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

        $( "#filtro" ).change(function() {
            var valor = $( this ).val();
            console.log(valor)
            listar(valor)
        });

        //actualizarAvances();
    });

    function listar(valor)
    {

        tabla=$('#grid').dataTable(
        {
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
            "ajax":
                    {
                        url: '<?= base_url() ?>C_proyectosPOA/filtrar?valor='+valor,
                        type : "get",
                        dataType : "json",						
                        error: function(e){
                            console.log(e.responseText);	
                        }
                    },
            "bDestroy": true,
            "iDisplayLength": 5,//Paginación
            "order": [[ 2, "asc" ]]//Ordenar (columna,orden)
        }).DataTable();
    }
</script>