<!--titulo-->
<section>
	 <div class="page-breadcrumb">
		  <div class="row">
				<div class="col-5 align-self-center">
					 <h4 class="page-title">Tablas del Anexo Estadístico</h4>
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
				<!--<form class="needs-validation was-validated" onsubmit="genera_ranex(this,event);">-->
					<form class="needs-validation was-validated" onsubmit="carga_act(this,event);">
					<div class="col-md-12">
						<h5>Filtrar por:</h5>
						<hr>
						<div class="row">
						  	<div class="col-md-4">
								<div class="form-group">
								 	<label for="SelEje">Eje<span class="text-danger">*</span></label>
								 	<select class="form-control" id="SelEje" name="SelEje" required onchange="hideFrmPrint();">
										  <?=$ejes;?>                                         
								 	</select>
								 	<div class="invalid-feedback">
		                                Este campo no puede estar vacio.
		                            </div>
								</div>
						  	</div>
						  	<div class="col-md-2">
								<div class="form-group">
								 	<label readonly for="anio">Año<span class="text-danger">*</span></label>
								 	<input type="text" id="anio" name="anio" required class="form-control" value="<?php echo (date('Y')-1); ?>">
								 	<div class="invalid-feedback">
		                                Este campo no puede estar vacio.
		                            </div>
								</div>
						  	</div> 
						  	<div class="col-md-4">
								<div class="custom-control custom-checkbox mr-sm-2" style="margin-top:35px;">
		                            <input type="checkbox" class="custom-control-input" id="maya" name="maya" value="1">
		                            <label class="custom-control-label" for="maya">Descargar versión en lengua maya</label>
		                        </div>
						  	</div>
							<div class="col-md-2 mb-2">
						 		<div id="genera_anex" style="float:left;margin-top:40px;"><button type="submit" class="btn waves-effect waves-light btn-block btn-danger" id="btnCalculate">Calcular</button></div>
					 		</div>
						</div>
					</div>
					</form>

					<form id="frmPrint" class="needs-validation was-validated" onsubmit="printAnex(event);">
					<div class="col-md-12">
					 	<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="ini">Imprimir tablas de la:</label>
								</div>
							</div>
							<div class="col-md-2">
								<input class="form-control" name="ini" id="ini" value=""> 
								<div class="invalid-feedback">
	                                Este campo no puede estar vacio.
	                            </div>
	                        </div>
	                        <div class="col-md-1">
	                        	<span style="margin-top:35px;"><label>hasta</label></span>
	                        </div>
	                        <div class="col-md-2">
								<input class="form-control" name="end" id="end" value=""> 
								<div class="invalid-feedback">
	                                Este campo no puede estar vacio.
	                            </div>
	                        </div>
						  	<div class="col-md-1">
								<div id="genera_anex" style="float:left;"><button type="submit" class="btn waves-effect waves-light btn-block btn-danger">Generar</button></div>
								
						  	</div>
						  	<div class="col-md-2">
								<a style="cursor:pointer; color:blue; display:none;" target="_blank" href="javascript:" id="descarga_anex"><h4><b><i class="m-r-10 mdi mdi-briefcase-download"></i>Descargar</b></h4></a>
						  	</div>
						 </div>
						 <!--<div style="float:right;"> <button onclick="espera(1);" type="button" class="btn waves-effect waves-light btn-block btn-danger">Generar</button></div>-->
						 
					</div>
				</form>
				<script>
                    // Example starter JavaScript for disabling form submissions if there are invalid fields
                    (function() {
                        'use strict';
                        window.addEventListener('load', function() {
                            // Fetch all the forms we want to apply custom Bootstrap validation styles to
                            var forms = document.getElementsByClassName('needs-validation');
                            // Loop over them and prevent submission
                            var validation = Array.prototype.filter.call(forms, function(form) {
                                form.addEventListener('submit', function(event) {
                                    if (form.checkValidity() === false) {
                                        event.preventDefault();
                                        event.stopPropagation();
                                    }
                                    form.classList.add('was-validated');
                                }, false);
                            });
                        }, false);
                    })();
                </script>
		  </div>
	 </div>
