<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class home extends MyController {

	public function __construct()
	{
		parent::__construct();	
		//$this->is_logged_in();
	}
	
	public function index(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$data['main_content']="home";
		$this->load->view('template/main',$data);
	}
	
	public function login(){
		$jenis=$this->uri->segment(3);
		$id=$this->uri->segment(4);
		if( $this->session->userdata('logged_state') !== false){
			if($jenis == ""){
				redirect('home/index');
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
				}elseif($jenis == "is_cp"){
					$url="customer/list_cp_req";
					redirect($url);
				}
			}
			
		}else{
			$data['jenis']=$this->uri->segment(3);
			$this->load->view('login',$data);
		}
		//$data['main_content']="home";
		
	}
	
	public function cek_login(){
		$this->load->model('sso_model');
		//$this->load->model('oci_model');
		$user=stripslashes(strip_tags(htmlspecialchars ($this->input->post('user'),ENT_QUOTES)));
		$pass=stripslashes(strip_tags(htmlspecialchars ($this->input->post('pass'),ENT_QUOTES)));
		$jenis=$this->input->post("jenis");
		$this->sso_model->valid_login($user, $pass, $jenis);
		//$this->oci_model->valid_login($user, $pass);
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
	
	function proses_reset(){
		$nik = $this->input->post('nik_reset');
		$reason = $this->input->post('reason');
		$auth = "1baba0ef1125204761a2f03f611e991e";
		
		$url = "http://pitstop.vivere.co.id/vservice/action/reset_password/".$auth."/".$nik."/".$reason;
		$grab = $this->getURL($url); 
		$hasil = json_decode($grab, true);
		
		if($hasil['result'] == "true"){
			redirect("home/req_reset_sukses");
		}else{
			redirect("home/req_reset_gagal");
		}
		
	}
	
	function req_reset_sukses(){
		$this->load->view('req_reset_sukses');
	}
	
	function req_reset_gagal(){
		$this->load->view('req_reset_gagal');
	}
	
	function logout(){
		$this->session->unset_userdata('logged_state');
		//$this->session->sess_destroy();
		redirect("home/login");
	}
	
	
	function test_paging(){
	
		$this->load->library('pagination');
	
		$config['base_url'] = 'http://example.com/index.php/test/page/';
		$config['total_rows'] = 200;
		$config['per_page'] = 20;
		
		$this->pagination->initialize($config);
		
		echo $this->pagination->create_links();
	    }
	
	
}
