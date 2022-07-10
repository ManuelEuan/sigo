<!--titulo-->
<section>
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-5 align-self-center">
        <h4 class="page-title">Reporte Picaso</h4>
      </div>
    </div>
  </div>
</section>
<!--endtitulo-->
<br><br>
<!-- formulario -->
<section>
  <form id="frmReport">
    <div class="card" style="padding: 2%;">
      <form id="form" name="form" class="">
        <hr>

        <div class="row">

        <textarea name="txtsql" id="txtsql" cols="30" rows="10" style="width: 100%;"></textarea>
        
        </div>

        <!--<div id="divChecks">
          <div class="row">
            <div class="col-12">
              <h4><b>Campos adicionales</b></h4>
              <hr>
            </div>
          </div>

          <div class="row">
            <div class="col-4">
              <div class="form-check" style="margin-top:10px;">
                <input class="form-check-input" type="checkbox" name="fuentes" value="1" id="fuentes">Fuentes de financiamiento
              </div>
              <div class="form-check" style="margin-top:10px;">
                <input class="form-check-input" type="hidden" name="ubp" value="0" id="ubp">
              </div>
              <div class="form-check" style="margin-top:10px;">
                <input class="form-check-input" type="checkbox" name="ped" value="1" id="ped">Alineación al PED
              </div>
            </div>
            <div class="col-4">
              <div class="form-check" style="margin-top:10px;">
                <input class="form-check-input" type="checkbox" name="entregables" value="1" id="entregables" onchange="validChecks();">Indicadores
              </div>
              <div class="form-check" style="margin-top:10px;">
                <input class="form-check-input" type="hidden" name="compromisos" value="0" id="compromisos" disabled>
              </div>
              <div class="form-check" style="margin-top:10px;">
                <input class="form-check-input" type="checkbox" name="metasmun" value="1" id="metasmun" disabled>Metas por municipio
              </div>
              <div class="form-check" style="margin-top:10px;margin-bottom:10px;">
                <input class="form-check-input" type="checkbox" name="avances" value="1" id="avances" onchange="validGroupby();" disabled>Avances
              </div>


            </div>

          </div>
        </div> -->

        <div class="row">
          <div class="col-md-4">
            <a style="cursor:pointer; color:blue; display:none;" href="<?= base_url(); ?>public/reportes/actividadesBD.xlsx" id="descarga"><i class="m-r-10 mdi mdi-briefcase-download"></i>Descargar</a>
          </div>
          <div class="col-md-4"></div>
          <div class="col-md-4">
            <button onclick="generarExcel();" type="button" class="btn waves-effect waves-light btn-block btn-danger">Generar</button>
          </div>
        </div>
        
        <div id="respuesta">

        </div>

      </form>
    </div>
  </form>
</section>

<script>

    function generarExcel(){
        var message = $('#txtsql').val();
        //console.log(message);       
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>index.php/C_query/ejecutarQuery",
            data: {message:message},
            success: function (response) {
                console.log(response)
                $("#respuesta").html(response)
            }
        });
    }

</script>