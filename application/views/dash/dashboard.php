<!-- referencias -->
<!-- highmaps -->
<!--<script src="<?= base_url(); ?>assets/highmaps/code/highcharts.js"></script>
<script src="<?= base_url(); ?>assets/highmaps/code/highmaps.js"></script>

<script src="<?= base_url(); ?>assets/highmaps/code/modules/exporting.js"></script>
<script src="<?= base_url(); ?>assets/highmaps/code/modules/offline-exporting.js"></script>-->

<!--
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>-->

<!-- #end highmaps -->
<!-- echarts -->
<script src="<?= base_url(); ?>public/assets/libs/echarts/dist/echarts-en.min.js"></script>
<!-- #end echarts -->
<!-- #end referencias -->

<section>
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <!--
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                </div>
            -->
            </div>
        </div>
    </div>
</section>

<!-- end Titulo -->
<br>
<div class="col-md-12">
    <form onsubmit="recuperar(event);" id="form-busqueda">
    <div class="row">
        <div class="col-md-11">
        <label>Búsqueda por palabra clave</label>
        <input type="text" value="<?php echo date('Y'); ?>" id="anio" name="anio" class="form-control" autofocus="on" required>
        <input type="hidden" name="eje_oculto" id="eje_oculto" value="0">
        </div>
        <div class="col-md-1" style="padding-top: 2.5%;">
        <button id="search" type="submit" class="btn btn-dark"><i class="mdi mdi-search-web"></i></button>
        <br><br>
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
        cargar('<?= base_url(); ?>index.php/C_dash/buscar', '#datos', 'POST', variables);
    }
</script>