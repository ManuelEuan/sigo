<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <h4 class="card-title">Permisos por Rol</h4>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-light" type="submit" onclick="regresar()"><i class="mdi mdi-arrow-left">Regresar</i></button>
                </div>
            </div>
            <br><br>
            <form class="needs-validation" onsubmit="guardarPermisos(this,event);">
                <?= $menu ?>
            </form>
        </div>
    </div>
</div>

<script>
    function guardarPermisos(f,e){
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "<?=base_url()?>C_roles/restart", //Nombre del controlador
            data: $(f).serialize(),

            success: function(resp) {
              if(resp == "correcto"){
                
                regresar();
                alerta('Guardado exitosamente','success');

              }if(resp == "error"){

                alerta('Error al guardar','error');
              }

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              
            }
        });
    }
</script>

<script>
function changecheck(idcheck,id,idpermisopadre){
    $("#"+idcheck).on('click change', function(e) {
        $("#val"+id).val(1);
        $("#guardarpermisos").removeAttr('disabled');

        if(idpermisopadre != 0){

            if($("#rbt1"+idpermisopadre).is(':checked') || $("#rbt2"+idpermisopadre).is(':checked') || $("#rbt3"+idpermisopadre).is(':checked')){               

            }else{
                $("#rbt2"+idpermisopadre).prop("checked", true);
            }
        }
    });
}  
</script>