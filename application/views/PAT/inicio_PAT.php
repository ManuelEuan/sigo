<div id="contenidoPAT">
    <br><br>

    <div class="row" id="divbusqueda">
        <div class="col-md-12">
            <div class="card card-body">
                <h1 class="card-title">Programa Operativo Anual</h1>
                <hr class="m-t-0">
                <div class="form-body">
                    <div class="card-body">
                        <h4 class="card-title">Filtrar por:</h4>
                        <form class="r-separator" name="frmbusqueda" id="frmbusqueda" onsubmit="search(event);">
                            <input type="hidden" id="start" value="0">
                            <input type="hidden" id="length" value="10">
                            <div class="row">
                                <?php 
                                if(isset($ejes))
                                {
                                    echo '<div class="col">
                                        <div class="form-group">
                                            <label class="control-label">Eje Rector</label>
                                            <select type="text" name="search_eje" id="search_eje" class="form-control" onChange="cargarOptions(\'dependencias\',this);" >
                                                <option value="0">--Todos--</option>'.$ejes.'
                                            </select>
                                        </div>
                                    </div>';
                                }
                                else 
                                {
                                    echo '<input type="hidden" name="search_eje" id="search_eje" value="'.$_SESSION[PREFIJO.'_ideje'].'" >';
                                } 

                                if(isset($dependencias))
                                {
                                    echo '<div class="col">
                                        <div class="form-group">
                                            <label class="control-label">Dependencia responsable</label>
                                            <select type="text" name="search_dependencia" id="search_dependencia" class="form-control" onChange="search(event);" >
                                                <option value="0">--Todos--</option>'.$dependencias.'
                                            </select>
                                        </div>
                                    </div>';
                                } 
                                else 
                                {
                                    echo '<input type="hidden" name="search_dependencia" id="search_dependencia" value="'.$_SESSION[PREFIJO.'_iddependencia'].'" >';
                                }
                                ?>
                                <div class="col">
                                    <div class="form-group">
                                    <!-- <label class="control-label">COVID</label>-->
                                        <input type="hidden" class="form-control " maxlength="255" id="covid" name="covid" value="">
                                        <!--<select class="form-control" name="covid" id="covid">
                                            <option value="">--Todas--</option>
                                            <option value="1">Covid</option>
                                            <option value="0">Sin covid</option>
                                        </select>-->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="custom-control custom-checkbox mr-sm-2 m-b-15" style="margin-top:24px;">
                                        <!--<input type="checkbox" class="custom-control-input" name="newAvances" id="newAvances" value="1">-->

                                        <input type="hidden" class="form-control input-lectura" maxlength="255" id="newAvances" name="newAvances" value="1">

                                    <!--  <label class="custom-control-label" for="newAvances">Actividades con <br>avances por revisar</label>-->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <div class="form-group">
                                        <label class="control-label">Año</label>
                                        <input type="text" name="anio" id="anio" class="form-control form-control-danger" placeholder="" value="<?=$year?>" onkeypress="solonumeros(event);" maxlength="4">
                                    </div>
                                </div>
                                <div class="col-2">
                                <div class="form-group">
                                        <label class="control-label">Mes</label>
                                        <select class="form-control" name="mes" id="mes">
                                            <option value="0">--Todos--</option>
                                            <option value="1">Enero</option>
                                            <option value="2">Febrero</option>
                                            <option value="3">Marzo</option>
                                            <option value="4">Abril</option>
                                            <option value="5">Mayo</option>
                                            <option value="6">Junio</option>
                                            <option value="7">Julio</option>
                                            <option value="8">Agosto</option>
                                            <option value="9">Septiembre</option>
                                            <option value="10">Octubre</option>
                                            <option value="11">Noviembre</option>
                                            <option value="12">Diciembre</option>
                                        </select>
                                    </div>
                            </div>
                                <div class="col-7">
                                    <div class="form-group">
                                        <label class="control-label">Nombre de la acción</label>
                                        <!--<input type="text" name="keyword" id="keyword" class="form-control" placeholder="">-->
                                        <div class="input-group mb-3">
                                            <input type="text" name="keyword" id="keyword" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-info" type="button"><i class="fas fa-search"></i>&nbsp;Buscar</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <!--<button type="submit" class="btn waves-effect waves-light btn-light" style="margin-top:30px" id="btn_buscar">Buscar</button>-->
                                        <?php if($acceso > 1) { ?>
                                        <button type="button" class="btn waves-effect waves-light btn-primary" style="margin-top:30px" onclick="agregarAct();">+ Nueva</button>
                                        <?php } 
                                        if($p_clonar > 0){ ?>
                                            <button type="button" class="btn btn-warning" data-toggle="modal" style="margin-top:30px" data-target="#clonarModal" data-whatever="@getbootstrap"><i class="far fa-copy"></i>&nbsp;Clonar</button>
                                        <?php } ?>
                                        <?php if(isset($ejes) && isset($dependencias)) { ?>
                                        <button type="button" class="btn waves-effect waves-light btn-outline-info" style="margin-top:30px" onclick="updatePOAS();">
                                            <i class="fa-solid fa-arrows-rotate"></i>&nbsp;Sincronizar con Picaso
                                        </button>
                                        <button type="button" class="btn waves-effect waves-light btn-outline-info" style="margin-top:30px" onclick="actualizarNuevos();">
                                            <i class="fa-solid fa-arrows-rotate"></i>&nbsp;Alineación con Picaso 
                                        </button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="contenido_modulo" class="content">
        <?php include_once('pat_list.php') ?>
    </div>
</div>

<div id="contenidoEnt" class="content">
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="needs-validation was-validated" onsubmit="guardarAct(this,event);">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nueva actividad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-9 mb-6">
                            <label for="validationCustom04">Nombre de la acción</label>
                            <input class="form-control" id="validationCustom04" name="NombAct" required="" type="text" placeholder="">
                            <div class="invalid-feedback">
                                Este campo no puede estar vacio.
                            </div>
                            <input class="form-control" name="idAct" type="hidden" value="">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="validationCustom04">Año</label>
                            <input class="form-control input-number" id="validationCustom05" name="annio" required="" type="text" maxlength="4">
                            <div class="invalid-feedback">
                                Este campo no puede estar vacio.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal form "Clonar" -->
<div class="modal fade" id="clonarModal" tabindex="-1" role="dialog" aria-labelledby="clonarModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Clonar acción</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form onsubmit="clonar(this,event);" class="needs-validation was-validated">
            <div class="modal-body">
                
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Eje:<b class="text-danger">*</b></label>
                        <select name="clonar-eje" id="clonar-eje" class="form-control" onChange="cargarOptions('c_dependencias',this);" required="required" >
                            <option value="">--Seleccione--</option>
                            <?=$ejes?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Dependencia:<b class="text-danger">*</b></label>
                        <select name="clonar-dep" id="clonar-dep" class="form-control" required="required">
                            <option value="">--Seleccione--</option>
                            <?=$dependencias?>
                        </select>
                    </div>
                    <div class="form-group row">
                        <div class="col-5">
                            <label for="message-text" class="control-label">Año origen:<b class="text-danger">*</b></label>
                            <input class="form-control" maxlength="4"  name="anio-origen" id="anio-origen" onKeyPress="solonumeros(event)" required="required">
                        </div>
                        <div class="col-2 text-center">
                            <br>
                            <br>
                            <i class="mdi mdi-arrow-right-bold"></i>
                        </div>
                        <div class="col-5">
                            <label for="message-text" class="control-label">Año destino:<b class="text-danger">*</b></label>
                            <input class="form-control" maxlength="4" onKeyPress="solonumeros(event)" name="anio-destino" id="anio-destino" required="required" value="<?php echo date('Y'); ?>">
                        </div>
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-default"><b>Clonar</b></button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal form "Clonar actividad" -->
<div class="modal fade" id="clonarActModal" tabindex="-1" role="dialog" aria-labelledby="clonarActModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Clonar acción</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form onsubmit="clonarAct(this,event);" class="needs-validation was-validated">
            <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-5">
                            <label for="message-text" class="control-label">Año destino:<b class="text-danger">*</b></label>
                            <input class="form-control" maxlength="4" onKeyPress="solonumeros(event)" name="anioDestino" id="anioDestino" required="required" value="<?php echo date('Y'); ?>">
                            <input type="hidden" name="idActClone" id="idActClone" value="">
                        </div>
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-default"><b>Clonar</b></button>
            </div>
            </form>
        </div>
    </div>
</div>
<script src="<?= base_url() ?>public/assets/extra-libs/knob/jquery.knob.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script type="text/javascript">
    var table;
    var order = [2,"ASC"];
    function solonumeros(e) {
        var key = window.event ? e.which : e.keyCode;
        if ((key < 48 && key != 13) || (key > 57 && key != 13))
        e.preventDefault();
    }

    src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"
    $('.input-number').on('input', function () { 
        this.value = this.value.replace(/[^0-9]/g,'');
    });

    function openModalCloneAct(idAct){
        $("#clonarActModal").modal();
        $("#idActClone").val(idAct);
    }

    function capturarAct() {
        debugger;
        //  Guardamos la página actual
        $("#start").val(table.page.info().start);
        $("#length").val(table.page.len());
        order = table.order();
        //-------------------------------
        cargar('<?= base_url() ?>C_pat/cargar', '#contenido_modulo');
    }

    function abrirEntregables(id) {
        //  Guardamos la página actual
        $("#start").val(table.page.info().start);
        $("#length").val(table.page.len());
        order = table.order();
        //-------------------------------
        cargar('<?= base_url() ?>index.php/C_entregables/', '#contenido_modulo', 'POST', 'id=' + id);
    }

    function abrirCapturaTxt(id) {
        //  Guardamos la página actual
        $("#start").val(table.page.info().start);
        $("#length").val(table.page.len());
        order = table.order();
        //-------------------------------
        cargar('<?= base_url() ?>C_pat/abrirCapTxt', '#contenido_modulo', 'POST', 'id=' + id);
    }

    function FichaActividad(iIdDetalleActividad) {
        
        window.open("<?= base_url() ?>C_pat/ShowFichaActividad/"+iIdDetalleActividad,"_blank");
    }

    function agregarAct() {
        //  Guardamos la página actual
        $("#start").val(table.page.info().start);
        $("#length").val(table.page.len());
        order = table.order();
        //-------------------------------
        cargar('<?= base_url() ?>C_pat/add', '#contenido_modulo', 'POST');
    }

    function modificarAct(id) {
        //  Guardamos la página actual
        $("#start").val(table.page.info().start);
        $("#length").val(table.page.len());
        order = table.order();
        //-------------------------------
        cargar('<?= base_url() ?>C_pat/edit', '#contenido_modulo', 'POST', 'id=' + id);
    }

    function guardarAct(f, e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_pat/insertarAct",
            data: $(f).serialize(),

            success: function(resp) {
                if (resp > 0) {
                   //filtrar();
                    alerta('Guardado exitosamente', 'success');
                    $("#validationCustom04").val(null);
                    $("#validationCustom05").val(null);
                    setTimeout(function(){
                        back();
                    }, 3000);
                } else {
                    alerta('Error al guardar', 'error');
                }
            },
            error: function(XMLHHttRequest, textStatus, errorThrown) {}
        });
    }

    function cargarOptions(listado,elemento){
        var valor = $("#"+elemento.id).val();

        $.post("<?=base_url();?>C_pat/cargar_options/",{listado:listado,valor:valor},function(resultado,status){
        
            if(listado == 'dependencias'){                
                $('#search_dependencia option[value!="0"]').remove();
                $('#search_dependencia').append(resultado);
                $("#start").val(0);
                back();
            }

            if(listado == 'c_dependencias'){
                $('#clonar-dep option[value!=""]').remove();
                $('#clonar-dep').append(resultado);   
            }

            if(listado == 'dependencias_act'){
                $('#depAct option[value!="0"]').remove();
                $('#depAct').append(resultado);
            }

            if(listado == 'retos'){
                $('#iReto option[value!="0"]').remove();
                $('#iReto').append(resultado);
                createSelectPOA();
            }
        });
    }

    function clonar(f,e){
        e.preventDefault();
        var anioOrigen = parseInt($("#anio-origen").val());
        var anioDestino = parseInt($("#anio-destino").val());
        
        if(anioDestino > anioOrigen){
            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>C_pat/clonar",
                data: $(f).serialize(),
                beforeSend: function () {
                    Swal.fire({
                      position: 'center',
                      type: 'info',
                      title: 'Estamos trabajando en ello, espere por favor',
                      showConfirmButton: false,
                      allowOutsideClick: false
                    })
                },
                success: function(resp) {
                    resp = JSON.parse(resp);
                    Swal.close();
                    if(resp.error == false){
                        alerta(resp.mensaje,'success');
                    } else {
                        alerta(resp.mensaje,'error');
                    }
                },
                error: function(XMLHHttRequest, textStatus, errorThrown) {}
            });
        } else {
            alerta('El año de origen debe ser menor al año de destino','error');
        }
    }

    function clonarAct(f,e){
        e.preventDefault();
        
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_pat/clonar_actividad",
            data: $(f).serialize(),
            beforeSend: function () {
                Swal.fire({
                  position: 'center',
                  type: 'info',
                  title: 'Estamos trabajando en ello, espere por favor',
                  showConfirmButton: false,
                  allowOutsideClick: false
                })
            },
            success: function(resp) {
                resp = JSON.parse(resp);
                Swal.close();
                if(resp.error == false){
                    alerta(resp.mensaje,'success');
                } else {
                    alerta(resp.mensaje,'error');
                }
            },
            error: function(XMLHHttRequest, textStatus, errorThrown) {}
        });
        
    }

    function eliminarActividad(key) {
        //  Guardamos la página actual
        $("#start").val(table.page.info().start);
        $("#length").val(table.page.len());
        //-------------------------------

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_pat/eliminarActividad",
            data: {
                'key': key
            },
            //contentType: 'json',
            success: function(resp) {
                if (resp == true) {
                    back();
                    alerta('Eliminado exitosamente', 'success');
                } else {
                    alerta('Error al eliminar', 'error');
                }
            },
            error: function(XMLHHttRequest, textStatus, errorThrown) {

            }
        });
    }


    function percentageToDegrees(percentage) {
        return percentage / 100 * 360
    }

    function search(e){
        e.preventDefault();
        $("#start").val(0);
        cargar('<?=base_url()?>C_pat/new_search', '#contenido_modulo', 'POST');
    }

    function searchPats(){
        table = $('#grid').DataTable({
            "searching": false,
            "processing": true,
            "serverSide": true,
            "displayStart":parseInt($('#start').val()),
            "pageLength": parseInt($('#length').val()),
            "order":order,
            "ajax": {
                "url": "<?=base_url();?>C_pat/search_pats",
                "type": "POST",
                "data": {
                    "eje": $("#search_eje").val(),
                    "dep": $("#search_dependencia").val(),
                    "covid": $("#covid").val(),
                    "mes": $("#mes").val(),
                    "anio": $("#anio").val(),
                    "keyword": $("#keyword").val(),
                    "newAvances": ($("#newAvances").is(':checked')) ? 1:0
                }
            },
            "drawCallback": function() {
                $(".dial").knob();
                $(".progress-c").each(function(){
                    var value = $(this).attr('data-value');
                    var left = $(this).find('.progress-c-left .progress-c-bar');
                    var right = $(this).find('.progress-c-right .progress-c-bar');

                    if (value > 0) {
                        if (value <= 50) {
                            right.css('transform', 'rotate(' + percentageToDegrees(value) + 'deg)')
                        } else {
                            right.css('transform', 'rotate(180deg)')
                            left.css('transform', 'rotate(' + percentageToDegrees(value - 50) + 'deg)')
                        }
                    }
                });
            }
        });
    }


    function back(){
        cargar('<?=base_url()?>C_pat/new_search', '#contenido_modulo', 'POST');
    }

    /**
     * Ingresa el monto del proyecto segun el POA seleccionada
     */
    function setMontoPOA(event){
        let numeroProyecto = $('select[id=catPoas]').val();
        proyectos.forEach(element => {
            if(element.numeroProyecto == numeroProyecto){
                $('#nPresupuestoAutorizado').val(element.aprobado);
            }
        });
    }

    /**
     * Remplaza los acentos para asi realizar la busqueda de lo retorna el sistema de finanzas
     * input: string str
     * ouput: string 
     */
    const removeAccents = (str) => {
        return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    }

    /**
     * Actualiza los montos del detalle de Actividad en base a los montos de Picazo
     * 
     */
    function updatePOAS(){
        console.log("entro");
        $.ajax({
            type: "GET",
            url: "<?= base_url() ?>C_pat/updateMontoActividades",
            success: function(resp) {
                console.log("entro");
                console.log(resp);
                console.log("salgo");
            },
            error: function(XMLHHttRequest, textStatus, errorThrown) {
                console.log(XMLHHttRequest);
            }
        });
    }

    /**
     * Actualizar los proyectos nuevos y que no se han asignado
     * 
     */
    function actualizarNuevos(){
        console.log('Se va a actualizar')
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_pat/actualizarProyectosNuevos",
            success: function (response) {
                console.log('Respuesta: ' + response )
                alerta(response, 'success');
            }
        });
    }
</script>