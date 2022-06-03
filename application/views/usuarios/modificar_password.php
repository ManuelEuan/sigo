<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <h4 class="card-title">Cambiar contraseña</h4>
                </div>
                <div class="col-md-2 text-right">
                    <button class="btn waves-effect waves-light btn-outline-info" type="button" onclick="buscarUsuario(event);"><i class="mdi mdi-arrow-left"></i>Regresar</button>
                </div>
            </div>
            <br><br>
            <form class="needs-validation was-validated" onsubmit="modificarPassword(this,event);">
                <div class="form-row">
                    <div class="col-md-12 mb-12">
                        <label>Nueva contraseña<span class="text-danger">*</span></label>
                        <input type="password" id="contrasenia" name="newcontrasenia" class="form-control" placeholder="ingresar contraseña" required="">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-12">
                        <label>Confirmar nueva contraseña<span class="text-danger">*</span></label>
                        <input type="password" id="contrasenia" name="confcontrasenia" class="form-control" placeholder="ingresar contraseña" required="">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>
                <br><br>
                <input type="hidden" value="<?= $consulta->iIdUsuario ?>" name='id' />
                <center>
                    <button class="btn waves-effect waves-light btn-success" type="submit">Guardar cambios</button>
                    <button type="reset" class="btn waves-effect waves-light btn-inverse" onclick="regresar()">Cancelar</button>
                </center>
            </form>
        </div>
    </div>
</div>

<script>
    function modificarPassword(f, e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_usuarios/updatepass", //Nombre del controlador
            data: $(f).serialize(),

            success: function(resp) {
                if (resp == "correcto") {
                    buscarUsuario(e);
                    alerta('Los datos han sido guardados', 'success');

                }
                if(resp == "error_passnew"){
                    alerta('La confirmación de la contraseña no coincide con la nueva contraseña', 'warning');
                }
                if (resp == "error") {
                    alerta('Error al modificar', 'error');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {

            }
        });
    }
</script>