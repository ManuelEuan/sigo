<div class="row">
    <div class="col-4 mb-4">
        <hr style="border:6px; background-color:#000080 !important;">
            <div class="row">
                <div class="col-8 text-center"><h1 style="font-weight:700;color:#000080;" class="count"><?=$n_actividades;?></h1>
                    <h5 style="font-weight:500;">Actividadesf</h5></div>
                <div class="col-4"><h1 style="color:#000080;"><i class="fas fa-book fa-lg"></i></h1></div>
            </div>
        </div>

        <div class="col-4 mb-4">
            <hr style="border:6px; background-color:#000080 !important;">
            <div class="row">
                <div class="col-8 text-center"><h1 style="font-weight:700;color:#000080;" class="count"><?=$n_entregables;?></h1>
                    <h5 style="font-weight:500;">Entregables</h5></div>
                <div class="col-4"><h1 style="color:#000080;"><i class="fas fa-pen-square fa-lg"></i></h1></div>
            </div>
        </div>

        <div class="col-4 mb-4">
            <hr style="border:6px; background-color:#000080 !important;">
            <div class="row">
                <div class="col-8 text-center"><h1 style="font-weight:700;color:#000080;" class="count"><?=$gasto?></h1>
                    <h5 style="font-weight:500;">Gasto ejercido</h5></div>
                <div class="col-4"><h1 style="color:#000080;"><i class="fas fa-money-bill-alt fa-lg"></i></h1></div>
            </div>
        </div>
</div>
<div class="row">
    <div class="col-lg-6 text-center">
        <div class="card">
            <div class="card-body">
                <div id="g-avance-anual" style="width: 400px; height: 400px; margin: 0 auto"></div>
            </div>
        </div>
    </div>
    <div class="col-6">
    <?php
    if(count($actividades) > 0)
    {
        echo '<table class="table table-bordered table-striped" id="tabla-actividades">
              <thead>
                  <th>Actividad</th>
                  <th>Avance</th>
              </thead>
              <tbody>';
        $result = $actividades;
        foreach ($result as $row)
        {
            $avance = $row->nAvance;
            echo '<tr title="Haga clic para ver más información" style="cursor:pointer;" onclick="irActividad('.$row->iIdActividad.')">
                    <td>'.$row->vActividad.'</td>
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
<script>
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
    })
    </script>