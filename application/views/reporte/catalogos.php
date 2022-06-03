<!--titulo-->
<section>
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Catálogos del sistema</h4>
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
          <div class="col mb-4">
                <div class="form-group">
                    <label readonly for="tipo">Tipo<span class="text-danger">*</span></label>
                    <select class="form-control" name="tipo" id="tipo" onchange="showChecks();">                        
                        <option value="1">Fuentes de Financiamiento</option>
                        <option value="2">Plan Estatal de Desarrollo 2018-2024</option>
                        <option value="3">Programas Presupuestarios</option>
                        <option value="4">Sujetos afectados</option>
                        <option value="5">Unidades Básicas de Presupuestación</option>
                        <option value="6">Unidades de medida</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
              <button onclick="espera(1);" type="button" class="btn waves-effect waves-light btn-block btn-danger" style="margin-top:30px;">Descargar</button>
            </div>
        </div>

        <div class="row">
          <div class="col-md-4">                        
            <a style="cursor:pointer; color:blue; display:none;"  href="<?=base_url();?>public/reportes/actividadesBD.xlsx" id="descarga"><i class="m-r-10 mdi mdi-briefcase-download"></i>Descargar</a>
          </div>
          <div class="col-md-4"></div>
          
        </div>

      </form>
    </div>
  </form>    
</section>
<script>
  var position = 0;
  var total = 0;
  function espera(id){
    document.getElementById("descarga").style.display="none";
    generarExcel();
  }
  
  
  function generarExcel(){
    var eje = parseInt($("#selEje").val());
    var dep = parseInt($("#selDep").val());
    var anio = $("#anio").val();

  
    $.ajax({         
      type: "POST",
      url:"<?=base_url()?>index.php/C_reporte/descargar_catalogo",
      data: $("#frmReport").serialize(),
      beforeSend: function( xhr ) {
        Swal.fire({
          position: 'center',
          type: 'info',
          title: 'Estamos trabajando en ello, espere por favor',
          showConfirmButton: false,
          timer: 2000
        });
      },
      success: function(r) {
        $("#descarga").attr("href","<?=base_url();?>public/reportes/catalogos.xlsx");  
        document.getElementById("descarga").style.display="inline";
        Swal.fire({
          position: 'center',
          type: 'success',
          title: 'Su reporte se ha generado con exito',
          showConfirmButton: false,
          timer: 1500
        })  

      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {

      }
    });
    
  }
</script>