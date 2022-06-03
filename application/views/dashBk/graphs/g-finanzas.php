<style type="text/css">
	.rojo {
		color: #FF0000;
	}

	.verde {
		color: #008000;
	}
</style>

<div class="card">
    <div class="card-body">
    	<div class="row">
            <div class="col-12 mb-2 text-center">
                <h2 style="font-weight:700;color:#000080;"> Información financiera </h2>
            </div>
        </div>
		<div class="row">
		    <div class="col-lg-12 text-center mb-4">		        
                <div id="g-finanzas" style="max-width: 400px; max-width:100%"></div>		            
		    </div>
		</div>
		<div class="row">
		    <div class="col-lg-12" id="tabla-finanzas">		        
            	<div class="alert alert-info"><p><i class="fas fa-exclamation"></i> Haga clic sobre la gráfica para ver el comparativo de cantidades</p></div>
		    </div>
		</div>
	</div>
</div>

<script type="text/javascript">
		var cat_mes = [];
	$(document).ready(function (){		
		function set_catMeses(meses){
			cat_mes = meses;
		}
		set_catMeses(<?= $data_fin["categorias"]?>);
		Highcharts.chart('g-finanzas', {
			credits: false,
		    chart: {
		        type: 'column'
		    },		   	
		    title: {
		        text: ''
		    },
		    xAxis: {
		        categories: cat_mes,
		        crosshair: true
		    },
		    yAxis: {
		        min: 0,
		        title: {
		            text: 'Pesos ($)'
		        }
		    },
		    tooltip: {
		        headerFormat: '<table><tr><td colspan="2" align="center"><span style="font-size:14px"><b>{point.key}</b></span></td></tr>',
		        pointFormat: '<tr><td style="padding:0"><b>{series.name}: </b></td>' +
		            '<td style="padding:0" align="right">$ {point.y:,.2f}</td></tr>',
		        footerFormat: '</table><br> <i>Haga clic para mostrar la tabla comparativa por año</i>',
		        shared: true,
		        useHTML: true
		    },
		    plotOptions: {
		        column: {
		            pointPadding: 0.2,
		            borderWidth: 0,
		            cursor: 'pointer',
		            dataLabels: {
		                enabled: true
		            },
		            point: {
                        events: {
                            click: function() {
                            	verTablaComp(this.category)
                            }
                        }
                    }

		        },
		        series: {
		            /*cursor: 'pointer',
		            events: {
		                click: function (event) {
		                	console.log(this);
		                    console.log(this.category);
		                }
		            }*/
		        }
		    },
		    series: [<?=$data_fin['series']?>]
		});

	});

	var arrayFin = <?=$data_fin['arrayFin']?>; 

	function verTablaComp(anio){
		var anioIni = 2021;
		var anioFin = cat_mes[cat_mes.length - 1].split(" ");
		anioFin = parseInt(anioFin[1],10);
		anio = anio.split(" ");
		anio = anio[1];

		var th = '<th></th>';
		//console.log(arrayFin);
		
		var td1 = '<td>Presupuesto</td>';
		var td2 = '<td>Autorizado</td>';
		var td3 = '<td>Modificado</td>';
		var td4 = '<td>Ejercido</td>';


		for (var i = 0; i < cat_mes.length; i++) {
			anio = cat_mes[i].split(" ");
		    anio = anio[1];
			if(cat_mes[i] == "Febrero 2021"){
				break;
			}

					var dif1 = arrayFin.Presupuesto[anioIni][0] -  (!esNuloVacio(arrayFin.Presupuesto[anio][i]) ? arrayFin.Presupuesto[anio][i] : 0);
					var dif2 = arrayFin.Autorizado[anioIni][0] - (!esNuloVacio(arrayFin.Autorizado[anio][i]) ? arrayFin.Autorizado[anio][i] : 0) ;
					var dif3 = arrayFin.Modificado[anioIni][0] - (!esNuloVacio(arrayFin.Modificado[anio][i]) ? arrayFin.Modificado[anio][i] : 0 );
					var dif4 = arrayFin.Ejercido[anioIni][0] - (!esNuloVacio( arrayFin.Ejercido[anio][i]) ? arrayFin.Ejercido[anio][i] : 0);
					
					var class1 = (dif1 == 0) ? "" : (dif1 > 0) ? "verde" : "rojo";
					var class2 = (dif2 == 0) ? "" : (dif2 > 0) ? "verde" : "rojo";
					var class3 = (dif3 == 0) ? "" : (dif3 > 0) ? "verde" : "rojo";
					var class4 = (dif4 == 0) ? "" : (dif4 > 0) ? "verde" : "rojo";


						// var getanio = cat_mes[a].split(" ");
						// anioFin = parseInt(getanio[1],10);
						if(i == anio){
						th += '<th align="center"><b>'+cat_mes[i]+'</b></th>';
						td1 += '<td align="right"><b>'+number_format(arrayFin.Presupuesto[anio][i],2)+'</b></td>';
						td2 += '<td align="right"><b>'+number_format(arrayFin.Autorizado[anio][i],2)+'</b></td>';
						td3 += '<td align="right"><b>'+number_format(arrayFin.Modificado[anio][i],2)+'</b></td>';
						td4 += '<td align="right"><b>'+number_format(arrayFin.Ejercido[anio][i],2)+'</b></td>';
					} else {
						
						th += '<th align="center">'+cat_mes[i]+'</th>';
						td1 += '<td align="right">'+number_format(arrayFin.Presupuesto[anio][i],2)+'<br><span class="'+class1+'">( '+number_format(dif1,2)+' )</span></td>';
						td2 += '<td align="right">'+number_format(arrayFin.Autorizado[anio][i],2)+'<br><span class="'+class2+'">( '+number_format(dif2,2)+' )</span></td>';
						td3 += '<td align="right">'+number_format(arrayFin.Modificado[anio][i],2)+'</br><span class="'+class3+'">( '+number_format(dif3,2)+' )</span></td>';
						td4 += '<td align="right">'+number_format(arrayFin.Ejercido[anio][i],2)+'</br><span class="'+class4+'">( '+number_format(dif4,2)+' )</span></td>';
					}
			
		};
		var html = '<div class="row"><div class="col-12 text-right mb-4"><button class="btn btn-default" id="btnTable" onclick="mostOculTable();">Ocultar tabla</button></div></div>'+
			'<table class="table table-bordered table-hover" id="tableFinanzas">' +
            		'<thead style="background-color:#011f4b; color:#FFFFFF;">' +
            			'<tr>'+th+'</tr>' +
            		'</thead>' +
            		'<tbody>' +
            			'<tr>'+td1+'</tr>' +
            			'<tr>'+td2+'</tr>' +
            			'<tr>'+td3+'</tr>' +
            			'<tr>'+td4+'</tr>' + 
            		'</tbody>' +            		
            	'</table>';

		$("#tabla-finanzas").html(html);
		   // Scroll
        $('html,body').animate({
        	scrollTop: $("#tabla-finanzas").offset().top},
        'slow');
	}

	function mostOculTable(){
		if($("#tableFinanzas").is(":visible")){
			$("#tableFinanzas").hide();
			$("#btnTable").html('Mostrar tabla');
		}
		else{
			$("#tableFinanzas").show();
			$("#btnTable").html('Ocultar tabla');
		}
		
	}
	function esNuloVacio (valor){
		var resp = false;
		if(valor == undefined){
			resp = true;
		}
		if(typeof valor == 'undefined'){
			resp = true;
		}
		if(valor == null){
			resp = true;
		}
		if(valor == ""){
			resp = true;
		}
		if(valor == ''){
			resp = true;
		}
	}
	// function verTablaComp(anio){
	// 	var anioIni = 2018;
	// 	var anioFin = $anio;

	// 	var th = '<th></th>';
	// 	//console.log(arrayFin);
		
	// 	var td1 = '<td>Presupuesto</td>';
	// 	var td2 = '<td>Autorizado</td>';
	// 	var td3 = '<td>Modificado</td>';
	// 	var td4 = '<td>Ejercido</td>';

	// 	for (var i = anioIni; i <= anioFin; i++) {
	// 		var dif1 = arrayFin.Presupuesto[anio] - arrayFin.Presupuesto[i];
	// 		var dif2 = arrayFin.Autorizado[anio] - arrayFin.Autorizado[i];
	// 		var dif3 = arrayFin.Modificado[anio] - arrayFin.Modificado[i];
	// 		var dif4 = arrayFin.Ejercido[anio] - arrayFin.Ejercido[i];
			
	// 		var class1 = (dif1 == 0) ? "" : (dif1 > 0) ? "verde" : "rojo";
	// 		var class2 = (dif2 == 0) ? "" : (dif2 > 0) ? "verde" : "rojo";
	// 		var class3 = (dif3 == 0) ? "" : (dif3 > 0) ? "verde" : "rojo";
	// 		var class4 = (dif4 == 0) ? "" : (dif4 > 0) ? "verde" : "rojo";


	// 		if(i == anio){
	// 			th += '<th align="center"><b>'+i+'</b></th>';
	// 			td1 += '<td align="right"><b>'+number_format(arrayFin.Presupuesto[i],2)+'</b></td>';
	// 			td2 += '<td align="right"><b>'+number_format(arrayFin.Autorizado[i],2)+'</b></td>';
	// 			td3 += '<td align="right"><b>'+number_format(arrayFin.Modificado[i],2)+'</b></td>';
	// 			td4 += '<td align="right"><b>'+number_format(arrayFin.Ejercido[i],2)+'</b></td>';
	// 		} else {
				
	// 			th += '<th align="center">'+i+'</th>';
	// 			td1 += '<td align="right">'+number_format(arrayFin.Presupuesto[i],2)+'<br><span class="'+class1+'">( '+number_format(dif1,2)+' )</span></td>';
	// 			td2 += '<td align="right">'+number_format(arrayFin.Autorizado[i],2)+'<br><span class="'+class2+'">( '+number_format(dif2,2)+' )</span></td>';
	// 			td3 += '<td align="right">'+number_format(arrayFin.Modificado[i],2)+'</br><span class="'+class3+'">( '+number_format(dif3,2)+' )</span></td>';
	// 			td4 += '<td align="right">'+number_format(arrayFin.Ejercido[i],2)+'</br><span class="'+class4+'">( '+number_format(dif4,2)+' )</span></td>';
	// 		}
		
	// 	};
	// 	var html = '<div class="row"><div class="col-12 text-right mb-4"><button class="btn btn-default" id="btnTable" onclick="mostOculTable();">Ocultar tabla</button></div></div>'+
	// 		'<table class="table table-bordered table-hover" id="tableFinanzas">' +
    //         		'<thead style="background-color:#011f4b; color:#FFFFFF;">' +
    //         			'<tr>'+th+'</tr>' +
    //         		'</thead>' +
    //         		'<tbody>' +
    //         			'<tr>'+td1+'</tr>' +
    //         			'<tr>'+td2+'</tr>' +
    //         			'<tr>'+td3+'</tr>' +
    //         			'<tr>'+td4+'</tr>' + 
    //         		'</tbody>' +            		
    //         	'</table>';

	// 	$("#tabla-finanzas").html(html);
	// 	   // Scroll
    //     $('html,body').animate({
    //     	scrollTop: $("#tabla-finanzas").offset().top},
    //     'slow');
	// }
</script>

