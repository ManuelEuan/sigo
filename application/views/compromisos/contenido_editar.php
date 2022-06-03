<link rel="stylesheet" href="<?= base_url(); ?>/assets/imagenes/vendor/jquery/jquery-ui/jquery-ui.css">
<script src="<?= base_url(); ?>/assets/imagenes/vendor/jquery/jquery-ui/jquery-ui.js" type="text/javascript"></script>


<script>
    $("#buscador_compromiso").hide();
</script>
<style type="text/css">
    .padre {
        /* IMPORTANTE */
        text-align: center;
    }

    .hijo {

        padding: 10px;
        margin: 10px; /* IMPORTANTE */
        display: inline-block;
    }

    body.dragging, body.dragging * {
        cursor: move !important;
    }

    div.drag img {
        margin: 5px;
        -moz-transition: width 0.3s, height 0.3s;
        -webkit-transition: width 0.3s, height 0.3s;
        -o-transition: width 0.3s, height 0.3s;
        transition: width 0.3s, height 0.3s;
    }

    .dragged {
        position: absolute;
        opacity: 0.5;
        z-index: 2000;
    }

    div.drag .placeholder:before {
        position: absolute;
    }

    div.drag .placeholder {
        vertical-align: middle;
        display: inline-block;
        background-color: #CCC;
        width: 250px;
        height: 160px;
        position: relative;
        border: 2px dashed #000;
        line-height: 1.428571429;
        background-color: #fff;
        border-radius: 4px;
        padding: 4px;

    }
    /*image gallery*/
    label.galeria:before {
        content: url("https://cdn1.iconfinder.com/data/icons/windows8_icons_iconpharm/26/unchecked_checkbox.png");
        position: absolute;
        z-index: 100;
    }
    :checked+label.galeria:before {
        content: url("https://cdn1.iconfinder.com/data/icons/windows8_icons_iconpharm/26/checked_checkbox.png");
    }
    input[type=checkbox].check_hidden{
        display: none;
    }
    /*pure cosmetics:*/
    img.imagen {
        width: 150px;
        height: 150px;
    }
    label.galeria {
        margin: 10px;
    }
    .item-drag{

    }
    .img-thumbnail{
        display:inline-block;


    }
    .img-thumbnail label{
        display:inline-block;
        position:relative;

    }
    .img-thumbnail input{
        position:absolute;
        top:5px;
        left:5px;
    }


</style>
<style type="text/css">

    img.pequeña {
        width: 250px;
        height: 160px;
    }

</style>
<style>
    .demoDrag {
    }

    #image-container {
        border: 3px dashed #666;
    }

</style>

<?php
if ($datos_m[0]["iRevisado"] > 0) {
    $checkedrevisado = 'checked="checked"';
} else {
    $checkedrevisado = "";

}
$check = ($permisorevision > 0 && $periodorevision > 0) ? '<label><input type="checkbox" value="" class="form-control" ' . $checkedrevisado . ' id="iRevisadoc" onclick="revisadoCheck()"> Revisado</label>' : '';
$periodoactivo = ($periodorevision == 0) ? '' : 'disabled="disabled"';


