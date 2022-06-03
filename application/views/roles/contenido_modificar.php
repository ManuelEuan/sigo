<div id="contenido_modulo" class="">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-10">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-light" type="submit" onclick="regresar()"><i class="mdi mdi-arrow-left">Regresar</i></button>
                    </div>
                </div>
                <br><br>
                <form class="needs-validation was-validated" onsubmit="modificarRol(this,event);">
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label for="validationCustom04">Rol</label>
                            <input class="form-control" id="validationCustom04" name="rol" required="" type="text" placeholder="Ingresar rol" value="<?= $consulta->vRol ?>">
                            <div class="invalid-feedback">
                                Este campo no puede estar vacio.
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <input type="hidden" value="<?= $consulta->iIdRol ?>" name='id' />
                    <center>
                    <button class="btn btn-success" type="submit">Guardar cambios</button>
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
    function modificarRol(f,e){
        e.preventDefault();

        $.ajax({         
            type: "POST",
            url: "<?=base_url()?>C_roles/update", //Nombre del controlador
            data: $(f).serialize(),

            success: function(resp) {
              if(resp > 0){
                
                regresar();
                alerta('Modificado exitosamente','success');

              } else {
                alerta('Error al Modificar','error');
              }

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              
            }
        });
    }
</script>