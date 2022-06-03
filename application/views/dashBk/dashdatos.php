<style type="text/css">
    .progress {
        width: 110px;
        height: 110px;
        background: none;
        position: relative;
    }

    .progress::after {
        content: "";
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 6px solid #eee;
        position: absolute;
        top: 0;
        left: 0;
    }

    .progress>span {
        width: 50%;
        height: 100%;
        overflow: hidden;
        position: absolute;
        top: 0;
        z-index: 1;
    }

    .progress .progress-left {
        left: 0;
    }

    .progress .progress-bar {
        width: 100%;
        height: 100%;
        background: none;
        border-width: 6px;
        border-style: solid;
        position: absolute;
        top: 0;
    }

    .progress .progress-left .progress-bar {
        left: 100%;
        border-top-right-radius: 100px;
        border-bottom-right-radius: 100px;
        border-left: 0;
        -webkit-transform-origin: center left;
        transform-origin: center left;
    }

    .progress .progress-right {
        right: 0;
    }

    .progress .progress-right .progress-bar {
        left: -100%;
        border-top-left-radius: 100px;
        border-bottom-left-radius: 100px;
        border-right: 0;
        -webkit-transform-origin: center right;
        transform-origin: center right;
    }

    .progress .progress-value {
        position: absolute;
        top: 0;
        left: 0;
    }



    .progress-skill {        
        display: flex;
        height: 20px;
        font-size: .65625rem;
        background-color: #f6f8f9;
        border-radius: 2px;
    }    

    .progress-skill>span {
        width: 50%;
        height: 100%;
        overflow: hidden;
        position: absolute;
        top: 0;
        z-index: 1;
    }

    .progress-skill .progress-left {
        left: 0;
    }    

    .progress-skill .progress-left .progress-bar {
        left: 100%;
        border-top-right-radius: 100px;
        border-bottom-right-radius: 100px;
        border-left: 0;
        -webkit-transform-origin: center left;
        transform-origin: center left;
    }

    .progress-skill .progress-right {
        right: 0;
    }

    .progress-skill .progress-right .progress-bar {
        left: -100%;
        border-top-left-radius: 100px;
        border-bottom-left-radius: 100px;
        border-right: 0;
        -webkit-transform-origin: center right;
        transform-origin: center right;
    }

    .progress-skill .progress-value {
        position: absolute;
        top: 0;
        left: 0;
    }    

    .card .card-title {
        color: #fff !important;
        margin-bottom: 0px;
        margin-top: 15px;
    }


