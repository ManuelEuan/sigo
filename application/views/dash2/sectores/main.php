<script src="<?= base_url(); ?>public/assets/libs/echarts/dist/echarts-en.min.js"></script>
<section>
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
            </div>
        </div>
    </div>
</section>

<br>
<div class="col-md-12">
    <form onsubmit="recuperar(event);" id="form-busqueda">
    <div class="row">
        <div class="col-md-11 mb-4">
            <label>Búsqueda por palabra clave</label>
            <input type="text" value="<?php echo date('Y'); ?>" id="anio" name="anio" class="form-control" autofocus="on" required>
            <input type="hidden" name="eje_oculto" id="eje_oculto" value="0">
        </div>
        <div class="col-md-1" style="padding-top: 2.5%;">
            <button id="search" type="submit" class="btn btn-dark"><i class="mdi mdi-search-web"></i></button>
        </div>
    </div>
    </form>
</div>
<section id="datos">

</section>

<script>
    $(document).ready(function(){
        $("#search").trigger("click");
    });

    function recuperar(e, op = 0){
        if(op > 0) $("#eje_oculto").val(op);
        //e = e || $(window).event;        
        e.preventDefault();       
        //var variables = $('#form-busqueda').serialize();
        var variables = {
            anio: $('#anio').val(),
            eje: op
        }
        cargar('<?= base_url(); ?>index.php/C_dash2/find_in_sector', '#datos', 'POST', variables);
    }
</script>