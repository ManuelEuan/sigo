<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_ractividad extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->library('excel');
        $this->load->helper('url');        
        $this->load->library('Class_options');
        $this->load->model('M_pat', 'pat');
        $this->load->model('M_reporteAct','mra');
    }

     public function index()
    {
        $options = new Class_options();
        $datos['ejes'] = $options->options_tabla('eje');        
        $this->load->view('reporte/actividades_c',$datos);
    }

    public function dependencias()
    {
        $ejeid = $this->input->post('id', TRUE);
        $ent = new M_reporteAct();
        $dep = $ent->dependencias($ejeid);
        if($dep!=false)
        {
            echo '<option value="0">Seleccione..</option>';
            foreach ($dep as $vdep) {
                echo '<option value="'.$vdep->iIdDependencia.'">'.$vdep->vDependencia.'</option>';
            }
        }
        else echo '<option value="0">Seleccione..</option>'; 
    }    

    public function total_act()
    {
        $eje = $this->input->get('eje',true);
        $dep = $this->input->get('dep',true);
        $anio = $this->input->get('anio',true);

        $resp = $this->mra->carga_actividades($eje, $dep, $anio);        
        if($resp != false) echo json_encode($resp);
        else echo 'error';

    }

    public function genera_ract()
    {
        $userid = $_SESSION[PREFIJO.'_idusuario'];
        $dir = "public/fichas_".$userid."/";

        if(is_dir($dir)==false)
        {
            if(!mkdir($dir, 0777, true)) {
                die('Fallo al crear las carpetas...');
            }            
        }

        $id_detact = $this->input->post('iIdActividad', TRUE);                
        try {
            $data= $this->Ficha_Actividad($id_detact);        
            $this->load->library('ReportePdf');
            $pdf = new ReportePdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);    
            $pdf->config();
            $pdf->generate($data);
            //$pdf->Output('FichaActividad.pdf', 'D'); 
            $pdf->Output($_SERVER['DOCUMENT_ROOT'].'sigov2/'.$dir.'/FichaActividad_'.$id_detact.'.pdf', 'F');
            echo '1';
        } catch (Exception $e) {
            echo "0";
        }           
    }

    public function descargar()
    {        
        $usid = $_SESSION[PREFIJO.'_idusuario'];
        $directorio = "public/fichas_".$usid."/";

        
        $zip = new ZipArchive();
        $dir = $directorio."/fichas_us_".$usid.".zip";
        $ficheros1  = scandir($directorio);

        if($zip->open($dir, ZIPARCHIVE::CREATE)==TRUE)
        {
            for ($i=0; $i < count($ficheros1); $i++) { 
                if($ficheros1[$i]!='.' && $ficheros1[$i]!='..')
                {
                    if(file_exists($directorio.'/'.$ficheros1[$i])) {
                        $zip->addFile($directorio.'/'.$ficheros1[$i]);                   

                    }
                }
            }

            $zip->close();

            header("Content-type: application/octet-stream");
            header("Content-disposition: attachment; filename=fichas.zip");

            readfile($dir);
            unlink($dir);
            

            for ($i=0; $i < count($ficheros1); $i++) { 
                if($ficheros1[$i]!='.' && $ficheros1[$i]!='..')
                {
                    unlink($directorio.'/'.$ficheros1[$i]);
                }
            }
            rmdir($directorio);
            echo $dir;

        }else echo'Error1';
        
    }

    function Ficha_Actividad($id_detact){

        //$id_detact = 657;

        if($id_detact != NULL){

            $data['actividad'] = $this->pat->obtener_informacion_actividad($id_detact);
            $data['lineasaccion'] = $this->pat->obtener_alineacion_actividad($id_detact);
            $pe = $this->pat->suma_presupuesto_ejercido($id_detact);
            $pm = $this->pat->suma_presupuesto_modificado($id_detact);
            $data['contenido_lineasaccion'] = $this->generar_lineasaccion_ficha($id_detact);
            $data['contenido_entregables'] = $this->generar_entregables_ficha($id_detact);
            $data['municipios'] = $this->pat->obtener_municipios_actividad($id_detact);
            $data['idactividad'] =$id_detact;
            if($pe->monto_total != NULL){
                $data['presupuesto_ejercido'] = $pe->monto_total;
            }else{
                $data['presupuesto_ejercido'] = 0;
            }
            if($pm->monto_total != NULL){
                $data['presupuesto_modificado'] = $pm->monto_total;
            }else{
                $data['presupuesto_modificado'] = 0;
            }
            //Imagen Gráfica
           // $image = imagecreatetruecolor(400,300);
           // $this->graficar($image, $data['presupuesto_modificado'], $data['presupuesto_ejercido']);
            //imagePNG($image,str_replace('system','',BASEPATH).'public/ImgTemporal/'.$data['idactividad'].'.png');
            //imagedestroy($image);
            //Fin de Imagen Gráfica

            //Municipios
           $mpios = array();
            foreach($data['municipios'] as $key=>$mun)
            {
                $mpios[] = $mun->iIdMunicipio;
            }
            $this->genSVG($mpios,$data['idactividad']);
            //genGrafica($idactividad,$presupuesto_modificado, $presupuesto_ejercido);
            //Fin de municipios
            //$data['grafica'] = $this->load->view('grafica', $data);
           // $this->load->view('PAT/ficha_actividad',$data);
           return $data;
        }
    }

    public function graficar($im, $total, $pctv)
    {
        $fondo = imagecolorallocate($im, 255, 255, 255);
        $arc100 = imagecolorallocate($im, 41, 34, 91);
        $arcpct = imagecolorallocate($im, 31, 111, 182);
        $letra = imagecolorallocate($im, 0, 0, 0);
        imagefilledrectangle($im,0,0,400,300, $fondo);
        $pct = 270 - $pctv*270/$total;
        if($pctv!=0)
        {
            imagefilledarc($im,130,150,150,150,$pct,270,$arcpct,IMG_ARC_EDGED);
            imagefilledarc($im,130,150,150,150,$pct,270,$arcpct,IMG_ARC_EDGED);
        }
        if($total!=0)
        {
            imagefilledarc($im,130,150,250,250,0,270,$arc100,IMG_ARC_EDGED);
            imagefilledarc($im,130,150,200,200,0,270,$fondo,IMG_ARC_EDGED);   
        }
        imagefilledrectangle($im,230,50,260,60, $arcpct);
        imagefilledrectangle($im,230,100,260,110, $arc100);
        imagestring ($im, 1,265,50,"Ppto ejercido:",$letra);
        imagestring ($im, 2,265,70,"$".$pctv,$letra);   
        imagestring ($im, 1,265,100,"Ppto Modificado:",$letra);
        imagestring ($im, 2,265,120,"$".$total,$letra); 
    }

    function genSVG($edos_a_pintar, $idactividad)
    {
            $ruta = str_replace('system','',BASEPATH).'public/';  

            $file = fopen($ruta.'ImgTemporal/'.$idactividad.'.svg', "w");

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
            fwrite($file, $cadena . PHP_EOL);
            fclose($file);
    }

    //crea el contenido de las lineas de accion del contenido de la ficha de actividad
    public function generar_lineasaccion_ficha($id_detact){

        $actividad = $this->pat->obtener_informacion_actividad($id_detact);
        $lineasaccion = $this->pat->obtener_alineacion_actividad($id_detact);
       
        $html = '<table style="width: 98%; padding:5px; font-size:12px; font-family: Panton-Regular, Helvetica, sans-serif;">
                        <tr style="background-color:#F2F3F4;">
                            <td style="font-weight: bolder; text-align: left; font-size:14px;">
                                Alineacion
                            </td>
                            <td style="text-align: left;">
                             <span style="font-weight: bolder;"> Dependencia:</span> <span style="font-size:11px;">'.((isset($actividad->vDependencia))?$actividad->vDependencia:'').'</span></td>
                        </tr>
                </table>';
                    foreach($lineasaccion as $la){

                        $html.= '
                        <table style="width:100%; background-color: #FFFFFF; padding-left:10px; padding-bottom:5px; padding-top:5px;">
                        <tr>
                            <td style="font-size:12px; font-family: Panton-Regular, Helvetica, sans-serif; text-decoration: underline; font-weight: bolder; text-align: left;">Eje PED
                            </td>
                            <td style="font-size:12px; font-family: Panton-Regular, Helvetica, sans-serif; text-decoration: underline; font-weight: bolder; text-align: left;">Politica publica
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size:11px; font-family: Panton-Regular, Helvetica, sans-serif; text-align: left;">
                            '.$la->vEje.'
                            </td>
                            <td style="font-size:11px; font-family: Panton-Regular, Helvetica, sans-serif; text-align: left;">
                                '.$la->vTema.'
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size:12px; font-family: Panton-Regular, Helvetica, sans-serif; text-decoration: underline; font-weight: bolder; text-align: left;">Estrategia
                            </td>
                            <td style="font-size:12px; font-family: Panton-Regular, Helvetica, sans-serif; text-decoration: underline; font-weight: bolder; text-align: left;">Linea de accion
                                </td>
                        </tr>
                        <tr>
                            <td style="font-size:11px; font-family: Panton-Regular, Helvetica, sans-serif; text-align: left;">
                            '.$la->vEstrategia.'
                            </td>
                            <td style="font-size:11px; font-family: Panton-Regular, Helvetica, sans-serif; text-align: left;">
                            '.$la->vLineaAccion.'
                            </td>
                        </tr>
                    </table>
                    <br>';
                    }
        return $html;
    }
    

    //Crea la seccion de entregables del contenido de la ficha de actividad
    public function generar_entregables_ficha($id_detact){

        $cont = 0;

        $entregables = $this->pat->mostrar_actividadentregables($id_detact);

        $html = '
            <table style="width:100%; padding-bottom:5px;">
                <tr>
                    <td style="font-weight: bolder; text-align: left; font-size:14px; font-family: Panton-Regular, Helvetica, sans-serif;">
                        Entregables
                    </td>
                </tr>
            </table>
            <div style="height:1px; background-color: #F2F3F4;"></div> ';

        foreach($entregables as $ent){
            $cont = $cont+1;
            $sumatotal = $this->pat->suma_avances_total($ent->iIdDetalleEntregable);
            if($sumatotal->total_avance != NULL){
                $total = $sumatotal->total_avance;
            }else{
                $total = 0;
            }
            $porcentaje = $total /($ent->nMeta)/100;
            $html.= '
            <table style="width:100%; padding-left:10px; padding-bottom:5px; padding-top:5px; background-color: #FFFFFF;">
                <tr>
                    <td style="width:250px; font-weight: bolder; text-align: left; font-size:12px; font-family: Panton-Regular, Helvetica, sans-serif;">Indicador '.$cont.'</td>
                    <td style="width:140px; font-weight: bolder; text-align: left; font-size:12px; font-family: Panton-Regular, Helvetica, sans-serif;">Avance</td>
                    <td style="width:130px; font-weight: bolder; text-align: left; font-size:12px; font-family: Panton-Regular, Helvetica, sans-serif;">Meta</td>
                </tr>
                <tr>
                    <td style="width:250px;">'.$ent->vEntregable.'</td>
                    <td style="width:140px;">
                                '.$total.' | '.$porcentaje.'%        
                    </td>
                    <td style="width:130px;">
                    '.$ent->nMeta.'
                    </td>
                </tr>
            </table>
            <div style="height:2px; background-color: #F2F3F4;"></div>';
            
        }
        
        return $html;
    }  
        

}