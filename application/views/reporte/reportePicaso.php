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

      </form>
    </div>
  </form>
</section>
<script>
  var position = 0;
  var total = 0;

  function espera(id) {
    document.getElementById("descarga").style.display = "none";
    if ($("#tipo").val() == 1) generarExcel();
  }

  function showChecks() {
    if ($("#tipo").val() == 1) $("#divChecks").css('display', 'none');
    else $("#divChecks").css('display', '');
  }

  function validChecks() {
    if (!$("#entregables").is(':checked')) {
      $("#compromisos").prop('checked', false);
      $("#metasmun").prop('checked', false);
      $("#avances").prop('checked', false);

      $("#compromisos").attr('disabled', true);
      $("#metasmun").attr('disabled', true);
      $("#avances").attr('disabled', true);

    } else {
      $("#compromisos").attr('disabled', false);
      $("#metasmun").attr('disabled', false);
      $("#avances").attr('disabled', false);
    }
  }

  function validGroupby() {
    $("input[name*='agrupar']").attr('disabled', !$("#avances").is(':checked'));
  }

  function generarFichas() {
    var data = $("#frmReport").serialize();

    $.ajax({
      type: "POST",
      url: "<?= base_url() ?>index.php/C_reportesPOA/listar_actividades",
      data: data,
      success: function(resp) {
        var ids = JSON.parse(resp);
        total = ids.length;
        if (total > 0) generaFicha(ids, position);
        else {
          Swal.fire({
            position: 'center',
            type: 'warning',
            title: 'No se encontraron registros para los filtros seleccionados',
            showConfirmButton: false,
            timer: 2000
          });
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {}
    });
  }

  function generaFicha(array, position, dir) {
    dir = dir || '';

    if (position < total) {
      var id = array[position].iIdDetalleActividad;
      var url = "<?= base_url() ?>index.php/C_pat/ShowFichaActividad/" + id + "/F";
      if (dir != '') url += '/' + dir;
      $.ajax({
        type: "GET",
        url: url,
        success: function(resp) {
          resp = JSON.parse(resp);
          if (resp.status) {
            position++;
            generaFicha(array, position, resp.temp_dir);
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {}
      });
    } else {
      comprimir(dir);
    }
  }

  function comprimir(dir) {
    $.ajax({
      type: "POST",
      url: "<?= base_url() ?>index.php/C_reportesPOA/comprimir_directorio",
      data: "dir=" + dir,
      success: function(resp) {
        resp = JSON.parse(resp);
        if (resp.status) {

          $("#descarga").attr("href", "<?= base_url(); ?>public/reportes/" + dir + ".zip");
          document.getElementById("descarga").style.display = "inline";

          Swal.fire({
            position: 'center',
            type: 'success',
            title: 'El proceso ha finalizado',
            showConfirmButton: false,
            timer: 1500
          });
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {}
    });
  }

  function dependencia() {
    var id = document.getElementById("selEje").value;
    $.ajax({
      type: "POST",
      url: "<?= base_url() ?>index.php/C_reportesPOA/dependencias",
      data: 'id=' + id,
      success: function(r) {
        $("#selDep").html(r);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        notie.alert({
          type: 3,
          text: 'Ha ocurrido un error. Contacte al administrador',
          time: 2
        });
      }
    });
  }

  function generarExcel() {
    var eje = parseInt($("#selEje").val());
    var dep = parseInt($("#selDep").val());
    var anio = $("#anio").val();
    var mes = $('#mes').val();

      $.ajax({
        type: "POST",
        url: "<?= base_url() ?>index.php/C_reportePicaso/generarrepo",
        beforeSend: function(xhr) {
          Swal.fire({
            position: 'center',
            type: 'info',
            title: 'Estamos trabajando en ello, espere por favor',
            showConfirmButton: false,
            timer: 2000
          });
        },
        success: function(r) {
          console.log(r)
          var resp = JSON.parse(r);
          if (resp.resp) {
            $("#descarga").attr("href", resp.url);
            document.getElementById("descarga").style.display = "inline";
            Swal.fire({
              position: 'center',
              type: 'success',
              title: 'Su reporte se ha generado con exito',
              showConfirmButton: false,
              timer: 1500
            })
          } else {
            Swal.fire({
              position: 'center',
              type: 'error',
              title: resp.error_message,
              showConfirmButton: false,
              timer: 1500
            })
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {

        }
      });
    
  }
</script>