</section>
<!-- fin tabla -->
<!-- endformulario-->


<script>
	var chkMaya = 0;
	var archivos = [];
	var reporte;
	var intentos = 0;
	var sel_eje = 0;
	var sel_anio = 0;
	var dataTemp = []; // Aqui guardaremos la información que se debe de generar
	$(document).ready(function(){
		$("#frmPrint").hide();
		$('#maya').change(function() {
        	chkMaya = (this.checked) ? 1:0;
	    });
	    $('#anio').on('input',function(e){
		    hideFrmPrint();
		});
	});

	function carga_act(f, e) {
		reporte = [];
		e.preventDefault();
		//if(archivos.length > 0) archivos = [];

		sel_eje = $('#SelEje').val();
		sel_anio = $('#anio').val();
		$.ajax({
			type: "POST",			
			url:"<?=base_url()?>C_ranexoest/carga_actividades",
			data: $(f).serialize(),
			beforeSend: function() {
				Swal.fire({
				  position: 'center',
				  type: 'info',
				  title: 'Estamos trabajando en ello, espere por favor',
				  showConfirmButton: false,
				  allowOutsideClick: false
				});
				$('#genera_anex').attr('disabled');
				$('#descarga_anex').css('display','none');
			},
			success: function(data) {
				var datos = JSON.parse(data);
				Swal.close();				
				console.log(datos);
				
				var end = datos.datos.length;

				if(end > 0) {
					$("#btnCalculate").hide();
					$('#frmPrint').show();
					$('#ini').val(1);
					$('#end').val(end);
					dataTemp = datos.datos;
				} else {
					Swal.fire({
						position: 'center',
						type: 'warning',
						title: 'Sin datos',
						showConfirmButton: false,
						timer: 2000
					});
				}
				
				
				/*if(datos.resp=='correcto')
				{
					var ent = datos.datos;
					var resp;
					var n = 0;
					var cont = 1;				
					console.log(ent.length);

					genera_archivos(ent, n, sel_eje, sel_anio, cont);		

				}
				
				*/
				
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				return false;
				notie.alert({ type: 3, text: 'Ha ocurrido un error. Contacte al administrador', time: 2 });
			}
		});	
	}

	function genera_excel() {
		let datos = JSON.stringify(reporte);
		$.post('<?=base_url();?>C_ranexoest/rep_excel', {datos: datos}, function(resp){
			console.log(resp);
		});
	}

	function genera_archivos(datos, n, sel_eje, sel_anio, cont)
	{
		if(n < datos.length)
		{
			if(datos[n].datos == 1)
			{
				let datos_ent = {
					cont: cont,
					sel_eje: sel_eje,
					sel_anio: sel_anio,
					sel_numods: datos[n].iNumOds,
					iIdActividad: datos[n].iIdActividad,
					iIdEntregable: datos[n].iIdEntregable,
					iIdEje: datos[n].iIdEje,
					iIdTema: datos[n].iIdTema,
					vActividad: datos[n].vNombreActividad,
					vEntregable: datos[n].vNombreEntregable,
					iMismosBeneficiarios: datos[n].iMismosBeneficiarios,
					benmy_nd: datos[n].benmy_nd,
					bend_nd: datos[n].bend_nd,
					numtabla: datos[n].numtabla,
					vTituloMaya: datos[n].vNombreEntregableMaya,
					maya: chkMaya
				}
				
			
				var resp;				
				
				$.ajax({
					type: "POST",			
					url:"<?=base_url()?>C_ranexoest/genera_archivos",
					data: datos_ent,
					success: function(data) {
						resp = JSON.parse(data);

						let rep = {
							nom_ar: resp.nom_ar,
							ejeid: resp.ejeid,
							ods: resp.ods,
							actid: resp.actid,
							entid: resp.entid,
							depid: resp.dep,
							actividad: resp.actividad,
							entregable: resp.entregable,
							cont: resp.cont
						}

						archivos.push(resp.nom_ar);
						reporte.push(rep);
						cont++;
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						return false;
						notie.alert({ type: 3, text: 'Ha ocurrido un error. Contacte al administrador', time: 2 });
					},
					complete: function(jqXHR , status)
					{
					  	if(status=='success')
					  	{
					      	if(resp=="correcto")
					      	{			      	   
					      	   if(n==datos.length)
					      	   {
					      	   		console.log('terminado');
					      	   }
					      	   genera_archivos(datos, n+1, sel_eje, sel_anio, cont);
					      	}
					      	else
					        {
					        	console.log('falló');
					          	genera_archivos(datos, n+1, sel_eje, sel_anio, cont);
					        }
					  	}
					  	else
					  	{
					  		if(intentos<3)
					  	 	{
					  	 		intentos++;
					  	 		genera_archivos(datos, n, sel_eje, sel_anio, cont);
					  	 	}
					  	 	else
					  	 	{
					  	 		intentos = 0;
					  	 		console.log('intentos agotados');
					  	 		genera_archivos(datos, n+1, sel_eje, sel_anio, cont);
					  	 	}
					  	}
					}
				});				
			
					

			}
			else 
			{
				genera_archivos(datos, n+1, sel_eje, sel_anio, cont);
			}
		}
		else 
		{
			Swal.close();
			console.log(archivos);
			
			if(archivos.length > 0)
			{
				var sel_eje = $('#SelEje').val();
				var sel_anio = $('#anio').val();
				var chk_maya = ($("#maya").is(':checked')) ? 1:0;
				$.post('<?=base_url();?>C_ranexoest/descargar', {arc: archivos, anio:sel_anio, eje:sel_eje, len_maya:chk_maya, datos:JSON.stringify(reporte) }, function(r_arc){
					console.log(r_arc);
					$('#descarga_anex').css('display','block');
					$('#descarga_anex').attr('href','<?=base_url();?>'+r_arc);
					Swal.fire({
						position: 'center',
						type: 'success',
						title: 'Su reporte se ha generado con exito',
						showConfirmButton: false,
						timer: 2000
					});
				});
			}
			else 
			{
				Swal.fire({
					position: 'center',
					type: 'warning',
					title: 'Sin datos',
					showConfirmButton: false,
					timer: 2000
				});				
			}	
				
		}
	}

	function genera_ranex(f, e) {
		e.preventDefault();
		$('#genera_anex').attr('disabled');
		$('#descarga_anex').css('display','none');
	
		$.ajax({
			type: "POST",			
			url:"<?=base_url()?>C_ranexoest/genera_ranex",
			data: $(f).serialize(),
			success: function(data) {
				var datos = JSON.parse(data);
				console.log(datos);
				if(datos.resp=='error_in') alerta(datos.message, 'danger');
				else if(datos.resp=='error_d') alerta(datos.message, 'warning');
				else if(datos.resp=='mapas_g') genera_ranex(f, e);
				else if(datos.resp=='correcto') { 
					alerta(datos.message, 'success'); 					
					$('#descarga_anex').css('display','block');
					$('#descarga_anex').attr('href',datos.url);
				}
				$('#genera_anex').removeAttr('disabled');	
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				return false;
				notie.alert({ type: 3, text: 'Ha ocurrido un error. Contacte al administrador', time: 2 });
					/*alert("Status: " + textStatus);
					alert("Error: " + errorThrown);*/
			}
		});	
			
	}

	function hideFrmPrint(){
		$("#frmPrint").hide();
		$("#btnCalculate").show();
	}

	function printAnex(e){
		e.preventDefault();
		var n = 0;
		var cont = 1;
		archivos = [];
		var ini = parseInt($("#ini").val()) - 1;
		var end = parseInt($("#end").val());
		var dataSend = [];
		for (var i = ini; i < end; i++) {
			dataSend.push(dataTemp[i]); 
		};

		console.log(dataSend);
		genera_archivos(dataSend, n, sel_eje, sel_anio, cont);

	}

</script>