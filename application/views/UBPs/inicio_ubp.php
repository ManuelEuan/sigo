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
                <h1 class="card-title">POA's</h1>
                <h5 class="card-subtitle"> Administración del catálogo de Programas Operativos Anuales (POA). </h5>
                <div class="form-body">
                    <form id="frmbusqueda" name="frmbusqueda" onsubmit="filter(event);">
                    <div class="card-body">
                        <div class="row p-t-20">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="control-label">Buscar por palabra clave</label>
                                    <input type="text" id="clave" class="form-control" placeholder="">
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Año</label>
                                    <input type="text" id="anio" class="form-control form-control-danger" placeholder="" onkeypress="solonumeros(event);" maxlength="4">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="submmit" class="btn waves-effect waves-light btn-light" style="margin-top:35px" id="btn_buscar">Buscar</button>
                                    <button type="button" class="btn waves-effect waves-light btn-primary" style="margin-top:35px" onclick="capturarUBP()">Agregar</button>
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
        function capturarUBP() {
            cargar('<?= base_url() ?>C_ubps/agregar', '#contenido_modulo');
        }

        function modificarUBP(id) {
            cargar('<?= base_url() ?>C_ubps/edit', '#contenido_modulo', 'POST', 'id=' + id);
        }

        function regresar() {
            cargar('<?= base_url() ?>C_ubps/regresar', '#contenido_modulo');
        }

        function filter(e) {
            var keyword = $("#clave").val();
            var year = $("#anio").val();

            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>C_ubps/gettable",
                data: {
                    'keyword': keyword,
                    'year': year
                },
                //contentType: 'json',
                success: function(resp) {
                    $("#contenido_modulo").html(resp);
                },
                error: function(XMLHHttRequest, textStatus, errorThrown) {}
            });

            e.preventDefault();
        }

        function filter2() {
            var keyword = $("#clave").val();
            var year = $("#anio").val();

            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>C_ubps/gettable",
                data: {
                    'keyword': keyword,
                    'year': year
                },
                //contentType: 'json',
                success: function(resp) {
                    $("#contenido_modulo").html(resp);
                    $('#grid').DataTable({
                        stateSave: true,
                    });
                },
                error: function(XMLHHttRequest, textStatus, errorThrown) {}
            });
        }

        function solonumeros(e) {
            var key = window.event ? e.which : e.keyCode;
            if (key < 48 || key > 57)
                e.preventDefault();
        }
    </script>