</style>
<section>
    <div class="" style="background-color: #f2f4f5;">
        <h3 class="font-weight-bold text-center">AVANCE POR EJE RECTOR</h3>

        <div class="card-group">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <p class="font-16 m-b-5">Planes  de trabajo</p>
                                    <i class="fas fa-building fa-lg font-20 text-muted"></i>
                                </div>
                                <div class="ml-auto">
                                    <h1 class="font-light text-right"><?=Decimal($pat_totales);?></h1>
                                </div>
                            </div>
                        </div>
                        <!--<div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 75%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>-->
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <p class="font-16 m-b-5">Actividades</p>
                                    <i class="fas fa-folder fa-lg font-20  text-muted"></i>
                                </div>
                                <div class="ml-auto">
                                    <h1 class="font-light text-right"><?=Decimal($act_totales);?></h1>
                                </div>
                            </div>
                        </div>
                        <!--<div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 60%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>-->
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <p class="font-16 m-b-5">Resultados</p>
                                    <i class="fas fa-trophy fa-lg font-20 text-warning"></i>
                                </div>
                                <div class="ml-auto">
                                    <h1 class="font-light text-right"><?=Decimal($ent_totales);?></h1>
                                </div>
                            </div>
                        </div>
                        <!--<div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-purple" role="progressbar" style="width: 65%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <?php
            foreach ($q_ejes as $d)
            { 
                $fontsize = (strlen(${'eje_'.$d->iIdEje}['presupuesto']) > 12) ? 'font-size:12px;':'';
            ?>
                <div class="col-xs-12 col-md-4">
                    <div onclick="recuperar(event, <?=$d->iIdEje; ?>);" class="card d-flex align-items-center" style="cursor: pointer; min-height: 400px;background-color: #<?=$d->vColorDesca?> !important; border-radius:25px;">
                        <div class="card-body">
                            <!--<h4 style="color:#FFFFFF;font-weight: bold;" class="text-wrap text-center"><a style="cursor: pointer" onclick="verEje(<?=$d->iIdEje?>);"><?=$d->vEje?></a></h4>-->
                            <h4 style="color:#FFFFFF;font-weight: bold;" class="text-wrap text-center"><a style="cursor: pointer"><?=$d->vEje?></a></h4>
                            
                            <div class="row">
                                <div class="col-12" style="margin-top:25px;">
                                    <div class="progress mx-auto" data-value="<?=${'eje_'.$d->iIdEje}['avance']?>">
                                        <span class="progress-left">
                                            <span class="progress-bar border-info"></span>
                                        </span>
                                        <span class="progress-right">
                                            <span class="progress-bar border-info"></span>
                                        </span>
                                        <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                            <div class="h4 font-weight-bold text-center" style="color: #FFFFFF;">
                                                <img src="<?=$d->vIcono?>" width="50px;"><br>
                                                <?=${'eje_'.$d->iIdEje}['avance']?><sup class="small">%</sup>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <div class="row text-center" style="color:#ffffff;">
                                <div class="col-4 border-right">
                                    <h4 class="m-b-0"><?=${'eje_'.$d->iIdEje}['pat']?> </h4>
                                    <span class="font-14">Planes </span>
                                </div>
                                <div class="col-4 border-right">
                                    <h4 class="m-b-0"><?=${'eje_'.$d->iIdEje}['actividades']?></h4>
                                    <span class="font-14">Actividades</span>
                                </div>
                                <div class="col-4">
                                    <h4 class="m-b-0"><?=${'eje_'.$d->iIdEje}['entregables']?> </h4>
                                    <span class="font-14">Resultados</span>
                                </div>                                
                            </div>
                            <br>
                            
                            <div class="row text-center" style="color:#ffffff;">
                                <div class="col-12">
                                    <h4 class="m-b-0">$ <?=${'eje_'.$d->iIdEje}['ejercido']?> </h4>
                                    <span class="font-14">Ejercido</span>
                                </div>
                            </div>
                            

                            <!--
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="card-title">Avance</h4>
                                    <div class="progress-skill">
                                        <div class="progress-bar bg-primary progress-bar-striped" aria-valuenow="<?=${'eje_'.$d->iIdEje}['avance']?>" aria-valuemin="0" aria-valuemax="100" style="font-size: 15px; width: <?=${'eje_'.$d->iIdEje}['avance']?>%; height:20px; color:black; font-weight: bold;" role="progressbar"> <?=${'eje_'.$d->iIdEje}['avance']?>% </div>
                                    </div>                                                                  
                                </div>
                                <br>
                                <div class="col-md-12">
                                    <div class="progress-skill">
                                        <div class="progress-bar bg-info progress-bar-striped" aria-valuenow="<?=${'eje_'.$d->iIdEje}['avance']?>" aria-valuemin="0" aria-valuemax="100" style="font-size: 15px; width: <?=${'eje_'.$d->iIdEje}['avance']?>%; height:20px; color:black; font-weight: bold;" role="progressbar"> $ <?=${'eje_'.$d->iIdEje}['ejercido']?> </div>
                                    </div>
                                </div>
                                <br>
                                <div class="col-md-12">
                                    <h6 class="card-title">Beneficiarios </h6>
                                    <div class="progress-skill">
                                        <div class="progress-bar bg-success progress-bar-striped" aria-valuenow="<?=${'eje_'.$d->iIdEje}['avance']?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=${'eje_'.$d->iIdEje}['avance']?>%; height:20px;" role="progressbar">  <?=${'eje_'.$d->iIdEje}['beneficiarios']?> </div>
                                    </div>                                                                  
                                </div>
                            </div>
                            -->


                            <!--<div class="row">
                                <div class="col-6 text-center" style="border-right: 3px solid rgba(255,255,255,.1) !important;">
                                    <i class="fas fa-lg fa-money-bill-alt" style="color: #FFFFFF"></i>
                                    <h4 style="color: #FFFFFF;<?=$fontsize;?>"  class="mb-0 font-medium"><?=${'eje_'.$d->iIdEje}['presupuesto']?></h4>
                                    <span style="color: #FFFFFF;">Presupuesto</span>
                                </div>
                                <div class="col-6 p-l-20 text-center">
                                    <i class="fas fa-lg fa-dollar-sign" style="color: #FFFFFF"></i>
                                    <h4 class="mb-0 font-medium" style="color: #FFFFFF;<?=$fontsize;?>"><?=${'eje_'.$d->iIdEje}['ejercido']?></h4>
                                    <span style="color: #FFFFFF;">Ejercido</span>
                                </div>                                    
                            </div>-->
                        
                            

                        </div>
                    </div>
                </div>

            <?php                
            }
            ?>
        </div>
    </div>
