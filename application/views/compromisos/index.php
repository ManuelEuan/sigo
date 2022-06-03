<div class="container-fluid" id="buscador_compromiso"
     style="height: 100% !important; min-height: 100% !important; display: block;">
    <style TYPE="text/css">
        input.alinear {
            margin-right: 100px !important;
        }

        .progress-c {
            width: 110px;
            height: 110px;
            background: none;
            position: relative;
        }

        .progress-c::after {
            content: "";
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 6px solid #eee;
            position: absolute;
            top: 0;
            left: 0;
        }

        .progress-c>span {
            width: 50%;
            height: 100%;
            overflow: hidden;
            position: absolute;
            top: 0;
            z-index: 1;
        }

        .progress-c .progress-c-left {
            left: 0;
        }

        .progress-c .progress-c-bar {
            width: 100%;
            height: 100%;
            background: none;
            border-width: 6px;
            border-style: solid;
            position: absolute;
            top: 0;
        }

        .progress-c .progress-c-left .progress-c-bar {
            left: 100%;
            border-top-right-radius: 100px;
            border-bottom-right-radius: 100px;
            border-left: 0;
            -webkit-transform-origin: center left;
            transform-origin: center left;
        }

        .progress-c .progress-c-right {
            right: 0;
        }

        .progress-c .progress-c-right .progress-c-bar {
            left: -100%;
            border-top-left-radius: 100px;
            border-bottom-left-radius: 100px;
            border-right: 0;
            -webkit-transform-origin: center right;
            transform-origin: center right;
        }

        .progress-c .progress-c-value {
            position: absolute;
            top: 0;
            left: 0;
        }

    </style>
    <?php
    //$permisorevision=0;
    $res = ($permisorevision > 0) ? 'class="col-10"' : 'class="col-12"';
    $periodoactivo = ($periodorevision == 0) ? '' : 'disabled="disabled"';
    ?>
    <div class="row">
        <div <?= $res ?>>
            <div class="card">
                <div class="card-body">
                    <h1 class="page-title">Compromisos</h1>
                    <h6 class="card-subtitle">Administración del catalogo de compromisos </h6>
                    <h4 class="card-title">Búsqueda</h4>
                    <h6 class="card-subtitle"></h6>
                    <form class="" id="buscarCompromiso" onsubmit="buscar(event);">
                        <input type="hidden" id="start" value="0">
                        <input type="hidden" id="length" value="10">
                        <div class="row">
                            <?php if(isset($ejes)){ ?>
                            <div class="col-4">
                                
                                <div class="form-group">
                                    <label for="eje">Eje Rector</label>
                                    <select name="eje" id="eje" class="custom-select" onchange="cargarResponsables();">
                                        <option value="0">Todos</option>
                                        <?= $ejes; ?>
                                    </select>
                                </div>
                            </div>
                            <?php } else echo '<input type="hidden" name="eje" id="eje" value="'.$sec.'">'; 
                            if(isset($dependencias)) {?>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="dependencia">Responsable</label>
                                    <select name="dependencia" id="dependencia" class="custom-select">
                                        <option value="0">Todos</option>
                                        <?= $dependencias; ?>
                                    </select>
                                </div>
                            </div>
                            <?php } else echo '<input type="hidden" name="dependencia" id="dependencia" value="'.$dep.'">'; ?>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="estatus">Estatus</label>
                                    <select name="estatus" id="estatus" class="custom-select">
                                        <option value="0">Todos</option>
                                        <?= $estatus; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="eje">Última actualización posterior a:</label>
                                    <input type="date" class="form-control" name="fecha" id="fecha" value="">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="eje">Nombre o número de compromiso:</label>
                                    <input type="text" class="form-control" name="palabra" id="palabra" value="">
                                </div>
                            </div>

                            <div class="form-group col-2" style="margin-top: 30px;">
                                <button type="submit" class="btn waves-effect waves-light">Buscar
                                </button>

                            </div>

                            <div class="form-group col-2" style="margin-top: 30px;">
                                <button type="button" class="btn btn-primary btn-block"
                                        onclick="agregar_compromiso()" <?= $periodoactivo ?> >Nuevo
                                </button>
                            </div>

                        </div>
                </div>
                </form>
                <?php
                echo $periodoactivo = ($periodorevision == 0) ? '' : '<center><h4 style="color:red">Atención el periodo de revision se encuentra activo</h4></center>';

                ?>
            </div>
        </div>
        <?php
        $periodoactivo2 = ($periodorevision == 0) ? '<input type="submit" style="visibility: hidden"/>' : '<input style="width: 111% !important;" type="submit" value="Publicar compromiso" onclick="esperar(1)" class="btn btn-primary alinear" >
                </center>';

        ?>
        <?php
        if ($permisorevision > 0) {
            echo '
				 <div class="col-2">
            <div class="card">
                <div class="card-body">
                <h4 class="page-title">Activar periodo de evaluaciones </h4></br></br></br>
                <center>
                <input type="checkbox" checked data-toggle="toggle" id="periodoEval"></br></br>
                ' . $periodoactivo2 . '</br></br></br></br>';

        }
        ?>
    </div>
