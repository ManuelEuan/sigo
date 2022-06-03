    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">

                    <table id="grid" class="table table-striped table-bordered display" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Año</th>
                                <th>Bancada</th>
                                <th>Pregunta</th>
                                <th>Respuesta</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            if($preguntas!=false && count($preguntas) > 0)
                            {
                                foreach ($preguntas as $vpreg) {
                                    echo '
                                    <tr>
                                        <td>'.$vpreg->iIdPregunta.'</td>
                                        <td>'.$vpreg->iAnio.'</td>
                                        <td>'.$vpreg->vBancada.'</td>
                                        <td>'.$vpreg->vPregunta.'</td>
                                        <td>'.$vpreg->vRespuesta.'</td>
                                        <td width="200px;">
                                            <button type="button" class="btn btn-circle waves-effect waves-light btn-warning" onclick="modificar_pregunta('.$vpreg->iIdPregunta.');"><i class="mdi mdi-border-color"></i></button>                            
                                            <button type="button" class="btn btn-circle waves-effect waves-light btn-danger" onclick="confirmar(\'¿Esta usted seguro?\',eliminar_pregunta,'.$vpreg->iIdPregunta.')"><i class="mdi mdi-close"></i></button>
                                        </td>
                                    </tr>
                                    ';
                                }
                            }
                        ?>
                        </tbody>                        
                    </table>
                </div>
            </div>
        </div>
    </div>


<script>
    $(document).ready(function() {
        $("#buscador_preguntas").show();
        $("#grid").DataTable();
    });
</script>