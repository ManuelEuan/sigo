<?php
class M_pps extends CI_Model {

	function __construct(){
		parent::__construct();
        $this->db = $this->load->database('default',TRUE);
	}
	

	public function mostrar_pps($keyword = '',$id=0){
        $this->db->select();
		$this->db->from('ProgramaPresupuestario');	
		$this->db->where('iActivo', 1);

		if($keyword != '') $this->db->where("(lower(translate(\"vProgramaPresupuestario\",'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')) ilike lower(translate( '%$keyword%','áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')))");
		if($id > 0) $this->db->where('iIdProgramaPresupuestario',$id);

		$query =  $this->db->get();        
        return $query;
	}

	function sequence(){
		$sql = "select tab.relname as tabname, seq.relname as seqname, attr.attname as column
				from pg_class as seq
				join pg_depend as dep on (seq.relfilenode = dep.objid)
				join pg_class as tab on (dep.refobjid = tab.relfilenode)
				join pg_attribute as attr on (attr.attnum = dep.refobjsubid and attr.attrelid = dep.refobjid)
				where seq.relkind = 'S';";
		return $this->db->query($sql)->result();
	}

	function max_value($table,$column){
		$this->db->select('MAX("'.$column.'") max');
		$this->db->from($table);	
		
		$query =  $this->db->get();        
        return $query->row()->max;
	}

	function last_val_sequence($sequence){
		$sql = "SELECT last_value FROM $sequence;";
		
		$query =  $this->db->query($sql);
        return $query->row()->last_value;
	}
}