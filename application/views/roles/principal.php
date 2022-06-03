<br><br>
<div class="card">
    <div class="card-body">
        <h1 class="card-title">Roles</h1>
        <h5 class="card-subtitle"> Administración del catálogo roles. </h5>
        <br><br>
        <form onsubmit="buscarRol(event);">
        <div class="row">
            <div class="col-md-9 col-sm-3">
                <label for="validationCustom01">Rol</label>
                <input type="text" name="b_rol" id="b_rol" value="" autofocus="autofocus" class="form-control">
            </div>
            <div class="col-sm-12 col-md-3">
                <div class="form-group">
                    <div class="button-group">
                        <button type="submit" class="btn waves-effect waves-light btn-light" style="margin-top:30px">Buscar</button>
                        <button type="button" class="btn waves-effect waves-light btn-primary" style="margin-top:30px" onclick="agregar_rol()">Agregar</button>
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
    function agregar_rol() {
        cargar('<?= base_url() ?>C_roles/create', '#contenedor');
    }

    function modificar_rol(id) {
        cargar('<?= base_url() ?>C_roles/edit', '#contenedor', 'POST', 'id=' + id);
    }

    function asignar_permisos(id){
        cargar('<?= base_url() ?>C_roles/editpermisos', '#contenedor', 'POST', 'id=' + id);
    }

    function buscarRol(e) {
        e.preventDefault();
        var rol = $("#b_rol").val();

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_roles/search",
            data: {
                'rol': rol,
            },
            //contentType: 'json',
            success: function(resp) {
                $("#contenedor").html(resp);
            },
            error: function(XMLHHttRequest, textStatus, errorThrown) {}
        });
    }

    function regresar() {
        var rol = $("#b_rol").val();

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_roles/search",
            data: {
                'rol': rol,
            },
            //contentType: 'json',
            success: function(resp) {
                $("#contenedor").html(resp);
                $('#grid').DataTable({
                    stateSave: true,
                });
            },
            error: function(XMLHHttRequest, textStatus, errorThrown) {}
        });
    }

</script>