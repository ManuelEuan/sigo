<div>
<table id="tbllistadoP" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
                        <thead>
                            <tr>
                            <th>Numero de Proyecto</th>
                                <th>Aprobado</th>
                                <th>Pagado</th>
                                <th>Dependencia</th>
                                <th>Nombre Proyecto</th>
                                <th>Fecha Aprobacion</th>
                            
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                            <th>Numero de Proyecto</th>
                                <th>Aprobado</th>
                                <th>Pagado</th>
                                <th>Dependencia</th>
                                <th>Nombre Proyecto</th>
                                <th>Fecha Aprobacion</th>
                                

                            </tr>
                        </tfoot>
                    </table>
</div>

<script>
    $(document).ready(function(){

    getPropuestas()
 });
       function getPropuestas() {
        var tablaP = $('#tbllistadoP').dataTable({
            "aProcessing": true, //Activamos el procesamiento del datatables
            "aServerSide": true, //Paginación y filtrado realizados por el servidor
            dom: 'Bfrtip', //Definimos los elementos del control de tabla
            searching: false,
            buttons: [],
            "ajax": {
                url: '<?= base_url() ?>C_proyectosPOA/traerProyectoPicaso',
                type: "get",
                dataType: "json",
                error: function(e) {
                    console.log(e.responseText);
                }
            },
            "bDestroy": true,
            "iDisplayLength": 5, //Paginación
            "order": [
                [0, "desc"]
            ] //Ordenar (columna,orden)
        }).DataTable();
    }
</script>