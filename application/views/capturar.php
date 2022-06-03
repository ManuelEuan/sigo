<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn waves-effect waves-light btn-light" onclick="regresar(event)"><i class="mdi mdi-arrow-left"></i>Regresar</button>
                </div>
            </div>
            <br><br>
            <form class="needs-validation was-validated" onsubmit="guardar(this,event);">
                <div class="form-row">
                    <div class="col-md-6">
                        <label for="validationCustom04">Nombre(s)</label>
                        <input class="form-control" id="validationCustom04" id="vNombre" name="vNombre" required="" type="text" value="<?= $vNombre ?>" maxlength="255">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="validationCustom04">Apellido paterno</label>
                        <input class="form-control" id="validationCustom04" id="vPrimerApellido" name="vPrimerApellido" required="" type="text" value="<?= $vPrimerApellido ?>" maxlength="255">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="validationCustom04">Apellido materno</label>
                        <input class="form-control" id="validationCustom04" id="vSegundoApellido" name="vSegundoApellido" required="" type="text" value="<?= $vSegundoApellido ?>" maxlength="255">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col">
                        <label for="dFechaNacimiento">Fecha de nacimiento</label>
                        <input class="form-control date-inputmask" id="dFechaNacimiento" name="dFechaNacimiento" required="" type="text" value="<?= $dFechaNacimiento ?>">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <?php if($iIdRegistro > 0){ ?>
                    <div class="col">
                        <label for="iEdad">Edad</label>
                        <input class="form-control" id="iEdad" name="iEdad" required="" type="text" value="<?= $iEdad ?>" maxlength="255" readonly>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <?php }?>
                    <div class="col">
                        <label for="vSexo">Sexo</label>
                        <select class="form-control" id="vSexo" name="vSexo" required="required">
                            <option value="">--Seleccione--</option>
                            <option value="Hombre" <?php if($vSexo == 'Hombre') echo 'selected'; ?>>Hombre</option>
                            <option value="Mujer" <?php if($vSexo == 'Mujer') echo 'selected'; ?>>Mujer</option>
                        </select>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col">
                        <label for="vOcupacion">Ocupación</label>
                        <input class="form-control" id="vOcupacion" name="vOcupacion" required="" type="text" value="<?= $vOcupacion ?>" maxlength="255">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <label for="iDiscapacidad">¿Tiene alguna discapacidad?</label>
                       <div class="custom-control custom-checkbox mr-sm-2 m-b-15">
                            <input type="checkbox" class="custom-control-input" id="iDiscapacidad" name="iDiscapacidad" value="1" <?php if($iDiscapacidad > 0) echo 'checked'; ?>>
                            <label class="custom-control-label" for="iDiscapacidad">Sí</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="iMayaHablante">¿Es mayahablante?</label>
                        <div class="custom-control custom-checkbox mr-sm-2 m-b-15">
                            <input type="checkbox" class="custom-control-input" id="iMayaHablante" name="iMayaHablante" value="1" <?php if($iMayaHablante > 0) echo 'checked'; ?>>
                            <label class="custom-control-label" for="iMayaHablante">Sí</label>
                        </div>
                    </div>
                </div>

                <legend>Dirección</legend>
                <small><span>Ejemplo de captura:</span>
                    <ul>
                        <li><b>Calle y número:</b>  CALLE 12 No. 664 X 25 B Y 25</li>
                        <li><b>Colonia:</b> FRACC. BENITO JUAREZ ORIENTE</li>
                        <li><b>Código postal:</b> 97170</li>
                    </ul>
                </small>
                <div class="form-row">
                    <div class="col-md-8">
                        <label for="vCalleNum">Calle y número</label>
                        <input type="text" class="form-control" id="vCalleNum" name="vCalleNum" aria-invalid="false" required=""  value="<?=$vCalleNum?>">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="vColonia">Colonia</label>
                        <input type="text" class="form-control" id="vColonia" name="vColonia" aria-invalid="false" required=""  value="<?=$vColonia?>">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-4">
                        <label for="vCP">Código postal</label>
                        <input type="text" class="form-control" id="vCP" name="vCP" aria-invalid="false" required=""  value="<?=$vCP?>">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="iIdMunicipio">Municipio</label>
                        <select class="form-control search" id="iIdMunicipio" name="iIdMunicipio" required="required">
                            <option value="">--Seleccione--</option>
                            <?=$options_municipio;?>
                        </select>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>
                <hr>

                <div class="form-row">
                    <div class="col-md-9">
                        <label for="vProgramaMef">¿Recibe algún programa MEF?¿Cual?</label>
                        <input class="form-control" id="vProgramaMef" name="vProgramaMef" required="" type="text" value="<?= $vProgramaMef ?>" maxlength="255">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                        
                    </div>
                    <div class="col-md-3">
                        <label for="iDependendientes">Dependientes económicos</label>
                        <input class="form-control" id="iDependendientes" name="iDependendientes" required="" type="number" value="<?= $iDependendientes ?>" maxlength="3">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                        
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12">
                        <label for="iIdProgramaCC">Programa interesado</label>
                        <select class="form-control search" id="iIdProgramaCC" name="iIdProgramaCC" required="required">
                            <option value="">--Seleccione--</option>
                            <?=$options_programacc; ?>                           
                        </select>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="col-md-12">
                        <label for="vProblemaWeb">Nombre del problema</label>
                        <input class="form-control" id="vProblemaWeb" name="vProblemaWeb" required="" type="text" value="<?= $vProblemaWeb ?>" maxlength="255">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>

                <div class="form-row">
                     <div class="col-md-12">
                        <label for="vProblemaEspecificar">Descripción el problema</label>
                        <textarea class="form-control" id="vProblemaEspecificar" name="vProblemaEspecificar" aria-invalid="false" required=""  cols="40" rows="5"><?=$vProblemaEspecificar?></textarea>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>
                
                <div class="form-row">                   
                    <div class="col-md-6">
                        <label for="vTurno">Turno</label>
                        <select class="form-control" id="vTurno" name="vTurno">
                            <option value="Matutino" <?php if($vTurno == 'Matutino') echo 'selected'; ?>>Matutino</option>
                            <option value="Vespertino" <?php if($vTurno == 'Vespertino') echo 'selected'; ?>>Vespertino</option>
                        </select>
                    <?php if($iIdRegistro == 0){ ?>
                        <input type="hidden" name="tiempo" id="tiempo" value="<?=$tiempo;?>">
                    <?php } ?>
                    </div>
                    <?php if($iIdRegistro > 0){ ?>
                    <div class="col-md-6">
                        <label for="tDuracionLlamada">Duración de la llamada</label>
                        <input class="form-control hour-inputmask" id="tDuracionLlamada" name="tDuracionLlamada" required="" type="text" value="<?= $tDuracionLlamada ?>" maxlength="255" readonly>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                <?php } ?>
                </div>

                <br>
                <input type="hidden" value="<?=$iIdRegistro ?>" name='iIdRegistro' />
                <center>
                    <button class="btn waves-effect waves-light btn-light" type="button" onclick="regresar(event);">Cancelar</button>&nbsp;&nbsp;
                    <button class="btn waves-effect waves-light btn-primary" type="submit">Guardar</button>
                </center>
            </form>
            <script>
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
            </script>
        </div>
    </div>
