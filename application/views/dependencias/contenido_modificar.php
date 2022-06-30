<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <h4 class="card-title">Modificar dependencia</h4>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-light" type="submit" onclick="filtrar(event)"><i class="mdi mdi-arrow-left">Regresar</i></button>
                </div>
            </div>
            <br><br>           
            <form class="needs-validation was-validated" onsubmit="modificarDependencia(this,event);">
                <div class="form-row">
                    <div class="col-12">
                        <label for="validationCustom04">Nombre corto</label>
                        <input class="form-control text-left" id="validationCustom04" name="nombrecorto" required="" type="text" placeholder="Ingresar clave" value="<?= $consulta->vNombreCorto ?>">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="validationCustom04">Dependencia</label>
                        <textarea class="form-control" id="textarea" name="dependencia" aria-invalid="false" required="" placeholder="Ingresar dependencia"><?= $consulta->vDependencia ?></textarea>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-12">
                        <input type="hidden" value="<?= $consulta->iIdDependencia ?>" name='id' />
                        <label for="validationCustom04">Alineación a eje del PED</label>
                        <select required="required" aria-invalid="false" class="select2 form-control" multiple="multiple" style="height: 36px;width: 100%;" name="ejes[]" id="ejes">
                            <?=$options_eje;?>
                        </select>  
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>                     
                    </div>
                </div><br>

                <div class="form-row">
                    <div class="col-12">
                        <label for="validationCustom04">Gasto de Orden</label>
                        <select class="form-control" name="gastoOrden" id="gastoOrden" required>
                            <option value="">--Selecccione--</option>
                            <option value="Social" <?php if($consulta->vGastoOrden == 'Social') echo 'selected'; ?> >Social</option>
                            <option value="Administrativo" <?php if($consulta->vGastoOrden == 'Administrativo') echo 'selected'; ?> >Administrativo</option>
                        </select> 
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>                     
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-12">
                        <label for="validationCustom04">Grupo de Programa</label>
                        <select class="form-control" name="grupoPrograma" id="grupoPrograma" required>
                            <option value="">--Selecccione--</option>
                            <option value="Desempeño de las Funciones" <?php if($consulta->vGrupoPrograma == 'Desempeño de las Funciones') echo 'selected'; ?>>Desempeño de las Funciones</option>
                        </select> 
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>                     
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-12">
                        <label for="validationCustom04">Grupo de Gasto</label>
                        <select class="form-control" name="grupoGasto" id="grupoGasto" required>
                            <option value="">--Selecccione--</option>
                            <option value="Programable" <?php if($consulta->vGrupoGasto == 'Programable') echo 'selected'; ?>>Programable</option>
                        </select> 
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>                     
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-12">
                        <label for="validationCustom04">Modalidad</label>
                        <select class="form-control" name="modalidad" id="modalidad" required>
                            <option value="">--Selecccione--</option>
                            <option value="B - Procesión de bienes públicos" <?php if($consulta->vModalidad == 'B - Procesión de bienes públicos') echo 'selected'; ?>>B - Procesión de bienes públicos</option>
                            <option value="E - Presentación de servicios públicos" <?php if($consulta->vModalidad == 'E - Presentación de servicios públicos') echo 'selected'; ?>>E - Presentación de servicios públicos</option>
                            <option value="F - Programación y fomento" <?php if($consulta->vModalidad == 'F - Programación y fomento') echo 'selected'; ?>>F - Programación y fomento</option>
                            <option value="G - Regulación y supervisión" <?php if($consulta->vModalidad == 'G - Regulación y supervisión') echo 'selected'; ?>>G - Regulación y supervisión </option>
                            <option value="P - Planeación, formulación, implementación, seguimiento y evaluación de políticas públicas" <?php if($consulta->vModalidad == 'P - Planeación, formulación, implementación, seguimiento y evaluación de políticas públicas') echo 'selected'; ?>>P - Planeación, formulación, implementación, seguimiento y evaluación de políticas públicas</option>
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
                                                    <?php foreach($areasResponsables as $key => $row){ ?>
                                                        <tr class="rowArea<?= $row->iIdAreaResponsable?>">
                                                            <td><?= $key+1?></td>
                                                            <td><?= $row->vAreaResponsable?></td>
                                                            <td><button class="remover" type="button" onclick="deleteArea(<?= $row->iIdAreaResponsable?>)" style="border: none; background: none;"><i class="mdi mdi-close-circle" style="font-size: larger; color: red;"></i></button></td>
                                                        </tr>
                                                    <?php } ?>
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

    function deleteArea(id){

        swal({
            title: '¿Estás seguro?',
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Confirmar",   
            cancelButtonText: "Cancelar",
            }).then((confirm) => {

                if(confirm.hasOwnProperty('value')){
                    remover(id)
                    $.ajax({

                    type: "POST",
                    url: "<?=base_url()?>C_dependencias/deleteArea", //Nombre del controlador
                    data: {id:id},

                    success: function(resp) {
                        
                        alerta('Eliminado exitosamente','success');  
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                    
                    }

                })
                } 
            });

    }

    function modificarDependencia(f,e){
        e.preventDefault();

        $.ajax({         
            type: "POST",
            url: "<?=base_url()?>C_dependencias/update", //Nombre del controlador
            data: $(f).serialize(),

            success: function(resp) {
                if(resp == true){
                filtrar(e);
               
                alerta('Modificado exitosamente','success');  

              } else {
                alerta('Error al modificar','error');
              }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              
            }
        });
    }
</script>