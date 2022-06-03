<?php

class M_usuarios extends CI_Model {


	private $table = 'Usuario';
	private $idU = 'iIdUsuario';

	function __construct()
	{
		parent::__construct();
        $this->db = $this->load->database('default',TRUE);
    }

    //Muestra todos los usuarios
    public function mostrar_usuarios($usuario = null, $rol = null){

        $this->db->select();
        $this->db->from('Usuario u');
        $this->db->join('Dependencia d','u.iIdDependencia = d.iIdDependencia','INNER');
        $this->db->join('Rol r','u.iIdRol = r.iIdRol','INNER');
        //$this->db->join('FormacionAcademica fa','u.iIdFormacionAcademica = fa.iIdFormacionAcademica','INNER');
        //$this->db->join('MaxNivelAcademico na','u.iIdMaxNivelAcademico = na.iIdMaxNivelAcademico','INNER');
        $this->db->where('u.iActivo', 1);
        
        if (!empty($usuario) && $usuario != null){
			$this->db->where("(\"vNombre\" ilike '%$usuario%' or \"vPrimerApellido\" ilike '%$usuario%' or \"vSegundoApellido\" ilike '%$usuario%' OR \"vUsuario\" ilike '%$usuario%')");
		}
		if (!empty($rol) && $rol != null){
			$this->db->where('u.iIdRol', $rol);
		}

		$query =  $this->db->get();
        
        $resultado = $query->result();
        return $resultado;

    }
    
    //Guarda los usuarios en la DB
	public function guardar_usuario($data){

		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
    }
    
    //Muestra los usuarios con determinado id
	public function preparar_update($id){

		$this->db->select();
        $this->db->from('Usuario u');
        $this->db->join('Dependencia d','u.iIdDependencia = d.iIdDependencia','INNER');
        $this->db->join('Rol r','u.iIdRol = r.iIdRol','INNER');
        $this->db->join('FormacionAcademica fa','u.iIdFormacionAcademica = fa.iIdFormacionAcademica','INNER');
        $this->db->join('MaxNivelAcademico na','u.iIdMaxNivelAcademico = na.iIdMaxNivelAcademico','INNER');
		$this->db->where('u.iIdUsuario', $id);

		$query =  $this->db->get()->row();
        
        return $query;

    }
    
    //Modifica los usuarios en la DB
	public function modificar_usuario($id,$data){

		$this->db->where('iIdUsuario', $id);
		return $this->db->update('Usuario', $data);
		
	}

	//Cambia de estatus activo a inactivo(Metoo de eliminacion)
	public function eliminar_usuario($id){

		$data = array('iActivo' => 0);

		$this->db->where('iIdUsuario', $id);
		return $this->db->update('Usuario',$data);
    }
    
    //Valida si el usuario existe
    public function validar_usuario($us,$id=''){

        $this->db->select();
		$this->db->from('Usuario');
        $this->db->where('iActivo', 1);
        $this->db->where('vUsuario', $us);

        if($id != '') $this->db->where('iIdUsuario !=',$id);
        
        $query =  $this->db->get();

        if($query->num_rows() > 0){

            return FALSE;

        }else{

            return TRUE;
        }
    }

    //Valida la contraseña del usuario 
    public function validar_password($pass,$id){

        $this->db->select();
		$this->db->from('Usuario');
        $this->db->where('iActivo', 1);
        $this->db->where('vPassword', $pass);
        $this->db->where('iIdUsuario', $id);
        
        $query =  $this->db->get();

        if($query->num_rows() > 0){

            return TRUE;

        }else{

            return FALSE;
        }
    }

    //Valida el correo institucional y el correo personal
    public function validar_correos($correo_inst,$correo_per,$opcion,$id=''){

        switch ($opcion) {
            case $opcion == 1:

                $this->db->select();
                $this->db->from('Usuario');
                $this->db->where('iActivo', 1);
                $this->db->where('vCorreo', $correo_inst);
                //$this->db->or_where('vCorreoPersonal', $correo_inst);

                if($id != '') $this->db->where('iIdUsuario !=',$id);

                $query =  $this->db->get();

                if($query->num_rows() > 0){

                    return FALSE;

                }else{

                    return TRUE;
                }

                break;

            case $opcion == 2:

                $this->db->select();
                $this->db->from('Usuario');
                $this->db->where('iActivo', 1);
                //$this->db->where('vCorreo', $correo_per);
                $this->db->where('vCorreoPersonal', $correo_per);

                if($id != '') $this->db->where('iIdUsuario !=',$id);

                $query =  $this->db->get();

                if($query->num_rows() > 0){

                    return FALSE;

                }else{

                    return TRUE;
                }

                break;
            
            default:
                # code...
                break;
        }
    }

    //Obtiene los catalogos y subcatalogos del sistema
    public function consultar_menu_sistema($idpadre=0,$tipo)
	{	
        $this->db->select();
        $this->db->from('Permiso');
        $this->db->where('iActivo', 1);
        $this->db->where('iTipo', $tipo);
        $this->db->where('iIdPermisoPadre', $idpadre);
        $this->db->order_by( 'iOrden', 'ASC' ); 
        $query =  $this->db->get();
        
        $resultado = $query->result();
        return $resultado;      
    }
    
    //Obtiene los permisos otorgados para cada uno de los usuarios
    public function mostrar_permisos_usuario($idusuario,$idpermiso){

        $this->db->select('p."iIdPermiso", p."vPermiso", p."vClass", up."iTipoAcceso", p."vUrl", p."iOrden');
        $this->db->from('Permiso p');
        $this->db->join('UsuarioPermiso up','up.iIdPermiso = p.iIdPermiso','INNER');
        $this->db->join('Usuario u','up.iIdUsuario = u.iIdUsuario','INNER');
        $this->db->where('u.iIdUsuario',$idusuario);
        $this->db->where('p.iIdPermiso',$idpermiso);

        $query =  $this->db->get();

        $resultado = $query->result();
        return $resultado;

    }

    //Obtiene los permisos generados dependiendo el rol
    public function mostrar_permisos_rol($idusuario,$idpermiso,$permisopadre,$tipo){

        $this->db->select();
        $this->db->from('Permiso p');
        $this->db->join('RolPermiso rp','rp.iIdPermiso = p.iIdPermiso','INNER');
        $this->db->join('Usuario u','u.iIdRol = rp.iIdRol','INNER');
        $this->db->where('u.iIdUsuario',$idusuario);
        $this->db->where('p.iIdPermiso',$idpermiso);
        $this->db->where('p.iIdPermisoPadre',$permisopadre);
        $this->db->where('p.iTipo',$tipo);
        
        $query =  $this->db->get();

        $resultado = $query->result();
        return $resultado;

    }

    //Elimina los permisos especiales de determinado usuario
    public function eliminar_permisosusuario($id){
       
        $this-> db-> where ( 'iIdUsuario' ,  $id );
        if($this-> db-> delete ( 'UsuarioPermiso')){

            return TRUE;

        }else{

            return FALSE;
        }
        
    }

    //Agrega permisos especiales a determinado usuario
    public function agregar_permisos($data){

        $this->db->insert('UsuarioPermiso', $data);

        if($this->db->affected_rows() > 0){

            return true;
        }

    }

    //Valida si el usuario tiene permisos especiales
    public function validar_permisos($id_us){

        $this->db->select();
        $this->db->from('UsuarioPermiso');
        $this->db->where('iIdUsuario',$id_us);

        $query =  $this->db->get();

        if($query->num_rows() > 0){

            return TRUE;
        }else{
            
            return FALSE;
        }

    }
}

?>