</div>
<script src="<?=base_url()?>public/assets/libs/inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
<!--<script src="<?=base_url()?>public/dist/js/pages/forms/mask/mask.init.js"></script>-->
<script>
    $(function(e) {
        "use strict";
        $(".date-inputmask").inputmask("dd-mm-yyyy"), 
        $(".hour-inputmask").inputmask("hh:mm:ss"), 
        $(".phone-inputmask").inputmask("(999) 999-9999"), 
        $(".international-inputmask").inputmask("+9(999)999-9999"), 
        $(".xphone-inputmask").inputmask("(999) 999-9999 / x999999"), 
        $(".purchase-inputmask").inputmask("aaaa 9999-****"), 
        $(".cc-inputmask").inputmask("9999 9999 9999 9999"), 
        $(".ssn-inputmask").inputmask("999-99-9999"), 
        $(".isbn-inputmask").inputmask("999-99-999-9999-9"), 
        $(".currency-inputmask").inputmask("$9999"), 
        $(".percentage-inputmask").inputmask("99%"), 
        $(".decimal-inputmask").inputmask({
            alias: "decimal"
            , radixPoint: "."
        }); 
        
        $(".search").select2();
    });

    function guardar(f, e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_registro_cc/guardar", //Nombre del controlador
            data: $(f).serialize(),
            success: function(resp) {
                if (resp == '0') {
                    regresar(e);                    
                    alerta('El registro ha sido guardado', 'success');

                } else {
                    alerta(resp, 'error');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {

            }
        });
    }

    function calcularEdad() {
        var FechaNacimiento = $("#dFechaNacimiento").val();
        var fechaNace = new Date(FechaNacimiento);
        var fechaActual = new Date()

        var mes = fechaActual.getMonth();
        var dia = fechaActual.getDate();
        var año = fechaActual.getFullYear();

        fechaActual.setDate(dia);
        fechaActual.setMonth(mes);
        fechaActual.setFullYear(año);

        edad = Math.floor(((fechaActual - fechaNace) / (1000 * 60 * 60 * 24) / 365));
       
        $("#iEdad").val(edad);
    }
</script>