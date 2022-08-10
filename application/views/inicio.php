<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <!--<link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon.png">-->
    <title>SIGO</title>
    <!-- Custom CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <link href="<?=base_url()?>public/assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <link href="<?=base_url()?>public/assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="<?=base_url()?>public/assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <!-- This page plugin CSS -->
    <link href="<?=base_url()?>public/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url() ?>public/boots/bootstrap/miboostrapt/bootstrap-select.min.css" />

    <!-- Custom CSS -->
    <link href="<?=base_url()?>public/dist/css/style.css" rel="stylesheet">
    <link href="<?=base_url()?>public/assets/libs/toastr/build/toastr.min.css" rel="stylesheet">
    <link href="<?=base_url()?>public/assets/libs/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- swicht -->
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

<!-- select2 -->
<link rel="stylesheet" type="text/css" href="<?=base_url();?>public/assets/libs/select2/dist/css/select2.min.css">
<link href="<?=base_url();?>public/dist/css/style.min.css" rel="stylesheet">
<style type="text/css">
.select2-container .select2-selection--single{
    height:34px !important;
}
.select2-container--default .select2-selection--single{
         border: 1px solid #ccc !important; 
     border-radius: 0px !important; 
}
    #contenido {
          min-height:calc(100vh - 168px) !important;
        }
</style>
</head>

