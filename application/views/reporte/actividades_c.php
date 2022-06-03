<!--titulo-->
<section>
	 <div class="page-breadcrumb">
		  <div class="row">
				<div class="col-5 align-self-center">
					 <h4 class="page-title">Reporte Acciones estrategicas</h4>
				</div>
				<div class="col-7 align-self-center">
					 <div class="d-flex align-items-center justify-content-end">
						  <nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									 <li class="breadcrumb-item">
										  
									 </li>
									 
								</ol>
						  </nav>
					 </div>
				</div>
		  </div>
	 </div>
</section>
<!--endtitulo-->
<br><br>
<!-- formulario -->
<section>
	 <div class="col-12">
		  <div class="card" style="padding: 2%;">
				<div class="col-md-12">
					 <h5>Filtrar por:</h5>
					 <hr>

					 <div class="row">
						  <div class="col-md-4">
								<div class="form-group">
									 <label for="SelEje">*Eje</label>
									 <select class="form-control" id="SelEje" onchange="carga_dependencias();">
										  <option value="0">Seleccione..</option>
										  <?=$ejes;?>                                         
									 </select>
								</div>
						  </div>
						  <div class="col-md-4">
								<div class="form-group">
									 <label for="SelDep">*Dependencia</label>
									 <select class="form-control" id="SelDep">
										  <option value="0">Seleccione..</option>
									 </select>
								</div>
						  </div>
						  <div class="col-md-4">
								<div class="form-group">
									 <label readonly for="anio">Año</label>
									 <input type="text" id="anio" class="form-control" value="<?php echo date('Y'); ?>">
								</div>
						  </div>
					 </div>
				</div>
				<div class="col-md-12">
				 

					 <div class="row">
						  <div class="col-md-4">
								<br>
								<div class="col-md-12">
								<a style="cursor:pointer; color:blue; display:none;" target="_blank" href="javascript:" id="descarga"><i class="m-r-10 mdi mdi-briefcase-download"></i>Descargar</a>
								
						  </div>
						  </div>
						  <div class="col-md-4">
						 
								<br>
								
						  </div>

					 </div>
					 <div style="float:right;"> <button onclick="espera(1);" type="button" class="btn waves-effect waves-light btn-block btn-danger">Generar</button></div>
				</div>
		  </div>
	 </div>
</section>
<!-- fin tabla -->
<!-- endformulario-->


<script>
	var total_docs;
	var intentos = 0;
	var errores = [];

	function espera(id) {
		document.getElementById("descarga").style.display="none";
		if(id == 1) {
			Swal.fire({
  				position: 'center',
			  	type: 'info',
			  	title: 'Estamos trabajando en ello, espere por favor',
			  	showConfirmButton: false			  	
			});
			espera(0);
		}
		else {
		  total_act();
		}
  }
  
function carga_dependencias(){
	 var id = document.getElementById("SelEje").value;
	 $.ajax({         
		type: "POST",
		url:"<?=base_url()?>index.php/C_ractividad/dependencias",
		data: 'id='+id,
		success: function(r) {  
		  $("#SelDep").html(r);
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
		  notie.alert({ type: 3, text: 'Ha ocurrido un error. Contacte al administrador', time: 2 });
			 /*alert("Status: " + textStatus);
			 alert("Error: " + errorThrown);*/

		}
	 });
  }

  	function total_act() {
		var eje = document.getElementById("SelEje").value;
		var dep = document.getElementById("SelDep").value;
		var anio = document.getElementById("anio").value;
		if(anio == "" || anio == null) {
			Swal.fire({
  				type: 'error',
  				title: 'Error',
  				text: 'Debe ingresar el año para poder continuar'
			})
	 	}
	 	else {
		  	document.getElementById("descarga").style.display="none";
			$.ajax({
				type: "GET",
				async: false,
				url:"<?=base_url()?>index.php/C_ractividad/total_act",
				data: {
					'eje': eje,
					'dep':dep,
					'anio':anio
				},
				success: function(data) {
					var datap = JSON.parse(data);
					console.log(datap);
					total_docs = datap.length;				
					genera_ract(datap, 0);
					/*var datap = JSON.parse(data);
					//console.log(datap);
					for (var i = 0; i < datap.length; i++) {
						var actid = datap[i].iIdActividad;
						console.log(r);
						//genera_ract();					
					}*/
					/*
					var data3 = parseInt(datap.resp);
					//var data3 = parseInt(data);
					if(data3 === 0) {

						Swal.fire({
							position: 'center',
							type: 'error',
							title: 'Su reporte se no ha generado',
							showConfirmButton: false,
							timer: 1500
						});

					}
					else{
						
						document.getElementById("descarga").style.display="inline";
						document.getElementById("descarga").setAttribute("href", datap.url);
					}*/
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					notie.alert({ type: 3, text: 'Ha ocurrido un error. Contacte al administrador', time: 2 });
						/*alert("Status: " + textStatus);
						alert("Error: " + errorThrown);*/
				}
			});
		}
	}

	function genera_ract(datos, n) {		
		if(n < total_docs)
		{
			if(typeof datos[n].iIdActividad !== undefined) {
			  // your code here
				var actid = datos[n].iIdActividad;
				$.ajax({
					type: "POST",			
					url:"<?=base_url()?>index.php/C_ractividad/genera_ract",
					data: {
						'iIdActividad': actid
					},
					success: function(data) {
						resp = data;
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						return false;
						notie.alert({ type: 3, text: 'Ha ocurrido un error. Contacte al administrador', time: 2 });
							/*alert("Status: " + textStatus);
							alert("Error: " + errorThrown);*/
					},
					complete: function(jqXHR, status) {
					    if(status=="success")
					    {
					    	if(resp == '1')
					    	{
					    		genera_ract(datos, n+1);
					    	}
					    	else 
					    	{
					    		errores.push(n);
		                  		genera_ract(datos, n+1);
					    	}
					    }
					    else 
					    {
					    	if(intentos<3)
		                  	{
		                  		intentos++;
					    		genera_ract(datos, n);
		                  	}
		                  	else
		                  	{
		                  		intentos = 0;	                  		
			           	 		errores.push(n);
		                  		genera_ract(datos, n+1);
		                  	}
					    }
					}
				});	
			}
		}
		else
		{
			Swal.close();
			Swal.fire({
				position: 'center',
				type: 'success',
				title: 'Su reporte se ha generado con exito',
				showConfirmButton: false,
				timer: 1500
			});

			window.open('<?=base_url();?>index.php/C_ractividad/descargar','Fichas de ACtividades Estratégicas','width=520,height=300,scrollbars=NO');
		}
	}





</script>