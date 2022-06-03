<style>
    .boton {
        background-color: #B274E8;
        color: #fff;
    }

    .boton:hover {
        background-color: #C397EA;
    }

    .boton_desc {
        background-color: #62DDBA;
        color: #fff;
    }

    .boton_desc:hover {
        background-color: #90E4CC;
    }

    .boton_InfTex {
        background-color: #7E70E9;
        color: #fff;
    }

    .boton_InfTex:hover {
        background-color: #A69DED;
    }

    .boton_edit {
        background-color: #ffb300;
        color: #fff;
    }

    .boton_edit:hover {
        background-color: #ffe54c;
    }

    .boton_eliminar {
        background-color: #f44336;
        color: #fff;
    }

    .boton_eliminar:hover {
        background-color: #ff7961;
    }

    .progress-c {
        width: 110px;
        height: 110px;
        background: none;
        position: relative;
    }

    .progress-c::after {
        content: "";
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 6px solid #eee;
        position: absolute;
        top: 0;
        left: 0;
    }

    .progress-c>span {
        width: 50%;
        height: 100%;
        overflow: hidden;
        position: absolute;
        top: 0;
        z-index: 1;
    }

    .progress-c .progress-c-left {
        left: 0;
    }

    .progress-c .progress-c-bar {
        width: 100%;
        height: 100%;
        background: none;
        border-width: 6px;
        border-style: solid;
        position: absolute;
        top: 0;
    }

    .progress-c .progress-c-left .progress-c-bar {
        left: 100%;
        border-top-right-radius: 100px;
        border-bottom-right-radius: 100px;
        border-left: 0;
        -webkit-transform-origin: center left;
        transform-origin: center left;
    }

    .progress-c .progress-c-right {
        right: 0;
    }

    .progress-c .progress-c-right .progress-c-bar {
        left: -100%;
        border-top-left-radius: 100px;
        border-bottom-left-radius: 100px;
        border-right: 0;
        -webkit-transform-origin: center right;
        transform-origin: center right;
    }

    .progress-c .progress-c-value {
        position: absolute;
        top: 0;
        left: 0;
    }

    body {
        background: #ff7e5f;
        background: -webkit-linear-gradient(to right, #ff7e5f, #feb47b);
        background: linear-gradient(to right, #ff7e5f, #feb47b);
        min-height: 100vh;
    }

    .rounded-lg {
        border-radius: 1rem;
    }

    .text-gray {
        color: #aaa;
    }

    div.h4 {
        line-height: 0rem;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered display" style="width:100%" id="grid">
                        <thead>
                            <tr>
                                <th width="90px">Avance</th>
                                <th width="50px">Dependencia</th>
                                <th>Acción</th>
                                <th width="20px">Año</th>
                                <th width="180px">Acciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <th width="90px">Avance</th>
                                <th width="50px">Dependencia</th>
                                <th>Acción</th>
                                <th width="20px">Año</th>
                                <th width="180px">Acciones</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    /*$(function() {
        $(".dial").knob();
        $(".progress-c").each(function() {

            var value = $(this).attr('data-value');
            var left = $(this).find('.progress-c-left .progress-c-bar');
            var right = $(this).find('.progress-c-right .progress-c-bar');

            if (value > 0) {
                if (value <= 50) {
                    right.css('transform', 'rotate(' + percentageToDegrees(value) + 'deg)')
                } else {
                    right.css('transform', 'rotate(180deg)')
                    left.css('transform', 'rotate(' + percentageToDegrees(value - 50) + 'deg)')
                }
            }
        });
    });*/

    $(document).ready(function() {
        searchPats();
    });
</script>