<body class="" style="height: 100% !important;">
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
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" style="height: 100% !important;">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                        <i class="ti-menu ti-close"></i>
                    </a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <div class="navbar-brand">
                        <a href="<?= base_url() ?>" class="logo">
                            <!-- Logo text -->
                            <span class="logo-text">
                                <!-- dark Logo text -->
                                <img src="<?=base_url()?>public/img/logo_sigo.png" width="150px" alt="logo" class="dark-logo" />
                                <!-- Light Logo text -->
                                <img src="<?=base_url()?>public/img/logo_sigo.png" width="150px" class="light-logo" alt="logo" />
                            </span>
                        </a>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="ti-more"></i>
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-left mr-auto">
                        
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">
                        <!-- ============================================================== -->
                        <!-- Messages -->
                        <!-- ============================================================== -->
                        
                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->
                      
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="<?=base_url()?>public/assets/images/users/generic-user.png" alt="user" class="rounded-circle" width="40">
                                <span class="m-l-5 font-medium d-none d-sm-inline-block" style="color: #000000;"> <?= $_SESSION[PREFIJO.'_usuario'] ?> <i class="mdi mdi-chevron-down"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <span class="with-arrow">
                                    <span class="bg-primary"></span>
                                </span>
                                <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
                                    <div class="">
                                        <img src="<?=base_url()?>public/assets/images/users/generic-user.png" alt="user" class="rounded-circle" width="60">
                                    </div>
                                    <div class="m-l-10">
                                        <h6 class="m-b-0"><?= $_SESSION[PREFIJO.'_nombre'] ?></h6>
                                        <p class=" m-b-0"><?= $_SESSION[PREFIJO.'_rol'] ?></p>
                                    </div>
                                </div>
                                <!--<a class="dropdown-item" href="javascript:void(0)">
                                    <i class="ti-user m-r-5 m-l-5"></i> Perfil</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="ti-settings m-r-5 m-l-5"></i> Ajustes</a>
                                <div class="dropdown-divider"></div>-->
                                <a class="dropdown-item" style="cursor: pointer;" onclick="confirmar('¿Realmente desea cerrar sesión?',cerrarSesion);">
                                    <i class="fa fa-power-off m-r-5 m-l-5"></i> Cerrar sesión</a>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <?=$menu_navegacion?>
                <input type="text" value="<?= base_url() ?>" id="base_url" style="display:none">
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper" id="contenido">
        </div>
        <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                ESZ Smart Solutions<a href="https://esz.com.mx" target="blank">@2021</a>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    
    <div class="chat-windows"></div>
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="<?=base_url()?>public/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="<?=base_url()?>public/assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?=base_url()?>public/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?=base_url()?>public/dist/js/app.min.js"></script>
    <script src="<?=base_url()?>public/dist/js/app.init.horizontal.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?=base_url()?>public/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="<?=base_url()?>public/assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Menu sidebar -->
    <script src="<?=base_url()?>public/dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="<?=base_url()?>public/dist/js/custom.js"></script>
    <script src="<?=base_url()?>public/assets/extra-libs/DataTables/datatables.min.js?v=0.1"></script>
    <script src="<?=base_url()?>public/dist/js/pages/datatable/datatable-basic.init.js"></script>
    <script src="<?=base_url()?>public/assets/libs/toastr/build/toastr.min.js"></script>
    <script src="<?=base_url()?>public/assets/libs/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <!-- switch -->
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <!--Mask-->
    <script src="<?=base_url();?>public/assets/libs/inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
    <script src="<?=base_url();?>public/dist/js/pages/forms/mask/mask.init.js"></script>
    <script src="<?=base_url()?>public/assets/libs/ckeditor/ckeditor.js"></script>
    <!-- select2 -->
    <script src="<?=base_url()?>public/assets/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="<?=base_url()?>public/assets/libs/select2/dist/js/select2.min.js"></script>
    <script src="<?=base_url()?>public/dist/js/pages/forms/select2/select2.init.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.highcharts.com/maps/modules/map.js"></script>
    <script src="<?=base_url()?>public/assets/libs/block-ui/jquery.blockUI.js"></script>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js" integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/javascript">
        var moduloInicial = '<?=$modulo_inicial?>';
        $(document).ready(function (){

            $(document).ajaxStart(function(){
                validateSesion();
                $.blockUI();
            }).ajaxStop($.unblockUI);

            if(moduloInicial != ''){
                cargar(moduloInicial,"#contenido");    
            }
        });

        function validateSesion(){            
            var jqxhr = $.post( "<?=base_url();?>validate_sesion", function(response) {
                if(!JSON.parse(response) == true){
                    alert('Su sesión ha expirado.');
                    location.reload();
                }
            })
            .fail(function() {
                alert('Ha ocurrido un error.');
                location.reload();
            });
        }


        function cargar(pagina,obj,metodo,variables) {
            var loading = '<div id="page-loader" class="fade in"><span class="spinner"></span></div>';
            if(typeof(metodo) == "undefined" || metodo == ""){ metodo = "POST";}
            if(typeof(variables) == "undefined" || variables == ""){ variables = "";}
            //$(obj).html(loading);
            $.ajax({
                url: pagina,
                type: metodo,
                async: true,
                data: variables,
                success: function(htmlcode){
                    $(obj).html(htmlcode);
                },
                error: function(XMLHttpRequest, errMsg, exception){
                    console.log(errMsg,"error");
                }
            });
        }

        function cerrarSesion(){            
            $.ajax({
                url: '<?=base_url()?>C_seguridad/cerrar_sesion',
                type: 'POST',
                async: true,
                success: function(htmlcode){
                    window.location.href = '<?=base_url()?>';
                },
                error: function(XMLHttpRequest, errMsg, exception){
                    console.log(errMsg,"error");
                }
            });
        }

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

        function confirmar(mensaje,funcion,var1){
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

                if(confirm.hasOwnProperty('value')){
                    if(var1 != '') funcion(var1);
                    else funcion();
                } 
            });
        }

        function moneyFormat(id) {
            let num = $('#'+id).val();
            let newnum = num.replace(/,/g,'');
            let money = new Intl.NumberFormat('es-MX').format(Number(newnum));
            $('#'+id).val(money);
        }

        // Funciones para el manejo de cantidades
        function soloDigitos(e,decReq,decNeg) {
            var isIE = document.all?true:false;
            var isNS = document.layers?true:false;
            var key = (isIE) ? event.keyCode : e.which;
            var obj = (isIE) ? event.srcElement : e.target;
            var isNum = (key > 47 && key < 58) ? true : false;
            var dotOK = (key==46 && decReq=='OK' && (obj.value.indexOf(".")<0 || obj.value.length==0)) ? true:false;
            var isDel = (key==0 || key==8 ) ? true:false;
            var isEnter = (key==13) ? true:false;
            var isNeg = (key==45 && decNeg=='MIN' && (obj.value.indexOf("-")<0 || obj.value.length==0)) ? true:false;

            //e.which = (!isNum && !dotOK && isNS) ? 0 : key;
            return (isNum || dotOK || isDel || isEnter || isNeg);
        }
    </script>
</body>
</html>
