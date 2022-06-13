<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <h4 class="card-title">Nuevo indicador</h4>
                </div>
                <div class="col-md-2 text-right">
                    <button title="Ir a la pantalla anterior" class="btn waves-effect waves-light btn-outline-info" type="submit" onclick="regresarmodulo()"><i class="mdi mdi-arrow-left"></i>Regresar</button>
                </div>
            </div>
            <br>
            <br>
            <h5 class="card-title">Datos generales</h5>
            <div class="dropdown-divider"></div>
            <form class="needs-validation was-validated" onsubmit="guardarEntregables(this,event);">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label>Indicador<span class="text-danger">*</span></label>
                        <textarea class="form-control alphaonly" id="entregable" name="entregable" aria-invalid="false" required="" placeholder="Ingresar nombre del indicador" ></textarea>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label for="validationCustom04">Forma Indicador<span class="text-danger">*</span></label>
                        <select id="formaIndicador" name="formaIndicador" required class="form-control">
                            <option value="">Seleccionar...</option>
                            <?php foreach($FormaInd as $f){ ?>

                                <option value="<?= $f->iIdFormaInd ?>"><?= $f->vDescripcion ?></option>

                            <?php } ?>
                        </select>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                      <input type="hidden" id="" name="" required class="form-control" value=1>

                   
                    <div class="col-md-2 mb-3">
                        <label>Dimensión<span class="text-danger">*</span></label>
                        <select name="selectDimension" id="selectDimension" required class="form-control">
                            <option value="">Seleccionar...</option>
                            <?php foreach($dimension as $d){ ?>

                                <option value="<?= $d->iIdDimensionInd ?>"><?= $d->vDescripcion ?></option>

                            <?php } ?>
                        </select>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    
                </div>


                <!--- Este va a variar -->
                <div class="form-row" id="divVariables">
                    <div class="col-md-3 mb-3">
                        <label>Variable A<span class="text-danger">*</span> <button type="button" onclick="agregarVariable();" style="border: none;">+</button></label>
                        <input type="text" id="A" name="Letra[]" class="form-control" required="required" value="A" hidden>
                        <input type="text" id="A" name="Variable[]" class="form-control" required="required" placeholder="A">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-2 mb-3">
                        <label for="validationCustom04">Base Indicador<span class="text-danger">*</span></label>
                        <input type="text" id="baseIndicador" name="baseIndicador" class="form-control" required="required" placeholder="">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                      <input type="hidden" id="" name="" required class="form-control" value=1>

                   
                    <div class="col-md-2 mb-3">
                        <label>Medio Verificación<span class="text-danger">*</span></label>
                        <input type="text" id="medioVerificacion" name="medioVerificacion" class="form-control" required="required" placeholder="">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>

                    <div class="col-md-8 mb-3">
                        <label>Area para calculo de variable<span class="text-danger">*</span></label>
                        <textarea class="form-control alphaonly" id="areaCalculo" name="areaCalculo" aria-invalid="false" required="" placeholder="" ></textarea>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>



                <div class="form-row">

                    <div class="col-md-3 mb-3">
                        <label>Meta<span class="text-danger">*</span></label>
                        <input type="text" id="meta" name="meta" class="form-control only_number" required="required" placeholder="" onKeypress="return soloDigitos(event,'OK');" maxlength="30" onblur="moneyFormat(this.id);">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <!--<div class="col-md-2 mb-3">-->
                        <input type="hidden" class="form-control input-lectura" maxlength="1" id="metamodificada" name="metamodificada" value="0">


                      <!--  <label>Meta modificada<span class="text-danger">*</span></label>-->
                       <!-- <input type="text" id="metamodificada" name="metamodificada" class="input-lectura form-control" required="" placeholder="" onKeypress="return soloDigitos(event,'OK');" maxlength="30" onblur="moneyFormat(this.id);">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div> -->
                   <!-- </div>-->
                    <div class="col-md-2 mb-3">
                        <label for="validationCustom04">Unidad de medida<span class="text-danger">*</span></label>
                        <select id="unidadmedida" name="unidadmedida" required class="form-control">
                            <option value="">Seleccionar...</option>
                            <?= $unidadmedida ?>
                        </select>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                      <input type="hidden" id="sujetoafectado" name="sujetoafectado" required class="form-control" value=1>

                   
                    <div class="col-md-2 mb-3">
                        <label>Periodicidad<span class="text-danger">*</span></label>
                        <select name="periodicidad" id="periodicidad" required class="form-control">
                            <option value="">Seleccionar...</option>
                            <?= $periodicidad ?>
                        </select>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>


                <br>
                <div class="form-row">

                    <div class="col-md-3 mb-3">
                            <label>Fecha inicio<span class="text-danger">*</span></label>
                            <input type="date" id="fechainicio" name="fechainicio" class="form-control only_number" required="" placeholder="dd-mm-yyyy"  value="2022-01-01" readonly>
                            <div class="invalid-feedback">
                                Este campo no puede estar vacio.
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Fecha fin<span class="text-danger">*</span></label>
                            <input type="date" id="fechafin" name="fechafin" class="form-control only_number" required="" placeholder="dd-mm-yyyy" value="2022-12-31" readonly>
                            <div class="invalid-feedback">
                                Este campo no puede estar vacio.
                            </div>
                    </div>
                    <div class="col-md-3 mb-3" style="align-self: self-end;">
                    <br>
                    <br>
                       <div class="custom-control custom-checkbox mr-sm-2 m-b-15" style="text-align: -webkit-center;">
                            <input type="checkbox" class="custom-control-input" id="checkbox0" name="municipalizable" value="1">
                            <label class="custom-control-label" for="checkbox0">Municipalizable</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                      <!-- <div class="custom-control custom-checkbox mr-sm-2 m-b-15">
                            <input type="checkbox" class="custom-control-input" id="checkbox1" name="beneficios" value="1">
                            <label class="custom-control-label" for="checkbox1">Mismos beneficiarios</label>
                        </div>-->
                        <input type="hidden" class="form-control input-lectura" maxlength="255" id="checkbox1" name="beneficios" value="0">
                    </div>
                    <div class="col-md-12" id="ctl-municipios">
                         <label for="municipios">Municipios</label>
                        <select aria-invalid="false" class="select2 form-control" multiple="multiple" style="height: 36px;width: 100%;" name="municipios[]" id="municipios">
                            <?=$municipios;?>
                        </select>  
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>  
                    </div>
                </div>
                <br>
                <br>
                <!--<h5 class="card-title">Alineacion compromisos</h5>-->
                <!--<div class="dropdown-divider"></div>
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label for="validationCustom04">Compromiso</label>
                        <select id="compromiso" name="compromiso" required class="form-control" onchange="cargarComponente()">
                            <option value="0">Seleccionar...</option>
                            <?php foreach ($compromisos as $value) { ?>
                                <option value="<?= $value->iIdCompromiso ?>"><?=$value->iNumero ?>. <?=$value->vCompromiso ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Componente</label>
                        <select name="componente" id="componente" required class="form-control">
                            <option value="0">Seleccionar...</option>
                            
                        </select>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>-->
                <center>
                    <input type="hidden" name="id_detalleactividad" value="<?= $id_detact ?>">
                    <button class="btn waves-effect waves-light btn-info" type="submit">Continuar</button>
                    <button type="reset" class="btn waves-effect waves-light btn-inverse" onclick="regresarmodulo()">Cancelar</button>
                </center>
            </form>
        </div>
    </div>
</div>

<script>
$(".alphaonly").attr("maxlength", 350);
$(".only_number").attr("maxlength", 11);
</script>

<script>
    function cargarComponente() {
        var value = $("#compromiso").val();
        $("#componente").load('C_entregables/showcomponentes/' + value);
    }
</script>

<script>
     $(document).ready(function(){
        $(".select2").select2();
        $("#ctl-municipios").hide();

        $('#checkbox0').click(function() {
            if ($(this).is(':checked')) {
                $("#ctl-municipios").show();
            }else {
                 $("#ctl-municipios").hide();
            }
        });

        /*alphabet = 'abcdefghijklmnopqrstuvwxyz';
        letra = '';
        
        for(i=0; i<= alphabet.length; i++){
            letra = alphabet[i]
            console.log(letra)
        }*/

    });

    var areaReponsableArray = []
    var contador = 0;
    var myArea = {};
    var alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    function agregarVariable(){
        console.log('Estas clickando el boton de mas ')

        var id = areaReponsableArray.length + 1

        myArea.id = id

        var tbody = '<div class="col-md-3 mb-3 divVariable'+id+'"> <label>Variable '+alphabet[id]+'<span class="text-danger">*</span> <button class="remover" type="button" onclick="remover('+id+');" style="border: none;">x</button></label> <input type="text" id="'+alphabet[id]+'" name="Letra[]" class="form-control" required="required" value="'+alphabet[id]+'" hidden> <input type="text" id="'+alphabet[id]+'" name="Variable[]" class="form-control" required="required" placeholder="'+alphabet[id]+'"> <div class="invalid-feedback"> Este campo no puede estar vacio. </div> </div>'
        $('#divVariables').append(tbody)

        areaReponsableArray.push(myArea);
        myArea = {}
        /*var result = eval('1+3-4'); 
        console.log(result)*/
    }

    function remover(id){
        areaReponsableArray = areaReponsableArray.filter(obj => obj.id != id)
        $(".divVariable"+id).remove();
    }

    function guardarEntregables(f, e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_entregables/insert", //Nombre del controlador
            data: $(f).serialize(),

            success: function(resp) {
                if (resp >0) {

                    agregar_ponderacion(resp,<?= $id_detact ?>);

                    //alerta('Guardado exitosamente', 'success');
                }if (resp == 'error_meta'){
                    alerta('La meta debe ser mayor a cero', 'warning');
                }if(resp == 'error') {
                    alerta('Error al guardar', 'error');
                }

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {

            }
        });
    }
</script>

