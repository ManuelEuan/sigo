<br><br>
<div class="card">
    <div class="card-body">
        <h6 class="card-subtitle">Acción estratégica</h6>
        <h3 class="card-title"><?=$vActividad;?></h3>
        <div class="row">
            <div class="col-md-10 mb-3">
            <?php if($acceso > 1) {?>
                <button type="button" class="btn waves-effect waves-light btn-primary" style="margin-top:35px" onclick="agregar_entregable(<?= $id_detact ?>)">+ Nuevo indicador</button>
                <button type="button" class="btn waves-effect waves-light btn-warning" style="margin-top:35px" onclick="modificar_ponderacion(<?= $id_detact ?>,null)">Captura de ponderaciones</button>
            <?php } ?>
            </div>
            <div class="col-md-2 mb-3 text-right">
                <div class="form-group">
                    <div class="button-group">
                        <button title="Ir al listado del PAT" id="regresarbtnent" type="button" class="btn waves-effect waves-light btn-outline-info" style="margin-top:35px" onclick="back()"><i class="mdi mdi-arrow-left"></i>&nbsp;Regresar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="contenedor">
<?php
    include_once('contenido_tabs.php');
?>
</div>

<script>
    function validar(id){
        event.preventDefault();
        var validado = ($('#chk'+id).is(':checked'))? 1:0;
        var variables = 'id='+id+'&validado='+validado;
         $.ajax({
            url: '<?=base_url();?>index.php/C_entregables/marcar',
            type: 'POST',
            async: true,
            data: variables,
            error: function(XMLHttpRequest, errMsg, exception){
                var msg = "Ha fallado la petición al servidor";
                alerta(msg,"error");              
            },
            success: function(htmlcode){
                switch(htmlcode)
                {
                    case "0":
                        $("#chk"+id).prop('checked', (validado == 1));
                        break;                    
                    default:
                        alerta(htmlcode,'error');
                        break;
                }
            }
        });
    }

    function agregar_entregable(id) {
        cargar('<?= base_url() ?>C_entregables/create', '#contenedor','POST', 'id=' + id);
        $('#regresarbtnent').hide();
    }

    function modificar_ponderacion(id,tipo){

        var variables = 'id2='+id+ '&'+ 'tipo='+tipo;
           
        cargar('<?= base_url() ?>C_entregables/showponderacion', '#contenedor','POST', variables);
        $('#regresarbtnent').hide();
    }

    function municipalizacion(id,id_act) {
        cargar('<?= base_url() ?>C_entregables/create_municipalizacion', '#contenedor','POST', 'id=' + id + '&id_act=' + id_act);
        $('#regresarbtnent').hide();
    }

    function modificar_entregable(id, id_detact) {

        var variables = 'id='+id+ '&'+ 'id2='+<?= $id_detact ?>;

        cargar('<?= base_url() ?>C_entregables/edit', '#contenedor', 'POST', variables);
        $('#regresarbtnent').hide();
    }

    function regresarmodulo() {
        cargar('<?= base_url() ?>C_entregables/','#contenido_modulo', 'POST', 'id=' + <?= $id_detact ?>);
    }
    
    function agregar_ponderacion(id_detent,id_detact) {

        var variables = 'id='+id_detent+ '&'+ 'id2='+id_detact;
        
        cargar('<?= base_url() ?>C_entregables/showponderacion', '#contenedor','POST', variables);
        $('#regresarbtnent').hide();
    }

    function mostrar_avances(id_detent){
        var variables = 'id='+id_detent+ '&'+ 'id_detact='+<?= $id_detact ?>;
        cargar('<?= base_url() ?>C_avances/index', '#contenido_modulo','POST', variables);
        $('#regresarbtnent').hide();
    }

    function CalcularPorcentajeActividad(){
        //event.preventDefault();

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_entregables/calcular_porcentaje_avance", //Nombre del controlador
            data: {
                'id_detact': <?= $id_detact ?>
            },

            success: function(resp) {
                if (resp == true) {

                } else {
                    
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {

            }
        });
    }

    /*function filterFloat(evt,input){
        var key = window.Event ? evt.which : evt.keyCode;    
        var chark = String.fromCharCode(key);
        var tempValue = input.value+chark;
        if(key >= 48 && key <= 57){
            if(filter_key(tempValue)=== false){
                return false;
            }else{       
                return true;
            }
        }else{
              if(key == 8 || key == 13 || key == 0) {     
                  return true;              
              }else if(key == 46){
                    if(filter_key(tempValue)=== false){
                        return false;
                    }else{       
                        return true;
                    }
              }else{
                  return false;
              }
        }
    }*/

    function filter_key(__val__){
        var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
        if(preg.test(__val__) === true){
            return true;
        }else{
           return false;
        }   
    }
</script>