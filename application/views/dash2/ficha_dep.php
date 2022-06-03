<div class="page-breadcrumb">
    <div class="row">
        <div class="col-10 align-self-center">
            <h3 class="page-title"><?=$dependencia->vDependencia;?></h3>
        </div>
        <div class="col-md-2 mb-2 text-right">
            <div class="button-group">
                <button title="Ir a la pantalla anterior" id="regresarbtnent" type="button" class="btn waves-effect waves-light btn-outline-info" style="margin-top:35px" onclick="recuperar(event)"><i class="mdi mdi-arrow-left"></i>&nbsp;Regresar...</button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">

    
    <!-- Compromisos-->
    <?php
    // Gráfica todos los compromisos por estatus 
    if($est_compromiso->num_rows() > 0)
    {
        $result = $est_compromiso->result();

        $data_comp_est = '';
        $total = 0;
        $html = '';
        foreach ($result as $row) 
        {
            $estatus = ($row->vEstatus == 'Cumplido') ? 'Cumplidos' : $row->vEstatus;
            $data_comp_est.= ($data_comp_est != '') ? ',':'';
            $data_comp_est.= ($row->vEstatus == 'Cumplido' ) ? "{name:'$row->vEstatus',color: \"$row->vColor\", y:$row->numcomp, sliced: true,
    selected: true}":"{name:'$row->vEstatus',color: \"$row->vColor\",y:$row->numcomp}";
            $html.= '<div class="col-4 text-center"><h4 style="color:'.$row->vColor.';font-weight:700;">'.$row->numcomp.'</h4><h5>'.$estatus.'</h5></div>';
            $total+= $row->numcomp;
        }
    ?>
        <div class="row">
            
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                        <div class="col-lg-6 text-center">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 text-center" style="margin:auto;"><h1 style="font-weight:700;color:#000080;"><?=$total;?></h1><h2>Compromisos</h2></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" id="g-avance-compromisos" class="m-t-30" style="min-height:250px; width:100%;margin:auto;">
                                    </div>
                                </div>
                                <div class="row">
                                    <?=$html;?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                    <?php
                    if($compromisos->num_rows() > 0)
                    {
                        echo '<table class="table table-bordered table-striped" id="tabla-compromisos">
                              <thead>
                                  <th>#</th>
                                  <th>Compromiso</th>
                                  <th>Avance</th>
                                  <th>Estatus</th>
                              </thead>
                              <tbody>';
                        $result = $compromisos->result();
                        foreach ($result as $row)
                        {
                            echo '<tr>
                                    <td>'.$row->iNumero.'</td>
                                    <td>'.$row->vCompromiso.'</td>
                                    <td>'.$row->dPorcentajeAvance.'</td>
                                    <td>'.$row->vEstatus.'</td>
                                </tr>';
                        }

                        echo '</tbody>
                            </table>';
                    }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>

    <!-- Actividades-->

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <label> Seleccione un año para conocer su avance</label>
                    <select class="form-control" onchange="consultaAnio();" id="selAnioDep">
                        <?=$anios;?>
                    </select>
                </div>
            </div>

            <div id="divAnioDep">
                <div class="row">
                    <div class="col-4 mb-4">
                        <hr style="border:6px; background-color:#000080 !important;">
                            <div class="row">
                                <div class="col-8 text-center"><h1 style="font-weight:700;color:#000080;" class="count"><?=$n_actividades;?></h1>
                                    <h5 style="font-weight:500;">Acciones</h5></div>
                                <div class="col-4"><h1 style="color:#000080;"><i class="fas fa-book fa-lg"></i></h1></div>
                            </div>
                        </div>

                        <div class="col-4 mb-4">
                            <hr style="border:6px; background-color:#000080 !important;">
                            <div class="row">
                                <div class="col-8 text-center"><h1 style="font-weight:700;color:#000080;" class="count"><?=$n_entregables;?></h1>
                                    <h5 style="font-weight:500;">Indicadores</h5></div>
                                <div class="col-4"><h1 style="color:#000080;"><i class="fas fa-pen-square fa-lg"></i></h1></div>
                            </div>
                        </div>

                        <div class="col-4 mb-4">
                            <hr style="border:6px; background-color:#000080 !important;">
                            <div class="row">
                                <div class="col-8 text-center"><h1 style="font-weight:700;color:#000080;" class="count"><?=$gasto?></h1>
                                    <h5 style="font-weight:500;">Monto pagado</h5></div>
                                <div class="col-4"><h1 style="color:#000080;"><i class="fas fa-money-bill-alt fa-lg"></i></h1></div>
                            </div>
                        </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="card">
                            <div class="card-body">
                                <div id="g-avance-anual" style="width: 400px; height: 400px; margin: 0 auto"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                    <?php
                    if(count($actividades) > 0)
                    {
                        echo '<table class="table table-bordered table-striped" id="tabla-actividades">
                              <thead>
                                  <th>Acciones</th>
                                  <th>Total de beneficiarios</th>
                                  <th>Presupuesto Ejercido</th>
                                  <th>Avance</th>
                              </thead>
                              <tbody>';
                        $result = $actividades;
                        foreach ($result as $row)
                        {
                            $avance = round($row->nAvance);
                            $clase = 'success';
                            $classPre = 'success';

                            if($avance >= 0 && $avance < 25)
                                $clase = 'danger';
                            elseif($avance >= 25 && $avance < 80)
                                $clase = 'warning';
                                
                            if($row->presupuesto >= 0 && $row->presupuesto  < 25)
                                $classPre = 'danger';
                            elseif($row->presupuesto >= 25 && $row->presupuesto  < 80)
                                $classPre = 'warning';

                            echo '<tr title="Haga clic para ver más información" style="cursor:pointer;" onclick="irActividad('.$row->iIdActividad.')">
                                    <td>'.$row->vActividad.'</td>
                                    <td>'.$row->beneficiario.'</td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar progress-bar-striped bg-'.$classPre.'" role="progressbar" style="width:'.$row->presupuesto.'%;" aria-valuenow="'.$row->presupuesto.'" aria-valuemin="0" aria-valuemax="100"><span class="text-center d-flex position-absolute" style="font-weight:bold;color:#000000;">'.number_format($row->presupuesto, 2).'%</span></div>
                                        </div>
                                    </td>
                                    <td><div class="progress" style="height: 20px;">
                                          <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width:'.round($avance).'%;" aria-valuenow="'.round($avance).'" aria-valuemin="0" aria-valuemax="100"><span class="text-center d-flex position-absolute" style="font-weight:bold;color:#000000;">'.round($avance).'%</span></div>
                                        </div>
                                    </td>
                                </tr>';
                        }

                        echo '</tbody>
                            </table>';
                    }
                    ?>
                    </div>
                </div>
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
        $('.count').each(function () {
            $(this).prop('Counter',0).animate({
                Counter: $(this).text()
            }, {
                duration: 4000,
                easing: 'swing',
                step: function (now) {
                    var n_format = Math.ceil(now);
                    n_format = number_format(n_format);
                    $(this).text(n_format);
                }
            });
        });

        $("#tabla-compromisos, #tabla-actividades").dataTable();
        <?php
        if($est_compromiso->num_rows() > 0)
        { ?>
            // Gráfica de compromisos por estatus
        Highcharts.chart('g-avance-compromisos', {
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
        <?php } ?>
        // Gráfica de avance anual
        Highcharts.chart('g-avance-anual', {
            chart: {
                type: 'solidgauge',
                height: '110%'                
            },
            title: {
                text: 'Avance de cumplimiento',
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

        var chart = $('#g-avance-anual').highcharts(),
                point = chart.series[0].points[0];
        point.onMouseOver(); // Show the hover marker
        chart.tooltip.refresh(point); // Show the tooltip
        chart.tooltip.hide = function () {};
      
    });

    function irActividad(id){
        var variables = {
          tipo: 2,
          id: id
        }
        cargar('<?= base_url(); ?>index.php/C_dash/ver_detalle', '#datos', 'POST', variables);
    }

    function consultaAnio(){
        var variables = {
          anio: $('#selAnioDep').val(),
          idDep: <?=$idDep?>
        }
        cargar('<?= base_url(); ?>index.php/C_dash2/avan_anio', '#divAnioDep', 'POST', variables);
    }

    function number_format(number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}
</script>