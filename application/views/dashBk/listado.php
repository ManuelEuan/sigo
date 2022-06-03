<section>
    <div class="card">
        <div class="card-body" id="dash-content">

            <ul class="nav nav-tabs" role="tablist">
                <?php /*<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab"><span class="hidden-sm-up"><i class="fas fa-file-pdf"></i></span> <span class="hidden-xs-down">Fichas ejecutivas</span></a> </li>*/ ?>
                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#profile" role="tab"><span class="hidden-sm-up"><i class="fas fa-check"></i></span> <span class="hidden-xs-down">Actividades estratégicas</span></a> </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#messages" role="tab"><span class="hidden-sm-up"><i class="fas fa-map-marker-alt"></i></span> <span class="hidden-xs-down">Mapa</span></a> </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content tabcontent-border">
                <?php /*<div class="tab-pane p-20 active" id="home" role="tabpanel">
                    <table id="lista_fichas" class="table table-hover datatable">
                        <thead class="bg-inverse text-white">
                            <tr>
                                <th>Actividad</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($query as $row)
                        {
                            echo '<tr title="Haga click para ver más" style="cursor:pointer;" onclick="FichaActividad('.$row['iIdDetalleActividad'].');">';                            
                            echo '<td><i class="fas fa-file-pdf text-danger text-warning"></i>&nbsp;'.$row['vActividad'].'</td>';
                            echo '</tr>';
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                */?>
                <div class="tab-pane p-20 active" id="profile" role="tabpanel">
                    <?php 
                    if(count($query) > 0)
                    {
                    ?>
                    <table id="lista_act" class="table table-hover datatable">
                        <thead class="bg-inverse text-white">
                            <tr>
                                <th>Id</th>
                                <th>Actividad</th>
                                <th>Dependencia</th>                        
                                <?php 
                                    if($eje > 0)
                                    {
                                        //echo '<th>Avance</th><th>Ejercido</th><th>Beneficiarios</th>';
                                        echo '<th>% de Avance</th><th>Ejercido</th>';
                                    }
                                ?>
                                <th>Ficha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($query as $row)
                            {
                                echo '<tr>';
                                echo '<td title="Haga click para ver más" style="cursor:pointer;" onclick="verMas('.$row['iIdActividad'].');">'.$row['iIdActividad'].'</td>';
                                echo '<td title="Haga click para ver más" style="cursor:pointer;" onclick="verMas('.$row['iIdActividad'].');">'.$row['vActividad'].'</td>';
                                echo '<td title="Haga click para ver más" style="cursor:pointer;" onclick="verMas('.$row['iIdActividad'].');">'.$row['vDependencia'].'</td>';
                                if($eje > 0)
                                {
                                    echo "<td>".Decimal($row['avance'])." %</td>";
                                    echo "<td>$".DecimalMoneda($row['ejercido'])."</td>";
                                    //echo "<td>".Decimal($row['beneficiarios'])."</td>";
                                }
                                echo '<td title="Haga click para ver más" style="cursor:pointer;" onclick="FichaActividad('.$row['iIdDetalleActividad'].');"><i class="fas fa-file-pdf fa-lg text-danger text-warning"></i></td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                <?php }
                else {
                    echo '<p>No se encontraron resultados que coincidan con su búsqueda</p>';
                }?>
                </div>
                <div class="tab-pane p-20" id="messages" role="tabpanel">
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <input onchange="consultaMapa();" type="radio" id="rbtipomapa" name="rbtipomapa" value="1" checked="checked">Acciones&nbsp;&nbsp;
                                    <input onchange="consultaMapa();" type="radio" id="rbtipomapa" name="rbtipomapa" value="2">Obras&nbsp;&nbsp;
                                    <input onchange="consultaMapa();" type="radio" id="rbtipomapa" name="rbtipomapa" value="3">Ambos
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div id="mapaMunicipios2" style="height: 100%; min-width: 100%; max-width: 100%; margin: 0 auto"></div>
                                </div>
                                <div id="divscript"></div>
                            </div>
                        </div>
                        <div class="col-6 jumbotron">
                            <div class="card">
                                <div class="card-body">
                                    <h3 id="nombreMun"></h3>
                                    <div id="divdatomun">
                                        <span>Haga clic en un municipio para visualizar su información</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="<?=base_url();?>assets/mapacalor.js"></script>
<script type="text/javascript">
    var map2;
    var datos = [<?=$datamun?>];
    $(document).ready(function() {
        $("#eje_oculto").val(<?=$eje;?>);
        $('.datatable').DataTable();
        // Mapa
          map = $('#mapaMunicipios2').highcharts('Map', {
            title: {
                        text: null
                    },
            legend: {
                title: {
                    text: 'Ejercido'
                }
            },
            credits: {
                enabled: false
            },
            colorAxis: {
                min: 1,
                max:<?=$maxGasto?>,
                type: 'logarithmic',
                minColor: '#efecf3',
                maxColor: '#00688B'/*,
                stops: [
                    [0, '#EFEFFF'],
                    [0.67, '#4444FF'],
                    [1, '#000022']
                ]*/
            },
            plotOptions: {
                series: {
                    point: {
                        events: {
                            select: function(){
                                //alert('Seleccionado');
                            },
                            unselect: function(){
                                //alert('Des-Seleccionado');
                                console.log(map);
                            },
                            click: function (e) {
                                $("#nombreMun").html(e.point.name);
                                consultarInfoMun(e.point.id, e.point.op);
                                filtarListado(e.point.id, e.point.op);
                                        
                                /*if (!this.chart.clickLabel) {
                                    this.chart.clickLabel = this.chart.renderer.label(text, 0, 250)
                                        .css({
                                            width: '180px'
                                        })
                                        .add();
                                } else {
                                    this.chart.clickLabel.attr({
                                        text: text
                                    });
                                }*/
                            }
                        }
                    }
                }
            },
            /*tooltip: {
                pointFormat: "value: {point.y:,.0f}"
            },*/
            tooltip: {
                backgroundColor: '#FFFFFF',
                borderColor: 'black',
                borderRadius: 10,
                borderWidth: 3,
                pointFormat:'<h4 class="font-weight-bold text-center">{point.name}</h4><br>Población:<b>{point.population:,.0f}</b>  <br>Ejercido: <b>${point.value:,.2f}</b>'
            },
            series: [{
                type: "map",
                joinBy: ['id', 'id'],
                data: datos,
                name: "Municipio",
                mapData: mapData,
                allowPointSelect: true,
                cursor:"pointer",
                states: {
                    hover:{
                        color: '#a4edba'
                    },
                    select: {
                        color: '#EFFFEF',
                        borderColor: 'black',
                        dashStyle: 'dot'
                    }
                }
            }]
        });
     
    });

    function consultarInfoMun(id,op) {
        $.ajax({
            type: "POST",
            url: "<?=base_url() ?>C_dash/mostrar_datos_municipio",
            data: 'anio=<?=$an?>&eje=<?=$eje?>&mun='+id+'&op='+op,
            success: function(resp) {
                $("#divdatomun").html(resp);
            },
            error: function(XMLHHttRequest, textStatus, errorThrown) {}
        });
    }

    function filtarListado(mun,op){
        $.ajax({
            type: "POST",
            url: "<?=base_url() ?>C_dash/filtrar_listado_act",
            data: 'anio=<?=$an?>&eje=<?=$eje?>&mun='+mun+'&op='+op,
            success: function(resp) {
                $("#profile").html(resp);
            },
            error: function(XMLHHttRequest, textStatus, errorThrown) {}
        });
    }

    function verMas(id){
        $.ajax({
            type: "POST",
            url: "<?=base_url() ?>C_dash/ficha/"+id,
            data: data,
            success: function(resp) {
                $("#datos").html(resp);
            },
            error: function(XMLHHttRequest, textStatus, errorThrown) {}
        });
    }

    function FichaActividad(iIdDetalleActividad) {
        window.open("<?= base_url() ?>C_pat/ShowFichaActividadobj/"+iIdDetalleActividad,"_blank");
    }

    function consultaMapa(){
        var op = $('input:radio[name=rbtipomapa]:checked').val();

        $.ajax({
            type: "POST",
            url: "<?=base_url() ?>C_dash/mostrar_mapa_op",
            data: 'anio=<?=$an?>&eje=<?=$eje?>&op='+op,
            success: function(resp) {
                $("#divscript").html(resp);
                $("#nombreMun").html('');
                $("#divdatomun").html('<span>Haga clic en un municipio para visualizar su información</span>');
            },
            error: function(XMLHHttRequest, textStatus, errorThrown) {}
        });
    }
</script>