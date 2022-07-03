<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class M_reportePicaso extends CI_Model {

    function __construct(){
        parent::__construct();
            $this->db = $this->load->database('default',TRUE);
        }


    function obtenerDep($id){
        $sql = 'SELECT "vDependencia" FROM "Dependencia" WHERE "iIdDependencia" = 144';
        return $this->db->query($sql)->result();
    }
}

?>