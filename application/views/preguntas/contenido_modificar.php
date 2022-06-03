<script>
$("#buscador_preguntas").hide();
</script>
<div class="col-12">    
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <h4 class="card-title">Modificar pregunta</h4>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-light" type="submit" onclick="carga_preguntas()"><i
                            class="mdi mdi-arrow-left">Regresar</i></button>
                </div>
                <div class="col-md-12"><br></div>
            </div>
            <?php 
                if($datosPreg!=false)
                {                                        
                    $vPregunta = $datosPreg[0]->vPregunta;
                    $anio = $datosPreg[0]->iAnio;
                    $vRespuesta = $datosPreg[0]->vRespuesta;
                    $ban = $datosPreg[0]->vBancada;
                    $ruta = $datosPreg[0]->vRuta;
                }
                else 
                {                    
                    $vPregunta = "";
                    $anio = "";
                    $vRespuesta = "";
                    $ban = '';
                    $ruta = '';
                }       
            ?>
            <form class="needs-validation was-validated" id="frmPregunta">
                <input type="hidden" id="iIdPregunta" name="iIdPregunta" value="<?=$iIdPregunta;?>">     
                <div class="row">
                   <div class="col-md-8"></div>
                        <div class="col-md-2">
                        <button type="button" class="btn btn-info btn-block" onclick="actualizar_pregunta()">Guardar</button>
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
                            <textarea class="form-control" name="vPregunta" required><?=$vPregunta;?></textarea>
                            <div class="invalid-feedback">
                                Este campo no puede estar vacio.
                            </div>
                        </div>
                        
                    </div>

                    <div class="col-6">
                        <div>
                            <label class="form-inline">Respuesta:<code>*</code></label>
                            <textarea class="form-control" name="vRespuesta"><?=$vRespuesta;?></textarea>
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
                        <option value="">Seleccione</option>     
                        <?=$politica_publica;?>
                        </select>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-inline">Objetivo:</label>                        
                        <select name="iIdObjetivo" id="iIdObjetivo" class="form-control custom-select" style="width: 100%; height:36px;">
                        <option value="0">Seleccione</option>
                        <?=$objetivos;?>                      
                        </select>
                        <div class="invalid-feedback" id="status_politica_publica_text" style="display: none">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-inline">Partido:</label>                        
                        <select name="partido" id="partido" class="form-control custom-select" style="width: 100%; height:36px;">
                            <option value="0">Seleccione</option>
                            <option <?php echo ($ban == 'PAN') ? 'selected' : '' ;?> value="PAN">PAN</option>
                            <option <?php echo ($ban == 'PRI') ? 'selected' : '' ;?> value="PRI">PRI</option>
                            <option <?php echo ($ban == 'PRD') ? 'selected' : '' ;?> value="PRD">PRD</option>
                            <option <?php echo ($ban == 'PVEM') ? 'selected' : '' ;?> value="PVEM">PVEM</option>
                            <option <?php echo ($ban == 'PANAL') ? 'selected' : '' ;?> value="PANAL">PANAL</option>
                            <option <?php echo ($ban == 'MORENA') ? 'selected' : '' ;?> value="MORENA">MORENA</option>                    
                        </select>
                        <div class="invalid-feedback" id="status_politica_publica_text" style="display: none">
                            Este campo no puede estar vacio.
                        </div>
                    </div>

                    <div class="col-md-3">                        
                        
                        <label class="form-inline">Año:<code>*</code></label>
                        <input  class="form-control" name="anio" type="number" maxlength="4" value="<?=$anio;?>" required/>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>                             
                    </div>

                    <div class="col-md-3">
                        <label class="form-inline">Responsable:</label>                        
                        <select name="responsable" id="responsable" class="form-control custom-select" style="width: 100%; height:36px;">
                        <option value="0">Seleccione</option>
                        <?=$dep_resp;?>
                        </select>
                        <div class="invalid-feedback" id="status_politica_publica_text" style="display: none">
                            Este campo no puede estar vacio.
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-inline">Corresponsable:</label>                        
                        <select name="corresponsable" id="corresponsable" class="form-control custom-select" style="width: 100%; height:36px;">
                        <option value="0">Seleccione</option>
                        <?=$dep_corresp;?>
                        </select>
                        <div class="invalid-feedback" id="status_politica_publica_text" style="display: none">
                            Este campo no puede estar vacio.
                        </div>
                    </div>                    
                </div>
            </form>

            <div class="row">
                <div class="col-10">                
                <p>Documento en formato PDF</p>
                <?php 
                if($ruta!='')
                {
                    echo'
                        <form method="POST" enctype="multipart/form-data" id="input-type">                            
                            <a href="'.base_url().'archivos/preguntasPDF/'.$ruta.'" target="_blank">Ver documento</a>                            
                        </form></div>
                            
                        <div class="col-md-2" style="margin-top: auto;">
                            <button class="btn btn-warning btn-block" type="button" onclick="eliminar_doc()"><i
                            class="mdi mdi-delete-sweep">Eliminar</i></button>
                        </div>
                    ';
                }
                elseif($ruta=='')
                {
                    echo '
                        <form method="POST" enctype="multipart/form-data" id="input-type">
                            <input type="file" class="form-control" id="files" name="files" onchange="validaInputFile(this);">               
                            <input type="text" name="pregid" style="display: none" value="'.$iIdPregunta.'">
                        </form></div>
                        <div class="col-md-2" style="margin-top: auto;">
                            <input type="submit" id="subir" value="Subir" class="btn btn-success btn-block" onclick="subir_doc();">
                        </div>
                    ';
                }
                ?>
                
            </div>
