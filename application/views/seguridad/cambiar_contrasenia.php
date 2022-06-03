<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>public/assets/images/favicon.png">
    <title>SIGO</title>
    <!-- Custom CSS -->
    <link href="<?= base_url() ?>public/dist/css/style.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>public/assets/libs/toastr/build/toastr.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>public/assets/libs/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
    <div class="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background:url(<?= base_url() ?>public/img/auth-bg.jpg) no-repeat center center;">
            <div class="auth-box">
                <div id="loginform">
                    <div class="logo">
                        <span class="db"><img src="<?= base_url() ?>public/img/logo_sigo.png" alt="logo" class="responsive" width="200px" /></span>
						<h5 class="font-medium m-b-20">Cambiar contraseña</h5>
                    </div>
                    <!-- Form -->
                    <div class="row">
                        <div class="col-12">
                            <form class="form-horizontal m-t-20" class="needs-validation" novalidate onsubmit="restaurarPassword(this,event);">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="ti-pencil"></i></span>
                                    </div>
                                    <input type="password" class="form-control form-control-lg" name="new_pass" placeholder="Nueva contraseña" aria-label="Usuario" aria-describedby="basic-addon1" required>
                                    <div class="invalid-feedback">
                                        Este campo es requerido
                                    </div>

                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon2"><i class="ti-pencil"></i></span>
                                    </div>
                                    <input type="password" class="form-control form-control-lg" name="rep_pass" placeholder="Repetir contraseña" aria-label="Password" aria-describedby="basic-addon1" required>
                                    <div class="invalid-feedback">
                                        Este campo es requerido
                                    </div>

                                </div>
                                <div class="form-group text-center">
									<input name="idusuario" type="hidden" value="<?= $idusuario ?>">
									<input name="token" type="hidden" value="<?= $token ?>">
                                    <div class="col-xs-12 p-b-20">
                                        <button class="btn btn-block btn-lg btn-info" type="submit">Cambiar contraseña</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <script src="<?= base_url() ?>public/assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?= base_url() ?>public/assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?= base_url() ?>public/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>public/assets/libs/toastr/build/toastr.min.js"></script>
    <script src="<?= base_url() ?>public/assets/libs/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    <script>
        $(".preloader").fadeOut(); 
    </script>
    
    <script>
        function alerta(mensaje,tipo){
            switch(tipo){
                case 'success':
                    toastr.success(mensaje, '¡Exito!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 4000 });    
                    break;
                case 'warning':
                    toastr.warning(mensaje, 'Advertencia', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 4000 });    
                    break;
                case 'error':
                    toastr.error(mensaje, '¡Error!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 4000 });    
                    break;
                default:
                    toastr.info(mensaje, 'Info', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 4000 });
            }
        }
    </script>

	<script>
    function restaurarPassword(f, e) {
		e.preventDefault();

			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>C_seguridad/reestore_password", //Nombre del controlador
				data: $(f).serialize(),

				success: function(resp) {
					if (resp == "correcto") {

                        window.location.href = '<?=base_url()?>';
                        alerta('Restauración exitosa', 'success');
					}
					if(resp == "error_passnew"){
						alerta('La confirmación de la contraseña no coincide con la nueva contraseña', 'warning');
					}
                    if(resp == "error_token"){
						alerta('Se a producido un error, intente nuevamente', 'error');
					}
					if (resp == "error") {
						alerta('Se a producido un error, intente nuevamente', 'error');
					}
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {

				}
			});
    }
</script>
</body>
</html>
