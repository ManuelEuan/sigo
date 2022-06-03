<?php

class M_roles extends CI_Model {

	private $table = 'Rol';
	private $idU = 'iIdRol';

	function __construct()
	{
		parent::__construct();
        $this->db = $this->load->database('default',TRUE);
    }

    //Muestra todos los roles registrados
    public function mostrar_roles($rol=null){

        $this->db->select();
        $this->db->from('Rol');
        $this->db->where('iActivo', 1);

        if (!empty($rol) && $rol != null){
			///$this->db->where('iIdRol', $rol);
            $this->db->where("(lower(translate(\"vRol\",'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')) ilike lower(translate( '%$rol%','áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')))");
		}

        $query =  $this->db->get();
        
        $resultado = $query->result();
        return $resultado;
    }

    //Guarda los Roles en la DB
    public function insertar_rol($data){

        $this->db->insert($this->table, $data);
		return $this->db->insert_id();

    }

    //Muestra los usuarios con determinado id
	public function preparar_update($id){

		$this->db->select();
        $this->db->from('Rol r');
		$this->db->where('r.iIdRol', $id);

		$query =  $this->db->get()->row();
        
        return $query;

    }

    //Modifica los Roles en la DB
	public function modificar_rol($id,$data){

		$this->db->where('iIdRol', $id);
		return $this->db->update('Rol', $data);
		
	}

	//Cambia de estatus activo a inactivo(Metoo de eliminacion)
	public function eliminar_rol($id){

		$data = array('iActivo' => 0);

		$this->db->where('iIdRol', $id);
		return $this->db->update('Rol',$data);
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

    //Obtiene los permisos generados dependiendo el rol
    public function mostrar_permisos_rol($idrol,$idpermiso,$permisopadre,$tipo){

        $this->db->select();
        $this->db->from('Permiso p');
        $this->db->join('RolPermiso rp','rp.iIdPermiso = p.iIdPermiso','INNER');
        $this->db->join('Rol r','r.iIdRol = rp.iIdRol','INNER');
        $this->db->where('r.iIdRol',$idrol);
        $this->db->where('p.iIdPermiso',$idpermiso);
        $this->db->where('p.iIdPermisoPadre',$permisopadre);
        $this->db->where('p.iTipo',$tipo);
        
        $query =  $this->db->get();

        $resultado = $query->result();
        return $resultado;

    }

    //Elimina los permisos por rol
    public function eliminar_rolpermisos($id){
       
        $this-> db-> where ( 'iIdRol' ,  $id );
        if($this-> db-> delete ( 'RolPermiso')){

            return TRUE;

        }else{

            return FALSE;
        }
        
    }

    //Agrega permisos determinado rol
    public function agregar_rolpermisos($data){

        $this->db->insert('RolPermiso', $data);

        if($this->db->affected_rows() > 0){

            return true; // to the controller
        }

    }

    //Valida si el rol cuenta con permisos
    public function validar_rolpermisos($id_rol){

        $this->db->select();
        $this->db->from('RolPermiso');
        $this->db->where('iIdRol',$id_rol);

        $query =  $this->db->get();

        if($query->num_rows() > 0){

            return TRUE;
        }else{
            
            return FALSE;
        }

    }
}

?>