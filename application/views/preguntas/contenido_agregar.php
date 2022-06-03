<script>
$("#buscador_preguntas").hide();
</script>
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <h4 class="card-title">Nueva pregunta</h4>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-light" type="submit" onclick="carga_preguntas()"><i
                            class="mdi mdi-arrow-left">Regresar</i></button>
                </div>
                <div class="col-md-12"><br></div>
            </div>

            <form class="needs-validation was-validated" id="frmPregunta">
                <div class="row">
                   <div class="col-md-8"></div>
                        <div class="col-md-2">
                        <button type="button" class="btn btn-info btn-block" onclick="guardar_pregunta()">Guardar</button>
                        </div>
                        <div class="col-md-2">
                        <button type="submit" class="btn btn-danger btn-block" onclick="agregar_pregunta()">Cancelar</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12"><h6 class="card-subtitle"><strong>Nota:</strong>Todos los campos marcados con <code>*</code> son <code>obligatorios</code>.</h6></div>
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <div>
                            <label class="form-inline">Pregunta:<code>*</code></label>
                            <textarea class="form-control" name="vPregunta" required></textarea>
                            <div class="invalid-feedback">
                                Este campo no puede estar vacio.
                            </div>
                        </div>
                        
                    </div>

                    <div class="col-6">
                        <div>
                            <label class="form-inline">Respuesta:</label>
                            <textarea class="form-control" name="vRespuesta"></textarea>
                            <div class="invalid-feedback">
                                Este campo no puede estar vacio.
                            </div>                            
                        </div>

                    </div>
                    <div class="col-md-3">
                        <label class="form-inline">Eje:<code>*</code></label>                        
                        <select required class="form-control custom-select" onchange="buscar_select(this.value, 1);" id="iIdEje" name="iIdEje"style="width: 100%; height:36px;">
                        <option value="">Todos</option>
                            <?=$ejes;?>
                        </select>
                        <div class="invalid-feedback">
                                Este campo no puede estar vacio.
                            </div> 
                    </div>
                    <div class="col-md-3">
                        <label class="form-inline">Política pública:<code>*</code></label>                        
                        <select required name="iIdTema" id="iIdTema"  onchange="buscar_select(this.value, 2);" class="form-control custom-select" style="width: 100%; height:36px;">
                        <option value="0">Seleccione</option>                        
                        </select>
                        <div class="invalid-feedback" id="status_politica_publica_text" style="display: none">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-inline">Objetivo:</label>                        
                        <select name="iIdObjetivo" id="iIdObjetivo" class="form-control custom-select" style="width: 100%; height:36px;">
                        <option value="0">Seleccione</option>                        
                        </select>
                        <div class="invalid-feedback" id="status_politica_publica_text" style="display: none">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-inline">Partido:</label>                        
                        <select name="partido" id="partido" class="form-control custom-select" style="width: 100%; height:36px;">
                            <option value="0">Seleccione</option>
                            <option value="PAN">PAN</option>
                            <option value="PRI">PRI</option>
                            <option value="PRD">PRD</option>
                            <option value="PVEM">PVEM</option>
                            <option value="PANAL">PANAL</option>
                            <option value="MORENA">MORENA</option>
                        </select>
                        <div class="invalid-feedback" id="status_politica_publica_text" style="display: none">
                            Este campo no puede estar vacio.
                        </div>
                    </div>

                    <div class="col-md-3">                        
                        
                        <label class="form-inline">Año:<code>*</code></label>
                        <input  class="form-control" name="anio" type="number" maxlength="4" required/>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>                             
                    </div>
                </div>
            </form>
    </div>
</div>


<script src="<?=base_url()?>public/dist/js/customs/ejes.js"></script>


<script>    

    function buscar_select(id, op) {
        $.post('<?=base_url();?>C_preguntas/carga_sel', {id:id, op:op}, function(resp) {
            if(resp!="error") {
                if(op==1){
                    $('#iIdTema').html(resp);
                    $('#iIdObjetivo').html('<option value="0">Seleccione</option>');                    
                }
                else if(op==2)
                    $('#iIdObjetivo').html(resp);                
            }
            else alerta('Error al cargar el selector','error');        
        });
    }    


    function guardar_pregunta(){
        if($("#iIdTema").val()<=0 || $("#iIdEje").val()<=0  || $("#iIdObjetivo").val<=0 ||  $("#partido").val<=0){
            alerta('Llene los campos correctamente','error');        
        }
        else {
            
        var form = $("#frmPregunta").serialize();    
        
        $.ajax({
                type: 'POST',
                //dataType: 'json',
                url: "<?=base_url();?>C_preguntas/inserta_pregunta", //Nombre del controlador
                data: form,
                success: function(resp) {                    
                   if(resp=="correcto") {              
                    alerta('Guardado exitosamente','success');
                    carga_preguntas();
                   } else{
                    alerta('Error al insertar la pregunta','error');
                   }
                }
            });

        }
    }    
</script>