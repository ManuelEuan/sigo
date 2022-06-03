<style>
    .boton {
        width: 35px;
        height: 40px;
        padding: 10px 0 0 0;
        color: white;
    }
</style>
<div id="">
    <br><br>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-body">
                <h1 class="card-title">PPs</h1>
                <h5 class="card-subtitle"> Administración del catálogo de Programas Presupuestarios (PPs). </h5>
                <div class="form-body">
                    <form id="frmbusqueda" name="frmbusqueda" onsubmit="find(event);">
                    <div class="card-body">
                        <div class="row p-t-20">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="control-label">Buscar por palabra clave</label>
                                    <input type="text" name="key" id="key" class="form-control" placeholder="">
                                    <input type="hidden" name="start" id="start" value="0">
                                    <input type="hidden" name="length" id="length" value="10">
                                </div>
                            </div>                           
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="submmit" class="btn waves-effect waves-light btn-light" style="margin-top:30px" id="btn_buscar">Buscar</button>
                                    <button type="button" class="btn waves-effect waves-light btn-primary" style="margin-top:30px" onclick="capturar(0)">+ Agregar</button>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div id="contenido_modulo" class="content">
        <?php include_once('vTabla.php') ?>
    </div>

    <script>
        var tabla;

        function capturar(id) {
            //  Guardamos la página actual
            $("#start").val(tabla.page.info().start);
            $("#length").val(tabla.page.len());
            //-------------------------------
            cargar('<?= base_url() ?>C_pps/capturar', '#contenido_modulo','POST','id='+id);
        }        

        function find(e)
        {
            $("#start").val(0);
            filter(e);
        }

        function filter(e) {
            e = e || window.event;

            var keyword = $("#key").val();

            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>C_pps/buscar",
                data: {
                    'keyword': keyword
                },
                success: function(resp) {
                    $("#contenido_modulo").html(resp);
                },
                error: function(XMLHHttRequest, textStatus, errorThrown) {}
            });

            e.preventDefault();
        }

        function eliminar(key) {
            //  Guardamos la página actual
            $("#start").val(tabla.page.info().start);
            $("#length").val(tabla.page.len());
            //-------------------------------
            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>C_pps/eliminar",
                data: {
                    'key': key
                },
                success: function(resp) {
                    resp = JSON.parse(resp);

                    if (resp == true) {                
                        alerta('El registro ha sido eliminado', 'success');
                        filter();
                    } else {
                        alerta('Error al eliminar', 'error');
                    }
                },
                error: function(XMLHHttRequest, textStatus, errorThrown) {

                }
            });
        }

        function solonumeros(e) {
            var key = window.event ? e.which : e.keyCode;
            if (key < 48 || key > 57)
                e.preventDefault();
        }
    </script>