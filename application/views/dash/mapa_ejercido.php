<div id="mapaMunicipios" style="height: 100%; min-width: 100%; max-width: 100%; margin: 0 auto"></div>
<script type="text/javascript">
    var mapa;
    $(document).ready(function(){
        // Mapa
        Highcharts.setOptions({
            lang: {
                thousandsSep: ','
            }
        });
        mapa = $('#mapaMunicipios').highcharts('Map', {
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
        });
    });
</script>