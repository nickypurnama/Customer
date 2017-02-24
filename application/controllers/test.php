

function cust_history(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$this->load->model('sap_model');
		//$usr=$this->session->userdata('NIK');
		$field="*";
		$kondisi="";
		$data['row']=$this->oci_model->select($field, 'VW_CUST',FALSE);
		$data['company']=$this->sap_model->getCompanyCode();
		$data['main_content']="customer/cust_history";
		$this->load->view('template/main',$data);	
	}
	function cust_history_result($tg1=false, $tgl2=false, $company_code=false){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$tgl1 = $this->uri->segment(3);
		$tgl2 = $this->uri->segment(4);
		$tgl2 = $tgl2." 23:59";
		$company_code = $this->uri->segment(5);
		
		$this->load->model('oci_model');
		$this->load->model('sap_model');
		//$usr=$this->session->userdata('NIK');
		$field="*";
		$kondisi="";
		$data['row']=$this->oci_model->select($field, "VW_CUST","company_code='$company_code' AND TO_DATE(TGL,'dd-mm-yyyy hh24:mi') >=TO_DATE('$tgl1','dd-mm-yyyy hh24:mi') AND TO_DATE(TGL,'dd-mm-yyyy hh24:mi') <=TO_DATE('$tgl2','dd-mm-yyyy hh24:mi')"); 
		$data['company']=$this->sap_model->getCompanyCode();
		$data['company_code']=$company_code;
		$data['main_content']="customer/cust_history_result";
		$this->load->view('template/main',$data);	
	}
	function cust_history_filter(){
		
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}	
		$tgl1 = $this->input->post('tgl1');
		$tgl2 = $this->input->post('tgl2');
		$company_code = $this->input->post('company');
		$urlX = "customer/cust_history_result/".$tgl1."/".$tgl2."/".$company_code;
	    redirect($urlX);
	}
	