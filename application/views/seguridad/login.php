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
                        <h5 class="font-medium m-b-20"></h5>
                    </div>
                    <!-- Form -->
                    <div class="row">
                        <div class="col-12">
                            <form class="form-horizontal m-t-20" class="needs-validation" novalidate id="loginform" onsubmit="iniciarSesion(this,event);">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="ti-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control form-control-lg" name="vUsuario" placeholder="Usuario" aria-label="Usuario" aria-describedby="basic-addon1" required autofocus="autofocus">
                                    <div class="invalid-feedback">
                                        Este campo es requerido
                                    </div>

                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon2"><i class="ti-pencil"></i></span>
                                    </div>
                                    <input type="password" class="form-control form-control-lg" name="vPassword" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" required>
                                    <div class="invalid-feedback">
                                        Este campo es requerido
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <div class="custom-control custom-checkbox">
                                            <a href="javascript:void(0)" id="to-recover" class="text-dark float-right"><i class="fa fa-lock m-r-5"></i> ¿Olvid&oacute; su contrase&ntilde;a?</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <!-- <div id="div_captcha"></div> -->
                                </div>
                                <div class="form-group text-center">
                                    <div class="col-xs-12 p-b-20">
                                        <button class="btn btn-block btn-lg btn-info" type="submit">Iniciar sesión</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="recoverform">
                    <div class="logo">
                        <div class="row">
                            <div class="col-10">
                            </div>
                            <div class="col-2">
                                <button class="btn btn-block btn-light" type="submit" name="action" id="to-loginform"><i class="mdi mdi-close" alt=""></i></button>
                            </div>
                        </div>
                        <span class="db"><img src="<?= base_url() ?>public/assets/images/logo-icon.png" alt="logo" /></span>
                        <h5 class="font-medium m-b-20">Recuperar password</h5>
                        <span>Ingrese su correo para enviarle instrucciones de como recuperar su password</span>
                    </div>
                    <div class="row m-t-20">
                        <!-- Form -->
                        <form class="col-12" onsubmit="recuperarPassword(this,event);">
                            <!-- email -->
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control form-control-lg" name="correo" type="text" required="required" placeholder="Usuario">
                                </div>
                            </div>
                            <!-- pwd -->
                            <div class="row m-t-20">
                                <div class="col-12">
                                    <button class="btn btn-block btn-lg btn-danger" type="submit" name="action">Recuperar</button>
                                </div>
                            </div>
                        </form>
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
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"async defer></script>
    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    <script>
        var div_captcha;
        var onloadCallback = function() {
            div_captcha = grecaptcha.render('div_captcha', {
              'sitekey' : '6Lcwv5ocAAAAAP2259X_SQVR4NRRb2H0_WWyYQkO'
            });
        };

        $('[data-toggle="tooltip"]').tooltip();
        $(".preloader").fadeOut();
        // ============================================================== 
        // Login and Recover Password 
        // ============================================================== 
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });

        $('#to-loginform').on("click", function() {
            $("#recoverform").slideUp();
            $("#loginform").fadeIn();
        });

        function iniciarSesion(form, event) {
            event.preventDefault();
            event.stopPropagation();

            if (form.checkValidity() === true) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url() ?>C_seguridad/iniciar_sesion",
                    data: $(form).serialize(),
                    success: function(resp) {
                        if (resp == 'correcto') {
                            window.location.href = '<?= base_url() ?>';
                        } else {
                            alerta(resp, 'error');
                        }
                        grecaptcha.reset(div_captcha);
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                       alerta(resp, 'error');
                       grecaptcha.reset(div_captcha);
					   //console.log(XMLHttpRequest);
                    }
                });
            }
            form.classList.add('was-validated');
        }

        function recuperarPassword(form, event) {
            event.preventDefault();
            event.stopPropagation();

            if (form.checkValidity() === true) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url() ?>C_seguridad/enviar_correo",
                    data: $(form).serialize(),
                    success: function(resp) {
                        if (resp == 'correcto') {

                            alerta('Se le a enviado un email con las instrucciones para recuperar su contraseña', 'success');
                        }
                        if(resp == 'error_token') {

                            alerta('El correo ingresado no se encuentra registrado en el sistema, favor de verificar.', 'warning');
                        }
                        if(resp == 'error_email') {

                            alerta('El correo ingresado no se encuentra registrado en el sistema, favor de verificar.', 'warning');
                        }
                        if(resp == 'error') {

                            alerta('Se a producido un error, intentar más tarde', 'error');
                        }

                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        alerta(resp, 'error');
                    }
                });
            }
            form.classList.add('was-validated');
        }

        function alerta(mensaje, tipo) {
            switch (tipo) {
                case 'success':
                    toastr.success(mensaje, '¡Exito!', {
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        timeOut: 2000
                    });
                    break;
                case 'warning':
                    toastr.warning(mensaje, 'Advertencia', {
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        timeOut: 2000
                    });
                    break;
                case 'error':
                    toastr.error(mensaje, '¡Error!', {
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        timeOut: 2000
                    });
                    break;
                default:
                    toastr.info(mensaje, 'Info', {
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        timeOut: 2000
                    });
            }
        }

        function confirmar(mensaje, funcion, var1) {
            //event.preventDefault();
            var1 = var1 || '';
            swal({
                title: mensaje,
                /*text: mensaje,*/
                //icon: 'info',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Confirmar",
                cancelButtonText: "Cancelar",
            }).then((confirm) => {

                if (confirm.hasOwnProperty('value')) {
                    if (var1 != '') funcion(var1);
                    else funcion();
                }
            });
        }
    </script>
</body>

</html>
