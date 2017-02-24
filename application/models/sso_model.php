<?php

class sso_model extends CI_Model {
	private $dbsso;
	public function __construct()
	{
	     // Call the Model constructor
        parent::__construct();
		$this->dbsso = $this->load->database('sso',TRUE);
		$this->load->library('My_AdminLibrary');
	}
	
	function getURL($url) { 
		$curlHandle = curl_init(); // init curl 
		curl_setopt($curlHandle, CURLOPT_URL, $url); // setthe url to fetch 
		curl_setopt($curlHandle, CURLOPT_HEADER, 0); 
		curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($curlHandle, CURLOPT_TIMEOUT,30); 
		curl_setopt($curlHandle, CURLOPT_POST, 0); 
		$content = curl_exec($curlHandle); 
		if(!$content){ 
		return 'Curl error: ' . curl_error($curlHandle); 
		} 
		Else { 
		return $content; 
		} 
		curl_close($curlHandle); 
	}
	
	public function valid_login($nik=FALSE, $pas=FALSE, $jenis=FALSE){
                date_default_timezone_set('Asia/Jakarta');
                $tgl=date("Y-m-d H:i:s");

		$nik = $this->my_adminlibrary->CleanLogin($nik);
		$pas = $this->my_adminlibrary->CleanLogin($pas);
		
		$auth = "8c5743b960f1c021b497e589abf9d1e3";
		$url = "http://pitstop.vivere.co.id/vservice/action/login/".$auth."/".$nik."/".$pas;
		$grab = $this->getURL($url); 
		$hasil = json_decode($grab, true);
                    
		if($hasil['result'] == "true"){
			
			//Get Role User Login
			$this->dboci = $this->load->database('orcl',TRUE);
			$query = "SELECT ROLE FROM M_CUST_ROLE WHERE NIK='".$nik."'";
			$hasil=$this->dboci->query($query)->result_array();
			$role="";
			foreach($hasil as $a){
				$role=$role."-".$a['ROLE'];
			}
			
			$session_login = array(
				'NIK' => trim($nik), 
				'usr_name' => trim($hasil['name']),
				'app_code' => "CUST",
				'seskode' => $nik.strtotime($tgl),
				'role' => $role,
				'logged_state' => TRUE
			);
			$this->session->set_userdata($session_login);
			
			if($jenis == ""){
				redirect(site_url('home/index')); 
			}else{
				if($jenis == "approve_new"){
					$url="customer/list_cust_req";
					redirect($url);
				}elseif($jenis == "approve_edit"){
					$url="customer/list_cust_approval_edit";
					redirect($url);
				}elseif($jenis == "approve_extend"){
					$url="customer/list_cust_approval_extend";
					redirect($url);
				}elseif($jenis == "is_new"){
					$url="customer/list_cust_is";
					redirect($url);
				}elseif($jenis == "is_edit"){
					$url="customer/list_cust_is_edit";
					redirect($url);
				}elseif($jenis == "is_extend"){
					$url="customer/list_cust_is_extend";
					redirect($url);
				}
			}
			
		}else{
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
                            <h4 class="alert-heading">Error!</h4>
                             Username/Password Salah!</div>');		
			redirect(site_url('home/login')); 
		}
	}
	
	
	
	public function Exec($field=false, $val=false, $tbl=false, $kondisi=false, $state=false){
		$kondisi=($kondisi)?'where '.$kondisi:"";
		if($state=='insert'){
			 // $result=$this->dbintra->insert($tbl, $val); 				
			$result=$this->dbsso->query("insert into $tbl ($field) VALUES ($val)");
		}elseif($state=='update'){ 
			//echo $result="update $tbl set $field  where $kondisi";
			$result=$this->dbsso->query("update $tbl set $field  $kondisi");
			//exit;
		}elseif($state=='delete'){ 
			//echo $result="update $tbl set $field  where $kondisi";
			$result=$this->dbsso->query("delete from $tbl $kondisi");
		}
		$this->dbsso->close();
		return $result;
		
	}
	public function select($field=FALSE, $table=FALSE,$kondisi=FALSE){
		$field=($field)?$field:'*';
		$table = ($table)?" from $table":"";
		$kondisi=($kondisi)?'where '.$kondisi:'';
		//echo "select $field from $table $kondisi";
		$result=$this->dbsso->query("select $field $table $kondisi")->result_array();
		$this->dbsso->close();
		return $result;
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */