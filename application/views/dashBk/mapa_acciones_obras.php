<script type="text/javascript">
	var datos2 = [<?=$datamun?>];
    var op = Number(<?=$op;?>);
    if(op==2) 
        var accion = 'Acciones:<b>{point.acciones:,.0f}';
    else
        var accion = 'Población:<b>{point.population:,.0f}';

	 $(document).ready(function() {
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
                pointFormat:'<h4 class="font-weight-bold text-center">{point.name}</h4><br>'+accion+'</b>  <br>Ejercido: <b>${point.value:,.2f}</b>'
            },
            series: [{
                type: "map",
                joinBy: ['id', 'id'],
                data: datos2,
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