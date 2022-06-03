<br><br>
<div class="card">
    <div class="card-body">
        <h1 class="card-title">Registro call center</h1>
        <br><br>
        <form onsubmit="buscar(event);">
            <input type="hidden" id="start" value="0">
            <input type="hidden" id="length" value="10">
            <div class="row">
                <div class="col-8 mb-3">
                    <label for="validationTooltip02">Buscar por nombre o problema</label>
                    <input class="form-control" name="keyword" id="keyword" type="text" placeholder="Ingrese el texto a buscar">
                </div>
                <div class="col-sm-4 col-md-3">
                    <div class="form-group">
                        <div class="button-group">
                            <button type="submit" class="btn waves-effect waves-light btn-light" style="margin-top:30px"><b class="mdi mdi-search"></b>Buscar</button>
                            <button type="button" class="btn waves-effect waves-light btn-primary" style="margin-top:30px" onclick="capturar(0)"><b class="mdi mdi-plus"></b>Agregar</button>
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
    var tabla;
    function capturar(id) {
        //  Guardamos la página actual
        $("#start").val(tabla.page.info().start);
        $("#length").val(tabla.page.len());
        //-------------------------------
        cargar('<?= base_url() ?>C_registro_cc/capturar', '#contenedor', 'POST', 'id=' + id);
    }

    function buscar(e) {
        e.preventDefault();
        $("#start").val(0);
        regresar(e);
    }

    function regresar(e) {
        var keyword = $("#keyword").val();
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_registro_cc/buscar",
            data: {
                'keyword': keyword
            },
            //contentType: 'json',
            success: function(resp) {
                $("#contenedor").html(resp);
            },
            error: function(XMLHHttRequest, textStatus, errorThrown) {}
        });

        e.preventDefault();
    }


    function solonumeros(e) {
        var key = window.event ? e.which : e.keyCode;
        console.log(key);
        if (key != 13 && (key < 48 || key > 57))
        e.preventDefault();
    }

    function eliminar(id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_registro_cc/eliminar",
            data: {
                'id': id
            },
            //contentType: 'json',
            success: function(resp) {
                if (resp == '0') {                    
                    alerta('El registro ha sido eliminado', 'success');
                } else {
                    alerta(resp, 'error');
                }
            },
            error: function(XMLHHttRequest, textStatus, errorThrown) {

            }
        });
    }
</script>