</section>
<?php if(count($top_gasto) > 0){ ?>



<section>
    <h3 class="font-weight-bold text-center">Gasto por municipio</h3>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 card" style="background-color: #FFFFFF !important;">
                    <label>Filtrar por actividad (Programa):</label>
                    <select name="search-act" id="search-act" class="form-control select2" onchange="load_opt_entregables();">
                        <option value="0">-- Todos --</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 card" style="background-color: #FFFFFF !important;">
                    <label>Filtrar por indicador:</label>
                    <select name="search-ent" id="search-ent" class="form-control select2" onchange="update_mapa();">
                        <option value="0">-- Todos --</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 card" id="div-mapa" >            
                    <div id="mapaMunicipios" style="height: 100%; min-height:600px; max-width: 100%; margin: 0 auto"></div>
                </div>
                <div class="col-md-4 card" style="background-color: #FFFFFF !important;">
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
        </div>
    </div>
</section>
<?php } ?>
<section>
    <h3 class="font-weight-bold text-center">Avance de compromisos</h3>
    <div class="row">
        <div class="col-md-12 text-left">            
            <div class="card" style="background-color: #FFFFFF !important;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 bg-light" style="margin:auto;">
                            <?php
                            $data_comp_est = '';
                            $total = 0;
                            foreach ($comp_est as $row) 
                            {
                                $estatus = ($row->vEstatus == 'Cumplido') ? 'Cumplidos' : $row->vEstatus;
                                $data_comp_est.= ($data_comp_est != '') ? ',':'';
                                $data_comp_est.= ($row->vEstatus == 'Cumplido' ) ? "{name:'$row->vEstatus',color: \"$row->vColor\", y:$row->numcomp, sliced: true,
            selected: true}":"{name:'$row->vEstatus',color: \"$row->vColor\",y:$row->numcomp}";
                                echo '<i class="fa fa-circle m-r-5 font-12" style="color:'.$row->vColor.'"></i> <span class="text-muted">'.$estatus.':</span><span class="font-medium">'.$row->numcomp.'</span><br>';
                                $total+= $row->numcomp;
                            }

                            echo '<br><strong>Total : '.$total.'</strong>';
                            ?>
                        </div>
                        <div class="col-md-10 text-left" id="pie-compromisos" class="m-t-30" style="min-height:250px; width:100%;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php 
        $id_ejes = array();
        foreach ($comp as $c)
        {
            $id_ejes[] = $c->iIdEje;
        ?>
            <div class="col-md-6" style="">
                <div class="card" style="background-color: #FFFFFF !important;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h5 class="font-weigh-bold"><?=$c->vEje?></h5>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 bg-light" style="margin:auto;">
                                    <?php 
                                    $total = 0;
                                    ${"data-".$c->iIdEje} = '';
                                    foreach ($c->estatus as $est)
                                    {
                                        if(${"data-".$c->iIdEje} != '') ${"data-".$c->iIdEje}.= ',';

                                        $estatus = ($est->vEstatus == 'Cumplido') ? 'Cumplidos' : $est->vEstatus;

                                        ${"data-".$c->iIdEje}.= ($est->vEstatus == 'Cumplido') ? "{name:'$est->vEstatus',color: \"$est->vColor\",y:$est->numcomp, sliced:true,
            selected:true}":"{name:'$est->vEstatus',color: \"$est->vColor\",y:$est->numcomp}";
                                        echo '<i class="fa fa-circle m-r-5 font-12" style="color:'.$est->vColor.'"></i> <span class="text-muted">'.$estatus.': </span><span class="font-medium">'.$est->numcomp.'</span><br>';
                                        $total+= $est->numcomp;
                                    }
                                    ?>
                                    <br><strong>Total : <?=$total?></strong>
                                    
                                </div>                            
                                <div class="col-8">
                                    <div id="c-eje-<?=$c->iIdEje?>" class="m-t-30" style="height:200px; width:100%;"></div>
                                </div>
                            </div>
                            
                        </div>
                </div>

            </div>

        <?php
        }
        ?>
        <div id="container"></div>
    </div>
</section>
<script type="text/javascript" src="<?=base_url();?>assets/mapacalor.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
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

        // Gráficas de avance circulares
        $(".progress").each(function() {

            var value = $(this).attr('data-value');
            var left = $(this).find('.progress-left .progress-bar');
            var right = $(this).find('.progress-right .progress-bar');

            if (value > 0) {
                if (value <= 50) {
                    right.css('transform', 'rotate(' + percentageToDegrees(value) + 'deg)')
                } else {
                    right.css('transform', 'rotate(180deg)')
                    left.css('transform', 'rotate(' + percentageToDegrees(value - 50) + 'deg)')
                }
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
                pointFormat: '<b>{point.y}</b>'
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
                pointFormat: '<b>{point.y}</b>'
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
    

    function percentageToDegrees(percentage) {
        return percentage / 100 * 360
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
</script>