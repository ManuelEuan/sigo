<div class="card d-flex">
  <div class="card-body">
    
    <div class="row">
      <div class="col-12">
        <table class="table table-bordered table-striped" id="tabla">
          <thead>
              <th>Nombre cortooo</th>
              <th>Nombre completo..</th>
              <!--<th>Avance</th>-->
          </thead>
          <tbody>
            <?php
            foreach ($result as $row)
            {
                $avance = ($row->numact > 0) ? $row->sumavance/$row->numact:0;
              
                echo '<tr title="Haga clic para ver listado actividades" style="cursor:pointer;" onclick="verFicha('.$row->iIdDependencia.');">
                    <td>'.$row->vNombreCorto.'</td>
                    <td>'.$row->vDependencia.'</td>
                    <!--<td><div class="progress" style="height: 20px;">
                          <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width:'.round($avance).'%;" aria-valuenow="'.round($avance).'" aria-valuemin="0" aria-valuemax="100"><span class="text-center d-flex position-absolute" style="font-weight:bold;color:#000000;">'.round($avance).'%</span></div>
                        </div>
                    </td>-->
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

    function verFicha(idDep){
      var variables = {
            idDep: idDep
        }
        cargar('<?= base_url(); ?>index.php/C_dash2/ficha_dep', '#datos', 'POST', variables);
    }
</script>
