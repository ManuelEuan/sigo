<style type="text/css">
    .rosa{
        color:#e61980 !important;
    }
</style>
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-10 align-self-center"></div>
        <div class="col-md-2 mb-2 text-right">
            <div class="button-group">
                <button title="Ir a la pantalla anterior" id="regresarbtnent" type="button" class="btn waves-effect waves-light btn-outline-info" style="margin-top:35px" onclick="regresarActs();"><i class="mdi mdi-arrow-left"></i>&nbsp;Regresar</button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 mb-2">
                    <h1 style="font-weight:700;color:#000080;"><?=$vActividad;?></h1>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-12 mb-2">
                <?php
                if($ods->num_rows() > 0)
                {
                    $result = $ods->result();
                    foreach ($result as $row)
                    {
                        echo '<img src="'.base_url().'public/img/ods/'.$row->iIdOds.'.png" width="100px">';
                    }
                }
                ?>
                </div> 
            </div>-->
            <div class="row">
                <div class="col-6"><a href="#div-info-act" class="btn btn-info" data-toggle="collapse"><i class="mdi mdi-information-outline"></i> Ver datos generales de la actividad</a></div>
                <div class="col-6 text-right"><!--<a href="#div-mensaje" class="btn btn-info" title="Escribir mensaje para el responsable" data-toggle="collapse"><i class="mdi mdi-message-draw"></i> Enviar mensaje al responsable</a>--></div>
            </div>
            <br>
            <div id="div-info-act" class="collapse">
                <div class="row">
                    <div class="col-lg-12">                
                        <h5 class="card-title font-weight-bold">Descripción</h5>
                        <?=$vDescripcion?>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-lg-12">
                        <h5 class="card-title font-weight-bold">Objetivo</h5>
                        <?=$vObjetivo?>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-lg-12">
                       <h5 class="card-title font-weight-bold">Dependencia responsable</h5>
                        <?=$vDependencia?>
                    </div>
                </div>
                <br>
            </div>
            <div id="div-mensaje" class="collapse">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5><span class="card-title font-weight-bold">Responsable de la actividad:</span> <?=$vResponsable?></h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">                            
                                        <h5><span class="card-title font-weight-bold">Correo:</span> <?=$vCorreo?></h5>                            
                                    </div>
                                    <div class="col-lg-6">                            
                                        <h5><span class="card-title font-weight-bold">Teléfono:</span> <?=$vTelefono?></h5>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <form onsubmit="enviarCorreo(event,this);">
                                            <h5><span class="card-title font-weight-bold">Mensaje para el responsable:</span></h5>
                                            <textarea class="form-control" name="mensaje" id="mensaje"></textarea><br>
                                            <input type="hidden" name="correo" id="correo" value="<?=$vCorreo?>">
                                            <button type="submit" class="btn btn-block btn-info">Enviar correo &nbsp;<i class="fas fa-location-arrow"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- // Gráfica de avance por año -->
    <div class="row">
        <div class="col-lg-12 text-center">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-2 text-center">
                            <h2 style="font-weight:700;color:#000080;">Avance de la actividad </h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div id="g-avance" style="width: 400px; height: 400px; margin: 0 auto"></div>
                        </div>
                        <div class="col-md-6">
                            <?php echo $avance_mes; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfica de finanzas-->
    <?php include('graphs/g-finanzas.php'); ?>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 mb-2 text-center">
                    <h2 style="font-weight:700;color:#000080;">Indicadores</h2>
                </div>
            </div>
            <div class="row">                
                <div class="col-12 mb-2">
                    <label>Selecione un indicador para conocer su avance:</label>
                    <select class="form-control" name="idEnt" id="idEnt" onchange="verGrafEntregables();">
                        <?php
                        foreach ($ent as $row)
                        {
                            echo '<option value="'.$row->iIdEntregable.'">'.$row->vEntregable.'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div id="div-g-entregables">
                <?php include('graphs/g-entregables.php'); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-12 text-right">
            <div class="form-group">
                <div class="button-group">
                    <button title="Ir a la pantalla anterior" id="regresarbtnent" type="button" class="btn waves-effect waves-light btn-outline-info" style="margin-top:35px" onclick="recuperar(event)"><i class="mdi mdi-arrow-left"></i>&nbsp;Regresar</button>
                </div>
            </div>
        </div>
    </div>


</div>
<script type="text/javascript">
 $(document).ready(function (){       
       Highcharts.chart('g-avance', {
            chart: {
                type: 'solidgauge',
                height: '110%'                
            },
            title: {
                text: '',
                style: {
                    fontSize: '24px'
                }
            },
            tooltip: {
                    alwaysVisible: true,
                borderWidth: 0,
                backgroundColor: 'none',
                shadow: false,
                style: {
                    fontSize: '16px'
                },
                valueSuffix: '%',
                pointFormat: '{series.name}<br><span style="font-size:2em; color: {point.color}; font-weight: bold">{point.y}</span>',
                positioner: function (labelWidth) {
                    return {
                        x: (this.chart.chartWidth - labelWidth) / 2,
                        y: (this.chart.plotHeight / 2) + 15
                    };
                }
            },
            pane: {
                startAngle: 0,
                endAngle: 360,
                background: [<?=$background?>]
            },
            yAxis: {
                min: 0,
                max: 100,
                lineWidth: 0,
                tickPositions: []
            },
            plotOptions: {
                solidgauge: {
                    dataLabels: {
                        enabled: false
                    },
                    linecap: 'round',
                    stickyTracking: true,
                    rounded: true
                }
            },
            series: [<?=$series?>]
        });

        var chart = $('#g-avance').highcharts(),
                point = chart.series[0].points[0];
        point.onMouseOver(); // Show the hover marker
        chart.tooltip.refresh(point); // Show the tooltip
        chart.tooltip.hide = function () {};
    });
    
    
    function regresarActs(){
        console.log('Estas Regresando')
        <?php if($eje > 0){ ?>
        var variables = {
            anio: <?=$anio?>,
            eje: <?=$eje?>,
            dep: <?=$dep?>
        }
        cargar('<?= base_url(); ?>index.php/C_dash/list_acts', '#datos', 'POST', variables);
        <?php } else {?>
            $("#search").trigger("click");
        <?php } ?>
    }
    
    function enviarCorreo(e,f){
        e.preventDefault();

        $.ajax({         
            type: "POST",
            url: "<?=base_url()?>C_dash/enviar_correo", //Nombre del controlador
            data: $(f).serialize(),
            success: function(resp) {
                var response = JSON.parse(response);
                if(response.resp){
                    alerta('El correo ha sido enviado','success');
                    $("#mensaje").val('');

                } else {
                    alerta('El correo no puede ser enviado. Error:'+response.mensaje,'error');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
            }
        });

    }

    function verGrafEntregables() {
        var variables = {
            anio: <?=$anio?>,
            idAct: <?=$idAct?>,
            idEnt: $('#idEnt').val()
        }
        cargar('<?= base_url(); ?>index.php/C_dash/ver_graf_entregable', '#div-g-entregables', 'POST', variables);
    }

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
</script>