</div>


<script src="<?=base_url()?>public/dist/js/customs/ejes.js"></script>


<script>    

    function buscar_select(id, op) {
        $.post('<?=base_url();?>C_preguntas/carga_sel', {id:id, op:op}, function(resp) {
            if(resp!="error") {
                if(op==1){
                    $('#iIdTema').html(resp);
                    $('#iIdObjetivo').html('<option value="">Seleccione</option>');                    
                }
                else if(op==2)
                    $('#iIdObjetivo').html(resp);                
            }
            else alerta('Error al cargar el selector','error');        
        });
    }

    function validaInputFile(element){
        if($(element)[0].files[0] != undefined){
            if($(element)[0].files[0].size/1024 < 3082){
                var fileName = $(element).val().split("\\").pop();
                $(element).siblings(".custom-file-label").addClass("selected").html(fileName);        
            } else{
                $(element).val('');
                alerta('El archivo seleccionado superada el tamaño permitido','error');
            }
        }else {
            $(element).val('');
        }
    }

   /*function validar_doc() {
        var form = $('#input-type')[0];
        var data = new FormData(form);

        $.ajax({
            beforeSend: function() {
                alerta('Espere un momento verificando archivos', 'warning');
            },
            type: "POST",
            url: "<?=base_url()?>C_preguntas/validar_doc",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                resp = JSON.parse(data);                
                if (!data.error) {
                    alerta('Archivos aceptados para subir', 'success');
                    $('#subir').removeAttr("disabled");
                    $('#subir').attr("onclick", "subir_doc()");
                } else {
                    alerta(data.message, 'error');
                    $('#subir').removeAttr("onclick");
                    $('#subir').attr("disabled", "disabled");
                    $("#files").val("");

                }
            }
        });
    }*/

    function subir_doc() {
               
        var form = $('#input-type')[0];
        var data = new FormData(form);
        $.ajax({
            type: "POST",
            url: "<?=base_url()?>C_preguntas/subir_doc",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data == "correcto") {
                    alerta('Archivo subido correctamente', 'success');
                    $('#subir').removeAttr("onclick");
                    $('#subir').attr("disabled", "disabled");
                    $("#files").val("");
                    var id = $('#iIdPregunta').val();
                    modificar_pregunta(id);
                } else {
                    alerta('Error en la subida de archivos', 'error');
                }
            }
        });
    }  

    function eliminar_doc() {
        var pregid = $('#iIdPregunta').val();
        $.post('<?=base_url();?>C_preguntas/eliminar_doc', {pregid: pregid}, function(resp){
            console.log(resp);
            if(resp=="correcto") 
            {
                alerta('Archivo eliminado correctamente', 'success');
                modificar_pregunta(pregid);
            }
            else alerta('Error al eliminar el documento', 'danger');
        });  
    }


    function actualizar_pregunta(){
        if($("#iIdTema").val()<=0 || $("#iIdEje").val()<=0  || $("#iIdObjetivo").val<=0 ||  $("#partido").val<=0){
            alerta('Llene los campos correctamente','error');        
        }
        else {
            
        var form = $("#frmPregunta").serialize();    
        
        $.ajax({
            type: 'POST',
            //dataType: 'json',
            url: "<?=base_url();?>C_preguntas/actualizar_pregunta", //Nombre del controlador
            data: form,
            success: function(resp) {                    
               if(resp=="correcto"){                
                alerta('Guardado exitosamente','success');
                carga_preguntas();

               }else{
                alerta('Error al insertar la pregunta','error');
               }
            }
        });

        }
    }
</script>