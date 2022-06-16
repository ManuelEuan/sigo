<?php
class M_seguridad extends CI_Model {


	function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default',TRUE);
	}

	/*	Funciones para usar transacciones
	======================================
	*/
	public function iniciar_transaccion()
	{
	  $con = $this->load->database('default',TRUE);
	  $con->trans_begin();
	  return  $con;
	}

	public function terminar_transaccion($con)
	{
		if ($con->trans_status() === FALSE)
		{
			$con->trans_rollback();
			return false;
		}
		else 
		{
			$con->trans_commit();
			return true;
		}
	}

	public function inserta_registro($tabla,$datos,$con='')
	{
		if($con == '') $con = $this->db;

		if($con->insert($tabla,$datos)) return $con->insert_id();
		else return false;
	}

	public function inserta_registro_no_pk($tabla,$datos,$con='')
	{
		if($con == '') $con = $this->db;

		if($con->insert($tabla,$datos)) return true;
		else return false;
	}

	public function insertarAreaResponsable($tabla, $datos, $con=''){
		if($con == '') $con = $this->db;
		if($con->insert($tabla,$datos)) return true;
		else return false;
	}

	public function actualiza_registro($tabla,$where,$datos,$con='')
	{
		if($con == '') $con = $this->db;
		$con->where($where);
		return $con->update($tabla, $datos);
	}

	public function elimina_registro($tabla,$where,$con)
	{
		return $con->delete($tabla,$where);
	}

	/*	Funciones para usar transacciones
	======================================
	*/

	public function consulta_existe_usuario($where='')
	{
		$this->db->select('u.iIdUsuario, u.vUsuario, u.vNombre, u.vPrimerApellido, u.vSegundoApellido, u.vCorreo, u.iIdDependencia, de.iIdEje');
		$this->db->select('r.iIdRol, r.vRol');
		$this->db->from('Usuario u');
		$this->db->join('Rol r','r.iIdRol = u.iIdRol','INNER');
		$this->db->join('DependenciaEje de','de.iIdDependencia = u.iIdDependencia','INNER');
		$this->db->where('u.iActivo',1);

		if($where != '') $this->db->where($where);

		$query = $this->db->get();

		return $query;
	}

	public function consultar_menu_sistema($idusuario=0, $idpadre=0)
	{	
		$idusuario = $this->db->escape($idusuario);
		$idpadre = $this->db->escape($idpadre);

		$sql = "SELECT * 
				FROM ((SELECT p.\"iIdPermiso\", p.\"vPermiso\", p.\"vClass\", up.\"iTipoAcceso\", p.\"vUrl\", p.\"iOrden\", p.\"iInicial\", 2 AS tipo
						FROM \"Permiso\" p
						INNER JOIN \"UsuarioPermiso\" up ON up.\"iIdPermiso\" = p.\"iIdPermiso\" AND up.\"iIdUsuario\" = $idusuario AND p.\"iIdPermisoPadre\" = $idpadre AND p.\"iTipo\" = 1 AND p.\"iActivo\" = 1)
				UNION
					(SELECT p.\"iIdPermiso\", p.\"vPermiso\", p.\"vClass\", rp.\"iTipoAcceso\", p.\"vUrl\", p.\"iOrden\", p.\"iInicial\", 1 AS tipo
						FROM \"Permiso\" p
						INNER JOIN \"RolPermiso\" rp ON rp.\"iIdPermiso\" = p.\"iIdPermiso\"
						INNER JOIN \"Usuario\" u ON u.\"iIdRol\" = rp.\"iIdRol\"
					WHERE u.\"iIdUsuario\" = $idusuario AND p.\"iIdPermisoPadre\" = $idpadre AND p.\"iTipo\" = 1 AND p.\"iActivo\" = 1)) t
				ORDER BY t.\"iOrden\", t.\"iIdPermiso\" ASC, t.tipo DESC";
		$query =  $this->db->query($sql);

		return $query;
	}

	public function tipo_acceso($idPermiso,$idUsuario)
	{
		$this->db->select('COALESCE(up."iTipoAcceso",-1) acceso_usuario, COALESCE(rp."iTipoAcceso",-1) acceso_rol',false);

		$this->db->from('Usuario u');
		$this->db->join('UsuarioPermiso up','up.iIdUsuario = u.iIdUsuario AND up.iIdPermiso = '.$idPermiso,'LEFT OUTER');
		$this->db->join('RolPermiso rp','rp.iIdRol = u.iIdRol AND rp.iIdPermiso = '.$idPermiso,'LEFT OUTER');
		$this->db->where('u.iIdUsuario',$idUsuario);

		$query = $this->db->get();
		return $query;
	}

	public function buscar_usuarios($where ='',$palabra='')
	{
		$this->db->select('u.iIdUsuario, u.vNombre, u.vApellidoPaterno, u.vApellidoMaterno, u.vCorreo, r.vRol, r.iIdRol, u.iEstatus, iIdDependencia');
		$this->db->from('Usuario u');
		$this->db->join('Rol r','r.iIdRol = u.iIdRol','INNER');
		$this->db->where('u.iEstatus >',0);
		if($palabra != '')
		{
			//$this->db->where("CONCACT( u.vNombre,' ',u.vApellidoPaterno,' ',u.vApellidoMaterno) LIKE '%$palabra%'");
			$this->db->like("u.vNombre",$palabra);
		}

		if(!empty($where)) $this->db->where($where);

		
		$this->db->order_by('u.vNombre');
		

		return $this->db->get();
	}

	public function consultar_usuario_por_token($idusuario, $token)
	{
		$this->db->select('u.iIdUsuario, u.vNombre, u.vApellidoPaterno, u.vApellidoMaterno, u.vCorreo, r.vRol, r.iIdRol');
		$this->db->from('Usuario u');
		$this->db->join('Rol r','r.iIdRol = u.iIdRol','INNER');
		$this->db->where('u.iEstatus >',0);
		$this->db->where('u.iIdUsuario',$idusuario);
		$this->db->where('u.vToken',$token);
		$response = false;

		$query =  $this->db->get();
		if($query)
		{
			if($query->num_rows() == 1) $response = true;
		}

		return $response;
	}

	public function consultar_usuario_por_correo($correo)
	{
		$this->db->select('u.iIdUsuario, u.vNombre, u.vApellidoPaterno, u.vApellidoMaterno');
		$this->db->from('Usuario u');
		$this->db->join('Rol r','r.iIdRol = u.iIdRol','INNER');
		$this->db->where('u.iEstatus ',2);
		$this->db->where('u.vCorreo',$correo);
		$this->db->limit(1);	//Sólo debe haber un correo registrado
		$response = false;

		$query =  $this->db->get();
		
		return $query;
	}

	public function verificar_existe_correo_usuario($correo,$excepcion=0)
	{
		$this->db->select('u.iIdUsuario');
		$this->db->from('Usuario u');
		$this->db->join('Rol r','r.iIdRol = u.iIdRol','INNER');
		$this->db->where('u.iEstatus >',0);	// Se excluyen usuarios eliminados
		$this->db->where('u.vCorreo',$correo);
		if($excepcion != 0) $this->db->where('u.iIdUsuario !=',$excepcion);
		$response = false;

		$query =  $this->db->get();

		if($query->num_rows() > 0) $response = true;
		
		return $response;
	}

	public function consulta_valor_parametros($where='')
	{
		$this->db->select('p.vValor, p.vId, p.vDescripcion');
		$this->db->from('Parametro p');		
		$this->db->where('p.iActivo',1);	// Se excluyen usuarios eliminados

		$query =  $this->db->get();

		return $query;
	}

	public function datos_usuarios($where ='')
	{
		$this->db->select('u.iIdUsuario, u.vNombre, u.vApellidoPaterno, u.vApellidoMaterno, u.vCorreo, u.dFechaNacimiento, u.iGenero, u.iIdGradoEstudio, u.iIdOcupacion, u.iIdAsentamiento, u.iIdRol, u.iEstatus');
		$this->db->select('l.iIdLocalidad, l.vLocalidad, m.iIdMunicipio, m.vMunicipio, iCodigoPostal, vToken');
		$this->db->from('Usuario u');		
		$this->db->join('Asentamiento a','a.iIdAsentamiento = u.iIdAsentamiento','INNER');
		$this->db->join('Localidad l','l.iIdLocalidad = a.iIdLocalidad','INNER');
		$this->db->join('Municipio m','m.iIdMunicipio = l.iIdMunicipio','INNER');
		//$this->db->where('u.iEstatus >',0);

		if(!empty($where)) $this->db->where($where);

		$this->db->order_by('u.vNombre');

		return $this->db->get();
	}

	//Verifica si existe el correo personal o instutucional en la DB
	public function validar_correo_existente($correo){

		$this->db->select();
		$this->db->from('Usuario');
		$this->db->where('vCorreo',$correo);
		$this->db->or_where('vCorreoPersonal',$correo);
		$this->db->where('iActivo',1);

		$query =  $this->db->get();

		if($query->num_rows() > 0){

			$resultado = $query->row();
            return $resultado;

		}else{

			return FALSE;
		}		
	}

	//Actualiza la tabla de usuarios guardando el token
	public function guardar_token_usuario($id_us,$token){

		$data = array('vToken' => $token);

		$this->db->where('iIdUsuario', $id_us);
		$this->db->where('iActivo',1);
		$this->db->update('Usuario', $data);

		if($this->db->affected_rows() > 0){

            return TRUE;
        }else{
			return FALSE;
		}
	}

	//Verifica que el usuario no tenga algun token
	public function validar_token_usuario($idusuario,$token)
	{
		$this->db->select();
		$this->db->from('Usuario u');
		$this->db->where('u.iActivo',1);
		$this->db->where('u.iIdUsuario',$idusuario);
		$this->db->where('u.vToken',$token);
		$respuesta = FALSE;

		$query =  $this->db->get();

		if($query->num_rows() == 1){

			$respuesta = TRUE;
		}

		return $respuesta;
	}

	//Cambia la contraseña de un usuario en la DB
	public function modificar_usuario($id,$data){

		$this->db->where('iIdUsuario', $id);
		return $this->db->update('Usuario', $data);
	}

	
}

?>