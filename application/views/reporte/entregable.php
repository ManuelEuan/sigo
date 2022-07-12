<!--titulo-->
<section>
	 <div class="page-breadcrumb">
		  <div class="row">
				<div class="col-5 align-self-center">
					 <h4 class="page-title">Reporte Entregables</h4>
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
					 	<div class="col">
							<div class="form-group">
								 <label readonly for="anio">Año<b class="text-danger">*</b></label>
								 <input type="text" id="anio" class="form-control" value="<?php echo (in_array(date('n'), array(1,2)) ) ?  (date('Y') - 1):date('Y'); ?>">
							</div>
						  </div>
						  <div class="col">
                            <div class="form-group">
                                    <label class="control-label">Mes</label>
                                    <select class="form-control" name="mes" id="mes">
                                        <option value="0">--Todos--</option>
                                        <option value="1">Enero</option>
                                        <option value="2">Febrero</option>
                                        <option value="3">Marzo</option>
                                        <option value="4">Abril</option>
                                        <option value="5">Mayo</option>
                                        <option value="6">Junio</option>
                                        <option value="7">Julio</option>
                                        <option value="8">Agosto</option>
                                        <option value="9">Septiembre</option>
                                        <option value="10">Octubre</option>
                                        <option value="11">Noviembre</option>
                                        <option value="12">Diciembre</option>
                                    </select>
                                </div>
                        </div>
						  <?php
						   if(isset($ejes))
		                  	{
			                    echo '<div class="col">
			                        <div class="form-group">
			                            <label class="control-label">Eje Rector<span class="text-danger">*</span></label>
			                            <select name="SelEje" id="SelEje" class="form-control" onChange="carga_dependencias();" >
			                                <option value="0">--Todos--</option>'.$ejes.'
			                            </select>
			                        </div>
			                    </div>';
			                }
			                else 
			                {
			                    echo '<input type="hidden" name="SelEje" id="SelEje" value="'.$_SESSION[PREFIJO.'_ideje'].'" >';
			                } 

			                if(isset($dependencias))
			                {
			                    echo '<div class="col">
		                          <div class="form-group">
		                              <label class="control-label">Dependencia responsable</label>
		                              <select name="SelDep" id="SelDep" class="form-control" >
		                                  <option value="0">--Todos--</option>'.$dependencias.'
		                              </select>
		                          </div>
		                      </div>';
			                } 
			                else 
			                {
			                    echo '<input type="hidden" name="SelDep" id="SelDep" value="'.$_SESSION[PREFIJO.'_iddependencia'].'" >';
			                }
			                ?>
					 </div>
				</div>
				<div class="col-md-12">

					 <div class="row">
						<div class="col-md-4">
							<br>
							<div class="col-md-12">
								<a style="cursor:pointer; color:blue; display:none;"  href="<?=base_url();?>public/reportes/actividadesBD.xls" id="descarga"><i class="m-r-10 mdi mdi-briefcase-download"></i>Descargar</a>
						  	</div>
						</div>
						<div class="col-md-4">
						 
							<br>
								
						</div>
					 </div>
					 <div style="float:right;"> <button onclick="generar(event);" type="button" class="btn waves-effect waves-light btn-block btn-danger">Generar</button></div>
				</div>
		  </div>
	 </div>
</section>
<!-- fin tabla -->
<!-- endformulario-->


<script>
	function carga_dependencias(){
		var id = document.getElementById("SelEje").value;
		$.ajax({         
			type: "POST",
			url:"<?=base_url()?>C_rentregable/dependencias",
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

  	function generar(e) {
  		e.preventDefault();
  		document.getElementById("descarga").style.display="none";
		var eje = document.getElementById("SelEje").value;
		var dep = document.getElementById("SelDep").value;
		var anio = document.getElementById("anio").value;
		var mes = document.getElementById("mes").value;

	    if(anio == '' || anio == 0 || anio == null){
	      alerta('Por favor indique un año','warning');
	    } /*else if (eje == 0){
	      alerta('Por favor indique un eje','warning');
	    } */else {
	    	Swal.fire({
  				position: 'center',
			  	type: 'info',
			  	title: 'Estamos trabajando en ello, espere por favor',
			  	showConfirmButton: false,
			  	timer: 2000
			});
		  	document.getElementById("descarga").style.display="none";
			$.ajax({
				type: "POST",
				url:"<?=base_url()?>C_rentregable/genera_reporte",
				data: {
					'eje': eje,
					'dep':dep,
					'anio':anio,
					'mes': mes
				},
				success: function(data) {
					var datap = JSON.parse(data);
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
						Swal.fire({
							position: 'center',
							type: 'success',
							title: 'Su reporte se ha generado con exito',
							showConfirmButton: false,
							timer: 1500
						});
						document.getElementById("descarga").style.display="inline";
						document.getElementById("descarga").setAttribute("href", datap.url);
					}
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					notie.alert({ type: 3, text: 'Ha ocurrido un error. Contacte al administrador', time: 2 });
						/*alert("Status: " + textStatus);
						alert("Error: " + errorThrown);*/
					Swal.fire({
							position: 'center',
							type: 'error',
							title: 'Su reporte se no ha generado',
							showConfirmButton: false,
							timer: 1500
						});

				}

			});
		}
	}
</script>