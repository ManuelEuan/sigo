<?= $contenido ?>

<script>
$('.ponderacion').attr("maxlength", 11);
var ponderacion = $('#num_ponderaciones').val();
var modo = $('#modo').val();
function calculaPonderacion(){
    var ponderacion_length = modo == "crea" ?  parseInt(ponderacion,10) + 1 : parseInt(ponderacion,10);
    var divicion_ponderacion = 0;
    divicion_ponderacion = Math.round(100 / ponderacion_length);
    var valida = divicion_ponderacion * ponderacion_length;
    var ultimoItem = divicion_ponderacion;
            while(valida != 100){
                if(valida > 100){
                    ultimoItem = ultimoItem - 1;            
                }else{
                    ultimoItem = ultimoItem + 1;
                }
                valida = (divicion_ponderacion * (ponderacion_length - 1)) + ultimoItem;
            }
        
        for(let i = 1; i <= ponderacion_length; i ++){
            if($('#otrasPonderaciones'+ i).val() >= 100){
                if(modo == "crea"){
                    if(i == 1){
                        $("#ponderacionActual").val(divicion_ponderacion);
                    }else{
                        let id = i - 1;
                        if(i == ponderacion_length && ultimoItem != 0){
                            $('#otrasPonderaciones'+ id).val(ultimoItem);
                        }else{
                            $('#otrasPonderaciones'+ id).val(divicion_ponderacion);
                        }
                    }
                }else{
                    if(i == ponderacion_length && ultimoItem != 0){
                            $('#otrasPonderaciones'+ i).val(ultimoItem);
                        }else{
                            $('#otrasPonderaciones'+ i).val(divicion_ponderacion);
                    }
                }
            }
        }

        
}
calculaPonderacion();

function filterFloat(evt,input){
    var key = window.Event ? evt.which : evt.keyCode;    
    var chark = String.fromCharCode(key);
    var tempValue = input.value+chark;
    if(key >= 48 && key <= 57){
        if(filter(tempValue)=== false){
            return false;
        }else{       
            return true;
        }
    }else{
          if(key == 8 || key == 13 || key == 0) {     
              return true;              
          }else if(key == 46){
                if(filter(tempValue)=== false){
                    return false;
                }else{       
                    return true;
                }
          }else{
              return false;
          }
    }
}
function filter(__val__){
    var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
    if(preg.test(__val__) === true){
        return true;
    }else{
       return false;
    }   
}

    $(document).ready(function(){
        var total = 0;
        $('.ponderacion').each(function(index, value) {
            total += eval($(this).val());
        })
        $("#total").text(total);
        $("#totalponderacion").val(total);
    });

    function sumar(){
        var total = 0;
        $(".ponderacion").each(function() {

            if (isNaN(parseFloat($(this).val()))) {
                total += 0;
            } else {
                total += parseFloat($(this).val());
            }
        });
        $("#total").text(total);
        $("#totalponderacion").val(total);
    }

    function guardarPonderacion(f, e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_entregables/restart_ponderacion", //Nombre del controlador
            data: $(f).serialize(),

            success: function(resp) {
                if (resp == "correcto") {

                    CalcularPorcentajeActividad();
                    regresarmodulo();
                    alerta('Guardado exitosamente', 'success');

                }
                if (resp == "mayor") {

                    alerta('La ponderacion ingresada supera el total de 100, favor de verificar las ponderaciones', 'warning');

                }
                if (resp == "menor") {

                    alerta('La ponderacion ingresada no alcanza el total de 100, favor de verificar las ponderaciones', 'warning');

                }
                if (resp == "error") {

                    alerta('Error al guardar', 'error');
                }

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {

            }
        });
    }
</script>