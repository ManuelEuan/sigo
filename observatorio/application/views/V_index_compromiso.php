<?php
$pag = 1;
include 'application/views/masterpage/navagacionnavb.php';
?>
<div role="main" class="main">
	<style>
		.break-word {
			-ms-word-break: break-all;
			word-break: break-all;

		/ / Non standard for webkit word-break: break-word;

			-webkit-hyphens: auto;
			-moz-hyphens: auto;
			-ms-hyphens: auto;
			hyphens: auto;
		}
	</style>
	<div class="slider-container rev_slider_wrapper" style="height: 100vh;">
		<div id="revolutionSlider" class="slider rev_slider" data-version="5.4.8" data-plugin-revolution-slider
			 data-plugin-options="{'sliderLayout': 'fullscreen', 'delay': 9000, 'gridwidth': 1170, 'gridheight': 700, 'disableProgressBar': 'on', 'responsiveLevels': [4096,1200,992,500], 'navigation' : {'arrows': { 'enable': true, 'style': 'arrows-style-1 arrows-big' }, 'bullets': {'enable': false, 'style': 'bullets-style-1', 'h_align': 'center', 'v_align': 'bottom', 'space': 7, 'v_offset': 70, 'h_offset': 0}}}">
			<ul id="listar_Compromisos">
				<?php
				foreach ($compromisos_10 as $compromiso) {
					$imagen = "";
					if ($compromiso['imagenes']['vEvidencia'] == "") {
						$imagen = "slide-corporate-13-1.jpg";

					} else {
						$imagen = $compromiso['imagenes']['vEvidencia'];
					}
					echo '<li class="slide-overlay slide-overlay-gradient slide-overlay-level-9" data-transition="fade">
					<img src="' . base_url() . 'archivos/documentosImages/' . $imagen . '"
						 alt=""
						 data-bgposition="center center"
						 data-bgfit="cover"
						 data-bgrepeat="no-repeat"
						 class="rev-slidebg">

					<h1 class="tp-caption text-color-light font-weight-normal"
						data-x="center"
						data-y="center" data-voffset="[\'-110\',\'-110\',\'-110\',\'-180\']"
						data-start="700"
						data-fontsize="[\'22\',\'22\',\'22\',\'40\']"
						data-lineheight="[\'25\',\'25\',\'25\',\'45\']"
						data-letterspacing="0"
					</h1>

					<div class="tp-caption d-none d-md-block"
						 data-frames=\'[{"delay":2400,"speed":100,"frame":"0","from":"opacity:0;x:10%;","to":"opacity:1;x:0;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]\'
						 data-x="center" data-hoffset="[\'100\',\'100\',\'100\',\'135\']"
						 data-y="center" data-voffset="[\'-92\',\'-92\',\'-92\',\'-100\']"><img
							src="' . base_url() . 'archivos/documentosImages/slide-white-line.png" alt=""></div>

					<div  class="tp-caption font-weight-extra-bold text-color-light negative-ls-2 ws-nowrap break-word	"
						 data-frames=\'[{"delay":1000,"speed":2000,"frame":"0","from":"sX:1.5;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]\'
						 data-x="center"
						 data-y="center" data-voffset="[\'-60\',\'-60\',\'-60\',\'-85\']"
						 data-fontsize="[\'25\',\'25\',\'25\',\'25\']"
						 data-lineheight="[\'55\',\'55\',\'55\',\'95\']"
						 data-letterspacing="-2">' . $compromiso['vCompromiso'] . '
						
					</div>

					<div class="tp-caption font-weight-light text-color-light text-center ws-normal"
						 data-frames=\'[{"from":"opacity:0;","speed":300,"to":"o:0.8;","delay":2000,"split":"chars","splitdelay":0.04,"ease":"Power2.easeInOut"},{"delay":"wait","speed":1000,"to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]\'
						 data-x="center"
						 data-y="center" data-voffset="[\'15\',\'15\',\'15\',\'40\']"
						 data-width="[\'350\',\'350\',\'350\',\'875\']"
						 data-fontsize="[\'18\',\'18\',\'18\',\'50\']"
						 data-lineheight="[\'29\',\'29\',\'29\',\'60\']">' . $compromiso['vDescripcion'] . '
					</div>

					<a class="tp-caption btn btn-primary font-weight-semibold"
					   data-frames=\'[{"delay":3500,"speed":2000,"frame":"0","from":"opacity:0;y:50%;","to":"o:1;y:0;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]\'
					   data-hash
					   data-hash-offset="85"
					   href="' . base_url() . 'compromisos/descripcion/' . base64_encode($compromiso['iIdCompromiso']) . '/' . base64_encode($compromiso['iIdDependencia']) . '"
					   data-x="center" data-hoffset="0"
					   data-y="center" data-voffset="[\'100\',\'100\',\'100\',\'210\']"
					   data-whitespace="nowrap"
					   data-fontsize="[\'14\',\'14\',\'14\',\'33\']"
					   data-paddingtop="[\'16\',\'16\',\'16\',\'40\']"
					   data-paddingright="[\'33\',\'33\',\'33\',\'80\']"
					   data-paddingbottom="[\'16\',\'16\',\'16\',\'40\']"
					   data-paddingleft="[\'33\',\'33\',\'33\',\'80\']">Consulta</a>

				</li>';
				}
				?>
			</ul>
		</div>
	</div>

	<div class="container">
		<div class="row justify-content-center py-4 my-5" style="font-weight: bold">
			<div class="row text-center">
				<div class="col">
					<p class="font-weight-bold text-color-dark" style="font-size: 20px">
						¿Qué es el observatorio de compromisos?
						<?php var_dump(RUTA_ARCHIVOS); ?>
					</p>
				</div>
			</div>
			<div class="col-lg-10">

				<div class="tabs tabs-bottom tabs-center tabs-simple">
					<ul class="nav nav-tabs mb-3">
						<li class="nav-item active appear-animation" data-appear-animation="fadeInLeftShorter"
							data-appear-animation-delay="200">
							<a class="nav-link" href="#tabsNavigationSimpleIcons1" data-toggle="tab">
											<span class="featured-boxes featured-boxes-style-6 p-0 m-0">
												<span
													class="featured-box featured-box-primary featured-box-effect-6 p-0 m-0">
													<span class="box-content p-0 m-0">
														 <img alt="compromisos width="
															  30" height="50" src="<?= base_url(); ?>img/icono_c.png">
													</span>
												</span>
											</span>
								<h4 class="font-weight-bold text-color-dark text-3 mb-0 pb-0 mt-2">Compromisos</h4>
							</a>
						</li>
						<li class="nav-item appear-animation" data-appear-animation="fadeInLeftShorter">
							<a class="nav-link" href="#tabsNavigationSimpleIcons2" data-toggle="tab">
											<span class="featured-boxes featured-boxes-style-6 p-0 m-0">
												<span
													class="featured-box featured-box-primary featured-box-effect-6 p-0 m-0">
													<span class="box-content p-0 m-0">
														<img alt="compromisos width="
															 30" height="50" src="<?= base_url(); ?>img/icono_documento.png">
													</span>
												</span>
											</span>
								<h4 class="font-weight-bold text-color-dark text-3 mb-0 pb-0 mt-2">Documentos</h4>
							</a>
						</li>
						<li class="nav-item appear-animation" data-appear-animation="fadeInRightShorter">
							<a class="nav-link" href="#tabsNavigationSimpleIcons3" data-toggle="tab">
											<span class="featured-boxes featured-boxes-style-6 p-0 m-0">
												<span
													class="featured-box featured-box-primary featured-box-effect-6 p-0 m-0">
													<span class="box-content p-0 m-0">
														<img alt="compromisos width="
															 30" height="50" src="<?= base_url(); ?>img/icono_noticias.png">
													</span>
												</span>
											</span>
								<h4 class="font-weight-bold text-color-dark text-3 mb-0 pb-0 mt-2">Noticias</h4>
							</a>
						</li>

					</ul>

					<div class="tab-content appear-animation" data-appear-animation="fadeInUpShorter"
						 data-appear-animation-delay="300">
						<div class="tab-pane active" id="tabsNavigationSimpleIcons1">
							<!--este es el id por cada click que se le da al tab -->
							<div class="text-center">
								<p class="lead mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut
									feugiat urna arcu, vel molestie nunc commodo non. Nullam vestibulum odio vitae
									fermentum rutru , vel molestie nunc commodo non. Nullam vestibulum odio vitae
									fermentum rutrum , vel molestie nunc commodo non.</p>
								<p class="px-5">Mauris lobortis nulla ut aliquet interdum. Donec commodo ac elit
									sedauris lobortis nulla ut aliquet interdum. Donec commodo ac elit sed placerat.
									Mauris ac sodales gravida. In eros felis, elementum.</p>
							</div>
						</div>
						<div class="tab-pane" id="tabsNavigationSimpleIcons2">
							<div class="text-center">
								<p class="lead mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
									Pellentesque eu nunc in justo hendrerit vulputate in sed nibh. Ut tristique
									metus eu ipsum egestas, vel malesuada odio semper. Aenean quis ultrices nisl. Ut
									sagittis tellus ac aliquet rhoncus. Aliquam.</p>
								<p class="px-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse
									blandit neque non purus vulputate eleifend. Donec porta, ipsum non congue
									accumsan, odio orci dapibus leo, sit amet vehicula ligula nulla.</p>
							</div>
						</div>
						<div class="tab-pane" id="tabsNavigationSimpleIcons3">
							<div class="text-center">
								<p class="lead mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
									nunc metus, accumsan ac eros fermentum, blandit sagittis orci. Ut a laoreet
									massa. In mauris diam, dapibus at commodo in, egestas ut elit. Curabitur
									dignissim tellus nulla, ut porta ante.</p>
								<p class="px-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus
									pulvinar a mi in vehicula. Sed aliquam, turpis sed lacinia viverra, est neque
									pretium ex, et varius est massa vel sem.</p>
							</div>
						</div>

					</div>
				</div>

			</div>
		</div>
	</div>

	<hr class="my-0">

	<div class="container">
		<div class="row py-4 my-5">
			<div class="col py-3">
				<div class="owl-carousel owl-theme mb-0"
					 data-plugin-options="{'responsive': {'0': {'items': 3}, '476': {'items': 3}, '768': {'items': 3}, '992': {'items': 3}, '1200': {'items': 3}}, 'autoplay': true, 'autoplayTimeout': 3000, 'dots': false}">
					<div>
						<a href="http://www.estado.gob.mx" target="_blank">
							<img class="img-fluid opacity-2" src="<?= base_url(); ?>img/yuc_gris.png" alt="">
						</a>
					</div>
					<div>
						<a href="https://www.inegi.org.mx" target="_blank">
							<img class="img-fluid opacity-2" src="<?= base_url(); ?>img/inegi_gris.png" alt="">
						</a>
					</div>
					<div>
						<a href="http://subdominio.gobierno.gob.mx/" target="_blank">
							<img class="img-fluid opacity-2" src="<?= base_url(); ?>img/siegy_gris.png" alt="">
						</a>
					</div>

				</div>

			</div>
		</div>
	</div>

	<section class="section section-height-3 bg-color-grey-scale-1 border-0 m-0 appear-animation"
			 data-appear-animation="fadeIn">
		<div class="container">
			<div class="row align-items-center text-center text-md-left">
				<div class="col-md-6 mb-5 mb-md-0 appear-animation" data-appear-animation="fadeInRightShorter"
					 data-appear-animation-delay="200">
					<h2 class="font-weight-bold text-7 line-height-1 ls-0 mb-3">Testigos ciudadanos</h2>

					<p class="mb-4 pr-md-5">El grupo de Testigos Ciudadanos promueve el cumplimiento de los xxx
						compromisos del Gobierno del Estado mediante la formulación de planteamientos y
						recomendaciones que mejoren el desempeño de las políticas públicas implementadas para
						concretar las acciones pactas con la sociedad.

					</p>
					<p>
						Este grupo funge como contraloría social mediante el establecimiento de canales de
						comunicación entre el Gobierno del Estado y los diferentes sectores en  para la
						retroalimentación de las acciones vinculadas a los compromisos del Gobierno, el fomento a la
						transparencia y la rendición de cuentas.
					</p>

				</div>
				<div class="col-md-6 col-lg-5 offset-lg-1 appear-animation"
					 data-appear-animation="fadeInRightShorter" data-appear-animation-delay="400">
					<div class=" owl-theme nav-style-1 stage-margin mb-0"
						 data-plugin-options="{'responsive': {'576': {'items': 1}, '768': {'items': 1}, '992': {'items': 1}, '1200': {'items': 1}}, 'margin': 25, 'loop': true, 'nav': true, 'dots': false, 'stagePadding': 40}">
						<div class="p-4">
							<img class="img-fluid  mb-3" src="<?= base_url(); ?>img/gallery/testigo_ciudadano.png"
								 alt=""/>
						</div>

					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row align-items-center text-center text-md-left">

				<div class="col-md-6 col-lg-5 offset-lg-1 appear-animation"
					 data-appear-animation="fadeInRightShorter" data-appear-animation-delay="400">
					<div class=" owl-theme nav-style-1 stage-margin mb-0"
						 data-plugin-options="{'responsive': {'576': {'items': 1}, '768': {'items': 1}, '992': {'items': 1}, '1200': {'items': 1}}, 'margin': 25, 'loop': true, 'nav': true, 'dots': false, 'stagePadding': 40}">
						<div class="p-4">
							<img class="img-fluid  mb-3" src="<?= base_url(); ?>img/gallery/Logo-verde-FPEY-300x274.png"
								 alt=""/>
						</div>

					</div>
				</div>
				<div class="col-md-6 mb-5 mb-md-0 appear-animation" data-appear-animation="fadeInRightShorter"
					 data-appear-animation-delay="200" style="text-align:right ">
					<h2 class="font-weight-bold text-7 line-height-1 ls-0 mb-3">Plan estratégico de </h2>

					<p style="">La asociación civil, en la que participan hoy día 23 entidades comprometidas con el
						futuro de , colabora con sus opiniones y propuestas en la búsqueda de soluciones a
						los problemas que afectan el desarrollo de la estado y de sus habitantes.

					</p>
					<a href="https://estado.org.mx"
					   class="btn btn-primary font-weight-semibold rounded-0 text-2 btn-px-5 btn-py-2" target="_blank">Visitar</a>


				</div>
			</div>
		</div>
	</section>

	<div class="container-fluid">
		<div style="margin-bottom: -50px !important;" class="row featured-boxes-full featured-boxes-full-scale"
			 id="listado_compromisos">

		</div>
	</div>

</div>
<?php
$pag = 1;
include 'application/views/masterpage/menu_footer.php';
?>
<script
	src="https://code.jquery.com/jquery-3.4.1.js"
	integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
	crossorigin="anonymous"></script>
<script src="<?= base_url(); ?>js/compromisos/compromisos.js"></script>
