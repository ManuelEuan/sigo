<?php 
	$periodoactivo=($periodorevision==0) ? '' : 'disabled="disabled"';
?>
<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-md-10">
				<h4 class="card-title">Editar componente</h4>
			</div>
			<div class="col-md-2">
				<button class="btn waves-effect waves-light btn-outline-info" type="button" onclick="modificar_componentes(<?=$iIdCompromiso?>)"><i class="mdi mdi-arrow-left"></i> Regresar</button>
			</div>
			<div class="col-md-12"><br></div>
			<div class="col-md-6">
                <label for="">Componente</label>
			<textarea class="form-control" id="vComponente" <?=$periodoactivo?>><?=$datosTabla[0]->vComponente?></textarea></div>
			<div class="col-md-6">
                <label for="">Descripción</label>
			<textarea class="form-control" id="vDescripcion" <?=$periodoactivo?>><?=$datosTabla[0]->vDescripcion?></textarea></div><br>
			
			
			<div class="col-md-3">
                <label for="">Unidad de medida</label>
                <select name="" id="iIdUnidadMedida" class="form-control" name="" <?=$periodoactivo?>>
					<option value="">Seleccione</option>
					<?=$options_unidadmedida?>
				</select>
			</div>
			
			<div class="col-md-2">
                <label for="">Meta</label>
                <input type="text" id="nMeta" class="form-control" value="<?=$datosTabla[0]->nMeta?>" <?=$periodoactivo?>>
			</div>


			<div class="col-md-2">
                <label for="">Meta modificada</label>
                <input type="text" id="nMetaModificada" class="form-control" value="<?=$datosTabla[0]->nMetaModificada?>" <?=$periodoactivo?>>
			</div>


			<div class="col-md-4">
                <label for="">Ponderacion</label>
                <input type="text" id="nPonderacion" class="form-control" value="<?=$datosTabla[0]->nPonderacion?>" <?=$periodoactivo?>>
			</div>
			<div class="col-md-2" hidden>
                <label for="">Avance</label>
                <input type="text" id="nAvance" class="form-control" value="<?=$datosTabla[0]->nAvance?>" <?=$periodoactivo?>>
			</div>
			<div class="col-md-1" style="text-align: center; margin-top: auto;">
                <input type="submit" value="Guardar" class="btn btn-success" onclick="ActualizarComponente()" <?=$periodoactivo?>>
			</div>
			
			<div class="col-md-12"><br>
                <h4 class="card-title">UBP</h4>
			</div>
		</div>
		
        <div class="col-md-12">
			<div class="row">
				<div class="col-md-3">
					<label for="">Tipo UBP</label>
					<select class="form-control" onchange="seleccionar_ubp()" id="iIdTipoUbp" <?=$periodoactivo?>>
						<option value="0">Todos</option>
						<?=$options_tipo_ubp?>
					</select>
				</div>
				<div class="col-md-3">
					<label for="">UBP</label>
					<select class="form-control" id="iIdUbp" <?=$periodoactivo?>>
						<option value="">Seleccione</option>
						<?=$options_ubp?>
					</select>
				</div>
				<div class="col-md-4" >
					<label for="">Monto</label>
					<input type="text" name="" id="nMonto" class="form-control" <?=$periodoactivo?> maxlength="18">
				</div>
				<div class="col-md-2" style="margin-top: auto">
					<input type="submit" value="Agregar" class="btn btn-success" onclick="agregarUbpComponente()" <?=$periodoactivo?>>
				</div>
				<div class="col-md-12">
					<?=$datosTablaUBP?>
				</div>
			</div>
		</div>
	</div>
	
	
	
	<!-- funcion para regresar a la pagina anterior -->
    <script>
		function modificar_componentes(id) {
			cargar('<?=base_url()?>C_compromisos_componentes/index', '#contenedor','POST','id='+id);
		}
	</script>
	
	<script>
		$("#iIdUnidadMedida option[value=" + <?=$datosTabla[0]->iIdUnidadMedida?> +"]").prop("selected", true);
	</script>
	
	
	<!-- SCRIPT USO ESTRICTO EMAC SCRIPT -->
	<script>
		// no retirar uso estricto
		"use strict";
		function ActualizarComponente(){
			// datos del componente
			var data={"vComponente": $("#vComponente").val(), "vDescripcion": $("#vDescripcion").val(), "iIdUnidadMedida": $("#iIdUnidadMedida").val(), "nMeta": $("#nMeta").val(), "nPonderacion": $("#nPonderacion").val(), "iIdCompromiso": <?=$iIdCompromiso?>, "iOrden":0, "iActivo":1,"nAvance": $("#nAvance").val() ,"iIdComponente": <?=$datosTabla[0]->iIdComponente?>, 'nMetaModificada': $('#nMetaModificada').val()};
			// validador de campos vacios
			var validador=0;
			var objetos = (Object.values(data));
			for (var x = 0; x < objetos.length; x++) {
				if(objetos[x]=="" || objetos[x]==0){
					validador++;
				}
			}
			validador=1;
			
			if((<?=$ponderacion?>-<?=$datosTabla[0]->nPonderacion?>)+parseFloat($("#nPonderacion").val())>100){
				alerta('La suma de los componentes deben ser equivalentes a 100%', 'error');
				console.log((<?=$ponderacion?>-<?=$datosTabla[0]->nPonderacion?>)+parseFloat($("#nPonderacion").val()));
				}else if(validador>2){
				alerta('Todos los campos son obligatorios', 'error');
				}else if(validador==1){
				if($("#nPonderacion").val()>=0 && $("#nMeta").val()>=0 && $("#nAvance").val()<=100 && $("#nAvance").val()>=0 && $('#nMetaModificada').val() >= 0){
					console.log(data);
					$.ajax({
						type: "POST",
						url: "<?=base_url()?>C_compromisos_componentes/updateComponente", //Nombre del controlador porcentajeAvance
						data: data,
						success: function(resp) {
							if (resp == 'correcto') {
								CalcularAvance();
								alerta('Guardado', 'success');
								// cargar('<?=base_url()?>C_compromisos_componentes/index', '#contenedor','POST','id='+<?=$iIdCompromiso?>);
								} else {
								alerta('Algo salio mal', 'error');
							}
						}});
						}else{
						alerta('Verifique sus datos', 'error');
				}
			}
		}
	</script>	
	<script>
		function agregarUbpComponente(){
			var data={"iIdUbp": $("#iIdUbp").val(), "iIdComponente": <?=$datosTabla[0]->iIdComponente?> , "nMonto": $("#nMonto").val() };
			// validador de campos vacios
			var validador=0;
			var objetos = (Object.values(data));
			for (var x = 0; x < objetos.length; x++) {
				if(objetos[x]=="" || objetos[x]==0){
					validador++;
				}
			}
			if(validador==0){
				try{
					if(parseFloat($("#nMonto").val())>=0){
						$.ajax({
							type: "POST",
							url: "<?=base_url()?>C_compromisos_componentes/agregarUbpComponente", //Nombre del controlador
							data: data,
							success: function(resp) {
								if (resp == 'correcto') {
									alerta('Guardado', 'success');
									var data={"iIdComponente":  <?=$datosTabla[0]->iIdComponente?> , "iIdCompromiso": <?=$iIdCompromiso?>};
									cargar('<?= base_url() ?>C_compromisos_componentes/componente_editar', '#vistaComponente','POST', data);
									} else {
									alerta('Algo salio mal', 'error');
								}
							}});
							}else{
							alerta('Llene todos los campos correctamente', 'error');
					}
					} catch (e) {
					alerta('Llene todos los campos correctamente', 'error');
				}
				
				}else{
				alerta('Llene todos los campos correctamente', 'error');
			}
			
		}
	</script>
	<script>
		function eliminar_componenteubp(iIdUbp){
			var data ={"iIdUbp":iIdUbp,"iIdComponente": <?=$datosTabla[0]->iIdComponente?>};
			$.ajax({
				type: "POST",
				url: "<?=base_url()?>C_compromisos_componentes/eliminarUbpComponente", //Nombre del controlador
				data: data,
				success: function(resp) {
					if (resp == 'correcto') {
						alerta('Eliminado', 'success');
						var data={"iIdComponente":  <?=$datosTabla[0]->iIdComponente?> , "iIdCompromiso": <?=$iIdCompromiso?>};
						cargar('<?= base_url() ?>C_compromisos_componentes/componente_editar', '#vistaComponente','POST', data);
						} else {
						alerta('Algo salio mal', 'error');
					}
				}});
				
		}
	</script>
	<script>
		function seleccionar_ubp(){
			var iIdTipoUbp=$("#iIdTipoUbp").val();
			var data={ "iIdTipoUbp": iIdTipoUbp };
			$.ajax({
				type: "POST",
				url: "<?=base_url()?>C_compromisos_componentes/listarubp", //Nombre del controlador
				data: data,
				dataType: 'json',
				success: function(data) {
					$("#iIdUbp").empty();
					var obj = new Option("option text", 0);
					$("#iIdUbp").append(obj);
					$(obj).html("Seleccione"); 
					var objetos = (Object.values(data));
                    for (x = 0; x < objetos.length; x++) {
                        //aceder al valor especifico
                        /* console.log(objetos[x].vNombre); */
                        var obj = new Option("option text", objetos[x].iIdUbp);
                        $("#iIdUbp").append(obj);
                        $(obj).html(objetos[x].vUBP);                       
					}
				}
			});
			
		}
	</script>	
	
	<script>
		function CalcularAvance(){
			var data={"iIdCompromiso": <?=$iIdCompromiso?> };
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>C_compromisos_componentes/porcentajeAvance", //Nombre del controlador
				data: data,
				success: function(resp) {
					console.log(resp);
				}});      
		}
	</script>	