<style type="text/css">
    .circle img {              
        border-radius: 50%;
        width:50px;
        height:50px;
    }
</style>
<section>
    <div class="" style="background-color: #f2f4f5;">
        <h3 class="font-weight-bold text-center">AVANCE POR EJE RECTOR</h3>
        <div class="row">
            <div class="col-4 mb-4">
                <hr style="border:6px; background-color:#000080 !important;">
                <div class="row">
                    <div class="col-8 text-center"><h1 style="font-weight:700;color:#000080;" class="count"><?=Decimal($pat_totales);?></h1>
                        <h5 style="font-weight:500;">Planes  de trabajo</h5></div>
                    <div class="col-4"><h1 style="color:#000080;"><i class="fas fa-book fa-lg"></i></h1></div>
                </div>
            </div>

            <div class="col-4 mb-4">
                <hr style="border:6px; background-color:#000080 !important;">
                <div class="row">
                    <div class="col-8 text-center"><h1 style="font-weight:700;color:#000080;" class="count"><?=Decimal($act_totales);?></h1>
                        <h5 style="font-weight:500;">Actividades</h5></div>
                    <div class="col-4"><h1 style="color:#000080;"><i class="fas fa-pen-square fa-lg"></i></h1></div>
                </div>
            </div>

            <div class="col-4 mb-4">
                <hr style="border:6px; background-color:#000080 !important;">
                <div class="row">
                    <div class="col-8 text-center"><h1 style="font-weight:700;color:#000080;" class="count"><?=$ent_totales?></h1>
                        <h5 style="font-weight:500;">Resultados</h5></div>
                    <div class="col-4"><h1 style="color:#000080;"><i class="fas fa-check-circle fa-lg"></i></h1></div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <?php
            foreach ($q_ejes as $d)
            { 
                $fontsize = (strlen(${'eje_'.$d->iIdEje}['presupuesto']) > 12) ? 'font-size:12px;':'';
                if($d->iIdEje == 9)
                { 
                    $avance = ($av_obras->numobras > 0) ? round($av_obras->avancefisico / $av_obras->numobras):0;
                    $ejercido = DecimalMoneda(($av_obras->avancefinanciero * $pre_obras->presupuestoobra) / 100);
                    ?>
                    <div class="col-xs-12 col-md-4">
                        <div onclick="mostrarTableroObras(<?=$anio?>);" class="card d-flex" style="cursor: pointer; min-height: 200px; !important;">
                            <div class="card-body">
                         
                                <div class="row">
                                    <div class="col-1 circle"><img src="<?=$d->vIcono?>" width="200px;" style="background:#<?=$d->vColorDesca?>;"></div>
                                    <div class="col-1"></div>
                                    <div class="col-10"><h5 style="color:#<?=$d->vColorDesca?>;font-weight: bold;" ><a style="cursor: pointer"><?=$d->vEje?></a></h5></div>                                
                                </div>
                                <div class="row">
                                    <div class="col-2"></div>
                                    <div class="col-6 mb-0"><div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="background-color:#<?=$d->vColorDesca?> !important; width:<?=$avance?>%;height: 8px;" aria-valuenow="<?=$avance?>" aria-valuemin="0" aria-valuemax="100"><span style="font-size:10px;"></span></div></div>
                                    <div class="col-4"><h3 class="font-light" style="font-weight:700"><span class="count"><?=$avance?></span>%</h3></div>
                                    
                                </div>
                                
                                <div class="row">
                                    <div class="col-2"></div>
                                    <div class="col-10"><hr style="background-color:#000000;"></div>
                                </div>
                                
                                <div class="row text-center mb-2">
                                    <div class="col-12 text-center">
                                        <h4 class="m-b-0" style="font-weight:700"><?=$av_obras->numobras?></h4>
                                        <span class="font-14">Obras</span></div>
                                   
                                </div>

                                <div class="row mb-2">
                                     <div class="col-12 text-center mb-2">
                                        <h4 class="m-b-0" style="font-weight:700">$<?=$ejercido?> </h4>
                                        <span class="font-14">Ejercido</span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php 
                }
                else
                {   ?>
                    <div class="col-xs-12 col-md-4">
                        <div onclick="listarDeps(<?=$d->iIdEje; ?>);" class="card d-flex" style="cursor: pointer; min-height: 200px; !important;">
                            <div class="card-body">
                         
                                <div class="row">
                                    <div class="col-1 circle"><img src="<?=$d->vIcono?>" width="200px;" style="background:#<?=$d->vColorDesca?>;"></div>
                                    <div class="col-1"></div>
                                    <div class="col-10"><h5 style="color:#<?=$d->vColorDesca?>;font-weight: bold;" ><a style="cursor: pointer"><?=$d->vEje?></a></h5></div>                                
                                </div>
                                <div class="row">
                                    <div class="col-2"></div>
                                    <div class="col-6 mb-0"><div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="background-color:#<?=$d->vColorDesca?> !important; width:0%;height: 8px;" aria-valuenow="<?=${'eje_'.$d->iIdEje}['avance']?>" aria-valuemin="0" aria-valuemax="100"><span style="font-size:10px;"></span></div></div>
                                    <div class="col-4"><h3 class="font-light" style="font-weight:700"><span class="count"><?=${'eje_'.$d->iIdEje}['avance']?></span>%</h3></div>
                                    
                                </div>
                                
                                <div class="row">
                                    <div class="col-2"></div>
                                    <div class="col-10"><hr style="background-color:#000000;"></div>
                                </div>
                                
                                <div class="row text-center mb-2">
                                    <div class="col-4">
                                        <h4 class="mb-0" style="font-weight:700"><?=${'eje_'.$d->iIdEje}['pat']?> </h4>
                                        <span class="font-14">Planes </span></div>
                                    <div class="col-4"><h4 class="m-b-0" style="font-weight:700"><?=${'eje_'.$d->iIdEje}['actividades']?></h4>
                                        <span class="font-14">Actividades</span></div>
                                    <div class="col-4"><h4 class="m-b-0" style="font-weight:700"><?=${'eje_'.$d->iIdEje}['entregables']?> </h4>
                                        <span class="font-14">Resultados</span></div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-12 text-center mb-2">
                                        <h4 class="m-b-0" style="font-weight:700">$ <?=${'eje_'.$d->iIdEje}['ejercido']?> </h4>
                                        <span class="font-14">Ejercido</span></div>
                                </div>

                                
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>

<hr>
<?php if(count($top_gasto) > 0){ ?>
<section>
    <h3 class="font-weight-bold text-center">GASTO POR MUNICIPIO</h3>
        
    <div class="row mb-4">
        <div class="col-6">
            <label>Filtrar por actividad (Programa):</label>
            <select name="search-act" id="search-act" class="form-control select2" onchange="load_opt_entregables();">
                <option value="0">-- Todos --</option>
            </select>
        </div>
        <div class="col-6">
            <label>Filtrar por resultado:</label>
            <select name="search-ent" id="search-ent" class="form-control select2" onchange="update_mapa();">
                <option value="0">-- Todos --</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8" id="div-mapa" >            
            <div id="mapaMunicipios" style="height: 100%; min-height:600px; max-width: 100%; margin: 0 auto"></div>
        </div>
        <div class="col-md-4">
            <br>
            <table class="table" id="tabla-top-gasto">
                <thead>
                    <tr>
                        <th align="center">Top</th>
                        <th align="center">Municipio</th>
                        <th align="center">Ejercido (M.X.N)</th>
                    </tr>
                </thead>
                <tbody id="tbody-gasto">
                <?php
                $top = 1;
                foreach ($top_gasto as $g)
                {
                    echo '<tr>
                        <td align="center">'.$top.'</td>
                        <td align="center">'.$g['mun'].'</td>
                        <td align="right">$'.Decimal($g['ejercido']).'</td>
                    </tr>';

                    $top++;
                }
                
                ?>
                </tbody>
            </table>
        </div>
    </div>
        
</section>
<?php } ?>
<hr>




<script type="text/javascript" src="<?=base_url();?>assets/mapacalor.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

        $('.count').each(function () {
            $(this).prop('Counter',0).animate({
                Counter: $(this).text()
            }, {
                duration: 4000,
                easing: 'swing',
                step: function (now) {
                    $(this).text(number_format(Math.ceil(now)));
                }
            });
        });

        $('.progress-bar').each(function() {
            $(this).delay(1000).queue(function () {
                $(this).css('width', $(this).attr('aria-valuenow')+'%');
            });
        });
       
        // Iniciamos el campo de búsqueda del mapa
        $('#search-act').select2({
            placeholder: "Escriba su texto aquí",
            minimumInputLength: 4,
            allowClear: true,
            language: {
                noResults: function() {
                  return "No hay resultados";
                },
                searching: function() {
                  return "Buscando..";
                },
                inputTooShort: function () {
                    return "Debe ingresar 4 caractéres como mínimo...";
                }
            },
            ajax: {
                delay: 500,            
                url: function (params) {
                  return '<?=base_url()?>index.php/C_dash/options_actividades?anio=' + $("#anio").val();
                },
                dataType: 'json'
            }
        });
        
        // Mapa
        Highcharts.setOptions({
            lang: {
                thousandsSep: ','
            }
        });
        
        map = $('#mapaMunicipios').highcharts('Map',options);

        <?php 
        foreach ($id_ejes as $id)
        {
        ?>

        Highcharts.chart('c-eje-<?=$id?>', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            lang: {
                  thousandsSep: ','
            },
             title: {
                text: ''
            },
            credits: {
                enabled: false
            },
            tooltip: {
                pointFormat: '<b>{point.y}</b><br>Avance:<br><b>{point.avance}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                allowPointSelect: true,
                cursor: 'pointer',
                pie: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.percentage:.1f} %',
                        distance: 20,
                        style: {
                            color: 'black'
                        }
                    }
                    
                },
                series: {
                    cursor: 'pointer',
                    events: {
                        click: function (event) {
                            console.log(this);
                            
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Estatus comprmisos',
                innerSize: '50%',
                data:[<?=${'data-'.$id}?>]
            }]
        });
        
        <?php   
        }
        if($all_sec > 0){
        ?>

        Highcharts.chart('pie-compromisos', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type:'pie'
            },
            lang: {
                  thousandsSep: ','
            },
            title: {
                text: ''
            },
            credits: {
                enabled: false
            },
            tooltip: {
                pointFormat: '<b>{point.y}</b><br>Avance:<br><b>{point.avance}%</b>'
            },
            plotOptions: {
                pie: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.percentage:.1f} %',
                        style: {                            
                            color: 'black'
                        }
                    }
                    
                }
            },
            series: [{
                type: 'pie',
                colorByPoint: true,
                innerSize: '50%',
                data:[<?=$data_comp_est;?>]
            }]
        });
        <?php } ?>
    });

    // Variables para inicializar el mapa de ejercido
    var map;
    var options = {
        title: {
                    text: null
                },           
        legend: {
            title: {
                text: 'Ejercido'
            }
        },
        mapNavigation: {
            enabled: true,
            buttonOptions: {
                verticalAlign: 'bottom'
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
                            //alert(e.point.name);
                                    
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
            pointFormat:'<h4 class="font-weight-bold text-center">{point.name}</h4><br>Población:<b>{point.population:,.2f}</b>  <br>Ejercido: <b>${point.value:,.2f}</b>'
        },
        series: [{
            type: "map",
            joinBy: ['id', 'id'],
            data: [<?=$datamun?>],
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
    };
    
    function number_format(amount, decimals) {

        amount += ''; // por si pasan un numero en vez de un string
        amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

        decimals = decimals || 0; // por si la variable no fue fue pasada

        // si no es un numero o es igual a cero retorno el mismo cero
        if (isNaN(amount) || amount === 0) 
            return parseFloat(0).toFixed(decimals);

        // si es mayor o menor que cero retorno el valor formateado como numero
        amount = '' + amount.toFixed(decimals);

        var amount_parts = amount.split('.'),
            regexp = /(\d+)(\d{3})/;

        while (regexp.test(amount_parts[0]))
            amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

        return amount_parts.join('.');
    }
   
    function verEje(id){
        cargar('<?=base_url();?>index.php/C_dash/ficha_eje','#datos','POST','id='+id+'&anio=<?=$anio?>');
    }

    function update_mapa(){
        var idDetAct = ($("#search-act").val() == null) ? 0:$("#search-act").val();
        $.ajax({
            url: '<?=base_url()?>index.php/C_dash/update_mapa_gasto',
            type: 'POST',
            async: true,
            data: 'anio=<?=$anio?>&idDetAct='+idDetAct+'&idDetEnt='+$("#search-ent").val(),
            success: function(htmlcode){
                var resp = JSON.parse(htmlcode);
                console.log(resp);
                
                options.colorAxis = resp.maxGasto;
                options.series[0].data = resp.datamun;
                options.tooltip.pointFormat = resp.tooltip;
                generar_tabla_gasto(resp.top_gasto);
                map = $('#mapaMunicipios').highcharts('Map',options);

            },
            error: function(XMLHttpRequest, errMsg, exception){
                console.log(errMsg,"error");
            }
        });
    }

    function load_opt_entregables(){
        var idDetAct = ($("#search-act").val() == null) ? 0:$("#search-act").val();
        $('#search-ent').val(0);
        $.ajax({
            url: '<?=base_url()?>index.php/C_dash/option_entregables',
            type: 'POST',
            async: true,
            data: 'id='+idDetAct,
            success: function(htmlcode){
                $('#search-ent option[value!="0"]').remove();
                $('#search-ent').append(htmlcode);
                update_mapa();
            },
            error: function(XMLHttpRequest, errMsg, exception){
                console.log(errMsg,"error");
            }
        });
    }

    function generar_tabla_gasto(data){
        $("#tbody-gasto").empty();
        if(data.length < 5){

        }
        for (var i = 0; i < data.length; i++){
            var top = i + 1;
            $("#tbody-gasto").append('<tr>'+
                                '<td align="center">'+top+'</td>'+
                                '<td align="center">'+data[i].mun+'</td>'+
                                '<td align="right">$'+number_format(data[i].ejercido,2)+'</td>'+
                            '</tr>');
        };
    }

    function listarDeps(eje){
        var variables = {
            anio: <?=$anio?>,
            eje: eje
        }
        cargar('<?= base_url(); ?>index.php/C_dash/deps_anio_eje', '#datos', 'POST', variables);
    }

    function mostrarTableroObras(anio){
        var variables = {
            anio: anio
        }
        cargar('<?= base_url(); ?>index.php/C_dash/mostrar_tablero_obras', '#datos', 'POST', variables);
    }
</script>