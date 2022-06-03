<div id="contenido_modulo" class="">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <?php if(!$modal){ ?>
                <div class="row">
                    <div class="col-md-10">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-light" type="submit" onclick="filter2()"><i class="mdi mdi-arrow-left"></i> Regresar</button>
                    </div>
                </div>
                <br><br>
                <?php }?>
                <form class="needs-validation was-validated" onsubmit="guardarUM(this,event);">
                    <div class="form-row">
                        <div class="col-md-12 mb-2">
                            <label for="validationCustom04">Unidad de medida</label>
                            <input class="form-control" id="NombUm" name="NombUm" required="" type="text" placeholder="Ingresar unidad de medida">
                            <div class="invalid-feedback">
                                Este campo no puede estar vacio.
                            </div>
                        </div>
                    </div>
                    <center>
                    <button class="btn btn-info" type="submit">Guardar</button>
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
</div>

<script>
    $(document).ready(function(){
        $("#NombUm").focus();
    });

    function guardarUM(f, e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_unidadesmedida/insertar",
            data: $(f).serialize(),
            success: function(resp) {
                <?php if($modal) { ?>
                    optionSelected = parseInt(resp);
                    refreshSelect2();
                <?php } else {?>
                if (resp > 0) {
                    filter();
                    alerta('Guardado exitosamente','success');
                } else {
                    alerta('Error al guardar','error');
                }
                <?php } ?>
            },
            error: function(XMLHHttRequest, textStatus, errorThrown) {

            }
        });
    }
</script>