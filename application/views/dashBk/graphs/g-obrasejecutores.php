<div class="row">
    <div class="col-12 text-right" id="btnback<?=$id?>">
        <?php 
        if(isset($boton))
        {
            echo '<button class="btn btn-default" onclick="updateGraph(event,'.$id.',0);">Ver todo</button>' ;   
        }
        ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-12" id="groupbar<?=$id?>">
        
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function (){
        Highcharts.chart('groupbar<?=$id?>', {
            chart: {
                type: '<?=$type?>'
            },
            credits: {
                        enabled: false
            },
            title: {
                text: '<?=$titulo?>'
            },
            subtitle: {
                text: '' //'Source: WorldClimate.com'
            },
            xAxis: {
                categories: [<?=$categories;?>],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Obras'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:14px;font-weight:bold;">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:,.0f} </b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [<?=$series?>]
        });
    });
</script>