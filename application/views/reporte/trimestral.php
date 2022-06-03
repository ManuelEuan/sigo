<!-- titulo -->
<section>
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Reportes trimestrales</h4>
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
<!-- endtitulo -->

<!-- cuerpo -->
<section>
    <div class="col-12">
        <div class="card" style="padding: 2%;">            
            <h5>Filtrar por:</h5>
            <hr>
            <div class="row">
                <div class="col-md-2">
                    <label>Año<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="anio" onkeypress='return validaNumericos(event)' value="<?php  echo date('Y'); ?>">
                </div>
                <div class="col-md-2">
                <div class="form-group">
                    <label for="tri">Trimestre<span class="text-danger">*</span></label>
                    <select class="form-control" id="tri">
                      <option value="1">1er Trimestre</option>
                      <option value="2">2do Trimestre</option>
                      <option value="3">3er Trimestre</option>
                      <option value="4">4to Trimestre</option>
                    </select>
                </div>
                    
                </div>
                <!-- <div class="col-md-8">
                    <div class="form-check" style="margin-top:30px;">
                      <input class="form-check-input" type="checkbox" value="" id="inactivas">Omitir actividades marcadas como inactivas (COVID)
                    </div>
                </div> -->
            </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="eje">Eje<span class="text-danger">*</span></label>
                            <select class="form-control" id="eje" onchange="dependencia();temas();">
                                <option class="selected" value="0">Selecciona...</option>
                                <?php
                                foreach($ejes as $eje){
                                    ?>
                                        <option value="<?php echo $eje['iIdEje']; ?>"><?php echo $eje['vEje']; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                    <div class="form-group">
                    <label for="tema">Tema</label>
                            <select class="form-control" id="tema" onchange="objetivos();">
                            <option class="selected">Todos</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                    <div class="form-group">
                            <label for="obj">Objetivo</label>
                            <select class="form-control" id="obj" onchange="estrategias();">
                            <option class="selected">Todos</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                    <div class="form-group">
                            <label for="est">Estrategia</label>
                            <select class="form-control" id="est" onchange="lineas();">
                            <option class="selected">Todos</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                    <div class="form-group">
                            <label for="lin">Linea de accion</label>
                            <select class="form-control" id="lin">
                            <option class="selected">Todos</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                    <div class="form-group">
                            <label for="dep">Dependencia</label>
                            <select class="form-control" id="dep" name="dep">
                            <option class="selected">Todas</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-9">
                    <br>
                    <br>
                    <div id="b1" style="float:right;"><button type="button" class="btn waves-effect waves-light btn-block btn-danger" onclick="aviso();">Generar</button></div>
                    <div id="b2" style="float:right; display:none;"><button type="button" class="btn waves-effect waves-light btn-block btn-danger" onclick="generar();">Generar</button></div>
                    <div id="b3" style="float:right; display:none;"><button type="button" class="btn waves-effect waves-light btn-block btn-danger" onclick="generar2();">Generar</button></div>
                    <a style="cursor:pointer; color:blue; display:none;"  href="<?=base_url();?>public/reportes/trimestrales.docx" id="descarga"><i class="m-r-10 mdi mdi-briefcase-download"></i>Descargar</a>
                  </div>
                </div>
                
            
        </div>
    </div>
</section>
<script>
function dependencia(){
    var id = document.getElementById("eje").value;
    $.ajax({         
      type: "POST",
      url:"<?=base_url()?>index.php/C_reporte/dependencias",
      data: 'id='+id,
      success: function(r) { 
        if(id > 0) $("#dep").html(r);
        else $("#dep").html('<option value="0" class="selected">Todas</option>'); 
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        notie.alert({ type: 3, text: 'Ha ocurrido un error. Contacte al administrador', time: 2 });
          /*alert("Status: " + textStatus);
          alert("Error: " + errorThrown);*/

      }
    });
  }

  function temas(){
    var id = document.getElementById("eje").value;
    $.ajax({         
      type: "POST",
      url:"<?=base_url()?>index.php/C_trimestrales/temas",
      data: 'id='+id,
      success: function(r) {  
        if(id > 0) $("#tema").html(r);
        else $("#tema").html('<option value="0" class="selected">Todos</option>');

        $("#obj").html('<option value="0" class="selected">Todos</option>');
        $("#est").html('<option value="0" class="selected">Todos</option>');
        $("#lin").html('<option value="0" class="selected">Todos</option>');
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        notie.alert({ type: 3, text: 'Ha ocurrido un error. Contacte al administrador', time: 2 });
          /*alert("Status: " + textStatus);
          alert("Error: " + errorThrown);*/

      }
    });
  }

  function objetivos(){
    var id = document.getElementById("tema").value;
    $.ajax({         
      type: "POST",
      url:"<?=base_url()?>index.php/C_trimestrales/objetivos",
      data: 'id='+id,
      success: function(r) {  
        $("#obj").html(r);
        $("#est").html('<option value="0" class="selected">Todos</option>');
        $("#lin").html('<option value="0" class="selected">Todos</option>');
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        notie.alert({ type: 3, text: 'Ha ocurrido un error. Contacte al administrador', time: 2 });
          /*alert("Status: " + textStatus);
          alert("Error: " + errorThrown);*/

      }
    });
  }

  function estrategias(){
    var id = document.getElementById("obj").value;
    $.ajax({         
      type: "POST",
      url:"<?=base_url()?>index.php/C_trimestrales/estrategias",
      data: 'id='+id,
      success: function(r) {  
        $("#est").html(r);
        $("#lin").html('<option value="0" class="selected">Todos</option>');
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        notie.alert({ type: 3, text: 'Ha ocurrido un error. Contacte al administrador', time: 2 });
          /*alert("Status: " + textStatus);
          alert("Error: " + errorThrown);*/

      }
    });
  }

  function lineas(){
    var id = document.getElementById("est").value;
    $.ajax({         
      type: "POST",
      url:"<?=base_url()?>index.php/C_trimestrales/lineas",
      data: 'id='+id,
      success: function(r) {  
        $("#lin").html(r);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        notie.alert({ type: 3, text: 'Ha ocurrido un error. Contacte al administrador', time: 2 });
          /*alert("Status: " + textStatus);
          alert("Error: " + errorThrown);*/

      }
    });
  }

  function aviso(){
    var tri = document.getElementById('tri').value;
    var anio = document.getElementById("anio").value;
    var eje = document.getElementById("eje").value;

    if(anio == '' || anio == null){
      alerta('Debe ingresar el año para poder continuar','error');
    }
    else if(tri == 0 || tri == null){
      alerta('Debe seleccionar el trimestre que desea consultar','error');
      
    }else if(eje == 0 || eje == null){
      alerta('Debe seleccionar el eje que desea consultar','error');
    } else {
      Swal.fire({
        position: 'center',
        type: 'info',
        title: 'Estamos trabajando en ello, espere por favor',
        showConfirmButton: false,
        timer: 2000
      });
      generar();
    }
  }

  function generar(){
    var id = 1;
    var eje = document.getElementById("eje").value;
    var tema =document.getElementById("tema").value;
    var obj = document.getElementById("obj").value;
    var est = document.getElementById("est").value;
    var la = document.getElementById("lin").value;
    var tri = document.getElementById("tri").value;
    var anio = document.getElementById("anio").value;
    var dep = document.getElementById("dep").value;
   /*  var inac = ($('#inactivas').prop('checked')) ? 1:0; */
    
    $.ajax({         
      type: "POST",
      url:"<?=base_url()?>index.php/C_trimestrales/obtenerdatos",
      data: {
          'id':id,
          'eje': eje,
          'tema':tema,
          'obj':obj,
          'est':est,
          'la':la,
          'tri':tri,
          'anio':anio,
          'dep': dep,
          'inactivas': 0
        },
      success: function(data) {  
        var data3 = parseInt(data);
         
         if(data3 === 0){
          
            mensajeSwal('El reporte no pudo ser generado','error');
          }else{
            Swal.fire({
            position: 'center',
            type: 'success',
            title: 'Su reporte se ha generado con exito',
            showConfirmButton: false,
            timer: 1500
          })  
            document.getElementById("descarga").style.display="inline";
          }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        notie.alert({ type: 3, text: 'Ha ocurrido un error. Contacte al administrador', time: 2 });
      }
    });
  }

var anio = ''; 
function recuperar(){
    anio = document.getElementById("anio").value;
    cargar('<?= base_url(); ?>index.php/C_dash/datosdash/?an='+anio, '#datos');
}

function validaNumericos(event) {
    if(event.charCode >= 48 && event.charCode <= 57){
      return true;
     }
     Swal.fire(
        'Lo sentimos',
        'Unicamente se permiten números en este apartado',
        'error'
        )
     return false;        
}

var input=  document.getElementById('anio');
input.addEventListener('input',function(){
  if (this.value.length > 4) 
     this.value = this.value.slice(0,4); 
})
</script>