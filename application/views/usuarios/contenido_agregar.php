<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <h4 class="card-title">Nuevo usuario</h4>
                </div>
                <div class="col-md-2 text-right">
                    <button class="btn waves-effect waves-light btn-outline-info" type="button" onclick="buscarUsuario(event);""><i class="mdi mdi-arrow-left"></i>Regresar</button>
                </div>
            </div>
            <br><br>
            <form class="needs-validation was-validated" onsubmit="guardarUsuario(this,event);">
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <label for="validationCustom04">Dependencia</label>
                        <select id="dependencia" name="dependencia" required class="select2 form-control" style="width: 100% !important; height:36px !important;">
                            <option value="">Seleccionar...</option>
                            <?= $dependencias ?>
                        </select>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Rol<span class="text-danger">*</span></label>
                        <select name="rol" id="rol" required class="form-control">
                            <option value="">Seleccionar...</option>
                            <?= $roles ?>
                        </select>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Formación academica<span class="text-danger">*</span></label>
                        <select name="formacionacademica" id="formacionacademica" required class="select2 form-control" style="width: 100% !important; height:36px !important;">
                            <option value="">Seleccionar...</option>
                            <?= $formacion_academica ?>
                        </select>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Maximo nivel academico<span class="text-danger">*</span></label>
                        <select name="maxnivelacademico" id="maxnivelacademico" required class="form-control">
                            <option value="">Seleccionar...</option>
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

                        <input type="text" id="nombre" name="nombre" class="form-control" required="" placeholder="Ingresar nombre">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Apellido paterno<span class="text-danger">*</span></label>
                        <input type="text" id="apepat" name="apepat" class="form-control" required="" placeholder="ingresar apellido">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Apellido materno<span class="text-danger">*</span></label>

                        <input type="text" id="apemat" name="apemat" class="form-control" required="" placeholder="ingresar apellido">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Cargo<span class="text-danger">*</span></label>
                        <input type="text" id="cargo" name="cargo" class="form-control" required="" placeholder="ingresar cargo">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <label>Correo institucional<span class="text-danger">*</span></label>
                        <input type="email" id="correoinst" name="correoinst" class="form-control" placeholder="usuario@ejemplo.com" required="">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Correo personal<span class="text-danger">*</span></label>
                        <input type="email" id="correopersonal" name="correopersonal" class="form-control" required="" placeholder="usuario@ejemplo.com" required="">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Telefono<span class="text-danger">*</span></label>
                        <input type="text" id="telefono" name="telefono" class="form-control phone-inputmask" id="phone-mask" placeholder="Ingresar número" required="">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Celular<span class="text-danger">*</span></label>
                        <input type="text" id="celular" name="celular" class="form-control phone-inputmask" id="phone-mask" placeholder="Ingresar número" required="">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <label>Nombre de usuario<span class="text-danger">*</span></label>
                        <input type="text" id="nombreusuario" required="" name="nombreusuario" class="form-control" placeholder="nombre.apellido">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Contraseña<span class="text-danger">*</span></label>
                        <input type="password" id="contrasenia" name="contrasenia" class="form-control" placeholder="ingresar contraseña" required="">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Confirmar contraseña<span class="text-danger">*</span></label>
                        <input type="password" name="confirmarcontrasenia" required="" data-validation-match-match="contrasenia" class="form-control" placeholder="confirmar contraseña">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Fecha de nacimiento<span class="text-danger">*</span></label>
                        <input type="date" id="fechanac" name="fechanc" class="form-control" required>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>
                    <center>
                        <button class="btn waves-effect waves-light btn-info" type="submit">Guardar</button>
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

    function guardarUsuario(f, e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_usuarios/insert", //Nombre del controlador
            data: $(f).serialize(),

            success: function(resp) {
                if (resp == "correcto") {
                    buscarUsuario(e);
                    alerta('Los datos han sido guardados', 'success');

                }
                if (resp == "validar_pass") {

                    alerta('La confirmación de su contraseña no coincide con la contraseña', 'warning');

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
                if (resp == "error") {

                    alerta('Error al guardar', 'error');
                }

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {

            }
        });
    }
</script>