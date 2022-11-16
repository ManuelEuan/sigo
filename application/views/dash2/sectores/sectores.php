<style type="text/css">
    .circle img {              
        border-radius: 50%;
        width:50px;
        height:50px;
    }
    #contenido {
        max-width: 1500px !important;
    }

    h4 {
        font-size: 14px;
    }
</style>
<section>

    <div class="" style="background-color: #f2f4f5;">
    <h3 class="font-weight-bold text-center">AVANCE PICASO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>
        <div class="row">
            <div class="col-4 mb-4">
                <hr style="border:6px; background-color:#000080 !important;">
                <div class="row">
                    <div class="col-12 text-center"><h1 style="font-weight:700;color:#000080;" id="txtAutizado">$0</h1>
                        <h5 style="font-weight:500;">Autorizados</h5></div>
                </div>
            </div>
            <div class="col-4 mb-4">
                <hr style="border:6px; background-color:#000080 !important;">
                <div class="row">
                    <div class="col-12 text-center"><h1 style="font-weight:700;color:#000080;" id="txtGastado">$0</h1>
                        <h5 style="font-weight:500;">Gastados</h5></div>
                </div>
            </div>
            <div class="col-4 mb-4">
                <hr style="border:6px; background-color:#000080 !important;">
                <div class="row">
                    <div class="col-12 text-center"><h1 style="font-weight:700;color:#000080;" id="txtPorcentaje">%</h1>
                        <h5 style="font-weight:500;">%</h5></div>
                </div>
            </div>
        </div>


        <h3 class="font-weight-bold text-center">AVANCE POR EJE RECTOR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   <a  ><button class="btn btn-info" onclick="downloadPDF()">PDF</button></a></h3>
        <!--<div class="row">
            <div class="col-4 mb-4">
                <hr style="border:6px; background-color:#000080 !important;">
                <div class="row">
                    <div class="col-8 text-center"><h1 style="font-weight:700;color:#000080;" class="count"><?=Decimal($pat_totales);?></h1>
                        <h5 style="font-weight:500;">Planes  de trabajooo9</h5></div>
                    <div class="col-4"><h1 style="color:#000080;"><i class="fas fa-book fa-lg"></i></h1></div>
                </div>
            </div>

            <div class="col-4 mb-4">
                <hr style="border:6px; background-color:#000080 !important;">
                <div class="row">
                    <div class="col-8 text-center"><h1 style="font-weight:700;color:#000080;" class="count"><?=Decimal($act_totales);?></h1>
                        <h5 style="font-weight:500;">Actividades</h5></div>
                    <div class="col-4"><h1 style="color:#000080;"><i class="fas fa-pen-square fa-lg"></i></h1></div>
                </div>
            </div>

            <div class="col-4 mb-4">
                <hr style="border:6px; background-color:#000080 !important;">
                <div class="row">
                    <div class="col-8 text-center"><h1 style="font-weight:700;color:#000080;" class="count"><?=$ent_totales?></h1>
                        <h5 style="font-weight:500;">Resultados</h5></div>
                    <div class="col-4"><h1 style="color:#000080;"><i class="fas fa-check-circle fa-lg"></i></h1></div>
                </div>
            </div>
        </div>-->

        <div class="row">
            <div class="col-4 mb-4">
                <hr style="border:6px; background-color:#000080 !important;">
                <div class="row">
                    <div class="col-12 text-center"><h1 style="font-weight:700;color:#000080;">$<?=number_format($apro_totales, 2)?></h1>
                        <h5 style="font-weight:500;">Autorizados</h5></div>
                </div>
            </div>
            <div class="col-4 mb-4">
                <hr style="border:6px; background-color:#000080 !important;">
                <div class="row">
                    <div class="col-12 text-center"><h1 style="font-weight:700;color:#000080;">$<?=Decimal($ejer_totales)?></h1>
                        <h5 style="font-weight:500;">Gastados</h5></div>
                </div>
            </div>
            <div class="col-4 mb-4">
                <hr style="border:6px; background-color:#000080 !important;">
                <div class="row">
                    <div class="col-12 text-center"><h1 style="font-weight:700;color:#000080;"><?=$papro_totales?> %</h1>
                        <h5 style="font-weight:500;">%</h5></div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <?php
            $obras = false;
            foreach ($cifras as $key => $value)
            { 
                //var_dump($value);

                $fontsize = (strlen($value['presupuesto']) > 12) ? 'font-size:12px;':'';
                if($obras && $key == 9)
                { 
                    //$avance = ($av_obras->numobras > 0) ? round($av_obras->avancefisico / $av_obras->numobras):0;
                    //$ejercido = DecimalMoneda(($av_obras->avancefinanciero * $pre_obras->presupuestoobra) / 100);
                    ?>
                    <div class="col-xs-12 col-md-4">
                        <div onclick="mostrarTableroObras(<?=$anio?>);" class="card d-flex" style="cursor: pointer; min-height: 200px; !important;">
                            <div class="card-body">
                         
                                <div class="row">
                                    <div class="col-1 circle"><img src="<?=base_url().$value['icono']?>" width="200px;" style="background:#<?=$value['color']?>;"></div>
                                    <div class="col-1"></div>
                                    <div class="col-10"><h5 style="color:#<?=$d->vColorDesca?>;font-weight: bold;" ><a style="cursor: pointer"><?=$value['eje']?></a></h5></div>                                
                                </div>
                                <div class="row">
                                    <div class="col-2"></div>
                                    <div class="col-6 mb-0"><div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="background-color:#<?=$value['color']?> !important; width:<?=$avance?>%;height: 8px;" aria-valuenow="<?=$avance?>" aria-valuemin="0" aria-valuemax="100"><span style="font-size:10px;"></span></div></div>
                                    <div class="col-4"><h3 class="font-light" style="font-weight:700"><span class="count"><?=$avance?></span>%</h3></div>
                                    
                                </div>
                                
                                <div class="row">
                                    <div class="col-2"></div>
                                    <div class="col-10"><hr style="background-color:#000000;"></div>
                                </div>
                                
                                <div class="row text-center mb-2">
                                    <div class="col-12 text-center">
                                        <h4 class="m-b-0" style="font-weight:700"><?=$av_obras->numobras?></h4>
                                        <span class="font-14">Obras</span></div>
                                   
                                </div>

                                <div class="row mb-2">
                                     <div class="col-4 text-center mb-2">
                                        <h4 class="m-b-0" style="font-weight:700">$<?=$autorizado?> </h4>
                                        <span class="font-14">Autorizado</span>
                                    </div>
                                    <div class="col-4 text-center mb-2">
                                        <h4 class="m-b-0" style="font-weight:700">$<?=$ejercido?> </h4>
                                        <span class="font-14">Ejercido</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php 
                }
                else
                {   ?>
                    <div class="col-xs-12 col-md-4">

                        <div onclick="listarDeps(<?=$key?>, '<?=preg_replace('[\n|\r|\n\r]', '', $value['eje']);?>');" class="card d-flex" style="cursor: pointer; min-height: 200px; !important;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-1 circle"><img src="<?=base_url().$value['icono']?>" width="200px;" ></div>
                                    <div class="col-1"></div>
                                    <div class="col-10"><h5 style="color:#<?=$value['color']?>;font-weight: bold;" ><a style="cursor: pointer"><?=$value['eje']?></a></h5></div>                                
                                </div>
                                <div class="row">
                                    <div class="col-2"></div>
                                    <div class="col-6 mb-0"><div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="background-color:#<?=$value['color']?> !important; width:0%;height: 8px;" aria-valuenow="<?=$value['avance']?>" aria-valuemin="0" aria-valuemax="100"><span style="font-size:10px;"></span></div></div>
                                    <div class="col-4"><h3 class="font-light" style="font-weight:700"><span class="count"><?=$value['avance']?></span>%</h3></div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-2"></div>
                                    <div class="col-10"><hr style="background-color:#000000;"></div>
                                </div>

                                
                                <div class="row text-center mb-2">
                                    <div class="col-4">
                                        <h4 class="mb-0" style="font-weight:700"><?=$value['pat']?> </h4>
                                        <span class="font-14">Dependencias y Entidades</span>
                                    </div>
                                    
                                    <div class="col-4"><h4 class="m-b-0" style="font-weight:700"><?=$value['actividades']?></h4>
                                        <span class="font-14">Acciones</span>
                                    </div>
                                    <div class="col-4"><h4 class="m-b-0" style="font-weight:700"><?=$value['entregables']?> </h4>
                                        <span class="font-14">Indicadores</span>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                     <div class="col-4 text-center mb-2">
                                        <h4 class="m-b-0" style="font-weight:700">$ <?=Decimal($value['autorizado'])?> </h4>
                                        <span class="font-14">Autorizado</span>
                                    </div>
                                    <div class="col-4 text-center mb-2">
                                        <h4 class="m-b-0" style="font-weight:700">$ <?=Decimal($value['ejercido'])?> </h4>
                                        <span class="font-14">Gastado</span>
                                    </div>
                                    <div class="col-4 text-center mb-2">
                                        <h4 class="m-b-0" style="font-weight:700"><?=$value['porcentajeAutorizado']?> %</h4>
                                        <span class="font-14">% Gastado</span>
                                    </div>
                                </div> 
                                
                                <!-- <div class="row mb-2">
                                     <div class="col-4 text-center mb-2">
                                        <h4 class="m-b-0" style="font-weight:700"><?=number_format($value['hombres'], 0)?> </h4>
                                        <span class="font-14">Hombres</span>
                                    </div>
                                    <div class="col-4 text-center mb-2">
                                        <h4 class="m-b-0" style="font-weight:700"><?=number_format($value['mujeres'], 0)?> </h4>
                                        <span class="font-14">Mujeres</span>
                                    </div>
                                    <div class="col-4 text-center mb-2">
                                        <h4 class="m-b-0" style="font-weight:700"><?=number_format(intval($value['hombres']) + intval($value['mujeres']), 0)?></h4>
                                        <span class="font-14">Totales</span>
                                    </div>
                                </div>   -->
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>
<hr>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/polyfills.umd.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/mapacalor.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

        obtenerPOAS();
        $('.count').each(function () {
            $(this).prop('Counter',0).animate({
                Counter: $(this).text()
            }, {
                duration: 4000,
                easing: 'swing',
                step: function (now) {
                    $(this).text(number_format(Math.ceil(now)));
                }
            });
        });

        $('.progress-bar').each(function() {
            $(this).delay(1000).queue(function () {
                $(this).css('width', $(this).attr('aria-valuenow')+'%');
            });
        });
    });

    function obtenerPOAS(){
                $.ajax({
                    type: "POST",
                    url: "<?= base_url() ?>C_pat/getCatalogoPOA",
                    success: function(resp) {
                        var sumaMyUAprobado = 0;
                        var sumaMyUPagado = 0;
                        var totalAprobado = 0;
                        var totalPagado = 0;
                        
                        var jsonParseado = JSON.parse(resp)
                        var filteredMunicipios = getFilteredByKey(jsonParseado.datos, "dependenciaEjecutora", "MUNICIPIO");
                        var filteredUniversidad = getFilteredByKey(jsonParseado.datos, "dependenciaEjecutora", "UNIVERSIDAD");

                        //Valor Total
                        var totalJsonAprobado = 0;
                        var totalJsonPagado = 0;

                        for(let i = 0; i <= jsonParseado.datos.length; i++){
                            if(jsonParseado.datos[i]?.aprobado != null){
                                totalJsonAprobado = totalJsonAprobado + jsonParseado.datos[i]?.aprobado;
                            }
                            if(jsonParseado.datos[i]?.pagado != null){
                                totalJsonPagado = totalJsonPagado + jsonParseado.datos[i]?.pagado;
                            }
                        }
                        
                        // Valor Municipios
                        var totalMunicipiosAprobado = 0;
                        var totalMunicipiosPagado = 0;
                        for(let i = 0; i <= filteredMunicipios.length; i++){
                            if(filteredMunicipios[i]?.aprobado != null){
                                totalMunicipiosAprobado = totalMunicipiosAprobado + filteredMunicipios[i]?.aprobado;
                            }
                            if(filteredMunicipios[i]?.pagado != null){
                                totalMunicipiosPagado = totalMunicipiosPagado + filteredMunicipios[i]?.pagado;
                            }
                        }
                        //Universidad
                        var totalUniversidadAprobado = 0;
                        var totalUniversidadPagado = 0;
                        for(let i = 0; i <= filteredUniversidad.length; i++){
                            if(filteredUniversidad[i]?.aprobado != null){
                                totalUniversidadAprobado = totalUniversidadAprobado + filteredUniversidad[i]?.aprobado;
                            }
                            if(filteredUniversidad[i]?.pagado != null){
                                totalUniversidadPagado = totalUniversidadPagado + filteredUniversidad[i]?.pagado;
                            }
                        }

                        //Operacion
                        sumaMyUAprobado = totalMunicipiosAprobado + totalUniversidadAprobado;
                        sumaMyUPagado =  totalMunicipiosPagado + totalUniversidadPagado;

                        //Resta total
                        totalAprobado = (totalJsonAprobado - sumaMyUAprobado)
                        totalPagado = (totalJsonPagado - sumaMyUPagado)
                        
                        var porcentaje = (totalPagado/totalAprobado)*100;
                        
                        document.getElementById("txtAutizado").innerHTML = "$" + number_format(totalAprobado, 2);
                        document.getElementById("txtGastado").innerHTML = "$" + number_format(totalPagado, 2);
                        document.getElementById("txtPorcentaje").innerHTML = number_format(porcentaje, 2) + "%";
                        
                    },
                    error: function(XMLHHttRequest, textStatus, errorThrown) {
                        console.log(XMLHHttRequest);
                    }
                });

    }

    function isNumber(n) {
        'use strict';
        n = n.replace(/\./g, '').replace(',', '.');
        return !isNaN(parseFloat(n)) && isFinite(n);
    }


    function getFilteredByKey(array, key, value) {
        return array.filter(function(e) {
            var json = JSON.parse(e[key].includes(value))
            return json;
        });
    }

    function downloadPDF(){
            html2canvas(document.body, {
                            // Establecer en verdadero para usar la imagen de red, de lo contrario, use la imagen de ruta absoluta
              onrendered:function(canvas) {
                  debugger;
                  window.jsPDF = window.jspdf.jsPDF;
                  var contentWidth = canvas.width;
                  var contentHeight = canvas.height;

                                     // Una página de pdf muestra la altura del lienzo generado por la página html;
                  var pageHeight = contentWidth / 592.28 * 841.89;
                                     // La altura de la página html del pdf no se genera
                  var leftHeight = contentHeight;
                                     // desplazamiento de página pdf
                  var position = 0;
                                     // El tamaño del papel a4 [595.28,841.89], el ancho y el alto de la imagen en el pdf generado por el lienzo en la página html
                  var imgWidth = 595.28;
                  var imgHeight = 592.28/contentWidth * contentHeight;

                  var pageData = canvas.toDataURL('', 2.0);

                  var pdf = new jsPDF('', 'pt', 'b4');

                                     // Hay dos alturas que deben distinguirse, una es la altura real de la página html y la altura de la página del pdf generado (841.89)
                                     // Cuando el contenido no excede el rango mostrado en una página de pdf, no se requiere paginación
                  if (leftHeight < pageHeight) {
                      pdf.addImage(pageData, 'JPEG', 0, 0, imgWidth, imgHeight );
                  } else {
                      while(leftHeight > 0) {
                          pdf.addImage(pageData, 'JPEG', 0, position, imgWidth, imgHeight)
                          leftHeight -= pageHeight;
                          position -= 841.89;
                                                     // Evita agregar páginas en blanco
                          if(leftHeight > 0) {
                              pdf.addPage();
                          }
                      }
                  }
                  pdf.save('Dashboard.pdf');
              }
          });
        }
    function number_format(amount, decimals) {

        amount += ''; // por si pasan un numero en vez de un string
        amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

        decimals = decimals || 0; // por si la variable no fue fue pasada

        // si no es un numero o es igual a cero retorno el mismo cero
        if (isNaN(amount) || amount === 0) 
            return parseFloat(0).toFixed(decimals);

        // si es mayor o menor que cero retorno el valor formateado como numero
        amount = '' + amount.toFixed(decimals);

        var amount_parts = amount.split('.'),
            regexp = /(\d+)(\d{3})/;

        while (regexp.test(amount_parts[0]))
            amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

        return amount_parts.join('.');
    }
   
    function verEje(id){
        cargar('<?=base_url();?>index.php/C_dash/ficha_eje','#datos','POST','id='+id+'&anio=<?=$anio?>');
    }

    function listarDeps(eje, name){
        var variables = {
            anio: <?=$anio?>,
            eje: eje,
            name: name,
        }
        cargar('<?= base_url(); ?>index.php/C_dash/deps_anio_eje', '#datos', 'POST', variables);
    }

    function mostrarTableroObras(anio){
        var variables = {
            anio: anio
        }
        cargar('<?= base_url(); ?>index.php/C_dash/mostrar_tablero_obras', '#datos', 'POST', variables);
    }
</script>