</div>
</div>
</div>
</div>

<section id="contenedor" class="container-fluid">
    <?php
    include_once('tabla.php');
    ?>
    
</section>

<script type="text/javascript">
    var table;



     $(function () {
        $('#periodoEval').bootstrapToggle({
            on: 'Activado',
            off: 'Desactivado'
        })
        <?php
        if ($periodorevision == 1) {
            echo '$("#periodoEval").bootstrapToggle("on")';
        } else {
            echo '$("#periodoEval").bootstrapToggle("off")';
        }
        ?>

    });

    $(function () {
        $('#periodoEval').change(function () {
            if ($(this).prop('checked') === true) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url() ?>C_compromisos/actualizarperiodo", //Nombre del controlador
                    data: {
                        'iActivo': 1
                    },
                    success: function (resp) {
                        if (resp == 'correcto') {
                            listar_compromiso();
                            alerta('Periodo de revision activo', 'success');
                            cargar("<?=base_url()?>C_compromisos/", '#contenido');

                        } else {
                            alerta('Error al activar el periodo de revision', 'error');
                        }
                    }
                });
            } else {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url() ?>C_compromisos/actualizarperiodo", //Nombre del controlador
                    data: {
                        'iActivo': 0
                    },
                    success: function (resp) {
                        if (resp == 'correcto') {
                            listar_compromiso();
                            alerta('Periodo de revision desactivado', 'success');
                            cargar("<?=base_url()?>C_compromisos/", '#contenido');

                        } else {
                            alerta('Error al activar el periodo de revision', 'error');
                        }
                    }
                });

            }

        })
    });

    function cargarResponsables() {
        var valor = $("#eje").val();
        $.post("<?=base_url();?>C_compromisos/cargar_options/", {
            listado: 'responsables',
            valor: valor
        }, function (resultado, status) {

            $('#dependencia option[value!="0"]').remove();
            $('#dependencia').append(resultado);

        });
    }

    function buscar(e){
        e.preventDefault();
        $("#start").val(0);
        listar_compromiso_busqueda();
    }

    function agregar_compromiso() {
        //  Guardamos la página actual
        $("#start").val(table.page.info().start);
        $("#length").val(table.page.len());
        //-------------------------------
        cargar('<?= base_url() ?>C_compromisos/create', '#contenedor');
    }

    function listar_compromiso() {
        cargar('<?= base_url() ?>C_compromisos/listartablacompromiso', '#contenedor');
    }

    function listar_compromiso_busqueda() {

        cargar('<?= base_url() ?>C_compromisos/listartablacompromiso', '#contenedor', 'POST', $("#buscarCompromiso").serializeArray());
    }

   
    function eliminar_compromiso(id) {
        event.preventDefault();

         //  Guardamos la página actual
        $("#start").val(table.page.info().start);
        $("#length").val(table.page.len());
        //-------------------------------
        
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_compromisos/delete", //Nombre del controlador
            data: {
                'iIdCompromiso': id
            },
            success: function (resp) {
                if (resp == 'correcto') {
                    listar_compromiso();
                    alerta('Eliminado exitosamente', 'success');

                } else {
                    alerta('Error al eliminar', 'error');
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {

            }
        });
    }

    function esperar(id) {
        //document.getElementById("descarga").style.display = "none";
        if (id == 1) {
            Swal.fire({
                position: 'center',
                type: 'info',
                title: 'Espere un momento por favor...',
                showConfirmButton: false,
                timer: 600
            })
            esperar(0);
        } else {
            publicar_compromiso();
        }
    }

    function publicar_compromiso() {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_compromisos/PublicarCompromiso",


            success: function (resp) {
                if (resp == 'Correcto') {

                    alerta('Compromisos publicados correctamente', 'success');
                } else {
                    alerta('Error al publicar los compromisos', 'error');
                    //alert(resp);
                }
            },
            error: function (XMLHHttRequest, textStatus, errorThrown) {
            }
        });


    }

    function modificar_financiamiento(id) {
        //  Guardamos la página actual
        $("#start").val(table.page.info().start);
        $("#length").val(table.page.len());
        //-------------------------------
        cargar('<?= base_url() ?>C_compromisos/update', '#contenedor', 'POST', 'id=' + id);
    }

    function modificar_componentes(id) {
        //  Guardamos la página actual
        $("#start").val(table.page.info().start);
        $("#length").val(table.page.len());
        //-------------------------------
        cargar('<?= base_url() ?>C_compromisos_componentes/index', '#contenedor', 'POST', 'id=' + id);
    }
</script>


