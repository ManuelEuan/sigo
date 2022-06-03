<div id="">
    <br><br>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-body">
                <h1 class="card-title">Unidades de Medida</h1>
                <h5 class="card-subtitle"> Administración del catálogo de Unidades de Medida. </h5>
                <div class="form-body">
                    <div class="card-body">
                        <div class="row p-t-20">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="control-label">Buscar por palabra clave</label>
                                    <input type="text" id="clave" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="button" class="btn waves-effect waves-light btn-light" style="margin-top:35px" onclick="filter()">Buscar</button>
                                    <button type="button" class="btn waves-effect waves-light btn-primary" style="margin-top:35px" onclick="capturarUM()">Agregar</button>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <!--/row-->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="contenido_modulo" class="content">
        <?php include_once('vTabla.php') ?>
    </div>

    <script>
        function capturarUM() {
            cargar('<?= base_url() ?>C_unidadesmedida/cargar', '#contenido_modulo');
        }

        function modificarUM(id) {
            cargar('<?= base_url() ?>C_unidadesmedida/edit', '#contenido_modulo', 'POST', 'id=' + id);
        }

        function regresar() {
            cargar('<?= base_url() ?>C_unidadesmedida/regresar', '#contenido_modulo');
        }

        function filter() {
            var keyword = $("#clave").val();

            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>C_unidadesmedida/gettable",
                data: {
                    'keyword': keyword
                },
                //contentType: 'json',
                success: function(resp) {
                    $("#contenido_modulo").html(resp);
                },
                error: function(XMLHHttRequest, textStatus, errorThrown) {}
            });
        }

        function filter2() {
            var keyword = $("#clave").val();

            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>C_unidadesmedida/gettable",
                data: {
                    'keyword': keyword
                },
                //contentType: 'json',
                success: function(resp) {
                    $("#contenido_modulo").html(resp);
                    $('#grid').DataTable({
                        stateSave: true,
                    });
                    //$("#grid").dataTable().fnReloadAjax();
                },
                error: function(XMLHHttRequest, textStatus, errorThrown) {}
            });
        }
    </script>