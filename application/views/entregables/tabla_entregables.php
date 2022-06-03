<?= $tabla ?>

<script>
    $(document).ready(function() {
        $('#grid').DataTable();
    });
</script>

<script>
    function EliminarEntregable(id){
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_entregables/delete", //Nombre del controlador
            data: {
                'id': id,
                'id_detact': <?= $id_detact ?>
            },

            success: function(resp) {
                if (resp == true) {

                    modificar_ponderacion(<?= $id_detact ?>,1);
                    alerta('Eliminado exitosamente', 'success');
                    CalcularPorcentajeActividad();
                    $('#regresarbtnent').hide();

                }if (resp == false){
                    regresarmodulo();
                    alerta('Eliminado exitosamente', 'success');
                    CalcularPorcentajeActividad();
                    $('#regresarbtnent').hide();
                }if(resp > 1){
                    alerta('Error al eliminar', 'error');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {

            }
        });
    }
</script>