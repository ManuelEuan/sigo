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
            <th>Acción</th>
            <th>Total de beneficiarios </th>
            <th>Presupuesto Ejercido</th>
            <th>Avance</th>
        </thead>
        <tbody>
          <?php
          foreach ($query as $row)
          {
                $avance = round($row->nAvance);
                $clase = 'success';
                $classPre = 'success';

                if($avance >= 0 && $avance < 25)
                    $clase = 'danger';
                elseif($avance >= 25 && $avance < 80)
                    $clase = 'warning';
                    
                if($row->presupuesto >= 0 && $row->presupuesto  < 25)
                    $classPre = 'danger';
                elseif($row->presupuesto >= 25 && $row->presupuesto  < 80)
                    $classPre = 'warning';

                echo '<tr title="Haga clic para consultar actividad" style="cursor:pointer;" onclick="verActividad('.$row->iIdActividad.');">
                    <td>'.$row->vActividad.'</td>
                    <td style="text-align: center;">'.$row->beneficiario.'</td>
                    <td>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar progress-bar-striped bg-'.$classPre.'" role="progressbar" style="width:'.$row->presupuesto.'%;" aria-valuenow="'.$row->presupuesto.'" aria-valuemin="0" aria-valuemax="100"><span class="text-center d-flex position-absolute" style="font-weight:bold;color:#000000;">'.number_format($row->presupuesto, 2).'%</span></div>
                        </div>
                    </td>
                    <td>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar progress-bar-striped bg-'.$clase.'" role="progressbar" style="width:'.round($row->nAvance).'%;" aria-valuenow="'.round($row->nAvance).'" aria-valuemin="0" aria-valuemax="100"><span class="text-center d-flex position-absolute" style="font-weight:bold;color:#000000;">'.number_format(round($row->nAvance), 2).'%</span></div>
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
