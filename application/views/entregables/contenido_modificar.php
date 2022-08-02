<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <h2 class="card-title">Modificar Indicador</h2>
                </div>
                <div class="col-md-2 text-right">
                    <button title="Ir a la pantalla anterior" class="btn waves-effect waves-light btn-outline-info" type="submit" onclick="regresarmodulo()"><i class="mdi mdi-arrow-left"></i>Regresar</button>
                </div>
            </div>
            <br>
            
            <?php if($av_capturados) echo '<small>Los campos deshabilitados no pueden modificarse debido a que el indicador cuenta con avances capturados en este o en años anteriores.</small>'; ?>
            <form class="needs-validation was-validated" onsubmit="modificarEntregables(this,event);">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label>Nombre del indicador <span class="text-danger">*</span></label>
                        <textarea class="input-lectura form-control" id="entregable" name="entregable" aria-invalid="false" required="" placeholder="Ingresar nombre del indicador"><?= $consulta->vEntregable ?></textarea>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>  
                    
                    <div class="col-md-2 mb-3">
                        <label for="validationCustom04">Forma Indicador<span class="text-danger">*</span></label>
                        <select id="formaIndicador" name="formaIndicador" required class="form-control">
                            <option value="">Seleccionar...</option>
                            <?php foreach($formaIndicador as $f){ ?>

                                <option value="<?= $f->iIdFormaInd ?>" <?php if($f->iIdFormaInd == $idForma) echo 'selected';?>><?= $f->vDescripcion ?></option>

                            <?php } ?>
                        </select>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                      <input type="hidden" id="" name="" required class="form-control" value=1>

                   
                    <div class="col-md-2 mb-3">
                        <label>Dimensión<span class="text-danger">*</span></label>
                        <select name="selectDimension" id="selectDimension" required class="form-control">
                            <option value="">Seleccionar...</option>
                            <?php foreach($dimension as $d){ ?>

                                <option value="<?= $d->iIdDimensionInd ?>" <?php if($d->iIdDimensionInd == $idDiemension) echo 'selected';?> ><?= $d->vDescripcion ?></option>

                            <?php } ?>
                        </select>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    
                </div>

                <!--- Este va a variar -->
                <div class="form-row" id="divVariables">

                    <?php if(count($Variables) > 0){ ?>

                        <?php foreach($Variables as $key => $v){ ?>
                            <div class="col-md-3 mb-3 divVariable<?= $v->iIdVariableIndicador ?>">
                                <?php if($key == 0){ ?>
                                    <label>Variable <?= $v->vVariableIndicador ?><span class="text-danger">*</span> <button type="button" onclick="agregarVariable();" style="border: none;">+</button></label>
                                <?php } else {?>
                                    <label>Variable <?= $v->vVariableIndicador ?><span class="text-danger">*</span> <button class="remover" type="button" onclick="eliminar(<?= $v->iIdVariableIndicador ?>);" style="border: none;">x</button></label>
                                <?php } ?>
                            <input type="text" id="idVariable" name="idVariable[]" class="form-control" value="<?= $v->iIdVariableIndicador ?>" hidden>     
                            <input type="text" id="<?= $v->vVariableIndicador ?>" name="Letra[]" class="form-control" required="required" value="<?= $v->vVariableIndicador ?>" hidden>
                            <input type="text" id="<?= $v->vVariableIndicador ?>" name="Variable[]" class="form-control" required="required" placeholder="<?= $v->vVariableIndicador ?>" value="<?= $v->vNombreVariable ?>">
                            <div class="invalid-feedback">
                                Este campo no puede estar vacio.
                            </div>
                        </div>
                        <?php }?>
                    
                    <?php }else{ ?>
                        <div class="col-md-3 mb-3">
                            <label>Variable A<span class="text-danger">*</span> <button type="button" onclick="agregarVariable();" style="border: none;">+</button></label>
                            <input type="text" id="A" name="Letra[]" class="form-control" required="required" value="A" hidden>
                            <input type="text" id="A" name="Variable[]" class="form-control" required="required" placeholder="A">
                            <div class="invalid-feedback">
                                Este campo no puede estar vacio.
                            </div>
                        </div>
                    <?php } ?>


                </div>

                <div class="form-row">
                    <div class="col-md-2 mb-3">
                        <label for="validationCustom04">Base Indicador<span class="text-danger">*</span></label>
                        <input type="text" id="baseIndicador" name="baseIndicador" class="form-control" required="required" placeholder="" value="<?= $baseIndicador?>">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                      <input type="hidden" id="" name="" required class="form-control" value=1>

                   
                    <div class="col-md-2 mb-3">
                        <label>Medio Verificación<span class="text-danger">*</span></label>
                        <input type="text" id="medioVerificacion" name="medioVerificacion" class="form-control" required="required" placeholder="" value="<?= $medioVerificacion?>">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>

                    <div class="col-md-8 mb-3">
                        <label>Area para calculo de variable<span class="text-danger">*</span></label>
                        <textarea class="form-control alphaonly" id="areaCalculo" name="areaCalculo" aria-invalid="false" required="" placeholder="" onkeypress="sinEspacios(event);"><?= $areaCalculo?></textarea>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>


                

                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <label>Meta<span class="text-danger">*</span></label>
                        <input type="text" id="meta" name="meta" class="input-lectura form-control" required="" placeholder="" value="<?= DecimalMoneda($consulta->nMeta); ?>" onKeypress="return soloDigitos(event,'OK','MIN');" maxlength="30" onblur="moneyFormat(this.id);">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                        <input type="hidden" class="form-control input-lectura" maxlength="255" id="metamodificada" name="metamodificada" value="0">
                   <!-- <div class="col-md-3 mb-3">
                        <label>Meta modificada<span class="text-danger">*</span></label>
                        <input type="text" id="metamodificada" name="metamodificada" class="input-lectura form-control" required="" placeholder="" value="<?= DecimalMoneda($consulta->nMetaModificada); ?>" onKeypress="return soloDigitos(event,'OK');" maxlength="30" onblur="moneyFormat(this.id);">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    -->
                    <div class="col-md-2 mb-3">
                        <label for="validationCustom04">Unidad de medida<span class="text-danger">*</span></label>
                        <select id="unidadmedida" name="unidadmedida" required class="input-lectura form-control" <?php if($av_capturados > 0) echo "disabled";?>>
                            <?= $unidadmedida ?>
                        </select>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                   <!-- <div class="col-md-2 mb-3">
                        <label for="validationCustom04">Sujeto afectaado<span class="text-danger">*</span></label>
                       
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>-->
                    <div class="col-md-2 mb-3">
                        <label>Periodicidad<span class="text-danger">*</span></label>
                        <select name="periodicidad" id="periodicidad" required class="input-lectura form-control">
                            <?= $periodicidad ?>
                        </select>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label>Tipo<span class="text-danger">*</span></label>
                        <select name="tipoAlta" id="tipoAlta" required class="form-control">
                            <option value="">Seleccionar...</option>
                            <option value="1" <?php if($iAcumulativo == 1) echo 'selected' ?>>Acumulativo </option>
                            <option value="2" <?php if($iAcumulativo == 2) echo 'selected' ?>>Puntual</option>
                        </select>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>

                    <select style="visibility:hidden" id="sujetoafectado" name="sujetoafectado" required class="input-lectura form-control" <?php if($av_capturados > 0) echo "disabled";?>>
                            <?= $sujeto_afectado ?>
                        </select>
                </div>

                <div class="form-row">
                     <div class="col-md-3 mb-3">
                        <label>Fecha inicio<span class="text-danger">*</span></label>
                        <input type="date" id="fechainicio" name="fechainicio" class="form-control only_number" required="" placeholder="" value="<?=$consulta1[0]->dInicio?>" readonly>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Fecha fin<span class="text-danger">*</span></label>
                        <input type="date" id="fechafin" name="fechafin" class="form-control only_number" required="" placeholder="" value="<?=$consulta1[0]->dFin?>" readonly>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-3" style="padding-left: 20px;">
                       <div class="row">

                        <div class="custom-control custom-checkbox mr-sm-2 m-b-15" style="margin-top:35px;">
                                <input type="checkbox" class="select-lectura custom-control-input" id="checkbox0" name="municipalizable" value="1" <?php if($consulta->iMunicipalizacion == 1)  echo 'checked '; if($av_capturados) echo 'disabled'; ?>/>
                                <label class="custom-control-label" for="checkbox0">Se entrega por municipio</label>
                            </div>

                            <div class="custom-control custom-checkbox mr-sm-2 m-b-15" style="margin-top:35px;">
                                    <input type="checkbox" class="custom-control-input" id="checkMismoBenef" name="checkMismoBenef" value="1" <?php if($iMismosBeneficiarios == 1) echo 'checked' ?>>
                                    <label class="custom-control-label" for="checkMismoBenef">Mismo Beneficiario</label>
                            </div>

                       </div>
                    </div>
                    <div class="col-md-6 mb-3">
                       <div class="custom-control custom-checkbox mr-sm-2 m-b-15" style="margin-top:35px;">
                            <!--<input type="checkbox" class="select-lectura custom-control-input" id="checkbox1" name="beneficios" value="1" <?php if($consulta->iMismosBeneficiarios == 1)  echo 'checked '; if($av_capturados) echo 'disabled'; ?>/>
                            <label class="custom-control-label" for="checkbox1">Reporta los mismos beneficiarios</label>-->

                            <!--<input type="hidden" class="form-control input-lectura" maxlength="255" id="checkbox1" name="beneficios" value="0">-->
                        </div>
                    </div>
                    <div class="col-md-12">
                         <label for="municipios">Municipios</label>
                        <select aria-invalid="false" class="select2 form-control" multiple="multiple" style="height: 36px;width: 100%;" name="municipios[]" id="municipios">
                            <?=$municipios;?>
                        </select>  
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div> 
                    </div>
                </div>
                <br>
                <?php 
                $checked_a = '';
                if($consulta->iAnexo == 1){
                    $checked_a = 'checked';
                }
                ?>
                
                <div style="display:none;">
                <fieldset>
                    <h5 class="card-title">Anexo estadístico</h5>
                    <div class="dropdown-divider"></div>
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                           <div class="custom-control custom-checkbox mr-sm-2 m-b-15">
                                <input type="checkbox" class="select-lectura custom-control-input" id="checkbox2" name="anexo" value="1" <?= $checked_a ?>>
                                <label class="custom-control-label" for="checkbox2">Se reporta en el anexo estadístico</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Nombre para la tabla del anexo</label>
                            <textarea class="input-lectura form-control" id="vNombreEntregable" name="vNombreEntregable"><?= $consulta->vNombreEntregable ?></textarea>
                        </div>
                    </div>
                </fieldset>
                </div>
                                
                <fieldset>
                 <!--   <h5>Alineacion compromisos</h5>
                
                    <div class="dropdown-divider"></div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom04">Compromiso</label>
                            <select id="compromiso" name="compromiso" required class="select-lectura form-control" onchange="cargarComponente()">
                            <option value="0">Seleccionar...</option>
                                <?= $compromiso ?>
                            </select>
                            <div class="invalid-feedback">
                                Este campo no puede estar vacio.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Componente</label>
                            <select name="componente" id="componente" required class="select-lectura form-control">
                                <?= $componente ?>
                            </select>
                            <div class="invalid-feedback">
                                Este campo no puede estar vacio.
                            </div>
                        </div>
                    </div>-->
                </fieldset>

                <center>
                    <input type="hidden" name="id_entregable" value="<?= $id_ent ?>">
                    <input type="hidden" name="id_detalleactividad" value="<?= $id_detact ?>">
                    <button class="btn-lectura btn waves-effect waves-light btn-info" type="submit">Guardar</button>
                    <button type="reset" class="btn-lectura btn waves-effect waves-light btn-inverse" onclick="regresarmodulo()">Cancelar</button>
                </center>
            </form>
        </div>
    </div>
