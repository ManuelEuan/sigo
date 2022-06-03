<?php 
$mes = date('n');
$trim_act1 = (in_array($mes,array(2,3,4))) ? 'active show':'';
$trim_act2 = (in_array($mes,array(5,6,7))) ? 'active show':'';
$trim_act3 = (in_array($mes,array(8,9,10))) ? 'active show':'';
$trim_act4 = (in_array($mes,array(11,12,1))) ? 'active show':'';
if($acceso < 2){
    $readonly = ', readOnly: true';
    $display = 'style="display:none;"';
} else {
    $display = $readonly = '';
}
?>
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                </div>
                <div class="col-md-2 text-right">
                    <button title="Ir al listado del PAT" class="btn waves-effect waves-light btn-outline-info" type="button" onclick="back()"><i class="mdi mdi-arrow-left"></i>Regresar</button>               
                </div>
            </div>
            <form method="POST" onsubmit="event.preventDefault();"  id="formTexto">
                <input type="hidden" name="iIdDetalleActividad" id="iIdDetalleActividad" value="<?=$iIdDetalleActividad;?>"> 
                <h3><b>Actividad:</b>&nbsp;<?=$vActividad?></h3><br>
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item"> <a class="nav-link <?=$trim_act1?>" data-toggle="tab" href="#tab1" role="tab" aria-selected="true"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">1° Trimestre</span></a> </li>
                    <li class="nav-item"> <a class="nav-link <?=$trim_act2?>" data-toggle="tab" href="#tab2" role="tab" aria-selected="false"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">2° Trimestre</span></a> </li>
                    <li class="nav-item"> <a class="nav-link <?=$trim_act3?>" data-toggle="tab" href="#tab3" role="tab" aria-selected="false"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">3° Trimestre</span></a> </li>
                    <li class="nav-item"> <a class="nav-link <?=$trim_act4?>" data-toggle="tab" href="#tab4" role="tab" aria-selected="false"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">4° Trimestre</span></a> </li>
                </ul>
                <div class="tab-content tabcontent-border">
                    <?php
                   
                    for ($i=1; $i < 5; $i++)
                    { 
                        echo '<div class="tab-pane '.${'trim_act'.$i}.'" id="tab'.$i.'" role="tabpanel">';
                        foreach ($texto as $row)
                        {
                            $id = $i.'_'.$iIdDetalleActividad.'_'.$row->iIdLineaAccion;
                    ?>
                            
                            <h1><small><?= $row->vEje ?></small></h1>
                            <h2><small><?= $row->vTema ?></small></h2>                        
                            <h3><small><?= $row->vObjetivo ?></small></h3>
                            <h4><small><?= $row->vEstrategia ?></small><h4>
                            <h5><small><?= $row->vLineaAccion ?></small><h5>
                            <div class="card-body">
                                <div class="form-group">
                                    <textarea cols="80" id="editor<?=$id?>" name="editor<?=$id?>" rows="5" data-sample="1" data-sample-short="" class="TxtEditora" required></textarea>
                                    <script>   
                                        var editor<?=$id?> = CKEDITOR.replace("editor<?=$id?>", {
                                            extraAllowedContent: "div",
                                            height: 164
                                        });
                                        CKEDITOR.instances.editor<?=$id?>.setData(`<?=$row->{'tInforme'.$i}?>`);
                                    </script>
                                </div>
                            </div>
                    <?php
                        }
                        echo '</div>';
                    }
                    ?>
                    <center>
                        <button class="btn btn-info" <?=$display;?> onclick="guardarInforme()">Guardar</button>
                    </center>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?= base_url() ?>public/assets/libs/ckeditor/ckeditor.js"></script>
<script src="<?=base_url();?>public/js/jquery.base64.min.js"></script>
<script>

    function guardarInforme() {
        var data = {"iIdDetalleActividad":<?=$iIdDetalleActividad?>};
        $(".TxtEditora").each(function(){
            data[this.name] = $.base64.encode(utf8_encode(CKEDITOR.instances[this.name].getData()));
      
        });
        $.ajax({
            type: 'POST',
            url: "C_pat/guardarInforme", //Nombre del controlador
            data: data,
            success: function(resp) {
                if (resp == '0') {
                    alerta('Los datos han sido guardados', 'success');
                } else {
                    alerta(resp, 'error');
                }
            }
        });
    }

    function utf8_encode(argString) { 
        if (argString === null || typeof argString === "undefined") {
            return "";
          }
          var string = (argString + ""); // .replace(/\r\n/g, "\n").replace(/\r/g, "\n");
          var utftext = "",
            start, end, stringl = 0;

          start = end = 0;
          stringl = string.length;
          for (var n = 0; n < stringl; n++) {
            var c1 = string.charCodeAt(n);
            var enc = null;

            if (c1 < 128) {
              end++;
            } else if (c1 > 127 && c1 < 2048) {
              enc = String.fromCharCode(
                (c1 >> 6) | 192, (c1 & 63) | 128
              );
            } else if ((c1 & 0xF800) != 0xD800) {
              enc = String.fromCharCode(
                (c1 >> 12) | 224, ((c1 >> 6) & 63) | 128, (c1 & 63) | 128
              );
            } else { // surrogate pairs
              if ((c1 & 0xFC00) != 0xD800) {
                throw new RangeError("Unmatched trail surrogate at " + n);
              }
              var c2 = string.charCodeAt(++n);
              if ((c2 & 0xFC00) != 0xDC00) {
                throw new RangeError("Unmatched lead surrogate at " + (n - 1));
              }
              c1 = ((c1 & 0x3FF) << 10) + (c2 & 0x3FF) + 0x10000;
              enc = String.fromCharCode(
                (c1 >> 18) | 240, ((c1 >> 12) & 63) | 128, ((c1 >> 6) & 63) | 128, (c1 & 63) | 128
              );
            }
            if (enc !== null) {
              if (end > start) {
                utftext += string.slice(start, end);
              }
              utftext += enc;
              start = end = n + 1;
            }
          }

          if (end > start) {
            utftext += string.slice(start, stringl);
        }
        return utftext;
    }
</script>
