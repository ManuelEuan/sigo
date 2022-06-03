<?php if (!defined('BASEPATH')) exit('No permitir el acceso directo al script');

class Class_options {

    function __construct()
    {
        $CI =& get_instance();
        $CI->load->helper('url');
        $CI->load->model('M_catalogos'); 
    }

    function options_tabla($tabla,$seleccionado="",$where='')
    { 
        $model = new M_catalogos();
        $select = '';

        $query = $model->{$tabla}($where);       

        if($query != false)
        {   
            $result = $query->result();
           
            foreach ($result as $row)
            {
                $selected = ($row->id == $seleccionado) ? 'selected':'';
                $select .= '<option value="'.$row->id.'" '.$selected.'>'.$row->valor.'</option>';
            }
        }

        return $select;
    }

    function options_multiselect($tabla,$seleccionado="",$where='')
    {
        $model = new M_catalogos();
        $select = '';        

        $query = $model->{$tabla}($where); 

        if($query)
        {
            $result = $query->result();
            foreach ($result as $row)
            {
                $selected = (in_array($row->id, $seleccionado)) ? 'selected':'';
                $select .= '<option value="'.$row->id.'" '.$selected.'>'.$row->valor.'</option>';
            }
        }

        return $select;
    }  
}