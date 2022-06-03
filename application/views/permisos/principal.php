<br><br>
<div class="card">
    <div class="card-body">
        <h1 class="card-title">Permisos</h1>
        <h5 class="card-subtitle"> Administración del catálogo de permisos. </h5>
        <br><br>
       
        <input type="hidden" id="start" value="0">
        <input type="hidden" id="length" value="10">
        <div class="col text-right">
            <button class="btn btn-primary" type="button" onclick="capturar(0);">Agregar +</button>
        </div>
   
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
    function capturar(id) {
        //  Guardamos la página actual
        $("#start").val(table.page.info().start);
        $("#length").val(table.page.len());
        //-------------------------------
        cargar('<?= base_url() ?>C_admin/capturar_permiso', '#contenedor', 'POST', 'id=' + id);
    }
    

    function find(e) {
        e.preventDefault();
        $("#start").val(0);
        verListado(e);
    }

    function verListado(e) {
        e.preventDefault();
        
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_admin/search_permisos",
            data: '',
            success: function(resp) {
                $("#contenedor").html(resp);
            },
            error: function(XMLHHttRequest, textStatus, errorThrown) {}
        });
    }
</script>