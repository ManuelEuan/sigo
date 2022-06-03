<div class="card">
    <div class="card-body <?= $acceso ?>">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs customtab" role="tablist">
            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#ingresar" role="tab"><span class="hidden-sm-up"><i class="mdi mdi-plus-circle"></i></span> <span class="hidden-xs-down">Ingresar datos</span></a> </li>
            <?php if($consulta->iMunicipalizacion == 1){?>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#importar" role="tab"><span class="hidden-sm-up"><i class="mdi mdi-upload"></i></span> <span class="hidden-xs-down">Importar datos</span></a> </li>  
            <?php } ?>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="ingresar" role="tabpanel">
                <div class="p-20">
                    <?php
                    include_once('ingresar_datos.php');
                    ?>
                </div>
            </div>
            <div class="tab-pane" id="importar" role="tabpanel">
                <div class="p-20">
                    <?php
                    include_once('importar_datos.php');
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="dropdown-divider"></div>
    <div class="card" id="tabtrimestres">
        <?= $contenido_trimestres ?>
    </div>
</div>

<script>
    var width = 46;
    var widthTh;
    $(document).ready(function() {
        $('.dng').hide();
        $('.lect').hide();
        $('.lectesc').show();
    });
</script>
