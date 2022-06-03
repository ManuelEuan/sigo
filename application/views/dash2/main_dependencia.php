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
<div class="col-md-12 mb-4">
    <?php
    if(isset($depencencias))
    {
      echo '<div class="row">
                <div class="col-md-11">
                    <label class="control-label">Búsqueda por palabra clave</label>
                    <select name="SelDep" id="DependenciasIdSelect" class="form-control select2" onChange="buscar(event);">
                        <option value="SinResultados">--SELECCIONE UNA OPCIÓN--</option>'.$depencencias.'
                    </select>
                </div>
            </div>';
    }
    ?>
</div>
<!-- <div class="col-md-12 mb-4">
    <form onsubmit="buscar(event);" id="form-busqueda">
        <div class="row">
            <div class="col-md-11">
                <label>Búsqueda por palabra clave</label>
                <input type="text" value="" id="text" name="text" class="form-control" autofocus="on" placeholder="Ingrese su texto aquí" required>
            </div>
            <div class="col-md-1" style="padding-top: 2.5%;">
                <button id="search" type="submit" class="btn btn-dark"><i class="mdi mdi-search-web"></i></button>
            </div>
        </div>
    </form>

</div> -->
<section id="datos">

</section>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            minimumResultsForSearch: 10
        });
        $("#search").trigger("click");
        $('.count').each(function() {
            $(this).prop('Counter', 0).animate({
                Counter: $(this).text()
            }, {
                duration: 4000,
                easing: 'swing',
                step: function(now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });
    });



    function buscar(e) {
        e.preventDefault();
        //var variables = $('#form-busqueda').serialize();
        var variableSelect = {SelDep : $(".select2 option:selected").text()};
        cargar('<?= base_url(); ?>index.php/C_dash2/buscar_dep', '#datos', 'POST', variableSelect);
    }
</script>