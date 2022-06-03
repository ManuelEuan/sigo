<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="SemiColonWeb" />

	<!-- Stylesheets
	============================================= -->
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700|Raleway:300,400,500,600,700|Crete+Round:400i" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?=base_url();?>public/css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="<?=base_url();?>public/css/style.css" type="text/css" />
	<link rel="stylesheet" href="<?=base_url();?>public/css/swiper.css" type="text/css" />
	<link rel="stylesheet" href="<?=base_url();?>public/css/dark.css" type="text/css" />
	<link rel="stylesheet" href="<?=base_url();?>public/css/font-icons.css" type="text/css" />
	<link rel="stylesheet" href="<?=base_url();?>public/css/animate.css" type="text/css" />
	<link rel="stylesheet" href="<?=base_url();?>public/css/magnific-popup.css" type="text/css" />

	<link rel="stylesheet" href="<?=base_url();?>public/css/responsive.css" type="text/css" />
	<!--Modal Loading -->
	<link type="text/css" rel="stylesheet" href="<?=base_url();?>admin/plugins/modal-loading/css/modal-loading.css" />
	<link type="text/css" rel="stylesheet" href="<?=base_url();?>admin/plugins/modal-loading/css/modal-loading-animate.css" />
	<!--Modal Loading -->
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<!-- Document Title
	============================================= -->
	<title>Participación Ciudadana</title>

</head>

<body class="stretched" data-loader="2" data-animation-in="fadeIn" data-speed-in="1500" data-animation-out="fadeOut" data-speed-out="800">

	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">

		<div id="home" class="page-section" style="position:absolute;top:0;left:0;width:100%;height:200px;z-index:-2;"></div>

		
		<!-- Header
		============================================= -->
		<?php  include('header.php'); ?>

		<div class="clear"></div>

		<!-- Content
		============================================= -->
		<section id="content">

			<div class="content-wrap">

				<div class="container clearfix">

					<div class="tabs divcenter nobottommargin clearfix" id="tab-login-register" style="max-width: 500px;">

						<div class="card nobottommargin">
							<div class="card-body" style="padding: 40px;">
								<form id="login-form" name="login-form" class="nobottommargin" method="post" action="" onsubmit="">

									<h3>Recuperar contraseña</h3>

									<div class="col_full" id="#divcorreo">
										<label for="login-form-username">Correo electrónico:</label>
										<input type="text" id="correo" name="correo" value="" class="form-control" autocomplete="off" />
									</div>
									

									<div class="col_full nobottommargin">
										<button class="button button-3d nomargin" id="login-form-submit" name="login-form-submit" value="login">Enviar correo</button>
									</div>

								</form>
							</div>
						</div>

					</div>

				</div>

			</div>
		<!-- Footer
		============================================= -->
		<?php include('footer.php'); ?>

	</div><!-- #wrapper end -->

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-angle-up"></div>

	<!-- External JavaScripts
	============================================= -->
	<script src="<?=base_url();?>public/js/jquery.js"></script>
	<script src="<?=base_url();?>public/js/plugins.js"></script>
	<script src="<?=base_url();?>public/js/plugins/jquery.validation.js"></script>

	<!-- Footer Scripts
	============================================= -->
	<script src="<?=base_url();?>public/js/functions.js"></script>
	<script src="<?=base_url();?>public/js/funciones.js?v=4"></script>
	<!--Modal Loading -->
	<script src="<?=base_url();?>admin/plugins/modal-loading/js/modal-loading.js"></script>
	<!--Modal Loading -->


	<script>

	</script>
	<!-- External JavaScripts
				============================================= -->
				
	<script >
		$( "#login-form" ).validate({
		  	rules: {
		    	correo: {
		      		required: true,
		      		email: true
		    	}
		  	},
		  	messages: {		  		
			    correo: {
			    	required: "Este campo es requerido",
			    	email: "Por favor ingrese un correo en formato ejemplo@dominio.com"
			    }
		  	},
		  	submitHandler: function(form){
		  		EnviarCorreoRecuperacion(form,'<?=base_url();?>C_seguridad/validar_envio_recuperacion_contrasenia');

		  	}
		});

		function EnviarCorreoRecuperacion(form,url_destino)
		{
			var loading = new Loading({
					discription: 'Espere...',
			    	defaultApply: true
			    });
			$.ajax({
		        url: url_destino,
		        type: 'POST',
		        async: false,	//	Para obligar al usuario a esperar una respuesta
		        data: $(form).serialize(),
		        error: function(XMLHttpRequest, errMsg, exception){
		            var msg = "Ha fallado la petición al servidor";
		            alert(msg);
		        },
		        success: function(htmlcode){
		        	var cod = htmlcode.split("-");
		        	switch(cod[0])
		            {
		                case "0":
		                	loading.out();
		                    Notificacion('Correo enviado','success');
		                    break;                    
		                default:
		                	loading.out();
		                    Notificacion(htmlcode,'error');
		                    break;
		            }
		        }
		    });	
		}

	</script>

	<!-- Footer Scripts
	============================================= -->
  	
</body>
</html>