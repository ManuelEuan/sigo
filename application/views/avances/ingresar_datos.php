<div class="col-12">    
    <form id="addavance" class="" onsubmit="guardarAvance(this,event);">
        <div class="form-row">
            <div class="col-md-3 mb-3">
            <label for="validationCustom04">Mes reporte<b class="text-danger">*</b></label>
                <select id="mes_corte" name="mes_corte" required class="form-control">
                    <option value="">Seleccionar...</option>
                    <option value="01">Ene</option>
                    <option value="02">Feb</option>
                    <option value="03">Mar</option>
                    <option value="04">Abr</option>
                    <option value="05">May</option>
                    <option value="06">Jun</option>
                    <option value="07">Jul</option>
                    <option value="08">Ago</option>
                    <option value="09">Sep</option>
                    <option value="10">Oct</option>
                    <option value="11">Nov</option>
                    <option value="12">Dic</option>
                </select>
                <div class="invalid-feedback">
                    Este campo no puede estar vacio.
                </div>
            </div>

            <?php if($consulta->iMunicipalizacion == 1){?>
            <div class="col-md-9 mb-9">
                <!--<label for="validationCustom04">Municipiosss<b class="text-danger">*</b></label>
                <select id="municipio" name="municipio" required class="form-control">
                    <option value="">Seleccionar...</option>
                    <?= $municipios ?>
                </select>
                <div class="invalid-feedback">
                    Este campo no puede estar vacio.  
                </div>-->
                <label for="municipios">Municipios</label>
                <select aria-invalid="false" class="select2 form-control" multiple="multiple" style="height: 36px;width: 100%;" name="municipios[]" id="municipios">
                    <?=$municipios;?>
                </select>  
                <div class="invalid-feedback">
                    Este campo no puede estar vacio.
                </div>  
            </div>
            <?php } ?>
        </div>
        
            <div class="form-row">
                <?php foreach($Variables as $key => $v){ ?>
                    <div class="col-md-3 mb-3">
                        <label for=""><?= $v->vNombreVariable ?></label>
                        <input class="form-control" type="text" id="letra" name="letra[]" value="<?= $v->vVariableIndicador ?>" hidden>
                        <input class="form-control full" type="number" id="valores" name="valores[]" placeholder="0" required>
                    </div>
                <?php } ?>
            </div>

            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <button type="button" class="btn waves-effect waves-light btn-info" onclick="changeInput();">Calcular</button>
                </div>
            </div>

            <!--<div class="form-row">
                <div class="col-md-3 mb-3">
                        <label for="">Presupuesto</label>
                        <input class="form-control" type="number" id="presupuesto" name="presupuesto" placeholder="0" readonly>
                    </div>
            </div>-->
            
        
        
        <div class="form-row">
            
            <div class="col-md-3 mb-3" id="avanceCalculado">
                <label>Avance al mes de reporte<b class="text-danger">*</b></label>
                <input type="text" id="avance" name="avance" class="form-control" required="" placeholder="Ingresar avance" onkeypress="return filterFloat(event,this);" readonly>
                <div class="invalid-feedback">
                    Este campo no puede estar vacio.
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <label>Monto Pagado a la fecha de corte<b class="text-danger">*</b></label>
                <input type="text" id="monto" name="monto" class="form-control" required="" placeholder="Ingresar monto" onkeypress="return filterFloat(event,this);">
                <div class="invalid-feedback">
                    Este campo no puede estar vacio.
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <label><i style="margin-top:5px;" class="fa-lg mdi mdi-human-male azul"></i>Ciudadanos Hombres</label>
                <input type="text" id="beneficiarioH" name="nBeneficiariosH" class="form-control" placeholder="Ingresar cantidad" onkeypress="return filterFloat(event,this);">
                <div class="invalid-feedback">
                    Este campo no puede estar vacio.
                </div>
            </div>                 
            <div class="col-md-2 mb-3">
                <label><i style="margin-top:5px;" class="fa-lg mdi mdi-human-female rosa"></i>Ciudadanos Mujeres</label>
                <input type="text" id="beneficiarioM" name="nBeneficiariosM" class="form-control" placeholder="Ingresar cantidad" onkeypress="return filterFloat(event,this);">
                <div class="invalid-feedback">
                    Este campo no puede estar vacio.
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <label><i style="margin-top:5px;" class="fa-lg mdi mdi-human-male text-info"></i>Hombres con discapacidad</label>
                <input type="text" id="nDiscapacitadosH" name="nDiscapacitadosH" class="form-control" placeholder="Ingresar cantidad" onkeypress="return filterFloat(event,this);" onblur="ValidarBeneficiariosH()">
                <div class="invalid-feedback">
                    Este campo no puede estar vacio.
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <label><i style="margin-top:5px;" class="fa-lg mdi mdi-human-female rosa"></i>Mujeres con discapacidad</label>
                <input type="text" id="nDiscapacitadosM" name="nDiscapacitadosM" class="form-control" placeholder="Ingresar cantidad" onkeypress="return filterFloat(event,this);" onblur="ValidarBeneficiariosM()">
                <div class="invalid-feedback">
                    Este campo no puede estar vacio.
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <label><i style="margin-top:5px;" class="fa-lg mdi mdi-human-male text-info"></i>Hombres de habla indígena</label>
                <input type="text" id="nLenguaH" name="nLenguaH" class="form-control" placeholder="Ingresar cantidad" onkeypress="return filterFloat(event,this);" onblur="ValidarBeneficiariosH()">
                <div class="invalid-feedback">
                    Este campo no puede estar vacio.
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <label><i style="margin-top:5px;" class="fa-lg mdi mdi-human-female rosa"></i>Mujeres de habla indígena</label>
                <input type="text" id="nLenguaM" name="nLenguaM" class="form-control" placeholder="Ingresar cantidad" onkeypress="return filterFloat(event,this);" onblur="ValidarBeneficiariosM()">
                <div class="invalid-feedback">
                    Este campo no puede estar vacio.
                </div>
            </div>
             <div class="col-md-3 mb-3">
                <label><i style="margin-top:5px;" class="fa-lg mdi mdi-human-male text-info"></i>Hombres tercera edad</label>
                <input type="text" id="nTerceraEdadH" name="nTerceraEdadH" class="form-control" placeholder="Ingresar cantidad" onkeypress="return filterFloat(event,this);" onblur="ValidarBeneficiariosH()">
                <div class="invalid-feedback">
                    Este campo no puede estar vacio.
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <label><i style="margin-top:5px;" class="fa-lg mdi mdi-human-female rosa"></i>Mujeres tercera edad</label>
                <input type="text" id="nTerceraEdadM" name="nTerceraEdadM" class="form-control" placeholder="Ingresar cantidad" onkeypress="return filterFloat(event,this);" onblur="ValidarBeneficiariosM()">
                <div class="invalid-feedback">
                    Este campo no puede estar vacio.
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <label><i style="margin-top:5px;" class="fa-lg mdi mdi-human-male text-info"></i>Hombres niños y adolescentes</label>
                <input type="text" id="nAdolescenteH" name="nAdolescenteH" class="form-control" placeholder="Ingresar cantidad" onkeypress="return filterFloat(event,this);" onblur="ValidarBeneficiariosH()">
                <div class="invalid-feedback">
                    Este campo no puede estar vacio.
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <label><i style="margin-top:5px;" class="fa-lg mdi mdi-human-female rosa"></i>Mujeres niñas y adolescentes</label>
                <input type="text" id="nAdolescenteM" name="nAdolescenteM" class="form-control" placeholder="Ingresar cantidad" onkeypress="return filterFloat(event,this);" onblur="ValidarBeneficiariosM()">
                <div class="invalid-feedback">
                    Este campo no puede estar vacio.
                </div>
            </div>
        </div>
         <div class="form-row">
            <div class="col-md-3 mb-3">
                <label>Empresas</label>
                <input type="text" class="form-control" id="empresa" name="empresa" placeholder="Ingrese la empresa">
                <div class="invalid-feedback">
                    Este campo no puede estar vacio.
                </div>
            </div>
        </div>
         <div class="form-row">
            <div class="col-md-12 mb-3">
                <label>Observaciones</label>
                <textarea class="form-control" id="observaciones" name="observaciones" aria-invalid="false" placeholder="Ingresar observación" maxlength="50"></textarea>
                <div class="invalid-feedback">
                    Este campo no puede estar vacio.
                </div>
            </div>
        </div>

        
        <center style="margin:auto;">
            <input name="id_detent" type="hidden" value="<?= $consulta->iIdDetalleEntregable ?>">
            <button id="addavance" class="btn waves-effect waves-light btn-info" type="submit">+ Agregar avance</button>
        </center>
    </form>
