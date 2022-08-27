<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered display" style="width:100%" id="grid">
                        <thead>
                            <tr>
                                <th>Numero de Proyecto</th>
                                <th>Aprobado</th>
                                <th>Pagado</th>
                                <th>Dependencia</th>
                                <th>Nombre Proyecto</th>
                                <th>Fecha Aprobacion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($proyectos as $p){ ?>
                                <tr>
                                    
                                    <td><?= $p->numeroProyecto?></td>
                                    <td><?= $p->aprobado ?></td>
                                    <td><?= $p->pagado ?></td>
                                    <td><?= $p->dependenciaEjecutora ?></td>
                                    <td><?= $p->nombreProyecto ?></td>
                                    <td><?= $p->fechaAprobacion ?></td>
                                    
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>