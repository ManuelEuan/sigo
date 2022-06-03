<section>
    <h2 style="color:#<?=$row_eje->vColorDesca;?>;font-weight: bold;" align="center"><?=$row_eje->vEje?></h2>
    <input type="hidden" name="iIdEje" id="iIdEje" value="<?=$iIdEje?>">
    <input type="hidden" name="anio" id="anio" value="<?=$anio?>">
    <div class="row">
        <div class="col-11 text-center">
            <h3 class="font-weight-bold text-center">Actividades con avance por trimestre</h3>
        </div>
        <div class="col-1 text-right">
            <button type="button" class="btn btn-default" onclick="refrescar();"><i class="mdi mdi-refresh"></i></button>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-4">
            <div class="p-10 bg-white">
               <div class="d-flex align-items-center" >
                    <div>
                        <h3 class="font-light m-b-5"><?=$total_actividades?></h3>
                        <span class="text-muted">Total de actividades</span>
                    </div>
                    <div class="ml-auto">
                        <h1><i class="mdi mdi-flag-checkered text-primary"></i></h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="p-10 bg-white">
                <div class="d-flex align-items-center">
                    <div>
                        <h3 class="font-light m-b-5"><?=$total_dependencias?></h3>
                        <span class="text-muted">Total de dependencias</span>
                    </div>
                    <div class="ml-auto">
                        <h1><i class="mdi mdi-hospital-building"></i></h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="p-10 bg-white">
                <div class="d-flex align-items-center">
                    <div>
                            <h3 class="font-light m-b-5"><?=$ult_fecha?></h3>
                        <span class="text-muted">Fecha útimo avance capturado</span>
                    </div>
                    <div class="ml-auto">
                        <h1><i class="mdi mdi-calendar text-success"></i></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>

    
    <?php 
    for ($i=1; $i < 5 ; $i++)
    {
    ?>
    <div class="row">
        <div class="col-md-12" style="">
            <div class="card" style="background-color: #FFFFFF !important;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h5 class="font-weigh-bold">TRIMESTRE <?=$i?></h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div id="trim<?=$i?>" class="m-t-30" style="height:200px; width:100%;">
                                <?php if(${'trim'.$i} == '') echo 'No se encontraron datos para mostrar' ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="contenido<?=$i?>"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
</section>
<script type="text/javascript">
    $(document).ready(function(){
    <?php for ($i=1; $i < 5 ; $i++)
        { 
            if(${'trim'.$i} != ''){ ?>
        Highcharts.chart('trim<?=$i?>', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            credits: {
                enabled: false
            },
            title: {
                text: ''
            },
            tooltip: {
                pointFormat: '<h4 class="font-weight-bold text-center">{point.name}</h4><br>Porcentaje:<b>{point.percentage:.2f}%</b><br>#Actividades: <b>{point.y:,.0f}</b>'
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
                                
                            },
                            click: function (e) {
                                //console.log(e.point.trimestre);
                                verActividades(e.point.trimestre,e.point.op);
                                        
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
                },
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Actividades',
                colorByPoint: true,
                data: [<?=${'trim'.$i}?>]
            }]
        });
    <?php }
    } ?>
    });

    function refrescar(){
        var datos = 'id=' + $('#iIdEje').val() + '&anio=' + $('#anio').val();
        cargar('<?=base_url();?>index.php/C_dash/ficha_eje','#datos','POST', datos);
    }

    function verActividades(trim,op){
        var datos = 'id=' + $('#iIdEje').val() + '&anio=' + $('#anio').val() + '&trim=' + trim + '&op=' + op;
        cargar('<?=base_url();?>index.php/C_dash/tabla_act','#contenido'+trim,'POST', datos);
    }

    function cerrarTabla(trim)
    {
        $("#contenido"+trim).html('');
    }

    function descargarFichaActividad(iIdDetalleActividad) {
        window.open("<?= base_url() ?>C_pat/ShowFichaActividad/"+iIdDetalleActividad,"_blank");
    }
</script>