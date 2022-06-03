<?php 
//if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
//Barras
//require_once dirname(__FILE__) . '/SVGGraph/autoloader.php';

class ReportePdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }
    function config()
    {
        $this->SetCreator(PDF_CREATOR);
        $this->SetAuthor('FIGO');
        $this->SetTitle('Ficha de actividades');
        $this->SetSubject('TCPDF Tutorial');
        $this->SetKeywords('TCPDF, PDF, example, test, guide');
        $this->setPrintHeader(true); 
        $this->setPrintFooter(true);
        $this->SetAutopageBreak(false);
        // set header and footer fonts
        $this->AddPage();
    }
    function H1($style='')
    {
        $this->SetFont('Helvetica',$style,16);
    }
    function H2($style=''){
        $this->SetFont('Helvetica',$style,14);
    }
    function H3($style=''){
        $this->SetFont('Helvetica',$style,11);
    }
    function body($data)
    {
        //Segmento inicial
       
        $x = 15; $y = 0;
        //Background
        //$this->SetFillColor(255,255,255);
        // MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

        //Titulo x, y, w, h, estilo, borde, color_relleno
        $this->fondo();
        $this->Rect(0, 15, 210,10,'DF','',array(42,52,67));
        
         //Imagen 
         //$this->Image('public/img/elementos_web_sigo/logo_seplan.png', 10,0,50,15,'PNG','','',false,300);
         //$this->Image('public/img/logo_sigo.png', 60,0,50,15,'PNG','','',false,300);

        if(strlen($data['actividad']) < 40) $this->H2('');
        else $this->SetFont('Helvetica','',9);
        $this->SetTextColor(255,255,255);

        $this->MultiCell(210,10,$data['actividad'],0,'C',0,0,0,15,true,1,false,true,10,'M',false);


        $this->H2('B');
        $this->SetTextColor(42,52,67);
        $y = 25;
        /*$this->SetXY($x,$y);
        $this->Cell(50,10,"Alineación");*/

        $this->SetXY($x,$y);
        $this->MultiCell(40,20,"Dependencia:",0,'L',0,0);
        $this->H3();
        $this->MultiCell(0,20,$data['vdependencia'],0,'L',0,1);
        //$this->MultiCell(80,20,$data['vdependencia'],0,'J',0,0,$x+95,$y+8,true,0,true,true);
        $this->SetXY($x,$y+8);
        $this->H2('B');
        $this->MultiCell(40,20,"Alineación:",0,'L',0,0);
        $y = 40;
        //Imagenes de ODS
        $posX = 15;
        if(isset($data['ods'])&&!empty($data['ods']))
        {
            foreach ($data['ods'] as $ods)
            {
                $this->Image('public/img/ods/'.$ods->iIdOds.'_50.png', $posX, $y, 10, 10, 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);
                $posX = $posX + 10;
            }
        }
      
        //Arreglo de Ejes
        if(isset($data['lineasaccion'])&&!empty($data['lineasaccion']))
        {
            foreach($data['lineasaccion'] as $linea)
            {
                $y = $y + 10;
                $this->Rect($x,$y,180,65,'DF',array('width' => 0, 'color' => array(255,241,242), 'dash' => 2, 'cap' => 'round'),array(255,255,255));
                $y = $y+2;
                $this->H2('U');
                $this->SetXY($x+5,$y);
                $this->Cell(50,10,"Eje PED");

                $this->SetXY($x+105,$y);
                $this->Cell(50,10,"Política pública");
                //Contenido
                $this->H3();
                $this->MultiCell(90,20,$linea->vEje,0,'J',0,0,$x+5,$y+10,true,0,true,true,20);
                $this->MultiCell(75,20,$linea->vTema,0,'J',0,0,$x+105,$y+10,true,0,true,true,20);

                $y = $y+24;
                $this->H2('U');
                $this->SetXY($x+5,$y);
                $this->Cell(50,10,"Estrategia");

                $this->SetXY($x+105,$y);
                $this->Cell(50,10,"Línea de acción");        

                $this->H3();
                $this->MultiCell(90,20,$linea->vEstrategia,0,'J',0,0,$x+5,$y+10,true,0,true,true,20);
                $this->MultiCell(75,20,$linea->vLineaAccion,0,'J',0,0,$x+105,$y+10,true,0,true,true,20);
                $y = $y + 30;
                //Checa si la nueva linea no da en la página
                if(($y+65)>=270)
                {
                    $this->AddPage();
                    $this->fondo();
                    $y = 5;
                }
            }
        }
        $this->H2('B');
        $y = $y+15;
        $this->SetXY($x,$y);
        $this->Cell(50,10,"Entregables");
        $this->H3();
        if(isset($data['entregables'])&&!empty($data['entregables']))
        {
            foreach($data['entregables'] as $key=>$entregable)
            {
                $y = $y + 10;
                $this->Rect($x,$y,180,34,'DF',array('width' => 0, 'color' => array(255,241,242), 'dash' => 2, 'cap' => 'round'),array(255,255,255));
                $this->H2();
                $this->SetXY($x+5,$y);
                
                $this->Cell(50,10,"Indicador ".($key+1));
                $this->SetXY($x+80,$y);
                $this->Cell(50,10,"Meta");                
                $this->SetXY($x+130,$y);
                $this->Cell(50,10,"Avance");
                $this->SetXY($x+155,$y);
                //$this->Cell(50,10,"Ejercido");
                $this->H3();
                $this->MultiCell(75,34,$entregable['vEntregable'],0,'J',0,0,$x+5,$y+10,true,1,true,true,34);
                $this->SetFont('Helvetica','',9);
                $meta = ($entregable['vMetaModificada'] > 0) ? $entregable['vMetaModificada']:$entregable['vMeta'];
                $pct = ($meta> 0) ? ( $entregable['vAvance'] / $meta ) * 100 : 0;
                if($pct > 100) $pct = 100;                

                $this->MultiCell(65,34,number_format($meta,2),0,'J',0,0,$x+80,$y+10,true,0,true,true,34);
                $this->MultiCell(65,34,number_format($entregable['vAvance'],2),0,'J',0,0,$x+130,$y+10,true,0,true,true,34);
                //$this->MultiCell(65,34,'$'.number_format($entregable['ejercido'],2),0,'J',0,0,$x+155,$y+10,true,0,true,true,34);
                // 50 es el 100%
                $width = 40 * $pct / 100;
                $round = 1.5;
                if($width==0)
                    $round = 0;
                $this->H3();
                $this->RoundedRect($x+80, $y+15, 40, 3, 1.5, '1111', 'DF',0,array(244,245,246));
                $this->RoundedRect($x+80, $y+15, $width, 3, $round, '0011', 'DF',0,array(42,52,67));

                $this->MultiCell(65,34,number_format($pct,2).'%',1,'L',0,0,$x+110,$y+10,true,0,true,true,34);
                
                $y = $y + 25;
                if($y>=255)
                {
                    $this->AddPage();
                    $this->fondo();
                    $y = 10;
                }
            }
        }
        /*
        if($y>160)
        {
            $this->AddPage();
            $this->fondo();
            $y = 10;
        }
        $this->H2('B');
        $y = $y+15;
        $this->SetXY($x,$y);
        $this->Cell(50,10,"Datos financieros");
        $this->SetX($x+95);
        $this->Cell(50,10,"Municipios meta");
        $map = $this->genMap($data['edos_a_pintar'],$data['idactividad']);
        $colours = array('rgb(42,52,67)','blue');
        $settings = array(
            'axis_overlap' => 2,
            'bar_width' => 40,
            'data_labe_type'=>array('box','box'),
            'show_data_labels'=>true,
            'data_label_position'=>'above',
            'data_label_popfront'=>true
          );
        //Barras
        // $graph = new Goat1000\SVGGraph\SVGGraph(600, 400,$settings);
        // $graph->colours($colours);
        // $graph->Values(['Modificado'=>$data['presupuesto_modificado'], 'Ejercido'=>$data['presupuesto_ejercido']]); 
        // $output = $graph->fetch('BarGraph');
        // $this->imageSVG('@' . $output, $x, $y+10, 90, 80, 'http://localhost', '', 'T', false, '', '', false, false, 0, false, false, false);

        //Dona
        $this->donutGraph($x,$y+10,35,array($data['presupuesto_modificado'],$data['presupuesto_ejercido'],$data['nPresupuestoModificado']),array('Modificado','Ejercido','Modificado2'));
        //Mapa
        $this->Rect($x+95,$y+10,85,80,'F',array('width' => 10, 'color' => array(255,241,242), 'dash' => 2, 'cap' => 'round'),array(255,255,255));
        $this->imageSVG('@'. $map, $x+105, $y+10, 105, 100, '', '', 'T', false, '', '', false, false, 0, false, false, false);    
        */
    }

    function bodyobj($data)
    {
        //Segmento inicial
       
        $x = 15; $y = 0;
        //Background
        //$this->SetFillColor(255,255,255);
        // MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

        //Titulo x, y, w, h, estilo, borde, color_relleno
        $this->fondo();
        $this->Rect(0, 15, 210,10,'DF','',array(42,52,67));
        
         //Imagen 
         //$this->Image('public/img/elementos_web_sigo/logo_seplan.png', 10,0,50,15,'PNG','','',false,300);
         //$this->Image('public/img/logo_sigo.png', 60,0,50,15,'PNG','','',false,300);

        if(strlen($data['actividad']) < 40) $this->H2('');
        else $this->SetFont('Helvetica','',9);
        $this->SetTextColor(255,255,255);

        $this->MultiCell(210,10,$data['actividad'],0,'C',0,0,0,15,true,1,false,true,10,'M',false);


        $this->H2('B');
        $this->SetTextColor(42,52,67);
        $y = 25;
        $this->SetXY($x,$y);
        $this->Cell(50,10,"Dependencia:");
        $this->H3();
        $this->MultiCell(80,20,$data['vdependencia'],0,'J',0,0,$x,$y+8,true,0,true,true);
        $y = 40;

        //Arreglo de Ejes
        if(isset($data['lineasaccion'])&&!empty($data['lineasaccion']))
        {
            foreach($data['lineasaccion'] as $linea)
            {
                $y = $y + 10;
                $this->Rect($x,$y,180,65,'DF',array('width' => 0, 'color' => array(255,241,242), 'dash' => 2, 'cap' => 'round'),array(255,255,255));
                $y = $y+2;
                $this->H2('U');
                $this->SetXY($x+1,$y);
                $this->Cell(50,10,"Descripción");

                $this->H3();

                $this->MultiCell(175,20,$data['descact'],0,'J',0,0,$x+1,$y+10,true,0,true,true,20);

                $y = $y+30;
                $this->H2('U');
                $this->SetXY($x+1,$y);
                $this->Cell(50,10,"Objetivo");

                $this->H3();
                $this->MultiCell(175,20,$data['objact'],0,'J',0,0,$x+1,$y+10,true,0,true,true,20);
                //$this->MultiCell(90,20,$linea->vObjetivo,0,'J',0,0,$x+5,$y+10,true,0,true,true,20);
                $y = $y + 30;
                //Checa si la nueva linea no da en la página
                if(($y+65)>=270)
                {
                    $this->AddPage();
                    $this->fondo();
                    $y = 5;
                }
            }
        }
        $this->H2('B');
        $y = $y+15;
        $this->SetXY($x,$y);
        $this->Cell(50,10,"Entregables");
        $this->H3();
        if(isset($data['entregables'])&&!empty($data['entregables']))
        {
            foreach($data['entregables'] as $key=>$entregable)
            {
                $y = $y + 10;
                $this->Rect($x,$y,180,34,'DF',array('width' => 0, 'color' => array(255,241,242), 'dash' => 2, 'cap' => 'round'),array(255,255,255));
                $this->H2();
                $this->SetXY($x+5,$y);
                
                $this->Cell(50,10,"Indicador ".($key+1));
                $this->SetXY($x+80,$y);
                $this->Cell(50,10,"Meta");                
                $this->SetXY($x+130,$y);
                $this->Cell(50,10,"Avance");
                $this->SetXY($x+155,$y);
                $this->Cell(50,10,"Ejercido");
                $this->H3();
                $this->MultiCell(75,34,$entregable['vEntregable'],0,'J',0,0,$x+5,$y+10,true,1,true,true,34);
                $this->SetFont('Helvetica','',9);
                $pct = ($entregable['vMeta'] > 0) ? ( $entregable['vAvance'] / $entregable['vMeta'] ) * 100 : 0;
                if($pct > 100) $pct = 100;
                
                $this->MultiCell(65,34,number_format($entregable['vMeta'],2),0,'J',0,0,$x+80,$y+10,true,0,true,true,34);
                $this->MultiCell(65,34,number_format($entregable['vAvance'],2),0,'J',0,0,$x+130,$y+10,true,0,true,true,34);
                $this->MultiCell(65,34,'$'.number_format($entregable['ejercido'],2),0,'J',0,0,$x+155,$y+10,true,0,true,true,34);
                // 50 es el 100%
                $width = 40 * $pct / 100;
                $round = 1.5;
                if($width==0)
                    $round = 0;
                $this->H3();
                $this->RoundedRect($x+80, $y+15, 40, 3, 1.5, '1111', 'DF',0,array(244,245,246));
                $this->RoundedRect($x+80, $y+15, $width, 3, $round, '0011', 'DF',0,array(42,52,67));

                $this->MultiCell(65,34,number_format($pct,2).'%',1,'L',0,0,$x+110,$y+10,true,0,true,true,34);
                
                $y = $y + 25;
                if($y>=255)
                {
                    $this->AddPage();
                    $this->fondo();
                    $y = 10;
                }
            }
        }
        if($y>160)
        {
            $this->AddPage();
            $this->fondo();
            $y = 10;
        }
        $this->H2('B');
        $y = $y+15;
        $this->SetXY($x,$y);
        $this->Cell(50,10,"Datos financieros");
        $this->SetX($x+95);
        $this->Cell(50,10,"Meta por municipio");
        $map = $this->genMap($data['edos_a_pintar'],$data['idactividad']);
        $colours = array('rgb(42,52,67)','blue');
        $settings = array(
            'axis_overlap' => 2,
            'bar_width' => 40,
            'data_labe_type'=>array('box','box'),
            'show_data_labels'=>true,
            'data_label_position'=>'above',
            'data_label_popfront'=>true
          );
        //Barras
        // $graph = new Goat1000\SVGGraph\SVGGraph(600, 400,$settings);
        // $graph->colours($colours);
        // $graph->Values(['Modificado'=>$data['presupuesto_modificado'], 'Ejercido'=>$data['presupuesto_ejercido']]); 
        // $output = $graph->fetch('BarGraph');
        // $this->imageSVG('@' . $output, $x, $y+10, 90, 80, 'http://localhost', '', 'T', false, '', '', false, false, 0, false, false, false);

       //Dona
        $this->donutGraph($x,$y+10,35,array($data['presupuesto_modificado'],$data['presupuesto_ejercido']),array('Modificado','Ejercido'));
        //Mapa
        $this->Rect($x+95,$y+10,85,80,'F',array('width' => 10, 'color' => array(255,241,242), 'dash' => 2, 'cap' => 'round'),array(255,255,255));
        $this->imageSVG('@'. $map, $x+105, $y+10, 105, 100, '', '', 'T', false, '', '', false, false, 0, false, false, false);    
    }
    function fondo()
    {
        
        $this->Rect(0, 15,210,282,'DF','',array(242,243,244));
    }
    function donutGraph($x=0,$y=0,$r=60,$data=array(1,1,1),$legend=array())
    {
        //data: vTotal, vAcumulado
        //legend: tTotal, tAcumulado
        //  #Circle( $x0, $y0, $r, $angstr = 0, $angend = 360, $style = '', $line_style = array(), $fill_color = array(), $nc = 2 )
        $pad = 5;
        $pady = 5;
        $style6 = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,10', 'color' => array(0, 128, 0));
        $pct = ($data[0] > 0 ) ? ($data[1] / $data[0]) * 100:0;
      
        //Fondo
        $this->Rect($x,$y,$r*2+15+$pady,$r*2+10,'F',array('width' => 10, 'color' => array(255,241,242), 'dash' => 2, 'cap' => 'round'),array(255,255,255));
        $this->Circle($x+$r+$pad,$y+$r+$pady,$r,90,360,'F','',array(42,52,67));
        $this->Circle($x+$r+$pad,$y+$r+$pady,$r-7,90,360,'F','',array(255,255,255));
        
        $this->Circle($x+$r+$pad,$y+$r+$pady,$r-12,90,360,'F','',array(242,243,244));
        $color = array(0,0,255);
        if($pct>100)
        {
            //$color = array(255,0,0);
            $avance = 90;
            $pct=100;
        }
        else
        {
            
            if($pct<1)
                $avance = 359;
            else{

                $avance = 360-$pct/100 * 270;
            }
            
        }
        
        //$this->Circle($x+$r+$pad,$y+$r+$pady,$r-12,$avance,360,'F','',$color);
        $this->SetFillColor(0,0,255);
        $this->PieSector($x+$r+$pad,$y+$r+$pady,$r-12,$avance,360,'FD',false,0,2);
        // pct% Acumulado
        
        $this->Circle($x+$r+$pad,$y+$r+$pady,$r-19,90,360,'F','',array(255,255,255));
        $this->Rect($x+$r+$pad,$y+$pady,$r,$r,'F',array('width' => 0, 'color' => array(255,241,242), 'dash' => 2, 'cap' => 'round'),array(255,255,255));
        $this->H2();
        $this->SetXY($x+$r-10+$pad,$y+$r-10+$pady);
        $this->Cell(40,20,(number_format($pct,2).'%'));
        
        
        //Linea 1
        $this->setTextColor(42,52,67);
        $this->H3('B');
        $this->Setxy($x+$r+$pad,$y-8+$pady);
        $this->Cell(40,20,'Presupuesto');

        $this->H3();
        $this->Setxy($x+$r+2+$pad,$y-4+$pady);
        $this->Cell(40,20,'$ '.number_format($data[0],2));

        //Línea 2
        $this->H3('B');        
        $this->Setxy($x+$r+$pad,$y+0+$pady);
        $this->Cell(40,20,'Presupuesto Modificado');

        $this->H3();
        $this->Setxy($x+$r+2+$pad,$y+4+$pady);
        $this->Cell(40,20,'$ '.number_format($data[2],2));

        //Línea 3
        $this->H3('B');        
        $this->Setxy($x+$r+$pad,$y+8+$pady);
        $this->Cell(40,20,'Presupuesto ejercido');

        $this->H3();
        $this->Setxy($x+$r+2+$pad,$y+12+$pady);
        $this->Cell(40,20,'$ '.number_format($data[1],2));

        
    }

    function Footer()
    {
        $var = date('d-m-Y H:i:s');
        $this->SetY(-15);
        $this->SetFont('Helvetica', '', 8);
        // Page number
        $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages().' -   '.$var, 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
    function Header()
    {
        $this->Rect(0, 0, 210, 15, 'DF', '', array(255, 255, 255));
        $this->Image('public/img/elementos_web_sigo/logo_seplan.png', 10,1,60,13,'PNG','','',false,300);
        $this->Image('public/img/logo_sigo.png', 150,1,45,13,'PNG','','',false,300);
        

    }

    function genMap($edos_a_pintar, $idactividad)
    {
            $ruta = str_replace('system','',BASEPATH).'public/';
           // $ruta = './';
     //       $file = fopen($ruta.'ImgTemporal/'.$idactividad.'.svg', "w");

            $cadena = <<<EOD
<?xml version="1.0" standalone="no"?>
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 20010904//EN"
    "http://www.w3.org/TR/2001/REC-SVG-20010904/DTD/svg10.dtd">
<svg version="1.0" xmlns="http://www.w3.org/2000/svg"
    width="1024px" height="800px" viewBox="0 0 1024 800"
    preserveAspectRatio="xMidYMid meet">
<metadata>
    Created by JLira, using GeoJSON
</metadata>
<g transform="translate(0.000000,600.000000) scale(0.70000, 0.60000)" fill="#FF0000" stroke="none">\n
EOD;
        $json = file_get_contents($ruta."data.json");
        $data = json_decode($json);
        //$array= array(1,5,15,33,48,65,104);
        foreach ($data->mapData as $key => $value) {
            if(in_array($value->id, $edos_a_pintar))
                $relleno = "#29225b";
            else
                $relleno = "none";
            $cadena = $cadena.'<path stroke="black" id="'.$value->id.'" fill="'.$relleno.'"'."\n".' d="'.$value->path.'" />'."\n";
        }
        $cadena = $cadena. " </g>\n
        </svg>";
        return $cadena;
    }
    function generate($data)
    {
        $actividad = (isset($data['actividad']->vActividad))?$data['actividad']->vActividad:'';
        $contenido_lineasaccion = $data['contenido_lineasaccion'];
        $contenido_entregables = $data['contenido_entregables'];
        //imagen
        
        $ruta_imagen = base_url().'public/grafica.php?vtotal='.$data['presupuesto_modificado'].'&vpctv='.$data['presupuesto_ejercido'].'&t=b';
        $ruta_avance = base_url().'public/grafica.php?vtotal='.$data['presupuesto_modificado'].'&vpctv='.$data['presupuesto_ejercido'].'&t=x';
        $ruta_mapa = base_url().'public/ImgTemporal/'.$data['idactividad'].'.svg';
        $pct1 = 50;
        $pct2 = 50;
        $pe = 10000;
        $data['presupuesto_ejercido'] = 1400000;
        $settings = array(
            'axis_overlap' => 2,
            'bar_width' => 40
          );
        $graph = new Goat1000\SVGGraph\SVGGraph(600, 400,$settings);
        
        $graph->Values(['Modificado'=>$data['presupuesto_modificado'], 'Ejercido'=>$data['presupuesto_ejercido']]); 
        $output = $graph->fetch('BarGraph');
        $html= <<<EOD
<table valign="center" align="center" style="padding:5px;" >
<tr >
    <td style="text-align: center; background-color: #293543; color: #FFFFFF; font-size:14px; font-family: Arial, Helvetica, sans-serif;">
    $actividad
    </td>
</tr>
</table>

<table valign="center" style="background-color:#F2F3F4; width:100%;">
<tr><td>
$contenido_lineasaccion
</td></tr>
</table>

<table valign="center" style="background-color:#F2F3F4; width:100%;">
<tr><td>
$contenido_entregables 
</td></tr>
</table>
EOD;
    /*$img = file_get_contents($ruta_imagen);*/
    

    
    $this->writeHTMLCell(190,'',10,25, $html, '');
    
    $this->lastPage();
    $this->AddPage();
    $html=<<<EOD
    <table align="center" style="width: 100%;  background-color:#FFFFFF; border:2px solid #F2F3F4;">
    <tr style="background-color: #F2F3F4;">
        <td  style="width:260px; font-weight: bolder; text-align: left; font-size:12px; font-family: Panton-Regular, Helvetica, sans-serif;">Datos financieros<br />
        </td>
        <td  style="width:270px; font-weight: bolder; text-align: left; font-size:12px; font-family: Panton-Regular, Helvetica, sans-serif;">Municipios a beneficiar<br />
        </td>
    </tr>
    </table>
EOD;
    $this->writeHTMLCell(90,'',10,25, $html, '');
    $value = $this->getY();
    $this->imageSVG('@' . $output, 10, 40, 100, 80, 'http://localhost', '', 'T', false, '', '', false, false, 0, false, false, false);
    $this->imageSVG($ruta_mapa, 120, 40, 110, '', 'http://localhost', '', 'T', false, '', '', false, false, 0, false, false, false);    
        //$this->writeHTML($contenido_lineasaccion,true,false,true,false,'' );
    //$this->writeHTML($html, true, false, true, false, '');
    //$this->Image(base_url().'public/grafica.php?vtotal=10000&vpctv=5000', 10,5,100,150,'PNG','','',false,300);
    }

    function mapaAnexo($ejeid, $regiones)
    {
        $resp = array();
        $n_arr = array();        
        asort($regiones);        
        foreach ($regiones as $key => $value) {
            array_unshift($n_arr, $key);
        }
        $n_arr2 = array_flip($n_arr);        

        $colores[1] = array('#012820', '#024F3E', '#02765D', '#029D7B', '#02C59A', '#01ECB9', '#16FFCC');
        $colores[2] = array('#020A11', '#061F34', '#082946', '#0C3E6A', '#10528D', '#1367B1', '#167CD6');
        $colores[3] = array('#43355B', '#554374', '#66508E', '#795FA6', '#8E77B5', '#A390C4', '#B8A9D2');
        $colores[4] = array('#40520F', '#5A7414', '#749619', '#8EB81E', '#A9DB22', '#B7E242', '#C4E864');
        $colores[5] = array('#25132F', '#3C1E4B', '#522968', '#683385', '#7F3EA2', '#944BBC', '#A667C7');
        $colores[6] = array('#034962', '#036689', '#0382B0', '#039FD7', '#05BBFD', '#2BC6FE', '#51D1FF');
        $colores[7] = array('#000000', '#141413', '#292925', '#3E3E38', '#53534A', '#69695B', '#7F7F6C');
        $colores[8] = array('#233B3F', '#315359', '#3E6B73', '#4B838D', '#589BA8', '#71ABB6', '#8ABBC4');
        $colores[9] = array('#1C3656', '#254974', '#2E5C92', '#366EB1', '#4682C8', '#6496D2', '#82ABDB');
        $colores[10] = array('#020A11', '#061F34', '#082946', '#0C3E6A', '#10528D', '#1367B1', '#167CD6');

        $ruta = str_replace('system','',BASEPATH).'public/';
           // $ruta = './';
     //       $file = fopen($ruta.'ImgTemporal/'.$idactividad.'.svg', "w");

        $cadena = <<<EOD
<?xml version="1.0" standalone="no"?>
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 20010904//EN"
    "http://www.w3.org/TR/2001/REC-SVG-20010904/DTD/svg10.dtd">
<svg version="1.0" xmlns="http://www.w3.org/2000/svg"
    width="1024px" height="800px" viewBox="0 0 1024 800"
    preserveAspectRatio="xMidYMid meet">
<metadata>
    Created by JLira, using GeoJSON
</metadata>
<g transform="translate(0.000000,600.000000) scale(0.70000, 0.60000)" fill="#FF0000" stroke="none">\n
EOD;
        $json = file_get_contents($ruta."data.json");
        $data = json_decode($json);
        //$array= array(1,5,15,33,48,65,104);
        foreach ($data->mapData as $key => $value) {
            $color = $n_arr2[$value->reg];
            $relleno = $colores[$ejeid][$color]; //"#29225b";
            /*
            if(in_array($value->id, $regiones))
                $relleno = $colores[$ejeid][5]; //"#29225b";
            else
                $relleno = "none";
            */
            $cadena = $cadena.'<path stroke="black" id="'.$value->id.'" fill="'.$relleno.'"'."\n".' d="'.$value->path.'" />'."\n";
        }
        $cadena = $cadena. " </g>\n
        </svg>";

        array_push($resp, $cadena);
        array_push($resp, $n_arr2);
        array_push($resp, $colores);

        return $resp;
    }
}