<script>
$("#buscador_compromiso").hide();
</script>
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <h4 class="card-title">Nuevo compromiso</h4>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-light" type="submit" onclick="listar_compromiso()"><i
                            class="mdi mdi-arrow-left">Regresar</i></button>
                </div>
                <div class="col-md-12"><br></div>
            </div>

            <form class="needs-validation was-validated" onsubmit="guardarCompromiso(this,event);" id="frmCompromiso">
       <div class="row">
       <div class="col-md-8"></div>
                <div class="col-md-2">
                <button type="submit" class="btn btn-success btn-block" onclick="guardar_compromiso()">Guardar</button>
                </div>
                <div class="col-md-2">
                <button type="submit" class="btn btn-danger btn-block" onclick="agregar_compromiso()">Cancelar</button>
                </div>
       </div>
                <div class="form-row">
                    <div class="col-md-6">
                    <div>
                        <label class="form-inline">Numero:</label>
                        <input  class="form-control" name="iNumero" type="number" maxlength="4" required/>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div>
                        <label class="form-inline">Nombre corto:</label>
                        <input type="text" class="form-control" name="vNombreCorto" required />
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div>
                        <label class="form-inline">Nombre completo:</label>
                        <textarea class="form-control" name="vCompromiso" required></textarea>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div>
                        <label class="form-inline">Descripción:</label>
                        <textarea class="form-control" name="vDescripcion" required></textarea>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    </div>

                    <div class="col-6">
                        <label class="form-inline">Observaciones</label>
                        <div class="form-group">
                        <textarea cols="80" id="editor1" name="editor1" rows="5" data-sample="1" data-sample-short="" required></textarea>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-inline">Eje:</label>
                        <select class="form-control" onchange="buscarPolitica()" id="cboEje">
                        <option value="0">Todos</option>
                                        <?=$options_ejes;?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-inline">Política pública:</label>
                        <select class="form-control" name="iIdTema" id="iIdTema"  onchange="status_compromiso()>
                        <option value="0">Seleccione</option>
                        <?=$politica_publica;?>
                        </select>
                        <div class="invalid-feedback" id="status_politica_publica_text" style="display: none">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-inline">Estatus del compromiso:</label>
                        <select class="form-control" name="iEstatus" id="iEstatus" onchange="status_compromiso()">
                        <option value="0">Seleccione</option>
                        <?=$estatus;?>
                        </select>
                        <div class="invalid-feedback" id="status_compromiso_text" style="display: none">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                
                    <div class="col-md-6 ">
                        <label class="form-inline" >Dependencia responsable:</label>
                        <select class="form-control" name="iIdDependencia" id="iIdDependencia" onchange="status_compromiso()" >
                        <option value="0">Seleccione</option>
                        <?=$dependencias;?>
                        </select>
                        <div class="invalid-feedback" id="status_responsable_text" style="display: none">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-inline" >Dependencia corresponsable:</label>
                        <select   class="form-control js-example-basic-multiple"  multiple="multiple" id="iIdDependenciaCble">
                        <?=$dependencias;?>
                        </select>
                    </div>
                   
                
                </div>
            </form>
    </div>
</div>


<script>
function guardarCompromiso(f, e) {
    e.preventDefault();

    // $.ajax({         
    //     type: "POST",
    //     url: "<?=base_url()?>C_financiamientos/insert", //Nombre del controlador
    //     data: $(f).serialize(),

    //     success: function(resp) {
    //       if(resp > 0){

    //         buscarfinanciamiento();
    //         alerta('Guardado exitosamente','success');

    //       } else {
    //         alerta('Error al guardar','error');
    //       }

    //     },
    //     error: function(XMLHttpRequest, textStatus, errorThrown) {

    //     }
    // });
}
</script>


<!-- <script src="<?=base_url()?>public/assets/libs/ckeditor/ckeditor.js"></script> -->

<script>

//default
// initSample();

//inline editor
// We need to turn off the automatic editor creation first.
// CKEDITOR.disableAutoInline = true;

// CKEDITOR.inline('editor2', {
//     extraPlugins: 'sourcedialog',
//     removePlugins: 'sourcearea'
// });

var editor1 = CKEDITOR.replace('editor1', {
    extraAllowedContent: 'div',
    height: 164
});
// editor1.on('instanceReady', function() {
//     // Output self-closing tags the HTML4 way, like <br>.
//     this.dataProcessor.writer.selfClosingEnd = '>';

//     // Use line breaks for block elements, tables, and lists.
//     var dtd = CKEDITOR.dtd;
//     for (var e in CKEDITOR.tools.extend({}, dtd.$nonBodyContent, dtd.$block, dtd.$listItem, dtd
//             .$tableContent)) {
//         this.dataProcessor.writer.setRules(e, {
//             indent: true,
//             breakBeforeOpen: true,
//             breakAfterOpen: true,
//             breakBeforeClose: true,
//             breakAfterClose: true
//         });
//     }
    // Start in source mode.
//     this.setMode('source');
// });
</script>
<script>
    $('.js-example-basic-multiple').select2();
</script>

<script src="<?=base_url()?>public/dist/js/customs/ejes.js"></script>


<script>
function guardar_compromiso(){
    if($("#iIdTema").val()<=0 || $("#iEstatus").val()<=0  || $("#iIdDependencia").val<=0){
        alerta('Llene los campos correctamente','error');
        status_compromiso();
    }else{
        var observaciones= CKEDITOR.instances.editor1.getData();
    var data = $("#frmCompromiso").serializeArray();
    data.push({name: 'vObservaciones', value: `${observaciones}`});
    var iIdDependenciaCble=$("#iIdDependenciaCble").val();
    data.push({name: 'iIdDependenciaCble', value: `${iIdDependenciaCble}`});
    
    $.ajax({
            type: 'POST',
            //dataType: 'json',
            url: "<?= base_url() ?>C_compromisos/insertarCompromiso", //Nombre del controlador
            data: data,
            success: function( data ) {
               if(data=="correcto"){
                listar_compromiso();
                alerta('Guardado exitosamente','success');

               }else{
                alerta('Error en la comunicación','error');
               }
            }
        });

    }
   
}
</script>

<script>
	$('#iNumero').on('input', function () { 
    this.value = this.value.replace(/[^0-9]/g,'');
});
	</script>

<script>
	function status_compromiso(){
		if($("#iEstatus").val()<=0){
			$("#status_compromiso_text").show();
		}else{
			$("#status_compromiso_text").hide();
        }
        if($("#iIdDependencia").val()<=0){
            $("#status_responsable_text").show();

        }else{
            $("#status_responsable_text").hide();

		}
		if($("#iIdTema").val()<=0){
			$("#status_politica_publica_text").hide();

		}else{
			$("#status_politica_publica_text").hide();
		}
	}
	</script>
