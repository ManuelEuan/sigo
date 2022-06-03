<div class="card d-flex">
  <div class="card-body">
    <div class="row">
      <div class="col-12">
        <table class="table table-bordered table-striped" id="tabla">
        <thead>
            <th>Nombre</th>
            <th>Tipo</th>
        </thead>
        <tbody>
          <?php
          foreach ($result as $row)
          {
              if($row->tipo == 1)
              {
                  $tipo = 'Dependencia';
                  if( trim($row->nom2) != '') $row->nom.= ' ('.$row->nom2.')';
              }else $tipo = 'Actividad';

              echo '<tr title="Haga clic para ver más información" style="cursor:pointer;" onclick="verDetalle('.$row->tipo.','.$row->id.');">
                  <td>'.$row->nom.'</td>
                  <td>'.$tipo.'</td>
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

    function verDetalle(tipo,id){
        var variables = {
          tipo: tipo,
          id: id
        }
        cargar('<?= base_url(); ?>index.php/C_dash/ver_detalle', '#datos', 'POST', variables);
    }
</script>
