<?php
$pag = 2;
include 'application/views/masterpage/navagacionnavb.php';
?>
<div class="page-header page-header-modern ">
	<div class="col-md-12 ">
		<ul class="breadcrumb d-block text-center " style="color: white !important;" data-appear-animation="fadeIn"
			data-appear-animation-delay="300">
			<li><a style="color:white !important;" href="<?= base_url() ?>control_pagina/index">Inicio</a></li>
			<li><a style="color:white !important;" href="<?= base_url() ?>compromisos/listar">Compromisos</a></li>
		</ul>
	</div>
	<div class="row align-items-center" style="text-align: center">
		<div class="col-md-12 align-self-center p-static order-2 text-center">
			<?php
			foreach ($descripcion as $key) {
				echo '<h1><strong>Compromiso ' . $key['iNumero'] . ' </strong></h1>';
			}
			?>
		</div>
	</div>
</div>
<div role="main" class="main shop py-4">
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<div class="owl-carousel owl-theme" data-plugin-options="{'items': 1}">
					<?php
					if ($imagenes_portada != null) {
						foreach ($imagenes_portada as $key) {
							echo '<div>
								<img style="height: 430px" alt="" class="img-fluid" src="' . base_url() . 'archivos/documentosImages/' . $key['vEvidencia'] . '">
							</div>';
						}
					} else {
						echo '<label style="margin-top: 120px; margin-left: 120px;font-size: 22px"><strong>Sin imágenes disponibles </strong></label>';
					}
					?>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="summary entry-summary">
					<?php
					foreach ($descripcion as $key) {
						echo '<h1 style="font-size: 30px !important;" class="mb-0 font-weight-bold text-7" >Compromiso ' . $key['iNumero'] . '</h1>';
					}
					?>
					<div class="pb-0 clearfix">
						<div title="Rated 3 out of 5" class="float-left">
							<input type="text" class="d-none" value="3" title="" data-plugin-star-rating
								   data-plugin-options="{'displayOnly': true, 'color': 'primary', 'size':'xs'}">
						</div>
					</div>
					<?php
					foreach ($descripcion as $key) {
						echo ' <p class="mb-4" style="font-size: 16px !important;" >' . $key['vCompromiso'] . ' </p>';
					}
					?>
					<?php
					foreach ($responsable as $key) {
						echo '<strong style="font-size: 16px" class="text-color-primary">Responsable:</strong> <label style="font-size: 16px"> ' . $key['vDependencia'] . '</label>';
					}
					?>
					<hr style="background: #777 !important;margin-bottom: 3rem!important;margin-top: 0px!important;      margin: 7px 0 !important; margin-top: 1rem !important; border: 0 !important; border-top: 0px solid rgba(0, 0, 0, 0.1) !important;">
					<strong style="font-size: 16px" class="text-color-primary">Participantes(s):</strong>
					<?php
					if ($participantes != null) {
						echo '<ul>';
						foreach ($participantes as $key) {
							echo '<li style="font-size: 16px"> ' . $key['vDependencia'] . '</li>';
						}
						echo '</ul>';
					} else {
						echo '<label style="font-size: 16px">Sin datos disponibles </label>';
					}
					?>
					<hr style="background: #777 !important;margin-bottom: 3rem!important;margin-top: 0px!important;      margin: 7px 0 !important; margin-top: 1rem !important; border: 0 !important; border-top: 0px solid rgba(0, 0, 0, 0.1) !important;">
					<strong style="font-size: 16px" class="text-color-primary">Ficha técnica:</strong>
					<i class="fas fa-file-pdf" style="font-size: 25px;">
					</i>
					<a class=" text-color-primary" style="font-size: 16px" download=""
					   href="https://www.anerbarrena.com/demos/2016/014-audio-helicoptero.mp3">ESTA SECCION ESTA
						pendiente, ya que es una consulta del campo vFeNotarial, que ahora no guarda nada, ademas de que
						ese campo no se sabe la carpte destino en el proyecto</a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<div class="tabs tabs-product mb-2">
					<ul class="nav nav-tabs">
						<li class="nav-item active"><a class="nav-link py-3 px-4" href="#productDescription"
													   data-toggle="tab">Metas de cumplimiento</a></li>
						<li class="nav-item"><a class="nav-link py-3 px-4" href="#productInfo" data-toggle="tab">Evidencia</a>
						</li>
					</ul>
					<div class="tab-content p-0">
						<div class="tab-pane p-4 active" id="productDescription">
						</div>
						<div class="tab-pane p-4" id="productInfo">
							<div class="col-lg-12 mb-4 mb-lg-0">
								<div class="accordion accordion-modern" id="accordion10">
									<div class="card card-default">
										<div class="card-header">
											<h4 class="card-title m-0">
												<a class="accordion-toggle text-color-dark font-weight-bold collapsed"
												   data-toggle="collapse" data-parent="#accordion10"
												   href="#collapse10One" aria-expanded="false">
													<i class="fas fa-file-pdf text-color-primary"></i> Documentos
												</a>
											</h4>
										</div>
										<div id="collapse10One" class="collapse" style="">
											<div class="card-body">
												<?php
												if ($documentos != null) {
													foreach ($documentos as $key) {
														echo '<strong style="font-size: 14px "
																		class="text-color-primary">Documento:</strong>
																<i class="fas fa-file-pdf" style="font-size: 25px;">
				
																</i>
																<a class=" text-color-primary" style="font-size: 14px" download=""
																   href="' . base_url() . 'archivos/documentosOffice/' . $key['vEvidencia'] . '">Enlace
																	de descarga al documento ' . $key['vEvidencia'] . '</a>
																<br>
														';
													}
												} else {

													echo '<label style="margin-top: 120px;margin-bottom: 100px;font-size: 22px"><strong>Sin documentos disponibles </strong></label>';
												}
												?>
											</div>
										</div>
									</div>
									<div class="card card-default">
										<div class="card-header">
											<h4 class="card-title m-0">
												<a class="accordion-toggle text-color-dark font-weight-bold collapsed"
												   data-toggle="collapse" data-parent="#accordion10"
												   href="#collapse10Two" aria-expanded="false">
													<i class="fas fa-image text-color-primary"></i> Fotos
												</a>
											</h4>
										</div>
										<div id="collapse10Two" class="collapse" style="">
											<div class="card-body">
												<div
													class="owl-carousel owl-theme stage-margin owl-loaded owl-drag owl-carousel-init"
													data-plugin-options="{'items': 6, 'margin': 10, 'loop': false, 'nav': true, 'dots': false, 'stagePadding': 40}"
													style="height: auto;">
													<div class="owl-stage-outer">
														<div class="owl-stage"
															 style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1814px; padding-left: 40px; padding-right: 40px;">
															<?php
															if ($galeria_fotos != null) {
																foreach ($galeria_fotos as $key) {
																	echo '<div class="owl-item active"
																				 style="width: 500px; margin-right: 10px;">
																				<div>
																					<img style="height: 160px" alt="" class="img-fluid rounded"
																						 src="' . base_url() . 'archivos/documentosImages/' . $key['vEvidencia'] . '">
																				</div>
																			</div>';

																}
															} else {
																echo '<label style="margin-top: 120px; margin-left: 120px;font-size: 22px"><strong>Sin imágenes disponibles </strong></label>';
															}
															?>
														</div>
													</div>
													<div class="owl-nav">
														<button type="button" role="presentation"
																class="owl-prev disabled"></button>
														<button type="button" role="presentation"
																class="owl-next"></button>
													</div>
													<div class="owl-dots disabled"></div>
												</div>
											</div>
										</div>
									</div>
									<div class="card card-default">
										<div class="card-header">
											<h4 class="card-title m-0">
												<a class="accordion-toggle text-color-dark font-weight-bold collapsed"
												   data-toggle="collapse" data-parent="#accordion10"
												   href="#collapse10Three" aria-expanded="false">
													<i class="fas fa-film text-color-primary"></i> Videos
												</a>
											</h4>
										</div>
										<div id="collapse10Three" class="collapse" style="">
											<div class="card-body">
												<div class="row">
													<?php
													function convertYoutube($string)
													{
														//esta es una funcion que convierte la url de youtube en una ruta "embed"
														return preg_replace(
															"/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
															"<iframe width=\"420\" height=\"315\" src=\"//www.youtube.com/embed/$2\" allowfullscreen></iframe>",
															$string
														);
													}

													if ($videos != null) {
														$i = 1;
														foreach ($videos as $key) {
															$convertidor = convertYoutube($key['vEvidencia']);

															echo '<div class="col-lg-6">
																		<h4>Video ' . $i . '</h4>
																		<div class="embed-responsive-borders">
																			<div class="embed-responsive embed-responsive-16by9">
																				' . $convertidor . '
																			</div>
																		</div>
																	</div>';
															$i++;
														}
													} else {
														echo '<label style="margin-top: 120px; margin-bottom: 120px;font-size: 22px"><strong>Sin videos disponibles </strong></label>';
													}
													?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>

				</div>
			</div>
		</div>
	</div>


</div>

</div>
<?php
$pag = 2;
include 'application/views/masterpage/menu_footer.php';
?>


<input type="hidden" id="id_compromiso" value="<?php echo $this->uri->segment(3); ?>">
<script
	src="https://code.jquery.com/jquery-3.4.1.js"
	integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
	crossorigin="anonymous"></script>
<script src="<?= base_url(); ?>js/compromisos/descripcion_compromisos.js"></script>
