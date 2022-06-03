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
            
            <form class="needs-validation was-validated" onsubmit="guardarDetalles(this,event);">
                <div class="form-row">
                    <legend>Datos generales</legend>
                    <div class="col-md-10 mb-10">
                        <label for="validationCustom04">Nombre de la actividad</label>
                        <input class="form-control input-lectura" id="validationCustom04" name="NombAct" required="" type="text" placeholder="" value="<?=htmlspecialchars($consulta->vActividad)?>">
                        <input id="idAct" name="idAct" type="hidden" value="<?= $consulta->iIdActividad ?>">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="validationCustom04">Año</label>
                        <input readonly="readonly" class="form-control input-number" id="validationCustom04" name="annio" required="" type="text" placeholder="" maxlength="4" value="<?= $consulta->iAnio ?>">
                        <input id="id" name="id" type="hidden" value="<?= $consulta->iIdDetalleActividad ?>">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12 mb-2">
                        <label for="validationCustom04">Nombre para la tabla del anexo</label>
                        <input class="form-control input-lectura"  name="vNombreActividad" type="text" placeholder="" value="<?=htmlspecialchars($consulta->vNombreActividad)?>">
                    </div>
                </div>

                <div class="form-row">
                    <!--<div class="col-md-6 mb-6">-->
                       <!-- <label for="objGeneral">Objetivo General</label>-->
                       <!-- <textarea class="form-control input-lectura" id="objGeneral" name="objGeneral" aria-invalid="false" required="" placeholder="" cols="40" rows="5" style=""><?=htmlspecialchars($consulta->vObjetivo)?></textarea>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                        <div class="valid-feedback"> </div>-->
                   <!-- </div>-->
                    <div class="col-md-12 mb-2">
                        <input type="hidden" class="form-control input-lectura" maxlength="255" id="objGeneral" name="objGeneral" value=".">
                       
                        <label for="descripcion">Descripción</label>
                        
                        <textarea class="form-control input-lectura" id="descripcion" name="descripcion" aria-invalid="false" required="" placeholder="" cols="40" rows="5" style=""><?=htmlspecialchars($consulta->vDescripcion)?></textarea>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                        <div class="valid-feedback"> </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6 mb-6">
                        <label for="validationCustom04">Fecha de inicio</label>
                        <input type="date" class="form-control input-lectura" id="fINICIO" name="fINICIO" required="" value="<?= $consulta->dInicio ?>">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-6 mb-6">
                        <label for="validationCustom04">Fecha fin</label>
                        <input type="date" class="form-control input-lectura" id="fFIN" name="fFIN" required="" value="<?= $consulta->dFin ?>">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>
                <?php if(isset($ejes) && isset($dependencias)){ ?>
                <div class="form-row">
                    <div class="col-md-6 mb-6">
                        <label for="validationCustom04">Eje Rector</label>
                        <select class="custom-select select-lectura" name="ejeAct" id="ejeAct" onchange="cargarOptions('dependencias_act',this);">
                            <?=$ejes?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-6">
                        <label for="validationCustom04">Dependencia responsable</label>
                        <select class="form-control select-lectura" aria-invalid="false" name="depAct" id="depAct" required="">
                            <option value="0">--Seleccione--</option>
                            <?=$dependencias?>
                        </select>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>
                <?php } ?>

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
                                    <div class="col-sm-6">
                                        <label for="validationCustom04">Presupuesto Autorizado por la Secretaría de Finanzas </label>
                                        <input align='right' class="input-lectura form-control" id="nPresupuestoAutorizado" name="nPresupuestoAutorizado" type="text" value="<?=DecimalMoneda($consulta->nPresupuestoAutorizado); ?>" onKeypress="return onlyDigits(event,'decOK');" maxlength="20" onblur="moneyFormat(this.id);">
                                    </div>
                                    <div class="col-sm-6">
                                       <!-- <label for="validationCustom04">Presupuesto modificado</label>-->
                                        <!--
                                        <input align='right' class="input-lectura form-control" id="nPresupuestoModificado" name="nPresupuestoModificado" type="text" value="<?=DecimalMoneda($consulta->nPresupuestoModificado); ?>" onKeypress="return onlyDigits(event,'decOK');" maxlength="20" onblur="moneyFormat(this.id);">
                                                -->
                                         <input type="hidden" class="form-control input-lectura" maxlength="255" id="nPresupuestoModificado" name="nPresupuestoModificado" value="0">
                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>

                <div class="form-row">
                    <legend>Alineación al P.E.D</legend>
                    <div class="col-md-6">
                        <label for="validationCustom04">Eje</label>
                        <div class="form-group">
                            <select class="custom-select select-lectura" required="" name="eje" id="eje" onchange="cargarPpublica()">
                                <option value="0">Seleccione...</option>
                                <?php foreach ($eje as $value) { ?>
                                    <option value="<?php echo $value->iIdEje ?>"><?= $value->vEje ?></option>
                                <?php } ?>
                            </select>
                            <div class="valid-feedback"> </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="validationCustom04">Política pública</label>
                        <div class="form-group">
                            <select class="custom-select select-lectura" <?= $requerido ?> name="polipub" id="polipub" onchange="cargarObjetivo()">

                            </select>
                            <div class="valid-feedback"> </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="validationCustom04">Objetivo</label>
                        <div class="form-group">
                            <select class="custom-select select-lectura" <?= $requerido ?> name="objetivo" id="objetivo" onchange="cargarEstrategia()">

                            </select>
                            <div class="valid-feedback"> </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="validationCustom04">Estrategia</label>
                        <div class="form-group">
                            <select class="custom-select select-lectura" <?= $requerido ?> name="estrategia" id="estrategia" onchange="cargarLineaAccion()">

                            </select>
                            <div class="valid-feedback"> </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <label for="validationCustom04">Línea de acción</label>
                        <div class="form-group">
                            <select class="custom-select select-lectura" <?= $requerido ?> name="linAcc" id="linAcc">

                            </select>
                            <div class="valid-feedback"> </div>
                        </div>
                    </div>
                    <div class="col-md-4" style="margin-top: 30px;">
                        <button type="button" class="btn-lectura btn waves-effect waves-light btn-primary" onclick="agregarLA()">+ Agregar</button>
                    </div>
                </div>
                
                <div class="content">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive" id="tabla-grid3">
                                        <small>Las alineaciones marcadas con <i class="fas fa-check text-success"></i> no pueden ser eliminadas debido a que cuentan con texto para el informe capturado. Para desvincular primero elimine estos textos.</small>
                                        <table class="table table-striped table-bordered" id="table3">
                                            <thead>
                                                <th>Eje</th>
                                                <th>P. Pública</th>
                                                <th>Objetivo</th>
                                                <th>Estrategia</th>
                                                <th>Línea de acción</th>
                                                <th>ODS</th>
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
                                                    <td>'.$row->vOds.'</td>
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
                    
                    <br><br>
                    <center>
                        <button title="Ir a listado del PAT" class="btn btn-lg waves-effect waves-light btn-outline-info" type="submit" onclick="filtrar(event)"><i class="mdi mdi-arrow-left"></i>Regresar</button>&nbsp;&nbsp;
                        <button class="btn-lectura btn btn-lg btn-info" type="submit">Guardar</button>
                    </center>
            </form>
        </div>
    </div>
</div>


<input type="text" value="<?= base_url(); ?>" id="url" style="display: none">
<script src="<?= base_url() ?>/assets/jquery.maskMoney.js"></script>
<script>
    var isIE = document.all?true:false;
    var isNS = document.layers?true:false;

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
        <?php
        }
        ?>
        $(".select2").select2();
        url = $("#url").val();
        sumaMontoFin();
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
        var inicio = document.getElementById('fINICIO').value;
        var fin = document.getElementById('fFIN').value;
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_pat/guardarAct",
            data: $(f).serialize()+'&contLA='+contLA,
            success: function(resp) {
                if(fin < inicio){
                    alerta('La fecha final debe ser mayor que la fecha inicial y viceversa', 'warning');
                }
                else if(inicio < fin){
                    if (resp == 'Correcto') {
                    //filtrar(e);
                    alerta('Guardado exitosamente', 'success');
                    } else {
                        alerta('Error al guardar', 'error');
                        //alert(resp);
                    }
                }
            },
            error: function(XMLHHttRequest, textStatus, errorThrown) {}
        });
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
</script>