<?php
use PhpOffice\PhpWord\Writer\Word2007\Style\Row;
class M_notis extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

    public function agregarNoti($data){
        $query_noti = "INSERT INTO notis(comment_subject, comment_text, comment_status) VALUES ('yo','prueba de las notis',1)";
		return $this->db->insert('notis', $data);

	}

	public function PruebaX(){
		
		$this->db->select('*');
		$this->db->from('notis');
		$this->db->where('comment_status',0);
		$query = $this->db->get();
		$output='';

		foreach ($query->result() as $row) {
        	$datos[] = [
	           'comment_subject' => $row->comment_subject,
	           'comment_text' => $row->comment_text
	        ];
			
				$output .='<div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">';
				$output.='<div class="">';
				$output.='<svg style="width:24px;height:24px" viewBox="0 0 24 24">';
				$output.='<path fill="currentColor"';
				$output.='d="M10 21H14C14 22.1 13.1 23 12 23S10 22.1 10 21M21 19V20H3V19L5 17V11C5 7.9 7 5.2 10 4.3V4C10 2.9 10.9 2 12 2S14 2.9 14 4V4.3C17 5.2 19 7.9 19 11V17L21 19M17 11C17 8.2 14.8 6 12 6S7 8.2 7 11V18H17V11Z">';
				$output.='</path>';
				$output.='</svg>';
				$output.='</div>'.$row->comment_subject.''.$row->comment_text.'</div>';
				echo($output);
			
	    }
     	
	}

}

?>