<div id="modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="contenido-modal">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="card d-flex">
    <div class="card-body">
        <div class="row">
            <div class="col-12 text-right mb-4">
                <button title="Regresar" type="button" class="btn waves-effect waves-light btn-outline-info" onclick="regresar();"><i class="mdi mdi-arrow-left"></i>&nbsp;Regresar</button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h3>Obras por ejecutor</h3>
                <table class="table table-bordered table-striped table-hover" id="obras_ej">
                    <thead>
                        <tr>
                            <th>Dependencia ejecutora</th>
                            <th class="sum">Total</th>
                            <th class="sum">Licitadas</th>
                            <th class="sum">Concluidas</th>
                            <th class="sum">No iniciadas</th>
                            <th width="50px" id="th4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $obras_ej = $obras_ej->result();
                        foreach ($obras_ej as $da)
                        {
                            echo '<tr>
                                <td><a title="Haga clic para ver la información del registro" style="cursor:pointer" onclick="updateGraph(event,4,'.$da->iIdDependencia.');">'.$da->vDependencia.'</a></td>
                                <td>'.$da->total.'</td>
                                <td>'.$da->licitadas.'</td>
                                <td>'.$da->concluidas.'</td>
                                <td>'.$da->noiniciadas.'</td>
                                <td><a title="Haga clic para ver información de las obras" style="cursor:pointer" onclick="openModal(event,'.$da->iIdDependencia.',4);"><i class="mdi mdi-information-outline"></i></a>&nbsp;<a title="Haga clic para ver la información del registro" style="cursor:pointer" onclick="updateGraph(event,4,'.$da->iIdDependencia.');"><i class="mdi mdi-chart-pie"></i></a></td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                    <tfoot>
                         <tr>
                            <th>Totales</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table> 

            </div>
        </div>

        <div class="row">
            <div class="col-12" id="container4"><?=$graph4?></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#obras_ej').DataTable({
            //"scrollY": '70vh',
            "paging": false,
            "info": false,
            dom: 'Bfrtip1',
            buttons: [
                'copy', 'excel', 'pdf'
            ],
                footerCallback: function ( row, data, start, end, display ) {
                var api = this.api(), data;
     
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
           
                // Total over this page
                pageTotal1 = api
                    .column( 1, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                pageTotal2 = api
                    .column( 2, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                pageTotal3 = api
                    .column( 3, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                pageTotal4 = api
                    .column( 4, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );     
                // Update footer
                $( api.column( 1 ).footer() ).html(number_format(pageTotal1));
                $( api.column( 2 ).footer() ).html(number_format(pageTotal2));
                $( api.column( 3 ).footer() ).html(number_format(pageTotal3));
                $( api.column( 4 ).footer() ).html(number_format(pageTotal4));
            }
        });
    });

    function updateGraph(e,iIdGraph,iId) {
        e.preventDefault();
        var variables = 'iIdGraph='+iIdGraph+'&iId='+iId;
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_dash/actualizar_grafica",
            data: variables,
            success: function(resp) {
                $("#container"+iIdGraph).html(resp);
            },
            error: function(XMLHHttRequest, textStatus, errorThrown) {}
        });
    }

    function openModal(e,id,tipo){

        e.preventDefault();
        var variables = 'id='+id+'&anio=<?=$anio?>&tipo='+tipo;
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_dash/mostrar_datos_obras",
            data: variables,
            success: function(resp) {
                $("#contenido-modal").html(resp);
            },
            error: function(XMLHHttRequest, textStatus, errorThrown) {}
        });

        $("#modal").modal();
    }

    function descargar_reporte(id) {
        window.open("http://ssop.yucatan.gob.mx/index.php/C_obras/descargar_reporte?id="+id);
    }

    function clickTable(n){
        setTimeout(function(){ $("#th"+n).click(); }, 500);
    }

    function regresar(){
        var variables = {
            anio: $('#anio').val(),
            eje: 0
        }
        cargar('<?= base_url(); ?>index.php/C_dash/buscar', '#datos', 'POST', variables);
    }
</script>