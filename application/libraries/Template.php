<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Template {
	var $template_data = array();
	 
		public function set($name, $value)
		{
			 $this->template_data[$name] = $value;
		}
		
		public function load($template = '', $view = '' , $view_data = array(), $return = FALSE) {
        $this->CI =& get_instance();
        $this->set('filecontent', $this->CI->load->view($view, $view_data, TRUE)); 
		//$this->set('nav_list', array(''=>'Home', 'home/upload'=>'Upload Data Absen', 'home/absensi_harian'=>'Absensi Keterlambatan Harian', 'home/absensi_bulanan'=>'Absensi Keterlambatan Bulanan','tutup'=>'Tutup'));  
	
		//echo $view."  ".print_r($view_data);     
        return $this->CI->load->view($template, $this->template_data, $return);
		}
		
}

?>
