<style>
    .boton_eliminar {
        background-color: #f44336;
        color: #fff;
    }

    .boton_eliminar:hover {
        background-color: #ff7961;
    }
</style>

<?php
if ($consulta->vObjetivo != NULL && $consulta->vDescripcion != NULL) {
    $requerido = '';
} else {
    $requerido = 'required';
}

?>
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                </div>
                <div class="col-md-2 text-right">
                    <button title="Ir a listado del PAT" class="btn waves-effect waves-light btn-outline-info" type="submit" onclick="back()"><i class="mdi mdi-arrow-left"></i>Regresar</button>
                </div>
            </div>
            
            <form  id="myForm" class="needs-validation was-validated" onsubmit="guardarDetalles(this,event);">
                <div class="form-row">
                    <legend>Datos generales</legend>
                    <div class="col-md-10 mb-10">
                        <label for="validationCustom04">Nombre de la acción</label>
                        <input class="form-control input-lectura" id="validationCustom04" name="NombAct" required type="text" placeholder="" value="<?=htmlspecialchars($consulta->vActividad)?>">
                        <input id="idAct" name="idAct" type="hidden" value="<?= $consulta->iIdActividad ?>">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="validationCustom04">Año</label>
                        <input class="form-control input-number" id="validationCustom04" name="annio" required type="text" placeholder="" maxlength="4" value="<?= $consulta->iAnio ?>">
                        <input id="id" name="id" type="hidden" value="<?= $consulta->iIdDetalleActividad ?>">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>

                <!--<div class="form-row">
                    <div class="col-md-12 mb-2">
                        <label for="validationCustom04">Nombre para la tabla del anexo</label>-->
                        <hidden class="form-control input-lectura"  name="vNombreActividad" type="text" placeholder="" value="<?=htmlspecialchars($consulta->vNombreActividad)?>">
                   <!-- </div>
                </div>-->

                <div class="form-row">
                    <!--<div class="col-md-6 mb-6">-->
                       <!-- <label for="objGeneral">Objetivo General</label>-->
                       <!-- <textarea class="form-control input-lectura" id="objGeneral" name="objGeneral" aria-invalid="false" required placeholder="" cols="40" rows="5" style=""><?=htmlspecialchars($consulta->vObjetivo)?></textarea>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                        <div class="valid-feedback"> </div>-->
                   <!-- </div>-->
                    <div class="col-md-12 mb-2">
                        <input type="hidden" class="form-control input-lectura" maxlength="255" id="objGeneral" name="objGeneral" value=".">
                       
                        <label for="descripcion">Descripción</label>
                        
                        <textarea class="form-control input-lectura" id="descripcion" name="descripcion" aria-invalid="false" required placeholder="" cols="40" rows="5" style=""><?=htmlspecialchars($consulta->vDescripcion)?></textarea>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                        <div class="valid-feedback"> </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-2 mb-2">
                        <label for="checkProyectoPrioritario">Proyecto Prioritario </label>
                        <input type="checkbox" id="checkProyectoPrioritario" name="checkProyectoPrioritario" value="Si_ProyectoPrioritario">
                    </div>
                    <div class="col-md-10">
                        <select class="custom-select select-lectura" name="selectProyectoPrioritario" id="selectProyectoPrioritario">
                            <option value="">--Seleccione--</option>
                            <?php foreach($proyectoPrioritario as $p){?>
                            <option value="<?= $p->iIdProyectoPrioritario?>"><?= $p->vProyectoPrioritario ?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6 mb-6">
                        <label for="validationCustom04">Fecha de inicio</label>
                        <input type="date" class="form-control input-lectura" id="fINICIO" name="fINICIO" required value="<?= $consulta->dInicio ?>">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-6 mb-6">
                        <label for="validationCustom04">Fecha fin</label>
                        <input type="date" class="form-control input-lectura" id="fFIN" name="fFIN" required value="<?= $consulta->dFin ?>">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>
                <?php if(isset($ejes) && isset($dependencias)){ ?>
                <div class="form-row">
                    <div class="col-md-6 mb-6">
                        <label for="validationCustom04">Eje Rector</label>
                        <select class="custom-select select-lectura" name="RetoAct" id="RetoAct"  required>
                            <option value="">--Seleccione--</option>
                            <?=$ejes?>
                        </select>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-6 mb-6">
                        <label for="validationCustom04">Dependencia responsable</label>
                        <select class="form-control select-lectura" aria-invalid="false" name="depAct" id="depAct"  required>
                            <option value="">--Seleccione--</option>
                         
                        </select>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>
                <?php } ?>
                    <br>
                <div class="form-row">
                    <div class="col-md-1 mb-2">
                        <label for="checkODS">ODS </label>
                        <input type="checkbox" id="checkODS" name="checkODS">
                    </div>
                    <div class="col-md-11">
                        <select class="custom-select select-lectura" name="selectODS" id="selectODS">
                            <option value="">--Seleccione--</option>
                            <?php foreach($ODS as $o){ ?>
                                <option value="<?= $o->iIdOds ?>"><?= $o->vOds ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6 mb-6">
                        <label for="validationCustom04">Reto</label>
                          <select class="form-control select-lectura" aria-invalid="false" name="iReto" id="iReto" required>
                            <option value="">--Seleccione--</option>
                            <?=$retos?>
                           
                        </select>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>

                    <div class="col-md-6 mb-6">
                        <label for="validationCustom04">Área Responsable</label>
                          <select class="form-control select-lectura" aria-invalid="false" name="iAreaResponsable" id="iAreaResponsable" required>
                            <option value="">--Seleccione--</option>
                        </select>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>


                <div class="form-row">
                    <div class="col-md-12 mb-12">
                        <label for="objGeneral">Objetivo Anual</label>
                       <textarea class="form-control input-lectura" id="objGeneral" name="objGeneral" aria-invalid="false" required placeholder="" cols="40" rows="5" style=""><?=htmlspecialchars($consulta->vObjetivo)?></textarea>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                   </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12 mb-12">
                        <label for="vEstrategia">Estrategia</label>
                        <textarea class="form-control input-lectura" id="vEstrategia" name="vEstrategia" aria-invalid="false" required placeholder="" cols="40" rows="5" style=""><?=htmlspecialchars($consulta->vEstrategia)?></textarea>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <!--
                    <div class="col-md-6 mb-6" hidden style="display:none">
                        <label for="vAccion">Acción</label>
                        <textarea class="form-control input-lectura" id="vAccion" name="vAccion" aria-invalid="false" required placeholder="" cols="40" rows="5" style=""><?=htmlspecialchars($consulta->vAccion)?></textarea>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                -->
                </div>

                <div class="form-row">
                    <div class="col-md-6 mb-6">
                        <input type="hidden" class="form-control input-lectura" maxlength="255" id="vResponsable" name="vResponsable" value=".">
                    </div>
                    <div class="col-md-6 mb-6">
                        <input type="hidden" class="form-control input-lectura" maxlength="255" id="vCargo" name="vCargo" value=".">
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6 mb-6">
                        <input type="hidden" class="form-control input-lectura" maxlength="255" id="vCorreo" name="vCorreo" value=".">
                    </div>
                    <div class="col-md-6 mb-6">
                        <input type="hidden" class="form-control input-lectura" maxlength="20" id="vTelefono" name="vTelefono" value=".">
                    </div>
                </div>

                <?php if($per_ods > 0){ ?>
                <div class="row">
                    <div class="col-12 mb-6">
                        <div class="custom-control custom-checkbox mr-sm-2 m-b-15">
                            <input type="hidden" class="custom-control-input" name="iODS" id="iODS" value="0" >
                        </div>
                    </div>
                </div>
                <?php } ?>
                <hr>

                <div class="row">
                    <div class="col-12">
                        <div class="card border-danger">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="custom-control custom-checkbox mr-sm-2 m-b-15">
                                            <input type="hidden" class="select-lectura custom-control-input" name="iReactivarEconomia" id="iReactivarEconomia" value="1" >   
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="tipoActividad">Fuente de recurso<span class="text-danger">*</span></label>
                                        <select class="form-control" aria-invalid="false" name="vTipoActividad" id="vTipoActividad" required>
                                            <option value="">--Seleccione--</option>
                                            <option value="gestion">Gestion</option>
                                            <option value="poa">Estratégico</option>
                                        </select>
                                    </div>

                                    <div id="mostrarPOAS"> </div>

                                    <div class="col-sm-4 col-sm-3">
                                        <label for="validationCustom04">Monto autorizado </label>
                                        <input disabled class="input-lectura form-control" id="nPresupuestoAutorizado" name="nPresupuestoAutorizado" type="text" value="<?=DecimalMoneda($consulta->nPresupuestoAutorizado); ?>" onKeypress="return onlyDigits(event,'decOK');" maxlength="20" onblur="moneyFormat(this.id);">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="hidden" class="form-control input-lectura" maxlength="255" id="nPresupuestoModificado" name="nPresupuestoModificado" value="0">
                                        <input type="hidden" class="form-control input-lectura" id="valCatPoas" name="valCatPoas" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

             <!--<div class="form-row">
                    <div class="col-md-12 mb-12">
                        <label for="vJustificaCambio">Justificación del cambio</label>
                        <textarea class="form-control input-lectura" id="vJustificaCambio" name="vJustificaCambio" aria-invalid="false" required placeholder="" cols="40" rows="5" style=""><?=htmlspecialchars($consulta->vJustificaCambio)?></textarea>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    
                </div>-->

                <div class="content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive" id="tabla-grid3">
                                       
                                        <table class="table table-striped table-bordered" id="table3">
                                            <thead>
                                                <th>Eje</th>
                                                <th>P. Pública</th>
                                                <th>Objetivo</th>
                                                <th>Estrategia</th>
                                                <th>Línea de acción</th>
                                                <th></th>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $contLA = 0;
                                            foreach ($alineacion as $row)
                                            {
                                                $button = ($row->caracteres > 10)? '<i class="fas fa-check text-success"></i>':'<button type="button" name="dltactla" title="Eliminar" id="dltactla" type="button" class="btn btn-xs waves-effect waves-light boton_eliminar dltactla" onclick="eliminarLA('.$contLA.')"><i class="mdi mdi-close"></i></button>';
                                                $input = '<input type="hidden" class="linea" name="la'.$contLA.'" id="la'.$contLA.'" value="'.$row->iIdLineaAccion.'">';

                                                echo '<tr id="trla'.$contLA.'">
                                                    <td>'.$row->vEje.'</td>
                                                    <td>'.$row->vTema.'</td>
                                                    <td>'.$row->vObjetivo.'</td>
                                                    <td>'.$row->vEstrategia.'</td>
                                                    <td>'.$row->vLineaAccion.'</td>
                                                    
                                                    <td>'.$button.$input.'</td>
                                                </tr>'; 
                                                $contLA++;
                                            }
                                            
                                            ?> 
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                
                <br><br>

                <div class="content">

                    <div class="row">
                        <div class="col-md-2 mb-2" style="text-align: -webkit-right;">
                            <label for="icluyeMIR">Incluye MIR</label>
                        </div>

                        <div class="col-md-2 mb-2" style="text-align: -webkit-center;">
                            <input type="checkbox" id="icluyeMIR" name="icluyeMIR">
                        </div>

                        <div class="col-md-2" style="text-align: -webkit-right;">
                            <label for="ProgramaPresupuestario" id="txtNivelMIR" name="txtNivelMIR">Nivel de MIR</label>
                        </div>

                        <div class="col-md-6">
                                <div class="col-md-12">
                                    <select class="form-control" name="idNivelMIR" id="idNivelMIR">
                                        <option value="">--Seleccione--</option>
                                        <?php foreach($nivelesMIR as $nivelMIR){?>
                                        <option value="<?= $nivelMIR->iIdNivelMIR ?>"><?= $nivelMIR->vNivelMIR ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                        </div>                 
                    </div>

                </div>
                <br>
                <div class="content">
                    <div class="row">
                        <div class="col-md-2 mb-2" style="text-align: -webkit-right;">
                            <label for="tieneAglomeracion">Tiene Aglomeracion</label>
                        </div>

                        <div class="col-md-2 mb-2" style="text-align: -webkit-center;">
                            <input type="checkbox" id="tieneAglomeracion" name="tieneAglomeracion" >
                        </div>

                        <div class="col-md-8">
                                <div class="col-md-12" id="recuadroactividad">
                                    <select class="form-control selectpicker" name="idActividad[]" id="idActividad" multiple>
                                        <option value="">--Seleccione--</option>
                                    </select>
                                </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="content">
                    <div class="row">

                        <div class="col-md-2 col-md-2 mb-2" style="text-align: -webkit-right;">
                            <label for="ProgramaPresupuestario">Programa Presupuestario</label>
                        </div>

                        <div class="col-md-2">
                        
                        </div>

                        <div class="col-md-8">
                                <div class="col-md-12">
                                    <select class="form-control" name="ProgramaPresupuestario" id="ProgramaPresupuestario">
                                        <option value="">--Seleccione--</option>
                                        <?php foreach($programaPresupuestario as $pp){?>
                                        <option value="<?= $pp->iIdProgramaPresupuestario ?>"><?= $pp->vProgramaPresupuestario ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                        </div>
                    </div>

                </div>

                <div class="content">
                    <div class="row">
                        <div class="col-md-2" style="text-align: -webkit-right;">
                            <label for="resumenNarrativo" id="txtResumenNarrativo" name="txtResumenNarrativo">Resumen Narrativo</label>
                        </div>

                        <div class="col-md-2">
                        
                        </div>

                        <div class="col-md-8">
                                <div class="col-md-12">
                                    <select class="form-control" name="resumenNarrativo" id="resumenNarrativo">
                                        <option value="">--Seleccione--</option>
                                        
                                    </select>
                                </div>
                        </div>
                    </div>
                </div>
                <br>

                <div class="content">
                    <div class="row">
                        <div class="col-md-12 mb-10">
                            <label for="validationCustom04">Supuesto</label>
                            <textarea class="form-control input-lectura" id="txtSupuesto" name="txtSupuesto" aria-invalid="false" required placeholder="" cols="40" rows="5" style=""><?=htmlspecialchars($consulta->vDescripcion)?></textarea>
                            <div class="invalid-feedback">
                                Este campo no puede estar vacio.
                            </div>
                        </div>
                    </div>
                </div>
                
               
                <div class="content">
                    
                    <br><br>
                    <center>&nbsp;&nbsp;
                        <button class="btn-lectura btn btn-lg btn-info" type="submit">Guardar</button>
                    </center>
            </form>
        </div>
    </div>
</div>


<input type="text" value="<?= base_url(); ?>" id="url" style="display: none">
<script src="<?= base_url() ?>/assets/jquery.maskMoney.js"></script>
<script>
    var isIE = document.all     ? true : false;
    var isNS = document.layers  ? true : false;
    var proyectos   = [];
    var peticion    = true;
    var arrayDep    = [];

    function onlyDigits(e,decReq) {
        var key = (isIE) ? event.keyCode : e.which;
        var obj = (isIE) ? event.srcElement : e.target;
        var isNum = (key > 47 && key < 58) ? true : false;
        var dotOK = (key==46 && decReq=='decOK' && (obj.value.indexOf(".")<0 || obj.value.length==0)) ? true:false;
        var isDel = (key==0 || key==8 ) ? true:false;
        var isEnter = (key==13) ? true:false;
        //e.which = (!isNum && !dotOK && isNS) ? 0 : key;
        return (isNum || dotOK || isDel || isEnter);
    }

    var contLA = <?=$contLA?>;
    $(document).ready(function() {
        <?php if($acceso == 1){ ?>
            $('.btn-lectura').css('display','none');
            $('.select-lectura').attr('disabled',true);
            $('.input-lectura').attr('readonly','readonly');
            
            
        <?php } ?>
        $('#idNivelMIR').hide();
        $('#selectProyectoPrioritario').hide();
        $('#txtResumenNarrativo').hide();
        $('#resumenNarrativo').hide();
        $('#txtNivelMIR').hide();
        $('#recuadroactividad').hide();
        $('#selectODS').hide();
        $(".select2").select2();
        url = $("#url").val();
        sumaMontoFin();
        
        idDependenciaGuardado = <?php echo $idDependencia ?>;
        
        obtenerAreasResp(idDependenciaGuardado)
        obtenerActividades(idDependenciaGuardado)


        $("#mostrarPOAS").removeClass("col-sm-3");

        $('#depAct').change(function(){
            idDEp = $(this).val();
            $("#iAreaResponsable").empty();
            $("#idActividad").empty();
            obtenerActividades(idDEp)
            obtenerAreasResp(idDEp)
        });

        $('#idNivelMIR').change(function(){
            nivelMIR = $(this).val();
            if(nivelMIR >= 1){
                document.getElementById("resumenNarrativo").disabled = false;
                $("#resumenNarrativo").empty()
                obtenerResumen(nivelMIR)
                $('#resumenNarrativo').show();
                $('#txtResumenNarrativo').show();
            }else{
                $('#resumenNarrativo').hide();
                $('#txtResumenNarrativo').hide();
                document.getElementById("resumenNarrativo").disabled = true;
            }
            
        });

        //Obtengo las dependencias para manejar en POA
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_pat/getDependencias",
            success: function(resp) {
                arrayDep = JSON.parse(resp);
            },
            error: function(XMLHHttRequest, textStatus, errorThrown) {
                console.log(XMLHHttRequest);
            }
        });
    });
    function obtenerResumen(nivelMIR){
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_pat/obtenerResumenNarrativo",
            data:{nivelMIR:nivelMIR},
            success: function(resp) {
                var parsedData = JSON.parse(resp);
                for(let i = 0; i <= parsedData.length; i++){
                    if(parsedData[i]?.vNombreResumenNarrativo != undefined){
                        $('#resumenNarrativo').append('<option value="'+parsedData[i]?.iIdResumenNarrativo+'">'+parsedData[i]?.vNombreResumenNarrativo+'</option>')
                    }
                }
                
                
            },
            error: function(XMLHHttRequest, textStatus, errorThrown) {
                console.log(XMLHHttRequest);
            }
        });
    }
    function obtenerActividades(idDependencia){

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_pat/obtenerActividades",
            data:{idDependencia:idDependencia},
            success: function(resp) {
                var parsedData = JSON.parse(resp);
                for(let i = 0; i <= parsedData.length; i++){
                    if(parsedData[i]?.vActividad != undefined){
                        $('#idActividad').append('<option value="'+parsedData[i]?.iIdActividad+'">'+parsedData[i]?.vActividad+'</option>')
                    }
                }
                $('.selectpicker').selectpicker('refresh');

                
            },
            error: function(XMLHHttRequest, textStatus, errorThrown) {
                console.log(XMLHHttRequest);
            }
        });

    }

    function obtenerAreasResp(idDependencia){

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_pat/obtenerAreasRESP",
            data:{idDependencia:idDependencia},
            success: function(resp) {
                var parsedData = JSON.parse(resp);
                for(let i = 0; i <= parsedData.length; i++){
                    if(parsedData[i]?.vAreaResponsable != undefined){
                        $('#iAreaResponsable').append('<option value="'+parsedData[i]?.iIdAreaResponsable+'">'+parsedData[i]?.vAreaResponsable+'</option>')
                    }
                }
                
            },
            error: function(XMLHHttRequest, textStatus, errorThrown) {
                console.log(XMLHHttRequest);
            }
        });

    }

    $('#icluyeMIR').click(function(){
        if($(this).is(':checked')){
            document.getElementById("idNivelMIR").disabled = false;
            $('#idNivelMIR').show();
            $('#txtNivelMIR').show();
        } else {
            $('#idNivelMIR').prop('selectedIndex',0);
            $('#idNivelMIR').hide();
            $('#txtNivelMIR').hide();
            document.getElementById("idNivelMIR").disabled = true;

            $('#txtResumenNarrativo').hide();
            $('#resumenNarrativo').hide();
            $('#resumenNarrativo').prop('selectedIndex',0);
            document.getElementById("resumenNarrativo").disabled = true;
        }
    });

    $('#RetoAct').change(function(){
            // var idEje = $("#idEje").val();
            iIdEje = $(this).val();
            if(iIdEje >= 1){
                
                $("#iReto").empty()
                obtenerRetoseje(iIdEje) 
                $("#depAct").empty()
                obtenerDependenciaeje(iIdEje) 
                
            }else{
                console.log('No se ha seleccinado algo')

                
            }
            
        });
        
        function obtenerRetoseje(iIdEje){
            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>C_pat/obtenerRetosEje",
                data:{iIdEje:iIdEje},
                success: function(resp) {
                    var parsedData = JSON.parse(resp);
                    $('#iReto').append('<option value="">--Seleccione--</option>')
                    for(let i = 0; i <= parsedData.length; i++){
                        if(parsedData[i]?.vDescripcion != undefined){
                            $('#iReto').append('<option value="'+parsedData[i]?.iIdReto+'"  >'+parsedData[i]?.vDescripcion+'</option>')
                        }
                    }
                    // $('.selectpicker').selectpicker('refresh');
                    
                    console.log(resp)
                    
                    
                },
                error: function(XMLHHttRequest, textStatus, errorThrown) {
                    console.log(XMLHHttRequest);
                }
            });
    }
        function obtenerDependenciaeje(iIdEje){
            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>C_pat/obtenerDependenciaEje",
                data:{iIdEje:iIdEje},
                success: function(resp) {
                    var parsedData = JSON.parse(resp);
                    $('#depAct').append('<option value="">--Seleccione--</option>')
                    for(let i = 0; i <= parsedData.length; i++){
                        if(parsedData[i]?.vDependencia != undefined){
                            $('#depAct').append('<option value="'+parsedData[i]?.iIdDependencia+'"  >'+parsedData[i]?.vDependencia+'</option>')
                        }
                    }
                    // $('.selectpicker').selectpicker('refresh');
                    
                    console.log(resp)
                    
                    
                },
                error: function(XMLHHttRequest, textStatus, errorThrown) {
                    console.log(XMLHHttRequest);
                }
            });
    }
    $('#checkODS').click(function(){
        if($(this).is(':checked')){
            document.getElementById("selectODS").disabled = false;
            $('#selectODS').show();
        } else {
            $('#selectODS').prop('selectedIndex',0);
            $('#selectODS').hide();
            document.getElementById("selectODS").disabled = true;
        }
    });

    $('#checkProyectoPrioritario').click(function(){
        if($(this).is(':checked')){
            document.getElementById("selectProyectoPrioritario").disabled = false;
            $('#selectProyectoPrioritario').show();
        } else {
            $('#selectProyectoPrioritario').prop('selectedIndex',0);
            $('#selectProyectoPrioritario').hide();
            document.getElementById("selectProyectoPrioritario").disabled = true;
        }
    });

    $('#tieneAglomeracion').click(function(){
        if($(this).is(':checked')){
            document.getElementById("recuadroactividad").disabled = false;
            $('#recuadroactividad').show();
        } else {
            $('#recuadroactividad').prop('selectedIndex',0);
            $('#recuadroactividad').hide();
            document.getElementById("recuadroactividad").disabled = true;
        }
    });
    
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    $("#tabla-grid").load('<?= base_url() ?>C_pat/tablaFinanciamiento');
    $("#tabla-grid2").load('<?= base_url() ?>C_pat/tablaUbpsPp');
    //$("#tabla-grid3").load('<?= base_url() ?>C_pat/generar_tabla');
    //$(":input").inputmask();
    
    function agregarLA(){
        var idLA = $("#linAcc").val();
        console.log(findLA(!idLA));

        if(findLA(idLA) == false){
            $.ajax({
                type: "POST",
                data: 'idLA='+idLA+'&contLA='+contLA,
                url: '<?=base_url()?>C_pat/agregar_la',
                success: function(response) {
                    $("#table3").append(response);
                    contLA++;
                }
            });
        }else {
            alerta('Esta linea de acción ya se encuentra vinculada', 'warning');
        }
    }

    function eliminarLA(id){
        $('#trla'+id).remove();
    }

    function findLA(idLA){
        var response = false;
        $(".linea").each(function(){
            if(parseInt(this.value) == parseInt(idLA)) response = true;            
        });

        return response;
    }

    function sumaMontoFin() {
        //alert(url);
        var recurso = "C_pat/getsumaMonto";
        $.ajax({
            type: "GET",
            url: url + recurso,
            success: function(data) {
                //console.log(comma(data));
                $("#montoFinal").val(comma(data));
            }
        });
        //$("#montoFinal").val(total);
    }

    function comma(data) {
        var valor = data.split('.');
        var residuo = valor[0].length % 3;
        var resultado = '$';
        var cont = 0;
        for (var i = 0; i < valor[0].length; i++) {
            resultado += valor[0].charAt(i);
            if ((residuo - 1) == i) {
                resultado += ',';
            } else {
                if (i >= residuo) {
                    cont++;
                    if (cont == 3) {
                        resultado += ',';
                        cont = 0;
                    }

                }
            }
        }
        resultado = resultado.slice(0, -1);

        if (data.includes('.')) {
            resultado += '.' + valor[1]
        }

        /*if (data.indexOf('.')) {
            resultado += '.' + valor[1]
        }*/
        return resultado;
    }

    function restaMontoFin() {
        //alert(url);
        var recurso = "C_pat/getrestaMonto";
        $.ajax({
            type: "GET",
            url: url + recurso,
            success: function(data) {
                $("#montoFinal").val(data);
            }
        });
        //$("#montoFinal").val(total);
    }

    src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"

    function cargarPpublica() {

        var value = $("#eje").val();
        console.log(value);
        $("#polipub").load('C_pat/dPoliPub/' + value);
        $("#objetivo").load('C_pat/dObjetivo/' + 0);
        $("#estrategia").load('C_pat/dEstrategia/' + 0);
        $("#linAcc").load('C_pat/dLineaAccion/' + 0);
    }

    function cargarObjetivo() {
        var value = $("#polipub").val();
        $("#objetivo").load('C_pat/dObjetivo/' + value);
        $("#estrategia").load('C_pat/dEstrategia/' + 0);
        $("#linAcc").load('C_pat/dLineaAccion/' + 0);
    }

    function cargarEstrategia() {
        var value = $("#objetivo").val();
        $("#estrategia").load('C_pat/dEstrategia/' + value);
        $("#linAcc").load('C_pat/dLineaAccion/' + 0);
    }

    function cargarLineaAccion() {
        var value = $("#estrategia").val();
        $("#linAcc").load('C_pat/dLineaAccion/' + value);
    }

    function guardarDetalles(f, e) {
        var inicio  = new Date(document.getElementById('fINICIO').value);
        var fin     = new Date(document.getElementById('fFIN').value);
        let tipo    = $('select[id=vTipoActividad]').val();

        if(tipo == 'poa'){
           $('#valCatPoas').val($('select[id=catPoas]').val());
        }
        else {
            $('#valCatPoas').val('0');
        }

        e.preventDefault();

        if(fin < inicio){
            alerta('La fecha final debe ser mayor que la fecha inicial y viceversa', 'warning');
        }
        else{
            $('#nPresupuestoAutorizado').prop('disabled', false);
            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>C_pat/guardarNewAct",
                data: $(f).serialize()+'&contLA='+contLA,
                success: function(resp) {
                    if (resp == 'Correcto') {
                        //filtrar(e);
                        alerta('Guardado exitosamente', 'success');
                        setTimeout(function(){
                            back();
                        }, 3000);
                    } else {
                        alerta('Error al guardar', 'error');
                        //alert(resp);
                    }
                },
                error: function(XMLHHttRequest, textStatus, errorThrown) {}
            });
        }
    }

    /* Carrito selectores */
    function agregarCarrito() {
        if ($('#eje').val() == '0') {
            alerta('Debe seleccionar una opcion', 'error');
        } else {
            if ($('#linAcc').val() == '0') {
                alerta('Debe seleccionar una opcion', 'error');

            } else {
                var formData = new FormData();
                formData.append('linAcc', $("#linAcc").val());
                formData.append('tema', $("#tema").val());
                var url = "C_pat/carritoSelectores";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    async: false,
                    success: function(data) {
                        if (data == 1) {
                            $("#tabla-grid3").load('<?= base_url() ?>C_pat/generar_tabla');
                        } else {
                            alerta('No se puede repetir la opcion', 'error');
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        }
    }

    function eliminarCarrito(id) {
        var formData = new FormData();
        formData.append('linAcc', id);
        var url = "C_pat/removecarritoSelectores";
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            async: false,
            success: function(data) {
                if (data == 1) {
                    $("#tabla-grid3").load('<?= base_url() ?>C_pat/generar_tabla');
                } else {
                    alerta('Error al eliminar', 'error');
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }

    /* Carrito financiamiemto */
    function agregarCarritoF() {
        if ($('#montoF').val() == '') {
            alerta('Debe de ingresar un monto', 'error');
        } else {
            if ($('#fuenteF').val() == '0') {
                alerta('Debe seleccionar una opción', 'error');
            } else {
                var formData = new FormData();
                formData.append('fuenteF', $("#fuenteF").val());
                formData.append('montoF', $("#montoF").val());

                var url = "C_pat/carritoFinanciamiento";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    async: false,
                    success: function(data) {
                        if (data == 1) {
                            $("#tabla-grid").load('<?= base_url() ?>C_pat/tablaFinanciamiento');
                            sumaMontoFin();
                        } else {
                            alerta('No se puede repetir la opcion', 'error');
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        }
    }

    function eliminarCarritoF(id) {
        var formData = new FormData();
        formData.append('fuenteF', id);
        var url = "C_pat/removecarritoFinanciamiento";
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            async: false,
            success: function(data) {
                if (data == 1) {
                    $("#tabla-grid").load('<?= base_url() ?>C_pat/tablaFinanciamiento');
                    sumaMontoFin();
                } else {
                    alerta('Error al eliminar', 'error');
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }

    /* Carrito UBP y PP */
    function agregarCarritoUP() {
        if ($('#NumUBP').val() == '0') {
            alerta('Debe seleccionar una opción', 'error');
        } else {
            var formData = new FormData();
            formData.append('NumUBP', $("#NumUBP").val());
            var url = "C_pat/carritoUbpsPp";
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                async: false,
                success: function(data) {
                    if (data == 1) {
                        $("#tabla-grid2").load('<?= base_url() ?>C_pat/tablaUbpsPp');
                    } else {
                        alerta('No se puede repetir la opcion', 'error');
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    }

    function eliminarCarritoUP(id) {
        var formData = new FormData();
        formData.append('NumUBP', id);
        var url = "C_pat/removecarritoUbpsPp";
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            async: false,
            success: function(data) {
                if (data == 1) {
                    $("#tabla-grid2").load('<?= base_url() ?>C_pat/tablaUbpsPp');
                } else {
                    alerta('Error al eliminar', 'error');
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
    $(".mask").inputmask('Regex', {
        regex: "^[0-9]{1,20}(\\.\\d{1,2})?$"
    });

    /**
     * Crea el select del POA
     */
    function createSelectPOA(){
        let actvidad    = $('select[id=vTipoActividad]').val();
        let html        = '';
        let tieneDep    = true;

        <?php if(!isset($ejes) && !isset($dependencias)){ ?> tieneDep = false  <?php } ?>

        if(actvidad == 'poa'){ 
            let nombreDep       = '';
            let dependenciaID   = $('select[id=depAct]').val();

            //Obtengo la dependencia para sacar los poas
            if(tieneDep) {
                arrayDep.forEach(element => {
                    if(element.id == dependenciaID) {
                        nombreDep =  removeAccents(element.valor);
                    }
                });
            }
            else {
                <?php  echo "var varJS ='$vDependencia';";?>
                nombreDep =  removeAccents(varJS);
            }

            $("#mostrarPOAS").addClass("col-sm-4");
            html = `<div id="divCatPoas">
                        <label for="tipoActividad">POAS <span class="text-danger">*</span></label>
                        <select class="form-control" aria-invalid="false" id="catPoas" name="catPoas" required onchange="setMontoPOA(this)">
                            <option value="">--Seleccione--</option>
                        </select>
                        <div class="invalid-feedback">Este campo no puede estar vacio.</div>
                    </div>`;
    
            $("#mostrarPOAS").html(html);
            
            if(peticion){
                $.ajax({
                    type: "POST",
                    url: "<?= base_url() ?>C_pat/validarListaPOA",
                    success: function(resp) {
                        let response = JSON.parse(resp);
                        proyectos    = response;
    
                        response.forEach((value) => {
                            let nombreFinanzas = removeAccents(value.dependenciaEjecutora);
                            if(nombreFinanzas.toUpperCase() == nombreDep.toUpperCase() ){
                                $("#catPoas").append('<option value='+value.numeroProyecto+'>'+value.nombreProyecto+'</option>');
                            }
                        });
                        peticion = false;
                    },
                    error: function(XMLHHttRequest, textStatus, errorThrown) {
                        console.log(XMLHHttRequest);
                    }
                });
            }
            else {
                proyectos.forEach((value) => {
                    let nombreFinanzas = removeAccents(value.dependenciaEjecutora);
                    if(nombreFinanzas.toUpperCase() == nombreDep.toUpperCase() ){
                        $("#catPoas").append('<option value='+value.numeroProyecto+'>'+value.nombreProyecto+'</option>');
                    }
                });
            }
        }
    }

    /** Cambios aplicados por Manuel Euan */
    $("#vTipoActividad").change(function(){
        let actv    = $('select[id=vTipoActividad]').val();

        $("#mostrarPOAS").removeClass("col-sm-4");
        $("#mostrarPOAS").html('');
        
        if(actv == 'gestion'){
            $('#nPresupuestoAutorizado').val('0');
            $('#nPresupuestoAutorizado').prop('disabled', true);
        }
        else {
            if(actv == 'poa'){
                createSelectPOA();
            }
        }
    });
    $( document ).ready(function() {
            
            $('.selectpicker').selectpicker();
        });
</script>