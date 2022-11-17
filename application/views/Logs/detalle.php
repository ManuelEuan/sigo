<!--<div class="form-group">
    <div class="col-md-2 text-right">
        <button title="Ir a la pantalla anterior" class="btn waves-effect waves-light btn-outline-info" type="submit" onclick="buscar(event)"><i class="mdi mdi-arrow-left"></i>Regresar</button>
    </div>
</div>*/-->

<div class="card card-body">
    <div class="container">
        <!-- <h1><?= $cambios ?></h1> -->
        <table class="table table-striped table-bordered display" style="width:100%">
            <thead>
                <th>Campo</th>
                <th>Antes</th>
                <th>Despues</th>
            </thead>
            <tbody>
                <?= $cambios ?>

            </tbody>
        </table>
    </div>
</div>

<script>

</script>