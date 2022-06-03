<br><br>
<div class="card">
    <div class="card-body">
        <h1 class="card-title">Usuarios</h1>
        <h5 class="card-subtitle"> Administración del catálogo usuarios. </h5>
        <br><br>
        <form name="frmbusqueda" onsubmit="buscarUsuario(event);">
            <input type="hidden" id="start" value="0">
            <input type="hidden" id="length" value="10">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="validationCustom01">Rol</label>
                    <select class="custom-select" id="b_rol" name="b_rol">
                        <option value="">Seleccione...</option>
                        <?= $roles ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationTooltip02">Usuario/Nombre</label>
                    <input class="form-control" id="b_usuario" name="b_usuario" type="text" autofocus="autofocus" placeholder="Ingrese un texto">
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <div class="button-group">
                            <button type="submit" class="btn waves-effect waves-light btn-light" style="margin-top:35px">Buscar</button>
                            <button type="button" class="btn waves-effect waves-light btn-primary" style="margin-top:35px" onclick="agregar_usuario()">Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- alternative pagination -->
<div id="contenedor">
    <?php
    include_once('contenido_tabla.php');
    ?>
</div>

<script>
    var table;
    function agregar_usuario() {
        //  Guardamos la página actual
        $("#start").val(table.page.info().start);
        $("#length").val(table.page.len());
        //-------------------------------
        cargar('<?= base_url() ?>C_usuarios/create', '#contenedor');
    }

    function modificar_usuario(id) {
        //  Guardamos la página actual
        $("#start").val(table.page.info().start);
        $("#length").val(table.page.len());
        //-------------------------------
        cargar('<?= base_url() ?>C_usuarios/edit', '#contenedor', 'POST', 'id=' + id);
    }

    function modificar_password(id) {
        //  Guardamos la página actual
        $("#start").val(table.page.info().start);
        $("#length").val(table.page.len());
        //-------------------------------
        cargar('<?= base_url() ?>C_usuarios/editpassword', '#contenedor', 'POST', 'id=' + id);
    }
    function asignar_permisos(id){
        //  Guardamos la página actual
        $("#start").val(table.page.info().start);
        $("#length").val(table.page.len());
        //-------------------------------
        cargar('<?= base_url() ?>C_usuarios/editpermisos', '#contenedor', 'POST', 'id=' + id);
    }

    function find(e) {
        e.preventDefault();
        $("#start").val(0);
        buscarUsuario(e);
    }

    function buscarUsuario(e) {
        e.preventDefault();
        var rol = $("#b_rol").val();
        var usuario = $("#b_usuario").val();

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_usuarios/search",
            data: {
                'rol': rol,
                'usuario': usuario
            },
            //contentType: 'json',
            success: function(resp) {
                $("#contenedor").html(resp);
            },
            error: function(XMLHHttRequest, textStatus, errorThrown) {}
        });
    }
</script>