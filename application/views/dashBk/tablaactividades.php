<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered display" style="width:100%" id="grid">
                        <thead>
                            <tr>
                                <th></th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $c1 = 0;
                            $array2 = array();
                            foreach ($actividades2 as $act3) {
                                array_push($array2, $act3['nAvance']);
                                ?>
                                <tr>
                                    <td>
                                        <div class="col-md-12" style="background-color: white;">
                                            <div class="row">
                                                <div class="col-md-2" style="padding-top: 1rem;">

                                                </div>
                                                <div class="col-md-6" style="color: black; font-size: 120%; padding: 2rem;">
                                                    <label style="display: none;"><?php echo $act3['iIdActividad']; ?></label>
                                                    <a style="cursor:pointer;"><?php echo $act3['vActividad']; ?></a>
                                                </div>
                                                <div class="col-md-1">
                                                    <div id="basic-doughn<?php echo $c1; ?>" style="width: 100%; height:100%;"></div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div style="position: relative; top: 45%; left: -90%; font-size: 70%; color: #11386b"><?php echo $act3['nAvance']; ?></div>
                                                    <div style="display:none;position: relative; top: 60%; left: -103%; font-size: 70%; color: #11386b;">AVANCE GENERAL</div>
                                                </div>
                                                <div class="col-md-2"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                
                              
                                $c1++;
                            }
                           //var_dump($array2);
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

var arrayJS2=<?php echo json_encode($array2);?>;
  console.log(arrayJS2.length);
  var ba = [];
  for(var e=0;e<arrayJS2.length;e++){
    //console.log(arrayJS2[i]);
    ba[e] = echarts.init(document.getElementById('basic-doughn'+e));
option = {
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b}: {c} ({d}%)"
        },

        // Add custom colors
        color: ['#d0282a', '#c0cac8'],

        series: [{
            name: '',
            type: 'pie',
            radius: ['50%', '70%'],
            avoidLabelOverlap: true,

            labelLine: {
                normal: {
                    show: false
                }
            },
            data: [{
                    value: arrayJS2[e],
                    name: 'Porcentaje de avance'
                },

                {
                    value: 100,
                    name: 'Total posible'
                }
            ]
        }]
    };


    ba[e].setOption(option);
}

</script>