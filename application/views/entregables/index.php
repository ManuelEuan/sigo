<br><br>
<div class="card">
    <div class="card-body">
        <h1 class="card-title">Entregables</h1>
        <h5 class="card-subtitle"> Administración del catálogo entregables. </h5>
        <br><br>
        <form name="frmbusqueda" id="frmbusqueda" onsubmit="buscar(event);">
            <input type="hidden" id="start" value="0">
            <input type="hidden" id="length" value="10">
            <div class="row">
                <?php 
                if(isset($ejes))
                {
                    echo '<div class="col">
                        <div class="form-group">
                            <label class="control-label">Eje Rector</label>
                            <select type="text" name="eje" id="eje" class="form-control" onChange="cargarOptions(\'dependencias\',this);" >
                                <option value="0">--Todos--</option>'.$ejes.'
                            </select>
                        </div>
                    </div>';
                }
                else 
                {
                    echo '<input type="hidden" name="eje" id="eje" value="'.$_SESSION[PREFIJO.'_ideje'].'" >';
                } 

                if(isset($dependencias))
                {
                    echo '<div class="col">
                        <div class="form-group">
                            <label class="control-label">Dependencia responsable</label>
                            <select type="text" name="dep" id="dep" class="form-control" >
                                <option value="0">--Todos--</option>'.$dependencias.'
                            </select>
                        </div>
                    </div>';
                } 
                else 
                {
                    echo '<input type="hidden" name="dep" id="dep" value="'.$_SESSION[PREFIJO.'_iddependencia'].'" >';
                }
                ?>
                <div class="col">
                    <div class="form-group">
                        <label class="control-label">Año</label>
                        <input type="text" name="anio" id="anio" class="form-control form-control-danger" placeholder="" value="<?=$year;?>" onkeypress="solonumeros(event);" maxlength="4">
                    </div>
                </div>
                <div class="col">
                    <div class="custom-control custom-checkbox mr-sm-2 m-b-15" style="margin-top:30px;">
                        <input type="checkbox" class="custom-control-input" id="anexo" name="anexo" value="1">
                        <label class="custom-control-label" for="anexo">Mostrar entregables del anexo</label>
                    </div>
                </div>
            </div>
             <div class="row">
                <div class="col-10">
                    <div class="form-group">
                        <label class="control-label">Nombre del indicador</label>
                        <!--<input type="text" name="keyword" id="keyword" class="form-control" placeholder="">-->
                        <div class="input-group mb-3">
                            <input type="text" name="keyword" id="keyword" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-info" type="button"><i class="fas fa-search"></i>&nbsp;Buscar</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <?php if($acceso > 1) { ?>
                        <!--<button type="button" class="btn waves-effect waves-light btn-primary" data-toggle="modal" style="margin-top:30px" data-target="#exampleModal">+ Nuevo</button>-->
                    <?php } ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="contenedor">
    <?=$tabla;?>
</div>

<script>
    var table;

    function initDataTable(){
        if($("#grid").length > 0){
            table = $('#grid').DataTable({
                "displayStart":parseInt($('#start').val()),
                "pageLength": parseInt($('#length').val()),
                "order": [[ 0, "asc" ]]
            });
        }
    }

    function modificar(id) {
        //  Guardamos la página actual
        $("#start").val(table.page.info().start);
        $("#length").val(table.page.len());
        //-------------------------------
        cargar('<?= base_url() ?>C_entregables/modificar_entregable', '#contenedor', 'POST', 'id=' + id);
    }

      
    function find(e) {
        e.preventDefault();
        $("#start").val(0);
        buscar(e);
    }

    function buscar(e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_entregables/buscar_entregable",
            data: $("#frmbusqueda").serialize(),
            success: function(resp) {
                $("#contenedor").html(resp);
            },
            error: function(XMLHHttRequest, textStatus, errorThrown) {}
        });
    }
</script>