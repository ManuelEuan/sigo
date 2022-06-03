<div id="contenido_modulo" class="">
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div align="right">
                <button title="Ir al listado de PPs" type="button" class="btn waves-effect waves-light btn-outline-info" onclick="filter(event)"><i class="mdi mdi-arrow-left"></i>Regresar</button>
            </div>
            <form class="needs-validation was-validated" onsubmit="guardar(this,event);">
                <?php if($iIdProgramaPresupuestario > 0){ ?>
                <div class="form-row">
                    <div class="col-md-2">
                        <label>ID</label>      
                        <input type="text" id="iIdProgramaPresupuestario" name="iIdProgramaPresupuestario" value="<?=$iIdProgramaPresupuestario;?>" readonly>
                    </div>
                </div>
                <?php } else { ?>
                <input type="hidden" id="iIdProgramaPresupuestario" name="iIdProgramaPresupuestario" value="<?=$iIdProgramaPresupuestario;?>">
                <?php
                }
                ?>
                <div class="form-row">
                    <div class="col-md-4">

                        <label for="validationCustom01">Numero</label>
                        <input type="text" class="form-control" onkeypress="solonumeros(event);" id="iNumero" name="iNumero" value="<?=$iNumero?>" required="" maxlength="10">
                        <div class="valid-feedback">
                            
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-8">
                        <label for="validationCustom02">Nombre del programa</label>
                        <input type="text" class="form-control" id="vProgramaPresupuestario" name="vProgramaPresupuestario"  value="<?=$vProgramaPresupuestario?>" required="">
                        <div class="valid-feedback">
                            
                        </div>
                    </div>
                </div>
                <br>
                <center>
                    <button class="btn waves-effect waves-light btn-info" type="submit">Guardar</button>
                </center>
            </form>                            
        </div>
    </div>
</div>
</div>
    
<script type="text/javascript">   

    function guardar(f, e){
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_pps/guardar",
            data: $(f).serialize(),

            success: function(resp) {
                resp = JSON.parse(resp);
                if (resp.resp) {
                    filter(e);
                    alerta('El registro ha sigo guardado', 'success');
                } else {
                    alerta(resp.mensaje, 'error');
                }
            },
            error: function(XMLHHttRequest, textStatus, errorThrown) {

            }
        });
    }

    function solonumeros(e) {
        var key = window.event ? e.which : e.keyCode;
        if (key < 48 || key > 57)
            e.preventDefault();
    }
</script>