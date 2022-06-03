<?= $contenido ?>

<script>
$(".ponderacion").attr("maxlength", 11);
</script>

<script>

    $(document).ready(function(){
        <?php if($acceso == 1){ ?>
            $(".btn-lectura").css('display','none');
            $(".input-lectura").attr('readonly','readonly');
        <?php } ?>

        var total = 0;
        $('.ponderacion').each(function(index, value) {

            if(eval($(this).val()) != null){
                total += eval($(this).val());
            }
        })
        $("#total").text(total);
        $("#totalmeta").val(total);
        sumarMod();
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
        $("#totalmeta").val(total);
    }

    function sumarMod(){
        var total = 0;
        $(".ponderacionMod").each(function() {

            if (isNaN(parseFloat($(this).val()))) {
                total += 0;
            } else {
                total += parseFloat($(this).val());
            }
        });
        $("#totalmod").text(total);
        $("#totalmetamod").val(total);
    }

    function guardarMunicipalizacion(f, e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_entregables/insert_municipalizacion", //Nombre del controlador
            data: $(f).serialize(),

            success: function(resp) {
                if (resp == 'correcto'){

                    alerta('Guardado exitosamente', 'success');
                    regresarmodulo();
                }
                if (resp == 'mayor'){

                    alerta('La suma de metas supera la meta anual establecida', 'warning');
                }
                if (resp == 'menor'){

                    alerta('La suma de metas no alcanza la meta anual establecida', 'warning');
                }
                if (resp == 'error'){
                    
                    alerta('Error al guardar', 'error');
                }

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {

            }
        });
    }
</script>