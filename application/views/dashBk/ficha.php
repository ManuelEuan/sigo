<style type="text/css">
    .rosa{
        color:#e61980 !important;
    }
</style>
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-10 align-self-center">
            <h4 class="page-title"><?=$vActividad;?><br>
                <a href="#div-mensaje" title="Escribir mensaje para el responsable" data-toggle="collapse"><i class="mdi mdi-message-draw"></i></a>
                
            </h4>
        </div>
        <div class="col-md-2 mb-2 text-right">
            <div class="button-group">
                <button title="Ir a la pantalla anterior" id="regresarbtnent" type="button" class="btn waves-effect waves-light btn-outline-info" style="margin-top:35px" onclick="regresar(event)"><i class="mdi mdi-arrow-left"></i>&nbsp;Regresar</button>
            </div>
        </div>
    </div>
</div><br>

<div class="container-fluid">
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

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12"><a href="#div-info-act" class="btn btn-info" data-toggle="collapse"><i class="mdi mdi-information-outline"></i> Ver datos generales de la actividad</a></div>
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
        </div>
    </div>

    <!-- Presupuesto presupuesto vs modificado vs gasto-->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div id="g-gasto"></div>
                    <div id="g-gasto-mes"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
           <div class="row">
                <div class="col-12">
                    <a href="#div-presupuesto-anio" class="btn btn-info" data-toggle="collapse"><i class="mdi mdi-information-outline"></i> Mostrar presupuesto por año</a>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-12">
                    <div id="div-presupuesto-anio" class="collapse">
                        <h5 class="card-title font-weight-bold">Presupuesto por año</h5>
                       
                        <?php 
                        foreach ($tablas_fin as $tabla)
                        {
                            echo $tabla;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div id="g-avance-ent"></div>
                    <table class="table table-hover table-bordered">
                        <thead class="bg-inverse text-white">
                            <tr>
                                <th>ID</th>
                                <th>Indicador</th>
                            </tr>
                        </thead>
                        <tbody>
            
                        <?php 
                        foreach ($dat_entreg as $vtent)
                            {
                                echo '<tr>
                                        <td>'.$vtent['entid'].'</td>
                                        <td align="left">'.$vtent['nombre'].'</td>
                                    </tr>';
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Se va a sustituir
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div id="g-avance"></div>                    
                </div>
            </div>
        </div>
    </div>-->    

        

    <!--
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div id="g-avancefin-ent"></div>
                </div>
            </div>
        </div>
    </div> 
    
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div id="g-benef"></div>                    
                </div>
            </div>
        </div>
    </div>
    -->
    
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <a href="#div-entregables-anio" class="btn btn-info" data-toggle="collapse"><i class="mdi mdi-information-outline"></i> Mostrar entregables por año</a>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-12">
                    <div id="div-entregables-anio" class="collapse">
                        
                        <h5 class="card-title font-weight-bold">Entregables por año</h5>

                        <?php 
                        foreach ($tablas_entregables as $tabla)
                        {
                            echo $tabla;
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
    var datos = <?php echo json_encode($av); ?>;
    var datos_ben = <?php echo json_encode($ben); ?>;
    var datos_ent = <?php echo json_encode($av_ent); ?>;

    //console.log(datos);
    $(document).ready(function (){
        let beneficiarios = {
            anios: [],
            benef: []
        };

        let av = {
            anios: [],
            avance: []
        };

        let avent = []


        let arr1=[];

        datos_ent.entids.map(id => {
                arr1[id+""] = [];
                //console.log(id);
                datos_ent.anios.map(anio => {
                    //console.log(anio);
                    if(datos_ent.ent[anio][id] == undefined){
                        //console.log(0);
                        arr1[id].push(0);
                    }
                    else{
                        //console.log(datos_ent.ent[anio][id]);
                        arr1[id].push(Number(datos_ent.ent[anio][id]));
                    }
                });
                
            });

        arr1.map((id, index) => {
            let d = {name: ""+index, data: id};

            avent.push(d);


        });
        
        //console.log(avent);


        datos.map(anio => {

            av.anios.push(anio.iAnio);
            av.avance.push(parseInt(anio.nAvance));
        });

        datos_ben.map(anio => {
            beneficiarios.anios.push(anio.iAnio);
            beneficiarios.benef.push(parseInt(anio.beneficiarios));


        });

        

        /*Highcharts.chart('g-avance', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Avances - <?=$vActividad;?>'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: av.anios,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Avance'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:,.2f} %</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Avances',
                data: av.avance

            }]
        });*/

        Highcharts.chart('g-avance-ent', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Avance de los entregables'
            },
            credits: {
                        enabled: false
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: datos_ent.anios,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Avance'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:,.2f} %</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: avent
        });

        /*Highcharts.chart('g-benef', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Beneficiarios por año'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: beneficiarios.anios,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Beneficiarios'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:,.2f} </b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Beneficiarios',
                data: beneficiarios.benef

            }]
        });*/


        Highcharts.chart('g-gasto', {
            chart: {
                type: 'column'
            },
            credits: {
                enabled: false
            },
            title: {
                text: 'Presupuesto vs Modificado vs Gasto'
            },
            subtitle: {
                text: '' //'Source: WorldClimate.com'
            },
            xAxis: {
                categories: [<?=$categories_pre;?>],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Pesos ($)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:14px;font-weight:bold;">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:,.2f} </b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Presupuesto',
                data: [<?=$data_presupuesto?>],
                color: '#3E5F8A'

            },
            {
                name: 'Modificado',
                data: [<?=$data_modificado?>],
                color: '#7994b8'

            }, {
                name: 'Ejercido',
                data: [<?=$data_ejercido?>],
                color: '#CC0000'

            }]
        });

        // Avance de entregables por año
        Highcharts.chart('container', {
            chart: {
                type: 'bar'
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: ['Africa', 'America', 'Asia', 'Europe', 'Oceania'],
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Population (millions)',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' millions'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -40,
                y: 80,
                floating: true,
                borderWidth: 1,
                backgroundColor:
                    Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
                shadow: true
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Year 1800',
                data: [107, 31, 635, 203, 2]
            }, {
                name: 'Year 1900',
                data: [133, 156, 947, 408, 6]
            }, {
                name: 'Year 2000',
                data: [814, 841, 3714, 727, 31]
            }, {
                name: 'Year 2016',
                data: [1216, 1001, 4436, 738, 40]
            }]
        });


    });
    
    function regresar(e){
        e.preventDefault();
        var op = parseInt($("#eje_oculto").val());
        recuperar(e,op);

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
</script>