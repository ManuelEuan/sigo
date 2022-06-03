<div id="contenido_modulo" class="">
<div class="col-12">
                    <div class="card">
                        <div class="card-body">
                        <div align="right">
                                    <button type="button" class="btn waves-effect waves-light btn-light" onclick="filter()"><i class="mdi mdi-arrow-left">Regresar</i></button>
                                </div>
                            <form class="needs-validation was-validated" onsubmit="guardarUBP(this,event);">
                                <div class="form-row">                                    
                                    <div class="col-md-2">
                                        <label for="validationCustom01">Clave POA</label>
                                        <input type="text" class="form-control" id="claveUBP" name="Cubp" placeholder="Clave UBP" value="" required="" maxlength="5">
                                        <div class="valid-feedback">
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom02">Nombre del POA</label>
                                        <input type="text" class="form-control" id="nombUBP" name="NombUbp" placeholder="Nombre de la UBP" value="" required="">
                                        <div class="valid-feedback">
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="validationCustomUsername">Año</label>
                                        <input type="text" class="form-control" id="anio" name="annio" placeholder="Año" value="" required="" onkeypress="solonumeros(event);" maxlength="4">
                                        <div class="valid-feedback">
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="validationCustom03">Tipo POA</label>
                                        <div class="form-group">
                                            <select class="custom-select" required="" id="Tubp" name="TipoUBP">
                                                <option value="">Seleccione...</option>
                                                <?= $tipo_ubps ?>
                                            </select>
                                            <div class="valid-feedback"> </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="validationCustom04">Dependencia</label>
                                        <div class="form-group">
                                            <select class="custom-select" required="" name="Depen">
                                                <option value="">Seleccione...</option>
                                                <?= $dependencias ?>
                                            </select>
                                            <div class="valid-feedback"> </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Programa presupuestario (PP)</label>
                                        <div class="form-group">
                                            <select class="custom-select select2" required="required" name="ProgP">
                                                <option value="0">Seleccione...</option>
                                                <?= $PP ?>
                                            </select>
                                            <div class="valid-feedback"> </div>
                                        </div>
                                    </div>
                                </div>
                                <center>
                                    <button class="btn waves-effect waves-light btn-success" type="submit">Guardar</button>
                                </center>
                            </form>                            
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $(".select2").select2();
    });

    function UBP() {
        cargar('<?= base_url() ?>C_ubps/agregar', '#contenido_modulo');
    }
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

    function guardarUBP(f, e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_ubps/insertar",
            data: $(f).serialize(),

            success: function(resp) {
                if (resp > 0) {
                    filter(e);
                    alerta('Guardado exitosamente', 'success');
                } else {
                    alerta('Error al guardar', 'error');
                    //console.log(resp)
                }
            },
            error: function(XMLHHttRequest, textStatus, errorThrown) {

            }
        });
    }

    function solonumeros(e) {
        var key = window.event ? e.which : e.keyCode;
        if (key < 48 || key > 57)
            e.preventDefault();
    }
</script>