<!-- titulo -->
<section>
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Avance de compromisos</h4>
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
            <div class="col-md-12">
                <h5>Filtrar por:</h5>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="eje">Eje</label>
                            <select class="form-control" id="eje" onchange="dependencia()">
                                <option class="selected" value="0">Seleccione...</option>
                                <?php
                                foreach ($ejes as $eje) {
                                    ?>
                                    <option value="<?php echo $eje['iIdEje']; ?>"><?php echo $eje['vEje']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="dep">Dependencia responsable</label>
                            <select class="form-control" id="dep">
                                <option class="selected" value="0">Seleccione...</option>
                            </select>
                        </div>
                    </div>
                </div>
                <br>
                <br>
            </div>
            <div class="col-md-12">
                <h5>A??adir en el reporte:</h5>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="comp">
                            <label class="form-check-label" for="comp">
                                Componentes
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="adju" onclick="estado3();">
                            <label class="form-check-label" for="adju">
                                Relacion de archivos adjuntos
                            </label>
                        </div>
                    </div>
                </div>
                <br>
                <br>
            </div>

            <div class="col-md-12">
                <h5>Tipo de reporte:</h5>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-check">
                            <input onclick="estado1();" class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                                Base de datos (un registro por linea)
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input onclick="estado2();" class="form-check-input" type="checkbox" value="" id="defaultCheck2">
                            <label class="form-check-label" for="defaultCheck2">
                                Filas combinadas
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="float-right">
                        <div id="b1" style="float:right;"><button type="button" id="boton" class="btn waves-effect waves-light btn-block btn-danger" onclick="valida();">Descargar reporte</button></div>
                    </div><br>
                </div>
            </div>
        </div>
    </div>

    <a style="cursor:pointer; color:blue; display:none;"  href="<?=base_url();?>public/reportes/compromisobd.xls" id="descarga1"><i class="m-r-10 mdi mdi-briefcase-download"></i>Descargar</a>
    <a style="cursor:pointer; color:blue; display:none;"  href="<?=base_url();?>public/reportes/compromisocc.xls" id="descarga2"><i class="m-r-10 mdi mdi-briefcase-download"></i>Descargar</a>
</section>




<!-- endcuerpo -->


<script>
    function dependencia() {
        var id = document.getElementById("eje").value;
        if (id == 0 || id == null) {
            $("#dep").load(" #dep");
        } else {
            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>index.php/C_reporte/dependencias",
                data: 'id=' + id,
                success: function(r) {
                    $("#dep").html(r);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    notie.alert({
                        type: 3,
                        text: 'Ha ocurrido un error. Contacte al administrador',
                        time: 2
                    });
                    /*alert("Status: " + textStatus);
                    alert("Error: " + errorThrown);*/
                }
            });
        }
    }
    function valida() {
        var id = 1;
        var eje = document.getElementById("eje").value;
        if (id == 0 || id == null) {
            
        } else {
            var dep = document.getElementById("dep").value;
            if (id == 0 || id == null) {
               
            } else {
                if ($("#comp").is(':checked')) {
                    if ($("#adju").is(':checked')) {
                        if ($("#defaultCheck1").is(':checked')) {
                            //console.log('funcion 1 bd');
                            $.ajax({
                                type: "POST",
                                url: "<?= base_url() ?>index.php/C_rcompromisos/datoscompromisoCABD",
                                data: {
                                    'id': id,
                                    'eje': eje,
                                    'dep': dep,
                                },
                                success: function(r) {
                                    var data3 = parseInt(r);
         console.log(data3);
         if(data3 === 0){
          
          Swal.fire({
  position: 'center',
  type: 'error',
  title: 'No se encontraron datos',
  showConfirmButton: false,
  timer: 1500
})  
          
         }else{
          
            document.getElementById("descarga1").click();
                                    console.log(r);
         }
                                    
                                },
                                error: function(XMLHttpRequest, textStatus, errorThrown) {
                                    notie.alert({
                                        type: 3,
                                        text: 'Ha ocurrido un error. Contacte al administrador',
                                        time: 2
                                    });
                                    /*alert("Status: " + textStatus);
                                    alert("Error: " + errorThrown);*/
                                }
                            });
                        } else {
                            if ($("#defaultCheck2").is(':checked')) {
                                $.ajax({
                                type: "POST",
                                url: "<?= base_url() ?>index.php/C_rcompromisos/celdas1",
                                data: {
                                    'id': id,
                                    'eje': eje,
                                    'dep': dep,
                                },
                                success: function(r) {
                                    var data3 = parseInt(r);
         console.log(data3);
         if(data3 === 0){
          
          Swal.fire({
  position: 'center',
  type: 'error',
  title: 'No se encontraron datos',
  showConfirmButton: false,
  timer: 1500
})  
          
         }else{
          
            document.getElementById("descarga2").click();
                                    console.log(r);
         }
                                },
                                error: function(XMLHttpRequest, textStatus, errorThrown) {
                                    notie.alert({
                                        type: 3,
                                        text: 'Ha ocurrido un error. Contacte al administrador',
                                        time: 2
                                    });
                                    /*alert("Status: " + textStatus);
                                    alert("Error: " + errorThrown);*/
                                }
                            });
                            } else {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Error',
                                    text: 'Seleccione el tipo de reporte que desea'
                                })
                            }
                        }
                    } else {
                        if ($("#defaultCheck1").is(':checked')) {
                            //console.log('funcion 3 bd');
                            $.ajax({
                                type: "POST",
                                url: "<?= base_url() ?>index.php/C_rcompromisos/datoscompromisoSCBD",
                                data: {
                                    'id': id,
                                    'eje': eje,
                                    'dep': dep,
                                },
                                success: function(r) {
                                    var data3 = parseInt(r);
         console.log(data3);
         if(data3 === 0){
          
          Swal.fire({
  position: 'center',
  type: 'error',
  title: 'No se encontraron datos',
  showConfirmButton: false,
  timer: 1500
})  
          
         }else{
          
            document.getElementById("descarga1").click();
                                    console.log(r);
         }
                                },
                                error: function(XMLHttpRequest, textStatus, errorThrown) {
                                    notie.alert({
                                        type: 3,
                                        text: 'Ha ocurrido un error. Contacte al administrador',
                                        time: 2
                                    });
                                    /*alert("Status: " + textStatus);
                                    alert("Error: " + errorThrown);*/
                                }
                            });
                        } else {
                            if ($("#defaultCheck2").is(':checked')) {
                                $.ajax({
                                type: "POST",
                                url: "<?= base_url() ?>index.php/C_rcompromisos/celdas2",
                                data: {
                                    'id': id,
                                    'eje': eje,
                                    'dep': dep,
                                },
                                success: function(r) {
                                    var data3 = parseInt(r);
         console.log(data3);
         if(data3 === 0){
          
          Swal.fire({
  position: 'center',
  type: 'error',
  title: 'No se encontraron datos',
  showConfirmButton: false,
  timer: 1500
})  
          
         }else{
          
            document.getElementById("descarga2").click();
                                    console.log(r);
         }
                                },
                                error: function(XMLHttpRequest, textStatus, errorThrown) {
                                    notie.alert({
                                        type: 3,
                                        text: 'Ha ocurrido un error. Contacte al administrador',
                                        time: 2
                                    });
                                    /*alert("Status: " + textStatus);
                                    alert("Error: " + errorThrown);*/
                                }
                            });
                            } else {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Error',
                                    text: 'Seleccione el tipo de reporte que desea'
                                })
                            }
                        }
                    }
                } else {
                    if ($("#adju").is(':checked')) {
                        if ($("#defaultCheck1").is(':checked')) {
                            //console.log('funcion 5 bd');
                            $.ajax({
                                type: "POST",
                                url: "<?= base_url() ?>index.php/C_rcompromisos/datoscompromisoCABD",
                                data: {
                                    'id': id,
                                    'eje': eje,
                                    'dep': dep,
                                },
                                success: function(r) {
                                    document.getElementById("descarga1").click();
                                    console.log(r);
                                },
                                error: function(XMLHttpRequest, textStatus, errorThrown) {
                                    notie.alert({
                                        type: 3,
                                        text: 'Ha ocurrido un error. Contacte al administrador',
                                        time: 2
                                    });
                                    /*alert("Status: " + textStatus);
                                    alert("Error: " + errorThrown);*/
                                }
                            });
                        } else {
                            if ($("#defaultCheck2").is(':checked')) {
                                console.log('funcion 6 cc');    
                            } else {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Error',
                                    text: 'Seleccione el tipo de reporte que desea'
                                })
                            }
                        }
                    } else {
                        if ($("#defaultCheck1").is(':checked')) {
                            //console.log('funcion 7 bd');
                            $.ajax({
                                type: "POST",
                                url: "<?= base_url() ?>index.php/C_rcompromisos/datoscompromisoSSBD",
                                data: {
                                    'id': id,
                                    'eje': eje,
                                    'dep': dep,
                                },
                                success: function(r) {
                                    document.getElementById("descarga1").click();
                                    console.log(r);
                                },
                                error: function(XMLHttpRequest, textStatus, errorThrown) {
                                    notie.alert({
                                        type: 3,
                                        text: 'Ha ocurrido un error. Contacte al administrador',
                                        time: 2
                                    });
                                    /*alert("Status: " + textStatus);
                                    alert("Error: " + errorThrown);*/
                                }
                            });
                        } else {
                            if ($("#defaultCheck2").is(':checked')) {
                                $.ajax({
                                type: "POST",
                                url: "<?= base_url() ?>index.php/C_rcompromisos/celdas3",
                                data: {
                                    'id': id,
                                    'eje': eje,
                                    'dep': dep,
                                },
                                success: function(r) {
                                    var data3 = parseInt(r);
         console.log(data3);
         if(data3 === 0){
          
          Swal.fire({
  position: 'center',
  type: 'error',
  title: 'No se encontraron datos',
  showConfirmButton: false,
  timer: 1500
})  
          
         }else{
          
            document.getElementById("descarga2").click();
                                    console.log(r);
         }
                                },
                                error: function(XMLHttpRequest, textStatus, errorThrown) {
                                    notie.alert({
                                        type: 3,
                                        text: 'Ha ocurrido un error. Contacte al administrador',
                                        time: 2
                                    });
                                    /*alert("Status: " + textStatus);
                                    alert("Error: " + errorThrown);*/
                                }
                            });
                            } else {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Error',
                                    text: 'Seleccione el tipo de reporte que desea'
                                })
                            }
                        }
                    }
                }
            }
        }
    }
    function estado1() {
        if ($("#defaultCheck1").is(':checked')) {
            if ($("#defaultCheck2").is(':checked')) {
                document.getElementById("defaultCheck2").checked = false;
            }
        }
    }
    function estado2() {
        if ($("#defaultCheck2").is(':checked')) {
            if ($("#defaultCheck1").is(':checked')) {
                document.getElementById("defaultCheck1").checked = false;
            }
        }
    }
    function estado3() {
        if ($("#adju").is(':checked')) {
            if ($("#comp").not(':checked')) {
                document.getElementById("comp").checked = true;
            }
        }
    }
    function imprimir($f) {
        if (f == 1) {
        } else if (f == 2) {
        } else if (f == 3) {
        } else if (f == 4) {
        } else if (f == 5) {
        } else if (f == 6) {
        } else if (f == 7) {
            
            document.getElementById("descarga1").click();
        } else if (f == 8) {
        }
    }
    
</script>