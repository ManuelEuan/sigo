<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <h4 class="card-title">Modificar usuario</h4>
                </div>
                <div class="col-md-2 text-right">
                    <button class="btn waves-effect waves-light btn-outline-info" type="button" onclick="buscarUsuario(event);""><i class="mdi mdi-arrow-left"></i>Regresar</button>
                </div>
            </div>
            <br><br>
            <form class="needs-validation was-validated" onsubmit="modificarUsuario(this,event);">
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <label for="validationCustom04">Dependencia<span class="text-danger">*</span></label>
                        <select id="dependencia" name="dependencia" required class="select2 form-control" style="width: 100% !important; height:36px !important;">
                            <?= $dependencias ?>
                        </select>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Rol<span class="text-danger">*</span></label>
                        <select name="rol" id="rol" required class="form-control">
                            <?= $roles ?>
                        </select>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Formación academica<span class="text-danger">*</span></label>
                        <select name="formacionacademica" id="formacionacademica" required class="select2 form-control" style="width: 100% !important; height:36px !important;">
                            <?= $formacion_academica ?>
                        </select>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Maximo nivel academico<span class="text-danger">*</span></label>
                        <select name="maxnivelacademico" id="maxnivelacademico" required class="form-control">
                            <option value="<?= $consulta->iIdMaxNivelAcademico ?>"><?= $consulta->vNivelAcademico ?></option>
                            <?= $nivel_academico ?>
                        </select>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <label>Nombre(s)<span class="text-danger">*</span></label>

                        <input type="text" id="nombre" name="nombre" class="form-control" required="" placeholder="Ingresar nombre" value="<?= $consulta->vNombre ?>">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Apellido paterno<span class="text-danger">*</span></label>
                        <input type="text" id="apepat" name="apepat" class="form-control" required="" placeholder="ingresar apellido" value="<?= $consulta->vPrimerApellido ?>">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Apellido materno<span class="text-danger">*</span></label>

                        <input type="text" id="apemat" name="apemat" class="form-control" required="" placeholder="ingresar apellido" value="<?= $consulta->vSegundoApellido ?>">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Cargo<span class="text-danger">*</span></label>
                        <input type="text" id="cargo" name="cargo" class="form-control" required="" placeholder="ingresar cargo" value="<?= $consulta->vCargo ?>">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <label>Correo institucional<span class="text-danger">*</span></label>
                        <input type="text" id="correoinst" name="correoinst" class="form-control" placeholder="usuario@ejemplo.com" value="<?= $consulta->vCorreo ?>">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Correo personal<span class="text-danger">*</span></label>
                        <input type="text" id="correopersonal" name="correopersonal" class="form-control" required="" placeholder="usuario@ejemplo.com" value="<?= $consulta->vCorreoPersonal ?>">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Telefono<span class="text-danger">*</span></label>
                        <input type="text" id="telefono" name="telefono" class="form-control phone-inputmask" id="phone-mask" placeholder="Ingresar número" required="" value="<?= $consulta->vTelefono ?>">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Celular<span class="text-danger">*</span></label>
                        <input type="text" id="celular" name="celular" class="form-control phone-inputmask" id="phone-mask" placeholder="Ingresar número" required="" value="<?= $consulta->vCelular ?>">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <label>Nombre de usuario<span class="text-danger">*</span></label>
                        <input type="text" id="nombreusuario" required="" name="nombreusuario" class="form-control" placeholder="nombre.apellido" value="<?= $consulta->vUsuario ?>">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Fecha de nacimiento<span class="text-danger">*</span></label>
                        <input type="date" id="fechanac" name="fechanc" class="form-control" required value="<?= $consulta->dFechaNacimiento ?>">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>
                <br><br>
                <input type="hidden" value="<?= $consulta->iIdUsuario ?>" name='id' />
                <center>
                    <button class="btn waves-effect waves-light btn-info" type="submit">Guardar cambios</button>
                    <button type="reset" class="btn waves-effect waves-light btn-inverse" onclick="regresar()">Cancelar</button>
                </center>
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
            </form>
        </div>
    </div>
</div>

<script src="<?php base_url() ?>public/assets/libs/inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
<script src="<?php base_url() ?>public/dist/js/pages/forms/mask/mask.init.js"></script>

<script type="text/javaScript">
    $(document).ready(function(){
        $(".select2").select2();
    });

    function modificarUsuario(f, e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_usuarios/update", //Nombre del controlador
            data: $(f).serialize(),

            success: function(resp) {

                if (resp == "correcto") {
                    buscarUsuario(e);
                    alerta('Los datos han sido guardados', 'success');

                }
                if (resp == "validar_usuario") {

                    alerta('El nombre de usuario ya se encuentra registrado en el sistema', 'warning');

                }
                if (resp == "validar_correo_inst") {

                    alerta('El correo institucional ya se encuentra registrado en el sistema', 'warning');

                }
                if (resp == "validar_correo_per") {

                    alerta('El correo personal ya se encuentra registrado en el sistema', 'warning');

                }
                if(resp == "error") {
                    
                    alerta('Error al modificar', 'error');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {

            }
        });
    }
</script>