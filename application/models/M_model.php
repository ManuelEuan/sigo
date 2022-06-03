<?php
class M_model extends CI_Model
{
    
    function __construct()
	{
		parent::__construct();
        $this->db = $this->load->database('default',TRUE);
        $this->db_resp= $this->load->database('resp',TRUE);
        $this->dev= $this->load->database('dev',TRUE);
    }

    function all_avances()
    {
    	$sql = 'SELECT * FROM "Avance" WHERE "iActivo" = 1';
    	return $this->db->query($sql)->result();
    }

    function avance_resp($where)
    {
    	$this->db_resp->select('av.nBeneficiariosH, av.nBeneficiariosM, av.nDiscapacitadosH, av.nDiscapacitadosM, av.nLenguaH, av.nLenguaM');
    	$this->db_resp->from('Avance av');
    	$this->db_resp->where($where);

    	$query = $this->db_resp->get();

    	if($query->num_rows() == 1) return $query->row();
    	else return false;

    }


    function tabla_anexo()
    {
    	$sql = "SELECT * FROM tabla_anexo";
    	return $this->dev->query($sql)->result();
    }
}
?>