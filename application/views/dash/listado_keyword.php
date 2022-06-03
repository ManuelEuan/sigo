<section>
    <div class="card">
        <div class="card-body" id="dash-content">

            <div class="tab-pane p-20" id="profile" role="tabpanel">
                <?php 
                if(count($query) > 0)
                {
                ?>
                <table id="lista_act" class="table table-hover datatable">
                    <thead class="bg-inverse text-white">
                        <tr>
                            <th>Id</th>
                            <th>Actividad</th>                            
                            <th>Dependencia</th>                        
                            <th>Avance</th>
                            <th>Ejercido</th>
                            <th>Beneficiarios</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($query as $row)
                        {
                            echo '<tr title="Haga click para ver más" style="cursor:pointer;" onclick="verMas('.$row['iIdActividad'].');">';
                            echo '<td>'.$row['iIdActividad'].'</td>';                            
                            echo '<td>'.$row['vActividad'].'</td>';                            
                            echo '<td>'.$row['vDependencia'].'</td>';
                            echo "<td>".Decimal($row['avance'])."</td>";
                            echo "<td>$".DecimalMoneda($row['ejercido'])."</td>";
                            echo "<td>".Decimal($row['beneficiarios'])."</td>";
                            
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            <?php 
            }
            else
            {
                echo '<p>No se encontraron resultados que coincidan con su búsqueda</p>';
            }
            ?>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function() {
        $("#eje_oculto").val(<?=$eje;?>);
        $('.datatable').DataTable();
    });
   
    function verMas(id){
        $.ajax({
            type: "POST",
            url: "<?=base_url() ?>C_dash/ficha/"+id,
            data: data,
            success: function(resp) {
                $("#datos").html(resp);
            },
            error: function(XMLHHttRequest, textStatus, errorThrown) {}
        });
    }

    function FichaActividad(iIdDetalleActividad) {
        window.open("<?= base_url() ?>C_pat/ShowFichaActividad/"+iIdDetalleActividad,"_blank");
    }
</script>