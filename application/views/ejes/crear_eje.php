<div class="card">

    <div class="card-body">

        <form class="needs-validation was-validated">

            <div class="container">
                <label for="">Nombre:</label>
                <br>
                <input class="form-control" type="text" placeholder="Nombre" required>
                <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                </div>
            </div>

            <br>

            <div class="container">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Icono</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="custom-file-input" required>
                        <label class="custom-file-label" for="custom-file-input">Elige Archvio</label>
                    </div>
                    <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="form-row">
                    <div class="col-12">
                        <label for="validationCustom04">Color:</label>
                        <input class="form-control" id="validationCustom04" name="nombrecorto" required="" type="text" placeholder="Color">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <div class="container">
                <div class="col-md-6">
                    <div class="row">
                        <label for="">Reto</label>
                        <select class="form-control" name="selectReto" id="selectReto" required>

                            <option value="">--Seleccione--</option>
                            <?php foreach($retos as $r) {?>

                                <option value="<?= $r->iIdReto ?>"> <?= $r->vDescripcion ?> </option>

                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>



        </form>
    </div>

</div>


<script>


// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});


</script>