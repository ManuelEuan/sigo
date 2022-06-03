<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <h3 class="card-title">Edición</h3>
                </div>
                <div class="col-md-2 text-right">
                    <button title="Ir a la pantalla anterior" class="btn waves-effect waves-light btn-outline-info" type="submit" onclick="buscar(event)"><i class="mdi mdi-arrow-left"></i>Regresar</button>
                </div>
            </div>

            <div class="dropdown-divider"></div>
            <form class="needs-validation was-validated" onsubmit="guardar(this,event);">
                <input type="hidden" name="iIdActividad" value="<?=$iIdActividad?>">
                <input type="hidden" name="iIdEntregable" value="<?=$iIdEntregable?>">
                <input type="hidden" name="iIdDetalleEntregable" value="<?=$iIdDetalleEntregable?>">
                <div class="form-row">
                    <div class="col-md-12 mb-4">
                        <label>Actividad</label>
                        <textarea disabled class="form-control alphaonly" id="actividad" name="actividad" aria-invalid="false" required="" placeholder="Ingresar nombre del indicador" ><?=$vActividad;?></textarea>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-4">
                        <label>Entregable</label>
                        <textarea disabled class="form-control alphaonly" id="entregable" name="entregable" aria-invalid="false" required="" placeholder="Ingresar nombre del indicador" ><?=$vEntregable;?></textarea>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label>Meta</label>
                        <input disabled type="text" id="meta" name="meta" class="form-control only_number" value="<?=$nMeta?>">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                      <!--  <label>Meta modificada</label>
                        <input disabled type="text" id="metamodificada" name="metamodificada" class="input-lectura form-control" value="<?=$nMetaModificada?>">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div> -->
                         <input type="hidden" class="form-control input-lectura" maxlength="255" id="metamodificada" name="metamodificada" value="0">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="validationCustom04">Unidad de medida</label>
                        <input disabled type="text" id="metamodificada" name="metamodificada" class="input-lectura form-control" value="<?=$vUnidadMedida?>">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="validationCustom04">Sujeto afectado</label>
                        <input disabled type="text" id="metamodificada" name="metamodificada" class="input-lectura form-control" value="<?=$vSujetoAfectado?>">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label>Periodicidad</label>
                       <input disabled type="text" id="metamodificada" name="metamodificada" class="input-lectura form-control" value="<?=$vPeriodicidad?>">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>
              
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label><?=$mun;?></label>
                        <label><?=$misben?></label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input" id="iAnexo" name="iAnexo" value="1" <?=$checked?> >
                            <label class="custom-control-label" for="iAnexo">Se reporta en el anexo estadístico</label>
                        </div>
                    </div>
                
                </div>

                <h4>Datos para el anexo estadístico</h4>
                <div class="dropdown-divider"></div>

                <div class="row">                
                    <div class="col-md-6 mb-2">
                        <label>Titulo tabla anexo (Actividad)<span class="text-danger">*</span></label>
                        <textarea class="form-control alphaonly" id="vNombreActividad" name="vNombreActividad" aria-invalid="false" required=""><?=$vNombreActividad;?></textarea>
                    </div>                
                
                    <div class="col-md-6 mb-2">
                        <label>Titulo tabla anexo (Indicador)<span class="text-danger">*</span></label>
                        <textarea class="form-control alphaonly" id="vNombreEntregable" name="vNombreEntregable" aria-invalid="false" required=""><?=$vNombreEntregable;?></textarea>
                    </div>                
                </div>

                <div class="row">                
                    <div class="col-md-12 mb-2">
                        <label>Titulo tabla anexo traducido a Lengua Maya<span class="text-danger">*</span></label>
                        <textarea class="form-control alphaonly" id="vNombreEntregableMaya" name="vNombreEntregableMaya" aria-invalid="false" required=""><?=$vNombreEntregableMaya;?></textarea>
                    </div>                
                </div>

                <div class="row">                
                    <div class="col-md-6 mb-4">
                        <label>Eje<span class="text-danger">*</span></label>
                        <select class="form-control" name="iEjeAnexo" id="iEjeAnexo">
                            <?=$ejes;?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label>ODS<span class="text-danger">*</span></label>
                        <select class="form-control" name="iNumOds" id="iNumOds">
                            <?=$ods;?>
                        </select>
                    </div>
                </div>

                <center>
                    <button class="btn waves-effect waves-light btn-info" type="submit">Guardar</button>
                    <button type="reset" class="btn waves-effect waves-light btn-inverse" onclick="regresarmodulo()">Cancelar</button>
                </center>
            </form>
        </div>
    </div>
</div>

<script>
    $(".alphaonly").attr("maxlength", 350);
    $(".only_number").attr("maxlength", 11);

    function guardar(f, e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_entregables/guardar_entregable", //Nombre del controlador
            data: $(f).serialize(),
            success: function(resp) {
               if(resp == 1) alerta('ok','success');
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {

            }
        });
    }
</script>

