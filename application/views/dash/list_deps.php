



       
        </div>
        <div class="col-12 text-left mb-4">
        <label><?php print($query[0]->cadena) ?></label>
        </div>
          
        </div>  
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
              <th>Acciones</th>
              <th>Total de beneficiarios </th>
              <th>Presupuesto Ejercido</th>
              <th>Avance</th>
          </thead>
          <tbody>
            <?php
            foreach ($query as $row)
            {
                $avance = ($row->numact > 0) ? $row->sumavance/$row->numact:0;
                $dep    =  $row->presupuesto; 

                $clase      = 'success';
                $classPre   = 'success';

                if($avance >= 0 && $avance < 25)
                    $clase = 'danger';
                elseif($avance >= 25 && $avance < 80)
                    $clase = 'warning';

                if($row->presupuesto >= 0 && $avance < 25)
                    $classPre = 'danger';
                elseif($row->presupuesto >= 25 && $avance < 80)
                    $classPre = 'warning';

                echo '<tr title="Haga clic para ver listado actividades" style="cursor:pointer;" onclick="verActividades('.$row->iIdDependencia.');">
                    <td>'.$row->vNombreCorto.'</td>
                    <td>'.$row->vDependencia.'</td>
                    <td>'.$row->numact.'</td>
                    <td>'.$row->beneficiario.'</td>
                    <td>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar progress-bar-striped bg-'.$classPre.'" role="progressbar" style="width:'.$row->presupuesto.'%;" aria-valuenow="'.$row->presupuesto.'" aria-valuemin="0" aria-valuemax="100"><span class="text-center d-flex position-absolute" style="font-weight:bold;color:#000000;">'.number_format($row->presupuesto, 2).'%</span></div>
                        </div>
                    </td>
                    <td><div class="progress" style="height: 20px;">
                          <div class="progress-bar progress-bar-striped bg-'.$clase.'" role="progressbar" style="width:'.round($avance).'%;" aria-valuenow="'.round($avance).'" aria-valuemin="0" aria-valuemax="100"><span class="text-center d-flex position-absolute" style="font-weight:bold;color:#000000;">'.number_format(round($avance), 2).'%</span></div>
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
<hr>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/polyfills.umd.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/mapacalor.js"></script>
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
      cargar('<?= base_url(); ?>index.php/C_dash2/main_sectores', '#datos', 'POST', variables);
    }
    function verEje(id){
        cargar('<?=base_url();?>index.php/C_dash/ficha_eje','#datos','POST','id='+id+'&anio=<?=$anio?>');
    }

  
    function listarDeps(eje, name){
        var variables = {
            anio: <?=$anio?>,
            eje: eje,
            name: name
        }
        cargar('<?= base_url(); ?>index.php/C_dash/deps_anio_eje', '#datos', 'POST', variables);
    }
    

</script>
