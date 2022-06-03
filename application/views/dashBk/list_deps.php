<div class="card d-flex">
  <div class="card-body">
    <div class="row">
        <div class="col-12 text-right mb-4">
            <button title="Regresar" type="button" class="btn waves-effect waves-light btn-outline-info" onclick="regresar();"><i class="mdi mdi-arrow-left"></i>&nbsp;Regresar</button>
        </div>
    </div>

    <div class="row">
      <div class="col-12">
        <table class="table table-bordered table-striped" id="tabla">
          <thead>
              <th>Nombre corto</th>
              <th>Dependencia</th>
              <th>Avance</th>
              <th>Presupuesto ejercido</th>
          </thead>
          <tbody>
            <?php
            foreach ($query as $row)
            {
                $avance = ($row->numact > 0) ? $row->sumavance/$row->numact:0;
                $porcentajeAutorizado = ($row->numact > 0) ? round(($row->ejercido * 100) / ($row->autorizado), 0) : 0;

                echo '<tr title="Haga clic para ver listado actividades" style="cursor:pointer;" onclick="verActividades('.$row->iIdDependencia.');">
                    <td>'.$row->vNombreCorto.'</td>
                    <td>'.$row->vDependencia.'</td>
                    <td><div class="progress" style="height: 20px;">
                          <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width:'.round($avance).'%;" aria-valuenow="'.round($avance).'" aria-valuemin="0" aria-valuemax="100"><span class="text-center d-flex position-absolute" style="font-weight:bold;color:#000000;">'.round($avance).'%</span></div>
                        </div>
                    </td>
                     <td><div class="progress" style="height: 20px;">
                          <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width:'.$porcentajeAutorizado.'%;" aria-valuenow="'.$porcentajeAutorizado.'" aria-valuemin="0" aria-valuemax="100"><span class="text-center d-flex position-absolute" style="font-weight:bold;color:#000000;">'.$porcentajeAutorizado.'%</span></div>
                        </div>
                    </td>
                </tr>';
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $("#tabla").dataTable();
    });

    function verActividades(dep){
      var variables = {
            anio: <?=$anio?>,
            eje: <?=$eje?>,
            dep: dep
        }
        cargar('<?= base_url(); ?>index.php/C_dash/list_acts', '#datos', 'POST', variables);
    }

    function regresar(){
      var variables = {
            anio: $('#anio').val(),
            eje: 0
      }
      cargar('<?= base_url(); ?>index.php/C_dash/buscar', '#datos', 'POST', variables);
    }
</script>
