<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class M_query extends CI_Model {

    function __construct(){
    parent::__construct();
        $this->db = $this->load->database('default',TRUE);
    }

    function ejecutarQuery($sql){
        $query = $sql;
        
        if($this->db->query($query)){
            return $this->db->query($query)->result();
        }else{
            return $this->db->error();
        }
        

    }
}