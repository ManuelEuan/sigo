<div class="card">    
    <div class="card-body">
        <div class="card-title"><h4>Listado de indicadores</h4></div>
        <br>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs customtab" role="tablist">
            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#entregable" role="tab"><span class="hidden-sm-up"><i class="mdi mdi-playlist-check"></i></span> <span class="hidden-xs-down">Indicadores</span></a> </li>
            <!--<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#alineacion" role="tab"><span class="hidden-sm-up"><i class="mdi mdi-link-variant"></i></span> <span class="hidden-xs-down">Alineación a compromisos</span></a> </li>  -->
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="entregable" role="tabpanel">
                <div class="p-20">
                    <?php
                    include_once('tabla_entregables.php');
                    ?>
                </div>
            </div>
            <div class="tab-pane" id="alineacion" role="tabpanel">
                <div class="p-20">
                    <?php
                    include_once('contenido_alineacion.php');
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
