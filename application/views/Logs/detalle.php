 

<div class="card card-body">
    <div class="container">
    <div>
        <button title="Regresar" type="button" class="btn waves-effect waves-light btn-outline-info" onclick="regresar();"><i class="mdi mdi-arrow-left"></i>&nbsp;Regresar</button>
        </div>
        <p>
    <div>

    </div>
   </button>   
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

function regresar() {
            cargar('<?= base_url() ?>C_ubps/regresar', '#contenido_modulo');
}
     
</script>
