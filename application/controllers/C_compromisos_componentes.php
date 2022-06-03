<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	
	class C_compromisos_componentes extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			session_start();
			$this->load->helper('url');
			$this->load->helper('funciones');
			$this->load->library('Class_seguridad');
			$this->load->library('Class_options');
			$this->load->model('M_compromisos','comp');
			$this->load->model('M_componente','compt');
			$this->load->model('M_catalogos', 'catlogs');
		}
		public function porcentajeAvance(){
			$iIdCompromiso=$this->input->post("iIdCompromiso",TRUE);
			$where=array("iIdCompromiso"=>$iIdCompromiso, "iActivo" =>1);
			$this->compt->porcentajeAvance($where);
		}
		public function index()
		{
			$iIdCompromiso=$this->input->post("id",TRUE);
			$seg = new Class_seguridad();
			$options = new Class_options();
			$where["iIdCompromiso"] = $data["iIdCompromiso"] = $iIdCompromiso;
			$row = $this->comp->ConsultarCompromisos($where)->row();
			$data['vCompromiso'] = $row->iNumero.'. '.$row->vCompromiso ;
			$data['options_unidadmedida']  = $options->options_tabla('unidades_medida');
			
			$data['ponderacion']=$this->compt->consultaPonderacion($iIdCompromiso);
			$data['tabla_componente']=$this->tabla_componentes($iIdCompromiso);
				  $periodorevisionactivo = $this->comp->periodorevisionactivo();
			$data['periodorevision']=$periodorevisionactivo;
			$tipo_acceso = $seg->tipo_acceso(25,$_SESSION[PREFIJO.'_idusuario']);
			
			if($tipo_acceso > 0)
			{
				$this->load->view('compromisos/componentes/componente_index',$data);    
			}
			else 
			{
				echo '<p>Acceso denegado</p>';
			}
			
		}
		// Modulo Componente UBP
		public function agregarUbpComponente(){
			if($this->compt->agregarUbpComponente($_POST)===TRUE){
				echo "correcto";	
				}else{
				echo "incorrecto";
			}
		}
		public function eliminarUbpComponente(){
			if($this->compt->eliminarUbpComponente($_POST)===TRUE){
				echo "correcto";	
				}else{
				echo "incorrecto";
			}
		}
		
		public function insertarComponente(){
			if($this->compt->insertarComponente($_POST)===TRUE){
				echo "correcto";	
				}else{
				echo "incorrecto";
			}
		}
		public function updateComponente(){
			$where=array("iIdComponente"=>$_POST["iIdComponente"]);
			unset($_POST["iIdComponente"]);
			if($this->compt->updateComponente($_POST,$where)===TRUE){
				echo "correcto";	
				}else{
				echo "incorrecto";
			}
			
		}
		public function eliminarComponente(){
			if($this->compt->eliminarComponente($_POST)===TRUE){
				echo "correcto";	
				}else{
				echo "incorrecto";
			}
        }
        public function listarubp(){
            $data= $this->compt->listarubp($_POST);
            echo json_encode($data);
		}
		public function tabla_componenteubp($iIdComponente){
		  $periodorevisionactivo = $this->comp->periodorevisionactivo();
			$periodoactivo=($periodorevisionactivo==0) ? '' : 'disabled="disabled"';
			$where=array('iIdComponente'=>$iIdComponente);
			$ubpComponente = $this->compt->listado_ComponenteUBP($where);
			$html = '';
			if($ubpComponente->num_rows() > 0)
			{
				$html='
				<div class="col-12">
				<div class="card">
				<div class="card-body">
                <div class="table-responsive">';
				
                $html.= '<table class="table table-striped table-bordered display" style="width:100%" id="grid">
				<thead>
				<tr>
				<th>UBP</th>
				<th>Monto</th>
				<th width="200px;">Opciones</th>
				</tr>
				</thead>
				<tbody>';
				
				$ubpComponente = $ubpComponente->result();
				foreach ($ubpComponente as $c)
				{
					$option="confirmar('¿Esta usted seguro?',eliminar_componenteubp,$c->iIdUbp)";
					$html.= '<tr>
					<td>'.$c->vUBP.'</td>
					<td>'.$c->nMonto.'</td>					
					<td width="200px;">
					<button type="button" class="btn btn-circle waves-effect waves-light btn-danger" onclick="'.$option.'" '.$periodoactivo.'><i class="mdi mdi-close"></i></button>
					</td>
					</tr>';
				}
				$html.= ' </tbody></table>
				</div>
				</div>
				</div>
				</div>';
			}
			
			return $html;

		}
		public function tabla_componentes($iIdCompromiso)
		{
			  $periodorevisionactivo = $this->comp->periodorevisionactivo();
			$periodoactivo=($periodorevisionactivo==0) ? '' : 'disabled="disabled"';
			$where=array('c.iIdCompromiso'=>$iIdCompromiso, 'c.iActivo'=>1);
			$componente = $this->compt->listado_componentes($where);
			//  return $compromisos->result();
			
			$html = '';
			
			if($componente->num_rows() > 0)
			{
				$html='
				<div class="col-12">

				<div class="card">
				<div class="card-body">
                <div class="table-responsive">';
				
                $html.= '<table class="table table-striped table-bordered display" style="width:100%" id="grid">
				<thead>
				<tr>
				<th>Componente</th>
				<th>Ponderacion</th>
				<th>Avance</th>
				<th>Meta</th>
				<th>Meta modificada</th>
				<th>Unidad de medida</th>
				<th width="200px;">Opciones</th>
				</tr>
				</thead>
				<tbody>';
				
				$componente = $componente->result();
				foreach ($componente as $c)
				{
					$option="confirmar('¿Esta usted seguro?',eliminar_componente,$c->iIdComponente)";
					$html.= '<tr>
					<td>'.$c->vComponente.'</td>
					<td>'.$c->nPonderacion.'</td>
					<td>'.$c->nAvance.'</td>
					<td>'.$c->nMeta.'</td>
					<td>'.$c->nMetaModificada.'</td>
					<td>'.$c->vUnidadMedida.'</td>
					
					<td width="200px;">
					<button type="button" class="btn btn-circle waves-effect waves-light btn-warning" onclick="editar_componentes('.$c->iIdComponente.')"><i class="mdi mdi-border-color"></i></button>
					<button type="button" class="btn btn-circle waves-effect waves-light btn-danger" onclick="'.$option.'" '.$periodoactivo.'><i class="mdi mdi-close"></i></button>
					</td>
					</tr>';
				}
				// '.$opciones.'
				
				$html.= ' </tbody></table>
				</div>
				</div>
				</div>
				</div>';
			}
			
			return $html;
			
		}

		public function listar_Estatus_evidencia($iIdEvidencia,$iIdEstatus){
			$seg = new Class_seguridad();
			$revisarEvidencia = $seg->tipo_acceso(20,$_SESSION[PREFIJO.'_idusuario']);
			$permisoEstatus = ($revisarEvidencia <0) ? 'disabled="disabled"' :'';
		
			$where=array("vEntidadMide"=>"Evidencia");
			$evidencias_estatus = $this->compt->listar_Estatus_evidencia($where);	
			$html = '';
			if($evidencias_estatus->num_rows() > 0)
			{
				$html = '<select class="form-control" id="select-evidencia-'.$iIdEvidencia.'" onchange="actualizarEstatus('.$iIdEvidencia.')" '.$permisoEstatus.'>';
				$evidencias_estatus = $evidencias_estatus->result();
				foreach ($evidencias_estatus as $c)
				{	
					$seleccionado = ($iIdEstatus == $c->iIdEstatus) ? 'selected="selected"' : '';  
					$html.='<option value="'.$c->iIdEstatus.'" '.$seleccionado.'>'.$c->vEstatus.'</option>';		
				}
				$html.='<select>';
			}
			return $html;		
		}
		public function listado_evidencia_imagen(){
			$iIdComponente= $this->input->post("iIdComponente",TRUE);
			$where=array('iIdComponente'=>$iIdComponente, 'iActivo'=>1, "vTipo"=>"Fotografía");
			$evidencias = $this->compt->listado_evidencia($where);	
			
			
			$html = '';
			
			if($evidencias->num_rows() > 0)
			{
				$html='
				<div class="col-12">
				<div class="card">
				<div class="card-body">
                <div class="table-responsive">';
				
                $html.= '<table class="table table-striped table-bordered display" style="width:100%" id="grid">
				<thead>
				<tr>
				<th>Evidencia</th>
				<th>Estatus</th>
				<th width="200px;">Opciones</th>
				</tr>
				</thead>
				<tbody>';
				
				$evidencias = $evidencias->result();
				foreach ($evidencias as $c)
				{	
					$option_estatus=$this->listar_Estatus_evidencia($c->iIdEvidencia,$c->iEstatus);
		
					$option="confirmar_eliminar('¿Esta usted seguro?',eliminar_evidencia,$c->iIdEvidencia,$c->iIdComponente)";
					$html.= '<tr>
					<td><a href="'.base_url().'archivos/documentosImages/'.$c->vEvidencia.'" target="_blank">'.$c->vEvidencia.'<a></td>
					<td>'.$option_estatus.'</td>					
					<td width="200px;">
					<button type="button" class="btn btn-circle waves-effect waves-light btn-danger" onclick="'.$option.'"><i class="mdi mdi-close"></i></button>
					</td>
					</tr>';
				}
				$html.= ' </tbody></table>
				</div>
				</div>
				</div>
				</div>';
			}
			
			echo $html;		
		}
		public function descargarEvidencia(){
			$iIdComponente=$this->input->post("iIdComponente",TRUE);
			$zip = new ZipArchive;
			$nomenclatura="archivos/documentosZip/evidencias-".md5(time()).".zip";
			if ($zip->open($nomenclatura, ZipArchive::CREATE) === TRUE)
			{
				$where=array('iIdComponente'=>$iIdComponente, 'iActivo'=>1,"vTipo"=>"Documento");
				$evidencias_office = $this->compt->listado_evidencia($where);	
				$evidencias_office = $evidencias_office->result();
				foreach ($evidencias_office as $c)
				{	
					$zip->addFile('archivos/documentosOffice/'.$c->vEvidencia);
					//echo 'archivos/documentosOffice/'.$c->vEvidencia.'<br>';
				}
				$where=array('iIdComponente'=>$iIdComponente, 'iActivo'=>1,"vTipo"=>"Fotografía");		
				$evidencias_img = $this->compt->listado_evidencia($where);	
				$evidencias_img = $evidencias_img->result();
				foreach ($evidencias_img as $c)
				{	//echo 'archivos/documentosImages/'.$c->vEvidencia.'<br>';
					$zip->addFile('archivos/documentosImages/'.$c->vEvidencia);
				}

				$where=array('iIdComponente'=>$iIdComponente, 'iActivo'=>1,"vTipo"=>"Video");		
				$evidencias_video = $this->compt->listado_evidencia($where);	
				$evidencias_video = $evidencias_video->result();
				$namearchivo="archivos/enlacesYoutube/evidencia-link".md5(time()).".txt";
				$archivo = fopen($namearchivo,'a');
				$contenido='';
				foreach ($evidencias_video as $c)
				{	
					$contenido.=$c->vEvidencia."\n";				
				}
				fputs($archivo,$contenido);
				fclose($archivo);
				$zip->addFile($namearchivo);
			//	rmdir($namearchivo);
				// $namearchivo=md5(time()).".text";
				// $archivo = fopen($namearchivo,'a');
				// fputs($archivo,$contenido);
				// fclose($archivo);
				// Add files to the zip file
				//$zip->addFile('test.txt');
				//$zip->addFile('test.pdf');
			 
				// Add random.txt file to zip and rename it to newfile.txt
				//$zip->addFile('random.txt', 'newfile.txt');
			 
				// Add a file new.txt file to zip using the text specified
				//$zip->addFromString('new.txt', 'text to be added to the new.txt file');
			 
				// All files are added, so close the zip file.
				$zip->close();
			}
			echo base_url().$nomenclatura;
		}
		public function listado_evidencia_link(){
			$iIdComponente= $this->input->post("iIdComponente",TRUE);
			$where=array('iIdComponente'=>$iIdComponente, 'iActivo'=>1, "vTipo"=>"Video");
			$evidencias = $this->compt->listado_evidencia($where);			
			$html = '';
			
			if($evidencias->num_rows() > 0)
			{
				$html='
				<div class="col-12">
				<div class="card">
				<div class="card-body">
                <div class="table-responsive">';
				
                $html.= '<table class="table table-striped table-bordered display" style="width:100%" id="grid">
				<thead>
				<tr>
				<th>Evidencia</th>
				<th>Estatus</th>
				<th width="200px;">Opciones</th>
				</tr>
				</thead>
				<tbody>';
				
				$evidencias = $evidencias->result();
				foreach ($evidencias as $c)
				{	
					$option_estatus=$this->listar_Estatus_evidencia($c->iIdEvidencia,$c->iEstatus);
		
					$option="confirmar_eliminar('¿Esta usted seguro?',eliminar_evidencia,$c->iIdEvidencia,$c->iIdComponente)";
					$html.= '<tr>
					<td><a href="'.$c->vEvidencia.'" target="_blank">'.$c->vEvidencia.'<a></td>
					<td>'.$option_estatus.'</td>					
					<td width="200px;">
					<button type="button" class="btn btn-circle waves-effect waves-light btn-danger" onclick="'.$option.'"><i class="mdi mdi-close"></i></button>
					</td>
					</tr>';
				}
				$html.= ' </tbody></table>
				</div>
				</div>
				</div>
				</div>';
			}
			
			echo $html;		
		}
		public function listado_evidencia(){
			$iIdComponente= $this->input->post("iIdComponente",TRUE);
			$where=array('iIdComponente'=>$iIdComponente, 'iActivo'=>1, "vTipo"=>"Documento");
			$evidencias = $this->compt->listado_evidencia($where);	
			
			
			$html = '';
			
			if($evidencias->num_rows() > 0)
			{
				$html='
				<div class="col-12">
				<div class="card">
				<div class="card-body">
                <div class="table-responsive">';
				
                $html.= '<table class="table table-striped table-bordered display" style="width:100%" id="grid">
				<thead>
				<tr>
				<th>Evidencia</th>
				<th>Estatus</th>
				<th width="200px;">Opciones</th>
				</tr>
				</thead>
				<tbody>';
				
				$evidencias = $evidencias->result();
				foreach ($evidencias as $c)
				{
					$option_estatus=$this->listar_Estatus_evidencia($c->iIdEvidencia,$c->iEstatus);

					$option="confirmar_eliminar('¿Esta usted seguro?',eliminar_evidencia,$c->iIdEvidencia,$c->iIdComponente)";
					$html.= '<tr>
					<td><a href="'.base_url().'archivos/documentosOffice/'.$c->vEvidencia.'" target="_blank">'.$c->vEvidencia.'<a></td>
					<td>'.$option_estatus.'</td>					
					<td width="200px;">
					<button type="button" class="btn btn-circle waves-effect waves-light btn-danger" onclick="'.$option.'"><i class="mdi mdi-close"></i></button>
					</td>
					</tr>';
				}
				$html.= ' </tbody></table>
				</div>
				</div>
				</div>
				</div>';
			}
			
			echo $html;		
		}
			public function eliminar_evidencia(){
				$data=array("iActivo" =>0);
				if($this->compt->eliminar_evidencia($data,$_POST)){
					echo "correcto";	
					}else{
					echo "incorrecto";
				}			
			}
			public function update_estatus_evidencia(){
				
				$iIdEvidencia=$this->input->post("iIdEvidencia",TRUE);
				$where=array("iIdEvidencia"=>$iIdEvidencia);
				unset($_POST["iIdEvidencia"]);
				$_POST["iIdUsuarioRevisa"]=$_SESSION[PREFIJO . '_idusuario'];
				$_POST["dFechaRevision"]=date("Y-m-d H:i:s");
				if($this->compt->updateEvidencia($_POST,$where)===TRUE){
					echo "correcto";	
					}else{
					echo "incorrecto";
				}
				
			}
		public function componente_editar(){
		  $periodorevisionactivo = $this->comp->periodorevisionactivo();
			$data['periodorevision']=$periodorevisionactivo;
			$options = new Class_options();
            $data['options_unidadmedida']  = $options->options_tabla('unidades_medida');
            $data['options_tipo_ubp']  = $options->options_tabla('tipo_ubps');
            $data['options_ubp']  = $options->options_tabla('ubps');

			$iIdComponente= $this->input->post("iIdComponente",TRUE);
			$iIdCompromiso=$this->input->post("iIdCompromiso",TRUE);
			$where["iIdCompromiso"] = $data["iIdCompromiso"] = $iIdCompromiso;
			$row = $this->comp->ConsultarCompromisos($where)->row();
			$data['vCompromiso'] = $row->iNumero.'. '.$row->vCompromiso ;
			
			$where=array('c.iIdComponente'=>$iIdComponente);
			$datosTabla=$this->compt->listado_componentes($where);
			$data['datosTablaUBP']=$this->tabla_componenteubp($iIdComponente);
			$data['datosTabla']=$datosTabla->result();
			$data['iIdComponente']=$iIdComponente;
			$data['iIdCompromiso']=$iIdCompromiso;
			$data['ponderacion']=$this->compt->consultaPonderacion($iIdCompromiso);
			$this->load->view('compromisos/componentes/componente_editar',$data);
			
		}
		public function add_image_validador()
		{   $validador=0;
			$allowedfileExtensions = array('jpg', 'jpeg', 'png', 'gif');

			$where=array("iIdComponente"=>$this->input->post("iIdComponente",TRUE), "iActivo"=>1,"vTipo"=>"Fotografía");
			$numdocs=$this->compt->consultaArchivos($where,"Evidencia");
			$totaldocs=0;
			foreach($_FILES['image']['tmp_name'] as $key => $tmp_name)
			{
			$file_name = $key.$_FILES['image']['name'][$key];
			$file_size =$_FILES['image']['size'][$key];
			$file_tmp =$_FILES['image']['tmp_name'][$key];
			$file_type=$_FILES['image']['type'][$key];  
			$fileNameCmps = explode(".", $file_name);
			$fileExtension = strtolower(end($fileNameCmps));
			if (in_array($fileExtension, $allowedfileExtensions)!=TRUE) {$validador++;}
			//move_uploaded_file($file_tmp,"./archivos/documentosOffice/".time().$file_name);
			$totaldocs++;
			}
			$sumCount=$numdocs+$totaldocs;
			if($sumCount>10) {$validador++;}
			echo $validador;
		}
		public function add_link(){
			$iIdComponente=$this->input->post("iIdComponente",TRUE);
			$vEvidencia=$this->input->post("vEvidencia",TRUE);
			$where=array("iIdComponente"=>$iIdComponente, "iActivo"=>1,"vTipo"=>"Video");
			$numdocs=$this->compt->consultaArchivos($where,"Evidencia");
			
				if($numdocs<=1){
					$data=array(
						"iIdComponente"=>$iIdComponente,
						"vEvidencia" =>$vEvidencia,
						"iEstatus"  =>1,
						"vTipo" =>"Video",
						"dFechaSubida" =>date("Y-m-d H:i:s"), 
						"dFechaRevision" =>NULL,
						"iFotoInicio" =>0,
						"iOrdenFoto" =>0,
						"iIdUsuarioSube" =>$_SESSION[PREFIJO.'_idusuario'],
						"iIdUsuarioRevisa" =>NULL,
						"iActivo" =>1,
					);
					$this->compt->add_files($data);
					echo "correcto";

				}else{
					echo "incorrecto";
				}			
		}

		public function add_image()
		{ 
			 $iIdComponente= $this->input->post("iIdComponente",TRUE);
			foreach($_FILES['image']['tmp_name'] as $key => $tmp_name)
			{
			$file_name = $key.$_FILES['image']['name'][$key];
			$file_size =$_FILES['image']['size'][$key];
			$file_tmp =$_FILES['image']['tmp_name'][$key];
			$file_type=$_FILES['image']['type'][$key];  
			$fileNameCmps = explode(".", $file_name);
			$fileExtension = strtolower(end($fileNameCmps));
			$time=time()."-";

			$data=array(
				"iIdComponente"=>$iIdComponente,
				"vEvidencia" =>$time.$file_name,
				"iEstatus"  =>1,
				"vTipo" =>"Fotografía",
				"dFechaSubida" =>date("Y-m-d H:i:s"), 
				"dFechaRevision" =>NULL,
				"iFotoInicio" =>0,
				"iOrdenFoto" =>0,
				"iIdUsuarioSube" =>$_SESSION[PREFIJO.'_idusuario'],
				"iIdUsuarioRevisa" =>NULL,
				"iActivo" =>1,
			);
			move_uploaded_file($file_tmp,"./archivos/documentosImages/".$time.$file_name);
			$this->compt->add_files($data);
			}
			echo "correcto";			
		}
		public function add_files_validador()
		{ 
			$validador=0;
			
		//	$allowedfileExtensions = array('xls', 'xlsx', 'pdf', 'doc', 'docx', 'ppt', 'pptx');
			$allowedfileExtensions = array('pdf');


			$where=array("iIdComponente"=>$this->input->post("iIdComponente",TRUE), "iActivo"=>1, "vTipo"=>"Documento");
			$numdocs=$this->compt->consultaArchivos($where,"Evidencia");
			$totaldocs=0;

			foreach($_FILES['files']['tmp_name'] as $key => $tmp_name)
			{
			
			$file_name = $key.$_FILES['files']['name'][$key];
			$file_size =$_FILES['files']['size'][$key];
			$file_tmp =$_FILES['files']['tmp_name'][$key];
			$file_type=$_FILES['files']['type'][$key];  
			$fileNameCmps = explode(".", $file_name);
			$fileExtension = strtolower(end($fileNameCmps));
			
			$limiteArchivo="3072000‬";
			if($file_size>$limiteArchivo) {$validador++;}
			if (in_array($fileExtension, $allowedfileExtensions)!=TRUE) {$validador++;}
			$totaldocs++;
			//move_uploaded_file($file_tmp,"./archivos/documentosOffice/".time().$file_name);
			
			}
			$sumCount=$numdocs+$totaldocs;
			if($sumCount>15) {$validador++;}
			echo $validador;
		}
		public function add_files()
		{ 
			 $iIdComponente= $this->input->post("iIdComponente",TRUE);
			foreach($_FILES['files']['tmp_name'] as $key => $tmp_name)
			{
				$file_name = $key.$_FILES['files']['name'][$key];
				$file_size =$_FILES['files']['size'][$key];
				$file_tmp =$_FILES['files']['tmp_name'][$key];
				$file_type=$_FILES['files']['type'][$key];  
				$fileNameCmps = explode(".", $file_name);
				$fileExtension = strtolower(end($fileNameCmps));
				$time=time()."-";

				$data=array(
					"iIdComponente"=>$iIdComponente,
					"vEvidencia" =>$time.$file_name,
					"iEstatus"  =>1,
					"vTipo" =>"Documento",
					"dFechaSubida" =>date("Y-m-d H:i:s"), 
					"dFechaRevision" =>NULL,
					"iFotoInicio" =>0,
					"iOrdenFoto" =>0,
					"iIdUsuarioSube" =>$_SESSION[PREFIJO.'_idusuario'],
					"iIdUsuarioRevisa" =>NULL,
					"iActivo" =>1,
				);
				move_uploaded_file($file_tmp,"./archivos/documentosOffice/".$time.$file_name);
				$this->compt->add_files($data);
			}
			echo "correcto";			
		}
	}
?>