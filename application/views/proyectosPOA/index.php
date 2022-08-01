<div class="row" id="divbusqueda">
        <div class="col-md-12">
            <div class="card card-body">
                <h1 class="card-title">Programa Operativo Anual</h1>
                <hr class="m-t-0">
                <div class="form-body">
                    <div class="card-body">
                        <h4 class="card-title">Filtrar por:</h4>
                        <form class="r-separator" name="frmbusqueda" id="frmbusqueda" onsubmit="search(event);">
                            <input type="hidden" id="start" value="0">
                            <input type="hidden" id="length" value="10">
                            <div class="row">
                                <?php 
                                if(isset($ejes))
                                {
                                    echo '<div class="col">
                                        <div class="form-group">
                                            <label class="control-label">Eje Rector</label>
                                            <select type="text" name="search_eje" id="search_eje" class="form-control" onChange="cargarOptions(\'dependencias\',this);" >
                                                <option value="0">--Todos--</option>'.$ejes.'
                                            </select>
                                        </div>
                                    </div>';
                                }
                                else 
                                {
                                    echo '<input type="hidden" name="search_eje" id="search_eje" value="'.$_SESSION[PREFIJO.'_ideje'].'" >';
                                } 

                                if(isset($dependencias))
                                {
                                    echo '<div class="col">
                                        <div class="form-group">
                                            <label class="control-label">Dependencia responsable</label>
                                            <select type="text" name="search_dependencia" id="search_dependencia" class="form-control" onChange="search(event);" >
                                                <option value="0">--Todos--</option>'.$dependencias.'
                                            </select>
                                        </div>
                                    </div>';
                                } 
                                else 
                                {
                                    echo '<input type="hidden" name="search_dependencia" id="search_dependencia" value="'.$_SESSION[PREFIJO.'_iddependencia'].'" >';
                                }
                                ?>
                                <div class="col">
                                    <div class="form-group">
                                    <!-- <label class="control-label">COVID</label>-->
                                        <input type="hidden" class="form-control " maxlength="255" id="covid" name="covid" value="">
                                        <!--<select class="form-control" name="covid" id="covid">
                                            <option value="">--Todas--</option>
                                            <option value="1">Covid</option>
                                            <option value="0">Sin covid</option>
                                        </select>-->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="custom-control custom-checkbox mr-sm-2 m-b-15" style="margin-top:24px;">
                                        <!--<input type="checkbox" class="custom-control-input" name="newAvances" id="newAvances" value="1">-->

                                        <input type="hidden" class="form-control input-lectura" maxlength="255" id="newAvances" name="newAvances" value="1">

                                    <!--  <label class="custom-control-label" for="newAvances">Actividades con <br>avances por revisar</label>-->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <div class="form-group">
                                        <label class="control-label">Año</label>
                                        <input type="text" name="anio" id="anio" class="form-control form-control-danger" placeholder="" value="<?=$year?>" onkeypress="solonumeros(event);" maxlength="4">
                                    </div>
                                </div>
                                <div class="col-2">
                                <div class="form-group">
                                        <label class="control-label">Mes</label>
                                        <select class="form-control" name="mes" id="mes">
                                            <option value="0">--Todos--</option>
                                            <option value="1">Enero</option>
                                            <option value="2">Febrero</option>
                                            <option value="3">Marzo</option>
                                            <option value="4">Abril</option>
                                            <option value="5">Mayo</option>
                                            <option value="6">Junio</option>
                                            <option value="7">Julio</option>
                                            <option value="8">Agosto</option>
                                            <option value="9">Septiembre</option>
                                            <option value="10">Octubre</option>
                                            <option value="11">Noviembre</option>
                                            <option value="12">Diciembre</option>
                                        </select>
                                    </div>
                            </div>
                                <div class="col-7">
                                    <div class="form-group">
                                        <label class="control-label">Nombre de la acción</label>
                                        <!--<input type="text" name="keyword" id="keyword" class="form-control" placeholder="">-->
                                        <div class="input-group mb-3">
                                            <input type="text" name="keyword" id="keyword" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-info" type="button"><i class="fas fa-search"></i>&nbsp;Buscar</button>
                                            </div>
                                        </div>

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
                                        <button type="button" class="btn waves-effect waves-light btn-outline-info" style="margin-top:30px" onclick="cargar('//localhost/Trabajo/SIGO-QRO/index.php/C_proyectosPOA','#contenido');">
                                            <i class="fa-solid fa-arrows-rotate"></i>
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
                                <th>Numero de Proeycto</th>
                                <th>Aprobado</th>
                                <th>Pagado corto</th>
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
        //actualizarAvances();
    });
</script>