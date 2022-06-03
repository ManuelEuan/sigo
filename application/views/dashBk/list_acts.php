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
            <th>Actividad</th>
            <th>Avance</th>
        </thead>
        <tbody>
          <?php
          foreach ($query as $row)
          {
              echo '<tr title="Haga clic para consultar actividad" style="cursor:pointer;" onclick="verActividad('.$row->iIdActividad.');">
                  <td>'.$row->vActividad.'</td>
                  <td><div class="progress" style="height: 20px;">
                          <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width:'.round($row->nAvance).'%;" aria-valuenow="'.round($row->nAvance).'" aria-valuemin="0" aria-valuemax="100"><span class="text-center d-flex position-absolute" style="font-weight:bold;color:#000000;">'.round($row->nAvance).'%</span></div>
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

    function verActividad(idAct){
        var variables = {
          anio: <?=$anio?>,
          eje: <?=$eje?>,
          dep: <?=$dep?>,
          idAct: idAct
        }
        cargar('<?= base_url(); ?>index.php/C_dash/ver_actividad', '#datos', 'POST', variables);
    }

    function regresar(){
      var variables = {
            anio: $('#anio').val(),
            eje: <?=$eje?>
      }
      cargar('<?= base_url(); ?>index.php/C_dash/deps_anio_eje', '#datos', 'POST', variables);
    }
   
</script>
