<!DOCTYPE html>
<html>
<head>
	<title>Calculadora</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<style type="text/css">
		.label {
			font-weight: bold;
		}

		.big-checkbox {width: 18px; height: 18px;}
	</style>
</head>
<body>
<div class="page-wrapper" id="contenido">
	<div class="content">
		<div class="row">
			<div class="col-12">
			    <div class="card">
			        <div class="card-body">
			        	<h2>Probabilidad de defunción</h2>
			        	<small id="emailHelp" class="form-text text-muted">Los campos marcados con <span class="text-danger">*</span> son obligatorios.</small>
			        	<form>
			        		<div class="card">
							  	<div class="card-body">
					        		<div class="row">
						        		<div class="col-3">
										  	<div class="form-group">
											    <label for="edad"><strong>Edad <span class="text-danger">*</span></strong></label>
											    <select class="form-control" name="edad" id="edad" required>
											    	<option value="">--Elija una opción--</option>
											    	<option value="6">Menor a 15 años</option>
											    	<option value="5">15 a 39</option>
											    	<option value="4">40 a 49</option>
											    	<option value="3">50 a 59</option>
											    	<option value="2">60 años y más</option>
											    </select>
											</div>
										</div>
										<div class="col-3">
										  	<div class="form-group">
											    <label for="sexo"><strong>Sexo<span class="text-danger">*</span></strong></strong></label>
											    <select class="form-control" name="sexo" id="sexo" required>
											    	<option value="">--Elija una opción--</option>
											    	<option value="F">Femenino</option>
											    	<option value="M">Masculino</option>
											    </select>
											</div>
										</div>
										<div class="col-3">
										  	<div class="form-group">
											    <label for="sector"><b>Sector<span class="text-danger">*</span></strong></b></label>
											    <select class="form-control" name="sector" id="sector" required>
											    	<option value="">--Elija una opción--</option>
											    	<option value="12">Privado</option>
											    	<option value="15">SEDENA</option>
											    	<option value="13">IMSS</option>
											    	<option value="16">SSA</option>
											    	<option value="14">ISSSTE</option>
											    </select>									    
											</div>
										</div>
										<div class="col-3">
										  	<div class="form-group">
											    <label for="ocupacion"><b>Ocupación<span class="text-danger">*</span></strong></b></label>
											    <select class="form-control" name="ocupacion" id="ocupacion">
											    	<option value="">--Elija una opción--</option>
											    	<option value="25">Ocupado</option>
											    	<option value="26">No ocupado</option>
											    	<option value="27">Desocupado/Desempleado</option>
											    </select>
											</div>
										</div>
								    </div>
								</div>
							</div>
							<br>
						    <div class="row">
						    	<div class="col-8">
						    		<div class="card">
  									<div class="card-body">
							    		<div class="row">
							    			<div class="col-12">
							        			<label><b>Seleccione las opciones que aplica a su situación</b></label>
							        		</div>
							    		</div>
							    		<div class="row">
							        		<div class="col-12">
							        			<div class="form-check">
												  <input class="form-check-input big-checkbox" type="checkbox" id="intubado" value="28">
												  <label class="form-check-label" for="intubado">Intubado</label>
												</div>
												<div class="form-check">
												  <input class="form-check-input big-checkbox" type="checkbox" id="zona" value="17">
												  <label class="form-check-label" for="zona">Zona marginada</label>
												</div>
												<div class="form-check">
												  <input class="form-check-input big-checkbox" type="checkbox" id="atenOpor" value="29">
												  <label class="form-check-label" for="atenOpor">Atención oportuna</label>
												</div>
												<div class="form-check">
												  <input class="form-check-input big-checkbox" type="checkbox" id="indigena" value="8">
												  <label class="form-check-label" for="indigena">Indígena</label>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-12">
												<div class="form-check">
												  <input class="form-check-input big-checkbox" type="checkbox" id="comorbilidad" value="option2" onchange="showHide();">
												  <label class="form-check-label" for="comorbilidad">Comorbilidad</label>
												</div>
												<div class="card" id="divConmorbilidad" style="display:none">
													<div class="card-body">
													    <h5 class="card-title">Conmorbilidades</h5>
													
														<div class="row">
															<div class="col-6">
																<div class="form-check">
																  <input class="form-check-input big-checkbox" type="checkbox" id="diabetes" value="10">
																  <label class="form-check-label" for="diabetes">Diabetes</label>
																</div>
																<div class="form-check">
																  <input class="form-check-input big-checkbox" type="checkbox" id="hipertension" value="11">
																  <label class="form-check-label" for="hipertension">Hipertensión</label>
																</div>
																<div class="form-check">
																  <input class="form-check-input big-checkbox" type="checkbox" id="obesidad" value="9">
																  <label class="form-check-label" for="obesidad">Obesidad</label>
																</div>
																<div class="form-check">
																  <input class="form-check-input big-checkbox" type="checkbox" id="epoc" value="18">
																  <label class="form-check-label" for="epoc">EPOC</label>
																</div>
																<div class="form-check">
																  <input class="form-check-input big-checkbox" type="checkbox" id="vih" value="20">
																  <label class="form-check-label" for="vih">VIH</label>
																</div>
															</div>
														
															<div class="col-6">
																<div class="form-check">
																  <input class="form-check-input big-checkbox" type="checkbox" id="inmuno" value="19">
																  <label class="form-check-label" for="inmuno">Inmuno Supresión</label>
																</div>
																<div class="form-check">
																  <input class="form-check-input big-checkbox" type="checkbox" id="insre" value="22">
																  <label class="form-check-label" for="insre">Ins. Renal</label>
																</div>
																<div class="form-check">
																  <input class="form-check-input big-checkbox" type="checkbox" id="enfc" value="21">
																  <label class="form-check-label" for="enfc">Enf. Cardiaca</label>
																</div>
																<!--<div class="form-check">
																  <input class="form-check-input" type="checkbox" id="tabaq" value="option2">
																  <label class="form-check-label" for="tabaq">Tabaquismo</label>
																</div>-->
																<div class="form-check">
																  <input class="form-check-input big-checkbox" type="checkbox" id="otra" value="24">
																  <label class="form-check-label" for="otra">Otra</label>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<!--
										<div class="row">
											<div class="col-12">
												<div class="form-check">
												  <input class="form-check-input" type="checkbox" id="sintomas" value="option2" onchange="showHide();">
												  <label class="form-check-label" for="sintomas">Síntomas</label>
												</div>
												<div class="card" id="divSintomas" style="display:none">
													<div class="card-body">
													    <h5 class="card-title">Sintomas</h5>
													    <div class="row">
													    	<div class="col-3">
													    		<div class="form-check">
																  <input class="form-check-input" type="checkbox" id="ts" value="option2">
																  <label class="form-check-label" for="ts">Tos</label>
																</div>
																<div class="form-check">
																  <input class="form-check-input" type="checkbox" id="mial" value="option2">
																  <label class="form-check-label" for="mial">Dolor muscular</label>
																</div>
																<div class="form-check">
																  <input class="form-check-input" type="checkbox" id="fie" value="option2">
																  <label class="form-check-label" for="fie">Fiebre</label>
																</div>
																<div class="form-check">
																  <input class="form-check-input" type="checkbox" id="odino" value="option2">
																  <label class="form-check-label" for="odino">Dolor de garganta</label>
																</div>
																<div class="form-check">
																  <input class="form-check-input" type="checkbox" id="doltor" value="option2">
																  <label class="form-check-label" for="doltor">Dolor de toráx</label>
																</div>
													    	</div>
													    	<div class="col-3">
													    		<div class="form-check">
																  <input class="form-check-input" type="checkbox" id="vomi" value="option2">
																  <label class="form-check-label" for="vomi">Vómitos</label>
																</div>
																<div class="form-check">
																  <input class="form-check-input" type="checkbox" id="dolabd" value="option2">
																  <label class="form-check-label" for="dolabd">Dolor abdominal</label>
																</div>
																<div class="form-check">
																  <input class="form-check-input" type="checkbox" id="anos" value="option2">
																  <label class="form-check-label" for="anos">Perdida del olfato</label>
																</div>
																<div class="form-check">
																  <input class="form-check-input" type="checkbox" id="diarr" value="option2">
																  <label class="form-check-label" for="diarr">Diarrea</label>
																</div>
																<div class="form-check">
																  <input class="form-check-input" type="checkbox" id="cef" value="option2">
																  <label class="form-check-label" for="cef">Dolor de cabeza</label>
																</div>
													    	</div>
													    	<div class="col-3">
													    		<div class="form-check">
																  <input class="form-check-input" type="checkbox" id="irri" value="option2">
																  <label class="form-check-label" for="irri">Irritabilidad</label>
																</div>
																<div class="form-check">
																  <input class="form-check-input" type="checkbox" id="calo" value="option2">
																  <label class="form-check-label" for="calo">Calofrios</label>
																</div>
																<div class="form-check">
																  <input class="form-check-input" type="checkbox" id="art" value="option2">
																  <label class="form-check-label" for="art">Dolor de articulaciones</label>
																</div>
																<div class="form-check">
																  <input class="form-check-input" type="checkbox" id="atae" value="option2">
																  <label class="form-check-label" for="atae">Malestar general</label>
																</div>
																<div class="form-check">
																  <input class="form-check-input" type="checkbox" id="rino" value="option2">
																  <label class="form-check-label" for="rino">Congestión nasal</label>
																</div>
													    	</div>
													    	<div class="col-3">
													    		<div class="form-check">
																  <input class="form-check-input" type="checkbox" id="conjun" value="option2">
																  <label class="form-check-label" for="conjun">Conjuntivitis</label>
																</div>
																<div class="form-check">
																  <input class="form-check-input" type="checkbox" id="cia" value="option2">
																  <label class="form-check-label" for="cia">Piel azulada</label>
																</div>
																<div class="form-check">
																  <input class="form-check-input" type="checkbox" id="ini" value="option2">
																  <label class="form-check-label" for="ini">Inicio súbito de síntomas</label>
																</div>
																<div class="form-check">
																  <input class="form-check-input" type="checkbox" id="disg" value="option2">
																  <label class="form-check-label" for="disg">Perdida del gusto</label>
																</div>
													    	</div>
													    </div>
													</div>
												</div>
											</div>					        		
										</div>-->
									</div>
									</div>
				        		</div>
				        		<div class="col-4">
				        			<div class="card">
									  	<div class="card-body">
						        			<div id="resultado" style="min-height:150px;"></div>
						        			
										</div>
									</div>
									<div class="row">
										<div class="col-12 mb-4 text-center" >
											<button type="button"  class="btn btn-lg btn-dark btn-block" onclick="calcular();">Calcular</button>
										</div>
									</div>
				        		</div>
				        	</div>
				        	
							
							
						</form>
			        </div>
			    </div>
			</div>
		</div>
	</div>
