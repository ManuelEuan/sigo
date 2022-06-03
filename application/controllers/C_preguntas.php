<?php defined('BASEPATH') OR exit('No direct script access allowed');

class C_preguntas extends CI_Controller {

	public function __construct(){
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->library('Class_options');
        $this->load->model('M_preguntas', 'mp');
    }

    public function index(){
        //$data['consulta'] = $this->mum->mostrar_um();
        $options = new Class_options();
        $datos['ejes'] = $options->options_tabla('eje');
        $datos['bancada'] = $this->mp->bancadas();
        $datos['anio'] = $this->mp->anios('anio');
    	$this->load->view('preguntas/index', $datos);
    }

    public function cargar_preguntas()
    {
        $eje = $this->input->post('eje', TRUE);
        $anio = $this->input->post('anio', TRUE);
        $partido = $this->input->post('partido', TRUE);

        $datos['preguntas'] = $this->mp->carga_preguntas($eje, $anio, $partido);
        $this->load->view('preguntas/tabla', $datos);
    }

    public function modificar()
    {
        $options = new Class_options();

        $pregid = $this->input->post('pregid', TRUE);
        $datos_preg = $this->mp->datos_preg($pregid);
        
        $ejeid = $datos_preg[0]->iIdEje;
        $temaid = $datos_preg[0]->iIdTema;
        $objid = $datos_preg[0]->iIdObjetivo;
        $resp = $datos_preg[0]->iIdResponsable;
        $corresp = $datos_preg[0]->iIdCorresponsable;
        

        $datos['iIdPregunta'] = $pregid;
        $datos['bancada'] = $this->mp->bancadas();
        $datos['ejes'] = $options->options_tabla('eje',$ejeid);
        $datos['politica_publica'] = $options->options_tabla('tema',$temaid,'iIdEje = '.$ejeid);
        $datos['objetivos'] = $options->options_tabla('objetivo',$objid,'iIdTema = '.$temaid);
        $datos['dep_resp'] = $options->options_tabla('dependencias',$resp);
        $datos['dep_corresp'] = $options->options_tabla('dependencias',$corresp);
        $datos['datosPreg'] = $datos_preg;

        $this->load->view('preguntas/contenido_modificar', $datos);
    }

    public function crear()
    {
        $options = new Class_options();
        $datos['ejes'] = $options->options_tabla('eje');
        $datos['politica_publica'] = $options->options_tabla('tema');        
        $this->load->view('preguntas/contenido_agregar', $datos);
    }

    public function eliminar()
    {
        $pregid = $this->input->post('id', TRUE);

        $elimina = $this->mp->eliminar_pregunta($pregid);
        if($elimina==1) echo 'correcto';
        else echo 'error';
    }

    public function eliminar_doc()
    {
        $pregid = $this->input->post('pregid', TRUE);
        $r = $this->mp->datos_preg($pregid);
        $el = $this->mp->eliminar_doc($pregid);
        $ruta = 'archivos/preguntasPDF/'.$r[0]->vRuta;        

        //;
        if(file_exists($ruta)) 
        { 
            unlink($ruta);
            if($el==1) echo 'correcto'; 
            else echo 'error';
        }
        else 'error';
        
    }

    public function inserta_pregunta()
    {
        $datos["vPregunta"] = $this->input->post('vPregunta', TRUE);
        $datos["iAnio"] = $this->input->post('anio', TRUE);
        $datos["iIdEje"] = $this->input->post('iIdEje', TRUE);
        $datos["iIdTema"] = $this->input->post('iIdTema', TRUE);
        $datos["iIdObjetivo"] = $this->input->post('iIdObjetivo', TRUE);
        $datos["vRespuesta"] = $this->input->post('vRespuesta', TRUE);
        $datos["vBancada"] = $this->input->post('partido', TRUE);

        $inserta = $this->mp->inserta_pregunta($datos);
        if($inserta==1) echo 'correcto';
        else echo 'error';
    }

    public function actualizar_pregunta()
    {
        $iIdPregunta = $this->input->post('iIdPregunta', TRUE);

        $datos["vPregunta"] = $this->input->post('vPregunta', TRUE);
        $datos["iAnio"] = $this->input->post('anio', TRUE);
        $datos["iIdEje"] = $this->input->post('iIdEje', TRUE);
        $datos["iIdTema"] = $this->input->post('iIdTema', TRUE);
        $datos["iIdObjetivo"] = $this->input->post('iIdObjetivo', TRUE);
        $datos["vRespuesta"] = $this->input->post('vRespuesta', TRUE);
        $datos["vBancada"] = $this->input->post('partido', TRUE);
        $datos["iIdResponsable"] = $this->input->post('responsable', TRUE);
        $datos["iIdCorresponsable"] = $this->input->post('corresponsable', TRUE);

        $actualiza = $this->mp->actualiza_pregunta($datos, $iIdPregunta);
        if($actualiza == 1) echo 'correcto';
        else echo 'error';        
    }

    public function validar_doc()
    {   
        $array = array('error' => false , 'message'=>''); 
        $validador=0;
    
        $allowedfileExtensions = array('pdf');
        
        $file_name = $_FILES['files']['name'];
        $file_size =$_FILES['files']['size'];
        $file_tmp =$_FILES['files']['tmp_name'];
        $file_type=$_FILES['files']['type'];  
        $fileNameCmps = explode(".", $file_name);
        $fileExtension = strtolower(end($fileNameCmps));
        
        $limiteArchivo = "3072000‬";
        if($file_size>$limiteArchivo)
        {
            $array['error'] = true;
            $array['message'] = 'El archivo no debe ser mayor a 3 MB';
        }
        else if(!in_array($fileExtension, $allowedfileExtensions))
        {
            $array['error'] = true;
            $array['message'] = 'Extensión no permitida. Sólo se permiten archivos *.pdf';
        }            
                        
        echo json_encode($array);
    }

    public function subir_doc()
    { 

        $arr = array(" " => "_", "-" => "", "´" => "", 'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U', 'Ñ' => 'n', 'ñ' => 'n');
        
        $iIdPregunta = $this->input->post("pregid", TRUE);
        $file_name = $_FILES['files']['name'];
        $file_size =$_FILES['files']['size'];
        $file_tmp =$_FILES['files']['tmp_name'];
        $file_type=$_FILES['files']['type'];  
        $fileNameCmps = explode(".", $file_name);
        $fileExtension = strtolower(end($fileNameCmps));
        $time=time()."-";

        $f_name = 'ID_'.$iIdPregunta.$fileExtension;
    
        if(move_uploaded_file($file_tmp,"./archivos/preguntasPDF/".$f_name))
        {
            if($this->mp->subir_doc($f_name, $iIdPregunta) == 1) echo "correcto";
            else echo "error";   
        }
        else echo "error";
    }

    public function carga_sel()
    {
        $id = $this->input->post('id', TRUE);
        $op = $this->input->post('op', TRUE);

        $options = new Class_options();
        $resp = '<option value="0">Seleccione</option>';
                
        if($op==1) 
        {
            $where = 'iIdEje = '.$id;
            $resp.= $options->options_tabla('tema','', $where);
        }
        elseif($op==2) 
        {
            $where = 'iIdTema = '.$id;
            $resp.= $options->options_tabla('objetivo','', $where);
        }          
        else $resp = 'error';

        echo $resp;

    }

   
}