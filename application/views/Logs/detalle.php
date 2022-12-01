 

<div class="card card-body">
    <div class="container">
    <div>
        <button title="Regresar" type="button" class="btn waves-effect waves-light btn-outline-info" onclick="index();"><i class="mdi mdi-arrow-left"></i>&nbsp;Regresar</button>
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
        <p>
        <?php var_dump($antes); ?>
        <br><br><br><br><br><br>
        <?php var_dump($despues); ?>
        <br><br><br><br><br><br>
        <?php var_dump($key); ?>
        </p>
    </div>
</div>

<script>

function index(idLog){
        cargar('<?= base_url() ?>C_logs/index', '#contenido', 'POST', 'id=' + idLog);
    }
    
    </script>
