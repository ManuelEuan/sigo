<div class="container-fluid" id="buscador_preguntas" style="height: 100% !important; min-height: 100% !important; display: block;">       
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h1 class="page-title">Preguntas Diputados</h1>
                    <h6 class="card-subtitle">Administración del catalogo de compromisos </h6>
                    <h4 class="card-title">Búsqueda</h4>
                    <h6 class="card-subtitle"></h6>

                    <form class="" id="buscarPregunta">
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="eje">Eje</label>
                                    <select name="eje" id="eje" class="custom-select">
                                        <option value="">Todos</option>
                                        <?=$ejes;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="dependencia">Año</label>
                                    <select name="anio" id="anio" class="custom-select">
                                        <option value="">Todos</option>

                                        <?php 
                                        if($anio!=false)
                                        {
                                            foreach ($anio as $v) {
                                                
                                                echo '<option value="'.$v->iAnio.'">'.$v->iAnio.'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="estatus">Partido</label>
                                    <select name="partido" id="partido" class="custom-select">
                                        <option value="">Todos</option>                                        
                                        <option value="PAN">PAN</option>
                                        <option value="PRI">PRI</option>
                                        <option value="PRD">PRD</option>
                                        <option value="PVEM">PVEM</option>
                                        <option value="PANAL">PANAL</option>
                                        <option value="MORENA">MORENA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-1" style="margin-top: 30px;">
                                <button type="button" class="btn waves-effect waves-light"
                                        onclick="carga_preguntas()">Buscar
                                </button>
                            </div>
                            <div class="form-group col-1" style="margin-top: 30px;">
                                <button type="button" class="btn waves-effect waves-light btn-info"
                                        onclick="agregar_pregunta()">Agregar
                                </button>

                            </div>
                        </div>                    
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<section id="contenedor" class="container-fluid">
    <?php
        //include_once 'tabla.php';
    ?>
</section>

<script type="text/javascript">
    function carga_preguntas() {
        $.post("<?=base_url();?>C_preguntas/cargar_preguntas/", $('#buscarPregunta').serialize(), function (resp)
        {
            $('#contenedor').html(resp);
        });
    }

    function agregar_pregunta() {
        cargar('<?=base_url();?>C_preguntas/crear', '#contenedor');
    }

    function modificar_pregunta(id) {
        var variables = 'pregid='+id;
        cargar('<?=base_url();?>C_preguntas/modificar', '#contenedor', 'POST', variables);
    }

    function eliminar_pregunta(id) {
        $.post('<?=base_url();?>C_preguntas/eliminar', {id:id}, function(resp) {
            if(resp=='correcto') { alerta('Eliminado correctamente','success'); carga_preguntas(); }
            else alerta('Error al eliminar la pregunta','warning');
        });
    }


</script>


