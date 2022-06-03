<footer id="footer" >
	<div class="container">
		<div class="row py-5 justify-content-center">
			<div  class="col-md-9 offset-md-1 offset-lg-0 mb-4 mb-lg-0 d-flex align-items-center">
				<div class="footer-nav footer-nav-links footer-nav-bottom-line">
					<nav>
						<ul class="nav" id="footerNav">

							<li>
								<a class="<?php echo ($pag == 1) ? 'active' : ''; ?>" href="<?=base_url()?>control_pagina/index">Inicio</a>
							</li>
							<li>
								<a class="<?php echo ($pag == 2) ? 'active' : ''; ?>" href="<?=base_url()?>compromisos/listar">Compromisos</a>
							</li>
						</ul>
					</nav>
				</div>
			</div>
			<div class="col-md-4 col-lg-3 mb-4 mb-lg-0 text-center text-lg-right">
				<h5 class="text-3 mb-3">CONTACTO</h5>
				<ul class="list list-icons list-icons-lg">
					<li class="mb-1"><i class="far fa-dot-circle text-color-primary"></i>
						<p class="m-0">Domicilio Oficial del Gobierno Estatal,
							Ciudad, Estado, México.</p></li>
					<li class="mb-1"><i class="fas fa-phone text-color-primary"></i>
						<p class="m-0"><a href="tel:9999999999">(999) 61180 10 Ext. 47004</a></p></li>

				</ul>
			</div>
		</div>
	</div>
	<div class="footer-copyright footer-copyright-style-2">
		<div class="container py-2">
			<div class="row py-4">
				<div class="col-lg-1 d-flex align-items-center justify-content-center justify-content-lg-start mb-2 mb-lg-0">
					<a  class="logo pr-0 pr-lg-3">
						<img alt="compromisos width="30" height="40" src="<?=base_url();?>img/logo_compromiso_white.png">
					</a>
				</div>
				<div class="col-lg-11 d-flex align-items-center justify-content-center justify-content-lg-end mb-4 mb-lg-0">
					<img alt="compromisos width="30" height="40" src="<?=base_url();?>img/logo_seplan.png">
				</div>
			</div>
		</div>
	</div>
</footer>
</div>
