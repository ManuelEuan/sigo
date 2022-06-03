<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <h4 class="card-title">Modificar fuente de financiamiento</h4>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn waves-effect waves-light btn-light" onclick="buscarfinanciamiento2()"><i class="mdi mdi-arrow-left">Regresar</i></button>
                </div>
            </div>
            <br><br>
            <form class="needs-validation was-validated" onsubmit="modificarFinanciamiento(this,event);">
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <label for="validationCustom04">Clave</label>
                        <input class="form-control" id="validationCustom04" name="clave" required="" type="text" placeholder="Ingresar clave" value="<?= $consulta->vClave ?>" maxlength="5">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="validationCustom04">Año</label>
                        <input class="form-control" id="validationCustom04" name="anio" required="" type="text" placeholder="Ingresar año" value="<?= $consulta->iAnio ?>" onkeypress="solonumeros(event);" maxlength="4">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3 mb-6">
                    <label for="validationCustom04">Fuente de financiamiento</label>
                    <textarea class="form-control" id="textarea" name="financiamiento" aria-invalid="false" required="" placeholder="Ingresar fuente de financiamiento" cols="40" rows="5" style="resize: both; margin: 0px -246px 0px 0px; width: 520px; height: 128px;"><?= $consulta->vFinanciamiento ?></textarea>
                    <div class="invalid-feedback">
                        Este campo no puede estar vacio.
                    </div>
                </div>
                </div>
                <br>
                <input type="hidden" value="<?= $consulta->iIdFinanciamiento ?>" name='id' />
                <center>
                    <button class="btn waves-effect waves-light btn-success" type="submit">Guardar</button>
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

<script>
    function modificarFinanciamiento(f, e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_financiamientos/update", //Nombre del controlador
            data: $(f).serialize(),

            success: function(resp) {
                if (resp == true) {

                    buscarfinanciamiento2();
                    alerta('Modificado exitosamente', 'success');

                } else {
                    alerta('Error al modificar', 'error');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {

            }
        });
    }

    function solonumeros(e) {
        var key = window.event ? e.which : e.keyCode;
        if (key < 48 || key > 57)
            e.preventDefault();
    }
</script>