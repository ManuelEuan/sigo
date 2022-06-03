<div class="row">
    <div class="col-lg-12 text-center">
        <div id="g-metas-ent" style="max-width:100%"></div>
    </div>
</div>

 <div class="row">
    <div class="col-lg-6 text-center">
        <div id="g-avan-ent" style="max-width: 400px; max-width:100%"></div>
    </div>
    <div class="col-lg-6 text-center">
        <div id="g-ejer-ent" style="max-width: 400px; max-width:100%"></div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 text-center">
        <div id="g-map" style="max-width: 400px; max-width:100%"></div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.3.15/proj4.js"></script>
<script src="https://code.highcharts.com/mapdata/countries/us/us-all.js"></script>
<script type="text/javascript">
	var cat_mes = [];
	var categories = ['Oct 2021', 'Nov 2021', 'Dic 2021','Ene 2022'];
	var credits = false;
	$(document).ready(function (){
        function set_catMeses(meses){
			cat_mes = meses;
		}
		set_catMeses(<?= $data_fin["categorias"]?>);
        Highcharts.chart('g-metas-ent', {
            credits: false,
            chart: {
                type: 'column'
            },          
            title: {
                text: 'Avance vs Metas'
            },
            xAxis: {
                categories: cat_mes,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: '<?=$unidad?>'
                }
            },
            tooltip: {
                headerFormat: '<table><tr><td colspan="2" align="center"><span style="font-size:14px"><b>{point.key}</b></span></td></tr>',
                pointFormat: '<tr><td style="padding:0"><b>{series.name}:</b> </td>' +
                    '<td style="padding:0" align="right">{point.y:,.2f}{point.avance}</td></tr>',
                footerFormat: '</table> <br> <i>Haga clic para ver el avance del año seleccionado</i>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    grouping: false,
                    shadow: false,
                    pointPadding: 0.2,
                    borderWidth: 0,
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function() {
                                var category = this.category
                                Highcharts.each(series1.series, function(p, i) {                                    
                                    if (category === parseInt(p.name)) {
                                        p.show();                                      
                                    }else {
                                        p.hide();
                                    }
                                });
                                Highcharts.each(series2.series, function(p, i) {                                    
                                    if (category === parseInt(p.name)) {
                                        p.show();                                      
                                    }else {
                                        p.hide();
                                    }
                                });
                                $('html,body').animate({
                                    scrollTop: $("#g-avan-ent").offset().top},
                                'slow');
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true
                    }

                }
            },
            series: [<?=$data['series']?>]
        });

		var series1 = Highcharts.chart('g-avan-ent', {
            colors: ['#005b96', '#ff3377', '#3d1e6d', '#851e3e', '#b3cde0', '#451e3e', '#851e3e'],
			credits: credits,
		    chart: {
		        type: 'line'
		    },
		    title: {
		        text: 'Avance mensual'
		    },
		    xAxis: {
		        categories: categories
		    },
		    yAxis: {
		        title: {
		            text: '<?=$unidad?>'
		        }
		    },
		    plotOptions: {
		        line: {
		            dataLabels: {
		                enabled: true
		            },
		            enableMouseTracking: true
		        },                
		    },
		    series: [<?=$data['d_avan']?>]
		});

		var series2 = Highcharts.chart('g-ejer-ent', {
            colors: ['#005b96', '#ff3377', '#3d1e6d', '#851e3e', '#b3cde0', '#451e3e', '#851e3e'],
			credits: credits,
		    chart: {
		        type: 'line'
		    },
		    title: {
		        text: 'Ejercido mensual'
		    },
		    xAxis: {
		        categories: categories
		    },
		    yAxis: {
		        title: {
		            text: 'Pesos ($)'
		        }
		    },
            tooltip: {
                pointFormat: '<b>{point.y:,.2f}</b>'
            },
		    plotOptions: {
		        line: {
		            dataLabels: {
		                enabled: true,
                         format: '<b>{point.y:,.2f}</b>',
		            },
		            enableMouseTracking: true
		        }
		    },
		    series: [<?=$data['d_ejer']?>]
		});
	});
</script>
<!-- 
<script type="text/javascript">
	var categories = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
	var credits = false;
	$(document).ready(function (){
        Highcharts.chart('g-metas-ent', {
            credits: false,
            chart: {
                type: 'column'
            },          
            title: {
                text: 'Avance vs Metas'
            },
            xAxis: {
                categories: [<?=$data['anios']?>],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: '<?=$unidad?>'
                }
            },
            tooltip: {
                headerFormat: '<table><tr><td colspan="2" align="center"><span style="font-size:14px"><b>{point.key}</b></span></td></tr>',
                pointFormat: '<tr><td style="padding:0"><b>{series.name}:</b> </td>' +
                    '<td style="padding:0" align="right">{point.y:,.2f}{point.avance}</td></tr>',
                footerFormat: '</table> <br> <i>Haga clic para ver el avance del año seleccionado</i>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    grouping: false,
                    shadow: false,
                    pointPadding: 0.2,
                    borderWidth: 0,
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function() {
                                var category = this.category
                                Highcharts.each(series1.series, function(p, i) {                                    
                                    if (category === parseInt(p.name)) {
                                        p.show();                                      
                                    }else {
                                        p.hide();
                                    }
                                });
                                Highcharts.each(series2.series, function(p, i) {                                    
                                    if (category === parseInt(p.name)) {
                                        p.show();                                      
                                    }else {
                                        p.hide();
                                    }
                                });
                                $('html,body').animate({
                                    scrollTop: $("#g-avan-ent").offset().top},
                                'slow');
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true
                    }

                }
            },
            series: [<?=$data['series']?>]
        });

		var series1 = Highcharts.chart('g-avan-ent', {
            colors: ['#005b96', '#ff3377', '#3d1e6d', '#851e3e', '#b3cde0', '#451e3e', '#851e3e'],
			credits: credits,
		    chart: {
		        type: 'line'
		    },
		    title: {
		        text: 'Avance mensual'
		    },
		    xAxis: {
		        categories: categories
		    },
		    yAxis: {
		        title: {
		            text: '<?=$unidad?>'
		        }
		    },
		    plotOptions: {
		        line: {
		            dataLabels: {
		                enabled: true
		            },
		            enableMouseTracking: true
		        },                
		    },
		    series: [<?=$data['d_avan']?>]
		});

		var series2 = Highcharts.chart('g-ejer-ent', {
            colors: ['#005b96', '#ff3377', '#3d1e6d', '#851e3e', '#b3cde0', '#451e3e', '#851e3e'],
			credits: credits,
		    chart: {
		        type: 'line'
		    },
		    title: {
		        text: 'Ejercido mensual'
		    },
		    xAxis: {
		        categories: categories
		    },
		    yAxis: {
		        title: {
		            text: 'Pesos ($)'
		        }
		    },
            tooltip: {
                pointFormat: '<b>{point.y:,.2f}</b>'
            },
		    plotOptions: {
		        line: {
		            dataLabels: {
		                enabled: true,
                         format: '<b>{point.y:,.2f}</b>',
		            },
		            enableMouseTracking: true
		        }
		    },
		    series: [<?=$data['d_ejer']?>]
		});
	});
</script> -->