<!-- ocultar el buscador -->
<script>
$("#buscador_compromiso").hide();
</script>

<?php 
$periodoactivo=($periodorevision==0) ? '' : 'disabled="disabled"';

?>
<div class="col-12" id="vistaComponente">
<div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10 mb-2">
                    <h3 class="card-title"><?=$vCompromiso?></h3>
                </div>
                <div class="col-md-2">
                    <button class="btn waves-effect waves-light btn-outline-info" type="button" onclick="listar_compromiso_verificacion()"><i class="mdi mdi-arrow-left"></i> Regresar</button>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12 mb-4"><h4><b>Capturar nuevo componente</b></h4></div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="">Componente</label>
                    <textarea class="form-control" id="vComponente"></textarea>
                </div>
                <div class="col-md-6">
                    <label for="">Descripción</label>
                    <textarea class="form-control" id="vDescripcion"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-4">
                    <label for="">Meta</label>
                    <input type="text" id="nMeta" class="form-control">
                </div>

                <div class="col-md-3">
                    <label for="">Meta modificada</label>
                    <input type="text" id="nMetamod" class="form-control">
                </div>
                <div class="col-md-3">
                    <label for="">Unidad de medida</label>
                    <select name="" id="iIdUnidadMedida" class="form-control" name="">
                        <option value="">Seleccione</option>
                        <?=$options_unidadmedida?>
                    </select>
                </div>
                <div class="col-md-2" >
                    <label for="">Ponderacion</label>
                    <input type="text" id="nPonderacion" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="text-align: center; margin-top: auto;">
                    <input type="submit" value="+ Agregar" class="btn btn-info btn-block" onclick="insertarComponente()" <?=$periodoactivo?>>
                </div> 
            </div>
        </div> 
    </div>

</div>

<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <h4 class="card-title">Componentes</h4>
                </div>
                <div class="col-md-2">
                <h4 class="card-title">Ponderacion total <?=$ponderacion?>% </h4>
                <h4 id="lblMensajePonderacion"></h4>
                </div>
                <div class="col-md-12">
                <?=$tabla_componente?>
                </div>
            
        </div> 
    </div>
</div>


<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">

  <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
  <div class="modal-dialog modal-dialog-centered" role="document">


    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Instrucciones</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Verifique que la suma de las ponderaciones de los componentes equivalgan a 100%
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>     
<!-- modal-->

<!-- SCRIPT USO ESTRICTO EMAC SCRIPT -->
<script>
// no retirar uso estricto 
"use strict";
function insertarComponente(){
    // datos del componente
    var data={"vComponente": $("#vComponente").val(), "vDescripcion": $("#vDescripcion").val(), "iIdUnidadMedida": $("#iIdUnidadMedida").val(), "nMeta": $("#nMeta").val(), "nPonderacion": $("#nPonderacion").val(), "iIdCompromiso": <?=$iIdCompromiso?>, "iOrden":0, "iActivo":1,"nAvance":0, 'nMetaModificada': $('#nMetamod').val()};
    // validador de campos vacios
    var validador=0;
    var objetos = (Object.values(data));
    for (var x = 0; x < objetos.length; x++) {
        if(objetos[x]=="" || objetos[x]==0){
            validador++;
        }
    }
    if(<?=$ponderacion?>+parseFloat($("#nPonderacion").val())>100){
        alerta('La suma de los componentes deben ser equivalentes a 100%', 'error');
        console.log(<?=$ponderacion?>+parseFloat($("#nPonderacion").val()));
    }else if(validador>2){
        alerta('Todos los campos son obligatorios', 'error');
    }else if(validador==2){
        if($("#nPonderacion").val()>=0 && $("#nMeta").val()>=0 && $('#nMetamod').val() >= 0){
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_compromisos_componentes/insertarComponente", //Nombre del controlador
            data: data,
            success: function(resp) {
                if (resp == 'correcto') {
                    CalcularAvance();
                    alerta('Guardado', 'success');
                    cargar('<?= base_url() ?>C_compromisos_componentes/index', '#contenedor','POST','id='+<?=$iIdCompromiso?>);
                } else {
                    alerta('Algo salio mal', 'error');
                }
            }});      
        }else{
            alerta('La meta y ponderacion son tipo numerico', 'error');
        }
    }        
}

function eliminar_componente(id){
    var data={"iIdComponente": id};
    $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_compromisos_componentes/eliminarComponente",
            data: data,
            success: function(resp) {
                if (resp == 'correcto') {
                    CalcularAvance();
                    alerta('Guardado', 'success');
                    cargar('<?= base_url() ?>C_compromisos_componentes/index', '#contenedor','POST','id='+<?=$iIdCompromiso?>);
                } else {
                    alerta('Algo salio mal', 'error');
                }
            }}); 

}

function editar_componentes(id) {
    var data={"iIdComponente": id , "iIdCompromiso": <?=$iIdCompromiso?>};
cargar('<?= base_url() ?>C_compromisos_componentes/componente_editar', '#vistaComponente','POST', data);
}

function CalcularAvance(){
    var data={"iIdCompromiso": <?=$iIdCompromiso?> };
    $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_compromisos_componentes/porcentajeAvance", //Nombre del controlador
            data: data,
            success: function(resp) {
        }});      
}
    $(document).ready(function() {
        $("#grid").DataTable();
    });

function mensajePonderacion(){
        $("#lblMensajePonderacion").css('color', 'red');
        $("#lblMensajePonderacion").text("Verifica que el total sea 100%");
        $("#exampleModalCenter").modal("show");
    }

function listar_compromiso_verificacion(){
        if(<?=$ponderacion?>==100.00){
            //cargar('<?= base_url() ?>C_compromisos/listartablacompromiso', '#contenedor');
            listar_compromiso_busqueda();
        }else{
            mensajePonderacion();
        }       
    }

    $( document ).ready(function() { 
        if(<?=$ponderacion?><100.000){
            mensajePonderacion()
        }
    });
</script>