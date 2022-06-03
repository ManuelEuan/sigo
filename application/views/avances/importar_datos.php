<!--
<div class="col-12">    
    <form id="formuploadajax" enctype="multipart/form-data" method="POST">
        <div class="row">
            <div class="col-8"></div>
            <div class="col-4 text-right">
                 <a class="btn btn-rounded btn-block btn-light" style="cursor:pointer; color:blue;"  href="<?=base_url();?>public/files/FormatoAvancesMunicipales.xlsx" id="descarga"><i class="m-r-10 mdi mdi-download"></i>Descargar formato de avances</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="validationCustom04">Mes de corte<b class="text-danger">*</b></label>
                <select id="mescorte" name="mes_corte" class="form-control" onchange="mostrarelementos()">
                    <option value="">Seleccionar...</option>
                    <option value="01">Enero</option>
                    <option value="02">Febrero</option>
                    <option value="03">Marzo</option>
                    <option value="04">Abril</option>
                    <option value="05">Mayo</option>
                    <option value="06">Junio</option>
                    <option value="07">Julio</option>
                    <option value="08">Agosto</option>
                    <option value="09">Septiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12">Diciembre</option>
                </select>
                <div class="invalid-feedback">
                    Este campo no puede estar vacio.
                </div>
            </div>
            <div class="col-md-5 mb-5" style="margin-top: 30px;">
                <input disabled="true" type="file" id="idFiles" name="file" value="seleccione un archivo" class="">
            </div>
            <div class="col-md-4 mb-4" style="margin-top: 30px;">
                <input name="id_detent" type="hidden" value="<?= $consulta->iIdDetalleEntregable ?>">
                <button id="importarAvnc" disabled="true" class="btn waves-effect waves-light btn-info" type="submit" onclick="importarAvance()"><i class="mdi mdi-upload"></i>&nbsp;Importar avances</button>
            </div> 
        </div>
    </form>
</div>
<script>

     function validarexcelvacio(){
        var archivoexcel = $("#idFiles")[0].files.length;
        if(vidFileLength === 0){
            //$("#importarAvnc").removeAttr('disabled');
            //alert('funcionaaaaa');
        }
     }

    function mostrarelementos(){
        var value = $("#mescorte").val();
        
        if(value != ""){
            $("#importarAvnc").removeAttr('disabled');
            $("#idFiles").removeAttr('disabled');
        }else{
            $("#importarAvnc").attr("disabled", true);
            $("#idFiles").attr('disabled','disabled');
        }        
    }

    function importarAvance(){
        event.preventDefault();
        var mes = $('#mescorte').val();
        var formData = new FormData(document.getElementById("formuploadajax"));

		$.ajax({
        type: "POST",
        url: "<?=base_url()?>C_avances/read_excel",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(resp) {
            resp = JSON.parse(resp);
            if(resp.estatus) {                
                alerta(resp.mensaje, 'success');
                refrescarAvances(mes);
                mostrarRegistrosMes(mes);
                accordion[parseInt(mes)] = false;
            } else {
                alerta(resp.mensaje, resp.tipo);
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {

        }
    });

	}
</script>-->