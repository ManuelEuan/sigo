<style type="text/css">
    .rosa{
        color:#e61980 !important;
    }
    .soloLectura {

    }
</style>
<br><br>
<div id="header">
    <?= $header ?>
</div>

<div id="contenedor">
    <div class="card">
        <?php if($acceso > 1) { ?>
        <div class="card-body">
            <ul class="nav nav-tabs customtab" role="tablist">
                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#ingresar" role="tab"><span class="hidden-sm-up"><i class="mdi mdi-plus-circle"></i></span> <span class="hidden-xs-down">Ingresar datos</span></a> </li>
                <?php /*if($consulta->iMunicipalizacion == 1){?>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#importar" role="tab"><span class="hidden-sm-up"><i class="mdi mdi-upload"></i></span> <span class="hidden-xs-down">Importar datos</span></a> </li>  
                <?php } */?>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="ingresar" role="tabpanel">
                    <input type="hidden" id="tipoActividad" value="<?php echo($tipoActividad) ?>">
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
        <?php } ?>
        <div class="dropdown-divider"></div>
        <div id="tabtrimestres">
            <?= $contenido_trimestres ?>
        </div>
    </div>
</div>
<script>
    var accordion = [];
    accordion[1] = true;
    accordion[2] = true;
    accordion[3] = true;
    accordion[4] = true;
    accordion[5] = true;
    accordion[6] = true;
    accordion[7] = true;
    accordion[8] = true;
    accordion[9] = true;
    accordion[10] = true;
    accordion[11] = true;
    accordion[12] = true;

    function validarAcceso(){
        $(".soloLectura").each(function(){
             $(this).attr('disabled','disabled');
            //if($(this).attr("type") == 'text') $(this).attr('disabled','disabled');
            //if($(this).attr("type") == 'che') $(this).attr('disabled','disabled');
        });
    }

    function CalcularPorcentajeActividad(){
        //event.preventDefault();
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_entregables/calcular_porcentaje_avance", //Nombre del controlador
            data: {
                'id_detact': <?= $id_detact ?>
            },

            success: function(resp) {
                if (resp == true) {

                } else {
                    
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {

            }
        });
    }

    function actualizarAvance(t,mes,iddetent){
        var datos =[];
        // Obtenemos todos los valores contenidos en los <td> de la fila seleccionada
        $(t).parents("tr").find("td").each(function(){        
            //mes = $(this).parents("tr").find('#mes').val();
            municipio = $(this).parents("tr").find('#municipios').val();
            avance = $(this).parents("tr").find('#avance').val();
            monto = $(this).parents("tr").find('#monto').val();
            beneficiariosH = $(this).parents("tr").find('#bnfH').val();
            beneficiariosM = $(this).parents("tr").find('#bnfM').val();
            discapacitadosH = $(this).parents("tr").find('#discH').val();
            discapacitadosM = $(this).parents("tr").find('#discM').val();
            lenguaindijenaH = $(this).parents("tr").find('#lengindH').val();
            lenguaindijenaM = $(this).parents("tr").find('#lengindM').val();
            idavance =  $(this).parents("tr").find('#idavance').val();
            observaciones =  $(this).parents("tr").find('#vobservaciones').val();            

            datos = {
                'mes':mes,
                'municipio':municipio,
                'avance':avance,
                'monto':monto,
                'beneficiariosH':beneficiariosH,
                'beneficiariosM':beneficiariosM,
                'discapacitadosH':discapacitadosH,
                'discapacitadosM':discapacitadosM,
                'lenguaindijenaH':lenguaindijenaH,
                'lenguaindijenaM':lenguaindijenaM,
                'idavance': idavance,
                 'observaciones': observaciones
            };
        });

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_avances/actualizar_avance", //Nombre del controlador
            data: datos,

            success: function(resp) {
                if (resp == true) {
                    CalcularPorcentajeActividad();
                    muestraTotalesMes(mes);
                    mostrar_header(monto);
                    alerta('Datos modificados exitosamente', 'success');
                } else {
                    alerta('Error al modificar los datos', 'error');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {

            }
        });
    }

    function eliminarAvance(id,mes){
        event.preventDefault();

        swal({
            title: '¿Realmente desea eliminar este registro?',
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Confirmar",   
            cancelButtonText: "Cancelar",
        }).then((confirm) => {
            if(confirm.hasOwnProperty('value')){
                $.ajax({
                    type: "POST",
                    url: "<?= base_url() ?>C_avances/eliminar_avance", //Nombre del controlador
                    data: 'id='+id,
                    success: function(resp) {
                        if (resp == true) {
                            alerta('El registro ha sido eliminado', 'success');
                            mostrar_header(monto);
                            refrescarAvances(mes);
                            mostrarRegistrosMes(mes);
                            CalcularPorcentajeActividad();

                        } else {
                            alerta('Ha ocurrido un error.', 'error');
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                    }
                });
            }       
        });
    }

    function seleccionarTodos(mes){
        var checked = $("#selAll"+mes).is(':checked');
        $('.chk'+mes).each(function(){
            $(this).prop('checked',checked);
        });

        contarSeleccionados(mes);    
    }

    function contarSeleccionados(mes){
        var seleccionados = 0;
        $('.chk'+mes).each(function(){
            if(this.checked) seleccionados++; 
        });

        $("#e"+mes).text(seleccionados);
    }

    function eliminarSeleccionados(mes){
        var ids = new Array();
        var elementos = parseInt($("#e"+mes).text());

        if(elementos > 0){
            $('.chk'+mes).each(function(){
                if($(this).is(':checked')) ids.push($(this).val());
            });

            swal({
                title: '¿Realmente desea eliminar los registros seleccionados?',
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Confirmar",   
                cancelButtonText: "Cancelar",
            }).then((confirm) => {
                if(confirm.hasOwnProperty('value')){
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url() ?>C_avances/eliminar_avances", //Nombre del controlador
                        data: {'ids':ids},
                        success: function(resp) {
                            if (resp == true) {
                                alerta('El registro ha sido eliminado', 'success');
                                mostrar_header(monto);
                                refrescarAvances(mes);
                                mostrarRegistrosMes(mes);
                                CalcularPorcentajeActividad();

                            } else {
                                alerta('Ha ocurrido un error.', 'error');
                            }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                        }
                    });
                }       
            });
        } else {
            alerta('Debe seleccionar al menos un registro para continuar', 'warning');
        }
    }

    function revisarSeleccionados(mes,rev){
        var ids = new Array();
        var elementos = parseInt($("#e"+mes).text());
        var texto = (rev == 1) ? '¿Realmente desea aprobar los registros seleccionados?':'¿Realmente desea rechazar los registros seleccionados?';
        if(elementos > 0){
            $('.chk'+mes).each(function(){
                if($(this).is(':checked')) ids.push($(this).val());
            });

            swal({
                title: texto,
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Confirmar",   
                cancelButtonText: "Cancelar",
            }).then((confirm) => {
                if(confirm.hasOwnProperty('value')){
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url() ?>C_avances/revisar_avances", //Nombre del controlador
                        data: {'ids':ids, 'rev':rev},
                        success: function(resp) {
                            if (resp == true) {
                                alerta('Los cambios han sido guardados', 'success');
                                mostrar_header(monto);
                                refrescarAvances(mes);
                                mostrarRegistrosMes(mes);
                                CalcularPorcentajeActividad();
                            } else {
                                alerta('Ha ocurrido un error.', 'error');
                            }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                        }
                    });
                }       
            });
        } else {
            alerta('Debe seleccionar al menos un registro para continuar', 'warning');
        }
    }

    function muestraTotalesMes(mes){
        var datos = 'mes='+mes+'&id_detent=<?=$id_detent?>';
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_avances/muestra_totales_mes", //Nombre del controlador
            data: datos,
            success: function(resp) {
                $("#totalesMes"+mes).html(resp);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {

            }
        });
    }

    function mostrarRegistrosMes(mes){
        var datos = 'mes='+mes+'&id_detent=<?=$id_detent?>';
        cargar('<?= base_url() ?>C_avances/mostrar_registros_mes', '#divRegistros'+mes,'POST',datos);
    }

    function motrarAvances(mes){
        if(accordion[parseInt(mes)]){
            var datos = 'mes='+mes+'&id_detent=<?=$id_detent?>';
            cargar('<?= base_url() ?>C_avances/mostrar_avances', '#divAvances'+mes,'POST',datos);
            accordion[parseInt(mes)] = false;
        }
    }

    function refrescarAvances(mes){
        var datos = 'mes='+mes+'&id_detent=<?=$id_detent?>';
        cargar('<?= base_url() ?>C_avances/mostrar_avances', '#divAvances'+mes,'POST',datos);
    }

    function mostrar_header() {
        cargar('<?= base_url() ?>C_avances/showheader', '#header','POST',"id_detent=<?=$id_detent?>");
    }
</script>




