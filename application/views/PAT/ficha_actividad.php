<!DOCTYPE html>
<html dir="ltr" lang="en">
<title>Ficha de actividad</title>
    <link href="<?= base_url() ?>public/assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>public/dist/css/style.css" rel="stylesheet">
    <style type="text/css">
        #contenido {
            min-height: calc(100vh - 168px) !important;
        }

        @media print {
            .noImprimir{ display:none }
        }
    </style>
<style type="text/css">
        .auto-style1 {
            height: 27px;
        }
        .auto-style2 {
            height: 26px;
        }
        .auto-style4 {
            height: 26px;
            width: 453px;
        }
        .auto-style5 {
            width: 95%;
            height: 31px;
            margin-left: 34px;
        }
        .auto-style6 {
            width: 95%;
            height: 40px;
        }
        .auto-style7 {
            height: 28px;
        }
        .auto-style8 {
            height: 27px;
            width: 565px;
        }
        .auto-style9 {
            width: 95%;
            height: 32px;
        }
        
    </style>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SIGO</title>
</head>
<body style="height: 100%; width:100%; background-color: #F2F3F4; font-family: Arial, Helvetica, sans-serif;" >

<table align="center" style="width: 95%; background-color: #FFFFFF;">
    <tr>
        <td valign="middle" class="auto-style2">
            <img src="public/img/elementos_web_sigo/logo_seplan.png" width="150px" alt="logo" class="dark-logo" />
            <img src="public/img/logo_sigo.png" width="140px" class="light-logo" alt="logo" />
        </td>
    </tr>
</table>
<table align="center" class="auto-style6">
    <tr>
    <td style="text-align: center; background-color: #293543; color: #FFFFFF; font-family: Arial, Helvetica, sans-serif;">
    <?= $actividad->vActividad ?>
    </td>
    </tr>
</table>

<?= $contenido_lineasaccion ?>
<br>
<?= $contenido_entregables ?>
<br/>
<table align="center" style="width: 95%; height: 300px; background-color: #FFFFFF;">
    <tr style="background-color: #F2F3F4;">
        <td  style="font-weight: bolder">Datos financieros<br />
        </td>
        <td  style="font-weight: bolder">Mapa<br />
        </td>
    </tr>
    <tr>
        <td valign="top">
        <img style="height: 250px; width:250;" src="public/ImgTemporal/<?=$idactividad?>.png" />
        
          
        </td>
        
        <td valign="top">
            <img style="height: 300px; width:270;" src="public/ImgTemporal/<?=$idactividad?>.svg" />
           
                        </td>
                    </tr>
 </table>
 <div>

    </div>
    
</body>

</html>