<!--titulo-->
<section>
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-5 align-self-center">
        <h4 class="page-title">Proyectos Prioritarios</h4>
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
        <h5>Filtrar por:</h5>
        <hr>

        <div class="row">
          <div class="col">
            <div class="form-group">
              <label readonly for="anio">Año<span class="text-danger">*</span></label>
              <input required="required" type="text" name="anio" id="anio" class="form-control" value="<?php echo date('Y'); ?>">
            </div>
          </div>
          <div class="col">
            <div class="form-group">
              <label class="control-label">Mes</label>
              <select class="form-control" name="mes" id="mes">
                <option value="0">--Todos--</option>
                <option value="1">Enero</option>
                <option value="2">Febrero</option>
                <option value="3">Marzo</option>
                <option value="4">Abril</option>
                <option value="5">Mayo</option>
                <option value="6">Junio</option>
                <option value="7">Julio</option>
                <option value="8">Agosto</option>
                <option value="9">Septiembre</option>
                <option value="10">Octubre</option>
                <option value="11">Noviembre</option>
                <option value="12">Diciembre</option>
              </select>
            </div>
          </div>
          <?php
          if (isset($ejes)) {
            echo '<div class="col">
                <div class="form-group">
                    <label class="control-label">Eje Rector<span class="text-danger">*</span></label>
                    <select name="selEje" id="selEje" class="form-control" onChange="dependencia();" >
                        <option value="0">--Todos--</option>' . $ejes . '
                    </select>
                </div>
            </div>';
          } else {
            echo '<input type="hidden" name="selEje" id="selEje" value="' . $_SESSION[PREFIJO . '_ideje'] . '" >';
          }

          if (isset($dependencias)) {
            echo '<div class="col">
                  <div class="form-group">
                      <label class="control-label">Dependencia responsabe</label>
                      <select name="selDep" id="selDep" class="form-control" >
                          <option value="0">--Todos--</option>' . $dependencias . '
                      </select>
                  </div>
              </div>';
          } else {
            echo '<input type="hidden" name="selDep" id="selDep" value="' . $_SESSION[PREFIJO . '_iddependencia'] . '" >';
          }
          ?>
          <!-- <div class="col">
                  <div class="form-group">
                      <label class="control-label">Programa Presupuestario</label>
                      <select name="selPP" id="selPP" class="form-control" >
                          <option value="0">--Todos--</option>
                          <?php foreach($PP as $pp){ ?>
                            <option value="<?= $pp->iIdProgramaPresupuestario ?>"><?= $pp->vProgramaPresupuestario ?></option>
                          <?php } ?>
                      </select>
                  </div>
              </div> -->
          <div class="col mb-4">
            <div class="form-group">
              <label readonly for="tipo">Tipo<span class="text-danger">*</span></label>
              <select class="form-control" name="tipo" id="tipo" onchange="showChecks();">
                <option value="0">Base de datos (.xlsx)</option>
                <!-- <option value="1">Base de datos (.pdf)</option> -->
              </select>
            </div>
          </div>
        </div>

        <!-- <div id="divChecks">
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
            <button onclick="espera(1);" type="button" class="btn waves-effect waves-light btn-block btn-danger">Generar</button>
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
    if ($("#tipo").val() == 0) generarExcel();
    if ($("#tipo").val() == 1) generarPDF();
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
      url: "<?= base_url() ?>index.php/C_rprioritarios/listar_actividades",
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
      url: "<?= base_url() ?>index.php/C_rprioritarios/comprimir_directorio",
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
      url: "<?= base_url() ?>index.php/C_rprioritarios/dependencias",
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

    if (anio == '' || anio == 0 || anio == null) {
      alerta('Por favor indique un año', 'warning');
    } else if (eje == 0) {
      alerta('Por favor indique un eje', 'warning');
    } else {
      $.ajax({
        type: "POST",
        url: "<?= base_url() ?>index.php/C_rprioritarios/generarrepo",
        data: $("#frmReport").serialize(),
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
  }
  function generarPDF() {
    var eje = parseInt($("#selEje").val());
    var dep = parseInt($("#selDep").val());
    var anio = $("#anio").val();
    var mes = $('#mes').val();

    if (anio == '' || anio == 0 || anio == null) {
      alerta('Por favor indique un año', 'warning');
    } else if (eje == 0) {
      alerta('Por favor indique un eje', 'warning');
    } else {
      $.ajax({
        type: "POST",
        url: "<?= base_url() ?>index.php/C_rprioritarios/generarrepoPDF",
        data: $("#frmReport").serialize(),
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
          console.log('Hola mundo');
          var resp = JSON.parse(r);
          if (resp.resp) {
            var url = $("#descarga").attr("href", resp.url).attr('target','_blank');
            window.open(resp.url, '_blank');
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
  }
</script>