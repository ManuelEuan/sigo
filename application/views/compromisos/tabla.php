<!-- sirve para mostrar nuevamente el buscador -->
<script>
$("#buscador_compromiso").show();
</script>

<?=$tabla_compromisos?>

<script>
    $(document).ready(function() {
        table = $("#grid").DataTable({
        	"displayStart":parseInt($('#start').val()),
            "pageLength": parseInt($('#length').val())
        });

        console.log($('#start').val());
    });

</script>