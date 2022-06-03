<div id="contenido_modulo" class="">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                    <div align="right">
                        <button type="button" class="btn waves-effect waves-light btn-outline-info" onclick="verListado(event);"><i class="mdi mdi-arrow-left"></i> Regresar</button>
                    </div>
                <form class="needs-validation was-validated" onsubmit="guardar(this,event);">
                    <div class="form-row">                                    
                        <div class="col-8">
                            <label for="vPermiso">vPermiso</label>
                            <input type="hidden" name="iIdPermiso" id="iIdPermiso" value="<?=$iIdPermiso?>">
                            <input type="text" class="form-control" id="vPermiso" name="vPermiso" value="<?=$vPermiso?>" required="" maxlength="100">
                            <div class="valid-feedback">
                                
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="vIdentificador">vIdentificador</label>
                            <input type="text" class="form-control" id="vIdentificador" name="vIdentificador" value="<?=$vIdentificador?>" required maxlength="50">
                            <div class="valid-feedback">
                                
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-12">
                            <label for="vDescripcion">vDescripcion</label>
                            <input type="text" class="form-control" id="vDescripcion" name="vDescripcion" value="<?=$vDescripcion?>" required maxlength="255">
                            <div class="valid-feedback">
                                
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-4">
                            <label for="iTipo">iTipo</label>
                            <input type="text" class="form-control" id="iTipo" name="iTipo" value="<?=$iTipo?>" required maxlength="1" onkeypress="solonumeros(event);">
                        </div>
                        <div class="col-8">
                            <label for="vUrl">vUrl</label>
                            <div class="form-group">
                            <input type="text" class="form-control" id="vUrl" name="vUrl" value="<?=$vUrl?>" required maxlength="255">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <label>iIdPermisoPadre</label>
                            <div class="form-group">
                                <select class="custom-select select2" required="required" id="iIdPermisoPadre" name="iIdPermisoPadre">
                                    <option value="0">N/A</option>
                                    <?=$permisosPadre?>
                                </select>
                                <div class="valid-feedback"> </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="vClass">vClass</label>
                            <input type="text" class="form-control" id="vClass" name="vClass" value="<?=$vClass?>" required maxlength="100">
                        </div>
                    </div>

                    <div class="form-row mb-4">
                        <div class="col-4">
                            <label for="iOrden">iOrden</label>
                            <input type="text" class="form-control" id="iOrden" name="iOrden" value="<?=$iOrden?>" required maxlength="2" onkeypress="solonumeros(event);">
                        </div>
                        <div class="col-4">
                            <label for="iActivo">iActivo</label>
                            <select class="custom-select" required="required" id="iActivo" name="iActivo">
                                <option value="1" <?php if($iActivo == 1) echo 'selected';?>>Activo</option>
                                <option value="0" <?php if($iActivo == 0) echo 'selected';?>>Inactivo</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="iInicial">iInicial</label>
                            <input type="text" class="form-control" id="iInicial" name="iInicial" value="<?=$iInicial?>" required maxlength="1" onkeypress="solonumeros(event);">
                        </div>
                    </div>
                    <center>
                        <button class="btn btn-lg waves-effect waves-light btn-primary" type="submit">Guardar</button>
                    </center>
                </form>                            
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $(".select2").select2();
    });

    
    function guardar(f, e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_admin/guardar_permiso",
            data: $(f).serialize(),
            success: function(resp) {
                resp = JSON.parse(resp);
                if(resp.status == 'success'){
                    alerta('Los cambios han sido guardados',resp.status);
                    capturar(resp.id);
                }
                else alerta('Ha ocurrido un error al intentar guardar',resp.status);
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