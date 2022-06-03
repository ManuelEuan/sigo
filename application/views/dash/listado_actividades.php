<blockquote>
    <div class="row">
        <div class="col-12 text-right">
            <button title="Cerrar tabla" type="button" class="btn btn-danger" onclick="cerrarTabla(<?=$trim?>);"><i class="mdi mdi-close"></i></button>
        </div>
    </div>
    <br>
    <table class="table table-bordered" id="tabla-trim<?=$trim?>">
      <thead>
          <th>Avance</th>
          <th>Acción</th>
          <th>Indicadores</th>
          <th>Dependencia</th>
          <th width="50px"></th>
      </thead>
      <tbody>
        <?php
        foreach ($rows as $row)
        {
            $li = '<dl>';
            foreach ($row->entregables as $ent) {
                $style = ($ent->avance > 0) ? 'style="color:#3E5F8A;"':'style="color:#CC0000;"';
                    $li.= '<dt><a href="#" '.$style.' onclick="verDetalleEntregable('.$ent->iIdDetalleEntregable.',event)">'.$ent->vEntregable.'</a></dt><dd>'.$ent->vPeriodicidad.'</dd>';
                
            }
            $li.= '</dl>';
            echo '<tr>
                <td>'.$row->nAvance.'</td>
                <td>'.$row->vActividad.'</td>
                <td>'.$li.'</td>
                <td>'.$row->vDependencia.'</td>
                <td> <button title="Descargar ficha" type="button" class="btn btn-xs btn-primary waves-effect waves-light boton_desc" onclick="descargarFichaActividad('.$row->iIdDetalleActividad.')"><i class="mdi mdi-download"></i></button></td>
            </tr>';
        }
        ?>
      </tbody>
    </table>
</blockquote>
<script type="text/javascript">
    $(document).ready(function(){
        $("#tabla-trim<?=$trim?>").dataTable();
    });

    function verDetalleEntregable($id,e){
        e.preventDefault();

        

    }
   
</script>
