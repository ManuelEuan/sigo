<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <h4 class="card-title">Nueva dependencia</h4>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-light" type="submit" onclick="filtrar(event)"><i class="mdi mdi-arrow-left">Regresar</i></button>
                </div>
            </div>
            <br><br>           
            <form class="needs-validation was-validated" onsubmit="guardarDependencia(this,event);">
                <div class="form-row">
                    <div class="col-12">
                        <label for="validationCustom04">Nombre corto</label>
                        <input class="form-control" id="validationCustom04" name="nombrecorto" required="" type="text" placeholder="Ingresar nombre corto">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="validationCustom04">Nombre completo</label>
                        <textarea class="form-control" id="textarea" name="dependencia" aria-invalid="false" required="" placeholder="Ingresar dependencia"></textarea>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-12">
                        <label for="validationCustom04">Alineación a eje del PED</label>
                        <select required="required" aria-invalid="false" class="select2 form-control" multiple="multiple" style="height: 36px;width: 100%;" name="ejes[]" id="ejes">
                            <?=$options_eje;?>
                        </select>  
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>                     
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-12">
                        <label for="">Área responsable</label>
                        <div class="row">
                            <div class="col-11">
                                <input class="form-control" type="text" id="areaResposable" name="areaResposable" placeholder="Ingresar el Área Responsable">
                            </div>
                            <div class="col-1">
                                <button type="button" style="background: none; border: thick;" id="agregarArea" name="agregarArea" onclick="guardarArea();"><i class="mdi mdi-plus-circle" style="font-size: 20px; color: #37BCD5;"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered display" style="width:100%" id="grid">
                                                <thead>
                                                    <tr>
                                                        <th width="50px">ID</th>
                                                        <th style="text-align: -webkit-center;">Nombre</th>
                                                        <th width="150px">Opciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="datosArea">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-12 text-center">
                        <button class="btn waves-effect waves-light btn-info" type="submit">Guardar</button>
                    </div>
                </div>
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
    $(document).ready(function(){
        $(".select2").select2();
    });

    var areaReponsableArray = []
    var contador = 0;
    var myArea = {};

    function guardarArea(){
        if($('#areaResposable').val() != ''){
            var id = areaReponsableArray.length + 1
            var nombreArea = $('#areaResposable').val()
            myArea.nombre = nombreArea
            myArea.id = id
            var tbody = '<tr class="rowArea'+id+'"><td>'+id+'</td> <td> <input class="form-control" id="TnombreArea" name="TnombreArea[]" type="hidden" placeholder="Ingresar el Área Responsable" value="'+nombreArea+'"> '+nombreArea+'<td><button class="remover" type="button" onclick="remover('+id+');" style="border: none; background: none;"><i class="mdi mdi-close-circle" style="font-size: larger; color: red;"></i></button></td></tr>'
            $('#datosArea').append(tbody)
            $('#areaResposable').val('')

            areaReponsableArray.push(myArea);
            myArea = {}
        }
    }

    function remover(id){
        areaReponsableArray = areaReponsableArray.filter(obj => obj.id != id)
        $(".rowArea"+id).remove();
    }

    function guardarDependencia(f,e){
        e.preventDefault();
        $.ajax({         
            type: "POST",
            url: "<?=base_url()?>C_dependencias/insert", //Nombre del controlador
            data: $(f).serialize(),

            success: function(resp) {
              if(resp > 0){
                filtrar(e);
                alerta('Guardado exitosamente','success');

              } else {
                alerta('Error al guardar','error');
              }
              console.log(resp)

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              
            }
        });
    }
</script>