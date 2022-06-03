<style>
    .boton {
        background-color: #B274E8;
        color: #fff;
    }

    .boton:hover {
        background-color: #C397EA;
    }

    .boton_desc {
        background-color: #62DDBA;
        color: #fff;
    }

    .boton_desc:hover {
        background-color: #90E4CC;
    }

    .boton_InfTex {
        background-color: #7E70E9;
        color: #fff;
    }

    .boton_InfTex:hover {
        background-color: #A69DED;
    }

    .boton_edit {
        background-color: #ffb300;
        color: #fff;
    }

    .boton_edit:hover {
        background-color: #ffe54c;
    }

    .boton_eliminar {
        background-color: #f44336;
        color: #fff;
    }

    .boton_eliminar:hover {
        background-color: #ff7961;
    }
</style>

<style>
    .progress-c {
        width: 110px;
        height: 110px;
        background: none;
        position: relative;
    }

    .progress-c::after {
        content: "";
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 6px solid #eee;
        position: absolute;
        top: 0;
        left: 0;
    }

    .progress-c>span {
        width: 50%;
        height: 100%;
        overflow: hidden;
        position: absolute;
        top: 0;
        z-index: 1;
    }

    .progress-c .progress-c-left {
        left: 0;
    }

    .progress-c .progress-c-bar {
        width: 100%;
        height: 100%;
        background: none;
        border-width: 6px;
        border-style: solid;
        position: absolute;
        top: 0;
    }

    .progress-c .progress-c-left .progress-c-bar {
        left: 100%;
        border-top-right-radius: 100px;
        border-bottom-right-radius: 100px;
        border-left: 0;
        -webkit-transform-origin: center left;
        transform-origin: center left;
    }

    .progress-c .progress-c-right {
        right: 0;
    }

    .progress-c .progress-c-right .progress-c-bar {
        left: -100%;
        border-top-left-radius: 100px;
        border-bottom-left-radius: 100px;
        border-right: 0;
        -webkit-transform-origin: center right;
        transform-origin: center right;
    }

    .progress-c .progress-c-value {
        position: absolute;
        top: 0;
        left: 0;
    }

    /*
*
* ==========================================
* FOR DEMO PURPOSE
* ==========================================
*
*/

    body {
        background: #ff7e5f;
        background: -webkit-linear-gradient(to right, #ff7e5f, #feb47b);
        background: linear-gradient(to right, #ff7e5f, #feb47b);
        min-height: 100vh;
    }

    .rounded-lg {
        border-radius: 1rem;
    }

    .text-gray {
        color: #aaa;
    }

    div.h4 {
        line-height: 0rem;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered display" style="width:100%" id="grid">
                        <thead>
                            <tr>
                                <th width="100px">Avance</th>
                                <?php if($all_dep > 0) echo '<th width="50px">Dependencia</th>'; ?>
                                <th>Actividad</th>
                                <th width="30px">Año</th>
                                <th width="180px">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($actividad as $value) { ?>
                                <?php
                                if($value->vObjetivo != NULL){
                                    $disabled = '';
                                }else{
                                    $disabled = 'disabled';
                                }
                                $disabled = '';
                                ?>
                                <tr>
                                    <td class="cifraAvance" id="<?=$value->iIdDetalleActividad?>">
                                        <?php
                                            if ($value->nAvance >= 0 && $value->nAvance <= 25.9) { ?>
                                            <div class="progress-c mx-auto" data-value='<?= $value->nAvance ?>'>
                                                <span class="progress-c-left">
                                                    <span class="progress-c-bar border-danger"></span>
                                                </span>
                                                <span class="progress-c-right">
                                                    <span class="progress-c-bar border-danger"></span>
                                                </span>
                                                <div class="progress-c-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                                    <div class="h3 font-weight-bold"><?= $value->nAvance ?><sup class="small">%</sup></div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php
                                            if ($value->nAvance >= 26 && $value->nAvance <= 70.9) { ?>
                                            <div class="progress-c mx-auto" data-value='<?= $value->nAvance ?>'>
                                                <span class="progress-c-left">
                                                    <span class="progress-c-bar border-warning"></span>
                                                </span>
                                                <span class="progress-c-right">
                                                    <span class="progress-c-bar border-warning"></span>
                                                </span>
                                                <div class="progress-c-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                                    <div class="h3 font-weight-bold"><?= $value->nAvance ?><sup class="small">%</sup></div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php
                                            if ($value->nAvance >= 71 && $value->nAvance <= 100) { ?>
                                            <div class="progress-c mx-auto" data-value='<?= $value->nAvance ?>'>
                                                <span class="progress-c-left">
                                                    <span class="progress-c-bar border-success"></span>
                                                </span>
                                                <span class="progress-c-right">
                                                    <span class="progress-c-bar border-success"></span>
                                                </span>
                                                <div class="progress-c-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                                    <div class="h3 font-weight-bold"><?= $value->nAvance ?><sup class="small">%</sup></div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </td>
                                    <?php if($all_dep > 0) echo '<td>'.$value->vDependencia.'</td>'; ?>
                                    <td><?=$ods[$value->iIdActividad].$value->vActividad ?></td>
                                    <td><?= $value->iAnio ?></td>
                                    <td>
                                        <?php 
                                            $icon_class = ($acceso > 1) ? 'mdi mdi-border-color':'fas fa-search'; 
                                            $title = ($acceso > 1) ? 'Editar':'Consultar'; 
                                        ?>
                                        <button title="<?=$title?>" type="button" class="btn btn-xs waves-effect waves-light boton_edit" onclick="modificarAct(<?= $value->iIdDetalleActividad ?>)"><i class="<?=$icon_class?>"></i></button>
                                        <?php if($acceso > 1){ ?>
                                        <button title="Eliminar" type="button" class="btn btn-xs waves-effect waves-light boton_eliminar " onclick="confirmar('¿Está seguro de eliminar?', eliminarActividad,<?= $value->iIdDetalleActividad ?>);"><i class="mdi mdi-close"></i></button>
                                        <?php } ?>
                                        <button title="Entregables" type="button" class="btn btn-xs waves-effect waves-light boton" onclick="abrirEntregables(<?= $value->iIdDetalleActividad ?>)"><i class="icon-badge"></i></button>
                                        <button title="Texto para el informe" type="button" class="btn btn-xs waves-effect waves-light boton_InfTex" onclick="abrirCapturaTxt(<?= $value->iIdDetalleActividad ?>)"><i class="icon-book-open"></i></button>
                                        <button title="Descargar ficha" <?= $disabled ?> type="button" class="btn btn-xs waves-effect waves-light boton_desc" onclick="FichaActividad(<?= $value->iIdDetalleActividad ?>)"><i class="mdi mdi-download"></i></button>
                                        <?php if($p_clonar > 0){ ?>
                                             <button type="button" class="btn btn-xs waves-effect waves-light boton_edit" onclick="openModalCloneAct(<?= $value->iIdDetalleActividad ?>);"><i class="far fa-copy"></i></button>
                                        <?php } ?>
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
<script src="<?= base_url() ?>public/assets/extra-libs/knob/jquery.knob.min.js"></script>
<script>
    $(function() {
        //$('[data-plugin="knob"]').knob();
        $(".dial").knob();
    });

    $(function() {

        $(".progress-c").each(function() {

            var value = $(this).attr('data-value');
            var left = $(this).find('.progress-c-left .progress-c-bar');
            var right = $(this).find('.progress-c-right .progress-c-bar');

            if (value > 0) {
                if (value <= 50) {
                    right.css('transform', 'rotate(' + percentageToDegrees(value) + 'deg)')
                } else {
                    right.css('transform', 'rotate(180deg)')
                    left.css('transform', 'rotate(' + percentageToDegrees(value - 50) + 'deg)')
                }
            }

        })

        function percentageToDegrees(percentage) {

            return percentage / 100 * 360

        }

    });

    $(document).ready(function() {
        table = $('#grid').DataTable({
            "displayStart":parseInt($('#start').val()),
            "pageLength": parseInt($('#length').val()),
            "order": [[ 2, "asc" ]]
        });
        //actualizarAvances();
    });

    function eliminarActividad(key) {
        //  Guardamos la página actual
        $("#start").val(table.page.info().start);
        $("#length").val(table.page.len());
        //-------------------------------

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_pat/eliminarActividad",
            data: {
                'key': key
            },
            //contentType: 'json',
            success: function(resp) {
                if (resp == true) {
                    filtrar();
                    alerta('Eliminado exitosamente', 'success');
                } else {
                    alerta('Error al eliminar', 'error');
                }
            },
            error: function(XMLHHttRequest, textStatus, errorThrown) {

            }
        });
    }

    function actualizarAvances(){
        $(".cifraAvance").each(function(){
            console.log(this.id);
            $.post( "<?=base_url()?>index.php/C_pat/avance", {id:this.id}, function( data ) {
              $("#"+this.id).text(data);
            });
            
        });
    }
</script>