?>
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-10">
                            <h4 class="card-title">Editar compromiso </h4>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-light" type="submit" onclick="listar_compromiso_busqueda()"><i
                                        class="mdi mdi-arrow-left">Regresar</i></button>
                        </div>
                    </div>

                    <ul class="nav nav-tabs md-tabs" id="myTabMD" role="tablist">
                        <li class="nav-item">
                            <a onclick="cargar_nueva_Evidencia(<?= $periodoactivo ?>)" class="nav-link active" id="home-tab-md" data-toggle="tab" href="#home-md" role="tab"
                               aria-controls="home-md" aria-selected="true">Información general</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab-md" data-toggle="tab" href="#profile-md" role="tab"
                               aria-controls="profile-md" aria-selected="false">Componentes del compromiso</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" id="contact-tab-md" data-toggle="tab" href="#contact-md" role="tab"
							aria-controls="contact-md" aria-selected="false">Contact</a>
						</li> -->

                    </ul>


                    <div class="tab-content card pt-5" id="myTabContentMD">
                        <div class="tab-pane fade show active" id="home-md" role="tabpanel"
                             aria-labelledby="home-tab-md">
                            <div class="row">
                                <!-- <div class="col-md-12">
                                    <h4 class="card-title">Editar compromiso</h4>
								</div> -->
                                <!-- <div class="col-md-12"><br></div> -->
                                <!-- contenido -->


                                <form class="needs-validation was-validated" onsubmit="guardarCompromiso(this,event);"
                                      id="frmCompromiso">
                                    <div class="row">
                                        <div class="col-md-6"></div>
                                        <div class="col-md-2"><?= $check ?></div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-success btn-block"
                                                    onclick="ActualizarComprimiso()" <?= $periodoactivo ?>>Guardar
                                            </button>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-danger btn-block"
                                                    onclick="listar_compromiso_busqueda()">Cancelar
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div>
                                                <label class="form-inline">Numero:</label>
                                                <input class="form-control" name="iNumero" id="iNumero" type="number"
                                                       maxlength="4"
                                                       value="<?= $datos_m[0]["iNumero"] ?>"
                                                       required <?= $periodoactivo ?> />
                                                <div class="invalid-feedback">
                                                    Este campo no puede estar vacio.
                                                </div>
                                            </div>

                                            <div>
                                                <label class="form-inline">Nombre corto:</label>
                                                <input type="text" class="form-control" name="vNombreCorto"
                                                       id="vNombreCorto"
                                                       value="<?= $datos_m[0]["vNombreCorto"] ?>"
                                                       required <?= $periodoactivo ?> />
                                                <div class="invalid-feedback">
                                                    Este campo no puede estar vacio.
                                                </div>
                                            </div>

                                            <div>
                                                <label class="form-inline">Nombre completo:</label>
                                                <textarea class="form-control" name="vCompromiso" id="vCompromiso"
                                                          required <?= $periodoactivo ?>><?= $datos_m[0]["vCompromiso"] ?></textarea>
                                                <div class="invalid-feedback">
                                                    Este campo no puede estar vacio.
                                                </div>
                                            </div>
                                            <div>
                                                <label class="form-inline">Descripción:</label>
                                                <textarea class="form-control" name="vDescripcion" id="vDescripcion"
                                                          required <?= $periodoactivo ?>><?= $datos_m[0]["vDescripcion"] ?></textarea>
                                                <div class="invalid-feedback">
                                                    Este campo no puede estar vacio.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label class="form-inline">Principales Acciones</label>
                                            <div class="form-group">
												<textarea cols="80" id="editor1" name="editor1" rows="5" data-sample="1"
                                                          data-sample-short=""
                                                          required <?= $periodoactivo ?>></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-inline">Eje:</label>
                                            <select class="form-control" onchange="buscarPolitica()"
                                                    id="cboEje" <?= $periodoactivo ?>>
                                                <option value="0">Todos</option>
                                                <?= $options_ejes; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-inline">Política pública:</label>
                                            <select class="form-control" name="iIdTema"
                                                    id="iIdTema" <?= $periodoactivo ?> onchange="status_compromiso()">
												<option value="0">Seleccione</option>
                                            <?= $politica_publica; ?>
                                            </select>
                                            <div class="invalid-feedback" id="status_politica_publica_text"
                                                 style="display: none">
                                                Este campo no puede estar vacio.
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-inline">Estatus del compromiso:</label>
                                            <select class="form-control" name="iEstatus"
                                                    id="iEstatus" <?= $periodoactivo ?> onchange="status_compromiso()">
                                                <option value="0">Seleccione</option>
                                                <?= $estatus; ?>
                                            </select>
                                            <div class="invalid-feedback" id="status_compromiso_text"
                                                 style="display: none">
                                                Este campo no puede estar vacio.
                                            </div>
                                        </div>

                                        <div class="col-md-6 ">
                                            <label class="form-inline">Dependencia responsable:</label>
                                            <select class="form-control" name="iIdDependencia"
                                                    id="iIdDependencia" <?= $periodoactivo ?>
                                                    onchange="status_compromiso()">
                                                <option value="0">Seleccione</option>
                                                <?= $dependencias; ?>
                                            </select>
                                            <div class="invalid-feedback" id="status_responsable_text"
                                                 style="display: none">
                                                Este campo no puede estar vacio.
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-inline">Dependencia corresponsable:</label>
                                            <select class="form-control js-example-basic-multiple" multiple="multiple"
                                                    id="iIdDependenciaCble" <?= $periodoactivo ?>>
                                                <?= $dependencias; ?>
                                            </select>
                                        </div>

                                    </div>
                                </form>


                            </div>
                            </br>
                            <section>

                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12" id="cargar_galeria">
                                            <?php
                                            $style;
                                            $aviso;

                                            if ($periodoactivo != 'disabled="disabled"'){
                                                $style="none";
                                                $aviso="<h3 style=\"text-align: center !important;\" class=\"card-title\">Para ver la evidencia fotográfica, el período de revisión debe estar activo</h3>";
                                            }
                                            else{
                                               $style="";
                                               $aviso="";
                                            }
                                            $galeria;//este variable contiene las fotos
                                            $cont = 1;
                                            if ($galeria != null) {

                                                echo '<h3 style="text-align: center !important;" class="card-title">Evidencia fotográfica</h3>
                                                      '.$aviso.'
                                                    <h5 style="text-align: center !important;display:'.$style.';" class="card-title">Arraste para poner un orden y presione para seleccionar la foto inicio (orden de izquierda a derecha)</h5>';
                                                echo '<div style="display:'.$style.';"  class="drag padre" id="image-container">';
                                                foreach ($galeria as $key) {
                                                    $checked=null;
                                                    if($key['iFotoInicio'] == 1){
                                                        $checked="checked=\"checked\"";
                                                    }else{
                                                        $checked="";
                                                    }
                                                    echo '<div  id="foto_'.$key['iIdEvidencia'].'" rel="'.$key['iIdEvidencia'].'" class="img-thumbnail ">
                                                            ';
                                                    echo ' <input class="check_hidden" type="checkbox" '.$checked.' id="myCheckbox'.$cont.'" />
                                                              <label style="cursor:pointer" class="galeria" for="myCheckbox'.$cont.'">
                                                             
                                                                           <img   style="height: 160px;width:250px;" class="pequeña hijo imagen" rel="' . $key['iIdEvidencia'] . '" src=" '.base_url().'/archivos/documentosImages/'. $key['vEvidencia'] . '" alt="' . $key['vEvidencia'] . '">
                                                                           
                                                            </label>
                                                                        
                                                              
                                                                  
                                                           ';
                                                    $cont++;
                                                    echo '</div>';
                                                }
                                                echo ' </div>';
                                                echo ' <p style="visibility:hidden" id="output">1,2,3</p>
                                                    <div style="display:'.$style.';" id="submit-container">
                                                        <input onclick="guardar_posiciones()" type="button" class="btn btn-success" value="Guardar" />
                                                    </div>';
                                            } else {
                                                echo '
                                                    <h2 style="text-align: center !important;" class="card-title">Evidencia fotográfica</h2><h3 style="text-align: center !important;" class="card-title">Sin evidencia fotográfica disponible</h3>';
                                            }

                                            ?>
                                        </div>
                                        <input type="text" value="<?=$idcompromiso?>" id="id_comp" style="display: none">
                                    </div>
                                </div>
                            </section>

                        </div>
                        <!-- modulo para las imagenas -->

                        <div class="tab-pane fade" id="profile-md" role="tabpanel" aria-labelledby="profile-tab-md">
                            <!-- COMPONENTES -->
                            <nav>
                                <div class="nav nav-tabs md-tabs" id="nav-tab" role="tablist">

                                    <?php
                                    $class = "";
                                    $select = "";
                                    $active = "";
                                    $validador = 0;
                                    foreach ($datosTabla as $c) {
                                        if ($validador == 0) {
                                            $class = "nav-item nav-link active";
                                            $select = "true";
                                            $active = "show active";

                                        } else {
                                            $class = "nav-item nav-link";
                                            $select = "false";
                                            $active = "";
                                        }
                                        echo '    <a class="' . $class . '" id="nav-' . $c->iIdComponente . '-tab" data-toggle="tab" href="#nav-' . $c->iIdComponente . '" role="tab"
        aria-controls="nav-' . $c->iIdComponente . '" aria-selected="' . $select . '">' . $c->vComponente . '</a>';
                                        $validador++;
                                    }
                                    ?>

                                </div>
                            </nav>

                            <div class="tab-content pt-5" id="nav-tabContent">
                                <?php
                                $validadorA = 0;


                                foreach ($datosTabla as $c) {
                                    if ($validadorA == 0) {
                                        $active = "show active";
                                    } else {
                                        $active = "";
                                    }
                                    echo '<div class="tab-pane fade ' . $active . '" id="nav-' . $c->iIdComponente . '" role="tabpanel" aria-labelledby="nav-' . $c->iIdComponente . '-tab">';
                                    // INICIO

                                    echo '<div class="row">
    <div class="col-md-12"><h4>Nombre del componente: ' . $c->vComponente . '</h4></div>
    <div class="col-md-12"><p>' . $c->vDescripcion . '</p></div></div>';

                                    echo '<div class="col-md-12">
   <section> 
   <div class="row">
       <div class="col-md-4" style="margin-top: auto;"><h5><b>Meta</b><br> ' . $c->nMeta . '</h5></div>
       <div class="col-md-4" style="margin-top: auto;"><h5><b>Meta modificada</b><br> ' . $c->nMetaModificada . '</h5></div>
       <div class="col-md-4" style="margin-top: auto;"><h5><b>Unidad de medida</b><br> ' . $c->vUnidadMedida . '</h5></div>
    </div>
    <div class="row">
       <div class="col-md-4" style="margin-top: auto;"><h5><b>Ponderación del componente</b><br> ' . $c->nPonderacion . '</h5></div>
       <div class="col-md-4" style="margin-top: auto;"><h5><b>Porcentaje de avance</h5></b><input type="text" value="' . $c->nAvance . '" id="nAvance' . $c->iIdComponente . '" class="form-control" ' . $periodoactivo . '></div>
       <div class="col-md-4" style="margin-top: auto;"><input type="submit" value="Guardar" class="btn btn-success btn-block" onclick="guardarAvances(' . $c->iIdComponente . ')" ' . $periodoactivo . '></div>
   </div>
   </section></div>';

                                    echo '<section><div class="row">
   <div class="col-10">
   <br><p>Archivos documentos en formato PDF (Maximo: 15)</p>
   <form method="POST" enctype="multipart/form-data" id="input-type-1-id-' . $c->iIdComponente . '">
   <input type="file" class="form-control" id ="files-' . $c->iIdComponente . '" name="files[]" onchange="fileValidation(1,' . $c->iIdComponente . ')" multiple ' . $periodoactivo . '>
   <input type="text" name="iIdComponente" style="display: none" value="' . $c->iIdComponente . '"></form></div>
   <div class="col-md-2" style="margin-top: auto;"><input type="submit" id="inputbtn-type-1-id-' . $c->iIdComponente . '" value="Guardar" class="btn btn-success btn-block" disabled></div>
<div class="col-md-12"><br></div>
<div class="col-md-12" id="evidencias' . $c->iIdComponente . '">
<script>
	cargar("' . base_url() . 'C_compromisos_componentes/listado_evidencia", "#evidencias' . $c->iIdComponente . '","POST","iIdComponente=' . $c->iIdComponente . '");
	</script>
</div>

   <div class="col-10"><br><p>Imagenes (Maximo: 10)</p>
   <form method="POST" enctype="multipart/form-data" id="input-type-2-id-' . $c->iIdComponente . '">
   <input type="file" class="form-control" id ="image-' . $c->iIdComponente . '" name="image[]" onchange="imageValidation(2,' . $c->iIdComponente . ')" multiple ' . $periodoactivo . '>
   <input type="text" name="iIdComponente" style="display: none" value="' . $c->iIdComponente . '"></form></div>
   <div class="col-md-2" style="margin-top: auto;"><input type="submit" id="inputbtn-type-2-id-' . $c->iIdComponente . '" value="Guardar" class="btn btn-success btn-block" disabled></div>
   <div class="col-md-12"><br></div>
<div class="col-md-12" id="evidencias_image' . $c->iIdComponente . '">
<script>
	cargar("' . base_url() . 'C_compromisos_componentes/listado_evidencia_imagen", "#evidencias_image' . $c->iIdComponente . '","POST","iIdComponente=' . $c->iIdComponente . '");
	</script>
</div>

   <div class="col-10"><br><p>Link de videos de YouTube (Maximo: 2)</p>
   <input type="url" id="inputtext-type-3-id-' . $c->iIdComponente . '"  class="form-control" ' . $periodoactivo . '></div>
   <div class="col-md-2" style="margin-top: auto;"><input type="submit" value="Guardar" class="btn btn-success btn-block" onclick="guardarLink(3,' . $c->iIdComponente . ')"></div>
   <div class="col-md-12"><br></div>
   <div class="col-md-12" id="evidencias_link' . $c->iIdComponente . '">
   <script>
	cargar("' . base_url() . 'C_compromisos_componentes/listado_evidencia_link", "#evidencias_link' . $c->iIdComponente . '","POST","iIdComponente=' . $c->iIdComponente . '");
	</script>
</div>


   </div></section>';
                                    echo '<section>
   <div class="row">
 <div class="col-md-10"></div>
 <div class="col-md-2"><input type="submit" value="Descargar evidencia" class="btn btn-success btn-block" onclick="descargarEvidencia(' . $c->iIdComponente . ')"></div>  
 </div>  
 </section>';


                                    // FIN
                                    echo '</div>';
                                    $validadorA++;
                                }
                                ?>
                            </div>


                            <!-- COMPONENTES -->
                        </div>

                    </div>
                </div>
                <script>
                    // Using http://johnny.github.io/jquery-sortable for sorting
                    $(document).ready(function () {
                        sorteable_images();
                        //foto_inicio();
                    });
                    var posicion;

                    function sorteable_images(){
                        !function (e, x, h) {
                            function r(a, b) {
                                var c = Math.max(0, a[0] - b[0], b[0] - a[1]), d = Math.max(0, a[2] - b[1], b[1] - a[3]);
                                return c + d
                            }

                            function s(a, b, c, d) {
                                for (var f = a.length, d = d ? "offset" : "position", c = c || 0; f--;) {
                                    var k = a[f].el ? a[f].el : e(a[f]), i = k[d]();
                                    i.left += parseInt(k.css("margin-left"), 10);
                                    i.top += parseInt(k.css("margin-top"), 10);
                                    b[f] = [i.left - c, i.left + k.outerWidth() + c, i.top - c, i.top + k.outerHeight() + c]
                                }
                            }

                            function l(a, b) {
                                var c = b.offset();
                                return {left: a.left - c.left, top: a.top - c.top}
                            }

                            function t(a, b, c) {
                                for (var b = [b.left, b.top], c = c && [c.left, c.top], d, f = a.length, e = []; f--;) d = a[f], e[f] = [f, r(d, b), c && r(d, c)];
                                return e = e.sort(function (a, b) {
                                    return b[1] - a[1] || b[2] - a[2] || b[0] - a[0]
                                })
                            }

                            function m(a) {
                                this.options = e.extend({}, j, a);
                                this.containers = [];
                                this.scrollProxy = e.proxy(this.scroll, this);
                                this.dragProxy = e.proxy(this.drag, this);
                                this.dropProxy = e.proxy(this.drop, this);
                                this.options.parentContainer || (this.placeholder = e(this.options.placeholder), a.isValidTarget || (this.options.isValidTarget = h))
                            }

                            function n(a, b) {
                                this.el = a;
                                this.options = e.extend({}, v, b);
                                this.group = m.get(this.options);
                                this.rootGroup = this.options.rootGroup = this.options.rootGroup || this.group;
                                this.parentContainer = this.options.parentContainer;
                                this.handle = this.rootGroup.options.handle || this.rootGroup.options.itemSelector;
                                this.el.on(o.start, this.handle, e.proxy(this.dragInit, this));
                                this.options.drop && this.group.containers.push(this)
                            }

                            var o, v = {drag: !0, drop: !0, exclude: "", nested: !0, vertical: !0}, j = {
                                afterMove: function () {
                                },
                                containerPath: "",
                                containerSelector: "ol, ul",
                                distance: 0,
                                handle: "",
                                itemPath: "",
                                itemSelector: "li",
                                isValidTarget: function () {
                                    return !0
                                },
                                onCancel: function () {
                                },
                                onDrag: function (a, b) {
                                    a.css(b)
                                },
                                onDragStart: function (a) {
                                    a.css({height: a.height(), width: a.width()});
                                    a.addClass("dragged");
                                    e("body").addClass("dragging")
                                },
                                onDrop: function (a) {
                                    a.removeClass("dragged").removeAttr("style");
                                    e("body").removeClass("dragging")
                                },
                                onMousedown: function (a, b) {
                                    b.preventDefault()
                                },
                                placeholder: '<li class="placeholder"/>',
                                pullPlaceholder: !0,
                                serialize: function (a, b, c) {
                                    a = e.extend({}, a.data());
                                    if (c) return b;
                                    b[0] && (a.children = b, delete a.subContainer);
                                    delete a.sortable;
                                    return a
                                },
                                tolerance: 0
                            }, p = {}, u = 0, w = {left: 0, top: 0, bottom: 0, right: 0};
                            o = {
                                start: "touchstart.sortable mousedown.sortable",
                                drop: "touchend.sortable touchcancel.sortable mouseup.sortable",
                                drag: "touchmove.sortable mousemove.sortable",
                                scroll: "scroll.sortable"
                            };
                            m.get = function (a) {
                                p[a.group] || (a.group || (a.group = u++), p[a.group] = new m(a));
                                return p[a.group]
                            };
                            m.prototype = {
                                dragInit: function (a, b) {
                                    this.$document = e(b.el[0].ownerDocument);
                                    b.enabled() ? (this.toggleListeners("on"), this.item = e(a.target).closest(this.options.itemSelector), this.itemContainer = b, this.setPointer(a), this.options.onMousedown(this.item, a, j.onMousedown)) : this.toggleListeners("on", ["drop"]);
                                    this.dragInitDone = !0
                                }, drag: function (a) {
                                    if (!this.dragging) {
                                        if (!this.distanceMet(a)) return;
                                        this.options.onDragStart(this.item, this.itemContainer, j.onDragStart);
                                        this.item.before(this.placeholder);
                                        this.dragging = !0
                                    }
                                    this.setPointer(a);
                                    this.options.onDrag(this.item, l(this.pointer, this.item.offsetParent()), j.onDrag);
                                    var b = a.pageX, a = a.pageY, c = this.sameResultBox, d = this.options.tolerance;
                                    if (!c || c.top - d > a || c.bottom + d < a || c.left - d > b || c.right + d < b) this.searchValidTarget() || this.placeholder.detach()
                                }, drop: function () {
                                    this.toggleListeners("off");
                                    this.dragInitDone = !1;
                                    if (this.dragging) {
                                        if (this.placeholder.closest("html")[0]) this.placeholder.before(this.item).detach(); else this.options.onCancel(this.item, this.itemContainer, j.onCancel);
                                        this.options.onDrop(this.item, this.getContainer(this.item), j.onDrop);
                                        this.clearDimensions();
                                        this.clearOffsetParent();
                                        this.lastAppendedItem = this.sameResultBox = h;
                                        this.dragging = !1
                                    }
                                }, searchValidTarget: function (a, b) {
                                    a || (a = this.relativePointer || this.pointer, b = this.lastRelativePointer || this.lastPointer);
                                    for (var c = t(this.getContainerDimensions(), a, b), d = c.length; d--;) {
                                        var f = c[d][0];
                                        if (!c[d][1] || this.options.pullPlaceholder) if (f = this.containers[f], !f.disabled) {
                                            if (!this.$getOffsetParent()) var e = f.getItemOffsetParent(), a = l(a, e),
                                                b = l(b, e);
                                            if (f.searchValidTarget(a, b)) return !0
                                        }
                                    }
                                    this.sameResultBox && (this.sameResultBox = h)
                                }, movePlaceholder: function (a, b, c, d) {
                                    var f = this.lastAppendedItem;
                                    if (d || !(f && f[0] === b[0])) b[c](this.placeholder), this.lastAppendedItem = b, this.sameResultBox = d, this.options.afterMove(this.placeholder, a)
                                }, getContainerDimensions: function () {
                                    this.containerDimensions || s(this.containers, this.containerDimensions = [], this.options.tolerance, !this.$getOffsetParent());
                                    return this.containerDimensions
                                }, getContainer: function (a) {
                                    return a.closest(this.options.containerSelector).data("sortable")
                                }, $getOffsetParent: function () {
                                    if (this.offsetParent === h) {
                                        var a = this.containers.length - 1, b = this.containers[a].getItemOffsetParent();
                                        if (!this.options.parentContainer) for (; a--;) if (b[0] != this.containers[a].getItemOffsetParent()[0]) {
                                            b = !1;
                                            break
                                        }
                                        this.offsetParent = b
                                    }
                                    return this.offsetParent
                                }, setPointer: function (a) {
                                    a = {left: a.pageX, top: a.pageY};
                                    if (this.$getOffsetParent()) {
                                        var b = l(a, this.$getOffsetParent());
                                        this.lastRelativePointer = this.relativePointer;
                                        this.relativePointer = b
                                    }
                                    this.lastPointer = this.pointer;
                                    this.pointer = a
                                }, distanceMet: function (a) {
                                    return Math.max(Math.abs(this.pointer.left - a.pageX), Math.abs(this.pointer.top - a.pageY)) >= this.options.distance
                                }, scroll: function () {
                                    this.clearDimensions();
                                    this.clearOffsetParent()
                                }, toggleListeners: function (a, b) {
                                    var c = this, b = b || ["drag", "drop", "scroll"];
                                    e.each(b, function (b, f) {
                                        c.$document[a](o[f], c[f + "Proxy"])
                                    })
                                }, clearOffsetParent: function () {
                                    this.offsetParent = h
                                }, clearDimensions: function () {
                                    this.containerDimensions = h;
                                    for (var a = this.containers.length; a--;) this.containers[a].clearDimensions()
                                }
                            };
                            n.prototype = {
                                dragInit: function (a) {
                                    var b = this.rootGroup;
                                    !b.dragInitDone && 1 === a.which && this.options.drag && !e(a.target).is(this.options.exclude) && b.dragInit(a, this)
                                }, searchValidTarget: function (a, b) {
                                    var c = t(this.getItemDimensions(), a, b), d = c.length, f = this.rootGroup,
                                        e = !f.options.isValidTarget || f.options.isValidTarget(f.item, this);
                                    if (!d && e) return f.movePlaceholder(this, this.el, "append"), !0;
                                    for (; d--;) if (f = c[d][0], !c[d][1] && this.hasChildGroup(f)) {
                                        if (this.getContainerGroup(f).searchValidTarget(a, b)) return !0
                                    } else if (e) return this.movePlaceholder(f, a), !0
                                }, movePlaceholder: function (a, b) {
                                    var c = e(this.items[a]), d = this.itemDimensions[a], f = "after", h = c.outerWidth(),
                                        i = c.outerHeight(), g = c.offset(),
                                        g = {left: g.left, right: g.left + h, top: g.top, bottom: g.top + i};
                                    this.options.vertical ? b.top <= (d[2] + d[3]) / 2 ? (f = "before", g.bottom -= i / 2) : g.top += i / 2 : b.left <= (d[0] + d[1]) / 2 ? (f = "before", g.right -= h / 2) : g.left += h / 2;
                                    this.hasChildGroup(a) && (g = w);
                                    this.rootGroup.movePlaceholder(this, c, f, g)
                                }, getItemDimensions: function () {
                                    this.itemDimensions || (this.items = this.$getChildren(this.el, "item").filter(":not(.placeholder, .dragged)").get(), s(this.items, this.itemDimensions = [], this.options.tolerance));
                                    return this.itemDimensions
                                }, getItemOffsetParent: function () {
                                    var a = this.el;
                                    return "relative" === a.css("position") || "absolute" === a.css("position") || "fixed" === a.css("position") ? a : a.offsetParent()
                                }, hasChildGroup: function (a) {
                                    return this.options.nested && this.getContainerGroup(a)
                                }, getContainerGroup: function (a) {
                                    var b = e.data(this.items[a], "subContainer");
                                    if (b === h) {
                                        var c = this.$getChildren(this.items[a], "container"), b = !1;
                                        c[0] && (b = e.extend({}, this.options, {
                                            parentContainer: this,
                                            group: u++
                                        }), b = c.sortable(b).data("sortable").group);
                                        e.data(this.items[a], "subContainer", b)
                                    }
                                    return b
                                }, enabled: function () {
                                    return !this.disabled && (!this.parentContainer || this.parentContainer.enabled())
                                }, $getChildren: function (a, b) {
                                    var c = this.rootGroup.options, d = c[b + "Path"], c = c[b + "Selector"], a = e(a);
                                    d && (a = a.find(d));
                                    return a.children(c)
                                }, _serialize: function (a, b) {
                                    var c = this,
                                        d = this.$getChildren(a, b ? "item" : "container").not(this.options.exclude).map(function () {
                                            return c._serialize(e(this), !b)
                                        }).get();
                                    return this.rootGroup.options.serialize(a, d, b)
                                }, clearDimensions: function () {
                                    this.itemDimensions = h;
                                    if (this.items && this.items[0]) for (var a = this.items.length; a--;) {
                                        var b = e.data(this.items[a], "subContainer");
                                        b && b.clearDimensions()
                                    }
                                }
                            };
                            var q = {
                                enable: function () {
                                    this.disabled = !1
                                }, disable: function () {
                                    this.disabled = !0
                                }, serialize: function () {
                                    return this._serialize(this.el, !0)
                                }
                            };
                            e.extend(n.prototype, q);
                            e.fn.sortable = function (a) {
                                var b = Array.prototype.slice.call(arguments, 1);
                                return this.map(function () {
                                    var c = e(this), d = c.data("sortable");
                                    if (d && q[a]) return q[a].apply(d, b) || this;
                                    !d && (a === h || "object" === typeof a) && c.data("sortable", new n(c, a));
                                    return this
                                })
                            }
                        }(jQuery, window);

                        var jsonString;
                        var adjustment;


                        var group = $("div.drag").sortable({
                            group: 'drag',
                            itemSelector: '.img-thumbnail',
                            containerSelector: '.drag',
                            vertical: false,
                            placeholder: '<div class="placeholder" />',
                            pullPlaceholder: false,

                            // set item relative to cursor position
                            onDragStart: function ($item, container, _super) {
                                var offset = $item.offset(),
                                    pointer = container.rootGroup.pointer

                                adjustment = {
                                    left: pointer.left - offset.left,
                                    top: pointer.top - offset.top
                                }

                                _super($item, container)
                            },
                            onDrop: function (item, container, _super) {
                                //console.log(group.sortable("serialize").get());
                                posicion = group.sortable("serialize").get();


                                $('#output').text(group.sortable("serialize").get().join("\n"))
                                _super(item, container)
                                alerta('Presione guardar para los efectuar los cambios', 'Advertencia');
                            },
                            onDrag: function ($item, position) {

                                $item.css({
                                    width: 250,
                                    height: 160,
                                    left: position.left - adjustment.left,
                                    top: position.top - adjustment.top,

                                })
                            },
                            serialize: function (parent, children, isContainer) {
                                return isContainer ? children.join() : parent.attr('rel')
                            }

                        })

                    }
                    /*function foto_inicio() {
                                // image gallery
                                // init the state from the input
                                $(".image-checkbox").each(function () {
                                    if ($(this).find('input[type="checkbox"]').first().attr("checked")) {
                                        $(this).addClass('image-checkbox-checked');
                                    }
                                    else {
                                        $(this).removeClass('image-checkbox-checked');
                                    }
                                });


                    }*/
                    // sync the state to the input
                    $(".image-checkbox").on("click", function (e) {
                        $(this).toggleClass('image-checkbox-checked');
                        var $checkbox = $(this).find('input[type="checkbox"]');
                        $checkbox.prop("checked",!$checkbox.prop("checked"))

                        e.preventDefault();
                    });

                    function guardar_posiciones() {
                        if (posicion === undefined) {
                            alerta('Selecciona una posición para las imágenes', 'Advertencia');
                        }
                        else {
                            var ids_evidencia = posicion.toString();
                            var output= ids_evidencia.split(',');
                            var imagenes_array=[], checked = 0;
                            //la v es lo que contiene la posicion
                            //i es la posicion
                            $.each(output,function(i, v){
                                checked = 0;
                                if( $('#foto_'+v).find('input').prop("checked")=== true){
                                    checked = 1;
                                }
                                imagenes_array.push({
                                    'iIdEvidencia' : v,
                                    'iFotoInicio' : checked,
                                    'iOrdenFoto':i+1
                                });
                            });
                            $.ajax({
                                type: "POST",
                                //dataType:"json",
                                url: "<?=base_url()?>/C_compromisos/actualizar_posicion",
                                data: {data:imagenes_array},
                                success: function (data) {

                                    if (data == "correcto") {

                                        alerta('Guardado exitoso', 'success');
                                    } else {
                                        alerta('Algo salio mal', 'error');
                                    }

                                }
                            });
                        }


                    }
                    function cargar_nueva_Evidencia(periodo_activo) {
                        id_compromiso=$("#id_comp").val().trim();
                        var id_compromiso_parse=parseInt(id_compromiso);


                        $.ajax({
                            type: "POST",
                            url: "<?=base_url()?>C_compromisos/cargar_nueva_galeria",
                            data: {idCompromiso_: id_compromiso_parse,periodo:periodo_activo},
                            success: function (data) {
                                //console.log(data);
                                $("#cargar_galeria").empty();
                                $("#cargar_galeria").append(data);
                                sorteable_images();


                            }
                        });
                    }

                </script>
                <script>
                    function guardarAvances(id) {
                        var nuevoAvance = $("#nAvance" + id).val();
                        if (nuevoAvance <= 100 && nuevoAvance >= 0) {
                            data = {"nAvance": nuevoAvance, "iIdComponente": id};
                            $.ajax({
                                type: "POST",
                                url: "<?=base_url()?>/C_compromisos_componentes/updateComponente",
                                data: data,
                                success: function (data) {
                                    if (data == "correcto") {
                                        CalcularAvance();
                                        alerta('Estatus actualizado', 'success');
                                    } else {
                                        alerta('Algo salio mal', 'error');
                                    }
                                }
                            });
                        } else {
                            alerta('El avance debe ser un rango de 0-100', 'error');
                        }
                    }
                </script>

                <script>
                    function CalcularAvance() {
                        var data = {"iIdCompromiso": <?=$datos_m[0]["iIdCompromiso"]?> };
                        $.ajax({
                            type: "POST",
                            url: "<?= base_url() ?>C_compromisos_componentes/porcentajeAvance", //Nombre del controlador
                            data: data,
                            success: function (resp) {
                                console.log(resp);
                            }
                        });
                    }
                </script>

                <script>
                    function descargarEvidencia(iIdComponente) {
                        var data = {"iIdComponente": iIdComponente};
                        $.ajax({
                            beforeSend: function () {
                                alerta('Espere un momento por favor', 'warning');
                            },
                            type: "POST",
                            url: "<?=base_url()?>/C_compromisos_componentes/descargarEvidencia",
                            data: data,
                            success: function (data) {
                                //console.log(data);
                                window.open(data);
                            }
                        });
                    }
                </script>
                <script>
                    function actualizarEstatus(iIdEvidencia) {
                        var iEstatus = $('#select-evidencia-' + iIdEvidencia).val();
                        var data = {"iIdEvidencia": iIdEvidencia, "iEstatus": iEstatus};
                        $.ajax({
                            type: "POST",
                            url: "<?=base_url()?>/C_compromisos_componentes/update_estatus_evidencia",
                            data: data,
                            success: function (data) {
                                if (data == "correcto") {
                                    alerta('Estatus actualizado', 'success');
                                } else {
                                    alerta('Algo salio mal', 'error');
                                }
                            }
                        });
                    }
                </script>
                <script>
                    function guardarLink(input, iIdComponente) {
                        var input = $('#inputtext-type-3-id-' + iIdComponente).val().trim();
                        if (input != "") {
                            var data = {"vEvidencia": input, "iIdComponente": iIdComponente};
                            $.ajax({
                                type: "POST",
                                url: "<?=base_url()?>/C_compromisos_componentes/add_link",
                                data: data,
                                success: function (data) {
                                    if (data == "correcto") {
                                        alerta('Guardado', 'success');
                                        // cargar("<?=base_url()?>C_compromisos_componentes/listado_evidencia", "#evidencias"+iIdComponente,"POST","iIdComponente="+iIdComponente);
                                        $('#inputtext-type-3-id-' + iIdComponente).val("");
                                        cargar("<?=base_url()?>C_compromisos_componentes/listado_evidencia_link", "#evidencias_link" + iIdComponente, "POST", "iIdComponente=" + iIdComponente);
                                    } else {
                                        alerta('Verifique los requisitos', 'error');
                                    }
                                }
                            });
                        } else {
                            alerta('Llene todos los campos', 'error');

                        }


                    }
                </script>

                <script>
                    function confirmar_eliminar(mensaje, funcion, var1, var2) {
                        //event.preventDefault();
                        var1 = var1 || '';
                        swal({
                            title: mensaje,
                            /*text: mensaje,*/
                            //icon: 'info',
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Confirmar",
                            cancelButtonText: "Cancelar",
                        }).then((confirm) => {

                            if (confirm.hasOwnProperty('value')) {
                                if (var1 != '') funcion(var1, var2);
                                else funcion();
                            }

                        });
                    }

                    function eliminar_evidencia(iIdEvidencia, iIdComponente) {
                        var data = {"iIdEvidencia": iIdEvidencia};
                        $.ajax({
                            type: "POST",
                            url: "<?=base_url()?>/C_compromisos_componentes/eliminar_evidencia",
                            data: data,
                            success: function (data) {
                                if (data == "correcto") {
                                    alerta('Eliminado', 'success');
                                    cargar("<?=base_url()?>C_compromisos_componentes/listado_evidencia", "#evidencias" + iIdComponente, "POST", "iIdComponente=" + iIdComponente);

                                    cargar("<?=base_url()?>C_compromisos_componentes/listado_evidencia_imagen", "#evidencias_image" + iIdComponente, "POST", "iIdComponente=" + iIdComponente);

                                    cargar("<?=base_url()?>C_compromisos_componentes/listado_evidencia_link", "#evidencias_link" + iIdComponente, "POST", "iIdComponente=" + iIdComponente);
                                } else {
                                    alerta('Algo salio mal', 'error');
                                }
                            }
                        });

                    }
                </script>
                <!-- Validador de extenciones NO SUSTIUR EMAC JS -->

                <script>
                    function imageValidation(type, id) {
                        var form = $('#input-type-' + type + '-id-' + id)[0];
                        var data = new FormData(form);

                        $.ajax({
                            beforeSend: function () {
                                alerta('Espere un momento verificando imagenes', 'warning');
                            },
                            type: "POST",
                            url: "<?=base_url()?>/C_compromisos_componentes/add_image_validador",
                            data: data,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function (data) {
                                if (data == 0) {
                                    alerta('Archivos aceptados para subir', 'success');
                                    $('#inputbtn-type-' + type + '-id-' + id).removeAttr("disabled");
                                    $('#inputbtn-type-' + type + '-id-' + id).attr("onclick", "imageAdd(" + type + "," + id + ")");
                                } else {
                                    alerta('Los archivos no fueron aceptados por favor verifique las especificaciones', 'error');
                                    $('#inputbtn-type-' + type + '-id-' + id).removeAttr("onclick");
                                    $('#inputbtn-type-' + type + '-id-' + id).attr("disabled", "disabled");
                                    $("#image-" + id).val("");

                                }
                            }
                        });
                    }

                    function imageAdd(type, id) {
                        var form = $('#input-type-' + type + '-id-' + id)[0];
                        var data = new FormData(form);
                        $.ajax({
                            type: "POST",
                            url: "<?=base_url()?>/C_compromisos_componentes/add_image",
                            data: data,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function (data) {
                                if (data == "correcto") {
                                    alerta('Imagenes subidas correctamente', 'success');
                                    $('#inputbtn-type-' + type + '-id-' + id).removeAttr("onclick");
                                    $('#inputbtn-type-' + type + '-id-' + id).attr("disabled", "disabled");
                                    $("#image-" + id).val("");
                                    cargar("<?=base_url()?>C_compromisos_componentes/listado_evidencia_imagen", "#evidencias_image" + id, "POST", "iIdComponente=" + id);
                                } else {
                                    alerta('Error en la subida de imagenes', 'error');
                                }
                            }
                        });

                    }
                </script>
                <!-- Archivos de oficcios -->
                <script>
                    function fileValidation(type, id) {
                        var form = $('#input-type-' + type + '-id-' + id)[0];
                        var data = new FormData(form);

                        $.ajax({
                            beforeSend: function () {
                                alerta('Espere un momento verificando archivos', 'warning');
                            },
                            type: "POST",
                            url: "<?=base_url()?>/C_compromisos_componentes/add_files_validador",
                            data: data,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function (data) {
                                if (data == 0) {
                                    alerta('Archivos aceptados para subir', 'success');
                                    $('#inputbtn-type-' + type + '-id-' + id).removeAttr("disabled");
                                    $('#inputbtn-type-' + type + '-id-' + id).attr("onclick", "fileAdd(" + type + "," + id + ")");
                                } else {
                                    alerta('Los archivos no fueron aceptados por favor verifique las especificaciones', 'error');
                                    $('#inputbtn-type-' + type + '-id-' + id).removeAttr("onclick");
                                    $('#inputbtn-type-' + type + '-id-' + id).attr("disabled", "disabled");
                                    $("#files-" + id).val("");

                                }
                            }
                        });
                    }


                    function fileAdd(type, id) {
                        var form = $('#input-type-' + type + '-id-' + id)[0];
                        var data = new FormData(form);
                        $.ajax({
                            type: "POST",
                            url: "<?=base_url()?>/C_compromisos_componentes/add_files",
                            data: data,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function (data) {
                                if (data == "correcto") {
                                    alerta('Archivos subidos correctamente', 'success');
                                    $('#inputbtn-type-' + type + '-id-' + id).removeAttr("onclick");
                                    $('#inputbtn-type-' + type + '-id-' + id).attr("disabled", "disabled");
                                    $("#files-" + id).val("");
                                    cargar("<?=base_url()?>C_compromisos_componentes/listado_evidencia", "#evidencias" + id, "POST", "iIdComponente=" + id);
                                } else {
                                    alerta('Error en la subida de archivos', 'error');
                                }
                            }
                        });

                    }
                </script>

                <script>
                    // Example starter JavaScript for disabling form submissions if there are invalid fields
                    (function () {
                        'use strict';
                        window.addEventListener('load', function () {
                            // Fetch all the forms we want to apply custom Bootstrap validation styles to
                            var forms = document.getElementsByClassName('needs-validation');
                            // Loop over them and prevent submission
                            var validation = Array.prototype.filter.call(forms, function (form) {
                                form.addEventListener('submit', function (event) {
                                    if (form.checkValidity() === false) {
                                        event.preventDefault();
                                        event.stopPropagation();
                                    }
                                    form.classList.add('was-validated');
                                }, false);
                            });
                        }, false);
                    })();
                </script>
            </div>
        </div>
    </div>

    <script>
        function guardarCompromiso(f, e) {
            e.preventDefault();

            // $.ajax({
            //     type: "POST",
            //     url: "<?=base_url()?>C_financiamientos/insert", //Nombre del controlador
            //     data: $(f).serialize(),

            //     success: function(resp) {
            //       if(resp > 0){

            //         buscarfinanciamiento();
            //         alerta('Guardado exitosamente','success');

            //       } else {
            //         alerta('Error al guardar','error');
            //       }

            //     },
            //     error: function(XMLHttpRequest, textStatus, errorThrown) {

            //     }
            // });
        }
    </script>


    <!-- <script src="<?= base_url() ?>public/assets/libs/ckeditor/ckeditor.js"></script> -->

    <script>
        //default
        // initSample();

        //inline editor
        // We need to turn off the automatic editor creation first.
        // CKEDITOR.disableAutoInline = true;

        // CKEDITOR.inline('editor2', {
        //     extraPlugins: 'sourcedialog',
        //     removePlugins: 'sourcearea'
        // });

        var editor1 = CKEDITOR.replace('editor1', {
            extraAllowedContent: 'div',
            height: 164
        });
        // editor1.on('instanceReady', function() {
        //     // Output self-closing tags the HTML4 way, like <br>.
        //     this.dataProcessor.writer.selfClosingEnd = '>';

        //     // Use line breaks for block elements, tables, and lists.
        //     var dtd = CKEDITOR.dtd;
        //     for (var e in CKEDITOR.tools.extend({}, dtd.$nonBodyContent, dtd.$block, dtd.$listItem, dtd
        //             .$tableContent)) {
        //         this.dataProcessor.writer.setRules(e, {
        //             indent: true,
        //             breakBeforeOpen: true,
        //             breakAfterOpen: true,
        //             breakBeforeClose: true,
        //             breakAfterClose: true
        //         });
        //     }
        // Start in source mode.
        //     this.setMode('source');
        // });

        <?='CKEDITOR.instances.editor1.setData(`'.utf8_decode(base64_decode($datos_m[0]["vObservaciones"])).'`)' ?>

    
        $('.js-example-basic-multiple').select2();
    </script>
    <script src="<?= base_url() ?>public/dist/js/customs/ejes.js"></script>


    <script>
        function guardar_compromiso() {
            if ($("#iIdTema").val() <= 0 || $("#iRevisado").val() <= 0 || $("#iIdDependencia").val <= 0) {
                alerta('Llene los campos correctamente', 'error');
            } else {
                var vObservaciones = CKEDITOR.instances.editor1.getData();
                var data = $("#frmCompromiso").serializeArray();
                data.push({
                    name: 'vObservaciones',
                    value: `${vObservaciones}`
                });
                var iIdDependenciaCble = $("#iIdDependenciaCble").val();
                data.push({
                    name: 'iIdDependenciaCble',
                    value: `${iIdDependenciaCble}`
                });

                $.ajax({
                    type: 'POST',
                    //dataType: 'json',
                    url: "<?= base_url() ?>C_compromisos/insertarCompromiso", //Nombre del controlador
                    data: data,
                    success: function (data) {
                        if (data == "correcto") {
                            alerta('Guardado exitosamente', 'success');
                        } else {
                            alerta('Error en la comunicación', 'error');
                        }
                    }
                });

            }

        }

        function ActualizarComprimiso() {
            if ($("#iIdTema").val() <= 0 || $("#iRevisado").val() <= 0 || $("#iIdDependencia").val() <= 0 || $("#iEstatus").val() <= 0 || $("#vNombreCorto").val().trim().length == 0 || $("#vCompromiso").val().trim().length == 0 || $("#vDescripcion").val().trim().length == 0) {
                alerta('Llene los campos correctamente', 'error');
            } else {
                var vObservaciones = CKEDITOR.instances.editor1.getData();
                var data = $("#frmCompromiso").serializeArray();
                data.push({
                    name: 'vObservaciones',
                    value: `${vObservaciones}`

                });
                var iIdDependenciaCble = $("#iIdDependenciaCble").val();
                data.push({
                    name: 'iIdDependenciaCble',
                    value: `${iIdDependenciaCble}`
                });
                var iIdCompromiso =<?=$datos_m[0]["iIdCompromiso"]?> ;
                data.push({
                    name: 'iIdCompromiso',
                    value: `${iIdCompromiso}`
                });

                $.ajax({
                    type: 'POST',
                    //dataType: 'json',
                    url: "<?= base_url()?>C_compromisos/ActualizarCompromiso", //Nombre del controlador
                    data: data,
                    success: function (data) {
                        if (data == "correcto") {
                            alerta('Guardado exitosamente', 'success');
                        } else {
                            alerta('Error en la comunicación', 'error');
                        }
                    }
                });

            }

        }
    </script>


    <script>
        function revisadoCheck() {
            var iRevisadoc = 0;
            if ($('#iRevisadoc').is(':checked')) {
                iRevisadoc = 1;
            } else {
                iRevisadoc = 0;
            }
            var data = {"iRevisado": iRevisadoc, "iIdCompromiso": <?=$datos_m[0]["iIdCompromiso"]?>};
            $.ajax({
                type: 'POST',
                //dataType: 'json',
                url: "<?= base_url()?>C_compromisos/ActualizarIrevisado", //Nombre del controlador
                data: data,
                success: function (data) {
                    if (data == "correcto") {
                        alerta('Guardado exitosamente', 'success');
                    } else {
                        alerta('Error en la comunicación', 'error');
                    }
                }
            });
        }
    </script>

    <script>
        $(document).ready(function () {
            $("#cboEje option[value=" + <?=$datos_m[0]["iIdEje"]?> +"]").prop("selected", true);
            $("#iIdTema option[value=" + <?=$datos_m[0]["iIdTema"]?> +"]").prop("selected", true);
            $("#iEstatus option[value=" + <?=$datos_m[0]["iEstatus"]?> +"]").prop("selected", true);
            $("#iIdDependencia option[value=" + <?=$datos_m[0]["iIdDependencia"]?> +"]").prop("selected", true);
            // $('#iIdDependenciaCble').select2('val', ["2", "3", "5"]);
            var Values = new Array();
            <?php
            if (count($datos_m[0]["iIdDependenciaCble"][0]) > 0) {
                foreach ($datos_m[0]["iIdDependenciaCble"] as $row) {
                    echo 'Values.push("' . $row["iIdDependencia"] . '");';
                    //    Values.push("value1");
                }

            }
            ?>
            $("#iIdDependenciaCble").val(Values).trigger('change');
        });
    </script>
    <script>
        $('#iNumero').on('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
    <script>
        function status_compromiso() {
            if ($("#iEstatus").val() <= 0) {
                $("#status_compromiso_text").show();
            } else {
                $("#status_compromiso_text").hide();
            }
            if ($("#iIdDependencia").val() <= 0) {
                $("#status_responsable_text").show();

            } else {
                $("#status_responsable_text").hide();

            }
            if ($("#iIdTema").val() <= 0) {
                $("#status_politica_publica_text").hide();

            } else {
                $("#status_politica_publica_text").hide();
            }
        }
    </script>