</div>



<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script type="text/javascript">
	var values = [];
	values[2] = 1;
	values[3] = 3.61482700610662;
	values[4] = 7.18582258925415;
	values[5] = 30.5514760400389;
	values[6] = 34.4370148853459;
	values[7] = 0.579053329171701;
	values[8] = 0.583967236272978;
	values[9] = 0.79438114613367;
	values[10] = 0.583572782892511;
	values[11] = 0.733737972351056;
	values[12] = 1;
	values[13] = 0.0505046938245165;
	values[14] = 0.0636304595208124;
	values[15] = 0.0542097227550421;
	values[16] = 0.21815640921299;
	values[17] = 0.683158624275055;
	values[18] = 0.660629573098341;
	values[19] = 0.505861076379916;
	values[20] = 0.418314180833733;
	values[21] = 0.923340967917813;
	values[22] = 0.226792902887798;
	values[23] = 1.02914030666409;
	values[24] = 0.77668749799298;
	values[25] = 1;
	values[26] = 0.603482401257891;
	values[27] = 0.424157724999094;
	values[28] = 0.0309730750090065;
	values[29] = 1.71399430922849;
	values[30] = 53.7055313035073;


	function showHide(){
		if($("#comorbilidad").is(':checked')) $("#divConmorbilidad").css("display","");
		else $("#divConmorbilidad").css("display","none");

		if($("#sintomas").is(':checked')) $("#divSintomas").css("display","");
		else $("#divSintomas").css("display","none");
	}

	function calcular(){
		if($("#edad").val() != '' && $("#sexo").val() != '' && $("#sector").val() != '' && $("#ocupacion").val() != ''){

			var edad = values[parseInt($("#edad").val())];
			var sexo = ($("#sexo").val() == 'M') ? values[7]:1;
			var sector = values[parseInt($("#sector").val())];
			var ocupacion = values[parseInt($("#ocupacion").val())];

			var intubado = ($("#intubado").is(':checked')) ? values[parseInt($("#intubado").val())]:1;
			var zona = ($("#zona").is(':checked')) ? values[parseInt($("#zona").val())]:1;
			var indigena = ($("#indigena").is(':checked')) ? values[parseInt($("#indigena").val())]:1;
			var atenOpor = ($("#atenOpor").is(':checked')) ? values[parseInt($("#atenOpor").val())]:1;
			
			
			// Comoborbilidad
			var obesidad = 1;
			var hipertension = 1;
			var diabetes = 1;
			var epoc = 1;
			var vih = 1;
			var inmuno = 1;
			var enfc = 1;
			var insre = 1;
			var otra = 1;

			if($("#comorbilidad").is(':checked')){
				obesidad = ($("#obesidad").is(':checked')) ? values[parseInt($("#obesidad").val())]:1;
				hipertension = ($("#hipertension").is(':checked')) ? values[parseInt($("#hipertension").val())]:1;
				diabetes = ($("#diabetes").is(':checked')) ? values[parseInt($("#diabetes").val())]:1;
				epoc = ($("#epoc").is(':checked')) ? values[parseInt($("#epoc").val())]:1;
				vih = ($("#vih").is(':checked')) ? values[parseInt($("#vih").val())]:1;
				inmuno = ($("#inmuno").is(':checked')) ? values[parseInt($("#inmuno").val())]:1;
				enfc = ($("#enfc").is(':checked')) ? values[parseInt($("#enfc").val())]:1;
				insre = ($("#insre").is(':checked')) ? values[parseInt($("#insre").val())]:1;
				otra = ($("#otra").is(':checked')) ? values[parseInt($("#otra").val())]:1;
			}

			// Sintomas
			/*var ts = 1
	    	var mial = 1
	    	var fie = 1
	    	var odino = 1
	    	var doltor = 1
	    	var vomi = 1
	    	var dolabd = 1
	    	var anos = 1
	    	var diarr = 1
	    	var cef = 1
	    	var irri = 1
	    	var calo = 1
	    	var art = 1
	    	var atae = 1
	    	var rino = 1
	    	var conjun = 1
	    	var cia = 1
	    	var ini = 1
	    	var disg = 1

	    	if($("#sintomas").is(':checked')){
	    		ts = ($("#ts").is(':checked')) ? values[19]:1;
		    	mial = ($("#mial").is(':checked')) ? values[26]:1;
		    	fie = ($("#fie").is(':checked')) ? values[18]:1;
		    	odino = ($("#odino").is(':checked')) ? values[20]:1;
		    	doltor = ($("#doltor").is(':checked')) ? values[23]:1;
		    	vomi = ($("#vomi").is(':checked')) ? values[30]:1;
		    	dolabd = ($("#dolabd").is(':checked')) ? values[31]:1;
		    	anos = ($("#anos").is(':checked')) ? values[35]:1;
		    	diarr = ($("#diarr").is(':checked')) ? values[22]:1;
		    	cef = ($("#cef").is(':checked')) ? values[25]:1;
		    	irri = ($("#irri").is(':checked')) ? values[21]:1;
		    	calo = ($("#calo").is(':checked')) ? values[24]:1;
		    	art = ($("#art").is(':checked')) ? values[27]:1;
		    	atae = ($("#atae").is(':checked')) ? values[28]:1;
		    	rino = ($("#rino").is(':checked')) ? values[29]:1;
		    	conjun = ($("#conjun").is(':checked')) ? values[32]:1;
		    	cia = ($("#cia").is(':checked')) ? values[33]:1;
		    	ini = ($("#ini").is(':checked')) ? values[34]:1;
		    	disg = ($("#disg").is(':checked')) ? values[36]:1;
	    	}
	    	*/

	    	var prob = parseFloat( (1 / (1 + edad * sexo * sector * ocupacion * intubado *zona * indigena * epoc * vih * inmuno * obesidad * hipertension * diabetes * enfc * otra * insre * atenOpor * values[30])) * 100 ).toFixed(2);
			var html = '<h3 align="center"><b>'+prob + '%</b><br><small class="text-muted">Probabilidad de defunción</small></h3>';
			$("#resultado").html(html);
		} else alert('Debe completar todos los campos marcados con *');

	}

</script>
</body>

</html>