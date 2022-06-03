 <br><br>
 <div class="card">
     <div class="card-body">
         <h4 class="card-title">Buscar por:</h4>
         <form id="frmbusqueda" onsubmit="buscar(event);">
             <div class="row">
                 <div class="col-md-4 mb-3">
                    <input type="hidden" name="start" id="start" value="0">
                    <input type="hidden" name="length" id="length" value="10">
                    <label for="validationCustom01">Eje</label>
                    <select name="seleje" id="seleje" class="form-control">
                        <option value="0">--Todos--</option>
                        <?=$options_eje?>
                    </select> 
                 </div>
                 <div class="col-md-4 mb-3">
                     <label for="validationTooltip02">Nombre</label>
                     <input class="form-control" id="key" autofocus="autofocus" name="key" type="text" placeholder="">
                 </div>
                 <div class="col-sm-12 col-md-3">
                     <div class="form-group">
                         <div class="button-group">
                             <button type="submit" class="btn waves-effect waves-light btn-light" style="margin-top:30px" >Buscar</button>
                             <button type="button" class="btn waves-effect waves-light btn-primary" style="margin-top:30px" onclick="agregar_dependencia()">Agregar</button>
                         </div>
                     </div>
                 </div>
             </div>
         </form>
     </div>
 </div>
 <div id="contenedor">
    <?php
    include_once('contenido_tabla.php');
    ?>
 </div>

 <script>
    var table;
    function buscar(e){
        $("#start").val(0);
        filtrar(e);
    }

    function filtrar(e){
        e.preventDefault();
        var data = $("#frmbusqueda").serialize();
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_dependencias/buscar",
            data: data,
            success: function(resp) {
                $("#contenedor").html(resp);
            },
            error: function(XMLHHttRequest, textStatus, errorThrown) {

            }
        });
    }

    function agregar_dependencia() {
         //  Guardamos la página actual
        $("#start").val(table.page.info().start);
        $("#length").val(table.page.len());
        //-------------------------------

        cargar('<?= base_url() ?>C_dependencias/create', '#contenedor');
    }

    function modificar_dependencia(id) {
         //  Guardamos la página actual
        $("#start").val(table.page.info().start);
        $("#length").val(table.page.len());
        //-------------------------------
        cargar('<?= base_url() ?>C_dependencias/edit', '#contenedor','POST','id='+id);
    }
</script>