</div>

<script>
    
    var areaReponsableArray = []

    var myArea = {};

    var arrayJS=<?php echo json_encode($Variables);?>;

    if(arrayJS.length == 0){
        var alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    }else{
        var alphabet = '.ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    }

    for(var i=0;i<arrayJS.length;i++)
    {
        myArea.id = 1;
        areaReponsableArray.push(myArea);
        myArea = {}
    }

    $(document).ready(function(){
        $(".select2").select2();
    });
    $(document).ready(function(){
         <?php if($acceso == 1){ ?>
            $('.btn-lectura').css('display','none');
            $('.select-lectura').attr('disabled',true);
            $('.input-lectura').attr('readonly','readonly');
        <?php
        }
        ?>
        $("#compromiso, #componente").select2();
    });

    function cargarComponente() {
        var value = $("#compromiso").val();
        $("#componente").load('C_entregables/showcomponentes/' + value);
    }


    function agregarVariable(){

        var id = areaReponsableArray.length + 1

        myArea.id = id

        var tbody = '<div class="col-md-3 mb-3 divVariable'+id+'"> <label>Variable '+alphabet[id]+'<span class="text-danger">*</span> <button class="remover" type="button" onclick="remover('+id+');" style="border: none;">x</button></label> <input type="text" id="idVariable" name="idVariable[]" class="form-control" value="" hidden>  <input type="text" id="'+alphabet[id]+'" name="Letra[]" class="form-control" required="required" value="'+alphabet[id]+'" hidden> <input type="text" id="'+alphabet[id]+'" name="Variable[]" class="form-control" required="required" placeholder="'+alphabet[id]+'"> <div class="invalid-feedback"> Este campo no puede estar vacio. </div> </div>'
        $('#divVariables').append(tbody)

        areaReponsableArray.push(myArea);
        myArea = {}
        /*var result = eval('1+3-4'); */
    }

    function remover(id){
        areaReponsableArray = areaReponsableArray.filter(obj => obj.id != id)
        $(".divVariable"+id).remove();
    }

    function modificarEntregables(f, e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_entregables/update", //Nombre del controlador
            data: $(f).serialize(),

            success: function(resp) {
                if (resp >0) {

                    CalcularPorcentajeActividad();
                    alerta('Modificado exitosamente', 'success');
                    regresarmodulo();
                } else {
                    alerta('Error al guardar', 'error');
                }

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {

            }
        });
    }

    function sinEspacios(e) {
        $("#areaCalculo").on({
            keydown: function(e) {
                if (e.which === 32)
                return false;
            },
            change: function() {
                this.value = this.value.replace(/\s/g, "");
            }
        });
    }

    function eliminar(id) {
        swal({
            title: '¿Estás seguro?',
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Confirmar",   
            cancelButtonText: "Cancelar",
            }).then((confirm) => {

                if(confirm.hasOwnProperty('value')){
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url() ?>C_entregables/eliminarVariable", //Nombre del controlador
                        data: {id:id},
                        success: function(resp) {
                            remover(id)
                            console.log(resp)
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {

                        }
                    });
                } 
            });

    }

</script>
