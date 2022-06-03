<section>
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Reporte de vistas</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                
                            </li>
                            
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="col-12">
        <div class="card" style="padding: 2%;">
            <div class="col-md-12">
              <h4 class="page-title">Avances</h4>
              <?=$vavances?>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="col-12">
        <div class="card" style="padding: 2%;">
            <div class="col-md-12">
              <h4 class="page-title">Captura diaria</h4>
              <?=$vcapdiaria?>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="col-12">
        <div class="card" style="padding: 2%;">
            <div class="col-md-12">
              <h4 class="page-title">Sin captura</h4>
              <?=$vnocaptura?>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="col-12">
        <div class="card" style="padding: 2%;">
          <h4 class="page-title">Última captura</h4>
            <div class="col-md-12">
               <?=$vultcapt?>
            </div>
        </div>
    </div>
</section>


<script type="text/javascript">
  $(document).ready(function(){


    $('#t_vavances').dataTable({
      dom: 'Bfrtip1',
      buttons: [
          'copy', 'excel', 'pdf'
      ]
    });

    $('#t_vcapdiaria').dataTable({
      dom: 'Bfrtip2',
      buttons: [
          'copy', 'excel', 'pdf'
      ]
    });

    $('#t_vnocaptura').dataTable({
      dom: 'Bfrtip3',
      buttons: [
          'copy', 'excel', 'pdf'
      ]
    });

     $('#t_vultcapt').dataTable({
      dom: 'Bfrtip',
      buttons: [
          'copy', 'excel', 'pdf'
      ]
    });

     $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
    
  });

</script>