</div>

<script>
    var TipoActividad = 'gestion';
    var monto  = 0;

    $(document).ready(function(){
        $(".select2").select2();
        TipoActividad =  $("#tipoActividad").val();
        $('#monto').prop('disabled', true);
        $('#monto').val('0');

        if(TipoActividad == 'poa'){
            <?php echo "var numeroProyecto ='$numProyecto';"; ?>

            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>C_pat/getCatalogoPOA",
                success: function(resp) {
                    let response = JSON.parse(resp);
                    response.datos.forEach(value => {
                        if(value.numeroProyecto == numeroProyecto ){
                            let pagado = value.pagado == null ? '0' : value.pagado.toString();
                            $('#monto').val(pagado);
                            monto = pagado;
                        }
                    });
                   
                },
                error: function(XMLHHttRequest, textStatus, errorThrown) {
                    console.log('alsdhk');
                }
            });
        }
        else{
            $('#monto').val('0');
        }
 
    });

    $("#avance").attr("maxlength", 11);
    $("#monto").attr("maxlength", 11);
    $("#beneficiarioH").attr("maxlength", 11);
    $("#beneficiarioM").attr("maxlength", 11);
    $("#discapacitadoH").attr("maxlength", 11);
    $("#discapacitadoM").attr("maxlength", 11);
    $("#lenguaindH").attr("maxlength", 11);
    $("#lenguaindM").attr("maxlength", 11);
    $("#observaciones").attr("maxlength", 1000);

    function guardarAvance(f, e) {
        e.preventDefault();
        var mes = $("#mes_corte").val();
        var fecha = $("#mes_corte option:selected").html();
        var id_detent = <?=$consulta->iIdDetalleEntregable;?>;
        var acceso =  '<?=$acceso?>';  
        $('#monto').prop('disabled', false);

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>C_avances/insert", //Nombre del controlador
            data: $(f).serialize(),

            success: function(resp) {                
                if (resp == true) {
                    $("form#addavance")[0].reset();
                    alerta('Guardado exitosamente', 'success');
                    $("#municipios").val([]);
                    refrescarAvances(mes);
                    mostrarRegistrosMes(mes);
                    accordion[parseInt(mes)] = false;
                    $('#monto').prop('disabled', true);
                    $('#monto').val(monto);
                }else {
                    alerta('Error al guardar', 'error');
                }

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                 alerta('Ha ocurrido un erro, contacte al administrador', 'error');
            }
        });
    }


    function filterFloat(evt,input){
        var key = window.Event ? evt.which : evt.keyCode;    
        var chark = String.fromCharCode(key);
        var tempValue = input.value+chark;
        if(key >= 48 && key <= 57){
            if(filter(tempValue)=== false){
                return false;
            }else{       
                return true;
            }
        }else{
              if(key == 8 || key == 13 || key == 0) {     
                  return true;              
              }else if(key == 46){
                    if(filter(tempValue)=== false){
                        return false;
                    }else{       
                        return true;
                    }
              }else{
                  return false;
              }
        }
    }

    function filter(__val__){
        var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
        if(preg.test(__val__) === true){
            return true;
        }else{
           return false;
        }   
    }
    
    function ValidarBeneficiariosH(){
        var bnfH = $("#beneficiarioH").val();
        var dscH = $("#discapacitadoH").val();
        var lngH = $("#lenguaindH").val();

        if(bnfH == ''){
            bnfH = 0;
        }
        if(dscH == ''){
            dscH = 0;
        }
        if(lngH == ''){
            lngH = 0;
        }
        var suma = parseFloat(dscH) + parseFloat(lngH);
        
        if(suma > bnfH){
            alerta('El valor no puede ser mayor a los Beneficiarios Hombres', 'warning');
            //$("#addavance").prop( "disabled", true );
        }else{
            //$("#addavance").prop( "disabled", false );
        }
    }

    function changeInput(){

        const full = document.getElementsByClassName('full');
        const arr = [...full].map(input => input.value);

        console.log(arr);

        var formula = '<?= $vFormula ?: '' ?>'

        contadorValores = 0;

        var estructuraFinal = ''

        for(i = 0; i <= formula.length; i++){
            if(formula[i] != undefined){
                if(formula[i] != '+' && formula[i] != '*' && formula[i] != '/' && formula[i] != '-' && formula[i] != '(' && formula[i] != ')'){
                    estructuraFinal = estructuraFinal.concat(formula[i].replace(formula[i], arr[contadorValores]))
                    contadorValores = contadorValores + 1
                }else{
                    estructuraFinal = estructuraFinal.concat(formula[i])
                }
            
            }
        }
        //console.log(formula)
        //console.log(estructuraFinal)
        //console.log(eval(estructuraFinal))

        total =  eval(estructuraFinal)

        if(total < 0){
            document.getElementById("avance").value = 0;
        }else{
            document.getElementById("avance").value = total;
        }

        
    }

    function ValidarBeneficiariosM(){
        var bnfM = $("#beneficiarioM").val();
        var dscM = $("#discapacitadoM").val();
        var lngM = $("#lenguaindM").val();

        if(bnfM == ''){
            bnfM = 0;
        }
        if(dscM == ''){
            dscM = 0;
        }
        if(lngM == ''){
            lngM = 0;
        }
        var suma = parseFloat(dscM) + parseFloat(lngM);
        
        if(suma > bnfM){
            alerta('El valor no puede ser mayor a los Beneficiarios Mujeres', 'warning');
            //$("#addavance").prop( "disabled", true );
        }else{
            //$("#addavance").prop( "disabled", false );
        }
    }
</script>