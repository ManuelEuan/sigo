<br><br>
<div class="card">
    <div class="card-body">
        <h1 class="card-title">Fuentes de financiamiento</h1>
        <h5 class="card-subtitle"> Administración del catálogo de fuentes de financiamiento. </h5>
        <br><br>
        <form onsubmit="buscarfinanciamiento(event);">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="validationCustom01">Año</label>
                    <input type="text" id="anio" class="form-control" placeholder="Ingresar año" autofocus="autofocus" onkeypress="solonumeros(event);" maxlength="4">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationTooltip02">Fuentes</label>
                    <input class="form-control" id="fuente" type="text" placeholder="Ingresar fuentes">
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <div class="button-group">
                            <button type="submit" class="btn waves-effect waves-light btn-light" style="margin-top:35px">Buscar</button>
                            <button type="button" class="btn waves-effect waves-light btn-primary" style="margin-top:35px" onclick="agregar_financiamiento()">Agregar</button>
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
    function agregar_financiamiento() {
        cargar('<?= base_url() ?>C_financiamientos/create', '#contenedor');
    }

    function modificar_financiamiento(id) {
        cargar('<?= base_url() ?>C_financiamientos/edit', '#contenedor', 'POST', 'id=' + id);
    }

    function buscarfinanciamiento(e) {
        var fuente = $("#fuente").val();
        var anio = $("#anio").val();

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_financiamientos/search",
            data: {
                'fuente': fuente,
                'anio': anio
            },
            //contentType: 'json',
            success: function(resp) {
                $("#contenedor").html(resp);
            },
            error: function(XMLHHttRequest, textStatus, errorThrown) {}
        });

        e.preventDefault();
    }

    function buscarfinanciamiento2() {
        var fuente = $("#fuente").val();
        var anio = $("#anio").val();

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_financiamientos/search",
            data: {
                'fuente': fuente,
                'anio': anio
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

    function solonumeros(e) {
        var key = window.event ? e.which : e.keyCode;
        console.log(key);
        if (key != 13 && (key < 48 || key > 57))
        e.preventDefault();
    }

    function EliminarFinanciamiento(id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_financiamientos/eliminar",
            data: {
                'id': id
            },
            //contentType: 'json',
            success: function(resp) {
                if (resp == true) {
                    buscarfinanciamiento2();
                    alerta('Eliminado exitosamente', 'success');
                } else {
                    alerta('Error al eliminar', 'error');
                }
            },
            error: function(XMLHHttRequest, textStatus, errorThrown) {

            }
        });
    }
</script>