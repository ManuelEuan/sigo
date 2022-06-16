<br><br>

<div class="card">

    <div class="card-body">

        <h4 class="card-title">Ejes</h4>
         <form id="frmbusqueda" onsubmit="">
             <div class="row">
                 <div class="col-md-8 mb-3">
                     <div class="row">
                        <div class="col-md-2 mb-3" style="text-align: -webkit-right;">
                        <input type="hidden" name="start" id="start" value="0">
                        <input type="hidden" name="length" id="length" value="10">
                            <label for="">Buscar:</label>
                        </div>
                        
                        <div class="col-md-10 mb-3">
                            <input class="form-control" id="key" autofocus="autofocus" name="key" type="text" placeholder="">
                        </div>
                        
                     </div>
                 </div>
                 <div class="col-md-4 mb-3">
                    <button type="submit" class="btn waves-effect waves-light btn-light">Buscar</button>
                    <button type="button" class="btn waves-effect waves-light btn-primary" onclick="agregarEje()">Agregar</button>
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

    function agregarEje() {
        console.log('Estas clickando crear eje')
        cargar('<?= base_url() ?>C_eje/add', '#contenedor');
    }

 </script>