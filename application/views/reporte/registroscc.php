<!--titulo-->
<section>
	 <div class="page-breadcrumb">
		  <div class="row">
				<div class="col-5 align-self-center">
					 <h4 class="page-title">Reporte registros call center</h4>
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
					<h5>Filtrar por rango de fechas:</h5>
					<hr>

					<div class="row">
					  	<div class="col-md-4">
							<div class="form-group">
								 <label for="SelEje">Fecha de inicio<b class="text-danger">*</b></label>
								 <input type="text" id="finicio" name="finicio" class="form-control date-inputmask" value="<?php echo date('d-m-Y'); ?>">
							</div>
					  	</div>						
					  	<div class="col-md-4">
							<div class="form-group">
								<label for="anio">Fecha de fin<b class="text-danger">*</b></label>
								<input type="text" id="ffin" name="ffin" class="form-control date-inputmask" value="<?php echo date('d-m-Y'); ?>">
							</div>
					  	</div>
					  	<div class="col-md-4">
					  		<button onclick="espera(1);" style="margin-top: 30px;" type="button" class="btn waves-effect waves-light btn-block btn-danger">Generar</button>
					  	</div>
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
					 </div>
					 
				</div>
		  </div>
	 </div>
</section>
<!-- fin tabla -->
<!-- endformulario-->


<script>
	 $(function(e) {
        "use strict";
        $(".date-inputmask").inputmask("dd-mm-yyyy");
    });

	function espera(id) {
		var finicio = $("#finicio").val();
		var ffin = $("#ffin").val();
		
		if( (finicio == "" || finicio == null) || (ffin == "" || ffin == null)) 
		{
			alerta('Debe indicar un rango de fechas','error');
		}
		else
		{
			document.getElementById("descarga").style.display="none";
			if(id == 1) {
				Swal.fire({
	  				position: 'center',
				  	type: 'info',
				  	title: 'Estamos trabajando en ello, espere por favor',
				  	showConfirmButton: false,
				  	timer: 2000
				});
				espera(0);
			}
			else {
			  generar();
			}
		}
  	}  

  	function generar() {
		var finicio = $("#finicio").val();
		var ffin = $("#ffin").val();
	  	document.getElementById("descarga").style.display="none";
		$.ajax({
			type: "POST",
			url:"<?=base_url()?>C_registro_cc/generar_reporte",
			data: {
				'finicio': finicio,
				'ffin':ffin
			},
			success: function(data) {
				var datap = JSON.parse(data);
				var data3 = parseInt(datap.resp);					
				
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
			}
		});
	}
</script>