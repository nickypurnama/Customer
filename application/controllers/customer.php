<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class customer extends CI_CONTROLLER {

	public function __construct()
	{
		parent::__construct();	
		//$this->is_logged_in();
		//echo $this->session->userdata('logged_state');
		$this->load->library('My_Auth');
	}
	
	
	public function form_cust(){
	    if( $this->session->userdata('logged_state') !== true){
		redirect('home/login');
	    }
	    $this->my_auth->hak_akses("REQUESTER");
	 
            $this->load->model('sap_model');
	    $this->load->model('oci_model');
	    $seskode=$this->session->userdata('seskode');
	    
	    $data['company']=$this->sap_model->getCompanyCode();
	    $data['country']=$this->sap_model->getCountry();
	    $data['industry']=$this->sap_model->getIndustry();
	    $data['customer_class']=$this->sap_model->getCustomerClass();
	    $data['top']=$this->sap_model->getTOP();
	    $data['sales_office']=$this->sap_model->getSalesOffice();
	    $data['customer_group']=$this->sap_model->getCustomerGroup();
	    $data['currency']=$this->sap_model->getCurrency();
	    $data['incoterm']=$this->sap_model->getIncoterm();
	    $data['departemen']=$this->sap_model->getDepartemen();
	    $data['function']=$this->sap_model->getFunction();
	    $data['nielsen']=$this->sap_model->getNielsen();
	    $data['dis_channel']=$this->sap_model->getDistributionChannel();
	    $data['division']=$this->sap_model->getDivision();
	    $data['sales_org']=$this->sap_model->getSalesOrganization();
	    $data['region']=$this->sap_model->getRegion("ID");
	    $data['industry_code']=$this->sap_model->getIndustryCode();
	    $data['account_group']=$this->sap_model->getAccountGroup();
	    $data['recon_account']=$this->sap_model->getReconAccount();
	    $data['call_frequency']=$this->sap_model->getCallFrequency();
	    
	    $kondisi="SESKODE = '".$seskode."'";
	    $this->oci_model->Exec(FALSE, FALSE, 'TEMP_CP', $kondisi, 'delete');
	    
            $data['main_content']="customer/form_cust";
	    $this->load->view('template/main',$data);	
	}
	
	function get_region(){
		$this->load->model('sap_model');
		$land1=$this->input->post('id');
		$reg=$this->sap_model->getRegion($land1);
		//print_r($reg);
		echo '<select name="region_h" id="region" class="span6" onchange="getRegionChange();">
				      <option></option>';
		foreach($reg as $key => $a){
			if($key == 0 and $a['BLAND'] == ''){
				  continue;}
			echo '<option value="'.$a['BLAND'].'">'.$a['BLAND']." - ".$a['BEZEI'].'</option>';
		}
		echo '</select>';
		
	}
	
	function add_tempCP(){
		$this->load->model('oci_model');
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$title=$this->input->post('title');
		$firstname=$this->input->post('firstname');
		$name=$this->input->post('name');
		$tlp=$this->input->post('tlp');
		$ext=$this->input->post('ext');
		$hp=$this->input->post('hp');
		$fax=$this->input->post('fax');
		$dept=$this->input->post('dept');
		$func=$this->input->post('func');
		$email=$this->input->post('email');
		$gender=$this->input->post('gender');
		$tgl_lahir=$this->input->post('tgl_lahir');
		$tgl_register=$this->input->post('tgl_register');
		$call_freq = $this->input->post('call_freq');
		
		date_default_timezone_set('Asia/Jakarta');
		$tgl=date("Y-m-d");
		
		$seskode = $this->session->userdata('seskode');
		$username = $this->session->userdata('usr_name');
		
		$fieldH='TITLE_CP, FIRSTNAME_CP, NAME_CP, TLP_CP, EXT_CP, HP_CP, FAX_CP, EMAIL_CP, DEPARTMENT, FUNC, SESKODE, GENDER, TGL_LAHIR, CALL_REQ, DATE_REGISTER';
		$valH= "'".trim($title)."', '".trim($firstname)."', '".trim($name)."', '".trim($tlp)."', '".trim($ext)."', '".trim($hp)."', '".trim($fax)."' , '".trim($email)."', '".trim($dept)."',  '".trim($func)."', '".trim($seskode)."' , '".trim($gender)."', '".trim($tgl_lahir)."', '".trim($call_freq)."', '".trim($tgl_register)."'";
		
		$exec=$this->oci_model->Exec($fieldH, $valH, 'TEMP_CP', FALSE, 'insert');
		
		
		
		if($exec <= 0){
		    $this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				 Failed insert contact person !</div>');
		}
		
	}
	
	function load_tempCP(){
		$this->load->model('oci_model');
		$seskode=$this->session->userdata('seskode');
		$field="*";
		$kondisi="SESKODE = '$seskode'";
		$datax['row']=$this->oci_model->select($field, "TEMP_CP", $kondisi);
		$this->load->view('temp/tabel_cp',$datax);
	}
	
	function hapus_tempCP(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$id=$this->input->post('id');
		$this->oci_model->Exec(FALSE, FALSE, 'TEMP_CP', "ID_CP_TEMP=".$id, 'delete');
	}
	
	function test123(){
		$this->load->model('oci_model');
		$field="*";
		$kondisi="";
		$a = $this->oci_model->select($field, "TEMP_CP", $kondisi);
		//echo "<pre>";
		//print_r($a);
		//echo "</pre>";
		foreach($a as $b){
			echo $b['TITLE_CP']." - ".$b['FIRSTNAME_CP']." - ".$b['TLP_CP'];
			echo "<br/>";
		}
	}
	
	function add_customer(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		//General
		$id_cust=$this->oci_model->nextID('ID_CUST', 'M_CUST_KNA1',FALSE);
		//echo $id_cust;
		$country=$this->input->post('country');
		$name1=$this->input->post('name1');
		$name2=$this->input->post('name2');
		$city=$this->input->post('city');
		$postalcode=$this->input->post('postalcode');
		$region=$this->input->post('region_h');
		$sotl=substr($name1, 0, 9);
		$tlp1=$this->input->post('tlp');
		$tlp2=$this->input->post('hp');
		$fax=$this->input->post('fax');
		
		$address=$this->input->post('address');
		$address2=$this->input->post('address2');
		$address3=$this->input->post('address3');
		$address4=$this->input->post('address4');
		
		$search1=$this->input->post('search1');
		$search2=$this->input->post('search2');
		$title=$this->input->post('title');
		$allowpos=$this->input->post('ck1_h');
		$nielsen_id=$this->input->post('nielsen');
		$member_card=$this->input->post('membercard');
		$vatnum=$this->input->post('vat');
		$email=$this->input->post('email');
		$industry_key=$this->input->post('industry');
		$industry_code1=$this->input->post('industry_code1');
		
		$account_group=$this->input->post('account_group');
		$recont_account=$this->input->post('recon_account');
		
		$user_cr=$this->session->userdata('NIK');
		$st_send="0";
		$st="1";
		$subject=$this->input->post('subject');
		
		$customer_class=$this->input->post('customer_class');
		$seskode=$this->session->userdata('seskode');
		
		if($allowpos == '0'){
			$nielsen_id ="";
		}
		if($allowpos == "1"){
			if($nielsen_id == ""){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Failed, Please input Nielsen ID if allow data at POS!</div>');
				$url="customer/form_cust";
				redirect($url);
			}
			if($member_card == ""){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Failed, Please input Member Card if allow data at POS!</div>');
				$url="customer/form_cust";
				redirect($url);
			}
			if($industry_key == ""){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Failed, Please input Industry Key if allow data at POS!</div>');
				$url="customer/form_cust";
				redirect($url);
			}if($customer_class == ""){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Failed, Please input Customer Class if allow data at POS!</div>');
				$url="customer/form_cust";
				redirect($url);
			}
			if($industry_code1 == ""){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Failed, Please input Industry Code 1 if allow data at POS!</div>');
				$url="customer/form_cust";
				redirect($url);
			}
			
		}
		//Basic Data
		$company=$this->input->post('company');
		$sales_org=$this->input->post('sales_org');
		$dis_channel=$this->input->post('dis_channel');
		$division=$this->input->post('division');
		
		//Sales Area Data
		$top=$this->input->post('top');
		$sales_office=$this->input->post('sales_office');
		$cust_group=$this->input->post('customer_group');
		$currency=$this->input->post('currency');
		$inco1=$this->input->post('incoterm');
		$inco2=$this->input->post('deskripsi');
		
		$nik=$this->session->userdata('NIK');
		
		$stHak=$this->oci_model->cek_hak_akses($nik, $sales_org, $dis_channel, $division);
		if($stHak < 1){
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Sorry you do not have access, please contact the administrator !</div>');
			$url="customer/form_cust";
			redirect($url);
		}
		
		$stBasic=$this->oci_model->cek_data_basic($company, $sales_org, $dis_channel, $division);
		if($stBasic <> "1"){
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Failed to insert Customer! Please Check Company Code, Sales Organization, Distribution Channel and Division.</div>');
			$url="customer/form_cust";
			redirect($url);
		}
		date_default_timezone_set('Asia/Jakarta');
                $tgl=date("Y-m-d");
		
		//Insert KNA1
		$fieldKNA1="ID_CUST, COUNTRY_KEY, NAME1, NAME2, CITY, POSTAL_CODE, REGION, SHORT_FIELD, TLP1, TLP2, FAX, ADDRESS, SEARCH_TERM1, SEARCH_TERM2, TITLE_CP, ALLOW_POS, NIELSEN_ID, MEMBER_CARD, VATNUM, EMAIL, INDUSTRY_KEY, USER_CR, ST_SEND, ST, TGL, CUST_CLASS, SUBJECT, ADDRESS2, ADDRESS3, DATE_MODIF, NIK_MODIF, INDUSTRY_CODE1, ADDRESS4, ACCOUNT_GROUP";
		$valueKNA1="'".$id_cust."','".$country."','".$name1."', '".$name2."', '".$city."', '".$postalcode."', '".$region."', '".$sotl."', '".$tlp1."', '".$tlp2."', '".$fax."', '".$address."', '".$search1."', '".$search2."', '".$title."', '".$allowpos."', '".$nielsen_id."', '".$member_card."', '".$vatnum."', '".$email."', '".$industry_key."', '".$user_cr."', '".$st_send."', '".$st."', TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI'), '".$customer_class."', '".$subject."', '".$address2."', '".$address3."', TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI'), '".$user_cr."', '".$industry_code1."', '".$address4."', '".$account_group."'";
		$exec=$this->oci_model->Exec($fieldKNA1, $valueKNA1, 'M_CUST_KNA1', FALSE, 'insert');
		
		if($exec <= 0){
		    $this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Failed to insert Customer!</div>');
			$url="customer/form_cust";
			redirect($url);
		}else{
			//Insert KNVV
			$fieldKNVV="SALES_ORG, DIS_CHANNEL, DIVISION, ID_CUST, INCO1, INCO2, CUST_GROUP, CURR, TOP, SALES_OFFICE";
			$valueKNVV="'".$sales_org."', '".$dis_channel."', '".$division."', '".$id_cust."', '".$inco1."', '".$inco2."', '".$cust_group."', '".$currency."', '".$top."', '".$sales_office."'";
			$exec=$this->oci_model->Exec($fieldKNVV, $valueKNVV, 'M_CUST_KNVV', FALSE, 'insert');
			
			//Insert KNB1
			$fieldKNB1="COMPANY_CODE, ID_CUST, RECONT_ACC";
			$valueKNB1="'".$company."', '".$id_cust."', '".$recont_account."' ";
			$exec=$this->oci_model->Exec($fieldKNB1, $valueKNB1, 'M_CUST_KNB1', FALSE, 'insert');
			
			//Insert Contact Person
			$fieldTemp="*";
			$kondisiTemp="SESKODE = '".$seskode."'";
			$tempCP = $this->oci_model->select($fieldTemp, "TEMP_CP", $kondisiTemp);
			foreach($tempCP as $a){
				//Insert CP by Line Temp
				$id_cp = $this->oci_model->nextIDCP('ID_CP', 'M_CONTACT_PERSON',FALSE);
				
				$fieldCP='ID_CUST, ID_CP, TITLE_CP, FIRSTNAME_CP, NAME_CP, TLP_CP, EXT_CP, HP_CP, FAX_CP, EMAIL_CP, DEPARTMENT, FUNC, GENDER, TGL_LAHIR, CALL_FREQ, DATE_REGISTER';
				$valueCP= "'".$id_cust."', '".$id_cp."', '".$a['TITLE_CP']."', '".$a['FIRSTNAME_CP']."', '".$a['NAME_CP']."', '".$a['TLP_CP']."', '".$a['EXT_CP']."', '".$a['HP_CP']."', '".$a['FAX_CP']."' , '".$a['EMAIL_CP']."', '".$a['DEPARTMENT']."',  '".$a['FUNC']."',  '".$a['GENDER']."',  '".$a['TGL_LAHIR']."', '".$a['CALL_REQ']."', '".$a['DATE_REGISTER']."'";
				$exec=$this->oci_model->Exec($fieldCP, $valueCP, 'M_CONTACT_PERSON', FALSE, 'insert');
			}
			
			//delete_temp
			$kondisiTempDel="SESKODE = '".$seskode."'";
			$this->oci_model->Exec(FALSE, FALSE, 'TEMP_CP', $kondisiTempDel, 'delete');
	    
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Success! </div>');
			    redirect(site_url('customer/list_cust_req'));
			   //$this->form_cust();
			
		}
		
		
	}
	
	function list_cust_req(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->my_auth->hak_akses("REQUESTER");
		
		$this->load->model('oci_model');
		$usr=$this->session->userdata('NIK');
		$role=$this->session->userdata('role');
		
		if(strpos($this->session->userdata('role'),'ADMINISTRATOR') !== false){
			$field="ID_CUST,CUST_ACCOUNT,COUNTRY_KEY,NAME1,NAME2,
				CITY,POSTAL_CODE,REGION,SHORT_FIELD,TLP1,TLP2,FAX,
				ADDRESS,SEARCH_TERM1,SEARCH_TERM2,TITLE_CP,ALLOW_POS,
				NIELSEN_ID,MEMBER_CARD,VATNUM,EMAIL,INDUSTRY_KEY,ACCOUNT_GROUP,
				USER_CR,AUTH_GROUP,ST_SEND,NEW_ST,ST,TGL, REASONREJECT,DATE_POSTING,
				DATE_APPROVED,DATE_IS,DATE_DELETE,NIK_APPROVED,NIK_IS,
				COMPANY_CODE,CUST_CLASS,SUBJECT,ADDRESS2,
				ADDRESS3,DATE_MODIF,NIK_MODIF,RECONT_ACC,SALES_ORG,
				DIS_CHANNEL,DIVISION,CUST_GROUP,INCO1,INCO2,
				CURR,TOP,SALES_OFFICE,INDUSTRY_CODE1,SHORT_KEY,
				SALES_GROUP,CUST_PRICE,CUST_STAT,ACCOUNT_ASS,ADDRESS4,
				DEV_USERS.GET_NAME_BY_NIK(USER_CR) AS NAME_CREATE";
			$kondisi="ST = '1' ORDER BY ID_CUST DESC";
			$data['row']=$this->oci_model->select($field, 'VW_CUST',$kondisi);
		}else{
			$field="ID_CUST,CUST_ACCOUNT,COUNTRY_KEY,NAME1,NAME2,
				CITY,POSTAL_CODE,REGION,SHORT_FIELD,TLP1,TLP2,FAX,
				ADDRESS,SEARCH_TERM1,SEARCH_TERM2,TITLE_CP,ALLOW_POS,
				NIELSEN_ID,MEMBER_CARD,VATNUM,EMAIL,INDUSTRY_KEY,ACCOUNT_GROUP,
				USER_CR,AUTH_GROUP,ST_SEND,NEW_ST,ST,TGL, REASONREJECT,DATE_POSTING,
				DATE_APPROVED,DATE_IS,DATE_DELETE,NIK_APPROVED,NIK_IS,
				COMPANY_CODE,CUST_CLASS,SUBJECT,ADDRESS2,
				ADDRESS3,DATE_MODIF,NIK_MODIF,RECONT_ACC,SALES_ORG,
				DIS_CHANNEL,DIVISION,CUST_GROUP,INCO1,INCO2,
				CURR,TOP,SALES_OFFICE,INDUSTRY_CODE1,SHORT_KEY,
				SALES_GROUP,CUST_PRICE,CUST_STAT,ACCOUNT_ASS,ADDRESS4,
				DEV_USERS.GET_NAME_BY_NIK(USER_CR) AS NAME_CREATE";
			$kondisi="ST = '1' AND USER_CR = '".$usr."' ORDER BY ID_CUST DESC";
			$data['row']=$this->oci_model->select($field, 'VW_CUST',$kondisi);
		}
		
		$data['main_content']="customer/list_cust_req";
		$this->load->view('template/main',$data);	
	}
	
	//function getCustomerReq(){
	//	$this->db = $this->load->database('orcl',true);
	//	$this->load->library('Datatables');
	//	$this->load->helper('asset_helper');
	//	$whereArray = array('ST' => '1');
	//	
	//	$this->datatables	->select('ID_CUST,CUST_ACCOUNT,TITLE_CP, NAME1, COUNTRY_KEY, CITY, POSTAL_CODE, ST_SEND, NEW_ST')
	//				->from('VW_CUST')
	//				->where($whereArray)
	//				->unset_column('ST_SEND')
	//				->add_column('Action', '$1', 'opsi(ST_SEND)');
	//	echo $this->datatables->generate();	
	//}
	
	function approval_acc(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		
		$id=$this->input->post('id');
		$sales_org = $this->input->post('company');
		$dis_channel = $this->input->post('dis_channel');
		$division = $this->input->post('division');
		
		$fieldU="DISTINCT(NIK), DEV_USERS.GET_NAME_BY_NIK(NIK) as NAMA, DEV_USERS.GET_EMAIL_BY_NIK(NIK) AS EMAIL";
		$kondisiU="SALES_ORG='".$sales_org."' AND DIS_CHANNEL='".$dis_channel."' AND DIVISION='".$division."' AND NIK IN (SELECT NIK FROM M_CUST_ROLE WHERE (ROLE='APPROVAL' OR ROLE='ADMINISTRATOR'))";
		$listNIK=$this->oci_model->select($fieldU, 'M_CUST_PRIVILEGE',$kondisiU);
		
		$jml=count($listNIK);
		if($jml > 0){
			foreach($listNIK as $a){
				$nik=$a['NIK'];
				$email = $a['EMAIL'];
				$nama = $a['NAMA'];
				if($email <> ""){
					$this->send_mail($email, "REQUEST APPROVAL NEW CUSTOMER", "requestor", "new", $nama, $id);
				}
			}
		}
		
		date_default_timezone_set('Asia/Jakarta');
		$tgl=date("Y-m-d");
		$field="ST_SEND = '1', DATE_POSTING = TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI')";
		$kondisi="ID_CUST = '".$id."'";
		$exec=$this->oci_model->Exec($field, false, 'M_CUST_KNA1', $kondisi, 'update');
		
		
		if($exec == 1){
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Posting Customer Request Success. Waiting for approval.</div>');
		}
		
	}
	
	function del_cust(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$id=$this->input->post('id');
		date_default_timezone_set('Asia/Jakarta');
		$tgl=date("Y-m-d");
		
		$st=$this->oci_model->getStatusCustomer($id);
		if($st == "0"){
			$field="ST = '0', DATE_DELETE = TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI')";
			$kondisi="ID_CUST = '".$id."'";
			$exec=$this->oci_model->Exec($field, false, 'M_CUST_KNA1', $kondisi, 'update');
			
			if($exec == 1){
				$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Success!</h4>
					 Delete customer request success</div>');
			}
		}else{
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					 Failed to delete customer, customer status is not "Open".</div>');
		}
		
	}
	
	function view_cust(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$idCust=$this->uri->segment(3);
		
		$fieldKNA="*";
		$kondisiKNA="ID_CUST = '".$idCust."'";
		$KNA1=$this->oci_model->select($fieldKNA, 'VW_CUST',$kondisiKNA);
		foreach($KNA1 as $kna){
			$company_code=$kna['COMPANY_CODE'];
			$cust_account=$kna['CUST_ACCOUNT'];
			$country_key=$kna['COUNTRY_KEY'];
			$name1=$kna['NAME1'];
			$name2=$kna['NAME2'];
			$city=$kna['CITY'];
			$postal_code=$kna['POSTAL_CODE'];
			$region=$kna['REGION'];
			$short_field=$kna['SHORT_FIELD'];
			$tlp1=$kna['TLP1'];
			$tlp2=$kna['TLP2'];
			$fax=$kna['FAX'];
			$address=$kna['ADDRESS'];
			$address2=$kna['ADDRESS2'];
			$address3=$kna['ADDRESS3'];
			$address4=$kna['ADDRESS4'];
			$search1=$kna['SEARCH_TERM1'];
			$search2=$kna['SEARCH_TERM2'];
			$title=$kna['TITLE_CP'];
			$allowpos=$kna['ALLOW_POS'];
			$nielsen=$kna['NIELSEN_ID'];
			$member_card=$kna['MEMBER_CARD'];
			$vatnum=$kna['VATNUM'];
			$email=$kna['EMAIL'];
			$industry_key=$kna['INDUSTRY_KEY'];
			$account_group=$kna['ACCOUNT_GROUP'];
			$user=$kna['USER_CR'];
			$auth_group=$kna['AUTH_GROUP'];
			$st_send=$kna['ST_SEND'];
			$new_st=$kna['NEW_ST'];
			$st=$kna['ST'];
			$tgl=$kna['TGL'];
			$reasonreject=$kna['REASONREJECT'];
			$date_posting=$kna['DATE_POSTING'];
			$date_approved=$kna['DATE_APPROVED'];
			$date_is=$kna['DATE_IS'];
			$date_delete=$kna['DATE_DELETE'];
			$nik_approved=$kna['NIK_APPROVED'];
			$nik_is=$kna['NIK_IS'];
			$cust_class=$kna['CUST_CLASS'];
			$subject=$kna['SUBJECT'];
			$date_modif=$kna['DATE_MODIF'];
			$nik_modif=$kna['NIK_MODIF'];
		}
		
		
		$fieldKNB1="*";
		$kondisiKNB1="ID_CUST = '".$idCust."'";
		$KNB1=$this->oci_model->select($fieldKNB1, 'M_CUST_KNB1',$kondisiKNB1);
		foreach($KNB1 as $knb){
			$rec_account=$knb['RECONT_ACC'];
		}
		
		$fieldKNVV="*";
		$kondisiKNVV="ID_CUST = '".$idCust."'";
		$KNVV=$this->oci_model->select($fieldKNVV, 'M_CUST_KNVV',$kondisiKNVV);
		foreach($KNVV as $knvv){
			$sales_org=$knvv['SALES_ORG'];
			$dis_channel=$knvv['DIS_CHANNEL'];
			$division=$knvv['DIVISION'];
			$cust_group=$knvv['CUST_GROUP'];
			$inco1=$knvv['INCO1'];
			$inco2=$knvv['INCO2'];
			$curency=$knvv['CURR'];
			$top=$knvv['TOP'];
			$sales_office=$knvv['SALES_OFFICE'];
		}
		
		//Contact Person
		$fieldCP="*";
		$kondisiCP="ID_CUST = '".$idCust."'";
		$data['cp']=$this->oci_model->select($fieldCP, 'M_CONTACT_PERSON',$kondisiCP);
		
		//Get Data Name
		$this->load->model('sap_model');
		$data_company=$this->sap_model->getCompanyCode();
		$data_industry=$this->sap_model->getIndustry();
		$data_customer_class=$this->sap_model->getCustomerClass();
		$data_top=$this->sap_model->getTOP();
		$data_customer_group=$this->sap_model->getCustomerGroup();
		$data_incoterm=$this->sap_model->getIncoterm();
		$data_nielsen=$this->sap_model->getNielsen();
		$data_dis_channel=$this->sap_model->getDistributionChannel();
		$data_division=$this->sap_model->getDivision();
		$data_sales_org=$this->sap_model->getSalesOrganization();
		$data_region=$this->sap_model->getRegion($country_key);
		$data_sales_office=$this->sap_model->getSalesOffice();
		$data_account_group=$this->sap_model->getAccountGroup();
		$data_recon_account=$this->sap_model->getReconAccount();
		
		$data['txt_company']="";
		$data['txt_dischannel']="";
		$data['txt_division']="";
		$data['txt_region']="";
		$data['txt_region']="";
		$data['txt_nielsen']="";
		$data['txt_industry']="";
		$data['txt_custclass']="";
		$data['txt_top']="";
		$data['txt_salesoffice']="";
		$data['txt_inco1']="";
		$data['txt_account_group']="";
		$data['txt_recon']="";
		$data['txt_cust_group']="";
		$data['txt_sales_org']="";
		
		foreach($data_company as $key1 => $com){
			if($key1 == 0 and $com['BUKRS'] == ''){
			continue;}
			if($com['BUKRS'] == $company_code && $com['LAND1'] == 'ID'){
				$data['txt_company']=$com['BUTXT'];
			}
		}
		foreach($data_dis_channel as $key2 => $dis){
			
			if($key2 == 0 and !isset($dis['VTWEG'])){
			continue;}
			if($dis['VTWEG'] == $dis_channel){
				$data['txt_dischannel']=$dis['VTEXT'];
			}
		}
		foreach($data_division as $key3 => $div){
			
			if($key3 == 0 and !isset($div['SPART'])){
			continue;}
			if($div['SPART'] == $division){
				$data['txt_division']=$div['VTEXT'];
			}
		}
		foreach($data_region as $key4 => $reg){
			
			if($key4 == 0 and !isset($reg['BLAND'])){
			continue;}
			if($reg['BLAND'] == $region){
				$data['txt_region']=$reg['BEZEI'];
			}
		}
		
		foreach($data_nielsen as $key5 => $nil){
			if($key5 == 0 and !isset($nil['NIELS'])){
			continue;}
			if($nil['NIELS'] == $nielsen){
				$data['txt_nielsen']=$nil['BEZEI'];
			}
		}
		
		foreach($data_industry as $key6 => $ind){
			if($key6 == 0 and !isset($ind['BRSCH'])){
			continue;}
			if($ind['BRSCH'] == $industry_key){
				$data['txt_industry']=$ind['BRTXT'];
			}
		}
		foreach($data_customer_class as $key7 => $cs){
			if($key7 == 0 and !isset($cs['KUKLA'])){
			continue;}
			if($cs['KUKLA'] == $cust_class){
				$data['txt_custclass']=$cs['VTEXT'];
			}
		}
		
		foreach($data_top as $key8 => $tp){
			if($key8 == 0 and !isset($tp['ZTERM'])){
			continue;}
			if($tp['ZTERM'] == $top){
				$data['txt_top']=$tp['VTEXT'];
			}
		}
		
		foreach($data_sales_office as $key9 => $sof){
			if($key9 == 0 and !isset($sof['VKBUR'])){
			continue;}
			if($sof['VKBUR'] == $sales_office){
				$data['txt_salesoffice']=$sof['BEZEI'];
			}
		}
		foreach($data_incoterm as $key10 => $inc){
			if($key10 == 0 and !isset($inc['INCO1'])){
			continue;}
			if($inc['INCO1'] == $inco1){
				$data['txt_inco1']=$inc['BEZEI'];
			}
		}
		foreach($data_account_group as $key11 => $accg){
			if($key11 == 0 and !isset($accg['KTOKD'])){
			continue;}
			if($accg['KTOKD'] == $account_group){
				$data['txt_account_group']=$accg['TXT30'];
			}
		}
		foreach($data_recon_account as $key12 => $reca){
			if($key12 == 0 and !isset($reca['SAKNR'])){
			continue;}
			if($reca['SAKNR'] == $rec_account){
				$data['txt_recon']=$reca['TXT50'];
			}
		}
		
		foreach($data_customer_group as $key13 => $cgp){
			if($key13 == 0 and !isset($cgp['KDGRP'])){
			continue;}
			if($cgp['KDGRP'] == $cust_group){
				$data['txt_cust_group']=$cgp['KTEXT'];
			}
		}
		
		foreach($data_sales_org as $key14 => $sor){
			if($key14 == 0 and !isset($sor['VKORG'])){
			continue;}
			if($sor['VKORG'] == $sales_org){
				$data['txt_sales_org']=$sor['VTEXT'];
			}
		}
		
		$data['company_code']=$company_code;
		$data['account_group']=$account_group;
		$data['recon_account']=$rec_account;
		$data['dis_channel']=$dis_channel;
		$data['division']=$division;
		$data['title']=$title;
		$data['name1']=$name1;
		$data['name2']=$name2;
		$data['nickname']=$short_field;
		$data['search1']=$search1;
		$data['search2']=$search2;
		$data['address']=$address;
		$data['address2']=$address2;
		$data['address3']=$address3;
		$data['address4']=$address4;
		$data['country']=$country_key;
		$data['region']=$region;
		$data['city']=$city;
		$data['postal_code']=$postal_code;
		$data['tlp']=$tlp1;
		$data['fax']=$fax;
		$data['hp']=$tlp2;
		$data['email']=$email;
		$data['allowpos']=$allowpos;
		$data['subject']=$subject;
		if($allowpos == "1"){
			$data['nielsen']=$nielsen;
		}else{
			$data['nielsen']="";
			$data['txt_nielsen']="";
		}
		
		$data['member_card']=$member_card;
		$data['industry']=$industry_key;
		$data['customer_class']=$cust_class;
		$data['vat']=$vatnum;
		$data['top']=$top;
		$data['sales_office']=$sales_office;
		$data['cust_group']=$cust_group;
		$data['curr']=$curency;
		$data['inco1']=$inco1;
		$data['inco2']=$inco2;
		$data['tgl_create']=$tgl;
		$data['tgl_posting']=$date_posting;
		$data['user_create']=$user;
		$data['tgl_approved']=$date_approved;
		$data['user_approved']=$nik_approved;
		$data['tgl_is']=$date_is;
		$data['user_is']=$nik_is;
		$data['status']=$new_st;
		$data['sales_org']=$sales_org;
		$data['tgl_modif']=$date_modif;
		$data['nik_modif']=$nik_modif;
		$data['st_send']=$st_send;
		$data['id_cust']=$idCust;
		$data['st']=$st;
		
		$data['main_content']="customer/view_cust";
		$this->load->view('template/main',$data);	
	}
	
	function form_edit_cust(){
		if( $this->session->userdata('logged_state') !== true){
		    redirect('home/login');
		}
		$idCust=$this->uri->segment(3);
		$this->load->model('sap_model');
		$this->load->model('oci_model');
		
		$seskode=$this->session->userdata('seskode');
	    
		$fieldKNA="*";
		$kondisiKNA="ID_CUST = '".$idCust."'";
		$KNA1=$this->oci_model->select($fieldKNA, 'VW_CUST',$kondisiKNA);
		foreach($KNA1 as $kna){
			$company_code=$kna['COMPANY_CODE'];
			$cust_account=$kna['CUST_ACCOUNT'];
			$country_key=$kna['COUNTRY_KEY'];
			$name1=$kna['NAME1'];
			$name2=$kna['NAME2'];
			$city=$kna['CITY'];
			$postal_code=$kna['POSTAL_CODE'];
			$region=$kna['REGION'];
			$short_field=$kna['SHORT_FIELD'];
			$tlp1=$kna['TLP1'];
			$tlp2=$kna['TLP2'];
			$fax=$kna['FAX'];
			$address=$kna['ADDRESS'];
			$address2=$kna['ADDRESS2'];
			$address3=$kna['ADDRESS3'];
			$address4=$kna['ADDRESS4'];
			$search1=$kna['SEARCH_TERM1'];
			$search2=$kna['SEARCH_TERM2'];
			$title=$kna['TITLE_CP'];
			$allowpos=$kna['ALLOW_POS'];
			$nielsen=$kna['NIELSEN_ID'];
			$member_card=$kna['MEMBER_CARD'];
			$vatnum=$kna['VATNUM'];
			$email=$kna['EMAIL'];
			$industry_key=$kna['INDUSTRY_KEY'];
			$account_group=$kna['ACCOUNT_GROUP'];
			$user=$kna['USER_CR'];
			$auth_group=$kna['AUTH_GROUP'];
			$st_send=$kna['ST_SEND'];
			$new_st=$kna['NEW_ST'];
			$st=$kna['ST'];
			$tgl=$kna['TGL'];
			$reasonreject=$kna['REASONREJECT'];
			$date_posting=$kna['DATE_POSTING'];
			$date_approved=$kna['DATE_APPROVED'];
			$date_is=$kna['DATE_IS'];
			$date_delete=$kna['DATE_DELETE'];
			$nik_approved=$kna['NIK_APPROVED'];
			$nik_is=$kna['NIK_IS'];
			$cust_class=$kna['CUST_CLASS'];
			$subject=$kna['SUBJECT'];
			$industry_code=$kna['INDUSTRY_CODE1'];
		}
		
		
		
		$fieldKNB1="*";
		$kondisiKNB1="ID_CUST = '".$idCust."'";
		$KNB1=$this->oci_model->select($fieldKNB1, 'M_CUST_KNB1',$kondisiKNB1);
		foreach($KNB1 as $knb){
			$rec_account=$knb['RECONT_ACC'];
		}
		
		$fieldKNVV="*";
		$kondisiKNVV="ID_CUST = '".$idCust."'";
		$KNVV=$this->oci_model->select($fieldKNVV, 'M_CUST_KNVV',$kondisiKNVV);
		foreach($KNVV as $knvv){
			$sales_org=$knvv['SALES_ORG'];
			$dis_channel=$knvv['DIS_CHANNEL'];
			$division=$knvv['DIVISION'];
			$cust_group=$knvv['CUST_GROUP'];
			$inco1=$knvv['INCO1'];
			$inco2=$knvv['INCO2'];
			$curency=$knvv['CURR'];
			$top=$knvv['TOP'];
			$sales_office=$knvv['SALES_OFFICE'];
		}
		
		//Contact Person
		$fieldCP="*";
		$kondisiCP="ID_CUST = '".$idCust."'";
		$data['cp']=$this->oci_model->select($fieldCP, 'M_CONTACT_PERSON',$kondisiCP);
		
		
		$data['xcompany_code']=$company_code;
		$data['xaccount_group']=$account_group;
		$data['xrecon_account']=$rec_account;
		$data['xdis_channel']=$dis_channel;
		$data['xdivision']=$division;
		$data['xtitle']=$title;
		$data['xname1']=$name1;
		$data['xname2']=$name2;
		$data['xcity']=$city;
		$data['xnickname']=$short_field;
		$data['xsearch1']=$search1;
		$data['xsearch2']=$search2;
		$data['xaddress']=$address;
		$data['xaddress2']=$address2;
		$data['xaddress3']=$address3;
		$data['xaddress4']=$address4;
		$data['xcountry']=$country_key;
		$data['xregion']=$region;
		$data['xpostal_code']=$postal_code;
		$data['xtlp']=$tlp1;
		$data['xfax']=$fax;
		$data['xhp']=$tlp2;
		$data['xemail']=$email;
		$data['xallowpos']=$allowpos;
		$data['xnielsen']=$nielsen;
		$data['xmember_card']=$member_card;
		$data['xindustry']=$industry_key;
		$data['xcustomer_class']=$cust_class;
		$data['xvat']=$vatnum;
		$data['xtop']=$top;
		$data['xsales_office']=$sales_office;
		$data['xcust_group']=$cust_group;
		$data['xcurr']=$curency;
		$data['xinco1']=$inco1;
		$data['xinco2']=$inco2;
		$data['xtgl_create']=$tgl;
		$data['xtgl_posting']=$date_posting;
		$data['xuser_create']=$user;
		$data['xtgl_approved']=$date_approved;
		$data['xuser_approved']=$nik_approved;
		$data['xtgl_is']=$date_is;
		$data['xuser_is']=$nik_is;
		$data['xsales_org']=$sales_org;
		$data['xid_cust']=$idCust;
		$data['xsubject']=$subject;
		$data['xindustry_code']=$industry_code;
		$data['xc']=substr($company_code,0,1);
		
		
		$data['company']=$this->sap_model->getCompanyCode();
		$data['country']=$this->sap_model->getCountry();
		$data['industry']=$this->sap_model->getIndustry();
		$data['customer_class']=$this->sap_model->getCustomerClass();
		$data['top']=$this->sap_model->getTOP();
		$data['sales_office']=$this->sap_model->getSalesOffice();
		$data['customer_group']=$this->sap_model->getCustomerGroup();
		$data['currency']=$this->sap_model->getCurrency();
		$data['incoterm']=$this->sap_model->getIncoterm();
		$data['departemen']=$this->sap_model->getDepartemen();
		$data['function']=$this->sap_model->getFunction();
		$data['nielsen']=$this->sap_model->getNielsen();
		$data['dis_channel']=$this->sap_model->getDistributionChannel();
		$data['division']=$this->sap_model->getDivision();
		$data['sales_org']=$this->sap_model->getSalesOrganization();
		$data['region_select']=$this->sap_model->getRegion($country_key);
		$data['industry_code']=$this->sap_model->getIndustryCode();
		$data['account_group']=$this->sap_model->getAccountGroup();
		$data['recon_account']=$this->sap_model->getReconAccount();
		$data['call_frequency']=$this->sap_model->getCallFrequency();
		
		//SEND DATA CP
		//delete_temp CP
		$kondisiTempDel="SESKODE = '".$seskode."'";
		$this->oci_model->Exec(FALSE, FALSE, 'TEMP_CP', $kondisiTempDel, 'delete');
		
		//get data CP to temp
		$fieldCP="*";
		$kondisiCP="ID_CUST = '".$idCust."'";
		$dataCP=$this->oci_model->select($fieldCP, 'M_CONTACT_PERSON',$kondisiCP);
		foreach($dataCP as $cp){
			$ctitle=$cp['TITLE_CP'];
			$cfirstname=$cp['FIRSTNAME_CP'];
			$cname=$cp['NAME_CP'];
			$ctlp=$cp['TLP_CP'];
			$cext=$cp['EXT_CP'];
			$chp=$cp['HP_CP'];
			$cfax=$cp['FAX_CP'];
			$cdept=$cp['DEPARTMENT'];
			$cfunc=$cp['FUNC'];
			$cemail=$cp['EMAIL_CP'];
			$cgender = $cp['GENDER'];
			$ctgl_lahir= $cp['TGL_LAHIR'];
			$ccall_freq= $cp['CALL_FREQ'];
			$cdate_register=$cp['DATE_REGISTER'];
			
			date_default_timezone_set('Asia/Jakarta');
			$tgl=date("Y-m-d");
			
			$fieldH='TITLE_CP, FIRSTNAME_CP, NAME_CP, TLP_CP, EXT_CP, HP_CP, FAX_CP, EMAIL_CP, DEPARTMENT, FUNC, SESKODE, GENDER, TGL_LAHIR, CALL_REQ, DATE_REGISTER';
			$valH= "'".trim($ctitle)."', '".trim($cfirstname)."', '".trim($cname)."', '".trim($ctlp)."', '".trim($cext)."', '".trim($chp)."', '".trim($cfax)."' , '".trim($cemail)."', '".trim($cdept)."',  '".trim($cfunc)."', '".trim($seskode)."', '".trim($cgender)."', '".trim($ctgl_lahir)."', '".trim($ccall_freq)."', '".trim($cdate_register)."' ";
			$exec=$this->oci_model->Exec($fieldH, $valH, 'TEMP_CP', FALSE, 'insert');
			
		}
		
		$data['main_content']="customer/form_edit_cust";
		$this->load->view('template/main',$data);	
	}
	
	function edit_customer(){
		if( $this->session->userdata('logged_state') !== true){
		    redirect('home/login');
		}
		$seskode=$this->session->userdata('seskode');
		$this->load->model('oci_model');
		//General
		$id_cust=$this->input->post('id_cust');
		$country=$this->input->post('country');
		$name1=$this->input->post('name1');
		$name2=$this->input->post('name2');
		$city=$this->input->post('city');
		$postalcode=$this->input->post('postalcode');
		$region=$this->input->post('region_h');
		$sotl=substr($name1, 0, 9);
		$tlp1=$this->input->post('tlp');
		$tlp2=$this->input->post('hp');
		$fax=$this->input->post('fax');
		$address=$this->input->post('address');
		$address2=$this->input->post('address2');
		$address3=$this->input->post('address3');
		$address4=$this->input->post('address4');
		$search1=$this->input->post('search1');
		$search2=$this->input->post('search2');
		$title=$this->input->post('title');
		$allowpos=$this->input->post('ck1_h');
		$nielsen_id=$this->input->post('nielsen');
		$member_card=$this->input->post('membercard');
		$vatnum=$this->input->post('vat');
		$email=$this->input->post('email');
		$industry_key=$this->input->post('industry');
		$user_cr=$this->session->userdata('NIK');
		$st_send="0";
		$st="1";
		$subject=$this->input->post('subject');
		$industry_code=$this->input->post('industry_code1');
		$customer_class=$this->input->post('customer_class');
		$seskode=$this->session->userdata('seskode');
		
		$account_group=$this->input->post('account_group');
		$recont_account=$this->input->post('recon_account');
		
		if($allowpos == '0'){
			$nielsen_id ="";
		}
		if($allowpos == "1"){
			if($nielsen_id == ""){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Failed, Please input Nielsen ID if allow data at POS!</div>');
				$url="customer/list_cust_req";
				redirect($url);
			}
			if($member_card == ""){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Failed, Please input Member Card if allow data at POS!</div>');
				$url="customer/list_cust_req";
				redirect($url);
			}
			if($industry_key == ""){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Failed, Please input Industry Key if allow data at POS!</div>');
				$url="customer/list_cust_req";
				redirect($url);
			}if($customer_class == ""){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Failed, Please input Customer Class if allow data at POS!</div>');
				$url="customer/list_cust_req";
				redirect($url);
			}
			if($industry_code == ""){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Failed, Please input Industry Code 1 if allow data at POS!</div>');
				$url="customer/list_cust_req";
				redirect($url);
			}
			
		}
		
		
		//Basic Data
		$company=$this->input->post('company');
		$sales_org=$this->input->post('sales_org');
		$dis_channel=$this->input->post('dis_channel');
		$division=$this->input->post('division');
		
		//Sales Area Data
		$top=$this->input->post('top');
		$sales_office=$this->input->post('sales_office');
		$cust_group=$this->input->post('customer_group');
		$currency=$this->input->post('currency');
		$inco1=$this->input->post('incoterm');
		$inco2=$this->input->post('deskripsi');
		
//		date_default_timezone_set('Asia/Jakarta');
//                $tgl=date("Y-m-d");
		$nik=$this->session->userdata('NIK');
		
		//update KNA1
		$fieldKNA1="INDUSTRY_CODE1 = '".$industry_code."', COUNTRY_KEY = '".$country."', NAME1 = '".$name1."', NAME2 = '".$name2."', CITY = '".$city."', POSTAL_CODE = '".$postalcode."', REGION = '".$region."', SHORT_FIELD = '".$sotl."', TLP1 = '".$tlp1."', TLP2 = '".$tlp2."', FAX = '".$fax."', ADDRESS = '".$address."', SEARCH_TERM1 = '".$search1."', SEARCH_TERM2 = '".$search2."', TITLE_CP = '".$title."', ALLOW_POS = '".$allowpos."', NIELSEN_ID = '".$nielsen_id."', MEMBER_CARD = '".$member_card."', VATNUM = '".$vatnum."', EMAIL = '".$email."', INDUSTRY_KEY = '".$industry_key."', CUST_CLASS = '".$customer_class."', SUBJECT = '".$subject."', ADDRESS2 = '".$address2."', ADDRESS3 = '".$address3."', ADDRESS4 = '".$address4."',DATE_MODIF = TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI'), NIK_MODIF = '".$nik."', ACCOUNT_GROUP = '".$account_group."'";
		$kondisiKNA1="ID_CUST = '".$id_cust."'";
		$exec=$this->oci_model->Exec($fieldKNA1, FALSE, 'M_CUST_KNA1', $kondisiKNA1, 'update');
		
		if($exec <= 0){
		    $this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Failed to update Customer!</div>');
			$url="customer/list_cust_req";
			redirect($url);
		}else{
			//Insert KNVV
			$fieldKNVV="INCO1 = '".$inco1."', INCO2 = '".$inco2."', CUST_GROUP = '".$cust_group."', CURR = '".$currency."', TOP = '".$top."', SALES_OFFICE = '".$sales_office."'";
			$kondisiKNVV="ID_CUST = '".$id_cust."' AND SALES_ORG = '".$sales_org."'";
			$exec=$this->oci_model->Exec($fieldKNVV, FALSE, 'M_CUST_KNVV', $kondisiKNVV, 'update');
			
			//Insert KNB1
			$fieldKNB1="RECONT_ACC = '".$recont_account."'";
			$kondisiKNB1="ID_CUST = '".$id_cust."' AND COMPANY_CODE = '".$company."'";
			$exec=$this->oci_model->Exec($fieldKNB1, FALSE, 'M_CUST_KNB1', $kondisiKNB1, 'update');
			
			//Insert Contact Person
			$fieldTemp="*";
			$kondisiTemp="SESKODE = '".$seskode."'";
			$tempCP = $this->oci_model->select($fieldTemp, "TEMP_CP", $kondisiTemp);
			//delete CP yg ada
			$kondisiCPdel="ID_CUST = '".$id_cust."'";
			$this->oci_model->Exec(FALSE, FALSE, 'M_CONTACT_PERSON', $kondisiCPdel, 'delete');
			
			foreach($tempCP as $a){
				//Insert CP by Line Temp
				$id_cp = $this->oci_model->nextIDCP('ID_CP', 'M_CONTACT_PERSON',FALSE);
				
				$fieldCP='ID_CUST, ID_CP, TITLE_CP, FIRSTNAME_CP, NAME_CP, TLP_CP, EXT_CP, HP_CP, FAX_CP, EMAIL_CP, DEPARTMENT, FUNC, GENDER, TGL_LAHIR, CALL_FREQ, DATE_REGISTER';
				$valueCP= "'".$id_cust."', '".$id_cp."', '".$a['TITLE_CP']."', '".$a['FIRSTNAME_CP']."', '".$a['NAME_CP']."', '".$a['TLP_CP']."', '".$a['EXT_CP']."', '".$a['HP_CP']."', '".$a['FAX_CP']."' , '".$a['EMAIL_CP']."', '".$a['DEPARTMENT']."',  '".$a['FUNC']."',  '".$a['GENDER']."',  '".$a['TGL_LAHIR']."', '".$a['CALL_REQ']."', '".$a['DATE_REGISTER']."'";
				$exec=$this->oci_model->Exec($fieldCP, $valueCP, 'M_CONTACT_PERSON', FALSE, 'insert');
			}
			
			
			//delete_temp
			$kondisiTempDel="SESKODE = '".$seskode."'";
			$this->oci_model->Exec(FALSE, FALSE, 'TEMP_CP', $kondisiTempDel, 'delete');
	    
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Update Customer Success! </div>');
			    redirect(site_url('customer/list_cust_req'));
			   //$this->form_cust();
			
		}
		
	}
	
	function unposting_cust(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$id=$this->input->post('id');
		date_default_timezone_set('Asia/Jakarta');
		$tgl=date("Y-m-d");
		
		$st=$this->oci_model->getStatusCustomer($id);
		if($st == "1"){
			$field="ST_SEND = '0', DATE_POSTING = ''";
			$kondisi="ID_CUST = '".$id."'";
			$exec=$this->oci_model->Exec($field, false, 'M_CUST_KNA1', $kondisi, 'update');
			
			if($exec == 1){
				$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Success!</h4>
					 Unposting Customer Request Success</div>');
			}
		}else{
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					 Unposting failed, status customer not "Posting".</div>');
		}
		
	}
	
	function list_cust_approval(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->my_auth->hak_akses("APPROVAL");
		
		$this->load->model('oci_model');
		$nik=$this->session->userdata('NIK');
		
		if(strpos($this->session->userdata('role'),'ADMINISTRATOR') !== false){
			$field="ID_CUST,CUST_ACCOUNT,COUNTRY_KEY,NAME1,NAME2,
				CITY,POSTAL_CODE,REGION,SHORT_FIELD,TLP1,TLP2,FAX,
				ADDRESS,SEARCH_TERM1,SEARCH_TERM2,TITLE_CP,ALLOW_POS,
				NIELSEN_ID,MEMBER_CARD,VATNUM,EMAIL,INDUSTRY_KEY,ACCOUNT_GROUP,
				USER_CR,AUTH_GROUP,ST_SEND,NEW_ST,ST,TGL, REASONREJECT,DATE_POSTING,
				DATE_APPROVED,DATE_IS,DATE_DELETE,NIK_APPROVED,NIK_IS,
				COMPANY_CODE,CUST_CLASS,SUBJECT,ADDRESS2,
				ADDRESS3,DATE_MODIF,NIK_MODIF,RECONT_ACC,SALES_ORG,
				DIS_CHANNEL,DIVISION,CUST_GROUP,INCO1,INCO2,
				CURR,TOP,SALES_OFFICE,INDUSTRY_CODE1,SHORT_KEY,
				SALES_GROUP,CUST_PRICE,CUST_STAT,ACCOUNT_ASS,ADDRESS4,
				DEV_USERS.GET_NAME_BY_NIK(USER_CR) AS NAME_CREATE";
			$kondisi="(ST_SEND='1' OR ST_SEND = '2') AND ST = '1' ORDER BY ID_CUST DESC";
			$data['row']=$this->oci_model->select($field, 'VW_CUST',$kondisi);
		}else{
			$field="ID_CUST,CUST_ACCOUNT,COUNTRY_KEY,NAME1,NAME2,
				CITY,POSTAL_CODE,REGION,SHORT_FIELD,TLP1,TLP2,FAX,
				ADDRESS,SEARCH_TERM1,SEARCH_TERM2,TITLE_CP,ALLOW_POS,
				NIELSEN_ID,MEMBER_CARD,VATNUM,EMAIL,INDUSTRY_KEY,ACCOUNT_GROUP,
				USER_CR,AUTH_GROUP,ST_SEND,NEW_ST,ST,TGL, REASONREJECT,DATE_POSTING,
				DATE_APPROVED,DATE_IS,DATE_DELETE,NIK_APPROVED,NIK_IS,
				COMPANY_CODE,CUST_CLASS,SUBJECT,ADDRESS2,
				ADDRESS3,DATE_MODIF,NIK_MODIF,RECONT_ACC,SALES_ORG,
				DIS_CHANNEL,DIVISION,CUST_GROUP,INCO1,INCO2,
				CURR,TOP,SALES_OFFICE,INDUSTRY_CODE1,SHORT_KEY,
				SALES_GROUP,CUST_PRICE,CUST_STAT,ACCOUNT_ASS,ADDRESS4,
				DEV_USERS.GET_NAME_BY_NIK(USER_CR) AS NAME_CREATE";
			$kondisi="(ST_SEND='1' OR ST_SEND = '2') AND ST = '1' AND GET_ST_HAK('".$nik."', SALES_ORG,DIS_CHANNEL,DIVISION) = '1' ORDER BY ID_CUST DESC";
			$data['row']=$this->oci_model->select($field, 'VW_CUST',$kondisi);
		}
		
		$data['main_content']="customer/list_cust_approval";
		$this->load->view('template/main',$data);	
		
	}
	
	function form_approval(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$idCust=$this->uri->segment(3);
		
		$fieldKNA="*";
		$kondisiKNA="ID_CUST = '".$idCust."'";
		$KNA1=$this->oci_model->select($fieldKNA, 'VW_CUST',$kondisiKNA);
		foreach($KNA1 as $kna){
			$company_code=$kna['COMPANY_CODE'];
			$cust_account=$kna['CUST_ACCOUNT'];
			$country_key=$kna['COUNTRY_KEY'];
			$name1=$kna['NAME1'];
			$name2=$kna['NAME2'];
			$city=$kna['CITY'];
			$postal_code=$kna['POSTAL_CODE'];
			$region=$kna['REGION'];
			$short_field=$kna['SHORT_FIELD'];
			$tlp1=$kna['TLP1'];
			$tlp2=$kna['TLP2'];
			$fax=$kna['FAX'];
			$address=$kna['ADDRESS'];
			$address2=$kna['ADDRESS2'];
			$address3=$kna['ADDRESS3'];
			$address4=$kna['ADDRESS4'];
			$search1=$kna['SEARCH_TERM1'];
			$search2=$kna['SEARCH_TERM2'];
			$title=$kna['TITLE_CP'];
			$allowpos=$kna['ALLOW_POS'];
			$nielsen=$kna['NIELSEN_ID'];
			$member_card=$kna['MEMBER_CARD'];
			$vatnum=$kna['VATNUM'];
			$email=$kna['EMAIL'];
			$industry_key=$kna['INDUSTRY_KEY'];
			$account_group=$kna['ACCOUNT_GROUP'];
			$user=$kna['USER_CR'];
			$auth_group=$kna['AUTH_GROUP'];
			$st_send=$kna['ST_SEND'];
			$new_st=$kna['NEW_ST'];
			$st=$kna['ST'];
			$tgl=$kna['TGL'];
			$reasonreject=$kna['REASONREJECT'];
			$date_posting=$kna['DATE_POSTING'];
			$date_approved=$kna['DATE_APPROVED'];
			$date_is=$kna['DATE_IS'];
			$date_delete=$kna['DATE_DELETE'];
			$nik_approved=$kna['NIK_APPROVED'];
			$nik_is=$kna['NIK_IS'];
			$cust_class=$kna['CUST_CLASS'];
			$subject=$kna['SUBJECT'];
			$date_modif=$kna['DATE_MODIF'];
			$nik_modif=$kna['NIK_MODIF'];
			$industry_code=$kna['INDUSTRY_CODE1'];
		}
		
		
		$fieldKNB1="*";
		$kondisiKNB1="ID_CUST = '".$idCust."'";
		$KNB1=$this->oci_model->select($fieldKNB1, 'M_CUST_KNB1',$kondisiKNB1);
		foreach($KNB1 as $knb){
			$rec_account=$knb['RECONT_ACC'];
		}
		
		$fieldKNVV="*";
		$kondisiKNVV="ID_CUST = '".$idCust."'";
		$KNVV=$this->oci_model->select($fieldKNVV, 'M_CUST_KNVV',$kondisiKNVV);
		foreach($KNVV as $knvv){
			$sales_org=$knvv['SALES_ORG'];
			$dis_channel=$knvv['DIS_CHANNEL'];
			$division=$knvv['DIVISION'];
			$cust_group=$knvv['CUST_GROUP'];
			$inco1=$knvv['INCO1'];
			$inco2=$knvv['INCO2'];
			$curency=$knvv['CURR'];
			$top=$knvv['TOP'];
			$sales_office=$knvv['SALES_OFFICE'];
		}
		
		//Contact Person
		$fieldCP="*";
		$kondisiCP="ID_CUST = '".$idCust."'";
		$data['cp']=$this->oci_model->select($fieldCP, 'M_CONTACT_PERSON',$kondisiCP);
		
		//Get Data Name
		$this->load->model('sap_model');
		$data_company=$this->sap_model->getCompanyCode();
		$data_industry=$this->sap_model->getIndustry();
		$data_customer_class=$this->sap_model->getCustomerClass();
		$data_top=$this->sap_model->getTOP();
		$data_customer_group=$this->sap_model->getCustomerGroup();
		$data_incoterm=$this->sap_model->getIncoterm();
		$data_nielsen=$this->sap_model->getNielsen();
		$data_dis_channel=$this->sap_model->getDistributionChannel();
		$data_division=$this->sap_model->getDivision();
		$data_sales_org=$this->sap_model->getSalesOrganization();
		$data_region=$this->sap_model->getRegion($country_key);
		$data_sales_office=$this->sap_model->getSalesOffice();
		$data_account_group=$this->sap_model->getAccountGroup();
		$data_recon_account=$this->sap_model->getReconAccount();
		$data_industry_code=$this->sap_model->getIndustryCode();
		
		$data['txt_company']="";
		$data['txt_dischannel']="";
		$data['txt_division']="";
		$data['txt_region']="";
		$data['txt_region']="";
		$data['txt_nielsen']="";
		$data['txt_industry']="";
		$data['txt_custclass']="";
		$data['txt_top']="";
		$data['txt_salesoffice']="";
		$data['txt_inco1']="";
		$data['txt_account_group']="";
		$data['txt_recon']="";
		$data['txt_cust_group']="";
		$data['txt_sales_org']="";
		$data['txt_industry_code']="";
		
		foreach($data_company as $key1 => $com){
			if($key1 == 0 and $com['BUKRS'] == ''){
			continue;}
			if($com['BUKRS'] == $company_code && $com['LAND1'] == 'ID'){
				$data['txt_company']=$com['BUTXT'];
			}
		}
		foreach($data_dis_channel as $key2 => $dis){
			
			if($key2 == 0 and !isset($dis['VTWEG'])){
			continue;}
			if($dis['VTWEG'] == $dis_channel){
				$data['txt_dischannel']=$dis['VTEXT'];
			}
		}
		foreach($data_division as $key3 => $div){
			
			if($key3 == 0 and !isset($div['SPART'])){
			continue;}
			if($div['SPART'] == $division){
				$data['txt_division']=$div['VTEXT'];
			}
		}
		foreach($data_region as $key4 => $reg){
			
			if($key4 == 0 and !isset($reg['BLAND'])){
			continue;}
			if($reg['BLAND'] == $region){
				$data['txt_region']=$reg['BEZEI'];
			}
		}
		
		foreach($data_nielsen as $key5 => $nil){
			if($key5 == 0 and !isset($nil['NIELS'])){
			continue;}
			if($nil['NIELS'] == $nielsen){
				$data['txt_nielsen']=$nil['BEZEI'];
			}
		}
		
		foreach($data_industry as $key6 => $ind){
			if($key6 == 0 and !isset($ind['BRSCH'])){
			continue;}
			if($ind['BRSCH'] == $industry_key){
				$data['txt_industry']=$ind['BRTXT'];
			}
		}
		foreach($data_customer_class as $key7 => $cs){
			if($key7 == 0 and !isset($cs['KUKLA'])){
			continue;}
			if($cs['KUKLA'] == $cust_class){
				$data['txt_custclass']=$cs['VTEXT'];
			}
		}
		
		foreach($data_top as $key8 => $tp){
			if($key8 == 0 and !isset($tp['ZTERM'])){
			continue;}
			if($tp['ZTERM'] == $top){
				$data['txt_top']=$tp['VTEXT'];
			}
		}
		
		foreach($data_sales_office as $key9 => $sof){
			if($key9 == 0 and !isset($sof['VKBUR'])){
			continue;}
			if($sof['VKBUR'] == $sales_office){
				$data['txt_salesoffice']=$sof['BEZEI'];
			}
		}
		foreach($data_incoterm as $key10 => $inc){
			if($key10 == 0 and !isset($inc['INCO1'])){
			continue;}
			if($inc['INCO1'] == $inco1){
				$data['txt_inco1']=$inc['BEZEI'];
			}
		}
		foreach($data_account_group as $key11 => $accg){
			if($key11 == 0 and !isset($accg['KTOKD'])){
			continue;}
			if($accg['KTOKD'] == $account_group){
				$data['txt_account_group']=$accg['TXT30'];
			}
		}
		foreach($data_recon_account as $key12 => $reca){
			if($key12 == 0 and !isset($reca['SAKNR'])){
			continue;}
			if($reca['SAKNR'] == $rec_account){
				$data['txt_recon']=$reca['TXT50'];
			}
		}
		
		foreach($data_customer_group as $key13 => $cgp){
			if($key13 == 0 and !isset($cgp['KDGRP'])){
			continue;}
			if($cgp['KDGRP'] == $cust_group){
				$data['txt_cust_group']=$cgp['KTEXT'];
			}
		}
		
		foreach($data_sales_org as $key14 => $sor){
			if($key14 == 0 and !isset($sor['VKORG'])){
			continue;}
			if($sor['VKORG'] == $sales_org){
				$data['txt_sales_org']=$sor['VTEXT'];
			}
		}
		foreach($data_industry_code as $key15 => $icc){
			if($key15 == 0 and !isset($icc['BRACO'])){
			continue;}
			if($icc['BRACO'] == $industry_code){
				$data['txt_industry_code']=$icc['VTEXT'];
			}
		}
		
		
		$data['company_code']=$company_code;
		$data['xaccount_group']=$account_group;
		$data['xrecon_account']=$rec_account;
		$data['dis_channel']=$dis_channel;
		$data['division']=$division;
		$data['title']=$title;
		$data['name1']=$name1;
		$data['name2']=$name2;
		$data['nickname']=$short_field;
		$data['search1']=$search1;
		$data['search2']=$search2;
		$data['address']=$address;
		$data['address2']=$address2;
		$data['address3']=$address3;
		$data['address4']=$address4;
		$data['country']=$country_key;
		$data['region']=$region;
		$data['city']=$city;
		$data['postal_code']=$postal_code;
		$data['tlp']=$tlp1;
		$data['fax']=$fax;
		$data['hp']=$tlp2;
		$data['email']=$email;
		$data['allowpos']=$allowpos;
		$data['account_group']=$data_account_group;
		$data['recon_account']=$data_recon_account;
		$data['industry_code']=$industry_code;
		if($allowpos == "1"){
			$data['nielsen']=$nielsen;
		}else{
			$data['nielsen']="";
			$data['txt_nielsen']="";
		}
		$data['id_cust']=$idCust;
		$data['member_card']=$member_card;
		$data['industry']=$industry_key;
		$data['customer_class']=$cust_class;
		$data['vat']=$vatnum;
		$data['top']=$top;
		$data['sales_office']=$sales_office;
		$data['cust_group']=$cust_group;
		$data['curr']=$curency;
		$data['inco1']=$inco1;
		$data['inco2']=$inco2;
		$data['tgl_create']=$tgl;
		$data['tgl_posting']=$date_posting;
		$data['user_create']=$user;
		$data['tgl_approved']=$date_approved;
		$data['user_approved']=$nik_approved;
		$data['tgl_is']=$date_is;
		$data['user_is']=$nik_is;
		$data['status']=$new_st;
		$data['sales_org']=$sales_org;
		$data['xsubject']=$subject;
		$data['tgl_modif']=$date_modif;
		$data['nik_modif']=$nik_modif;
		
		$data['main_content']="customer/form_approval";
		$this->load->view('template/main',$data);
	}
	
	function add_approval(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$seskode=$this->session->userdata('seskode');
		$nik=$this->session->userdata('NIK');
		
		$this->load->model('oci_model');
		$id_cust=$this->input->post('id_cust');
		$acc_group=$this->input->post('account_group');
		$rec_account=$this->input->post('recon_account');
		$company_code=$this->input->post('company');
		$industry_code1=$this->input->post('industry_code');
		$short_key=$this->input->post('short_key');
		
		$sales_group=$this->input->post('sales_group');
		$cust_price=$this->input->post('cust_price');
		$cust_stat=$this->input->post('cust_stat');
		$relevan=$this->input->post('relevant_pod');
		$account_ass=$this->input->post('account_ass');
		$order_prob="000";
		
		$fieldKNA="*";
		$kondisiKNA="ID_CUST = '".$id_cust."'";
		$KNA1=$this->oci_model->select($fieldKNA, 'VW_CUST',$kondisiKNA);
		foreach($KNA1 as $kna){
			$sales_org=$kna['SALES_ORG'];
			$dis_channel=$kna['DIS_CHANNEL'];
			$division=$kna['DIVISION'];
		}
		
		date_default_timezone_set('Asia/Jakarta');
		$tgl=date("Y-m-d");
		
		$stHak=$this->oci_model->cek_hak_akses($nik, $sales_org, $dis_channel, $division);
		if($stHak < 1){
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Sorry you do not have access, please contact the administrator !</div>');
			$url="customer/list_cust_approval";
			redirect($url);
		}
		
		$fieldU="DISTINCT(NIK), DEV_USERS.GET_NAME_BY_NIK(NIK) as NAMA, DEV_USERS.GET_EMAIL_BY_NIK(NIK) AS EMAIL";
		$kondisiU="SALES_ORG='".$sales_org."' AND DIS_CHANNEL='".$dis_channel."' AND DIVISION='".$division."' AND NIK IN (SELECT NIK FROM M_CUST_ROLE WHERE (ROLE='MASTERDATA' OR ROLE='ADMINISTRATOR'))";
		$listNIK=$this->oci_model->select($fieldU, 'M_CUST_PRIVILEGE',$kondisiU);
		
		$jml=count($listNIK);
		if($jml > 0){
			foreach($listNIK as $a){
				$nik=$a['NIK'];
				$email = $a['EMAIL'];
				$nama = $a['NAMA'];
				if($email <> ""){
					$this->send_mail($email, "REQUEST TRANSPORT NEW CUSTOMER", "approval", "new", $nama, $id_cust);
				}
			}
		}
		
		//update KNB1
		$fieldKNB1="SHORT_KEY = '".$short_key."', RECONT_ACC = '".$rec_account."'";
		$kondisiKNB1="ID_CUST = '".$id_cust."' AND COMPANY_CODE = '".$company_code."'";
		$execKNB1=$this->oci_model->Exec($fieldKNB1, false, 'M_CUST_KNB1', $kondisiKNB1, 'update');
		
		//update customer KNA1
		$field="INDUSTRY_CODE1 = '".$industry_code1."', ST_SEND = '2', DATE_APPROVED = TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI'), NIK_APPROVED = '".$nik."', ACCOUNT_GROUP = '".$acc_group."'";
		$kondisi="ID_CUST = '".$id_cust."'";
		$exec=$this->oci_model->Exec($field, false, 'M_CUST_KNA1', $kondisi, 'update');
		
		//update customer KNVV
		$fieldKNVV="SALES_GROUP = '".$sales_group."', CUST_PRICE = '".$cust_price."', CUST_STAT = '".$cust_stat."', RELEVAN_POD = '".$relevan."', ACCOUNT_ASS = '".$account_ass."', ORDER_PROB = '".$order_prob."'";
		$kondisiKNVV="ID_CUST = '".$id_cust."'";
		$exec=$this->oci_model->Exec($fieldKNVV, false, 'M_CUST_KNVV', $kondisiKNVV, 'update');
		
		
		
		if($exec == 1){
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Approval Customer Request Success.</div>');
			redirect('customer/list_cust_approval');
		}
		
	}
	
	function form_edit_approval(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$idCust=$this->uri->segment(3);
		
		$fieldKNA="*";
		$kondisiKNA="ID_CUST = '".$idCust."'";
		$KNA1=$this->oci_model->select($fieldKNA, 'VW_CUST',$kondisiKNA);
		foreach($KNA1 as $kna){
			$company_code=$kna['COMPANY_CODE'];
			$cust_account=$kna['CUST_ACCOUNT'];
			$country_key=$kna['COUNTRY_KEY'];
			$name1=$kna['NAME1'];
			$name2=$kna['NAME2'];
			$city=$kna['CITY'];
			$postal_code=$kna['POSTAL_CODE'];
			$region=$kna['REGION'];
			$short_field=$kna['SHORT_FIELD'];
			$tlp1=$kna['TLP1'];
			$tlp2=$kna['TLP2'];
			$fax=$kna['FAX'];
			$address=$kna['ADDRESS'];
			$address2=$kna['ADDRESS2'];
			$address3=$kna['ADDRESS3'];
			$address4=$kna['ADDRESS4'];
			$search1=$kna['SEARCH_TERM1'];
			$search2=$kna['SEARCH_TERM2'];
			$title=$kna['TITLE_CP'];
			$allowpos=$kna['ALLOW_POS'];
			$nielsen=$kna['NIELSEN_ID'];
			$member_card=$kna['MEMBER_CARD'];
			$vatnum=$kna['VATNUM'];
			$email=$kna['EMAIL'];
			$industry_key=$kna['INDUSTRY_KEY'];
			$account_group=$kna['ACCOUNT_GROUP'];
			$user=$kna['USER_CR'];
			$auth_group=$kna['AUTH_GROUP'];
			$st_send=$kna['ST_SEND'];
			$new_st=$kna['NEW_ST'];
			$st=$kna['ST'];
			$tgl=$kna['TGL'];
			$reasonreject=$kna['REASONREJECT'];
			$date_posting=$kna['DATE_POSTING'];
			$date_approved=$kna['DATE_APPROVED'];
			$date_is=$kna['DATE_IS'];
			$date_delete=$kna['DATE_DELETE'];
			$nik_approved=$kna['NIK_APPROVED'];
			$nik_is=$kna['NIK_IS'];
			$cust_class=$kna['CUST_CLASS'];
			$subject=$kna['SUBJECT'];
			$date_modif=$kna['DATE_MODIF'];
			$nik_modif=$kna['NIK_MODIF'];
			$industry_code1=$kna['INDUSTRY_CODE1'];
		}
		
		
		$fieldKNB1="*";
		$kondisiKNB1="ID_CUST = '".$idCust."'";
		$KNB1=$this->oci_model->select($fieldKNB1, 'M_CUST_KNB1',$kondisiKNB1);
		foreach($KNB1 as $knb){
			$rec_account=$knb['RECONT_ACC'];
		}
		
		$fieldKNVV="*";
		$kondisiKNVV="ID_CUST = '".$idCust."'";
		$KNVV=$this->oci_model->select($fieldKNVV, 'M_CUST_KNVV',$kondisiKNVV);
		foreach($KNVV as $knvv){
			$sales_org=$knvv['SALES_ORG'];
			$dis_channel=$knvv['DIS_CHANNEL'];
			$division=$knvv['DIVISION'];
			$cust_group=$knvv['CUST_GROUP'];
			$inco1=$knvv['INCO1'];
			$inco2=$knvv['INCO2'];
			$curency=$knvv['CURR'];
			$top=$knvv['TOP'];
			$sales_office=$knvv['SALES_OFFICE'];
		}
		
		//Contact Person
		$fieldCP="*";
		$kondisiCP="ID_CUST = '".$idCust."'";
		$data['cp']=$this->oci_model->select($fieldCP, 'M_CONTACT_PERSON',$kondisiCP);
		
		//Get Data Name
		$this->load->model('sap_model');
		$data_company=$this->sap_model->getCompanyCode();
		$data_industry=$this->sap_model->getIndustry();
		$data_customer_class=$this->sap_model->getCustomerClass();
		$data_top=$this->sap_model->getTOP();
		$data_customer_group=$this->sap_model->getCustomerGroup();
		$data_incoterm=$this->sap_model->getIncoterm();
		$data_nielsen=$this->sap_model->getNielsen();
		$data_dis_channel=$this->sap_model->getDistributionChannel();
		$data_division=$this->sap_model->getDivision();
		$data_sales_org=$this->sap_model->getSalesOrganization();
		$data_region=$this->sap_model->getRegion($country_key);
		$data_sales_office=$this->sap_model->getSalesOffice();
		$data_account_group=$this->sap_model->getAccountGroup();
		$data_recon_account=$this->sap_model->getReconAccount();
		
		
		$data['txt_company']="";
		$data['txt_dischannel']="";
		$data['txt_division']="";
		$data['txt_region']="";
		$data['txt_region']="";
		$data['txt_nielsen']="";
		$data['txt_industry']="";
		$data['txt_custclass']="";
		$data['txt_top']="";
		$data['txt_salesoffice']="";
		$data['txt_inco1']="";
		$data['txt_account_group']="";
		$data['txt_recon']="";
		$data['txt_cust_group']="";
		$data['txt_sales_org']="";
		
		foreach($data_company as $key1 => $com){
			if($key1 == 0 and $com['BUKRS'] == ''){
			continue;}
			if($com['BUKRS'] == $company_code && $com['LAND1'] == 'ID'){
				$data['txt_company']=$com['BUTXT'];
			}
		}
		foreach($data_dis_channel as $key2 => $dis){
			
			if($key2 == 0 and !isset($dis['VTWEG'])){
			continue;}
			if($dis['VTWEG'] == $dis_channel){
				$data['txt_dischannel']=$dis['VTEXT'];
			}
		}
		foreach($data_division as $key3 => $div){
			
			if($key3 == 0 and !isset($div['SPART'])){
			continue;}
			if($div['SPART'] == $division){
				$data['txt_division']=$div['VTEXT'];
			}
		}
		foreach($data_region as $key4 => $reg){
			
			if($key4 == 0 and !isset($reg['BLAND'])){
			continue;}
			if($reg['BLAND'] == $region){
				$data['txt_region']=$reg['BEZEI'];
			}
		}
		
		foreach($data_nielsen as $key5 => $nil){
			if($key5 == 0 and !isset($nil['NIELS'])){
			continue;}
			if($nil['NIELS'] == $nielsen){
				$data['txt_nielsen']=$nil['BEZEI'];
			}
		}
		
		foreach($data_industry as $key6 => $ind){
			if($key6 == 0 and !isset($ind['BRSCH'])){
			continue;}
			if($ind['BRSCH'] == $industry_key){
				$data['txt_industry']=$ind['BRTXT'];
			}
		}
		foreach($data_customer_class as $key7 => $cs){
			if($key7 == 0 and !isset($cs['KUKLA'])){
			continue;}
			if($cs['KUKLA'] == $cust_class){
				$data['txt_custclass']=$cs['VTEXT'];
			}
		}
		
		foreach($data_top as $key8 => $tp){
			if($key8 == 0 and !isset($tp['ZTERM'])){
			continue;}
			if($tp['ZTERM'] == $top){
				$data['txt_top']=$tp['VTEXT'];
			}
		}
		
		foreach($data_sales_office as $key9 => $sof){
			if($key9 == 0 and !isset($sof['VKBUR'])){
			continue;}
			if($sof['VKBUR'] == $sales_office){
				$data['txt_salesoffice']=$sof['BEZEI'];
			}
		}
		foreach($data_incoterm as $key10 => $inc){
			if($key10 == 0 and !isset($inc['INCO1'])){
			continue;}
			if($inc['INCO1'] == $inco1){
				$data['txt_inco1']=$inc['BEZEI'];
			}
		}
		foreach($data_account_group as $key11 => $accg){
			if($key11 == 0 and !isset($accg['KTOKD'])){
			continue;}
			if($accg['KTOKD'] == $account_group){
				$data['txt_account_group']=$accg['TXT30'];
			}
		}
		foreach($data_recon_account as $key12 => $reca){
			if($key12 == 0 and !isset($reca['SAKNR'])){
			continue;}
			if($reca['SAKNR'] == $rec_account){
				$data['txt_recon']=$reca['TXT50'];
			}
		}
		
		foreach($data_customer_group as $key13 => $cgp){
			if($key13 == 0 and !isset($cgp['KDGRP'])){
			continue;}
			if($cgp['KDGRP'] == $cust_group){
				$data['txt_cust_group']=$cgp['KTEXT'];
			}
		}
		
		foreach($data_sales_org as $key14 => $sor){
			if($key14 == 0 and !isset($sor['VKORG'])){
			continue;}
			if($sor['VKORG'] == $sales_org){
				$data['txt_sales_org']=$sor['VTEXT'];
			}
		}
		
		$data['company_code']=$company_code;
		$data['xaccount_group']=$account_group;
		$data['xrecon_account']=$rec_account;
		$data['dis_channel']=$dis_channel;
		$data['division']=$division;
		$data['title']=$title;
		$data['name1']=$name1;
		$data['name2']=$name2;
		$data['nickname']=$short_field;
		$data['search1']=$search1;
		$data['search2']=$search2;
		$data['address']=$address;
		$data['address2']=$address2;
		$data['address3']=$address3;
		$data['address4']=$address4;
		$data['country']=$country_key;
		$data['region']=$region;
		$data['city']=$city;
		$data['postal_code']=$postal_code;
		$data['tlp']=$tlp1;
		$data['fax']=$fax;
		$data['hp']=$tlp2;
		$data['email']=$email;
		$data['allowpos']=$allowpos;
		$data['account_group']=$data_account_group;
		$data['recon_account']=$data_recon_account;
		$data['xindustry_code']=$industry_code1;
		if($allowpos == "1"){
			$data['nielsen']=$nielsen;
		}else{
			$data['nielsen']="";
			$data['txt_nielsen']="";
		}
		$data['id_cust']=$idCust;
		$data['member_card']=$member_card;
		$data['industry']=$industry_key;
		$data['customer_class']=$cust_class;
		$data['vat']=$vatnum;
		$data['top']=$top;
		$data['sales_office']=$sales_office;
		$data['cust_group']=$cust_group;
		$data['curr']=$curency;
		$data['inco1']=$inco1;
		$data['inco2']=$inco2;
		$data['tgl_create']=$tgl;
		$data['tgl_posting']=$date_posting;
		$data['user_create']=$user;
		$data['tgl_approved']=$date_approved;
		$data['user_approved']=$nik_approved;
		$data['tgl_is']=$date_is;
		$data['user_is']=$nik_is;
		$data['status']=$new_st;
		$data['sales_org']=$sales_org;
		$data['xsubject']=$subject;
		$data['tgl_modif']=$date_modif;
		$data['nik_modif']=$nik_modif;
		
		$data['main_content']="customer/form_edit_approval";
		$this->load->view('template/main',$data);
	}
	
	function edit_approval(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$seskode=$this->session->userdata('seskode');
		$nik=$this->session->userdata('NIK');
		
		$this->load->model('oci_model');
		$id_cust=$this->input->post('id_cust');
		$acc_group=$this->input->post('account_group');
		$rec_account=$this->input->post('recon_account');
		$company_code=$this->input->post('company');
		
		$nik=$this->session->userdata('NIK');
		
		$this->load->model('oci_model');
		$id_cust=$this->input->post('id_cust');
		$acc_group=$this->input->post('account_group');
		$rec_account=$this->input->post('recon_account');
		$company_code=$this->input->post('company');
		
		$fieldKNA="*";
		$kondisiKNA="ID_CUST = '".$id_cust."'";
		$KNA1=$this->oci_model->select($fieldKNA, 'VW_CUST',$kondisiKNA);
		foreach($KNA1 as $kna){
			$sales_org=$kna['SALES_ORG'];
			$dis_channel=$kna['DIS_CHANNEL'];
			$division=$kna['DIVISION'];
		}
		
		date_default_timezone_set('Asia/Jakarta');
		$tgl=date("Y-m-d");
		
		$stHak=$this->oci_model->cek_hak_akses($nik, $sales_org, $dis_channel, $division);
		if($stHak < 1){
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Sorry you do not have access, please contact the administrator !</div>');
			$url="customer/list_cust_approval";
			redirect($url);
		}
		
		//update KNB1
		$fieldKNB1="RECONT_ACC = '".$rec_account."'";
		$kondisiKNB1="ID_CUST = '".$id_cust."' AND COMPANY_CODE = '".$company_code."'";
		$execKNB1=$this->oci_model->Exec($fieldKNB1, false, 'M_CUST_KNB1', $kondisiKNB1, 'update');
		
		//update customer KNA1
		$field="ST_SEND = '2', DATE_APPROVED = TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI'), NIK_APPROVED = '".$nik."', ACCOUNT_GROUP = '".$acc_group."'";
		$kondisi="ID_CUST = '".$id_cust."'";
		$exec=$this->oci_model->Exec($field, false, 'M_CUST_KNA1', $kondisi, 'update');
		
		if($exec == 1){
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Edit Approval Customer Request Success.</div>');
			redirect('customer/list_cust_approval');
		}
	}
	
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
	
	function master_level(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->my_auth->hak_akses("ADMINISTRATOR");
		
		$this->load->model('oci_model');
		//$usr=$this->session->userdata('NIK');
		$field="*";
		$kondisi="";
		$data['row']=$this->oci_model->select($field, 'M_APP_LEVEL',FALSE);
		$data['main_content']="customer/master_level";
		$this->load->view('template/main',$data);	
	}
	
	function add_level(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$nik=$this->input->post('nik');
		$app2=$this->input->post('app');
		
		$field='NIK, APP2';
		$value= "'".$nik."', '".$app2."'";
		$exec=$this->oci_model->Exec($field, $value, 'M_APP_LEVEL', FALSE, 'insert');
		if($exec == 1){
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Add Level Approval Success.</div>');
			redirect('customer/master_level');
		}
	}
	
	function hapus_level(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$id=$this->input->post('id');
		$this->oci_model->Exec(FALSE, FALSE, 'M_APP_LEVEL', "NIK=".$id, 'delete');
		$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Delete level approval success</div>');
	}
	
	function form_edit_level(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$nik=$this->uri->segment(3);
		$fieldDet="*";
		$kondisiDet="NIK = '$nik'";
		$det=$this->oci_model->select($fieldDet, "M_APP_LEVEL", $kondisiDet);
		foreach($det as $a){
			$data['nik']=$a['NIK'];
			$data['app']=$a['APP2'];
		}
		
		$field="*";
		$kondisi="";
		$data['row']=$this->oci_model->select($field, 'M_APP_LEVEL',FALSE);
		$data['main_content']="customer/master_edit_level";
		$this->load->view('template/main',$data);	
	}
	
	function edit_level(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$nik=$this->input->post('nik');
		$app=$this->input->post('app');
		
		$field="APP2 = '".$app."'";
		$kondisi="NIK = '".$nik."'";
		$exec=$this->oci_model->Exec($field, false, 'M_APP_LEVEL', $kondisi, 'update');
		
		if($exec == 1){
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Edit Level Approval Success.</div>');
			redirect('customer/master_level');
		}
	}
	
	function list_cust_is(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->my_auth->hak_akses("MASTERDATA");
		
		$this->load->model('oci_model');
		$nik=$this->session->userdata('NIK');
		if(strpos($this->session->userdata('role'),'ADMINISTRATOR') !== false){
			$field="ID_CUST,CUST_ACCOUNT,COUNTRY_KEY,NAME1,NAME2,
				CITY,POSTAL_CODE,REGION,SHORT_FIELD,TLP1,TLP2,FAX,
				ADDRESS,SEARCH_TERM1,SEARCH_TERM2,TITLE_CP,ALLOW_POS,
				NIELSEN_ID,MEMBER_CARD,VATNUM,EMAIL,INDUSTRY_KEY,ACCOUNT_GROUP,
				USER_CR,AUTH_GROUP,ST_SEND,NEW_ST,ST,TGL, REASONREJECT,DATE_POSTING,
				DATE_APPROVED,DATE_IS,DATE_DELETE,NIK_APPROVED,NIK_IS,
				COMPANY_CODE,CUST_CLASS,SUBJECT,ADDRESS2,
				ADDRESS3,DATE_MODIF,NIK_MODIF,RECONT_ACC,SALES_ORG,
				DIS_CHANNEL,DIVISION,CUST_GROUP,INCO1,INCO2,
				CURR,TOP,SALES_OFFICE,INDUSTRY_CODE1,SHORT_KEY,
				SALES_GROUP,CUST_PRICE,CUST_STAT,ACCOUNT_ASS,ADDRESS4,
				DEV_USERS.GET_NAME_BY_NIK(USER_CR) AS NAME_CREATE";
			$kondisi="ST_SEND = '2' AND ST = '1'";
			$data['row']=$this->oci_model->select($field, 'VW_CUST',$kondisi);
		}else{
			$field="ID_CUST,CUST_ACCOUNT,COUNTRY_KEY,NAME1,NAME2,
				CITY,POSTAL_CODE,REGION,SHORT_FIELD,TLP1,TLP2,FAX,
				ADDRESS,SEARCH_TERM1,SEARCH_TERM2,TITLE_CP,ALLOW_POS,
				NIELSEN_ID,MEMBER_CARD,VATNUM,EMAIL,INDUSTRY_KEY,ACCOUNT_GROUP,
				USER_CR,AUTH_GROUP,ST_SEND,NEW_ST,ST,TGL, REASONREJECT,DATE_POSTING,
				DATE_APPROVED,DATE_IS,DATE_DELETE,NIK_APPROVED,NIK_IS,
				COMPANY_CODE,CUST_CLASS,SUBJECT,ADDRESS2,
				ADDRESS3,DATE_MODIF,NIK_MODIF,RECONT_ACC,SALES_ORG,
				DIS_CHANNEL,DIVISION,CUST_GROUP,INCO1,INCO2,
				CURR,TOP,SALES_OFFICE,INDUSTRY_CODE1,SHORT_KEY,
				SALES_GROUP,CUST_PRICE,CUST_STAT,ACCOUNT_ASS,ADDRESS4,
				DEV_USERS.GET_NAME_BY_NIK(USER_CR) AS NAME_CREATE";
			$kondisi="ST_SEND = '2' AND ST = '1' AND GET_ST_HAK('".$nik."', SALES_ORG,DIS_CHANNEL,DIVISION) = '1' ";
			$data['row']=$this->oci_model->select($field, 'VW_CUST',$kondisi);
		}
		
		$data['main_content']="customer/list_cust_is";
		$this->load->view('template/main',$data);	
	}
	
	function form_transport(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$idCust=$this->uri->segment(3);
		
		$fieldKNA="*";
		$kondisiKNA="ID_CUST = '".$idCust."'";
		$KNA1=$this->oci_model->select($fieldKNA, 'VW_CUST',$kondisiKNA);
		foreach($KNA1 as $kna){
			$company_code=$kna['COMPANY_CODE'];
			$cust_account=$kna['CUST_ACCOUNT'];
			$country_key=$kna['COUNTRY_KEY'];
			$name1=$kna['NAME1'];
			$name2=$kna['NAME2'];
			$city=$kna['CITY'];
			$postal_code=$kna['POSTAL_CODE'];
			$region=$kna['REGION'];
			$short_field=$kna['SHORT_FIELD'];
			$tlp1=$kna['TLP1'];
			$tlp2=$kna['TLP2'];
			$fax=$kna['FAX'];
			$address=$kna['ADDRESS'];
			$address2=$kna['ADDRESS2'];
			$address3=$kna['ADDRESS3'];
			$address4=$kna['ADDRESS4'];
			$search1=$kna['SEARCH_TERM1'];
			$search2=$kna['SEARCH_TERM2'];
			$title=$kna['TITLE_CP'];
			$allowpos=$kna['ALLOW_POS'];
			$nielsen=$kna['NIELSEN_ID'];
			$member_card=$kna['MEMBER_CARD'];
			$vatnum=$kna['VATNUM'];
			$email=$kna['EMAIL'];
			$industry_key=$kna['INDUSTRY_KEY'];
			$account_group=$kna['ACCOUNT_GROUP'];
			$user=$kna['USER_CR'];
			$auth_group=$kna['AUTH_GROUP'];
			$st_send=$kna['ST_SEND'];
			$new_st=$kna['NEW_ST'];
			$st=$kna['ST'];
			$tgl=$kna['TGL'];
			$reasonreject=$kna['REASONREJECT'];
			$date_posting=$kna['DATE_POSTING'];
			$date_approved=$kna['DATE_APPROVED'];
			$date_is=$kna['DATE_IS'];
			$date_delete=$kna['DATE_DELETE'];
			$nik_approved=$kna['NIK_APPROVED'];
			$nik_is=$kna['NIK_IS'];
			$cust_class=$kna['CUST_CLASS'];
			$subject=$kna['SUBJECT'];
			$date_modif=$kna['DATE_MODIF'];
			$nik_modif=$kna['NIK_MODIF'];
			$industry_code=$kna['INDUSTRY_CODE1'];
		}
		
		
		$fieldKNB1="*";
		$kondisiKNB1="ID_CUST = '".$idCust."'";
		$KNB1=$this->oci_model->select($fieldKNB1, 'M_CUST_KNB1',$kondisiKNB1);
		foreach($KNB1 as $knb){
			$rec_account=$knb['RECONT_ACC'];
		}
		
		$fieldKNVV="*";
		$kondisiKNVV="ID_CUST = '".$idCust."'";
		$KNVV=$this->oci_model->select($fieldKNVV, 'M_CUST_KNVV',$kondisiKNVV);
		foreach($KNVV as $knvv){
			$sales_org=$knvv['SALES_ORG'];
			$dis_channel=$knvv['DIS_CHANNEL'];
			$division=$knvv['DIVISION'];
			$cust_group=$knvv['CUST_GROUP'];
			$inco1=$knvv['INCO1'];
			$inco2=$knvv['INCO2'];
			$curency=$knvv['CURR'];
			$top=$knvv['TOP'];
			$sales_office=$knvv['SALES_OFFICE'];
		}
		
		//Contact Person
		$fieldCP="*";
		$kondisiCP="ID_CUST = '".$idCust."'";
		$data['cp']=$this->oci_model->select($fieldCP, 'M_CONTACT_PERSON',$kondisiCP);
		
		//Get Data Name
		$this->load->model('sap_model');
		$data_company=$this->sap_model->getCompanyCode();
		$data_industry=$this->sap_model->getIndustry();
		$data_customer_class=$this->sap_model->getCustomerClass();
		$data_top=$this->sap_model->getTOP();
		$data_customer_group=$this->sap_model->getCustomerGroup();
		$data_incoterm=$this->sap_model->getIncoterm();
		$data_nielsen=$this->sap_model->getNielsen();
		$data_dis_channel=$this->sap_model->getDistributionChannel();
		$data_division=$this->sap_model->getDivision();
		$data_sales_org=$this->sap_model->getSalesOrganization();
		$data_region=$this->sap_model->getRegion($country_key);
		$data_sales_office=$this->sap_model->getSalesOffice();
		$data_account_group=$this->sap_model->getAccountGroup();
		$data_recon_account=$this->sap_model->getReconAccount();
		
		$data['txt_company']="";
		$data['txt_dischannel']="";
		$data['txt_division']="";
		$data['txt_region']="";
		$data['txt_region']="";
		$data['txt_nielsen']="";
		$data['txt_industry']="";
		$data['txt_custclass']="";
		$data['txt_top']="";
		$data['txt_salesoffice']="";
		$data['txt_inco1']="";
		$data['txt_account_group']="";
		$data['txt_recon']="";
		$data['txt_cust_group']="";
		$data['txt_sales_org']="";
		
		foreach($data_company as $key1 => $com){
			if($key1 == 0 and $com['BUKRS'] == ''){
			continue;}
			if($com['BUKRS'] == $company_code && $com['LAND1'] == 'ID'){
				$data['txt_company']=$com['BUTXT'];
			}
		}
		foreach($data_dis_channel as $key2 => $dis){
			
			if($key2 == 0 and !isset($dis['VTWEG'])){
			continue;}
			if($dis['VTWEG'] == $dis_channel){
				$data['txt_dischannel']=$dis['VTEXT'];
			}
		}
		foreach($data_division as $key3 => $div){
			
			if($key3 == 0 and !isset($div['SPART'])){
			continue;}
			if($div['SPART'] == $division){
				$data['txt_division']=$div['VTEXT'];
			}
		}
		foreach($data_region as $key4 => $reg){
			
			if($key4 == 0 and !isset($reg['BLAND'])){
			continue;}
			if($reg['BLAND'] == $region){
				$data['txt_region']=$reg['BEZEI'];
			}
		}
		
		foreach($data_nielsen as $key5 => $nil){
			if($key5 == 0 and !isset($nil['NIELS'])){
			continue;}
			if($nil['NIELS'] == $nielsen){
				$data['txt_nielsen']=$nil['BEZEI'];
			}
		}
		
		foreach($data_industry as $key6 => $ind){
			if($key6 == 0 and !isset($ind['BRSCH'])){
			continue;}
			if($ind['BRSCH'] == $industry_key){
				$data['txt_industry']=$ind['BRTXT'];
			}
		}
		foreach($data_customer_class as $key7 => $cs){
			if($key7 == 0 and !isset($cs['KUKLA'])){
			continue;}
			if($cs['KUKLA'] == $cust_class){
				$data['txt_custclass']=$cs['VTEXT'];
			}
		}
		
		foreach($data_top as $key8 => $tp){
			if($key8 == 0 and !isset($tp['ZTERM'])){
			continue;}
			if($tp['ZTERM'] == $top){
				$data['txt_top']=$tp['VTEXT'];
			}
		}
		
		foreach($data_sales_office as $key9 => $sof){
			if($key9 == 0 and !isset($sof['VKBUR'])){
			continue;}
			if($sof['VKBUR'] == $sales_office){
				$data['txt_salesoffice']=$sof['BEZEI'];
			}
		}
		foreach($data_incoterm as $key10 => $inc){
			if($key10 == 0 and !isset($inc['INCO1'])){
			continue;}
			if($inc['INCO1'] == $inco1){
				$data['txt_inco1']=$inc['BEZEI'];
			}
		}
		foreach($data_account_group as $key11 => $accg){
			if($key11 == 0 and !isset($accg['KTOKD'])){
			continue;}
			if($accg['KTOKD'] == $account_group){
				$data['txt_account_group']=$accg['TXT30'];
			}
		}
		foreach($data_recon_account as $key12 => $reca){
			if($key12 == 0 and !isset($reca['SAKNR'])){
			continue;}
			if($reca['SAKNR'] == $rec_account){
				$data['txt_recon']=$reca['TXT50'];
			}
		}
		
		foreach($data_customer_group as $key13 => $cgp){
			if($key13 == 0 and !isset($cgp['KDGRP'])){
			continue;}
			if($cgp['KDGRP'] == $cust_group){
				$data['txt_cust_group']=$cgp['KTEXT'];
			}
		}
		
		foreach($data_sales_org as $key14 => $sor){
			if($key14 == 0 and !isset($sor['VKORG'])){
			continue;}
			if($sor['VKORG'] == $sales_org){
				$data['txt_sales_org']=$sor['VTEXT'];
			}
		}
		
		$data['company_code']=$company_code;
		$data['account_group']=$account_group;
		$data['recon_account']=$rec_account;
		$data['dis_channel']=$dis_channel;
		$data['division']=$division;
		$data['title']=$title;
		$data['name1']=$name1;
		$data['name2']=$name2;
		$data['nickname']=$short_field;
		$data['search1']=$search1;
		$data['search2']=$search2;
		$data['address']=$address;
		$data['address2']=$address2;
		$data['address3']=$address3;
		$data['address4']=$address4;
		$data['country']=$country_key;
		$data['region']=$region;
		$data['city']=$city;
		$data['postal_code']=$postal_code;
		$data['tlp']=$tlp1;
		$data['fax']=$fax;
		$data['hp']=$tlp2;
		$data['email']=$email;
		$data['allowpos']=$allowpos;
		$data['subject']=$subject;
		if($allowpos == "1"){
			$data['nielsen']=$nielsen;
		}else{
			$data['nielsen']="";
			$data['txt_nielsen']="";
		}
		
		$data['member_card']=$member_card;
		$data['industry']=$industry_key;
		$data['customer_class']=$cust_class;
		$data['vat']=$vatnum;
		$data['top']=$top;
		$data['sales_office']=$sales_office;
		$data['cust_group']=$cust_group;
		$data['curr']=$curency;
		$data['inco1']=$inco1;
		$data['inco2']=$inco2;
		$data['tgl_create']=$tgl;
		$data['tgl_posting']=$date_posting;
		$data['user_create']=$user;
		$data['tgl_approved']=$date_approved;
		$data['user_approved']=$nik_approved;
		$data['tgl_is']=$date_is;
		$data['user_is']=$nik_is;
		$data['status']=$new_st;
		$data['sales_org']=$sales_org;
		$data['id_cust']=$idCust;
		$data['tgl_modif']=$date_modif;
		$data['nik_modif']=$nik_modif;
		$data['industry_code']=$industry_code;
		$data['main_content']="customer/form_transport";
		$this->load->view('template/main',$data);
	}
	
	function get_recon(){
		$this->load->model('sap_model');
		$this->load->model('oci_model');
		$acc=$this->input->post('id');
		$idrecon=$this->oci_model->getIdRecon($acc);
		$recon_account=$this->sap_model->getReconAccount();
		//print_r($reg);
		echo '<select name="recon_account" id="recon_account" class="span6" readonly="readonly">
				      ';
		foreach($recon_account as $key2 => $rec){
			if($key2 == 0 and !isset($rec['SAKNR'])){
			    continue;}
			if($rec['SAKNR'] == $idrecon){
				echo "<option selected='selected' value='".$rec['SAKNR']."'>".$rec['SAKNR']." - ".$rec['TXT50']."</option>";
			}
			
		      }
		echo '</select>';
	}
	function testx(){
		echo date("Ymd");
	}
	function transport_sap(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$this->load->model('sap_model');
		date_default_timezone_set('Asia/Jakarta');
		$tgl=date("Y-m-d");
		$erdat = date("Ymd");
		$idCust=$this->input->post('id_cust');
		
		$fieldKNA="*";
		$kondisiKNA="ID_CUST = '".$idCust."'";
		$KNA1=$this->oci_model->select($fieldKNA, 'VW_CUST',$kondisiKNA);
		foreach($KNA1 as $kna){
			$company_code=$kna['COMPANY_CODE'];
			$cust_account=$kna['CUST_ACCOUNT'];
			$country_key=$kna['COUNTRY_KEY'];
			$name1=$kna['NAME1'];
			$name2=$kna['NAME2'];
			$city=$kna['CITY'];
			$postal_code=$kna['POSTAL_CODE'];
			$region=$kna['REGION'];
			$short_field=$kna['SHORT_FIELD'];
			$tlp1=$kna['TLP1'];
			$tlp2=$kna['TLP2'];
			$fax=$kna['FAX'];
			$address=$kna['ADDRESS'];
			$address2=$kna['ADDRESS2'];
			$address3=$kna['ADDRESS3'];
			$address4=$kna['ADDRESS4'];
			$search1=$kna['SEARCH_TERM1'];
			$search2=$kna['SEARCH_TERM2'];
			$title=$kna['TITLE_CP'];
			$allowpos=$kna['ALLOW_POS'];
			$nielsen=$kna['NIELSEN_ID'];
			$member_card=$kna['MEMBER_CARD'];
			$vatnum=$kna['VATNUM'];
			$email=$kna['EMAIL'];
			$industry_key=$kna['INDUSTRY_KEY'];
			$account_group=$kna['ACCOUNT_GROUP'];
			$user=$kna['USER_CR'];
			$auth_group=$kna['AUTH_GROUP'];
			$st_send=$kna['ST_SEND'];
			$new_st=$kna['NEW_ST'];
			$st=$kna['ST'];
			$tgl=$kna['TGL'];
			$reasonreject=$kna['REASONREJECT'];
			$date_posting=$kna['DATE_POSTING'];
			$date_approved=$kna['DATE_APPROVED'];
			$date_is=$kna['DATE_IS'];
			$date_delete=$kna['DATE_DELETE'];
			$nik_approved=$kna['NIK_APPROVED'];
			$nik_is=$kna['NIK_IS'];
			$cust_class=$kna['CUST_CLASS'];
			$subject=$kna['SUBJECT'];
			$sales_org=$kna['SALES_ORG'];
			$dis_channel=$kna['DIS_CHANNEL'];
			$division=$kna['DIVISION'];
			$industry_code1=$kna['INDUSTRY_CODE1'];
		}
		
		$nik=$this->session->userdata('NIK');
		$stHak=$this->oci_model->cek_hak_akses($nik, $sales_org, $dis_channel, $division);
		if($stHak < 1){
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Sorry you do not have access, please contact the administrator !</div>');
			$url="customer/list_cust_is";
			redirect($url);
		}
		
		$fieldKNB1="*";
		$kondisiKNB1="ID_CUST = '".$idCust."'";
		$KNB1=$this->oci_model->select($fieldKNB1, 'M_CUST_KNB1',$kondisiKNB1);
		foreach($KNB1 as $knb){
			$rec_account=$knb['RECONT_ACC'];
			$short_key=$knb['SHORT_KEY'];
		}
		
		$fieldKNVV="*";
		$kondisiKNVV="ID_CUST = '".$idCust."'";
		$KNVV=$this->oci_model->select($fieldKNVV, 'M_CUST_KNVV',$kondisiKNVV);
		foreach($KNVV as $knvv){
			$sales_org=$knvv['SALES_ORG'];
			$dis_channel=$knvv['DIS_CHANNEL'];
			$division=$knvv['DIVISION'];
			$cust_group=$knvv['CUST_GROUP'];
			$inco1=$knvv['INCO1'];
			$inco2=$knvv['INCO2'];
			$curency=$knvv['CURR'];
			$top=$knvv['TOP'];
			$sales_office=$knvv['SALES_OFFICE'];
			$sales_group=$knvv['SALES_GROUP'];
			$cust_price=$knvv['CUST_PRICE'];
			$cust_stat=$knvv['CUST_STAT'];
			$relevan_pod=$knvv['RELEVAN_POD'];
			$account_ass=$knvv['ACCOUNT_ASS'];
			$order_prob=$knvv['ORDER_PROB'];
		}
		
		//Contact Person
		$fieldCP="*";
		$kondisiCP="ID_CUST = '".$idCust."'";
		$data_cp=$this->oci_model->select($fieldCP, 'M_CONTACT_PERSON',$kondisiCP);
		
		//Cek Data
		$stBasic=$this->oci_model->cek_data_basic($company_code, $sales_org, $dis_channel, $division);
		if($stBasic < 1){
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Failed transport to SAP, Check Company Code, Sales Org., Distribution Channel, and Division not allowed.</div>');
			$url="customer/form_transport/".$idCust;
			redirect($url);
		}
		
		$custReference=$this->oci_model->getCustomerRef($company_code, $sales_org, $dis_channel, $division);
		
		if($rec_account == ""){
			$stFinance=$this->oci_model->cek_data_sales2($account_group);
		}else{
			$stFinance=$this->oci_model->cek_data_sales($account_group, $rec_account);
		}
		
		if($stFinance < 1){
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Failed transport to SAP, Check Account Group and Recon Account.</div>');
			$url="customer/form_transport/".$idCust;
			redirect($url);
		}
		
		$personalData=array(
			'TITLE_P' => $title,
			'FIRSTNAME' => $name1,
			'LASTNAME' => $short_field,
			'MIDDLENAME' => "",
			'SECONDNAME' => $name2,
			'DATE_BIRTH' => "",
			'CITY' => $city,
			'DISTRICT' => "",
			'POSTL_COD1' => $postal_code,
			'POSTL_COD2' => "",
			'PO_BOX' => "00000",
			'PO_BOX_CIT' => "00000",
			'STREET' => $address,
			'HOUSE_NO' => "",
			'BUILDING' => "",
			'FLOOR' => "",
			'ROOM_NO' => "",
			'COUNTRY' => $country_key,
			'COUNTRYISO' => "",
			'REGION' => $region,
			'TEL1_NUMBR' => $tlp1,
			'TEL1_EXT' => "",
			'FAX_NUMBER' => $fax,
			'FAX_EXTENS' => "",
			'E_MAIL' => $email,
			'LANGU_P' => "EN",
			'LANGUP_ISO' => "",
			'CURRENCY' => $curency,
			'CURRENCY_ISO' => "",
			'TITLE_KEY' => "",
			'ONLY_CHANGE_COMADDRESS' => ""
		);
		
		$optPersonalData=array(
			'TRANSPZONE' => "",
			'CONTROL_ACCOUNT' => $rec_account,
			'PMNTTRMS' => $top,
			'SHIP_COND' => "",
			'DELYG_PLNT' => "",
			'PART_DLV' => "",
			'PART_DLV' => "",
			'C_CTR_AREA'=>"",
			'TAXJURCODE'=>""
		);
		
		$copyreference=array(
			'SALESORG' => $sales_org,
			'DISTR_CHAN' => $dis_channel,
			'DIVISION' => $division,
			'REF_CUSTMR' => $custReference
		);
		
		$credit_control_flag="0";
		
		// Load SAP Call-Function
		$this->load->library('saprfc');	
		$this->load->library('sapauth');		
		echo $postal_code."<br/>";
		echo $tgl."<br/>";
		
		$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
		//Cek Connection SAP Status	
		$data['content']=$this->saprfc->callFunction("ZBAPI_CUSTOMER_CREATEFROMDATA1",
			array(	array("IMPORT","PI_PERSONALDATA",$personalData),
				array("IMPORT","PI_OPT_PERSONALDATA",$optPersonalData),
				array("IMPORT","PI_COPYREFERENCE",$copyreference),
				array("IMPORT","PI_CREDIT_CONTROL_FLAG",$credit_control_flag),
				array("EXPORT","CUSTOMERNO",array()),
				array("EXPORT","RETURN",array())
			     )
			);
				
		echo $this->saprfc->printStatus();
		echo $this->saprfc->getStatus();
		
		$xkunnr = $data['content']["CUSTOMERNO"];
		//$kunnr = substr($xkunnr, 0, -1);
		echo $xkunnr;
		echo "<br/><br/>";
		echo print_r($data['content']["RETURN"]);
		echo "<br/><br/>";
		echo $data['content']["RETURN"]['TYPE']."<br/>";
		$this->saprfc->logoff();
		
		if($data['content']["RETURN"]['TYPE'] == "E"){
			$error = $data['content']["RETURN"]['MESSAGE'];
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Failed transport to SAP, Error : '.$error.'</div>');
			$url="customer/form_transport/".$idCust;
			redirect($url);

		}else{
			if($xkunnr == ""){
				echo "kosong";
			}else{
				$nameFix = $name1." ".$short_field;
				//update via BAPI ZBAPI_TEST_INSERT_CUST
				$kna1=array(
					'KUNNR' => $xkunnr, //ID Customer
					'LAND1' => $country_key, //Country
					'NAME1' => $nameFix, 
					'NAME2' => $name2,
					'ORT01' => $city, //City
					'PSTLZ' => $postal_code, //Postal Code
					'REGIO' => $region, //Region
					'SORTL' => $name1, //short
					'STRAS' => $address, //alamat jalan
					'TELF1' => $tlp1, //tlp1
					'TELFX' => $fax, //Fax
					'MCOD1' => $search1, //Search 1
					'MCOD2' => $search2, //Search 2
					'ANRED' => $title, //Title
					'BRSCH' => $industry_key, //Industry Key
					'KTOKD' => $account_group, //Customer Account Group
					'KUKLA' => $cust_class, //Customer classification
					'NIELS' => $nielsen, //Nielsen ID
					'ORT02' => $country_key, //Country
					'SPRAS' => "EN", //LAnguage
					'STCEG' => $vatnum, //Vatnum
					'ERNAM' => "INTERFACE",
					'TELF2' => $tlp2, //telp2
					'ERDAT' => $erdat,
					'BRAN1' => $industry_code1 //INDUSTRY Code 1
				);
				
				$knb1=array(
					'KUNNR' => $xkunnr, 
					'BUKRS' => $company_code, //Company
					'AKONT' => $rec_account, //Recont account
					'ZTERM' => $top, //TOP
					'QLAND' => $country_key, //Withholding Tax Country Key
					'ERNAM' => "INTERFACE",
					'ERDAT' => $erdat,
					'ZUAWA' => $short_key // SHORT KEY
				);
				
				$knvv=array(
					'KUNNR' => $xkunnr, //Id Customer
					'VKORG' => $sales_org, //Sales Org.
					'VTWEG' => $dis_channel, //Distribution Channel
					'SPART' => $division, //Division
					'KDGRP' => $cust_group, //Customer Group
					'INCO1' => $inco1, //Incoterm 1
					'INCO2' => $inco2, //Incoterm 2
					'WAERS' => $curency, //Mata Uang
					'ZTERM' => $top, //top
					'VKBUR' => $sales_office, //Sales office
					'VKGRP' => $sales_group, //Sales Group
					'KALKS' => $cust_price, //Cust Price
					'VERSG' => $cust_stat, //Customer Statistic Group
					'KTGRD' => $account_ass, // Account assignment group for this customer
					'PODKZ' => $relevan_pod, //Relevant for POD processing
					'AWAHR' => $order_prob // Order probability of the item
				);
				
				$addr1=array(
					'ADDR_NO' => "",
					'FORMOFADDR' => $title,
					'NAME' => $name1,
					'NAME_2' => $name2,
					'CITY' => $city,
					'POSTL_COD1' => $postal_code,
					'STREET' => $address,
					'STR_SUPPL1' => $address2,
					'STR_SUPPL2' => $address3,
					'STR_SUPPL3' => $address4,
					'COUNTRY' => $country_key,
					'LANGU' => "EN",
					'REGION' => $region,
					'SORT1' => $search1,
					'SORT2' => $search2,
					'ADR_NOTES' => $member_card,
					'TEL1_NUMBR' => $tlp1,
					'TEL1_EXT' => "",
					'FAX_NUMBER' => $fax,
					'E_MAIL' => $email
				);
				
				$this->load->library('saprfc');	
				$this->load->library('sapauth');		
				
				$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
				//Cek Connection SAP Status	
				$data['content']=$this->saprfc->callFunction("ZBAPI_TEST_INSERT_CUST",
					array(	array("IMPORT","X_KNA1",$kna1),
						array("IMPORT","X_KNB1",$knb1),
						array("IMPORT","X_KNVV",$knvv),
						array("IMPORT","X_BAPIADDR1",$addr1),
						array("EXPORT","XKUNNR",array()),
						array("EXPORT","O_KNA1",array())
					     )
					); 	
				//echo $this->saprfc->printStatus();
				//echo $this->saprfc->getStatus();
				echo "<br/><br/>";
				echo "<pre>";
				print_r($data['content']["O_KNA1"]);
				echo "</pre>";
				
				//-------------------add no HP----------------------------
				$this->load->library('saprfc');	
				$this->load->library('sapauth');		
				
				$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
				//Cek Connection SAP Status	
				$data['content']=$this->saprfc->callFunction("ZBAPI_CHANGE_HP_CUSTOMER",
					array(	array("IMPORT","XKUNNR",$xkunnr),
						array("IMPORT","NO_HP",$tlp2)
					     )
					); 	
				echo $this->saprfc->printStatus();
				echo $this->saprfc->getStatus();
				//8e1f
				
				//CONTACT PERSON-----------------------------
				$fieldC="*";
				$kondisiC="ID_CUST='".$idCust."'";
				$listContact=$this->oci_model->select($fieldC, 'M_CONTACT_PERSON', $kondisiC);
				
				$jmlContact=count($listContact);
				if($jmlContact > 0){
					$this->load->library('saprfc');	
					$this->load->library('sapauth');	
					foreach($listContact as $con){
						$title_cp = $con['TITLE_CP'];
						$firstname_cp = $con['FIRSTNAME_CP'];
						$name_cp = $con['NAME_CP'];
						$tlp_cp = $con['TLP_CP'];
						$ext_cp = $con['EXT_CP'];
						$hp_cp = $con['HP_CP'];
						$fax_cp = $con['FAX_CP'];
						$email_cp = $con['EMAIL_CP'];
						$departement_cp = $con['DEPARTMENT'];
						$function_cp = $con['FUNC'];
						$gender_cp = $con['GENDER'];
						$tgl_lahir_cp = $con['TGL_LAHIR'];
						$call_freq_cp = $con['CALL_FREQ'];
						$date_register_cp = $con['DATE_REGISTER'];
						
						//tgl lahir
						$tgl_lahir_cp2=substr($tgl_lahir_cp,6,4).substr($tgl_lahir_cp,3,2).substr($tgl_lahir_cp,0,2);
						
						//tgl register
						$date_register_cp2=substr($date_register_cp,0,2).".".substr($date_register_cp,3,2).".".substr($date_register_cp,6,4);
						
						$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
						//Cek Connection SAP Status	
						$data['content']=$this->saprfc->callFunction("ZBAPI_CUSTOMER_CONTACTPERSON",
							array(	array("IMPORT","XKUNNR",$xkunnr),
								array("IMPORT","JENIS","ADD"),
								array("IMPORT","XFIRSTNAME",$firstname_cp),
								array("IMPORT","XLASTNAME", $name_cp),
								array("IMPORT","XTITLE", $title_cp),
								array("IMPORT","XTLP",$tlp_cp),
								array("IMPORT","XEXT", $ext_cp),
								array("IMPORT","XDEPARTEMEN", $departement_cp),
								array("IMPORT","XFUNCTION", $function_cp),
								array("IMPORT","XFAX", $fax_cp),
								array("IMPORT","XEMAIL",$email_cp),
								array("IMPORT","XGENDER",$gender_cp),
								array("IMPORT","XTGL_LAHIR",$tgl_lahir_cp2),
								array("IMPORT","XCALL_FREQ",$call_freq_cp),
								array("IMPORT","XDATE_REGISTER",$date_register_cp2),
								array("EXPORT","XPANNR",array())
							     )
							); 	
								
						//echo $this->saprfc->printStatus();
						//echo $this->saprfc->getStatus();
						//echo "<br/><br/>";
						$id_contact = $data['content']["XPANNR"];
						echo $id_contact;
						$this->saprfc->logoff();
						
						if($title_cp == "Mr."){
							$kode_title_cp = "0002";
						}elseif($title_cp == "Ms."){
							$kode_title_cp = "0001";
						}elseif($title_cp == "Company"){
							$kode_title_cp = "0003";
						}elseif($title_cp == "Mr. and Mrs."){
							$kode_title_cp = "0004";
						}else{
							$kode_title_cp = "";
						}
						
						//$this->load->library('saprfc');	
						//$this->load->library('sapauth');		
						
						$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
						//Cek Connection SAP Status	
						$data['content']=$this->saprfc->callFunction("ZBAPI_CUST_CONTACTPERSON_SAVE",
							array(	array("IMPORT","XKUNNR",$xkunnr),
								array("IMPORT","XPANR",$id_contact),
								array("IMPORT","XFIRSTNAME",$firstname_cp),
								array("IMPORT","XLASTNAME", $name_cp),
								array("IMPORT","XTITLE", $kode_title_cp),
								array("IMPORT","XTLP",$tlp_cp),
								array("IMPORT","XHP",$hp_cp),
								array("IMPORT","XEXT", $ext_cp),
								array("IMPORT","XDEPARTEMEN", $departement_cp),
								array("IMPORT","XFUNCTION", $function_cp),
								array("IMPORT","XFAX", $fax_cp),
								array("IMPORT","XEMAIL",$email_cp)
							     )
							); 	
								
						//echo $this->saprfc->printStatus();
						//echo $this->saprfc->getStatus();
						//echo "<br/><br/>";
						
						$this->saprfc->logoff();
					}	
				}
				
				
				
				//----------------Update Data Local---------------------
				$nik=$this->session->userdata('NIK');
				
				//update customer KNA1
				$field="ST_SEND = '3', DATE_IS = TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI'), NIK_IS = '".$nik."', CUST_ACCOUNT = '".$xkunnr."'";
				$kondisi="ID_CUST = '".$idCust."'";
				$exec=$this->oci_model->Exec($field, false, 'M_CUST_KNA1', $kondisi, 'update');
				
				
				//EMAIL END USER
				$fieldU="DEV_USERS.GET_NAME_BY_NIK('".$user."') as NAMA, DEV_USERS.GET_EMAIL_BY_NIK('".$user."') AS EMAIL";
				//$kondisiU="NIK='".$user."'";
				$listNIK=$this->oci_model->select($fieldU, 'DUAL', false);
				
				$jml=count($listNIK);
				if($jml > 0){
					foreach($listNIK as $a){
						//$nik=$a['NIK'];
						$email = $a['EMAIL'];
						$nama = $a['NAMA'];
						if($email <> ""){
							//$this->send_mail2($email, "REQUEST NEW CUSTOMER", "requestor", $nama, $xkunnr);
							$this->send_mail($email, "REQUEST NEW CUSTOMER", "masterdata", "new", $nama, $xkunnr);
						}
					}
				}
				
				//update daftar extend
				$fieldEx="*";
				$kondisiEx="ST_SEND <> '3' AND ID_CUST='".$idCust."' AND TIPE='WEB' AND ST='1'";
				$listEx=$this->oci_model->select($fieldEx, 'T_CUST_EXTEND', $kondisiEx);
				$jmlEx=count($listEx);
				if($jmlEx > 0){
					foreach($listEx as $b){
						$id_ex = $b['ID_EX'];
						
						$field="CUST_ACCOUNT='".$xkunnr."', TIPE = 'SAP', COMPANY1='".$company_code."', SALES_ORG1='".$sales_org."', DIS_CHANNEL1='".$dis_channel."', DIVISION1='".$division."'";
						$kondisi="ID_EX = '".$id_ex."'";
						$exec=$this->oci_model->Exec($field, false, 'T_CUST_EXTEND', $kondisi, 'update');
						
					}
				}
				
				$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Success!</h4>
					 Transport customer to SAP success. Nomor Customer Account : '.$xkunnr.' </div>');
				    redirect('customer/list_cust_is');
			}
		}
		
	}
	
	//function test_transport(){
	//	
	//	$personalData=array(
	//		'TITLE_P' => "Ms.",
	//		'FIRSTNAME' => "ssnewcust",
	//		'LASTNAME' => "last",
	//		'MIDDLENAME' => "midle",
	//		'SECONDNAME' => "seconname",
	//		'DATE_BIRTH' => "",
	//		'CITY' => "sby",
	//		'DISTRICT' => "",
	//		'POSTL_COD1' => "66666",
	//		'POSTL_COD2' => "77777",
	//		'PO_BOX' => "00000",
	//		'PO_BOX_CIT' => "00000",
	//		'STREET' => "jalan",
	//		'HOUSE_NO' => "30",
	//		'BUILDING' => "1",
	//		'FLOOR' => "3",
	//		'ROOM_NO' => "1",
	//		'COUNTRY' => "ID",
	//		'COUNTRYISO' => "",
	//		'REGION' => "01",
	//		'TEL1_NUMBR' => "0318002090",
	//		'TEL1_EXT' => "333",
	//		'FAX_NUMBER' => "0318001110",
	//		'FAX_EXTENS' => "",
	//		'E_MAIL' => "sn.hendra@gmail.com",
	//		'LANGU_P' => "EN",
	//		'LANGUP_ISO' => "",
	//		'CURRENCY' => "IDR",
	//		'CURRENCY_ISO' => "",
	//		'TITLE_KEY' => "",
	//		'ONLY_CHANGE_COMADDRESS' => ""
	//	);
	//	
	//	$optPersonalData=array(
	//		'TRANSPZONE' => "",
	//		'CONTROL_ACCOUNT' => "0000135002",
	//		'PMNTTRMS' => "Z060",
	//		'SHIP_COND' => "",
	//		'DELYG_PLNT' => "",
	//		'PART_DLV' => "",
	//		'PART_DLV' => "",
	//		'C_CTR_AREA'=>"",
	//		'TAXJURCODE'=>""
	//	);
	//	
	//	$copyreference=array(
	//		'SALESORG' => "1000",
	//		'DISTR_CHAN' => "10",
	//		'DIVISION' => "00",
	//		'REF_CUSTMR' => "0001100043"
	//	);
	//	$credit_control_flag="0";
	//	$cunsumer="1";
	//	// Load SAP Call-Function
	//	$this->load->library('saprfc');	
	//	$this->load->library('sapauth');		
	//	
	//	$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
	//	//Cek Connection SAP Status	
	//	$data['content']=$this->saprfc->callFunction("ZBAPI_CUSTOMER_CREATEFROMDATA1",
	//		array(	array("IMPORT","PI_PERSONALDATA",$personalData),
	//			array("IMPORT","PI_OPT_PERSONALDATA",$optPersonalData),
	//			array("IMPORT","PI_COPYREFERENCE",$copyreference),
	//			array("IMPORT","PI_CREDIT_CONTROL_FLAG",$credit_control_flag),
	//			array("EXPORT","CUSTOMERNO",array()),
	//			array("EXPORT","RETURN",array())
	//		     )
	//		); 	
	//			
	//	echo $this->saprfc->printStatus();
	//	echo $this->saprfc->getStatus();
	//	echo "<br/><br/>";
	//	echo print_r($data['content']["CUSTOMERNO"]);
	//	echo "<br/><br/>";
	//	$xkunnr = $data['content']["CUSTOMERNO"];
	//	//$kunnr = substr($xkunnr, 0, -1);
	//	echo $xkunnr;
	//	echo "<br/><br/>";
	//	echo print_r($data['content']["RETURN"]);
	//	echo "<br/><br/>";
	//	$this->saprfc->logoff();
	//	
	//	
	//	//update via BAPI ZBAPI_TEST_INSERT_CUST
	//	//$kna1=array(
	//	//	'KUNNR' => $xkunnr, //ID Customer
	//	//	'LAND1' => "ID", //Country
	//	//	'NAME1' => "HendraWebEditLangsung", 
	//	//	'NAME2' => "Langsung",
	//	//	'ORT01' => "Surabaya", //City
	//	//	'PSTLZ' => "60179", //Postal Code
	//	//	'REGIO' => "01", //Region
	//	//	'SORTL' => "hendraweb", //short
	//	//	'STRAS' => "JL. Selamat Jalan 33", //alamat jalan
	//	//	'TELF1' => "0318885555", //tlp1
	//	//	'TELFX' => "0315554444", //Fax
	//	//	'MCOD1' => "Hendra", //Search 1
	//	//	'MCOD2' => "test", //Search 2
	//	//	'ANRED' => "MR.", //Title
	//	//	'BRSCH' => "0001", //Industry Key
	//	//	'KTOKD' => "Z101", //Customer Account Group
	//	//	'KUKLA' => "01", //Customer classification
	//	//	'NIELS' => "03", //Nielsen ID
	//	//	'ORT02' => "ID", //Country
	//	//	'SPRAS' => "EN", //LAnguage
	//	//	'STCEG' => "11.11111.11" //Vatnum
	//	//);
	//	//
	//	//$knb1=array(
	//	//	'KUNNR' => $xkunnr, 
	//	//	'BUKRS' => "1000", //Company
	//	//	'AKONT' => "132001", //Recont account
	//	//	'ZTERM' => "Z014", //TOP
	//	//	'QLAND' => "ID" //Withholding Tax Country Key
	//	//	
	//	//);
	//	//
	//	//$knvv=array(
	//	//	'KUNNR' => $xkunnr, //Id Customer
	//	//	'VKORG' => "1000", //Sales Org.
	//	//	'VTWEG' => "10", //Distribution Channel
	//	//	'SPART' => "00", //Division
	//	//	'KDGRP' => "Z001", //Customer Group
	//	//	'INCO1' => "COD", //Incoterm 1
	//	//	'INCO2' => "test", //Incoterm 2
	//	//	'WAERS' => "IDR", //Mata Uang
	//	//	'ZTERM' => "Z014", //top
	//	//	'VKBUR' => "2001" //Sales office
	//	//);
	//	//$addr1=array(
	//	//	'ADDR_NO' => "",
	//	//	'FORMOFADDR' => "MR.",
	//	//	'NAME' => "hendraaddr1",
	//	//	'NAME_2' => "hendraaddr2",
	//	//	'CITY' => "SurabayaAdr",
	//	//	'POSTL_COD1' => "60179",
	//	//	'STREET' => "JL ADDR1",
	//	//	'COUNTRY' => "ID",
	//	//	'LANGU' => "EN",
	//	//	'REGION' => "01",
	//	//	'SORT1' => "adrtes",
	//	//	'SORT2' => "adrtes",
	//	//	'ADR_NOTES' => "VUM-199980",
	//	//	'TEL1_NUMBR' => "031999999",
	//	//	'TEL1_EXT' => "123",
	//	//	'FAX_NUMBER' => "031999999",
	//	//	'E_MAIL' => "hendra.adr1@gmail.com"
	//	//);
	//	////$addr2=array(
	//	////	'PERS_NO' => "",
	//	////	'ADDR_NO' => "",
	//	////	'TITLE_P' => "MR.",
	//	////	'FIRSTNAME' => "hendraaddr2",
	//	////	'LASTNAME' => "hendraaddr2",
	//	////	'LANGU_P' => "EN",
	//	////	'SORT1_P' => "addr2",
	//	////	'SORT2_P' => "addr2",
	//	////	'CITY' => "Surabaya",
	//	////	'STREET' => "JL Adrr2",
	//	////	'COUNTRY' => "ID",
	//	////	'REGION' => "01",
	//	////	'ADR_NOTES' => "VUM-222222",
	//	////	'TEL1_NUMBR' => "031222222",
	//	////	'TEL1_EXT' => "222",
	//	////	'FAX_NUMBER' => "031222222",
	//	////	'E_MAIL' => "hendra.adr2@gmail.com"
	//	////	
	//	////);
	//	//$this->load->library('saprfc');	
	//	//$this->load->library('sapauth');		
	//	//
	//	//$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
	//	////Cek Connection SAP Status	
	//	//$data['content']=$this->saprfc->callFunction("ZBAPI_TEST_INSERT_CUST",
	//	//	array(	array("IMPORT","X_KNA1",$kna1),
	//	//		array("IMPORT","X_KNB1",$knb1),
	//	//		array("IMPORT","X_KNVV",$knvv),
	//	//		array("IMPORT","X_BAPIADDR1",$addr1),
	//	//		//array("IMPORT","X_BAPIADDR2",$addr2),
	//	//		array("EXPORT","XKUNNR",array()),
	//	//		array("EXPORT","O_KNA1",array())
	//	//	     )
	//	//	); 	
	//	//		
	//	//echo $this->saprfc->printStatus();
	//	//echo $this->saprfc->getStatus();
	//	//echo "<br/><br/>";
	//	//echo "<pre>";
	//	//print_r($data['content']["O_KNA1"]);
	//	//echo "</pre>";
	//	
	//}
	
	function edit_cust(){
		//update via BAPI ZBAPI_TEST_INSERT_CUST
		$kna1=array(
			'KUNNR' => "0001105437", //ID Customer
			'LAND1' => "ID", //Country
			'NAME1' => "HendraWebEdit", 
			'NAME2' => "HendraWebEdit",
			'ORT01' => "Surabaya", //City
			'PSTLZ' => "60179", //Postal Code
			'REGIO' => "01", //Region
			'SORTL' => "hendraweb", //short
			'STRAS' => "JL. Selamat Jalan 33", //alamat jalan
			'TELF1' => "0318885555", //tlp1
			'TELFX' => "0315554444", //Fax
			'MCOD1' => "Hendra", //Search 1
			'MCOD2' => "test", //Search 2
			'ANRED' => "MR.", //Title
			'BRSCH' => "0001", //Industry Key
			'KTOKD' => "Z101", //Customer Account Group
			'KUKLA' => "01", //Customer classification
			'NIELS' => "03", //Nielsen ID
			'ORT02' => "ID", //Country
			'SPRAS' => "EN", //LAnguage
			'STCEG' => "11.11111.11" ,//Vatnum
			'TELF2' => "0815554444"
		);
		
		$knb1=array(
			'KUNNR' => "0001105437", 
			'BUKRS' => "1000", //Company
			'AKONT' => "132001", //Recont account
			'ZTERM' => "Z014" //TOP
		);
		
		$knvv=array(
			'KUNNR' => "0001105437", //Id Customer
			'VKORG' => "1000", //Sales Org.
			'VTWEG' => "10", //Distribution Channel
			'SPART' => "00", //Division
			'KDGRP' => "Z001", //Customer Group
			'INCO1' => "COD", //Incoterm 1
			'INCO1' => "test", //Incoterm 2
			'WAERS' => "IDR", //Mata Uang
			'ZTERM' => "Z014", //top
			'VKBUR' => "2001" //Sales office
		);
		
		$addr1=array(
			'ADDR_NO' => "",
			'FORMOFADDR' => "",
			'NAME' => "hendraaddr1",
			'NAME_2' => "hendraaddr2",
			'CITY' => "SurabayaAdr",
			'POSTL_COD1' => "60179",
			'STREET' => "JL ADDR1",
			'COUNTRY' => "ID",
			'LANGU' => "EN",
			'REGION' => "01",
			'SORT1' => "adrtes",
			'SORT2' => "adrtes",
			'ADR_NOTES' => "VUM-199980",
			'TEL1_NUMBR' => "031555555",
			'TEL1_EXT' => "123",
			'FAX_NUMBER' => "031999999",
			'E_MAIL' => "hendra.adr1@gmail.com"
		);
		echo "<pre>";
		print_r($kna1);
		echo "</pre>";
		echo "<pre>";
		print_r($knb1);
		echo "</pre>";
		echo "<pre>";
		print_r($knvv);
		echo "</pre>";
		$this->load->library('saprfc');	
		$this->load->library('sapauth');		
		
		$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
		//Cek Connection SAP Status	
		$data['content']=$this->saprfc->callFunction("ZBAPI_TEST_INSERT_CUST",
			array(	array("IMPORT","X_KNA1",$kna1),
				array("IMPORT","X_KNB1",$knb1),
				array("IMPORT","X_KNVV",$knvv),
				array("IMPORT","X_BAPIADDR1",$addr1),
				array("EXPORT","XKUNNR",array()),
				array("EXPORT","O_KNA1",array())
			     )
			); 	
				
		echo $this->saprfc->printStatus();
		echo $this->saprfc->getStatus();
		echo "<br/><br/>";
		echo "<pre>";
		print_r($data['content']["O_KNA1"]);
		echo "</pre>";
	}
	
	//function test_sd(){
	//	$kna1=array(
	//		'NAME1' => "Hendrates1",
	//		'NAME2' => "Hendrates2",
	//		'ORT01' => "Surabaya",
	//		'PSTLZ' => "60179",
	//		'REGIO' => "01",
	//		'SORTL' => "Hendrasotl",
	//		'TELF1' => "0318547373",
	//		'TELFX' => "03189882",
	//		'MCOD1' => "search1",
	//		'MCOD2' => "search2",
	//		'ANRED' => "MR.",
	//		'BRSCH' => "0002",
	//		'KTOKD' => "Z106",
	//		'KUKLA' => "01",
	//		'NIELS' => "03",
	//		'STCEG' => "13000878899"
	//	);
	//	$knb1=array(
	//		'BUKRS' => "2000",
	//		'AKONT' => "0000132001",
	//		'ZTERM' => "Z014"
	//	);
	//	$knvv=array(
	//		'VKORG' => "2000",
	//		'VTWEG' => "10",
	//		'SPART' => "2A",
	//		'KDGRP' => "01",
	//		'INCO1' => "CIP",
	//		'WAERS' => "IDR",
	//		'ZTERM' => "Z014",
	//		'VKBUR' => "2002"
	//	);
	//	
	//	$this->load->library('saprfc');	
	//	$this->load->library('sapauth');		
	//	
	//	$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
	//	//Cek Connection SAP Status	
	//	$data['content']=$this->saprfc->callFunction("SD_CUSTOMER_MAINTAIN_ALL",
	//		array(	array("IMPORT","I_KNA1",$kna1),
	//			array("IMPORT","I_KNB1",$knb1),
	//			array("IMPORT","I_KNVV",$knvv),
	//			array("EXPORT","E_KUNNR",array()),
	//			array("EXPORT","O_KNA1",array())
	//		     )
	//		); 	
	//			
	//	
	//	echo $this->saprfc->printStatus();
	//	
	//	echo $this->saprfc->getStatus();
	//	echo "<br/><br/>";
	//	echo print_r($data['content']["E_KUNNR"]);
	//	echo "<br/><br/>";
	//	//echo print_r($data['content']["RETURN"]);
	//	echo "<br/><br/>";
	//	$this->saprfc->logoff();
	//}
	
	
	function get_sales_org(){
		$this->load->model('sap_model');
		$this->load->model('oci_model');
		$company=$this->input->post('id');
		
		//get data konfigurasi
		$field="DISTINCT(SALES_ORG)";
		$kondisi="COMPANY_CODE = '$company'";
		$dataKonf=$this->oci_model->select($field, "M_CUST_KONF", $kondisi);
		
		$dataSalesOrg=$this->sap_model->getSalesOrganization();
		echo '<select name="sales_org" id="sales_org" class="span6" placeholder="Sales Organization" onchange="load_distribution_channel();">
			';
		foreach($dataKonf as $a){
			$zzz = $a['SALES_ORG'];
			//echo $zzz;
			foreach($dataSalesOrg as $key => $sls){
				if($key == 0 and !isset($sls['VKORG']) ){
					continue;}
				if($sls['VKORG'] == $zzz){
					echo "<option value='".$sls['VKORG']."'>".$sls['VKORG']." - ".$sls['VTEXT']."</option>";
				}
				
			}
		}
		echo '</select>';
		
	}
	
	function get_distribution_channel(){
		$this->load->model('sap_model');
		$this->load->model('oci_model');
		$company=$this->input->post('company');
		$sales_org=$this->input->post('sales_org');
		
		//get data konfigurasi
		$field="DISTINCT(DIS_CHANNEL)";
		$kondisi="COMPANY_CODE = '".$company."' AND SALES_ORG = '".$sales_org."'";
		$dataKonf=$this->oci_model->select($field, "M_CUST_KONF", $kondisi);
		
		$dataDisChannel=$this->sap_model->getDistributionChannel();
		
		echo ' <select name="dis_channel" id="dis_channel" class="span6" onchange="load_division();" placeholder="Distribution Channel">
				      ';
		foreach($dataKonf as $a){
			$zzz = $a['DIS_CHANNEL'];
			//echo $zzz;
			foreach($dataDisChannel as $key2 => $dis){
				if($key2 == 0 and !isset($dis['VTWEG'])){
				    continue;}
				if($dis['VTWEG'] == $zzz){
					echo "<option value='".$dis['VTWEG']."'>".$dis['VTWEG']." - ".$dis['VTEXT']."</option>";
				}
				
			}
		}
		echo '</select>';
	}
	
	function get_division(){
		$this->load->model('sap_model');
		$this->load->model('oci_model');
		$company=$this->input->post('company');
		$sales_org=$this->input->post('sales_org');
		$dis_channel=$this->input->post('dis_channel');
		
		//get data konfigurasi
		$field="DISTINCT(DIVISION)";
		$kondisi="COMPANY_CODE = '".$company."' AND SALES_ORG = '".$sales_org."' AND DIS_CHANNEL = '".$dis_channel."'";
		$dataKonf=$this->oci_model->select($field, "M_CUST_KONF", $kondisi);
		
		$dataDivision=$this->sap_model->getDivision();
		
		echo ' <select name="division" id="division" class="span6" placeholder="Division" >
				      ';
		foreach($dataKonf as $a){
			$zzz = $a['DIVISION'];
			//echo $zzz;
			foreach($dataDivision as $key3 => $div){
				if($key3 == 0 and !isset($div['SPART'])){
				    continue;}
				if($div['SPART'] == $zzz){
					echo "<option value='".$div['SPART']."'>".$div['SPART']." - ".$div['VTEXT']."</option>";
				}
				
			}
		}
		echo '</select>';
	}
	
	
	function get_sales_org2(){
		$this->load->model('sap_model');
		$this->load->model('oci_model');
		$company=$this->input->post('id');
		
		//get data konfigurasi
		$field="DISTINCT(SALES_ORG)";
		$kondisi="COMPANY_CODE = '$company'";
		$dataKonf=$this->oci_model->select($field, "M_CUST_KONF", $kondisi);
		
		$dataSalesOrg=$this->sap_model->getSalesOrganization();
		echo '<select name="sales_org2" id="sales_org2" class="span6" placeholder="Sales Organization" onchange="load_distribution_channel2();">
			';
		foreach($dataKonf as $a){
			$zzz = $a['SALES_ORG'];
			//echo $zzz;
			foreach($dataSalesOrg as $key => $sls){
				if($key == 0 and !isset($sls['VKORG']) ){
					continue;}
				if($sls['VKORG'] == $zzz){
					echo "<option value='".$sls['VKORG']."'>".$sls['VKORG']." - ".$sls['VTEXT']."</option>";
				}
				
			}
		}
		echo '</select>';
		
	}
	
	function get_distribution_channel2(){
		$this->load->model('sap_model');
		$this->load->model('oci_model');
		$company=$this->input->post('company');
		$sales_org=$this->input->post('sales_org');
		
		//get data konfigurasi
		$field="DISTINCT(DIS_CHANNEL)";
		$kondisi="COMPANY_CODE = '".$company."' AND SALES_ORG = '".$sales_org."'";
		$dataKonf=$this->oci_model->select($field, "M_CUST_KONF", $kondisi);
		
		$dataDisChannel=$this->sap_model->getDistributionChannel();
		
		echo ' <select name="dis_channel2" id="dis_channel2" class="span6" onchange="load_division2();" placeholder="Distribution Channel">
				      ';
		foreach($dataKonf as $a){
			$zzz = $a['DIS_CHANNEL'];
			//echo $zzz;
			foreach($dataDisChannel as $key2 => $dis){
				if($key2 == 0 and !isset($dis['VTWEG'])){
				    continue;}
				if($dis['VTWEG'] == $zzz){
					echo "<option value='".$dis['VTWEG']."'>".$dis['VTWEG']." - ".$dis['VTEXT']."</option>";
				}
				
			}
		}
		echo '</select>';
	}
	
	function get_division2(){
		$this->load->model('sap_model');
		$this->load->model('oci_model');
		$company=$this->input->post('company');
		$sales_org=$this->input->post('sales_org');
		$dis_channel=$this->input->post('dis_channel');
		
		//get data konfigurasi
		$field="DISTINCT(DIVISION)";
		$kondisi="COMPANY_CODE = '".$company."' AND SALES_ORG = '".$sales_org."' AND DIS_CHANNEL = '".$dis_channel."'";
		$dataKonf=$this->oci_model->select($field, "M_CUST_KONF", $kondisi);
		
		$dataDivision=$this->sap_model->getDivision();
		
		echo ' <select name="division2" id="division2" class="span6" placeholder="Division" >
				      ';
		foreach($dataKonf as $a){
			$zzz = $a['DIVISION'];
			//echo $zzz;
			foreach($dataDivision as $key3 => $div){
				if($key3 == 0 and !isset($div['SPART'])){
				    continue;}
				if($div['SPART'] == $zzz){
					echo "<option value='".$div['SPART']."'>".$div['SPART']." - ".$div['VTEXT']."</option>";
				}
				
			}
		}
		echo '</select>';
	}
	
	
	function find_customer(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$this->load->model('sap_model');
		
		$data['company']=$this->sap_model->getCompanyCode();
		$data['dis_channel']=$this->sap_model->getDistributionChannel();
		$data['division']=$this->sap_model->getDivision();
		$data['sales_org']=$this->sap_model->getSalesOrganization();
	    
		$data['main_content']="customer/find_customer";
		$this->load->view('template/main',$data);	
	}
	
	function find_cust_proses(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$this->load->model('sap_model');
		
		$cust_account=$this->input->post('cust_account');
		
		
		$name=$this->input->post('name_find');
		$sales_org=$this->input->post('sales_org');
		$dis_channel=$this->input->post('dis_channel');
		$division=$this->input->post('division');
		$city=$this->input->post('city');
		$postal_code=$this->input->post('postal_code');
		
		//get sesuai KUNNR
		$this->load->library('saprfc');	
		$this->load->library('sapauth');
		$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
		//Cek Connection SAP Status	
		$data['content']=$this->saprfc->callFunction("ZBAPI_FIND_CUST",
				array(
				    array("IMPORT","XKUNNR",$cust_account),
				    array("TABLE","XKNA1",array()),
				    array("TABLE","XKNB1",array()),
				    array("TABLE","XKNVV",array())
				)); 				
		$this->saprfc->logoff();
		
		
		foreach($data['content']["XKNA1"] as $rowA){
			
			$dataA[]=$rowA;
		}
		foreach($data['content']["XKNB1"] as $rowB){
		    $dataB[]=$rowB;
		}
		foreach($data['content']["XKNVV"] as $rowC){
		    $dataC[]=$rowC;
		}
		
		if(count($data['content']["XKNA1"]) == 0){
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Data not found !</div>');
			redirect('customer/find_customer');
		}
		$data['kna1']=$dataA;
		$data['knb1']=$dataB;
		$data['knvv']=$dataC;
		
		$data['main_content']="customer/find_customer_result";
		$this->load->view('template/main',$data);
	}
	
	function find_cust_proses2(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$this->load->model('sap_model');
		
		$name=$this->input->post('name_find');
		$sales_org=$this->input->post('sales_org');
		$dis_channel=$this->input->post('dis_channel');
		$division=$this->input->post('division');
		$city=$this->input->post('city');
		$postal_code=$this->input->post('postal_code');
		
		$this->load->library('saprfc');	
		$this->load->library('sapauth');
		$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
		if($sales_org == "ALL" && $dis_channel == "ALL" && $division == "ALL"){
			
			$data['content']=$this->saprfc->callFunction("ZBAPI_FIND_CUST",
				array(
				    array("IMPORT","XNAME",$name),
				    array("TABLE","XKNA1",array()),
				    array("TABLE","XKNB1",array()),
				    array("TABLE","XKNVV",array())
				)); 				
			$this->saprfc->logoff();
		}elseif($sales_org <> "ALL" && $division <> "ALL" && $dis_channel <> "ALL"){
			$data['content']=$this->saprfc->callFunction("ZBAPI_FIND_CUST",
				array(
				    array("IMPORT","XNAME",$name),
				    array("IMPORT","XSALESORG",$sales_org),
				    array("IMPORT","XDIS_CHANNEL",$dis_channel),
				    array("IMPORT","XDIVISION",$division),
				    array("TABLE","XKNA1",array()),
				    array("TABLE","XKNB1",array()),
				    array("TABLE","XKNVV",array())
				)); 				
			$this->saprfc->logoff();
		}elseif($sales_org <> "ALL" && $division <> "ALL" && $dis_channel == "ALL"){
			$data['content']=$this->saprfc->callFunction("ZBAPI_FIND_CUST",
				array(
				    array("IMPORT","XNAME",$name),
				    array("IMPORT","XSALESORG",$sales_org),
				    array("IMPORT","XDIVISION",$division),
				    array("TABLE","XKNA1",array()),
				    array("TABLE","XKNB1",array()),
				    array("TABLE","XKNVV",array())
				)); 				
			$this->saprfc->logoff();
		}elseif($sales_org <> "ALL" && $division == "ALL" && $dis_channel == "ALL"){
			$data['content']=$this->saprfc->callFunction("ZBAPI_FIND_CUST",
				array(
				    array("IMPORT","XNAME",$name),
				    array("IMPORT","XSALESORG",$sales_org),
				    array("TABLE","XKNA1",array()),
				    array("TABLE","XKNB1",array()),
				    array("TABLE","XKNVV",array())
				)); 				
			$this->saprfc->logoff();
		}elseif($sales_org <> "ALL" && $division == "ALL" && $dis_channel <> "ALL"){
			$data['content']=$this->saprfc->callFunction("ZBAPI_FIND_CUST",
				array(
				    array("IMPORT","XNAME",$name),
				    array("IMPORT","XSALESORG",$sales_org),
				    array("IMPORT","XDIS_CHANNEL",$dis_channel),
				    array("TABLE","XKNA1",array()),
				    array("TABLE","XKNB1",array()),
				    array("TABLE","XKNVV",array())
				)); 				
			$this->saprfc->logoff();
		}elseif($sales_org == "ALL" && $division == "ALL" && $dis_channel <> "ALL"){
			$data['content']=$this->saprfc->callFunction("ZBAPI_FIND_CUST",
				array(
				    array("IMPORT","XNAME",$name),
				    array("IMPORT","XDIS_CHANNEL",$dis_channel),
				    array("TABLE","XKNA1",array()),
				    array("TABLE","XKNB1",array()),
				    array("TABLE","XKNVV",array())
				)); 				
			$this->saprfc->logoff();
		}elseif($sales_org == "ALL" && $division <> "ALL" && $dis_channel <> "ALL"){
			$data['content']=$this->saprfc->callFunction("ZBAPI_FIND_CUST",
				array(
				    array("IMPORT","XNAME",$name),
				    array("IMPORT","XDIS_CHANNEL",$dis_channel),
				    array("IMPORT","XDIVISION",$division),
				    array("TABLE","XKNA1",array()),
				    array("TABLE","XKNB1",array()),
				    array("TABLE","XKNVV",array())
				)); 				
			$this->saprfc->logoff();
		}elseif($sales_org == "ALL" && $division <> "ALL" && $dis_channel == "ALL"){
			$data['content']=$this->saprfc->callFunction("ZBAPI_FIND_CUST",
				array(
				    array("IMPORT","XNAME",$name),
				    array("IMPORT","XDIVISION",$division),
				    array("TABLE","XKNA1",array()),
				    array("TABLE","XKNB1",array()),
				    array("TABLE","XKNVV",array())
				)); 				
			$this->saprfc->logoff();
		}
		
		foreach($data['content']["XKNA1"] as $rowA){
			
			$dataA[]=$rowA;
		}
		foreach($data['content']["XKNB1"] as $rowB){
			$dataB[]=$rowB;
		}
		foreach($data['content']["XKNVV"] as $rowC){
			$dataC[]=$rowC;
		}
		
		if(count($data['content']["XKNA1"]) == 0){
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Data not found !</div>');
			redirect('customer/find_customer');
		}
		//echo "aaa".count($data['content']["XKNVV"]);
		$data['kna1']=$dataA;
		$data['knb1']=$dataB;
		$data['knvv']=$dataC;
		
		$data['main_content']="customer/find_customer_result";
		$this->load->view('template/main',$data);
	}
	function view_cust_search(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$this->load->model('sap_model');
		
		$kunnr=$this->uri->segment(3);
		$sales_org=$this->uri->segment(4);
		$dis_channel=$this->uri->segment(5);
		$division=$this->uri->segment(6);
		
		$this->load->library('saprfc');	
		$this->load->library('sapauth');		
		
		$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
		//Cek Connection SAP Status	
		$data['content']=$this->saprfc->callFunction("ZBAPI_CUSTOMER_DETAIL",
			array(	array("IMPORT","XKUNNR",$kunnr),
				array("IMPORT","XSALESORG",$sales_org),
				array("IMPORT","XDIS_CHANNEL",$dis_channel),
				array("IMPORT","XDIVISION",$division),
				array("EXPORT","XMEMBER", array()),
				array("TABLE","XKNA1",array()),
				array("TABLE","XKNB1",array()),
				array("TABLE","XKNVV",array())
			     )
			); 	
		//echo $this->saprfc->printStatus();
		//echo $this->saprfc->getStatus();
		$member = $data['content']["XMEMBER"];
		
		foreach($data['content']["XKNA1"] as $a){
			$kunnr = $a['KUNNR'];
			$LAND1 = $a['LAND1'];
			$NAME1 = $a['NAME1'];
			$NAME2 = $a['NAME2'];
			$ORT01 = $a['ORT01'];
			$PSTLZ = $a['PSTLZ'];
			$REGIO = $a['REGIO'];
			$SORTL = $a['SORTL'];
			$STRAS = $a['STRAS'];
			$TELF1 = $a['TELF1'];
			$TELFX = $a['TELFX'];
			$MCOD1 = $a['MCOD1'];
			$MCOD2 = $a['MCOD2'];
			$ANRED = $a['ANRED'];
			$BRSCH = $a['BRSCH'];
			$KTOKD = $a['KTOKD'];
			$KUKLA = $a['KUKLA'];
			$NIELS = $a['NIELS'];
			$STCEG = $a['STCEG'];
			$TELF2 = $a['TELF2'];
		}
		foreach($data['content']["XKNB1"] as $b){
			$company_code=$b['BUKRS'];
			$top=$b['ZTERM'];
			$recon=$b['AKONT'];
		}
		
		foreach($data['content']["XKNVV"] as $c){
			$KUNNR = $c['KUNNR'];
			$VKORG = $c['VKORG'];
			$VTWEG = $c['VTWEG'];
			$SPART = $c['SPART'];
			$KDGRP = $c['KDGRP'];
			$INCO1 = $c['INCO1'];
			$INCO2 = $c['INCO2'];
			$WAERS = $c['WAERS'];
			$ZTERM = $c['ZTERM'];
			$VKBUR = $c['VKBUR'];
		}
		
		$this->load->model('sap_model');
		$data_company=$this->sap_model->getCompanyCode();
		$data_industry=$this->sap_model->getIndustry();
		$data_customer_class=$this->sap_model->getCustomerClass();
		$data_top=$this->sap_model->getTOP();
		$data_customer_group=$this->sap_model->getCustomerGroup();
		$data_incoterm=$this->sap_model->getIncoterm();
		$data_nielsen=$this->sap_model->getNielsen();
		$data_dis_channel=$this->sap_model->getDistributionChannel();
		$data_division=$this->sap_model->getDivision();
		$data_sales_org=$this->sap_model->getSalesOrganization();
		$data_region=$this->sap_model->getRegion($LAND1);
		$data_sales_office=$this->sap_model->getSalesOffice();
		$data_account_group=$this->sap_model->getAccountGroup();
		$data_recon_account=$this->sap_model->getReconAccount();
		
		$data['txt_company']="";
		$data['txt_dischannel']="";
		$data['txt_division']="";
		$data['txt_region']="";
		$data['txt_region']="";
		$data['txt_nielsen']="";
		$data['txt_industry']="";
		$data['txt_custclass']="";
		$data['txt_top']="";
		$data['txt_salesoffice']="";
		$data['txt_inco1']="";
		$data['txt_account_group']="";
		$data['txt_recon']="";
		$data['txt_cust_group']="";
		$data['txt_sales_org']="";
		
		foreach($data_company as $key1 => $com){
			if($key1 == 0 and $com['BUKRS'] == ''){
			continue;}
			if($com['BUKRS'] == $company_code && $com['LAND1'] == 'ID'){
				$data['txt_company']=$com['BUTXT'];
			}
		}
		foreach($data_dis_channel as $key2 => $dis){
			
			if($key2 == 0 and !isset($dis['VTWEG'])){
			continue;}
			if($dis['VTWEG'] == $VTWEG){
				$data['txt_dischannel']=$dis['VTEXT'];
			}
		}
		foreach($data_division as $key3 => $div){
			
			if($key3 == 0 and !isset($div['SPART'])){
			continue;}
			if($div['SPART'] == $SPART){
				$data['txt_division']=$div['VTEXT'];
			}
		}
		foreach($data_region as $key4 => $reg){
			
			if($key4 == 0 and !isset($reg['BLAND'])){
			continue;}
			if($reg['BLAND'] == $REGIO){
				$data['txt_region']=$reg['BEZEI'];
			}
		}
		
		foreach($data_nielsen as $key5 => $nil){
			if($key5 == 0 and !isset($nil['NIELS'])){
			continue;}
			if($nil['NIELS'] == $NIELS){
				$data['txt_nielsen']=$nil['BEZEI'];
			}
		}
		
		foreach($data_industry as $key6 => $ind){
			if($key6 == 0 and !isset($ind['BRSCH'])){
			continue;}
			if($ind['BRSCH'] == $BRSCH){
				$data['txt_industry']=$ind['BRTXT'];
			}
		}
		foreach($data_customer_class as $key7 => $cs){
			if($key7 == 0 and !isset($cs['KUKLA'])){
			continue;}
			if($cs['KUKLA'] == $KUKLA){
				$data['txt_custclass']=$cs['VTEXT'];
			}
		}
		
		foreach($data_top as $key8 => $tp){
			if($key8 == 0 and !isset($tp['ZTERM'])){
			continue;}
			if($tp['ZTERM'] == $top){
				$data['txt_top']=$tp['VTEXT'];
			}
		}
		
		foreach($data_sales_office as $key9 => $sof){
			if($key9 == 0 and !isset($sof['VKBUR'])){
			continue;}
			if($sof['VKBUR'] == $VKBUR){
				$data['txt_salesoffice']=$sof['BEZEI'];
			}
		}
		foreach($data_incoterm as $key10 => $inc){
			if($key10 == 0 and !isset($inc['INCO1'])){
			continue;}
			if($inc['INCO1'] == $INCO1){
				$data['txt_inco1']=$inc['BEZEI'];
			}
		}
		foreach($data_account_group as $key11 => $accg){
			if($key11 == 0 and !isset($accg['KTOKD'])){
			continue;}
			if($accg['KTOKD'] == $KTOKD){
				$data['txt_account_group']=$accg['TXT30'];
			}
		}
		foreach($data_recon_account as $key12 => $reca){
			if($key12 == 0 and !isset($reca['SAKNR'])){
			continue;}
			if($reca['SAKNR'] == $recon){
				$data['txt_recon']=$reca['TXT50'];
			}
		}
		
		foreach($data_customer_group as $key13 => $cgp){
			if($key13 == 0 and !isset($cgp['KDGRP'])){
			continue;}
			if($cgp['KDGRP'] == $KDGRP){
				$data['txt_cust_group']=$cgp['KTEXT'];
			}
		}
		
		foreach($data_sales_org as $key14 => $sor){
			if($key14 == 0 and !isset($sor['VKORG'])){
			continue;}
			if($sor['VKORG'] == $VKORG){
				$data['txt_sales_org']=$sor['VTEXT'];
			}
		}
		$hp=$this->get_no_hp($kunnr);
		
		$data['company_code']=$company_code;
		$data['account_group']=$KTOKD;
		$data['recon_account']=$recon;
		$data['dis_channel']=$VTWEG;
		$data['division']=$SPART;
		
		$data['title']=$ANRED;
		$data['name1']=$NAME1;
		$data['name2']=$NAME2;
		$data['nickname']=$SORTL;
		$data['search1']=$MCOD1;
		$data['search2']=$MCOD2;
		$data['address']=$STRAS;
		$data['address2']="";
		$data['address3']="";
		$data['country']=$LAND1;
		$data['region']=$REGIO;
		$data['city']=$ORT01;
		$data['postal_code']=$PSTLZ;
		$data['tlp']=$TELF1;
		$data['fax']=$TELFX;
		$data['hp']=$hp;
		$data['email']="";
		$data['allowpos']="";
		$data['nielsen']=$NIELS;
	
		$data['member_card']=$member;
		$data['industry']=$BRSCH;
		$data['customer_class']=$KUKLA;
		$data['vat']=$STCEG;
		$data['top']=$top;
		$data['sales_office']=$VKBUR;
		$data['cust_group']=$KDGRP;
		$data['curr']=$WAERS;
		$data['inco1']=$INCO1;
		$data['inco2']=$INCO2;
		$data['sales_org']=$VKORG;
		
		$data['main_content']="customer/view_cust_sap";
		$this->load->view('template/main',$data);	
		
	}
	
	function form_extend_cust(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->my_auth->hak_akses("REQUESTER");
		$this->load->model('sap_model');
		$this->load->model('oci_model');
		$seskode=$this->session->userdata('seskode');
		
		$data['company']=$this->sap_model->getCompanyCode();
		$data['country']=$this->sap_model->getCountry();
		$data['industry']=$this->sap_model->getIndustry();
		$data['customer_class']=$this->sap_model->getCustomerClass();
		$data['top']=$this->sap_model->getTOP();
		$data['sales_office']=$this->sap_model->getSalesOffice();
		$data['customer_group']=$this->sap_model->getCustomerGroup();
		$data['currency']=$this->sap_model->getCurrency();
		$data['incoterm']=$this->sap_model->getIncoterm();
		$data['departemen']=$this->sap_model->getDepartemen();
		$data['function']=$this->sap_model->getFunction();
		$data['nielsen']=$this->sap_model->getNielsen();
		$data['dis_channel']=$this->sap_model->getDistributionChannel();
		$data['division']=$this->sap_model->getDivision();
		$data['sales_org']=$this->sap_model->getSalesOrganization();
		$data['account_group']=$this->sap_model->getAccountGroup();
		$data['main_content']="customer/form_extend_cust";
		$this->load->view('template/main',$data);
	}
	
	function add_extend_customer(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('sap_model');
		$this->load->model('oci_model');
		
		$tipe=$this->input->post('tipe');
		$id_req_cust=$this->input->post('id_req_cust');
		
		$subject=$this->input->post('subject');
		if($tipe == "WEB"){
			$kunnr = "";
			$company1="";
			$sales_org1="";
			$dis_channel1="";
			$division1="";
		}else{
			$kunnr = $this->input->post('cust_account');
			$company1=$this->input->post('company2');
			$sales_org1=$this->input->post('sales_org2');
			$dis_channel1=$this->input->post('dis_channel2');
			$division1=$this->input->post('division2');
		}
		
		
		$company2=$this->input->post('company');
		$sales_org2=$this->input->post('sales_org');
		$dis_channel2=$this->input->post('dis_channel');
		$division2=$this->input->post('division');
		
		if($tipe == "WEB"){
			$jmlCust=$this->oci_model->getJmlStatusCustReq($id_req_cust);
			if($jmlCust == 0){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					ID Request New Customer Not Found !</div>');
				redirect('customer/form_extend_cust');
			}
			
			$cekKUNNR=$this->oci_model->cekKUNNR($id_req_cust);
			if($cekKUNNR == "3"){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Request New Customer already have Cust. Account (SAP ID), Please use Cust. Account for reference !</div>');
				redirect('customer/form_extend_cust');
			}
			
		}else{
			
			//------------------cek----------------------
			//get sesuai KUNNR
			$this->load->library('saprfc');	
			$this->load->library('sapauth');
			$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
			//Cek Connection SAP Status	
			$data['content']=$this->saprfc->callFunction("ZBAPI_FIND_CUST",
					array(
					    array("IMPORT","XKUNNR",$kunnr),
					    array("TABLE","XKNA1",array()),
					    array("TABLE","XKNB1",array()),
					    array("TABLE","XKNVV",array())
					)); 				
			$this->saprfc->logoff();
			
			
			foreach($data['content']["XKNA1"] as $rowA){
				
				$dataA[]=$rowA;
			}
			foreach($data['content']["XKNB1"] as $rowB){
			    $dataB[]=$rowB;
			}
			foreach($data['content']["XKNVV"] as $rowC){
			    $dataC[]=$rowC;
			}
			
			if(count($data['content']["XKNA1"]) == 0){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Data not found !</div>');
				redirect('customer/form_extend_cust');
			}
			if(count($data['content']["XKNVV"]) == 0){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Reference Data not found !</div>');
				redirect('customer/form_extend_cust');
			}else{
				$status="0";
				
				foreach($data['content']["XKNVV"] as $a){
					if($a['VKORG'] == $sales_org1 && $a['VTWEG'] == $dis_channel1 && $a['SPART'] == $division1){
						$status = $status + 1;
					}
				}
				if($status < 1){
					$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
						<h4 class="alert-heading">Error!</h4>
						Reference Data not found !</div>');
					redirect('customer/form_extend_cust');
					//print_r($data['content']["XKNVV"]);
				}
			}
			
		}
		
		
		
		
		$top=$this->input->post('top');
		$sales_office=$this->input->post('sales_office');
		$customer_group=$this->input->post('customer_group');
		$currency=$this->input->post('currency');
		$inco1=$this->input->post('incoterm');
		$deskripsi=$this->input->post('deskripsi');
		
		$account_group=$this->input->post('account_group');
		$recon_account=$this->input->post('recon_account');
		
		$nik=$this->session->userdata('NIK');
		$stHak=$this->oci_model->cek_hak_akses($nik, $sales_org2, $dis_channel2, $division2);
		if($stHak < 1){
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Sorry you do not have access, please contact the administrator !</div>');
			$url="customer/form_extend_cust";
			redirect($url);
		}
		
		//COLUM : ID_EX, CUST_ACCOUNT, SUBJECT, COMPANY1, SALES_ORG1, DIS_CHANNEL1, DIVISION1, COMPANY2, SALES_ORG2, DIS_CHANNEL2, DIVISION2, TOP, SALES_OFFICE, CUSTOMER_GROUP, CURRENCY, INCO1, INCO2, ACCOUNT_GROUP, RECON_ACCOUNT, ST_SEND, DATE_CREATE, NIK_CREATE, DATE_POSTING, DATE_APPROVED, NIK_APPROVED, DATE_TRANSPORT, NIK_TRANSPORT, DATE_MODIF, NIK_MODIF, DATE_DELETE, ST
		$nextID=$this->oci_model->nextIDEX();
		$field="ID_EX, TIPE, ID_CUST, CUST_ACCOUNT, SUBJECT, COMPANY1, SALES_ORG1, DIS_CHANNEL1, DIVISION1, COMPANY2, SALES_ORG2, DIS_CHANNEL2, DIVISION2, TOP, SALES_OFFICE, CUSTOMER_GROUP, CURRENCY, INCO1, INCO2, ACCOUNT_GROUP, RECON_ACCOUNT, ST_SEND, DATE_CREATE, NIK_CREATE, DATE_MODIF, NIK_MODIF, ST";
		$value="'".$nextID."', '".$tipe."', '".$id_req_cust."', '".$kunnr."', '".$subject."' ,'".$company1."','".$sales_org1."', '".$dis_channel1."', '".$division1."', '".$company2."', '".$sales_org2."', '".$dis_channel2."', '".$division2."', '".$top."', '".$sales_office."', '".$customer_group."', '".$currency."', '".$inco1."', '".$deskripsi."', '".$account_group."', '".$recon_account."', '0', TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI'), '".$nik."', TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI'), '".$nik."','1'";
		$exec=$this->oci_model->Exec($field, $value, 'T_CUST_EXTEND', FALSE, 'insert');
		
		if($exec <= 0){
		    $this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Failed to save Extend Customer!</div>');
			$url="customer/form_extend_cust";
			redirect($url);
		}else{
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				Extend Customer Success!</div>');
			$url="customer/list_cust_extend";
			redirect($url);
		}
	}
	
	function list_cust_extend(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->my_auth->hak_akses("REQUESTER");
		
		$this->load->model('sap_model');
		$this->load->model('oci_model');
		
		$usr=$this->session->userdata('NIK');
		
		if(strpos($this->session->userdata('role'),'ADMINISTRATOR') !== false){
			$field="ID_EX,CUST_ACCOUNT,SUBJECT,COMPANY1,SALES_ORG1,
				DIS_CHANNEL1,DIVISION1,COMPANY2,SALES_ORG2,
				DIS_CHANNEL2,DIVISION2,TOP,SALES_OFFICE,CUSTOMER_GROUP,
				CURRENCY,INCO1,INCO2,ACCOUNT_GROUP,RECON_ACCOUNT,
				ST_SEND,DATE_CREATE,NIK_CREATE,DATE_POSTING,DATE_APPROVED,
				NIK_APPROVED,DATE_TRANSPORT,NIK_TRANSPORT,DATE_MODIF,
				NIK_MODIF,DATE_DELETE,ST,NEW_ST, TIPE, ID_CUST,
				DEV_USERS.GET_NAME_BY_NIK(NIK_CREATE) AS NAME_CREATE";
			$kondisi="ST = '1' ORDER BY ID_EX DESC";
			$data['row']=$this->oci_model->select($field, 'VW_CUST_EXTEND',$kondisi);
		}else{
			$field="ID_EX,CUST_ACCOUNT,SUBJECT,COMPANY1,SALES_ORG1,
				DIS_CHANNEL1,DIVISION1,COMPANY2,SALES_ORG2,
				DIS_CHANNEL2,DIVISION2,TOP,SALES_OFFICE,CUSTOMER_GROUP,
				CURRENCY,INCO1,INCO2,ACCOUNT_GROUP,RECON_ACCOUNT,
				ST_SEND,DATE_CREATE,NIK_CREATE,DATE_POSTING,DATE_APPROVED,
				NIK_APPROVED,DATE_TRANSPORT,NIK_TRANSPORT,DATE_MODIF,
				NIK_MODIF,DATE_DELETE,ST,NEW_ST, TIPE, ID_CUST,
				DEV_USERS.GET_NAME_BY_NIK(NIK_CREATE) AS NAME_CREATE";
			$kondisi="ST = '1' AND NIK_CREATE = '".$usr."' ORDER BY ID_EX DESC";
			$data['row']=$this->oci_model->select($field, 'VW_CUST_EXTEND',$kondisi);
		}
		
		$data['main_content']="customer/list_cust_extend";
		$this->load->view('template/main',$data);	
	}
	
	function posting_extend(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$id=$this->input->post('id');
		$sales_org = $this->input->post('company');
		$dis_channel = $this->input->post('dis_channel');
		$division = $this->input->post('division');
		
		
		$field="ST_SEND = '1', DATE_POSTING = TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI')";
		$kondisi="ID_EX = '".$id."'";
		$exec=$this->oci_model->Exec($field, false, 'T_CUST_EXTEND', $kondisi, 'update');
		
		$fieldU="DISTINCT(NIK), DEV_USERS.GET_NAME_BY_NIK(NIK) as NAMA, DEV_USERS.GET_EMAIL_BY_NIK(NIK) AS EMAIL";
		$kondisiU="SALES_ORG='".$sales_org."' AND DIS_CHANNEL='".$dis_channel."' AND DIVISION='".$division."' AND NIK IN (SELECT NIK FROM M_CUST_ROLE WHERE (ROLE='APPROVAL' OR ROLE='ADMINISTRATOR'))";
		$listNIK=$this->oci_model->select($fieldU, 'M_CUST_PRIVILEGE',$kondisiU);
		
		$jml=count($listNIK);
		if($jml > 0){
			foreach($listNIK as $a){
				$nik=$a['NIK'];
				$email = $a['EMAIL'];
				$nama = $a['NAMA'];
				if($email <> ""){
					$this->send_mail($email, "REQUEST APPROVAL EXTEND CUSTOMER", "requestor","extend", $nama,$id);
				}
			}
		}
		
		
		if($exec == 1){
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Posting Extend Customer Request Success. Waiting for approval.</div>');
		}
	}
	
	function unposting_extend(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$id=$this->input->post('id');
		
		$st=$this->oci_model->getStatusExtendCustomer($id);
		if($st == "1"){
			$field="ST_SEND = '0', DATE_POSTING = ''";
			$kondisi="ID_EX = '".$id."'";
			$exec=$this->oci_model->Exec($field, false, 'T_CUST_EXTEND', $kondisi, 'update');
			
			if($exec == 1){
				$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Success!</h4>
					 Unposting Extend Customer Request Success</div>');
			}
		}else{
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					 Unposting failed, status extend customer not "Posting".</div>');
		}
	}
	
	function delete_extend_cust(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$id=$this->input->post('id');
		
		$st=$this->oci_model->getStatusExtendCustomer($id);
		if($st == "0"){
			$field="ST = '0', DATE_DELETE = TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI')";
			$kondisi="ID_EX = '".$id."'";
			$exec=$this->oci_model->Exec($field, false, 'T_CUST_EXTEND', $kondisi, 'update');
			
			if($exec == 1){
				$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Success!</h4>
					 Delete extend customer request success</div>');
			}
		}else{
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					 Failed to delete extend customer, extend customer status is not "Open".</div>');
		}
	}
	
	function view_extend(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		
		$id_ex=$this->uri->segment(3);
		$seskode=$this->session->userdata('seskode');
	    
		$field="*";
		$kondisi="ID_EX = '".$id_ex."'";
		$DataExtend=$this->oci_model->select($field, 'T_CUST_EXTEND',$kondisi);
		
		foreach($DataExtend as $a){
			$subject=$a['SUBJECT'];
			$kunnr=$a['CUST_ACCOUNT'];
			$company1=$a['COMPANY1'];
			$sales_org1=$a['SALES_ORG1'];
			$dis_channel1=$a['DIS_CHANNEL1'];
			$division1=$a['DIVISION1'];
			$company2=$a['COMPANY2'];
			$sales_org2=$a['SALES_ORG2'];
			$dis_channel2=$a['DIS_CHANNEL2'];
			$division2=$a['DIVISION2'];
			$top=$a['TOP'];
			$sales_office=$a['SALES_OFFICE'];
			$cust_group=$a['CUSTOMER_GROUP'];
			$currency=$a['CURRENCY'];
			$inco=$a['INCO1'];
			$deskripsi=$a['INCO2'];
			$account_group=$a['ACCOUNT_GROUP'];
			$rec_account=$a['RECON_ACCOUNT'];
			$st_send=$a['ST_SEND'];
			$date_create=$a['DATE_CREATE'];
			$date_posting=$a['DATE_POSTING'];
			$nik_create=$a['NIK_CREATE'];
			$date_posting=$a['DATE_POSTING'];
			$date_approve=$a['DATE_APPROVED'];
			$nik_approve=$a['NIK_APPROVED'];
			$date_transport=$a['DATE_TRANSPORT'];
			$nik_transport=$a['NIK_TRANSPORT'];
			$date_modif=$a['DATE_MODIF'];
			$nik_modif=$a['NIK_MODIF'];
			$st=$a['ST'];
			$tipe=$a['TIPE'];
			$id_cust_req=$a['ID_CUST'];
		}
		$data['nama_new']=$this->oci_model->getNamaKNA1($id_cust_req);
		
		$this->load->model('sap_model');
		$data_company=$this->sap_model->getCompanyCode();
		$data_industry=$this->sap_model->getIndustry();
		$data_customer_class=$this->sap_model->getCustomerClass();
		$data_top=$this->sap_model->getTOP();
		$data_customer_group=$this->sap_model->getCustomerGroup();
		$data_incoterm=$this->sap_model->getIncoterm();
		$data_nielsen=$this->sap_model->getNielsen();
		$data_dis_channel=$this->sap_model->getDistributionChannel();
		$data_division=$this->sap_model->getDivision();
		$data_sales_org=$this->sap_model->getSalesOrganization();
		$data_sales_office=$this->sap_model->getSalesOffice();
		$data_account_group=$this->sap_model->getAccountGroup();
		$data_recon_account=$this->sap_model->getReconAccount();
		
		$data['txt_company1']="";
		$data['txt_sales_org1']="";
		$data['txt_dischannel1']="";
		$data['txt_division1']="";
		$data['txt_company2']="";
		$data['txt_sales_org2']="";
		$data['txt_dischannel2']="";
		$data['txt_division2']="";
		
		$data['txt_top']="";
		$data['txt_salesoffice']="";
		$data['txt_inco1']="";
		$data['txt_account_group']="";
		$data['txt_recon']="";
		
		
		foreach($data_company as $key1 => $com){
			if($key1 == 0 and $com['BUKRS'] == ''){
			continue;}
		
			if($com['BUKRS'] == $company1 && $com['LAND1'] == 'ID'){
				$data['txt_company1']=$com['BUTXT'];
			}
			
			if($com['BUKRS'] == $company2 && $com['LAND1'] == 'ID'){
				$data['txt_company2']=$com['BUTXT'];
			}
		}
		
		foreach($data_sales_org as $key14 => $sor){
			if($key14 == 0 and !isset($sor['VKORG'])){
			continue;}
			if($sor['VKORG'] == $sales_org1){
				$data['txt_sales_org1']=$sor['VTEXT'];
			}
			
			if($sor['VKORG'] == $sales_org2){
				$data['txt_sales_org2']=$sor['VTEXT'];
			}
		}
		
		foreach($data_dis_channel as $key2 => $dis){
			
			if($key2 == 0 and !isset($dis['VTWEG'])){
			continue;}
			if($dis['VTWEG'] == $dis_channel1){
				$data['txt_dischannel1']=$dis['VTEXT'];
			}
			
			if($dis['VTWEG'] == $dis_channel2){
				$data['txt_dischannel2']=$dis['VTEXT'];
			}
		}
		foreach($data_division as $key3 => $div){
			
			if($key3 == 0 and !isset($div['SPART'])){
			continue;}
			if($div['SPART'] == $division1){
				$data['txt_division1']=$div['VTEXT'];
			}
			if($div['SPART'] == $division2){
				$data['txt_division2']=$div['VTEXT'];
			}
		}
		
		
		foreach($data_top as $key8 => $tp){
			if($key8 == 0 and !isset($tp['ZTERM'])){
			continue;}
			if($tp['ZTERM'] == $top){
				$data['txt_top']=$tp['VTEXT'];
			}
		}
		
		foreach($data_sales_office as $key9 => $sof){
			if($key9 == 0 and !isset($sof['VKBUR'])){
			continue;}
			if($sof['VKBUR'] == $sales_office){
				$data['txt_salesoffice']=$sof['BEZEI'];
			}
		}
		foreach($data_incoterm as $key10 => $inc){
			if($key10 == 0 and !isset($inc['INCO1'])){
			continue;}
			if($inc['INCO1'] == $inco){
				$data['txt_inco1']=$inc['BEZEI'];
			}
		}
		foreach($data_account_group as $key11 => $accg){
			if($key11 == 0 and !isset($accg['KTOKD'])){
			continue;}
			if($accg['KTOKD'] == $account_group){
				$data['txt_account_group']=$accg['TXT30'];
			}
		}
		foreach($data_recon_account as $key12 => $reca){
			if($key12 == 0 and !isset($reca['SAKNR'])){
			continue;}
			if($reca['SAKNR'] == $rec_account){
				$data['txt_recon']=$reca['TXT50'];
			}
		}
		foreach($data_customer_group as $key13 => $cgp){
			if($key13 == 0 and !isset($cgp['KDGRP'])){
			continue;}
			if($cgp['KDGRP'] == $cust_group){
				$data['txt_cust_group']=$cgp['KTEXT'];
			}
		}
		
		
		$data['xsubject']=$subject;
		$data['xkunnr']=$kunnr;
		$data['xcompany1']=$company1;
		$data['xsales_org1']=$sales_org1;
		$data['xdis_channel1']=$dis_channel1;
		$data['xdivision1']=$division1;
		$data['xcompany2']=$company2;
		$data['xsales_org2']=$sales_org2;
		$data['xdis_channel2']=$dis_channel2;
		$data['xdivision2']=$division2;
		$data['xtop']=$top;
		$data['xsales_office']=$sales_office;
		$data['xcust_group']=$cust_group;
		$data['xcurrency']=$currency;
		$data['xinco1']=$inco;
		$data['xinco2']=$deskripsi;
		$data['xaccount_group']=$account_group;
		$data['xrec_account']=$rec_account;
		$data['xst_send']=$st_send;
		$data['xdate_create']=$date_create;
		$data['xdate_posting']=$date_posting;
		$data['xdate_approve']=$date_approve;
		$data['xnik_approve']=$nik_approve;
		$data['xdate_transport']=$date_transport;
		$data['xnik_transport']=$nik_transport;
		$data['xdate_modif']=$date_modif;
		$data['xnik_modif']=$nik_modif;
		$data['xnik_create']=$nik_create;
		$data['xst']=$st;
		$data['id_ex']=$id_ex;
		$data['st_send']=$st_send;
		$data['st']=$st;
		$data['tipe']=$tipe;
		$data['id_cust_req']=$id_cust_req;
		
		//$data['nama_new']=$this->oci->getNamaKNA1($id_cust_req);

		
		
		$data['main_content']="customer/view_extend_cust";
		$this->load->view('template/main',$data);
	}
	
	function form_edit_extend(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$this->load->model('sap_model');
		
		$id_ex=$this->uri->segment(3);
		$seskode=$this->session->userdata('seskode');
	    
		$field="*";
		$kondisi="ID_EX = '".$id_ex."'";
		$DataExtend=$this->oci_model->select($field, 'T_CUST_EXTEND',$kondisi);
		
		foreach($DataExtend as $a){
			$subject=$a['SUBJECT'];
			$kunnr=$a['CUST_ACCOUNT'];
			$company1=$a['COMPANY1'];
			$sales_org1=$a['SALES_ORG1'];
			$dis_channel1=$a['DIS_CHANNEL1'];
			$division1=$a['DIVISION1'];
			$company2=$a['COMPANY2'];
			$sales_org2=$a['SALES_ORG2'];
			$dis_channel2=$a['DIS_CHANNEL2'];
			$division2=$a['DIVISION2'];
			$top=$a['TOP'];
			$sales_office=$a['SALES_OFFICE'];
			$cust_group=$a['CUSTOMER_GROUP'];
			$currency=$a['CURRENCY'];
			$inco=$a['INCO1'];
			$deskripsi=$a['INCO2'];
			$account_group=$a['ACCOUNT_GROUP'];
			$rec_account=$a['RECON_ACCOUNT'];
			$st_send=$a['ST_SEND'];
			$date_create=$a['DATE_CREATE'];
			$date_posting=$a['DATE_POSTING'];
			$nik_create=$a['NIK_CREATE'];
			$date_posting=$a['DATE_POSTING'];
			$date_approve=$a['DATE_APPROVED'];
			$nik_approve=$a['NIK_APPROVED'];
			$date_transport=$a['DATE_TRANSPORT'];
			$nik_transport=$a['NIK_TRANSPORT'];
			$date_modif=$a['DATE_MODIF'];
			$nik_modif=$a['NIK_MODIF'];
			$st=$a['ST'];
			$tipe=$a['TIPE'];
			$id_cust_req=$a['ID_CUST'];
		}
		
		$data['id_ex']=$id_ex;
		$data['xsubject']=$subject;
		$data['xkunnr']=$kunnr;
		$data['xcompany1']=$company1;
		$data['xsales_org1']=$sales_org1;
		$data['xdis_channel1']=$dis_channel1;
		$data['xdivision1']=$division1;
		$data['xcompany2']=$company2;
		$data['xsales_org2']=$sales_org2;
		$data['xdis_channel2']=$dis_channel2;
		$data['xdivision2']=$division2;
		$data['xtop']=$top;
		$data['xsales_office']=$sales_office;
		$data['xcust_group']=$cust_group;
		$data['xcurrency']=$currency;
		$data['xinco']=$inco;
		$data['xdeskripsi']=$deskripsi;
		$data['xaccount_group']=$account_group;
		$data['xrec_account']=$rec_account;
		$data['xst_send']=$st_send;
		$data['xdate_create']=$date_create;
		$data['xdate_posting']=$date_posting;
		$data['xdate_approve']=$date_approve;
		$data['xnik_approve']=$nik_approve;
		$data['xdate_transport']=$date_transport;
		$data['xnik_transport']=$nik_transport;
		$data['xdate_modif']=$date_modif;
		$data['xnik_modif']=$nik_modif;
		$data['xst']=$st;
		$data['tipe']=$tipe;
		$data['id_cust_req']=$id_cust_req;
		
		$data['company']=$this->sap_model->getCompanyCode();
		$data['country']=$this->sap_model->getCountry();
		$data['industry']=$this->sap_model->getIndustry();
		$data['customer_class']=$this->sap_model->getCustomerClass();
		$data['top']=$this->sap_model->getTOP();
		$data['sales_office']=$this->sap_model->getSalesOffice();
		$data['customer_group']=$this->sap_model->getCustomerGroup();
		$data['currency']=$this->sap_model->getCurrency();
		$data['incoterm']=$this->sap_model->getIncoterm();
		$data['dis_channel']=$this->sap_model->getDistributionChannel();
		$data['division']=$this->sap_model->getDivision();
		$data['sales_org']=$this->sap_model->getSalesOrganization();
		$data['account_group']=$this->sap_model->getAccountGroup();
		$data['recon_account']=$this->sap_model->getReconAccount();
		
		$data['main_content']="customer/form_edit_extend_cust";
		$this->load->view('template/main',$data);

	}
	
	function edit_extend_customer(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		
		$tipe=$this->input->post('tipe');
		$id_req_cust=$this->input->post('id_req_cust');
		
		$id_ex=$this->input->post('id_ex');
		$subject=$this->input->post('subject');
		$kunnr=$this->input->post('cust_account');
		
		
		if($tipe == "WEB"){
			$kunnr = "";
			$company1="";
			$sales_org1="";
			$dis_channel1="";
			$division1="";
			$id_req_cust=$this->input->post('id_req_cust');
		}else{
			$kunnr = $this->input->post('cust_account');
			$company1=$this->input->post('company2');
			$sales_org1=$this->input->post('sales_org2');
			$dis_channel1=$this->input->post('dis_channel2');
			$division1=$this->input->post('division2');
			$id_req_cust="";
		}
		
		
		$company2=$this->input->post('company');
		$sales_org2=$this->input->post('sales_org');
		$dis_channel2=$this->input->post('dis_channel');
		$division2=$this->input->post('division');
		
		$top=$this->input->post('top');
		$sales_office=$this->input->post('sales_office');
		$customer_group=$this->input->post('customer_group');
		$currency=$this->input->post('currency');
		$inco1=$this->input->post('incoterm');
		$deskripsi=$this->input->post('deskripsi');
		
		$account_group=$this->input->post('account_group');
		$recon_account=$this->input->post('recon_account');
		
		if($tipe == "WEB"){
			$jmlCust=$this->oci_model->getJmlStatusCustReq($id_req_cust);
			if($jmlCust == 0){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					ID Request New Customer Not Found !</div>');
				redirect('customer/list_cust_extend');
			}
			
			$cekKUNNR=$this->oci_model->cekKUNNR($id_req_cust);
			if($cekKUNNR == "3"){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Request New Customer already have Cust. Account (SAP ID), Please use Cust. Account for reference !</div>');
				redirect('customer/list_cust_extend');
			}
			
		}else{
			
			//------------------cek----------------------
			//get sesuai KUNNR
			$this->load->library('saprfc');	
			$this->load->library('sapauth');
			$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
			//Cek Connection SAP Status	
			$data['content']=$this->saprfc->callFunction("ZBAPI_FIND_CUST",
					array(
					    array("IMPORT","XKUNNR",$kunnr),
					    array("TABLE","XKNA1",array()),
					    array("TABLE","XKNB1",array()),
					    array("TABLE","XKNVV",array())
					)); 				
			$this->saprfc->logoff();
			
			
			foreach($data['content']["XKNA1"] as $rowA){
				
				$dataA[]=$rowA;
			}
			foreach($data['content']["XKNB1"] as $rowB){
			    $dataB[]=$rowB;
			}
			foreach($data['content']["XKNVV"] as $rowC){
			    $dataC[]=$rowC;
			}
			
			if(count($data['content']["XKNA1"]) == 0){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					 Reference Data not found !</div>');
				redirect('customer/list_cust_extend');
			}
			if(count($data['content']["XKNVV"]) == 0){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Reference Data not found !</div>');
				redirect('customer/list_cust_extend');
			}else{
				$status="0";
				
				foreach($data['content']["XKNVV"] as $a){
					if($a['VKORG'] == $sales_org1 && $a['VTWEG'] == $dis_channel1 && $a['SPART'] == $division1){
						$status = $status + 1;
					}
				}
				if($status < 1){
					$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
						<h4 class="alert-heading">Error!</h4>
						Reference Data not found !</div>');
					redirect('customer/list_cust_extend');
					//print_r($data['content']["XKNVV"]);
				}
			}
			
		}
		
		
		
		$nik=$this->session->userdata('NIK');
		$stHak=$this->oci_model->cek_hak_akses($nik, $sales_org2, $dis_channel2, $division2);
		if($stHak < 1){
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Sorry you do not have access, please contact the administrator !</div>');
			$url="customer/list_cust_extend";
			redirect($url);
		}
		//COLUM : ID_EX, CUST_ACCOUNT, COMPANY1, SALES_ORG1, DIS_CHANNEL1, DIVISION1, COMPANY2, SALES_ORG2, DIS_CHANNEL2, DIVISION2, TOP, SALES_OFFICE, CUSTOMER_GROUP, CURRENCY, INCO1, INCO2, ACCOUNT_GROUP, RECON_ACCOUNT, ST_SEND, DATE_CREATE, NIK_CREATE, DATE_POSTING, DATE_APPROVED, NIK_APPROVED, DATE_TRANSPORT, NIK_TRANSPORT, DATE_MODIF, NIK_MODIF, DATE_DELETE, ST
		
		$field="SUBJECT = '".$subject."', CUST_ACCOUNT='".$kunnr."', TIPE = '".$tipe."', ID_CUST = '".$id_req_cust."', COMPANY1='".$company1."', SALES_ORG1='".$sales_org1."', DIS_CHANNEL1='".$dis_channel1."', DIVISION1='".$division1."', COMPANY2='".$company2."', SALES_ORG2='".$sales_org2."', DIS_CHANNEL2='".$dis_channel2."', DIVISION2='".$division2."', TOP='".$top."', SALES_OFFICE='".$sales_office."', CUSTOMER_GROUP='".$customer_group."', CURRENCY='".$currency."', INCO1='".$inco1."', INCO2='".$deskripsi."', ACCOUNT_GROUP='".$account_group."', RECON_ACCOUNT='".$recon_account."', DATE_MODIF = TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI'), NIK_MODIF='".$nik."'";
		$kondisi="ID_EX = '".$id_ex."'";
		$exec=$this->oci_model->Exec($field, false, 'T_CUST_EXTEND', $kondisi, 'update');
		
		if($exec <= 0){
		    $this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Failed to edit Extend Customer!</div>');
			$url="customer/list_cust_extend";
			redirect($url);
		}else{
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				Edit Extend Customer Success!</div>');
			$url="customer/list_cust_extend";
			redirect($url);
		}
	}
	
	function transport_extend(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$this->load->model('sap_model');
		
		$id_ex=$this->input->post('id_ex');
		
		//get data ex local
		$field="*";
		$kondisi="ID_EX = '".$id_ex."'";
		$DataExtend=$this->oci_model->select($field, 'T_CUST_EXTEND',$kondisi);
		
		foreach($DataExtend as $a){
			$subject=$a['SUBJECT'];
			$kunnr=$a['CUST_ACCOUNT'];
			$company1=$a['COMPANY1'];
			$sales_org1=$a['SALES_ORG1'];
			$dis_channel1=$a['DIS_CHANNEL1'];
			$division1=$a['DIVISION1'];
			$company2=$a['COMPANY2'];
			$sales_org2=$a['SALES_ORG2'];
			$dis_channel2=$a['DIS_CHANNEL2'];
			$division2=$a['DIVISION2'];
			$xtop = $a['TOP'];
			$sales_office=$a['SALES_OFFICE'];
			$cust_group=$a['CUSTOMER_GROUP'];
			$currency=$a['CURRENCY'];
			$xinco=$a['INCO1'];
			$deskripsi=$a['INCO2'];
			$account_group=$a['ACCOUNT_GROUP'];
			$rec_account=$a['RECON_ACCOUNT'];
			$st_send=$a['ST_SEND'];
			$date_create=$a['DATE_CREATE'];
			$date_posting=$a['DATE_POSTING'];
			$nik_create=$a['NIK_CREATE'];
			$date_posting=$a['DATE_POSTING'];
			$date_approve=$a['DATE_APPROVED'];
			$nik_approve=$a['NIK_APPROVED'];
			$date_transport=$a['DATE_TRANSPORT'];
			$nik_transport=$a['NIK_TRANSPORT'];
			$date_modif=$a['DATE_MODIF'];
			$nik_modif=$a['NIK_MODIF'];
			$st=$a['ST'];
		}
		$nik=$this->session->userdata('NIK');
		$stHak=$this->oci_model->cek_hak_akses($nik, $sales_org2, $dis_channel2, $division2);
		if($stHak < 1){
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Sorry you do not have access, please contact the administrator !</div>');
			$url="customer/list_cust_extend";
			redirect($url);
		}
		//$kunnr="0001105421";
		//$company2="2000";
		//$sales_org2="2000";
		//$dis_channel2="20";
		//$division2="2A";
		//$top="Z014";
		//$sales_office="2001";
		//$cust_group="02";
		//$currency="IDR";
		//$xinco="FAS";
		//$deskripsi="tes extend";
		//$account_group="Z101";
		//$rec_account="0000132001";
		
		$this->load->library('saprfc');	
		$this->load->library('sapauth');		
		
		$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
		//Cek Connection SAP Status	
		$data['content']=$this->saprfc->callFunction("ZBAPI_CUSTOMER_DETAIL",
			array(	array("IMPORT","XKUNNR",$kunnr),
				array("IMPORT","XSALESORG",$sales_org1),
				array("IMPORT","XDIS_CHANNEL",$dis_channel1),
				array("IMPORT","XDIVISION",$division1),
				array("EXPORT","XMEMBER", array()),
				array("TABLE","XKNA1",array()),
				array("TABLE","XKNB1",array()),
				array("TABLE","XKNVV",array())
			     )
			); 	
		//echo $this->saprfc->printStatus();
		//echo $this->saprfc->getStatus();
		$member = $data['content']["XMEMBER"];
		
		foreach($data['content']["XKNA1"] as $a){
			$KUNNR = $a['KUNNR'];
			$LAND1 = $a['LAND1'];
			$NAME1 = $a['NAME1'];
			$NAME2 = $a['NAME2'];
			$ORT01 = $a['ORT01'];
			$PSTLZ = $a['PSTLZ'];
			$REGIO = $a['REGIO'];
			$SORTL = $a['SORTL'];
			$STRAS = $a['STRAS'];
			$TELF1 = $a['TELF1'];
			$TELFX = $a['TELFX'];
			$MCOD1 = $a['MCOD1'];
			$MCOD2 = $a['MCOD2'];
			$ANRED = $a['ANRED'];
			$BRSCH = $a['BRSCH'];
			$KTOKD = $a['KTOKD'];
			$KUKLA = $a['KUKLA'];
			$NIELS = $a['NIELS'];
			$STCEG = $a['STCEG'];
			$TELF2 = $a['TELF2'];
			$BRAN1 = $a['BRAN1'];
		}
		foreach($data['content']["XKNB1"] as $b){
			$company_code=$b['BUKRS'];
			$top=$b['ZTERM'];
			$recon=$b['AKONT'];
			$short_key=$b['ZUAWA'];
		}
		
		foreach($data['content']["XKNVV"] as $c){
			$KUNNR = $c['KUNNR'];
			$VKORG = $c['VKORG'];
			$VTWEG = $c['VTWEG'];
			$SPART = $c['SPART'];
			$KDGRP = $c['KDGRP'];
			$INCO1 = $c['INCO1'];
			$INCO2 = $c['INCO2'];
			$WAERS = $c['WAERS'];
			$ZTERM = $c['ZTERM'];
			$VKBUR = $c['VKBUR'];
			$VKGRP = $c['VKGRP'];
			$KALKS = $c['KALKS'];
			$VERSG = $c['VERSG'];
			$KTGRD = $c['KTGRD'];
			$PODKZ = $c['PODKZ'];
			$AWAHR = $c['AWAHR'];
		}
		
		
		//transport start
		//update via BAPI ZBAPI_TEST_INSERT_CUST
		$kna1=array(
			'KUNNR' => $KUNNR, //ID Customer
			'LAND1' => $LAND1, //Country
			'NAME1' => $NAME1, //Name1
			'NAME2' => $NAME2, //Name2
			'ORT01' => $ORT01, //City
			'PSTLZ' => $PSTLZ, //Postal Code
			'REGIO' => $REGIO, //Region
			'SORTL' => $SORTL, //short
			'STRAS' => $STRAS, //alamat jalan
			'TELF1' => $TELF1, //tlp1
			'TELFX' => $TELFX, //Fax
			'MCOD1' => $MCOD1, //Search 1
			'MCOD2' => $MCOD2, //Search 2
			'ANRED' => $ANRED, //Title
			'BRSCH' => $BRSCH, //Industry Key
			'KTOKD' => $KTOKD, //Customer Account Group
			'KUKLA' => $KUKLA, //Customer classification
			'NIELS' => $NIELS, //Nielsen ID
			'ORT02' => $ORT02, //Country
			'SPRAS' => "EN", //LAnguage
			'STCEG' => $STCEG, //Vatnum
			//'ERNAM' => "DEVELOPER",
			'TELF2' => $TELF2,
			'BRAN1' => $BRAN1
		);
		
		$knb1=array(
			'KUNNR' => $KUNNR, 
			'BUKRS' => $company2, //Company
			'AKONT' => $rec_account, //Recont account
			'ZTERM' => $xtop, //TOP
			'QLAND' => $LAND1, //Withholding Tax Country Key
			//'ERNAM' => "DEVELOPER",
			'ZUAWA' => $short_key
		);
		
		$knvv=array(
			'KUNNR' => $KUNNR, //Id Customer
			'VKORG' => $sales_org2, //Sales Org.
			'VTWEG' => $dis_channel2, //Distribution Channel
			'SPART' => $division2, //Division
			'KDGRP' => $cust_group, //Customer Group
			'INCO1' => $xinco, //Incoterm 1
			'INCO2' => $deskripsi, //Incoterm 2
			'WAERS' => $currency, //Mata Uang
			'ZTERM' => $xtop, //top
			'VKBUR' => $sales_office, //Sales office
			'VKGRP' => $VKGRP, //Sales Group
			'KALKS' => $KALKS, //Cust Price
			'VERSG' => $VERSG, //Customer Statistic Group
			'KTGRD' => $KTGRD, // Account assignment group for this customer
			'PODKZ' => $PODKZ, //Relevant for POD processing
			'AWAHR' => $AWAHR // Order probability of the item
			
		);
		
		$this->load->library('saprfc');	
		$this->load->library('sapauth');		
		
		$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
		//Cek Connection SAP Status	
		$data['content']=$this->saprfc->callFunction("ZBAPI_TEST_INSERT_CUST",
			array(	array("IMPORT","X_KNA1",$kna1),
				array("IMPORT","X_KNB1",$knb1),
				array("IMPORT","X_KNVV",$knvv),
				array("EXPORT","XKUNNR",array()),
				array("EXPORT","O_KNA1",array())
			     )
			); 	
		echo $this->saprfc->printStatus();
		echo $this->saprfc->getStatus();
		echo "<br/><br/>";
		echo "<pre>";
		print_r($data['content']["O_KNA1"]);
		echo "</pre>";
		
		
		//EMAIL END USER
		$fieldU="DEV_USERS.GET_NAME_BY_NIK('".$nik_create."') as NAMA, DEV_USERS.GET_EMAIL_BY_NIK('".$nik_create."') AS EMAIL";
		//$kondisiU="NIK='".$user."'";
		$listNIK=$this->oci_model->select($fieldU, 'DUAL', false);
		
		$jml=count($listNIK);
		if($jml > 0){
			foreach($listNIK as $a){
				//$nik=$a['NIK'];
				$email = $a['EMAIL'];
				$nama = $a['NAMA'];
				if($email <> ""){
					//$this->send_mail2($email, "REQUEST EXTEND CUSTOMER", "masterdata", $nama, $KUNNR);
					$this->send_mail($email, "REQUEST EXTEND CUSTOMER", "masterdata","extend", $nama, $KUNNR);
				}
			}
		}
		
		//----------------Update Data Local---------------------
		$nik=$this->session->userdata('NIK');
		
		//update customer extend
		$field="ST_SEND = '3', DATE_TRANSPORT = TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI'), NIK_TRANSPORT = '".$nik."'";
		$kondisi="ID_EX = '".$id_ex."'";
		$exec=$this->oci_model->Exec($field, false, 'T_CUST_EXTEND', $kondisi, 'update');
		
		$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
			<h4 class="alert-heading">Success!</h4>
			 Transport extend customer to SAP success. </div>');
		    redirect('customer/list_cust_extend');
		
	}
	
	function list_cust_approval_extend(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->my_auth->hak_akses("APPROVAL");
		
		$this->load->model('oci_model');
		$nik=$this->session->userdata('NIK');
		
		if(strpos($this->session->userdata('role'),'ADMINISTRATOR') !== false){
			$field="ID_EX,CUST_ACCOUNT,SUBJECT,COMPANY1,SALES_ORG1,
				DIS_CHANNEL1,DIVISION1,COMPANY2,SALES_ORG2,
				DIS_CHANNEL2,DIVISION2,TOP,SALES_OFFICE,CUSTOMER_GROUP,
				CURRENCY,INCO1,INCO2,ACCOUNT_GROUP,RECON_ACCOUNT,
				ST_SEND,DATE_CREATE,NIK_CREATE,DATE_POSTING,DATE_APPROVED,
				NIK_APPROVED,DATE_TRANSPORT,NIK_TRANSPORT,DATE_MODIF,
				NIK_MODIF,DATE_DELETE,ST,NEW_ST,DEV_USERS.GET_NAME_BY_NIK(NIK_CREATE) AS NAME_CREATE";
			$kondisi="(ST_SEND='1' OR ST_SEND = '2') AND ST = '1' ORDER BY ID_EX DESC";
			$data['row']=$this->oci_model->select($field, 'VW_CUST_EXTEND',$kondisi);
		}else{
			$field="ID_EX,CUST_ACCOUNT,SUBJECT,COMPANY1,SALES_ORG1,
				DIS_CHANNEL1,DIVISION1,COMPANY2,SALES_ORG2,
				DIS_CHANNEL2,DIVISION2,TOP,SALES_OFFICE,CUSTOMER_GROUP,
				CURRENCY,INCO1,INCO2,ACCOUNT_GROUP,RECON_ACCOUNT,
				ST_SEND,DATE_CREATE,NIK_CREATE,DATE_POSTING,DATE_APPROVED,
				NIK_APPROVED,DATE_TRANSPORT,NIK_TRANSPORT,DATE_MODIF,
				NIK_MODIF,DATE_DELETE,ST,NEW_ST,DEV_USERS.GET_NAME_BY_NIK(NIK_CREATE) AS NAME_CREATE";
			$kondisi="(ST_SEND='1' OR ST_SEND = '2') AND ST = '1' AND GET_ST_HAK('".$nik."', SALES_ORG2,DIS_CHANNEL2,DIVISION2) = '1' ORDER BY ID_EX DESC";
			$data['row']=$this->oci_model->select($field, 'VW_CUST_EXTEND',$kondisi);
		}
		//$field="*";
		//$kondisi="(ST_SEND='1' OR ST_SEND = '2') AND ST = '1' ORDER BY DATE_CREATE DESC";
		//$data['row']=$this->oci_model->select($field, 'VW_CUST_EXTEND',$kondisi);
		$data['main_content']="customer/list_cust_approval_extend";
		$this->load->view('template/main',$data);	
	}
	
	function form_approval_extend(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		
		$id_ex=$this->uri->segment(3);
		$seskode=$this->session->userdata('seskode');
	    
		$field="*";
		$kondisi="ID_EX = '".$id_ex."'";
		$DataExtend=$this->oci_model->select($field, 'VW_CUST_EXTEND',$kondisi);
		
		foreach($DataExtend as $a){
			$subject=$a['SUBJECT'];
			$kunnr=$a['CUST_ACCOUNT'];
			$company1=$a['COMPANY1'];
			$sales_org1=$a['SALES_ORG1'];
			$dis_channel1=$a['DIS_CHANNEL1'];
			$division1=$a['DIVISION1'];
			$company2=$a['COMPANY2'];
			$sales_org2=$a['SALES_ORG2'];
			$dis_channel2=$a['DIS_CHANNEL2'];
			$division2=$a['DIVISION2'];
			$top=$a['TOP'];
			$sales_office=$a['SALES_OFFICE'];
			$cust_group=$a['CUSTOMER_GROUP'];
			$currency=$a['CURRENCY'];
			$inco=$a['INCO1'];
			$deskripsi=$a['INCO2'];
			$account_group=$a['ACCOUNT_GROUP'];
			$rec_account=$a['RECON_ACCOUNT'];
			$st_send=$a['ST_SEND'];
			$date_create=$a['DATE_CREATE'];
			$date_posting=$a['DATE_POSTING'];
			$nik_create=$a['NIK_CREATE'];
			$date_posting=$a['DATE_POSTING'];
			$date_approve=$a['DATE_APPROVED'];
			$nik_approve=$a['NIK_APPROVED'];
			$date_transport=$a['DATE_TRANSPORT'];
			$nik_transport=$a['NIK_TRANSPORT'];
			$date_modif=$a['DATE_MODIF'];
			$nik_modif=$a['NIK_MODIF'];
			$st=$a['ST'];
			$tipe=$a['TIPE'];
			$id_req_cust=$a['ID_CUST'];
		}
		$data['nama_new']=$this->oci_model->getNamaKNA1($id_req_cust);
		$nik=$this->session->userdata('NIK');
		$stHak=$this->oci_model->cek_hak_akses($nik, $sales_org2, $dis_channel2, $division2);
		if($stHak < 1){
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Sorry you do not have access, please contact the administrator !</div>');
			$url="customer/list_cust_approval_extend";
			redirect($url);
		}
		
		$this->load->model('sap_model');
		$data_company=$this->sap_model->getCompanyCode();
		$data_industry=$this->sap_model->getIndustry();
		$data_customer_class=$this->sap_model->getCustomerClass();
		$data_top=$this->sap_model->getTOP();
		$data_customer_group=$this->sap_model->getCustomerGroup();
		$data_incoterm=$this->sap_model->getIncoterm();
		$data_nielsen=$this->sap_model->getNielsen();
		$data_dis_channel=$this->sap_model->getDistributionChannel();
		$data_division=$this->sap_model->getDivision();
		$data_sales_org=$this->sap_model->getSalesOrganization();
		$data_sales_office=$this->sap_model->getSalesOffice();
		$data_account_group=$this->sap_model->getAccountGroup();
		$data_recon_account=$this->sap_model->getReconAccount();
		
		$data['txt_company1']="";
		$data['txt_sales_org1']="";
		$data['txt_dischannel1']="";
		$data['txt_division1']="";
		$data['txt_company2']="";
		$data['txt_sales_org2']="";
		$data['txt_dischannel2']="";
		$data['txt_division2']="";
		
		$data['txt_top']="";
		$data['txt_salesoffice']="";
		$data['txt_inco1']="";
		$data['txt_account_group']="";
		$data['txt_recon']="";
		
		
		foreach($data_company as $key1 => $com){
			if($key1 == 0 and $com['BUKRS'] == ''){
			continue;}
		
			if($com['BUKRS'] == $company1 && $com['LAND1'] == 'ID'){
				$data['txt_company1']=$com['BUTXT'];
			}
			
			if($com['BUKRS'] == $company2 && $com['LAND1'] == 'ID'){
				$data['txt_company2']=$com['BUTXT'];
			}
		}
		
		foreach($data_sales_org as $key14 => $sor){
			if($key14 == 0 and !isset($sor['VKORG'])){
			continue;}
			if($sor['VKORG'] == $sales_org1){
				$data['txt_sales_org1']=$sor['VTEXT'];
			}
			
			if($sor['VKORG'] == $sales_org2){
				$data['txt_sales_org2']=$sor['VTEXT'];
			}
		}
		
		foreach($data_dis_channel as $key2 => $dis){
			
			if($key2 == 0 and !isset($dis['VTWEG'])){
			continue;}
			if($dis['VTWEG'] == $dis_channel1){
				$data['txt_dischannel1']=$dis['VTEXT'];
			}
			
			if($dis['VTWEG'] == $dis_channel2){
				$data['txt_dischannel2']=$dis['VTEXT'];
			}
		}
		foreach($data_division as $key3 => $div){
			
			if($key3 == 0 and !isset($div['SPART'])){
			continue;}
			if($div['SPART'] == $division1){
				$data['txt_division1']=$div['VTEXT'];
			}
			if($div['SPART'] == $division2){
				$data['txt_division2']=$div['VTEXT'];
			}
		}
		
		foreach($data_top as $key8 => $tp){
			if($key8 == 0 and !isset($tp['ZTERM'])){
			continue;}
			if($tp['ZTERM'] == $top){
				$data['txt_top']=$tp['VTEXT'];
			}
		}
		
		foreach($data_sales_office as $key9 => $sof){
			if($key9 == 0 and !isset($sof['VKBUR'])){
			continue;}
			if($sof['VKBUR'] == $sales_office){
				$data['txt_salesoffice']=$sof['BEZEI'];
			}
		}
		foreach($data_incoterm as $key10 => $inc){
			if($key10 == 0 and !isset($inc['INCO1'])){
			continue;}
			if($inc['INCO1'] == $inco){
				$data['txt_inco1']=$inc['BEZEI'];
			}
		}
		foreach($data_account_group as $key11 => $accg){
			if($key11 == 0 and !isset($accg['KTOKD'])){
			continue;}
			if($accg['KTOKD'] == $account_group){
				$data['txt_account_group']=$accg['TXT30'];
			}
		}
		foreach($data_recon_account as $key12 => $reca){
			if($key12 == 0 and !isset($reca['SAKNR'])){
			continue;}
			if($reca['SAKNR'] == $rec_account){
				$data['txt_recon']=$reca['TXT50'];
			}
		}
		
		$data['account_group']=$data_account_group;
		$data['recon_account']=$data_recon_account;
		
		$data['id_ex']=$id_ex;
		$data['xsubject']=$subject;
		$data['xkunnr']=$kunnr;
		$data['xcompany1']=$company1;
		$data['xsales_org1']=$sales_org1;
		$data['xdis_channel1']=$dis_channel1;
		$data['xdivision1']=$division1;
		$data['xcompany2']=$company2;
		$data['xsales_org2']=$sales_org2;
		$data['xdis_channel2']=$dis_channel2;
		$data['xdivision2']=$division2;
		$data['xtop']=$top;
		$data['xsales_office']=$sales_office;
		$data['xcust_group']=$cust_group;
		$data['xcurrency']=$currency;
		$data['xinco']=$inco;
		$data['xdeskripsi']=$deskripsi;
		$data['xaccount_group']=$account_group;
		$data['xrec_account']=$rec_account;
		$data['xst_send']=$st_send;
		$data['xdate_create']=$date_create;
		$data['xdate_posting']=$date_posting;
		$data['xdate_approve']=$date_approve;
		$data['xnik_approve']=$nik_approve;
		$data['xdate_transport']=$date_transport;
		$data['xnik_transport']=$nik_transport;
		$data['xdate_modif']=$date_modif;
		$data['xnik_modif']=$nik_modif;
		$data['xnik_create']=$nik_create;
		$data['xst']=$st;
		$data['tipe']=$tipe;
		$data['id_req_cust']=$id_req_cust;
		
		$data['main_content']="customer/form_approval_extend";
		$this->load->view('template/main',$data);
	}
	
	function add_approval_extend(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$seskode=$this->session->userdata('seskode');
		$nik=$this->session->userdata('NIK');
		
		$id_ex=$this->input->post('id_ex');
		
		$account_group=$this->input->post('account_group');
		$recon_account=$this->input->post('recon_account');
		
		$field="*";
		$kondisi="ID_EX = '".$id_ex."'";
		$DataExtend=$this->oci_model->select($field, 'VW_CUST_EXTEND',$kondisi);
		
		foreach($DataExtend as $a){
			$kunnr=$a['CUST_ACCOUNT'];
			$company1=$a['COMPANY1'];
			$sales_org1=$a['SALES_ORG1'];
			$dis_channel1=$a['DIS_CHANNEL1'];
			$division1=$a['DIVISION1'];
			$company2=$a['COMPANY2'];
			$sales_org2=$a['SALES_ORG2'];
			$dis_channel2=$a['DIS_CHANNEL2'];
			$division2=$a['DIVISION2'];
		}
		
		$nik=$this->session->userdata('NIK');
		$stHak=$this->oci_model->cek_hak_akses($nik, $sales_org2, $dis_channel2, $division2);
		if($stHak < 1){
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Sorry you do not have access, please contact the administrator !</div>');
			$url="customer/list_cust_extend";
			redirect($url);
		}
		
		$fieldU="DISTINCT(NIK), DEV_USERS.GET_NAME_BY_NIK(NIK) as NAMA, DEV_USERS.GET_EMAIL_BY_NIK(NIK) AS EMAIL";
		$kondisiU="SALES_ORG='".$sales_org2."' AND DIS_CHANNEL='".$dis_channel2."' AND DIVISION='".$division2."' AND NIK IN (SELECT NIK FROM M_CUST_ROLE WHERE (ROLE='MASTERDATA' OR ROLE='ADMINISTRATOR'))";
		$listNIK=$this->oci_model->select($fieldU, 'M_CUST_PRIVILEGE',$kondisiU);
		
		$jml=count($listNIK);
		if($jml > 0){
			foreach($listNIK as $a){
				$nik=$a['NIK'];
				$email = $a['EMAIL'];
				$nama = $a['NAMA'];
				if($email <> ""){
					$this->send_mail($email, "REQUEST TRANSPORT EXTEND CUSTOMER", "approval", "extend", $nama, $id_ex);
				}
			}
		}
		
		
		
		//update customer Extend
		$field="ST_SEND = '2', DATE_APPROVED = TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI'), NIK_APPROVED = '".$nik."', ACCOUNT_GROUP = '".$account_group."', RECON_ACCOUNT = '".$recon_account."'";
		$kondisi="ID_EX = '".$id_ex."'";
		$exec=$this->oci_model->Exec($field, false, 'T_CUST_EXTEND', $kondisi, 'update');
		
		if($exec == 1){
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Approval Customer Extend Request Success.</div>');
			redirect('customer/list_cust_approval_extend');
		}
	}
	
	function form_edit_approval_extend(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		
		$id_ex=$this->uri->segment(3);
		$seskode=$this->session->userdata('seskode');
	    
		$field="*";
		$kondisi="ID_EX = '".$id_ex."'";
		$DataExtend=$this->oci_model->select($field, 'VW_CUST_EXTEND',$kondisi);
		
		foreach($DataExtend as $a){
			$subject=$a['SUBJECT'];
			$kunnr=$a['CUST_ACCOUNT'];
			$company1=$a['COMPANY1'];
			$sales_org1=$a['SALES_ORG1'];
			$dis_channel1=$a['DIS_CHANNEL1'];
			$division1=$a['DIVISION1'];
			$company2=$a['COMPANY2'];
			$sales_org2=$a['SALES_ORG2'];
			$dis_channel2=$a['DIS_CHANNEL2'];
			$division2=$a['DIVISION2'];
			$top=$a['TOP'];
			$sales_office=$a['SALES_OFFICE'];
			$cust_group=$a['CUSTOMER_GROUP'];
			$currency=$a['CURRENCY'];
			$inco=$a['INCO1'];
			$deskripsi=$a['INCO2'];
			$account_group=$a['ACCOUNT_GROUP'];
			$rec_account=$a['RECON_ACCOUNT'];
			$st_send=$a['ST_SEND'];
			$date_create=$a['DATE_CREATE'];
			$date_posting=$a['DATE_POSTING'];
			$nik_create=$a['NIK_CREATE'];
			$date_posting=$a['DATE_POSTING'];
			$date_approve=$a['DATE_APPROVED'];
			$nik_approve=$a['NIK_APPROVED'];
			$date_transport=$a['DATE_TRANSPORT'];
			$nik_transport=$a['NIK_TRANSPORT'];
			$date_modif=$a['DATE_MODIF'];
			$nik_modif=$a['NIK_MODIF'];
			$st=$a['ST'];
			$tipe=$a['TIPE'];
			$id_req_cust=$a['ID_CUST'];
		}
		$data['nama_new']=$this->oci_model->getNamaKNA1($id_req_cust);
		
		
		$nik=$this->session->userdata('NIK');
		$stHak=$this->oci_model->cek_hak_akses($nik, $sales_org2, $dis_channel2, $division2);
		if($stHak < 1){
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Sorry you do not have access, please contact the administrator !</div>');
			$url="customer/list_cust_approval_extend";
			redirect($url);
		}
		$this->load->model('sap_model');
		$data_company=$this->sap_model->getCompanyCode();
		$data_industry=$this->sap_model->getIndustry();
		$data_customer_class=$this->sap_model->getCustomerClass();
		$data_top=$this->sap_model->getTOP();
		$data_customer_group=$this->sap_model->getCustomerGroup();
		$data_incoterm=$this->sap_model->getIncoterm();
		$data_nielsen=$this->sap_model->getNielsen();
		$data_dis_channel=$this->sap_model->getDistributionChannel();
		$data_division=$this->sap_model->getDivision();
		$data_sales_org=$this->sap_model->getSalesOrganization();
		$data_sales_office=$this->sap_model->getSalesOffice();
		$data_account_group=$this->sap_model->getAccountGroup();
		$data_recon_account=$this->sap_model->getReconAccount();
		
		$data['txt_company1']="";
		$data['txt_sales_org1']="";
		$data['txt_dischannel1']="";
		$data['txt_division1']="";
		$data['txt_company2']="";
		$data['txt_sales_org2']="";
		$data['txt_dischannel2']="";
		$data['txt_division2']="";
		
		$data['txt_top']="";
		$data['txt_salesoffice']="";
		$data['txt_inco1']="";
		$data['txt_account_group']="";
		$data['txt_recon']="";
		
		
		foreach($data_company as $key1 => $com){
			if($key1 == 0 and $com['BUKRS'] == ''){
			continue;}
		
			if($com['BUKRS'] == $company1 && $com['LAND1'] == 'ID'){
				$data['txt_company1']=$com['BUTXT'];
			}
			
			if($com['BUKRS'] == $company2 && $com['LAND1'] == 'ID'){
				$data['txt_company2']=$com['BUTXT'];
			}
		}
		
		foreach($data_sales_org as $key14 => $sor){
			if($key14 == 0 and !isset($sor['VKORG'])){
			continue;}
			if($sor['VKORG'] == $sales_org1){
				$data['txt_sales_org1']=$sor['VTEXT'];
			}
			
			if($sor['VKORG'] == $sales_org2){
				$data['txt_sales_org2']=$sor['VTEXT'];
			}
		}
		
		foreach($data_dis_channel as $key2 => $dis){
			
			if($key2 == 0 and !isset($dis['VTWEG'])){
			continue;}
			if($dis['VTWEG'] == $dis_channel1){
				$data['txt_dischannel1']=$dis['VTEXT'];
			}
			
			if($dis['VTWEG'] == $dis_channel2){
				$data['txt_dischannel2']=$dis['VTEXT'];
			}
		}
		foreach($data_division as $key3 => $div){
			
			if($key3 == 0 and !isset($div['SPART'])){
			continue;}
			if($div['SPART'] == $division1){
				$data['txt_division1']=$div['VTEXT'];
			}
			if($div['SPART'] == $division2){
				$data['txt_division2']=$div['VTEXT'];
			}
		}
		
		foreach($data_top as $key8 => $tp){
			if($key8 == 0 and !isset($tp['ZTERM'])){
			continue;}
			if($tp['ZTERM'] == $top){
				$data['txt_top']=$tp['VTEXT'];
			}
		}
		
		foreach($data_sales_office as $key9 => $sof){
			if($key9 == 0 and !isset($sof['VKBUR'])){
			continue;}
			if($sof['VKBUR'] == $sales_office){
				$data['txt_salesoffice']=$sof['BEZEI'];
			}
		}
		foreach($data_incoterm as $key10 => $inc){
			if($key10 == 0 and !isset($inc['INCO1'])){
			continue;}
			if($inc['INCO1'] == $inco){
				$data['txt_inco1']=$inc['BEZEI'];
			}
		}
		foreach($data_account_group as $key11 => $accg){
			if($key11 == 0 and !isset($accg['KTOKD'])){
			continue;}
			if($accg['KTOKD'] == $account_group){
				$data['txt_account_group']=$accg['TXT30'];
			}
		}
		foreach($data_recon_account as $key12 => $reca){
			if($key12 == 0 and !isset($reca['SAKNR'])){
			continue;}
			if($reca['SAKNR'] == $rec_account){
				$data['txt_recon']=$reca['TXT50'];
			}
		}
		
		$data['account_group']=$data_account_group;
		$data['recon_account']=$data_recon_account;
		
		$data['id_ex']=$id_ex;
		$data['xsubject']=$subject;
		$data['xkunnr']=$kunnr;
		$data['xcompany1']=$company1;
		$data['xsales_org1']=$sales_org1;
		$data['xdis_channel1']=$dis_channel1;
		$data['xdivision1']=$division1;
		$data['xcompany2']=$company2;
		$data['xsales_org2']=$sales_org2;
		$data['xdis_channel2']=$dis_channel2;
		$data['xdivision2']=$division2;
		$data['xtop']=$top;
		$data['xsales_office']=$sales_office;
		$data['xcust_group']=$cust_group;
		$data['xcurrency']=$currency;
		$data['xinco']=$inco;
		$data['xdeskripsi']=$deskripsi;
		$data['xaccount_group']=$account_group;
		$data['xrec_account']=$rec_account;
		$data['xst_send']=$st_send;
		$data['xdate_create']=$date_create;
		$data['xdate_posting']=$date_posting;
		$data['xdate_approve']=$date_approve;
		$data['xnik_approve']=$nik_approve;
		$data['xdate_transport']=$date_transport;
		$data['xnik_transport']=$nik_transport;
		$data['xdate_modif']=$date_modif;
		$data['xnik_modif']=$nik_modif;
		$data['xnik_create']=$nik_create;
		$data['xst']=$st;
		$data['tipe']=$tipe;
		$data['id_req_cust']=$id_req_cust;
		
		
		$data['main_content']="customer/form_approval_extend_edit";
		$this->load->view('template/main',$data);
	}
	
	function edit_approval_extend(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$seskode=$this->session->userdata('seskode');
		$nik=$this->session->userdata('NIK');
		
		$id_ex=$this->input->post('id_ex');
		
		$account_group=$this->input->post('account_group');
		$recon_account=$this->input->post('recon_account');
		
		$field="*";
		$kondisi="ID_EX = '".$id_ex."'";
		$DataExtend=$this->oci_model->select($field, 'VW_CUST_EXTEND',$kondisi);
		
		foreach($DataExtend as $a){
			$kunnr=$a['CUST_ACCOUNT'];
			$company1=$a['COMPANY1'];
			$sales_org1=$a['SALES_ORG1'];
			$dis_channel1=$a['DIS_CHANNEL1'];
			$division1=$a['DIVISION1'];
			$company2=$a['COMPANY2'];
			$sales_org2=$a['SALES_ORG2'];
			$dis_channel2=$a['DIS_CHANNEL2'];
			$division2=$a['DIVISION2'];
		}
		
		$nik=$this->session->userdata('NIK');
		$stHak=$this->oci_model->cek_hak_akses($nik, $sales_org2, $dis_channel2, $division2);
		if($stHak < 1){
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Sorry you do not have access, please contact the administrator !</div>');
			$url="customer/list_cust_extend";
			redirect($url);
		}
		
		//update customer Extend
		$field="ST_SEND = '2', ACCOUNT_GROUP = '".$account_group."', RECON_ACCOUNT = '".$recon_account."'";
		$kondisi="ID_EX = '".$id_ex."'";
		$exec=$this->oci_model->Exec($field, false, 'T_CUST_EXTEND', $kondisi, 'update');
		
		if($exec == 1){
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Approval Customer Extend Request Success.</div>');
			redirect('customer/list_cust_approval_extend');
		}
	}
	function list_cust_is_extend(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->my_auth->hak_akses("MASTERDATA");
		
		$this->load->model('oci_model');
		$nik=$this->session->userdata('NIK');
		if(strpos($this->session->userdata('role'),'ADMINISTRATOR') !== false){
			$field="ID_EX,CUST_ACCOUNT,SUBJECT,COMPANY1,SALES_ORG1,
				DIS_CHANNEL1,DIVISION1,COMPANY2,SALES_ORG2,
				DIS_CHANNEL2,DIVISION2,TOP,SALES_OFFICE,CUSTOMER_GROUP,
				CURRENCY,INCO1,INCO2,ACCOUNT_GROUP,RECON_ACCOUNT,
				ST_SEND,DATE_CREATE,NIK_CREATE,DATE_POSTING,DATE_APPROVED,
				NIK_APPROVED,DATE_TRANSPORT,NIK_TRANSPORT,DATE_MODIF,
				NIK_MODIF,DATE_DELETE,ST,NEW_ST,TIPE, ID_CUST,
				DEV_USERS.GET_NAME_BY_NIK(NIK_CREATE) AS NAME_CREATE";
			$kondisi="ST_SEND = '2' AND ST = '1' ORDER BY ID_EX DESC";
			$data['row']=$this->oci_model->select($field, 'VW_CUST_EXTEND',$kondisi);
		}else{
			$field="ID_EX,CUST_ACCOUNT,SUBJECT,COMPANY1,SALES_ORG1,
				DIS_CHANNEL1,DIVISION1,COMPANY2,SALES_ORG2,
				DIS_CHANNEL2,DIVISION2,TOP,SALES_OFFICE,CUSTOMER_GROUP,
				CURRENCY,INCO1,INCO2,ACCOUNT_GROUP,RECON_ACCOUNT,
				ST_SEND,DATE_CREATE,NIK_CREATE,DATE_POSTING,DATE_APPROVED,
				NIK_APPROVED,DATE_TRANSPORT,NIK_TRANSPORT,DATE_MODIF,
				NIK_MODIF,DATE_DELETE,ST,NEW_ST,TIPE, ID_CUST,
				DEV_USERS.GET_NAME_BY_NIK(NIK_CREATE) AS NAME_CREATE";
			$kondisi="ST_SEND = '2' AND ST = '1' AND GET_ST_HAK('".$nik."', SALES_ORG2,DIS_CHANNEL2,DIVISION2) = '1' ORDER BY ID_EX DESC";
			$data['row']=$this->oci_model->select($field, 'VW_CUST_EXTEND',$kondisi);
		}
		
		$data['main_content']="customer/list_cust_is_extend";
		$this->load->view('template/main',$data);	
	}
	
	function form_transport_extend(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		
		$id_ex=$this->uri->segment(3);
		$seskode=$this->session->userdata('seskode');
	    
		$field="*";
		$kondisi="ID_EX = '".$id_ex."'";
		$DataExtend=$this->oci_model->select($field, 'VW_CUST_EXTEND',$kondisi);
		
		foreach($DataExtend as $a){
			$subject=$a['SUBJECT'];
			$kunnr=$a['CUST_ACCOUNT'];
			$company1=$a['COMPANY1'];
			$sales_org1=$a['SALES_ORG1'];
			$dis_channel1=$a['DIS_CHANNEL1'];
			$division1=$a['DIVISION1'];
			$company2=$a['COMPANY2'];
			$sales_org2=$a['SALES_ORG2'];
			$dis_channel2=$a['DIS_CHANNEL2'];
			$division2=$a['DIVISION2'];
			$top=$a['TOP'];
			$sales_office=$a['SALES_OFFICE'];
			$cust_group=$a['CUSTOMER_GROUP'];
			$currency=$a['CURRENCY'];
			$inco=$a['INCO1'];
			$deskripsi=$a['INCO2'];
			$account_group=$a['ACCOUNT_GROUP'];
			$rec_account=$a['RECON_ACCOUNT'];
			$st_send=$a['ST_SEND'];
			$date_create=$a['DATE_CREATE'];
			$date_posting=$a['DATE_POSTING'];
			$nik_create=$a['NIK_CREATE'];
			$date_posting=$a['DATE_POSTING'];
			$date_approve=$a['DATE_APPROVED'];
			$nik_approve=$a['NIK_APPROVED'];
			$date_transport=$a['DATE_TRANSPORT'];
			$nik_transport=$a['NIK_TRANSPORT'];
			$date_modif=$a['DATE_MODIF'];
			$nik_modif=$a['NIK_MODIF'];
			$st=$a['ST'];
			$tipe=$a['TIPE'];
			$id_req_cust=$a['ID_CUST'];
		}
		
		
		if($tipe == "WEB"){
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Sorry, this request waiting for new customer request transported (ID Request New Customer : '.$id_req_cust.' ) !</div>');
			$url="customer/list_cust_is_extend";
			redirect($url);
		}
		
		$this->load->model('sap_model');
		$data_company=$this->sap_model->getCompanyCode();
		$data_industry=$this->sap_model->getIndustry();
		$data_customer_class=$this->sap_model->getCustomerClass();
		$data_top=$this->sap_model->getTOP();
		$data_customer_group=$this->sap_model->getCustomerGroup();
		$data_incoterm=$this->sap_model->getIncoterm();
		$data_nielsen=$this->sap_model->getNielsen();
		$data_dis_channel=$this->sap_model->getDistributionChannel();
		$data_division=$this->sap_model->getDivision();
		$data_sales_org=$this->sap_model->getSalesOrganization();
		$data_sales_office=$this->sap_model->getSalesOffice();
		$data_account_group=$this->sap_model->getAccountGroup();
		$data_recon_account=$this->sap_model->getReconAccount();
		
		$data['txt_company1']="";
		$data['txt_sales_org1']="";
		$data['txt_dischannel1']="";
		$data['txt_division1']="";
		$data['txt_company2']="";
		$data['txt_sales_org2']="";
		$data['txt_dischannel2']="";
		$data['txt_division2']="";
		
		$data['txt_top']="";
		$data['txt_salesoffice']="";
		$data['txt_inco1']="";
		$data['txt_account_group']="";
		$data['txt_recon']="";
		
		
		foreach($data_company as $key1 => $com){
			if($key1 == 0 and $com['BUKRS'] == ''){
			continue;}
		
			if($com['BUKRS'] == $company1 && $com['LAND1'] == 'ID'){
				$data['txt_company1']=$com['BUTXT'];
			}
			
			if($com['BUKRS'] == $company2 && $com['LAND1'] == 'ID'){
				$data['txt_company2']=$com['BUTXT'];
			}
		}
		
		foreach($data_sales_org as $key14 => $sor){
			if($key14 == 0 and !isset($sor['VKORG'])){
			continue;}
			if($sor['VKORG'] == $sales_org1){
				$data['txt_sales_org1']=$sor['VTEXT'];
			}
			
			if($sor['VKORG'] == $sales_org2){
				$data['txt_sales_org2']=$sor['VTEXT'];
			}
		}
		
		foreach($data_dis_channel as $key2 => $dis){
			
			if($key2 == 0 and !isset($dis['VTWEG'])){
			continue;}
			if($dis['VTWEG'] == $dis_channel1){
				$data['txt_dischannel1']=$dis['VTEXT'];
			}
			
			if($dis['VTWEG'] == $dis_channel2){
				$data['txt_dischannel2']=$dis['VTEXT'];
			}
		}
		foreach($data_division as $key3 => $div){
			
			if($key3 == 0 and !isset($div['SPART'])){
			continue;}
			if($div['SPART'] == $division1){
				$data['txt_division1']=$div['VTEXT'];
			}
			if($div['SPART'] == $division2){
				$data['txt_division2']=$div['VTEXT'];
			}
		}
		
		foreach($data_top as $key8 => $tp){
			if($key8 == 0 and !isset($tp['ZTERM'])){
			continue;}
			if($tp['ZTERM'] == $top){
				$data['txt_top']=$tp['VTEXT'];
			}
		}
		
		foreach($data_sales_office as $key9 => $sof){
			if($key9 == 0 and !isset($sof['VKBUR'])){
			continue;}
			if($sof['VKBUR'] == $sales_office){
				$data['txt_salesoffice']=$sof['BEZEI'];
			}
		}
		foreach($data_incoterm as $key10 => $inc){
			if($key10 == 0 and !isset($inc['INCO1'])){
			continue;}
			if($inc['INCO1'] == $inco){
				$data['txt_inco1']=$inc['BEZEI'];
			}
		}
		foreach($data_account_group as $key11 => $accg){
			if($key11 == 0 and !isset($accg['KTOKD'])){
			continue;}
			if($accg['KTOKD'] == $account_group){
				$data['txt_account_group']=$accg['TXT30'];
			}
		}
		foreach($data_recon_account as $key12 => $reca){
			if($key12 == 0 and !isset($reca['SAKNR'])){
			continue;}
			if($reca['SAKNR'] == $rec_account){
				$data['txt_recon']=$reca['TXT50'];
			}
		}
		
		$data['account_group']=$data_account_group;
		$data['recon_account']=$data_recon_account;
		
		$data['id_ex']=$id_ex;
		$data['xsubject']=$subject;
		$data['xkunnr']=$kunnr;
		$data['xcompany1']=$company1;
		$data['xsales_org1']=$sales_org1;
		$data['xdis_channel1']=$dis_channel1;
		$data['xdivision1']=$division1;
		$data['xcompany2']=$company2;
		$data['xsales_org2']=$sales_org2;
		$data['xdis_channel2']=$dis_channel2;
		$data['xdivision2']=$division2;
		$data['xtop']=$top;
		$data['xsales_office']=$sales_office;
		$data['xcust_group']=$cust_group;
		$data['xcurrency']=$currency;
		$data['xinco']=$inco;
		$data['xdeskripsi']=$deskripsi;
		$data['xaccount_group']=$account_group;
		$data['xrec_account']=$rec_account;
		$data['xst_send']=$st_send;
		$data['xdate_create']=$date_create;
		$data['xdate_posting']=$date_posting;
		$data['xdate_approve']=$date_approve;
		$data['xnik_approve']=$nik_approve;
		$data['xdate_transport']=$date_transport;
		$data['xnik_transport']=$nik_transport;
		$data['xdate_modif']=$date_modif;
		$data['xnik_modif']=$nik_modif;
		$data['xnik_create']=$nik_create;
		$data['xst']=$st;
		
		$data['main_content']="customer/form_transport_extend";
		$this->load->view('template/main',$data);
	}
	
	function form_edit_cust_req1(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->my_auth->hak_akses("REQUESTER");
	    
		$this->load->model('sap_model');
		
		
		$data['company']=$this->sap_model->getCompanyCode();
		$data['dis_channel']=$this->sap_model->getDistributionChannel();
		$data['division']=$this->sap_model->getDivision();
		$data['sales_org']=$this->sap_model->getSalesOrganization();
		
		$data['main_content']="customer/form_edit_cust_req1";
		$this->load->view('template/main',$data);
	}
	
	function form_edit_cust_req2(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$this->load->model('sap_model');
		
		$kunnr=$this->input->post('cust_account');
		//$kunnr="000".$kunnr;
		$sales_org=$this->input->post('sales_org');
		$dis_channel=$this->input->post('dis_channel');
		$division=$this->input->post('division');
		$seskode=$this->session->userdata('seskode');
		
		//delete_temp
		//$kondisiTempDel="SESKODE = '".$seskode."' AND KUNNR='".$kunnr."'";
		//$this->oci_model->Exec(FALSE, FALSE, 'TEMP_CP_EDIT', $kondisiTempDel, 'delete');
			
		$nik=$this->session->userdata('NIK');
		$stHak=$this->oci_model->cek_hak_akses($nik, $sales_org, $dis_channel, $division);
		if($stHak < 1){
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Sorry you do not have access, please contact the administrator !</div>');
			$url="customer/form_edit_cust_req1";
			redirect($url);
		}
		
		$this->load->library('saprfc');	
		$this->load->library('sapauth');		
		
		$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
		//Cek Connection SAP Status	
		$data['content']=$this->saprfc->callFunction("ZBAPI_CUSTOMER_DETAIL",
			array(	array("IMPORT","XKUNNR",$kunnr),
				array("IMPORT","XSALESORG",$sales_org),
				array("IMPORT","XDIS_CHANNEL",$dis_channel),
				array("IMPORT","XDIVISION",$division),
				array("EXPORT","XMEMBER", array()),
				array("TABLE","XKNA1",array()),
				array("TABLE","XKNB1",array()),
				array("TABLE","XKNVV",array())
			     )
			); 	
		//echo $this->saprfc->printStatus();
		//echo $this->saprfc->getStatus();
		$this->saprfc->logoff();
		$member = $data['content']["XMEMBER"];
		//echo "<pre>";
		//print_r($data['content']["XKNVV"]);
		//echo "</pre>";
		
		foreach($data['content']["XKNA1"] as $a){
			$xkunnr = $a['KUNNR'];
			$LAND1 = $a['LAND1'];
			$NAME1 = $a['NAME1'];
			$NAME2 = $a['NAME2'];
			$ORT01 = $a['ORT01'];
			$PSTLZ = $a['PSTLZ'];
			$REGIO = $a['REGIO'];
			$SORTL = $a['SORTL'];
			$STRAS = $a['STRAS'];
			$TELF1 = $a['TELF1'];
			$TELFX = $a['TELFX'];
			$MCOD1 = $a['MCOD1'];
			$MCOD2 = $a['MCOD2'];
			$ANRED = $a['ANRED'];
			$BRSCH = $a['BRSCH'];
			$KTOKD = $a['KTOKD'];
			$KUKLA = $a['KUKLA'];
			$NIELS = $a['NIELS'];
			$STCEG = $a['STCEG'];
			$TELF2 = $a['TELF2'];
			$BRAN1 = $a['BRAN1'];
		}
		
		
		foreach($data['content']["XKNB1"] as $b){
			$company_code=$b['BUKRS'];
			$top=$b['ZTERM'];
			$recon=$b['AKONT'];
			$short_key=$b['ZUAWA'];
		}
		
		foreach($data['content']["XKNVV"] as $c){
			$KUNNR = $c['KUNNR'];
			$VKORG = $c['VKORG'];
			$VTWEG = $c['VTWEG'];
			$SPART = $c['SPART'];
			$KDGRP = $c['KDGRP'];
			$INCO1 = $c['INCO1'];
			$INCO2 = $c['INCO2'];
			$WAERS = $c['WAERS'];
			$ZTERM = $c['ZTERM'];
			$VKBUR = $c['VKBUR'];
			$VKGRP = $c['VKGRP'];
			$KALKS = $c['KALKS'];
			$VERSG = $c['VERSG'];
			$KTGRD = $c['KTGRD'];
			$PODKZ = $c['PODKZ'];
			$AWAHR = $c['AWAHR'];
		}
		
		if($xkunnr == ""){
			
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Customer not found !</div>');
			$url="customer/form_edit_cust_req1";
			redirect($url);
		}else{
			if($company_code == ""){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Customer not found !</div>');
				$url="customer/form_edit_cust_req1";
				redirect($url);
			}
			if($VKORG == ""){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Customer not found !</div>');
				$url="customer/form_edit_cust_req1";
				redirect($url);
			}
			
			if($VTWEG == ""){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Customer not found !</div>');
				$url="customer/form_edit_cust_req1";
				redirect($url);
			}
			if($SPART == ""){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Customer not found !</div>');
				$url="customer/form_edit_cust_req1";
				redirect($url);
			}
			
			$data_company=$this->sap_model->getCompanyCode();
			$data_industry=$this->sap_model->getIndustry();
			$data_customer_class=$this->sap_model->getCustomerClass();
			$data_top=$this->sap_model->getTOP();
			$data_customer_group=$this->sap_model->getCustomerGroup();
			$data_incoterm=$this->sap_model->getIncoterm();
			$data_nielsen=$this->sap_model->getNielsen();
			$data_dis_channel=$this->sap_model->getDistributionChannel();
			$data_division=$this->sap_model->getDivision();
			$data_sales_org=$this->sap_model->getSalesOrganization();
			$data_region=$this->sap_model->getRegion($LAND1);
			$data_sales_office=$this->sap_model->getSalesOffice();
			$data_account_group=$this->sap_model->getAccountGroup();
			$data_recon_account=$this->sap_model->getReconAccount();
			
			if($NIELS <> ""){
				$data['xallowpos']="1";
			}else{
				$data['xallowpos']="0";
			}
			
			
			
			
			//$hp = $this->get_no_hp($kunnr);
			$this->load->library('saprfc');	
			$this->load->library('sapauth');		
			$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
			//Cek Connection SAP Status	
			$data['content']=$this->saprfc->callFunction("BAPI_ADDRESSORG_GETDETAIL",
				array(	array("IMPORT","OBJ_TYPE","KNA1"),
					array("IMPORT","OBJ_ID",$kunnr),
					array("IMPORT","OBJ_ID_EXT",""),
					array("IMPORT","CONTEXT","0001"),
					array("IMPORT","IV_CURRENT_COMM_DATA","X"),
					array("TABLE","BAPIAD1VL",array()),
					array("TABLE","BAPIADTEL",array()),
					array("TABLE","BAPIADFAX",array()),
					array("TABLE","BAPIADSMTP", array()),      
					array("TABLE","BAPIAD_REM", array())
				     )
				); 	
			$jmlT = count($data['content']["BAPIADTEL"]);
			$hp = "";
			$con_hp = "999";
			$tlp = "";
			$con_tlp = "999";
			$this->saprfc->logoff();
			if($jmlT > 0){
				foreach($data['content']["BAPIADTEL"] as $a){
					$cnt1 = $a['R_3_USER'];
					if($a['STD_RECIP'] == "X" && $a['R_3_USER'] == "3"){
						$hp = $a['TELEPHONE'];
						$con_hp = $a['CONSNUMBER'];
					}
					
					if($a['STD_RECIP'] <> "X" && $a['R_3_USER'] == "1"){
						$tlp = $a['TELEPHONE'];
						$con_tlp = $a['CONSNUMBER'];
					}
				}
			}else{
				$tlp = "";
				$con_tlp = "999";
				$hp="";
				$con_hp = "999";
			}
			
			$jmlT = count($data['content']["BAPIAD1VL"]);
			$address1 = "";
			$address2 = "";
			$address3 = "";
			$address4 = "";
			if($jmlT > 0){
				foreach($data['content']["BAPIAD1VL"] as $b){
					$address1 = $b['STREET'];
					$address2 = $b['STR_SUPPL1'];
					$address3 = $b['STR_SUPPL2'];
					$address4 = $b['STR_SUPPL3'];
				}
			}else{
				$address1 = "";
				$address2 = "";
				$address3 = "";
				$address4 = "";
			}
			
			$jmlF = count($data['content']["BAPIADFAX"]);
			$fax = "";
			$con_fax = "999";
			if($jmlF > 0){
				foreach($data['content']["BAPIADFAX"] as $f){
					if($f['STD_NO'] == "X"){
						$fax = $f['FAX'];
						$con_fax = $f['CONSNUMBER'];
					}
				}
			}else{
				$fax = "";
				$con_fax = "999";
			}
			//echo "<pre>";
			//print_r($data['content']["BAPIADSMTP"]);
			//echo "</pre>";
			
			$jmlE = count($data['content']["BAPIADSMTP"]);
			$email = "";
			$con_email = "999";
			if($jmlE > 0){
				foreach($data['content']["BAPIADSMTP"] as $e){
					if($e['STD_NO'] == "X"){
						$email = $e['E_MAIL'];
						$con_email= $e['CONSNUMBER'];
					}
					
				}
			}else{
				$email = "";
				$con_email = "999";
			}
			
			$jmlM = count($data['content']["BAPIAD_REM"]);
			$member = "";
			if($jmlM > 0){
				foreach($data['content']["BAPIAD_REM"] as $m){
					$member = $m['ADR_NOTES'];
				}
			}else{
				$member = "";
			}
		
			$data['xkunnr']=$kunnr;
			$data['xcompany_code']=$company_code;
			$data['xaccount_group']=$KTOKD;
			$data['xrecon_account']=$recon;
			$data['xdis_channel']=$VTWEG;
			$data['xdivision']=$SPART;
			$data['xc']=substr($company_code,0,1);
			
			$data['xtitle']=$ANRED;
			$data['xname1']=$NAME1;
			$data['xname2']=$NAME2;
			$data['xnickname']=$SORTL;
			$data['xsearch1']=$MCOD1;
			$data['xsearch2']=$MCOD2;
			
			$data['xaddress']=$address1;
			$data['xaddress2']=$address2;
			$data['xaddress3']=$address3;
			$data['xaddress4']=$address4;
			
			$data['xcountry']=$LAND1;
			$data['xregion']=$REGIO;
			$data['xcity']=$ORT01;
			$data['xpostal_code']=$PSTLZ;
			
			$data['xtlp']=$tlp;
			$data['xfax']=$fax;
			$data['xhp']=$hp;
			$data['xemail']=$email;
			
			$data['xcon_tlp']=$con_tlp;
			$data['xcon_hp']=$con_hp;
			$data['xcon_fax']=$con_fax;
			$data['xcon_email']=$con_email;
			$data['xmember_card']=$member;
			
			$data['xnielsen']=$NIELS;
			$data['xindustry']=$BRSCH;
			$data['xcustomer_class']=$KUKLA;
			$data['xvat']=$STCEG;
			$data['xtop']=$top;
			$data['xsales_office']=$VKBUR;
			$data['xcust_group']=$KDGRP;
			$data['xcurr']=$WAERS;
			$data['xinco1']=$INCO1;
			$data['xinco2']=$INCO2;
			$data['xsales_org']=$VKORG;
			$data['xshort_key']=$short_key;
			$data['xindustry_code1']=$BRAN1;
			$data['xsales_group']=$VKGRP;
			$data['xcust_price']=$KALKS;
			$data['xcust_stat']=$VERSG;
			$data['xaccount_ass']=$KTGRD;
			$data['xrelevan']=$PODKZ;
			$data['xorder_prob']=$AWAHR;
			
			$data['company']=$this->sap_model->getCompanyCode();
			$data['country']=$this->sap_model->getCountry();
			$data['industry']=$this->sap_model->getIndustry();
			$data['customer_class']=$this->sap_model->getCustomerClass();
			$data['top']=$this->sap_model->getTOP();
			$data['sales_office']=$this->sap_model->getSalesOffice();
			$data['customer_group']=$this->sap_model->getCustomerGroup();
			$data['currency']=$this->sap_model->getCurrency();
			$data['incoterm']=$this->sap_model->getIncoterm();
			$data['departemen']=$this->sap_model->getDepartemen();
			$data['function']=$this->sap_model->getFunction();
			$data['nielsen']=$this->sap_model->getNielsen();
			$data['dis_channel']=$this->sap_model->getDistributionChannel();
			$data['division']=$this->sap_model->getDivision();
			$data['sales_org']=$this->sap_model->getSalesOrganization();
			$data['region_select']=$this->sap_model->getRegion($LAND1);
			$data['industry_code']=$this->sap_model->getIndustryCode();
			$data['account_group']=$data_account_group;
			$data['recon_account']=$data_recon_account;
			
			
			//--------------------------CONTACT PERSON ----------------------------//
			//$this->load->library('saprfc');	
			//$this->load->library('sapauth');		
			//
			//$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
			////Cek Connection SAP Status	
			//$data['content']=$this->saprfc->callFunction("ZBAPI_CUST_GETCONTACTPERSON",
			//	array(	array("IMPORT","XKUNNR",$kunnr),
			//		array("TABLE","XKNVK",array())
			//	     )
			//	); 	
			////echo $this->saprfc->printStatus();
			////echo $this->saprfc->getStatus();
			//$this->saprfc->logoff();
			//$jmlCP = count($data['content']["XKNVK"]);
			//if($jmlCP > 0){
			//	foreach($data['content']["XKNVK"] as $cpdata){
			//		$cp_parnr = $cpdata['PARNR'];
			//		$cp_firstname = $cpdata['NAMEV'];
			//		$cp_lastname =  $cpdata['NAME1'];
			//		$cp_tlp =  $cpdata['TELF1'];
			//		
			//		$cp_departemen =  $cpdata['ABTNR'];
			//		$cp_function = $cpdata['PAFKT'];
			//		$cp_title = $cpdata['ANRED'];
			//		$cp_gender = $cpdata['PARGE'];
			//		$cp_call = $cpdata['BRYTH'];
			//		$cp_tgl_lahir =$cpdata['GBDAT'];
			//		$cp_tgl_register = $cpdata['PARAU'];
			//		
			//		//Get Tlp, Ext, no HP, fax, email
			//		$this->load->library('saprfc');	
			//		$this->load->library('sapauth');		
			//		
			//		$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
			//		//Cek Connection SAP Status	
			//		$data['content']=$this->saprfc->callFunction("BAPI_ADDRESSCONTPART_GETDETAIL",
			//			array(	array("IMPORT","OBJ_TYPE_P","BUS1006001"),
			//				array("IMPORT","OBJ_ID_P",$cp_parnr),
			//				array("IMPORT","OBJ_TYPE_C","KNA1"),
			//				array("IMPORT","OBJ_ID_C",$kunnr),
			//			
			//				array("IMPORT","CONTEXT","0005"),
			//				array("IMPORT","IV_CURRENT_COMM_DATA","X"),
			//				array("TABLE","BAPIAD3VL",array()),
			//				array("TABLE","BAPIADTEL",array()),
			//				array("TABLE","BAPIADFAX",array()),
			//				array("TABLE","BAPIADSMTP",array())
			//			     )
			//			); 	
			//		$this->saprfc->logoff();
			//		//-----------tlp & hp---------------------
			//		$jmlbaiatel=count($data['content']['BAPIADTEL']);
			//		$cp_tlp = "";
			//		$cp_hp = "";
			//		$cp_ext = "";
			//		if($jmlbaiatel > 0){
			//			foreach($data['content']["BAPIADTEL"] as $atel){
			//				$cnt1_cp = $atel['R_3_USER'];
			//				if($atel['STD_RECIP'] == "X" && $atel['R_3_USER'] == "3"){
			//					$cp_hp = $atel['TELEPHONE'];
			//					
			//				}
			//				
			//				if($atel['STD_RECIP'] <> "X" && $atel['R_3_USER'] == "1"){
			//					$cp_tlp = $atel['TELEPHONE'];
			//					$cp_ext = $atel['EXTENSION'];
			//				}
			//			}
			//		}
			//		//-----------  F A X ---------------------
			//		$jmlFAXCP = count($data['content']["BAPIADFAX"]);
			//		$cp_fax = "";
			//		if($jmlFAXCP > 0){
			//			foreach($data['content']["BAPIADFAX"] as $faxxx){
			//				if($faxxx['STD_NO'] == "X"){
			//					$cp_fax = $faxxx['FAX'];
			//				}
			//			}
			//		}
			//		//--------------- EMAIL -------------------------
			//		
			//		$jmlEmailCP = count($data['content']["BAPIADSMTP"]);
			//		$cp_email = "";
			//		if($jmlEmailCP > 0){
			//			foreach($data['content']["BAPIADSMTP"] as $emailCPP){
			//				if($emailCPP['STD_NO'] == "X"){
			//					$cp_email = $emailCPP['E_MAIL'];
			//				}
			//			}
			//		}
			//		
			//		$seskode = $this->session->userdata('seskode');
			//		
			//		$id_cp_edit = $this->oci_model->nextIDCP_EDIT('ID_CP_TEMP', 'TEMP_CP_EDIT',FALSE);
			//		$fieldH='ID_CP_TEMP, TITLE_CP, FIRSTNAME_CP, NAME_CP, TLP_CP, EXT_CP, HP_CP, FAX_CP, EMAIL_CP, DEPARTMENT, FUNC, SESKODE, GENDER, TGL_LAHIR, CALL_REQ, DATE_REGISTER, PARNR, KUNNR, ST';
			//		$valH= "'".$id_cp_edit."','".trim($cp_title)."', '".trim($cp_firstname)."', '".trim($cp_lastname)."', '".trim($cp_tlp)."', '".trim($cp_ext)."', '".trim($cp_hp)."', '".trim($cp_fax)."' , '".trim($cp_email)."', '".trim($cp_departemen)."',  '".trim($cp_function)."', '".trim($seskode)."' , '".trim($cp_gender)."', '".trim($cp_tgl_lahir)."', '".trim($cp_call)."', '".trim($cp_tgl_register)."', '".trim($cp_parnr)."', '".trim($kunnr)."', '0'";
			//		$exec=$this->oci_model->Exec($fieldH, $valH, 'TEMP_CP_EDIT', FALSE, 'insert');
			//	
			//	}
			//
			//}
			//
			//$seskode=$this->session->userdata('seskode');
			//$fieldCP="*";
			//$kondisiCP="SESKODE = '$seskode' AND KUNNR='".$kunnr."'";
			//$data['contact_person']=$this->oci_model->select($fieldCP, "TEMP_CP_EDIT", $kondisiCP);
			//--------------------------END CONTACT PERSON ------------------------//
			
			$data['main_content']="customer/form_edit_cust_req2";
			$this->load->view('template/main',$data);	
		}
		
	}
	
	function add_edit_customer_req(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		//General
		$id_edit=$this->oci_model->nextIDCP('ID_EDIT', 'T_CUST_EDIT',FALSE);
		//echo $id_cust;
		$kunnr=$this->input->post('cust_account');
		$country=$this->input->post('country');
		$name1=$this->input->post('name1');
		$name2=$this->input->post('name2');
		$city=$this->input->post('city');
		$postalcode=$this->input->post('postalcode');
		$region=$this->input->post('region_h');
		$sotl=substr($name1, 0, 9);
		$tlp1=$this->input->post('tlp');
		$tlp2=$this->input->post('hp');
		$fax=$this->input->post('fax');
		$address=$this->input->post('address');
		$address2=$this->input->post('address2');
		$address3=$this->input->post('address3');
		$address4=$this->input->post('address4');
		$search1=$this->input->post('search1');
		$search2=$this->input->post('search2');
		$title=$this->input->post('title');
		$allowpos=$this->input->post('ck1_h');
		$nielsen_id=$this->input->post('nielsen');
		$member_card=$this->input->post('membercard');
		$vatnum=$this->input->post('vat');
		$email=$this->input->post('email');
		$industry_key=$this->input->post('industry');
		$recon_account=$this->input->post('recon_account');
		$account_group=$this->input->post('account_group');
		
		$con_tlp = $this->input->post('con_tlp');
		$con_hp = $this->input->post('con_hp');
		$con_fax = $this->input->post('con_fax');
		$con_email = $this->input->post('con_email');
		
		$industry_code1=$this->input->post('industry_code');
		$short_key=$this->input->post('short_key');
		$sales_group=$this->input->post('sales_group');
		$cust_price=$this->input->post('cust_price');
		$cust_stat=$this->input->post('cust_stat');
		$relevan=$this->input->post('relevan');
		$account_ass=$this->input->post('account_ass');
		$order_prob=$this->input->post('order_prob');
		
		
		
		$user_cr=$this->session->userdata('NIK');
		$st_send="0";
		$st="1";
		$subject=$this->input->post('subject');
		
		$customer_class=$this->input->post('customer_class');
		$seskode=$this->session->userdata('seskode');
		
		if($allowpos == '0'){
			$nielsen_id ="";
		}
		
		if($allowpos == "1"){
			if($nielsen_id == ""){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Failed, Please input Nielsen ID if allow data at POS!</div>');
				$url="customer/form_edit_cust_req1";
				redirect($url);
			}
			if($member_card == ""){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Failed, Please input Member Card if allow data at POS!</div>');
				$url="customer/form_edit_cust_req1";
				redirect($url);
			}
			if($industry_key == ""){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Failed, Please input Industry Key if allow data at POS!</div>');
				$url="customer/form_edit_cust_req1";
				redirect($url);
			}if($customer_class == ""){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Failed, Please input Customer Class if allow data at POS!</div>');
				$url="customer/form_edit_cust_req1";
				redirect($url);
			}
			if($industry_code1 == ""){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Failed, Please input Industry Code 1 if allow data at POS!</div>');
				$url="customer/form_edit_cust_req1";
				redirect($url);
			}
			
		}
		
		//Basic Data
		$company=$this->input->post('company');
		$sales_org=$this->input->post('sales_org');
		$dis_channel=$this->input->post('dis_channel');
		$division=$this->input->post('division');
		
		//Sales Area Data
		$top=$this->input->post('top');
		$sales_office=$this->input->post('sales_office');
		$cust_group=$this->input->post('customer_group');
		$currency=$this->input->post('currency');
		$inco1=$this->input->post('incoterm');
		$inco2=$this->input->post('deskripsi');
		
		$nik=$this->session->userdata('NIK');
		$stHak=$this->oci_model->cek_hak_akses($nik, $sales_org, $dis_channel, $division);
		if($stHak < 1){
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Sorry you do not have access, please contact the administrator !</div>');
			$url="customer/form_edit_cust_req1";
			redirect($url);
		}
		//$stBasic=$this->oci_model->cek_data_basic($company_code, $sales_org, $dis_channel, $division);
		//if($stBasic <> "1"){
		//	$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
		//		<h4 class="alert-heading">Error!</h4>
		//		Failed to insert Customer! Please Check Company Code, Sales Organization, Distribution Channel and Division.</div>');
		//	$url="customer/form_cust";
		//	redirect($url);
		//}
		date_default_timezone_set('Asia/Jakarta');
                $tgl=date("Y-m-d");
		
		//Insert 
		$field="ID_EDIT, CUST_ACCOUNT, COUNTRY_KEY, NAME1, NAME2, CITY, POSTAL_CODE, REGION, SHORT_FIELD, TLP1, TLP2, FAX, ADDRESS, SEARCH_TERM1, SEARCH_TERM2, TITLE_CP, ALLOW_POS, NIELSEN_ID, MEMBER_CARD, VATNUM, EMAIL, INDUSTRY_KEY, ACCOUNT_GROUP, USER_CR, RECONT_ACCOUNT, COMPANY_CODE, SALES_ORG, DIS_CHANNEL, DIVISION, CUST_GROUP, INCO1, INCO2, CURR, TOP, SALES_OFFICE, ST_SEND, ST, TGL, CUST_CLASS, SUBJECT, ADDRESS2, ADDRESS3, DATE_MODIF, NIK_MODIF, INDUSTRY_CODE1, SHORT_KEY, SALES_GROUP, CUST_PRICE, CUST_STAT, RELEVAN_POD, ACCOUNT_ASS, ORDER_PROB, ADDRESS4, CON_TLP, CON_HP, CON_FAX, CON_EMAIL";
		$value="'".$id_edit."', '".$kunnr."','".$country."','".$name1."', '".$name2."', '".$city."', '".$postalcode."', '".$region."', '".$sotl."', '".$tlp1."', '".$tlp2."', '".$fax."', '".$address."', '".$search1."', '".$search2."', '".$title."', '".$allowpos."', '".$nielsen_id."', '".$member_card."', '".$vatnum."', '".$email."', '".$industry_key."', '".$account_group."','".$user_cr."', '".$recon_account."', '".$company."', '".$sales_org."', '".$dis_channel."', '".$division."', '".$cust_group."', '".$inco1."', '".$inco2."', '".$currency."', '".$top."', '".$sales_office."','".$st_send."', '".$st."', TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI'), '".$customer_class."', '".$subject."', '".$address2."', '".$address3."', TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI'), '".$user_cr."', '".$industry_code1."', '".$short_key."', '".$sales_group."', '".$cust_price."', '".$cust_stat."', '".$relevan."', '".$account_ass."', '".$order_prob."', '".$address4."', '".$con_tlp."', '".$con_hp."', '".$con_fax."', '".$con_email."'";
		$exec=$this->oci_model->Exec($field, $value, 'T_CUST_EDIT', FALSE, 'insert');
		
		if($exec <= 0){
		    $this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Failed to insert Customer Edit Request!</div>');
			$url="customer/form_edit_cust_req1";
			redirect($url);
		}else{
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Customer Edit Request Saved! </div>');
			    redirect(site_url('customer/list_cust_edit'));
		}
	}
	
	function list_cust_edit(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->my_auth->hak_akses("REQUESTER");
		
		$this->load->model('oci_model');
		$usr=$this->session->userdata('NIK');
		
		$nik=$this->session->userdata('NIK');
		if(strpos($this->session->userdata('role'),'ADMINISTRATOR') !== false){
			$field="ID_EDIT,CUST_ACCOUNT,COUNTRY_KEY,NAME1,NAME2,CITY,
				POSTAL_CODE,REGION,SHORT_FIELD,TLP1,TLP2,FAX,ADDRESS,
				SEARCH_TERM1,SEARCH_TERM2,TITLE_CP,ALLOW_POS,NIELSEN_ID,
				MEMBER_CARD,VATNUM,EMAIL,INDUSTRY_KEY,ACCOUNT_GROUP,
				USER_CR,AUTH_GROUP,RECONT_ACCOUNT,COMPANY_CODE,SALES_ORG,
				DIS_CHANNEL,DIVISION,CUST_GROUP,INCO1,INCO2,CURR,TOP,SALES_OFFICE,
				ST_SEND,ST,TGL,REASONREJECT,DATE_POSTING,DATE_APPROVED,NIK_APPROVED,
				DATE_IS,NIK_IS,DATE_DELETE,CUST_CLASS,SUBJECT,ADDRESS2,
				ADDRESS3,DATE_MODIF,NIK_MODIF,NEW_ST,INDUSTRY_CODE1,SHORT_KEY,
				SALES_GROUP,CUST_PRICE,CUST_STAT,RELEVAN_POD,
				ACCOUNT_ASS,ORDER_PROB,ADDRESS4,CON_TLP,CON_HP,
				CON_FAX,CON_EMAIL,
				DEV_USERS.GET_NAME_BY_NIK(USER_CR) AS NAME_CREATE";
			$kondisi="ST = '1' ORDER BY ID_EDIT DESC";
			$data['row']=$this->oci_model->select($field, 'VW_CUST_EDIT',$kondisi);
		}else{
			$field="ID_EDIT,CUST_ACCOUNT,COUNTRY_KEY,NAME1,NAME2,CITY,
				POSTAL_CODE,REGION,SHORT_FIELD,TLP1,TLP2,FAX,ADDRESS,
				SEARCH_TERM1,SEARCH_TERM2,TITLE_CP,ALLOW_POS,NIELSEN_ID,
				MEMBER_CARD,VATNUM,EMAIL,INDUSTRY_KEY,ACCOUNT_GROUP,
				USER_CR,AUTH_GROUP,RECONT_ACCOUNT,COMPANY_CODE,SALES_ORG,
				DIS_CHANNEL,DIVISION,CUST_GROUP,INCO1,INCO2,CURR,TOP,SALES_OFFICE,
				ST_SEND,ST,TGL,REASONREJECT,DATE_POSTING,DATE_APPROVED,NIK_APPROVED,
				DATE_IS,NIK_IS,DATE_DELETE,CUST_CLASS,SUBJECT,ADDRESS2,
				ADDRESS3,DATE_MODIF,NIK_MODIF,NEW_ST,INDUSTRY_CODE1,SHORT_KEY,
				SALES_GROUP,CUST_PRICE,CUST_STAT,RELEVAN_POD,
				ACCOUNT_ASS,ORDER_PROB,ADDRESS4,CON_TLP,CON_HP,
				CON_FAX,CON_EMAIL,
				DEV_USERS.GET_NAME_BY_NIK(USER_CR) AS NAME_CREATE";
			$kondisi="ST = '1' AND USER_CR = '".$nik."' ORDER BY ID_EDIT DESC";
			$data['row']=$this->oci_model->select($field, 'VW_CUST_EDIT',$kondisi);
		}
		
		$data['main_content']="customer/list_cust_edit_req";
		$this->load->view('template/main',$data);	
	}
	
	function posting_cust_edit(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$id=$this->input->post('id');
		
		$field="ST_SEND = '1', DATE_POSTING = TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI')";
		$kondisi="ID_EDIT = '".$id."'";
		$exec=$this->oci_model->Exec($field, false, 'T_CUST_EDIT', $kondisi, 'update');
		
		
		$sales_org = $this->input->post('company');
		$dis_channel = $this->input->post('dis_channel');
		$division = $this->input->post('division');
		
		$fieldU="DISTINCT(NIK), DEV_USERS.GET_NAME_BY_NIK(NIK) as NAMA, DEV_USERS.GET_EMAIL_BY_NIK(NIK) AS EMAIL";
		$kondisiU="SALES_ORG='".$sales_org."' AND DIS_CHANNEL='".$dis_channel."' AND DIVISION='".$division."' AND NIK IN (SELECT NIK FROM M_CUST_ROLE WHERE (ROLE='APPROVAL' OR ROLE='ADMINISTRATOR'))";
		$listNIK=$this->oci_model->select($fieldU, 'M_CUST_PRIVILEGE',$kondisiU);
		
		$jml=count($listNIK);
		if($jml > 0){
			foreach($listNIK as $a){
				$nik=$a['NIK'];
				$email = $a['EMAIL'];
				$nama = $a['NAMA'];
				if($email <> ""){
					$this->send_mail($email, "REQUEST APPROVAL CHANGE CUSTOMER", "requestor", "edit", $nama, $id);
				}
			}
		}
		
		
		if($exec == 1){
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Posting EDIT Customer Request Success. Waiting for approval.</div>');
		}
	}
	
	function unposting_cust_edit(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$id=$this->input->post('id');
		
		$st=$this->oci_model->getStatusEditCustomer($id);
		
		if($st == "1"){
			$field="ST_SEND = '0', DATE_POSTING = ''";
			$kondisi="ID_EDIT = '".$id."'";
			$exec=$this->oci_model->Exec($field, false, 'T_CUST_EDIT', $kondisi, 'update');
			
			if($exec == 1){
				$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Success!</h4>
					 Unposting Edit Customer Request Success</div>');
			}
		}else{
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					 Unposting failed, status edit customer not "Posting".</div>');
		}
	}
	
	function del_cust_edit(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$id=$this->input->post('id');
		
		$st=$this->oci_model->getStatusEditCustomer($id);
		if($st == "0"){
			$field="ST = '0', DATE_DELETE = TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI')";
			$kondisi="ID_EDIT = '".$id."'";
			$exec=$this->oci_model->Exec($field, false, 'T_CUST_EDIT', $kondisi, 'update');
			
			if($exec == 1){
				$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Success!</h4>
					 Delete edit customer request success</div>');
			}
		}else{
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					 Failed to delete edit customer, edit customer status is not "Open".</div>');
		}
	}
	
	function view_cust_edit(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$id_edit=$this->uri->segment(3);
		
		$field="*";
		$kondisi="ID_EDIT = '".$id_edit."'";
		$DataEdit=$this->oci_model->select($field, 'VW_CUST_EDIT',$kondisi);
		
		foreach($DataEdit as $kna){
			
			$company_code=$kna['COMPANY_CODE'];
			$cust_account=$kna['CUST_ACCOUNT'];
			$country_key=$kna['COUNTRY_KEY'];
			$name1=$kna['NAME1'];
			$name2=$kna['NAME2'];
			$city=$kna['CITY'];
			$postal_code=$kna['POSTAL_CODE'];
			$region=$kna['REGION'];
			$short_field=$kna['SHORT_FIELD'];
			$tlp1=$kna['TLP1'];
			$tlp2=$kna['TLP2'];
			$fax=$kna['FAX'];
			$address=$kna['ADDRESS'];
			$address2=$kna['ADDRESS2'];
			$address3=$kna['ADDRESS3'];
			$address4=$kna['ADDRESS4'];
			$search1=$kna['SEARCH_TERM1'];
			$search2=$kna['SEARCH_TERM2'];
			$title=$kna['TITLE_CP'];
			$allowpos=$kna['ALLOW_POS'];
			$nielsen=$kna['NIELSEN_ID'];
			$member_card=$kna['MEMBER_CARD'];
			$vatnum=$kna['VATNUM'];
			$email=$kna['EMAIL'];
			$industry_key=$kna['INDUSTRY_KEY'];
			$account_group=$kna['ACCOUNT_GROUP'];
			$user=$kna['USER_CR'];
			$auth_group=$kna['AUTH_GROUP'];
			$st_send=$kna['ST_SEND'];
			$new_st=$kna['NEW_ST'];
			$st=$kna['ST'];
			$tgl=$kna['TGL'];
			$reasonreject=$kna['REASONREJECT'];
			$date_posting=$kna['DATE_POSTING'];
			$date_approved=$kna['DATE_APPROVED'];
			$date_is=$kna['DATE_IS'];
			$date_delete=$kna['DATE_DELETE'];
			$nik_approved=$kna['NIK_APPROVED'];
			$nik_is=$kna['NIK_IS'];
			$cust_class=$kna['CUST_CLASS'];
			$subject=$kna['SUBJECT'];
			$date_modif=$kna['DATE_MODIF'];
			$nik_modif=$kna['NIK_MODIF'];
			$sales_org=$kna['SALES_ORG'];
			$dis_channel=$kna['DIS_CHANNEL'];
			$division=$kna['DIVISION'];
			$recon_account=$kna['RECONT_ACCOUNT'];
			$account_group=$kna['ACCOUNT_GROUP'];
			$top=$kna['TOP'];
			$sales_office=$kna['SALES_OFFICE'];
			$cust_group=$kna['CUST_GROUP'];
			$currency=$kna['CURR'];
			$inco1=$kna['INCO1'];
			$inco2=$kna['INCO2'];
			$st=$kna['ST'];
		}
		
		
		//Get Data Name
		$this->load->model('sap_model');
		$data_company=$this->sap_model->getCompanyCode();
		$data_industry=$this->sap_model->getIndustry();
		$data_customer_class=$this->sap_model->getCustomerClass();
		$data_top=$this->sap_model->getTOP();
		$data_customer_group=$this->sap_model->getCustomerGroup();
		$data_incoterm=$this->sap_model->getIncoterm();
		$data_nielsen=$this->sap_model->getNielsen();
		$data_dis_channel=$this->sap_model->getDistributionChannel();
		$data_division=$this->sap_model->getDivision();
		$data_sales_org=$this->sap_model->getSalesOrganization();
		$data_region=$this->sap_model->getRegion($country_key);
		$data_sales_office=$this->sap_model->getSalesOffice();
		$data_account_group=$this->sap_model->getAccountGroup();
		$data_recon_account=$this->sap_model->getReconAccount();
		
		$data['txt_company']="";
		$data['txt_dischannel']="";
		$data['txt_division']="";
		$data['txt_region']="";
		$data['txt_region']="";
		$data['txt_nielsen']="";
		$data['txt_industry']="";
		$data['txt_custclass']="";
		$data['txt_top']="";
		$data['txt_salesoffice']="";
		$data['txt_inco1']="";
		$data['txt_account_group']="";
		$data['txt_recon']="";
		$data['txt_cust_group']="";
		$data['txt_sales_org']="";
		
		foreach($data_company as $key1 => $com){
			if($key1 == 0 and $com['BUKRS'] == ''){
			continue;}
			if($com['BUKRS'] == $company_code && $com['LAND1'] == 'ID'){
				$data['txt_company']=$com['BUTXT'];
			}
		}
		foreach($data_dis_channel as $key2 => $dis){
			
			if($key2 == 0 and !isset($dis['VTWEG'])){
			continue;}
			if($dis['VTWEG'] == $dis_channel){
				$data['txt_dischannel']=$dis['VTEXT'];
			}
		}
		foreach($data_division as $key3 => $div){
			
			if($key3 == 0 and !isset($div['SPART'])){
			continue;}
			if($div['SPART'] == $division){
				$data['txt_division']=$div['VTEXT'];
			}
		}
		foreach($data_region as $key4 => $reg){
			
			if($key4 == 0 and !isset($reg['BLAND'])){
			continue;}
			if($reg['BLAND'] == $region){
				$data['txt_region']=$reg['BEZEI'];
			}
		}
		
		foreach($data_nielsen as $key5 => $nil){
			if($key5 == 0 and !isset($nil['NIELS'])){
			continue;}
			if($nil['NIELS'] == $nielsen){
				$data['txt_nielsen']=$nil['BEZEI'];
			}
		}
		
		foreach($data_industry as $key6 => $ind){
			if($key6 == 0 and !isset($ind['BRSCH'])){
			continue;}
			if($ind['BRSCH'] == $industry_key){
				$data['txt_industry']=$ind['BRTXT'];
			}
		}
		foreach($data_customer_class as $key7 => $cs){
			if($key7 == 0 and !isset($cs['KUKLA'])){
			continue;}
			if($cs['KUKLA'] == $cust_class){
				$data['txt_custclass']=$cs['VTEXT'];
			}
		}
		
		foreach($data_top as $key8 => $tp){
			if($key8 == 0 and !isset($tp['ZTERM'])){
			continue;}
			if($tp['ZTERM'] == $top){
				$data['txt_top']=$tp['VTEXT'];
			}
		}
		
		foreach($data_sales_office as $key9 => $sof){
			if($key9 == 0 and !isset($sof['VKBUR'])){
			continue;}
			if($sof['VKBUR'] == $sales_office){
				$data['txt_salesoffice']=$sof['BEZEI'];
			}
		}
		foreach($data_incoterm as $key10 => $inc){
			if($key10 == 0 and !isset($inc['INCO1'])){
			continue;}
			if($inc['INCO1'] == $inco1){
				$data['txt_inco1']=$inc['BEZEI'];
			}
		}
		foreach($data_account_group as $key11 => $accg){
			if($key11 == 0 and !isset($accg['KTOKD'])){
			continue;}
			if($accg['KTOKD'] == $account_group){
				$data['txt_account_group']=$accg['TXT30'];
			}
		}
		foreach($data_recon_account as $key12 => $reca){
			if($key12 == 0 and !isset($reca['SAKNR'])){
			continue;}
			if($reca['SAKNR'] == $recon_account){
				$data['txt_recon']=$reca['TXT50'];
			}
		}
		
		foreach($data_customer_group as $key13 => $cgp){
			if($key13 == 0 and !isset($cgp['KDGRP'])){
			continue;}
			if($cgp['KDGRP'] == $cust_group){
				$data['txt_cust_group']=$cgp['KTEXT'];
			}
		}
		
		foreach($data_sales_org as $key14 => $sor){
			if($key14 == 0 and !isset($sor['VKORG'])){
			continue;}
			if($sor['VKORG'] == $sales_org){
				$data['txt_sales_org']=$sor['VTEXT'];
			}
		}
		
		$data['kunnr']=$cust_account;
		$data['company_code']=$company_code;
		$data['account_group']=$account_group;
		$data['recon_account']=$recon_account;
		$data['dis_channel']=$dis_channel;
		$data['division']=$division;
		$data['title']=$title;
		$data['name1']=$name1;
		$data['name2']=$name2;
		$data['nickname']=$short_field;
		$data['search1']=$search1;
		$data['search2']=$search2;
		$data['address']=$address;
		$data['address2']=$address2;
		$data['address3']=$address3;
		$data['address4']=$address4;
		$data['country']=$country_key;
		$data['region']=$region;
		$data['city']=$city;
		$data['postal_code']=$postal_code;
		$data['tlp']=$tlp1;
		$data['fax']=$fax;
		$data['hp']=$tlp2;
		$data['email']=$email;
		$data['allowpos']=$allowpos;
		$data['subject']=$subject;
		if($allowpos == "1"){
			$data['nielsen']=$nielsen;
		}else{
			$data['nielsen']="";
			$data['txt_nielsen']="";
		}
		
		$data['member_card']=$member_card;
		$data['industry']=$industry_key;
		$data['customer_class']=$cust_class;
		$data['vat']=$vatnum;
		$data['top']=$top;
		$data['sales_office']=$sales_office;
		$data['cust_group']=$cust_group;
		$data['curr']=$currency;
		$data['inco1']=$inco1;
		$data['inco2']=$inco2;
		$data['tgl_create']=$tgl;
		$data['tgl_posting']=$date_posting;
		$data['user_create']=$user;
		$data['tgl_approved']=$date_approved;
		$data['user_approved']=$nik_approved;
		$data['tgl_is']=$date_is;
		$data['user_is']=$nik_is;
		$data['status']=$new_st;
		$data['sales_org']=$sales_org;
		$data['tgl_modif']=$date_modif;
		$data['nik_modif']=$nik_modif;
		$data['id_edit']=$id_edit;
		$data['st_send']=$st_send;
		$data['st']=$st;
		
		$data['customer_group']=$cust_group;
		$data['main_content']="customer/view_cust_edit";
		$this->load->view('template/main',$data);	
	}
	
	function form_edit_cust_req(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$id_edit=$this->uri->segment(3);
		
		$field="*";
		$kondisi="ID_EDIT = '".$id_edit."'";
		$DataEdit=$this->oci_model->select($field, 'VW_CUST_EDIT',$kondisi);
		
		foreach($DataEdit as $kna){
			$subject=$kna['SUBJECT'];
			$company_code=$kna['COMPANY_CODE'];
			$cust_account=$kna['CUST_ACCOUNT'];
			$country_key=$kna['COUNTRY_KEY'];
			$name1=$kna['NAME1'];
			$name2=$kna['NAME2'];
			$city=$kna['CITY'];
			$postal_code=$kna['POSTAL_CODE'];
			$region=$kna['REGION'];
			$short_field=$kna['SHORT_FIELD'];
			$tlp1=$kna['TLP1'];
			$tlp2=$kna['TLP2'];
			$fax=$kna['FAX'];
			$address=$kna['ADDRESS'];
			$address2=$kna['ADDRESS2'];
			$address3=$kna['ADDRESS3'];
			$address4=$kna['ADDRESS4'];
			$search1=$kna['SEARCH_TERM1'];
			$search2=$kna['SEARCH_TERM2'];
			$title=$kna['TITLE_CP'];
			$allowpos=$kna['ALLOW_POS'];
			$nielsen=$kna['NIELSEN_ID'];
			$member_card=$kna['MEMBER_CARD'];
			$vatnum=$kna['VATNUM'];
			$email=$kna['EMAIL'];
			$industry_key=$kna['INDUSTRY_KEY'];
			$account_group=$kna['ACCOUNT_GROUP'];
			$user=$kna['USER_CR'];
			$auth_group=$kna['AUTH_GROUP'];
			$st_send=$kna['ST_SEND'];
			$new_st=$kna['NEW_ST'];
			$st=$kna['ST'];
			$tgl=$kna['TGL'];
			$reasonreject=$kna['REASONREJECT'];
			$date_posting=$kna['DATE_POSTING'];
			$date_approved=$kna['DATE_APPROVED'];
			$date_is=$kna['DATE_IS'];
			$date_delete=$kna['DATE_DELETE'];
			$nik_approved=$kna['NIK_APPROVED'];
			$nik_is=$kna['NIK_IS'];
			$cust_class=$kna['CUST_CLASS'];
			$subject=$kna['SUBJECT'];
			$date_modif=$kna['DATE_MODIF'];
			$nik_modif=$kna['NIK_MODIF'];
			$sales_org=$kna['SALES_ORG'];
			$dis_channel=$kna['DIS_CHANNEL'];
			$division=$kna['DIVISION'];
			$recon_account=$kna['RECONT_ACCOUNT'];
			$account_group=$kna['ACCOUNT_GROUP'];
			$top=$kna['TOP'];
			$sales_office=$kna['SALES_OFFICE'];
			$cust_group=$kna['CUST_GROUP'];
			$currency=$kna['CURR'];
			$inco1=$kna['INCO1'];
			$inco2=$kna['INCO2'];
			$industry_code=$kna['INDUSTRY_CODE1'];
		}
		
		
		//Get Data Name
		$this->load->model('sap_model');
		$data_company=$this->sap_model->getCompanyCode();
		$data_industry=$this->sap_model->getIndustry();
		$data_customer_class=$this->sap_model->getCustomerClass();
		$data_top=$this->sap_model->getTOP();
		$data_customer_group=$this->sap_model->getCustomerGroup();
		$data_incoterm=$this->sap_model->getIncoterm();
		$data_nielsen=$this->sap_model->getNielsen();
		$data_dis_channel=$this->sap_model->getDistributionChannel();
		$data_division=$this->sap_model->getDivision();
		$data_sales_org=$this->sap_model->getSalesOrganization();
		$data_region=$this->sap_model->getRegion($country_key);
		$data_sales_office=$this->sap_model->getSalesOffice();
		$data_account_group=$this->sap_model->getAccountGroup();
		$data_recon_account=$this->sap_model->getReconAccount();
		
		$data['xid_edit']=$id_edit;
		$data['xkunnr']=$cust_account;
		$data['xcompany_code']=$company_code;
		$data['xaccount_group']=$account_group;
		$data['xrecon_account']=$recon_account;
		$data['xdis_channel']=$dis_channel;
		$data['xdivision']=$division;
		$data['xtitle']=$title;
		$data['xname1']=$name1;
		$data['xname2']=$name2;
		$data['xnickname']=$short_field;
		$data['xsearch1']=$search1;
		$data['xsearch2']=$search2;
		$data['xaddress']=$address;
		$data['xaddress2']=$address2;
		$data['xaddress3']=$address3;
		$data['xaddress4']=$address4;
		$data['xcountry']=$country_key;
		$data['xregion']=$region;
		$data['xcity']=$city;
		$data['xpostal_code']=$postal_code;
		$data['xtlp']=$tlp1;
		$data['xfax']=$fax;
		$data['xhp']=$tlp2;
		$data['xemail']=$email;
		$data['xallowpos']=$allowpos;
		$data['xsubject']=$subject;
		if($allowpos == "1"){
			$data['xnielsen']=$nielsen;
		}else{
			$data['xnielsen']="";
			$data['txt_nielsen']="";
		}
		
		$data['xmember_card']=$member_card;
		$data['xindustry']=$industry_key;
		$data['xcustomer_class']=$cust_class;
		$data['xvat']=$vatnum;
		$data['xtop']=$top;
		$data['xsales_office']=$sales_office;
		$data['xcust_group']=$cust_group;
		$data['xcurr']=$currency;
		$data['xinco1']=$inco1;
		$data['xinco2']=$inco2;
		$data['xtgl_create']=$tgl;
		$data['xtgl_posting']=$date_posting;
		$data['xuser_create']=$user;
		$data['xtgl_approved']=$date_approved;
		$data['xuser_approved']=$nik_approved;
		$data['xtgl_is']=$date_is;
		$data['xuser_is']=$nik_is;
		$data['xstatus']=$new_st;
		$data['xsales_org']=$sales_org;
		$data['xtgl_modif']=$date_modif;
		$data['xnik_modif']=$nik_modif;
		$data['xcustomer_group']=$cust_group;
		$data['xindustry_code1']=$industry_code;
		
		$data['company']=$this->sap_model->getCompanyCode();
		$data['country']=$this->sap_model->getCountry();
		$data['industry']=$this->sap_model->getIndustry();
		$data['customer_class']=$this->sap_model->getCustomerClass();
		$data['top']=$this->sap_model->getTOP();
		$data['sales_office']=$this->sap_model->getSalesOffice();
		$data['customer_group']=$this->sap_model->getCustomerGroup();
		$data['currency']=$this->sap_model->getCurrency();
		$data['incoterm']=$this->sap_model->getIncoterm();
		$data['departemen']=$this->sap_model->getDepartemen();
		$data['function']=$this->sap_model->getFunction();
		$data['nielsen']=$this->sap_model->getNielsen();
		$data['dis_channel']=$this->sap_model->getDistributionChannel();
		$data['division']=$this->sap_model->getDivision();
		$data['sales_org']=$this->sap_model->getSalesOrganization();
		$data['region_select']=$this->sap_model->getRegion($country_key);
		$data['industry_code']=$this->sap_model->getIndustryCode();
		$data['account_group']=$data_account_group;
		$data['recon_account']=$data_recon_account;
		$data['main_content']="customer/form_edit_cust_req_edit";
		$this->load->view('template/main',$data);
	}
	
	function edit_edit_customer_req(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$nik=$this->session->userdata('NIK');
		//General
		$id_edit=$this->input->post('id_edit');
		$kunnr=$this->input->post('cust_account');
		$country=$this->input->post('country');
		$name1=$this->input->post('name1');
		$name2=$this->input->post('name2');
		$city=$this->input->post('city');
		$postalcode=$this->input->post('postalcode');
		$region=$this->input->post('region_h');
		$sotl=substr($name1, 0, 9);
		$tlp1=$this->input->post('tlp');
		$tlp2=$this->input->post('hp');
		$fax=$this->input->post('fax');
		$address=$this->input->post('address');
		$address2=$this->input->post('address2');
		$address3=$this->input->post('address3');
		$address4=$this->input->post('address4');
		$search1=$this->input->post('search1');
		$search2=$this->input->post('search2');
		$title=$this->input->post('title');
		$allowpos=$this->input->post('ck1_h');
		$nielsen_id=$this->input->post('nielsen');
		$member_card=$this->input->post('membercard');
		$vatnum=$this->input->post('vat');
		$email=$this->input->post('email');
		$industry_key=$this->input->post('industry');
		$recon_account=$this->input->post('recon_account');
		$account_group=$this->input->post('account_group');
		$industry_code=$this->input->post('industry_code');
		
		$user_cr=$this->session->userdata('NIK');
		$st_send="0";
		$st="1";
		$subject=$this->input->post('subject');
		
		$customer_class=$this->input->post('customer_class');
		$seskode=$this->session->userdata('seskode');
		
		if($allowpos == '0'){
			$nielsen_id ="";
		}
		
		if($allowpos == "1"){
			if($nielsen_id == ""){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Failed, Please input Nielsen ID if allow data at POS!</div>');
				$url="customer/form_edit_cust_req1";
				redirect($url);
			}
			if($member_card == ""){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Failed, Please input Member Card if allow data at POS!</div>');
				$url="customer/form_edit_cust_req1";
				redirect($url);
			}
			if($industry_key == ""){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Failed, Please input Industry Key if allow data at POS!</div>');
				$url="customer/form_edit_cust_req1";
				redirect($url);
			}if($customer_class == ""){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Failed, Please input Customer Class if allow data at POS!</div>');
				$url="customer/form_edit_cust_req1";
				redirect($url);
			}
			if($industry_code == ""){
				$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Failed, Please input Industry Code 1 if allow data at POS!</div>');
				$url="customer/form_edit_cust_req1";
				redirect($url);
			}
			
		}
		
		
		//Basic Data
		$company=$this->input->post('company');
		$sales_org=$this->input->post('sales_org');
		$dis_channel=$this->input->post('dis_channel');
		$division=$this->input->post('division');
		
		//Sales Area Data
		$top=$this->input->post('top');
		$sales_office=$this->input->post('sales_office');
		$cust_group=$this->input->post('customer_group');
		$currency=$this->input->post('currency');
		$inco1=$this->input->post('incoterm');
		$inco2=$this->input->post('deskripsi');
		
		//update
		$fieldKNA1="SALES_OFFICE = '".$sales_office."', INDUSTRY_CODE1 = '".$industry_code."', COUNTRY_KEY = '".$country."', NAME1 = '".$name1."', NAME2 = '".$name2."', CITY = '".$city."', POSTAL_CODE = '".$postalcode."', REGION = '".$region."', SHORT_FIELD = '".$sotl."', TLP1 = '".$tlp1."', TLP2 = '".$tlp2."', FAX = '".$fax."', ADDRESS = '".$address."', SEARCH_TERM1 = '".$search1."', SEARCH_TERM2 = '".$search2."', TITLE_CP = '".$title."', ALLOW_POS = '".$allowpos."', NIELSEN_ID = '".$nielsen_id."', MEMBER_CARD = '".$member_card."', VATNUM = '".$vatnum."', EMAIL = '".$email."', INDUSTRY_KEY = '".$industry_key."', CUST_CLASS = '".$customer_class."', SUBJECT = '".$subject."', ADDRESS2 = '".$address2."', ADDRESS3 = '".$address3."', ADDRESS4 = '".$address4."' ,DATE_MODIF = TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI'), NIK_MODIF = '".$nik."', TOP = '".$top."', CUST_GROUP = '".$cust_group."', CURR = '".$currency."', INCO1 = '".$inco1."', INCO2 = '".$inco2."' ";
		$kondisiKNA1="ID_EDIT = '".$id_edit."'";
		$exec=$this->oci_model->Exec($fieldKNA1, FALSE, 'T_CUST_EDIT', $kondisiKNA1, 'update');
		
		if($exec <= 0){
		    $this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Failed to update Customer Edit Request!</div>');
			$url="customer/list_cust_edit";
			redirect($url);
		}else{
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Update data Customer Edit Request Saved! </div>');
			    redirect(site_url('customer/list_cust_edit'));
		}
	}
	
	function list_cust_approval_edit(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->my_auth->hak_akses("APPROVAL");
		
		$this->load->model('oci_model');
		$nik=$this->session->userdata('NIK');
		
		if(strpos($this->session->userdata('role'),'ADMINISTRATOR') !== false){
			$field="ID_EDIT,CUST_ACCOUNT,COUNTRY_KEY,NAME1,NAME2,CITY,
				POSTAL_CODE,REGION,SHORT_FIELD,TLP1,TLP2,FAX,ADDRESS,
				SEARCH_TERM1,SEARCH_TERM2,TITLE_CP,ALLOW_POS,NIELSEN_ID,
				MEMBER_CARD,VATNUM,EMAIL,INDUSTRY_KEY,ACCOUNT_GROUP,
				USER_CR,AUTH_GROUP,RECONT_ACCOUNT,COMPANY_CODE,SALES_ORG,
				DIS_CHANNEL,DIVISION,CUST_GROUP,INCO1,INCO2,CURR,TOP,SALES_OFFICE,
				ST_SEND,ST,TGL,REASONREJECT,DATE_POSTING,DATE_APPROVED,NIK_APPROVED,
				DATE_IS,NIK_IS,DATE_DELETE,CUST_CLASS,SUBJECT,ADDRESS2,
				ADDRESS3,DATE_MODIF,NIK_MODIF,NEW_ST,INDUSTRY_CODE1,SHORT_KEY,
				SALES_GROUP,CUST_PRICE,CUST_STAT,RELEVAN_POD,
				ACCOUNT_ASS,ORDER_PROB,ADDRESS4,CON_TLP,CON_HP,
				CON_FAX,CON_EMAIL,
				DEV_USERS.GET_NAME_BY_NIK(USER_CR) AS NAME_CREATE";
			$kondisi="(ST_SEND='1' OR ST_SEND = '2') AND ST = '1' ORDER BY ID_EDIT DESC";
			$data['row']=$this->oci_model->select($field, 'VW_CUST_EDIT',$kondisi);
		}else{
			$field="ID_EDIT,CUST_ACCOUNT,COUNTRY_KEY,NAME1,NAME2,CITY,
				POSTAL_CODE,REGION,SHORT_FIELD,TLP1,TLP2,FAX,ADDRESS,
				SEARCH_TERM1,SEARCH_TERM2,TITLE_CP,ALLOW_POS,NIELSEN_ID,
				MEMBER_CARD,VATNUM,EMAIL,INDUSTRY_KEY,ACCOUNT_GROUP,
				USER_CR,AUTH_GROUP,RECONT_ACCOUNT,COMPANY_CODE,SALES_ORG,
				DIS_CHANNEL,DIVISION,CUST_GROUP,INCO1,INCO2,CURR,TOP,SALES_OFFICE,
				ST_SEND,ST,TGL,REASONREJECT,DATE_POSTING,DATE_APPROVED,NIK_APPROVED,
				DATE_IS,NIK_IS,DATE_DELETE,CUST_CLASS,SUBJECT,ADDRESS2,
				ADDRESS3,DATE_MODIF,NIK_MODIF,NEW_ST,INDUSTRY_CODE1,SHORT_KEY,
				SALES_GROUP,CUST_PRICE,CUST_STAT,RELEVAN_POD,
				ACCOUNT_ASS,ORDER_PROB,ADDRESS4,CON_TLP,CON_HP,
				CON_FAX,CON_EMAIL,
				DEV_USERS.GET_NAME_BY_NIK(USER_CR) AS NAME_CREATE";
			$kondisi="(ST_SEND='1' OR ST_SEND = '2') AND ST = '1' AND GET_ST_HAK('".$nik."', SALES_ORG,DIS_CHANNEL,DIVISION) = '1' ORDER BY ID_EDIT DESC";
			$data['row']=$this->oci_model->select($field, 'VW_CUST_EDIT',$kondisi);
		}
		
		$data['main_content']="customer/list_cust_approval_edit";
		$this->load->view('template/main',$data);	
	}
	
	function form_approval_edit(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$nik=$this->session->userdata('NIK');
		
		$id_edit=$this->uri->segment(3);
		$seskode=$this->session->userdata('seskode');
		
		$field="*";
		$kondisi="ID_EDIT = '".$id_edit."'";
		$DataEdit=$this->oci_model->select($field, 'VW_CUST_EDIT',$kondisi);
		
		foreach($DataEdit as $kna){
			
			$company_code=$kna['COMPANY_CODE'];
			$cust_account=$kna['CUST_ACCOUNT'];
			$country_key=$kna['COUNTRY_KEY'];
			$name1=$kna['NAME1'];
			$name2=$kna['NAME2'];
			$city=$kna['CITY'];
			$postal_code=$kna['POSTAL_CODE'];
			$region=$kna['REGION'];
			$short_field=$kna['SHORT_FIELD'];
			$tlp1=$kna['TLP1'];
			$tlp2=$kna['TLP2'];
			$fax=$kna['FAX'];
			$address=$kna['ADDRESS'];
			$address2=$kna['ADDRESS2'];
			$address3=$kna['ADDRESS3'];
			$address4=$kna['ADDRESS4'];
			$search1=$kna['SEARCH_TERM1'];
			$search2=$kna['SEARCH_TERM2'];
			$title=$kna['TITLE_CP'];
			$allowpos=$kna['ALLOW_POS'];
			$nielsen=$kna['NIELSEN_ID'];
			$member_card=$kna['MEMBER_CARD'];
			$vatnum=$kna['VATNUM'];
			$email=$kna['EMAIL'];
			$industry_key=$kna['INDUSTRY_KEY'];
			$account_group=$kna['ACCOUNT_GROUP'];
			$user=$kna['USER_CR'];
			$auth_group=$kna['AUTH_GROUP'];
			$st_send=$kna['ST_SEND'];
			$new_st=$kna['NEW_ST'];
			$st=$kna['ST'];
			$tgl=$kna['TGL'];
			$reasonreject=$kna['REASONREJECT'];
			$date_posting=$kna['DATE_POSTING'];
			$date_approved=$kna['DATE_APPROVED'];
			$date_is=$kna['DATE_IS'];
			$date_delete=$kna['DATE_DELETE'];
			$nik_approved=$kna['NIK_APPROVED'];
			$nik_is=$kna['NIK_IS'];
			$cust_class=$kna['CUST_CLASS'];
			$subject=$kna['SUBJECT'];
			$date_modif=$kna['DATE_MODIF'];
			$nik_modif=$kna['NIK_MODIF'];
			$sales_org=$kna['SALES_ORG'];
			$dis_channel=$kna['DIS_CHANNEL'];
			$division=$kna['DIVISION'];
			$recon_account=$kna['RECONT_ACCOUNT'];
			$account_group=$kna['ACCOUNT_GROUP'];
			$top=$kna['TOP'];
			$sales_office=$kna['SALES_OFFICE'];
			$cust_group=$kna['CUST_GROUP'];
			$currency=$kna['CURR'];
			$inco1=$kna['INCO1'];
			$inco2=$kna['INCO2'];
		}
		
		$nik=$this->session->userdata('NIK');
		$stHak=$this->oci_model->cek_hak_akses($nik, $sales_org, $dis_channel, $division);
		if($stHak < 1){
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Sorry you do not have access, please contact the administrator !</div>');
			$url="customer/list_cust_approval_edit";
			redirect($url);
		}
		
		//Get Data Name
		$this->load->model('sap_model');
		$data_company=$this->sap_model->getCompanyCode();
		$data_industry=$this->sap_model->getIndustry();
		$data_customer_class=$this->sap_model->getCustomerClass();
		$data_top=$this->sap_model->getTOP();
		$data_customer_group=$this->sap_model->getCustomerGroup();
		$data_incoterm=$this->sap_model->getIncoterm();
		$data_nielsen=$this->sap_model->getNielsen();
		$data_dis_channel=$this->sap_model->getDistributionChannel();
		$data_division=$this->sap_model->getDivision();
		$data_sales_org=$this->sap_model->getSalesOrganization();
		$data_region=$this->sap_model->getRegion($country_key);
		$data_sales_office=$this->sap_model->getSalesOffice();
		$data_account_group=$this->sap_model->getAccountGroup();
		$data_recon_account=$this->sap_model->getReconAccount();
		
		$data['txt_company']="";
		$data['txt_dischannel']="";
		$data['txt_division']="";
		$data['txt_region']="";
		$data['txt_region']="";
		$data['txt_nielsen']="";
		$data['txt_industry']="";
		$data['txt_custclass']="";
		$data['txt_top']="";
		$data['txt_salesoffice']="";
		$data['txt_inco1']="";
		$data['txt_account_group']="";
		$data['txt_recon']="";
		$data['txt_cust_group']="";
		$data['txt_sales_org']="";
		
		foreach($data_company as $key1 => $com){
			if($key1 == 0 and $com['BUKRS'] == ''){
			continue;}
			if($com['BUKRS'] == $company_code && $com['LAND1'] == 'ID'){
				$data['txt_company']=$com['BUTXT'];
			}
		}
		foreach($data_dis_channel as $key2 => $dis){
			
			if($key2 == 0 and !isset($dis['VTWEG'])){
			continue;}
			if($dis['VTWEG'] == $dis_channel){
				$data['txt_dischannel']=$dis['VTEXT'];
			}
		}
		foreach($data_division as $key3 => $div){
			
			if($key3 == 0 and !isset($div['SPART'])){
			continue;}
			if($div['SPART'] == $division){
				$data['txt_division']=$div['VTEXT'];
			}
		}
		foreach($data_region as $key4 => $reg){
			
			if($key4 == 0 and !isset($reg['BLAND'])){
			continue;}
			if($reg['BLAND'] == $region){
				$data['txt_region']=$reg['BEZEI'];
			}
		}
		
		foreach($data_nielsen as $key5 => $nil){
			if($key5 == 0 and !isset($nil['NIELS'])){
			continue;}
			if($nil['NIELS'] == $nielsen){
				$data['txt_nielsen']=$nil['BEZEI'];
			}
		}
		
		foreach($data_industry as $key6 => $ind){
			if($key6 == 0 and !isset($ind['BRSCH'])){
			continue;}
			if($ind['BRSCH'] == $industry_key){
				$data['txt_industry']=$ind['BRTXT'];
			}
		}
		foreach($data_customer_class as $key7 => $cs){
			if($key7 == 0 and !isset($cs['KUKLA'])){
			continue;}
			if($cs['KUKLA'] == $cust_class){
				$data['txt_custclass']=$cs['VTEXT'];
			}
		}
		
		foreach($data_top as $key8 => $tp){
			if($key8 == 0 and !isset($tp['ZTERM'])){
			continue;}
			if($tp['ZTERM'] == $top){
				$data['txt_top']=$tp['VTEXT'];
			}
		}
		
		foreach($data_sales_office as $key9 => $sof){
			if($key9 == 0 and !isset($sof['VKBUR'])){
			continue;}
			if($sof['VKBUR'] == $sales_office){
				$data['txt_salesoffice']=$sof['BEZEI'];
			}
		}
		foreach($data_incoterm as $key10 => $inc){
			if($key10 == 0 and !isset($inc['INCO1'])){
			continue;}
			if($inc['INCO1'] == $inco1){
				$data['txt_inco1']=$inc['BEZEI'];
			}
		}
		foreach($data_account_group as $key11 => $accg){
			if($key11 == 0 and !isset($accg['KTOKD'])){
			continue;}
			if($accg['KTOKD'] == $account_group){
				$data['txt_account_group']=$accg['TXT30'];
			}
		}
		foreach($data_recon_account as $key12 => $reca){
			if($key12 == 0 and !isset($reca['SAKNR'])){
			continue;}
			if($reca['SAKNR'] == $recon_account){
				$data['txt_recon']=$reca['TXT50'];
			}
		}
		
		foreach($data_customer_group as $key13 => $cgp){
			if($key13 == 0 and !isset($cgp['KDGRP'])){
			continue;}
			if($cgp['KDGRP'] == $cust_group){
				$data['txt_cust_group']=$cgp['KTEXT'];
			}
		}
		
		foreach($data_sales_org as $key14 => $sor){
			if($key14 == 0 and !isset($sor['VKORG'])){
			continue;}
			if($sor['VKORG'] == $sales_org){
				$data['txt_sales_org']=$sor['VTEXT'];
			}
		}
		$data['id_edit']=$id_edit;
		$data['kunnr']=$cust_account;
		$data['company_code']=$company_code;
		$data['xaccount_group']=$account_group;
		$data['xrecon_account']=$recon_account;
		$data['dis_channel']=$dis_channel;
		$data['division']=$division;
		$data['title']=$title;
		$data['name1']=$name1;
		$data['name2']=$name2;
		$data['nickname']=$short_field;
		$data['search1']=$search1;
		$data['search2']=$search2;
		$data['address']=$address;
		$data['address2']=$address2;
		$data['address3']=$address3;
		$data['address4']=$address4;
		$data['country']=$country_key;
		$data['region']=$region;
		$data['city']=$city;
		$data['postal_code']=$postal_code;
		$data['tlp']=$tlp1;
		$data['fax']=$fax;
		$data['hp']=$tlp2;
		$data['email']=$email;
		$data['allowpos']=$allowpos;
		$data['subject']=$subject;
		if($allowpos == "1"){
			$data['nielsen']=$nielsen;
		}else{
			$data['nielsen']="";
			$data['txt_nielsen']="";
		}
		
		$data['member_card']=$member_card;
		$data['industry']=$industry_key;
		$data['customer_class']=$cust_class;
		$data['vat']=$vatnum;
		$data['top']=$top;
		$data['sales_office']=$sales_office;
		$data['cust_group']=$cust_group;
		$data['curr']=$currency;
		$data['inco1']=$inco1;
		$data['inco2']=$inco2;
		$data['tgl_create']=$tgl;
		$data['tgl_posting']=$date_posting;
		$data['user_create']=$user;
		$data['tgl_approved']=$date_approved;
		$data['user_approved']=$nik_approved;
		$data['tgl_is']=$date_is;
		$data['user_is']=$nik_is;
		$data['status']=$new_st;
		$data['sales_org']=$sales_org;
		$data['tgl_modif']=$date_modif;
		$data['nik_modif']=$nik_modif;
		$data['account_group']=$data_account_group;
		$data['recon_account']=$data_recon_account;
		$data['customer_group']=$cust_group;
		$data['main_content']="customer/form_approval_edit";
		$this->load->view('template/main',$data);	
	}
	
	function add_approval_edit(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$seskode=$this->session->userdata('seskode');
		$nik=$this->session->userdata('NIK');
		
		$id_edit=$this->input->post('id_edit');
		
		$account_group=$this->input->post('account_group');
		$recon_account=$this->input->post('recon_account');
		
		$field="*";
		$kondisi="ID_EDIT = '".$id_edit."'";
		$DataEdit=$this->oci_model->select($field, 'VW_CUST_EDIT',$kondisi);
		
		foreach($DataEdit as $kna){
			$kunnr=$kna['CUST_ACCOUNT'];
			$sales_org=$kna['SALES_ORG'];
			$dis_channel=$kna['DIS_CHANNEL'];
			$division=$kna['DIVISION'];
		}
		$nik=$this->session->userdata('NIK');
		$stHak=$this->oci_model->cek_hak_akses($nik, $sales_org, $dis_channel, $division);
		if($stHak < 1){
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Sorry you do not have access, please contact the administrator !</div>');
			$url="customer/list_cust_approval_edit";
			redirect($url);
		}
		
		
		
		//update customer Extend
		$field="ST_SEND = '2', DATE_APPROVED = TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI'), NIK_APPROVED = '".$nik."', ACCOUNT_GROUP = '".$account_group."', RECONT_ACCOUNT = '".$recon_account."' ";
		$kondisi="ID_EDIT = '".$id_edit."'";
		$exec=$this->oci_model->Exec($field, false, 'T_CUST_EDIT', $kondisi, 'update');
		
		
		$fieldU="DISTINCT(NIK), DEV_USERS.GET_NAME_BY_NIK(NIK) as NAMA, DEV_USERS.GET_EMAIL_BY_NIK(NIK) AS EMAIL";
		$kondisiU="SALES_ORG='".$sales_org."' AND DIS_CHANNEL='".$dis_channel."' AND DIVISION='".$division."' AND NIK IN (SELECT NIK FROM M_CUST_ROLE WHERE (ROLE='MASTERDATA' OR ROLE='ADMINISTRATOR'))";
		$listNIK=$this->oci_model->select($fieldU, 'M_CUST_PRIVILEGE',$kondisiU);
		
		$jml=count($listNIK);
		if($jml > 0){
			foreach($listNIK as $a){
				$nik=$a['NIK'];
				$email = $a['EMAIL'];
				$nama = $a['NAMA'];
				if($email <> ""){
					$this->send_mail($email, "REQUEST TRANSPORT CHANGE CUSTOMER", "approval", "edit" ,$nama, $id_edit);
				}
			}
		}
		
		
		
		if($exec == 1){
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Approval Customer Edit Request Success.</div>');
			redirect('customer/list_cust_approval_edit');
		}
	}
	
	function form_edit_approval_edit(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$nik=$this->session->userdata('NIK');
		
		$id_edit=$this->uri->segment(3);
		$seskode=$this->session->userdata('seskode');
		
		$field="*";
		$kondisi="ID_EDIT = '".$id_edit."'";
		$DataEdit=$this->oci_model->select($field, 'VW_CUST_EDIT',$kondisi);
		
		foreach($DataEdit as $kna){
			
			$company_code=$kna['COMPANY_CODE'];
			$cust_account=$kna['CUST_ACCOUNT'];
			$country_key=$kna['COUNTRY_KEY'];
			$name1=$kna['NAME1'];
			$name2=$kna['NAME2'];
			$city=$kna['CITY'];
			$postal_code=$kna['POSTAL_CODE'];
			$region=$kna['REGION'];
			$short_field=$kna['SHORT_FIELD'];
			$tlp1=$kna['TLP1'];
			$tlp2=$kna['TLP2'];
			$fax=$kna['FAX'];
			$address=$kna['ADDRESS'];
			$address2=$kna['ADDRESS2'];
			$address3=$kna['ADDRESS3'];
			$address4=$kna['ADDRESS4'];
			$search1=$kna['SEARCH_TERM1'];
			$search2=$kna['SEARCH_TERM2'];
			$title=$kna['TITLE_CP'];
			$allowpos=$kna['ALLOW_POS'];
			$nielsen=$kna['NIELSEN_ID'];
			$member_card=$kna['MEMBER_CARD'];
			$vatnum=$kna['VATNUM'];
			$email=$kna['EMAIL'];
			$industry_key=$kna['INDUSTRY_KEY'];
			$account_group=$kna['ACCOUNT_GROUP'];
			$user=$kna['USER_CR'];
			$auth_group=$kna['AUTH_GROUP'];
			$st_send=$kna['ST_SEND'];
			$new_st=$kna['NEW_ST'];
			$st=$kna['ST'];
			$tgl=$kna['TGL'];
			$reasonreject=$kna['REASONREJECT'];
			$date_posting=$kna['DATE_POSTING'];
			$date_approved=$kna['DATE_APPROVED'];
			$date_is=$kna['DATE_IS'];
			$date_delete=$kna['DATE_DELETE'];
			$nik_approved=$kna['NIK_APPROVED'];
			$nik_is=$kna['NIK_IS'];
			$cust_class=$kna['CUST_CLASS'];
			$subject=$kna['SUBJECT'];
			$date_modif=$kna['DATE_MODIF'];
			$nik_modif=$kna['NIK_MODIF'];
			$sales_org=$kna['SALES_ORG'];
			$dis_channel=$kna['DIS_CHANNEL'];
			$division=$kna['DIVISION'];
			$recon_account=$kna['RECONT_ACCOUNT'];
			$account_group=$kna['ACCOUNT_GROUP'];
			$top=$kna['TOP'];
			$sales_office=$kna['SALES_OFFICE'];
			$cust_group=$kna['CUST_GROUP'];
			$currency=$kna['CURR'];
			$inco1=$kna['INCO1'];
			$inco2=$kna['INCO2'];
		}
		
		$nik=$this->session->userdata('NIK');
		$stHak=$this->oci_model->cek_hak_akses($nik, $sales_org, $dis_channel, $division);
		if($stHak < 1){
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Sorry you do not have access, please contact the administrator !</div>');
			$url="customer/list_cust_approval_edit";
			redirect($url);
		}
		//Get Data Name
		$this->load->model('sap_model');
		$data_company=$this->sap_model->getCompanyCode();
		$data_industry=$this->sap_model->getIndustry();
		$data_customer_class=$this->sap_model->getCustomerClass();
		$data_top=$this->sap_model->getTOP();
		$data_customer_group=$this->sap_model->getCustomerGroup();
		$data_incoterm=$this->sap_model->getIncoterm();
		$data_nielsen=$this->sap_model->getNielsen();
		$data_dis_channel=$this->sap_model->getDistributionChannel();
		$data_division=$this->sap_model->getDivision();
		$data_sales_org=$this->sap_model->getSalesOrganization();
		$data_region=$this->sap_model->getRegion($country_key);
		$data_sales_office=$this->sap_model->getSalesOffice();
		$data_account_group=$this->sap_model->getAccountGroup();
		$data_recon_account=$this->sap_model->getReconAccount();
		
		$data['txt_company']="";
		$data['txt_dischannel']="";
		$data['txt_division']="";
		$data['txt_region']="";
		$data['txt_region']="";
		$data['txt_nielsen']="";
		$data['txt_industry']="";
		$data['txt_custclass']="";
		$data['txt_top']="";
		$data['txt_salesoffice']="";
		$data['txt_inco1']="";
		$data['txt_account_group']="";
		$data['txt_recon']="";
		$data['txt_cust_group']="";
		$data['txt_sales_org']="";
		
		foreach($data_company as $key1 => $com){
			if($key1 == 0 and $com['BUKRS'] == ''){
			continue;}
			if($com['BUKRS'] == $company_code && $com['LAND1'] == 'ID'){
				$data['txt_company']=$com['BUTXT'];
			}
		}
		foreach($data_dis_channel as $key2 => $dis){
			
			if($key2 == 0 and !isset($dis['VTWEG'])){
			continue;}
			if($dis['VTWEG'] == $dis_channel){
				$data['txt_dischannel']=$dis['VTEXT'];
			}
		}
		foreach($data_division as $key3 => $div){
			
			if($key3 == 0 and !isset($div['SPART'])){
			continue;}
			if($div['SPART'] == $division){
				$data['txt_division']=$div['VTEXT'];
			}
		}
		foreach($data_region as $key4 => $reg){
			
			if($key4 == 0 and !isset($reg['BLAND'])){
			continue;}
			if($reg['BLAND'] == $region){
				$data['txt_region']=$reg['BEZEI'];
			}
		}
		
		foreach($data_nielsen as $key5 => $nil){
			if($key5 == 0 and !isset($nil['NIELS'])){
			continue;}
			if($nil['NIELS'] == $nielsen){
				$data['txt_nielsen']=$nil['BEZEI'];
			}
		}
		
		foreach($data_industry as $key6 => $ind){
			if($key6 == 0 and !isset($ind['BRSCH'])){
			continue;}
			if($ind['BRSCH'] == $industry_key){
				$data['txt_industry']=$ind['BRTXT'];
			}
		}
		foreach($data_customer_class as $key7 => $cs){
			if($key7 == 0 and !isset($cs['KUKLA'])){
			continue;}
			if($cs['KUKLA'] == $cust_class){
				$data['txt_custclass']=$cs['VTEXT'];
			}
		}
		
		foreach($data_top as $key8 => $tp){
			if($key8 == 0 and !isset($tp['ZTERM'])){
			continue;}
			if($tp['ZTERM'] == $top){
				$data['txt_top']=$tp['VTEXT'];
			}
		}
		
		foreach($data_sales_office as $key9 => $sof){
			if($key9 == 0 and !isset($sof['VKBUR'])){
			continue;}
			if($sof['VKBUR'] == $sales_office){
				$data['txt_salesoffice']=$sof['BEZEI'];
			}
		}
		foreach($data_incoterm as $key10 => $inc){
			if($key10 == 0 and !isset($inc['INCO1'])){
			continue;}
			if($inc['INCO1'] == $inco1){
				$data['txt_inco1']=$inc['BEZEI'];
			}
		}
		foreach($data_account_group as $key11 => $accg){
			if($key11 == 0 and !isset($accg['KTOKD'])){
			continue;}
			if($accg['KTOKD'] == $account_group){
				$data['txt_account_group']=$accg['TXT30'];
			}
		}
		foreach($data_recon_account as $key12 => $reca){
			if($key12 == 0 and !isset($reca['SAKNR'])){
			continue;}
			if($reca['SAKNR'] == $recon_account){
				$data['txt_recon']=$reca['TXT50'];
			}
		}
		
		foreach($data_customer_group as $key13 => $cgp){
			if($key13 == 0 and !isset($cgp['KDGRP'])){
			continue;}
			if($cgp['KDGRP'] == $cust_group){
				$data['txt_cust_group']=$cgp['KTEXT'];
			}
		}
		
		foreach($data_sales_org as $key14 => $sor){
			if($key14 == 0 and !isset($sor['VKORG'])){
			continue;}
			if($sor['VKORG'] == $sales_org){
				$data['txt_sales_org']=$sor['VTEXT'];
			}
		}
		$data['id_edit']=$id_edit;
		$data['kunnr']=$cust_account;
		$data['company_code']=$company_code;
		$data['xaccount_group']=$account_group;
		$data['xrecon_account']=$recon_account;
		$data['dis_channel']=$dis_channel;
		$data['division']=$division;
		$data['title']=$title;
		$data['name1']=$name1;
		$data['name2']=$name2;
		$data['nickname']=$short_field;
		$data['search1']=$search1;
		$data['search2']=$search2;
		$data['address']=$address;
		$data['address2']=$address2;
		$data['address3']=$address3;
		$data['address4']=$address4;
		$data['country']=$country_key;
		$data['region']=$region;
		$data['city']=$city;
		$data['postal_code']=$postal_code;
		$data['tlp']=$tlp1;
		$data['fax']=$fax;
		$data['hp']=$tlp2;
		$data['email']=$email;
		$data['allowpos']=$allowpos;
		$data['subject']=$subject;
		if($allowpos == "1"){
			$data['nielsen']=$nielsen;
		}else{
			$data['nielsen']="";
			$data['txt_nielsen']="";
		}
		
		$data['member_card']=$member_card;
		$data['industry']=$industry_key;
		$data['customer_class']=$cust_class;
		$data['vat']=$vatnum;
		$data['top']=$top;
		$data['sales_office']=$sales_office;
		$data['cust_group']=$cust_group;
		$data['curr']=$currency;
		$data['inco1']=$inco1;
		$data['inco2']=$inco2;
		$data['tgl_create']=$tgl;
		$data['tgl_posting']=$date_posting;
		$data['user_create']=$user;
		$data['tgl_approved']=$date_approved;
		$data['user_approved']=$nik_approved;
		$data['tgl_is']=$date_is;
		$data['user_is']=$nik_is;
		$data['status']=$new_st;
		$data['sales_org']=$sales_org;
		$data['tgl_modif']=$date_modif;
		$data['nik_modif']=$nik_modif;
		$data['account_group']=$data_account_group;
		$data['recon_account']=$data_recon_account;
		$data['customer_group']=$cust_group;
		$data['main_content']="customer/form_edit_approval_edit";
		$this->load->view('template/main',$data);	
	}
	
	function edit_approval_edit(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$seskode=$this->session->userdata('seskode');
		$nik=$this->session->userdata('NIK');
		
		$id_edit=$this->input->post('id_edit');
		
		$account_group=$this->input->post('account_group');
		$recon_account=$this->input->post('recon_account');
		
		$field="*";
		$kondisi="ID_EDIT = '".$id_edit."'";
		$DataEdit=$this->oci_model->select($field, 'VW_CUST_EDIT',$kondisi);
		foreach($DataEdit as $kna){
			$sales_org=$kna['SALES_ORG'];
			$dis_channel=$kna['DIS_CHANNEL'];
			$division=$kna['DIVISION'];
		}
		
		$nik=$this->session->userdata('NIK');
		$stHak=$this->oci_model->cek_hak_akses($nik, $sales_org, $dis_channel, $division);
		if($stHak < 1){
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Sorry you do not have access, please contact the administrator !</div>');
			$url="customer/list_cust_approval_edit";
			redirect($url);
		}
		
		
		//update customer Extend
		$field="ST_SEND = '2', ACCOUNT_GROUP = '".$account_group."', RECONT_ACCOUNT = '".$recon_account."' ";
		$kondisi="ID_EDIT = '".$id_edit."'";
		$exec=$this->oci_model->Exec($field, false, 'T_CUST_EDIT', $kondisi, 'update');
		
		if($exec == 1){
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Approval Customer Edit Request Success.</div>');
			redirect('customer/list_cust_approval_edit');
		}
	}
	
	function list_cust_is_edit(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->my_auth->hak_akses("MASTERDATA");
		$this->load->model('oci_model');
		$nik=$this->session->userdata('NIK');
		
		if(strpos($this->session->userdata('role'),'ADMINISTRATOR') !== false){
			$field="ID_EDIT,CUST_ACCOUNT,COUNTRY_KEY,NAME1,NAME2,CITY,
				POSTAL_CODE,REGION,SHORT_FIELD,TLP1,TLP2,FAX,ADDRESS,
				SEARCH_TERM1,SEARCH_TERM2,TITLE_CP,ALLOW_POS,NIELSEN_ID,
				MEMBER_CARD,VATNUM,EMAIL,INDUSTRY_KEY,ACCOUNT_GROUP,
				USER_CR,AUTH_GROUP,RECONT_ACCOUNT,COMPANY_CODE,SALES_ORG,
				DIS_CHANNEL,DIVISION,CUST_GROUP,INCO1,INCO2,CURR,TOP,SALES_OFFICE,
				ST_SEND,ST,TGL,REASONREJECT,DATE_POSTING,DATE_APPROVED,NIK_APPROVED,
				DATE_IS,NIK_IS,DATE_DELETE,CUST_CLASS,SUBJECT,ADDRESS2,
				ADDRESS3,DATE_MODIF,NIK_MODIF,NEW_ST,INDUSTRY_CODE1,SHORT_KEY,
				SALES_GROUP,CUST_PRICE,CUST_STAT,RELEVAN_POD,
				ACCOUNT_ASS,ORDER_PROB,ADDRESS4,CON_TLP,CON_HP,
				CON_FAX,CON_EMAIL,
				DEV_USERS.GET_NAME_BY_NIK(USER_CR) AS NAME_CREATE";
			$kondisi="ST_SEND = '2' AND ST = '1' ORDER BY ID_EDIT DESC";
			$data['row']=$this->oci_model->select($field, 'VW_CUST_EDIT',$kondisi);
		}else{
			$field="ID_EDIT,CUST_ACCOUNT,COUNTRY_KEY,NAME1,NAME2,CITY,
				POSTAL_CODE,REGION,SHORT_FIELD,TLP1,TLP2,FAX,ADDRESS,
				SEARCH_TERM1,SEARCH_TERM2,TITLE_CP,ALLOW_POS,NIELSEN_ID,
				MEMBER_CARD,VATNUM,EMAIL,INDUSTRY_KEY,ACCOUNT_GROUP,
				USER_CR,AUTH_GROUP,RECONT_ACCOUNT,COMPANY_CODE,SALES_ORG,
				DIS_CHANNEL,DIVISION,CUST_GROUP,INCO1,INCO2,CURR,TOP,SALES_OFFICE,
				ST_SEND,ST,TGL,REASONREJECT,DATE_POSTING,DATE_APPROVED,NIK_APPROVED,
				DATE_IS,NIK_IS,DATE_DELETE,CUST_CLASS,SUBJECT,ADDRESS2,
				ADDRESS3,DATE_MODIF,NIK_MODIF,NEW_ST,INDUSTRY_CODE1,SHORT_KEY,
				SALES_GROUP,CUST_PRICE,CUST_STAT,RELEVAN_POD,
				ACCOUNT_ASS,ORDER_PROB,ADDRESS4,CON_TLP,CON_HP,
				CON_FAX,CON_EMAIL,
				DEV_USERS.GET_NAME_BY_NIK(USER_CR) AS NAME_CREATE";
			$kondisi="ST_SEND = '2' AND ST = '1' AND GET_ST_HAK('".$nik."', SALES_ORG,DIS_CHANNEL,DIVISION) = '1' ORDER BY ID_EDIT DESC";
			$data['row']=$this->oci_model->select($field, 'VW_CUST_EDIT',$kondisi);
		}
		
		$data['main_content']="customer/list_cust_is_edit";
		$this->load->view('template/main',$data);	
	}
	
	function form_transport_edit(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$id_edit=$this->uri->segment(3);
		
		$field="*";
		$kondisi="ID_EDIT = '".$id_edit."'";
		$DataEdit=$this->oci_model->select($field, 'VW_CUST_EDIT',$kondisi);
		
		foreach($DataEdit as $kna){
			
			$company_code=$kna['COMPANY_CODE'];
			$cust_account=$kna['CUST_ACCOUNT'];
			$country_key=$kna['COUNTRY_KEY'];
			$name1=$kna['NAME1'];
			$name2=$kna['NAME2'];
			$city=$kna['CITY'];
			$postal_code=$kna['POSTAL_CODE'];
			$region=$kna['REGION'];
			$short_field=$kna['SHORT_FIELD'];
			$tlp1=$kna['TLP1'];
			$tlp2=$kna['TLP2'];
			$fax=$kna['FAX'];
			$address=$kna['ADDRESS'];
			$address2=$kna['ADDRESS2'];
			$address3=$kna['ADDRESS3'];
			$address4=$kna['ADDRESS4'];
			$search1=$kna['SEARCH_TERM1'];
			$search2=$kna['SEARCH_TERM2'];
			$title=$kna['TITLE_CP'];
			$allowpos=$kna['ALLOW_POS'];
			$nielsen=$kna['NIELSEN_ID'];
			$member_card=$kna['MEMBER_CARD'];
			$vatnum=$kna['VATNUM'];
			$email=$kna['EMAIL'];
			$industry_key=$kna['INDUSTRY_KEY'];
			$account_group=$kna['ACCOUNT_GROUP'];
			$user=$kna['USER_CR'];
			$auth_group=$kna['AUTH_GROUP'];
			$st_send=$kna['ST_SEND'];
			$new_st=$kna['NEW_ST'];
			$st=$kna['ST'];
			$tgl=$kna['TGL'];
			$reasonreject=$kna['REASONREJECT'];
			$date_posting=$kna['DATE_POSTING'];
			$date_approved=$kna['DATE_APPROVED'];
			$date_is=$kna['DATE_IS'];
			$date_delete=$kna['DATE_DELETE'];
			$nik_approved=$kna['NIK_APPROVED'];
			$nik_is=$kna['NIK_IS'];
			$cust_class=$kna['CUST_CLASS'];
			$subject=$kna['SUBJECT'];
			$date_modif=$kna['DATE_MODIF'];
			$nik_modif=$kna['NIK_MODIF'];
			$sales_org=$kna['SALES_ORG'];
			$dis_channel=$kna['DIS_CHANNEL'];
			$division=$kna['DIVISION'];
			$recon_account=$kna['RECONT_ACCOUNT'];
			$account_group=$kna['ACCOUNT_GROUP'];
			$top=$kna['TOP'];
			$sales_office=$kna['SALES_OFFICE'];
			$cust_group=$kna['CUST_GROUP'];
			$currency=$kna['CURR'];
			$inco1=$kna['INCO1'];
			$inco2=$kna['INCO2'];
			//$consnum=$kna['CONSNUM'];
		}
		
		
		//Get Data Name
		$this->load->model('sap_model');
		$data_company=$this->sap_model->getCompanyCode();
		$data_industry=$this->sap_model->getIndustry();
		$data_customer_class=$this->sap_model->getCustomerClass();
		$data_top=$this->sap_model->getTOP();
		$data_customer_group=$this->sap_model->getCustomerGroup();
		$data_incoterm=$this->sap_model->getIncoterm();
		$data_nielsen=$this->sap_model->getNielsen();
		$data_dis_channel=$this->sap_model->getDistributionChannel();
		$data_division=$this->sap_model->getDivision();
		$data_sales_org=$this->sap_model->getSalesOrganization();
		$data_region=$this->sap_model->getRegion($country_key);
		$data_sales_office=$this->sap_model->getSalesOffice();
		$data_account_group=$this->sap_model->getAccountGroup();
		$data_recon_account=$this->sap_model->getReconAccount();
		
		$data['txt_company']="";
		$data['txt_dischannel']="";
		$data['txt_division']="";
		$data['txt_region']="";
		$data['txt_region']="";
		$data['txt_nielsen']="";
		$data['txt_industry']="";
		$data['txt_custclass']="";
		$data['txt_top']="";
		$data['txt_salesoffice']="";
		$data['txt_inco1']="";
		$data['txt_account_group']="";
		$data['txt_recon']="";
		$data['txt_cust_group']="";
		$data['txt_sales_org']="";
		
		foreach($data_company as $key1 => $com){
			if($key1 == 0 and $com['BUKRS'] == ''){
			continue;}
			if($com['BUKRS'] == $company_code && $com['LAND1'] == 'ID'){
				$data['txt_company']=$com['BUTXT'];
			}
		}
		foreach($data_dis_channel as $key2 => $dis){
			
			if($key2 == 0 and !isset($dis['VTWEG'])){
			continue;}
			if($dis['VTWEG'] == $dis_channel){
				$data['txt_dischannel']=$dis['VTEXT'];
			}
		}
		foreach($data_division as $key3 => $div){
			
			if($key3 == 0 and !isset($div['SPART'])){
			continue;}
			if($div['SPART'] == $division){
				$data['txt_division']=$div['VTEXT'];
			}
		}
		foreach($data_region as $key4 => $reg){
			
			if($key4 == 0 and !isset($reg['BLAND'])){
			continue;}
			if($reg['BLAND'] == $region){
				$data['txt_region']=$reg['BEZEI'];
			}
		}
		
		foreach($data_nielsen as $key5 => $nil){
			if($key5 == 0 and !isset($nil['NIELS'])){
			continue;}
			if($nil['NIELS'] == $nielsen){
				$data['txt_nielsen']=$nil['BEZEI'];
			}
		}
		
		foreach($data_industry as $key6 => $ind){
			if($key6 == 0 and !isset($ind['BRSCH'])){
			continue;}
			if($ind['BRSCH'] == $industry_key){
				$data['txt_industry']=$ind['BRTXT'];
			}
		}
		foreach($data_customer_class as $key7 => $cs){
			if($key7 == 0 and !isset($cs['KUKLA'])){
			continue;}
			if($cs['KUKLA'] == $cust_class){
				$data['txt_custclass']=$cs['VTEXT'];
			}
		}
		
		foreach($data_top as $key8 => $tp){
			if($key8 == 0 and !isset($tp['ZTERM'])){
			continue;}
			if($tp['ZTERM'] == $top){
				$data['txt_top']=$tp['VTEXT'];
			}
		}
		
		foreach($data_sales_office as $key9 => $sof){
			if($key9 == 0 and !isset($sof['VKBUR'])){
			continue;}
			if($sof['VKBUR'] == $sales_office){
				$data['txt_salesoffice']=$sof['BEZEI'];
			}
		}
		foreach($data_incoterm as $key10 => $inc){
			if($key10 == 0 and !isset($inc['INCO1'])){
			continue;}
			if($inc['INCO1'] == $inco1){
				$data['txt_inco1']=$inc['BEZEI'];
			}
		}
		foreach($data_account_group as $key11 => $accg){
			if($key11 == 0 and !isset($accg['KTOKD'])){
			continue;}
			if($accg['KTOKD'] == $account_group){
				$data['txt_account_group']=$accg['TXT30'];
			}
		}
		foreach($data_recon_account as $key12 => $reca){
			if($key12 == 0 and !isset($reca['SAKNR'])){
			continue;}
			if($reca['SAKNR'] == $recon_account){
				$data['txt_recon']=$reca['TXT50'];
			}
		}
		
		foreach($data_customer_group as $key13 => $cgp){
			if($key13 == 0 and !isset($cgp['KDGRP'])){
			continue;}
			if($cgp['KDGRP'] == $cust_group){
				$data['txt_cust_group']=$cgp['KTEXT'];
			}
		}
		
		foreach($data_sales_org as $key14 => $sor){
			if($key14 == 0 and !isset($sor['VKORG'])){
			continue;}
			if($sor['VKORG'] == $sales_org){
				$data['txt_sales_org']=$sor['VTEXT'];
			}
		}
		
		$data['kunnr']=$cust_account;
		$data['company_code']=$company_code;
		$data['account_group']=$account_group;
		$data['recon_account']=$recon_account;
		$data['dis_channel']=$dis_channel;
		$data['division']=$division;
		$data['title']=$title;
		$data['name1']=$name1;
		$data['name2']=$name2;
		$data['nickname']=$short_field;
		$data['search1']=$search1;
		$data['search2']=$search2;
		$data['address']=$address;
		$data['address2']=$address2;
		$data['address3']=$address3;
		$data['address4']=$address4;
		$data['country']=$country_key;
		$data['region']=$region;
		$data['city']=$city;
		$data['postal_code']=$postal_code;
		$data['tlp']=$tlp1;
		$data['fax']=$fax;
		$data['hp']=$tlp2;
		$data['email']=$email;
		$data['allowpos']=$allowpos;
		$data['subject']=$subject;
		if($allowpos == "1"){
			$data['nielsen']=$nielsen;
		}else{
			$data['nielsen']="";
			$data['txt_nielsen']="";
		}
		$data['id_edit']=$id_edit;
		$data['member_card']=$member_card;
		$data['industry']=$industry_key;
		$data['customer_class']=$cust_class;
		$data['vat']=$vatnum;
		$data['top']=$top;
		$data['sales_office']=$sales_office;
		$data['cust_group']=$cust_group;
		$data['curr']=$currency;
		$data['inco1']=$inco1;
		$data['inco2']=$inco2;
		$data['tgl_create']=$tgl;
		$data['tgl_posting']=$date_posting;
		$data['user_create']=$user;
		$data['tgl_approved']=$date_approved;
		$data['user_approved']=$nik_approved;
		$data['tgl_is']=$date_is;
		$data['user_is']=$nik_is;
		$data['status']=$new_st;
		$data['sales_org']=$sales_org;
		$data['tgl_modif']=$date_modif;
		$data['nik_modif']=$nik_modif;
		
		$data['customer_group']=$cust_group;
		$data['main_content']="customer/form_transport_edit";
		$this->load->view('template/main',$data);	
	}
	
	function transport_edit(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$id_edit=$this->input->post('id_edit');
		
		$field="*";
		$kondisi="ID_EDIT = '".$id_edit."'";
		$DataEdit=$this->oci_model->select($field, 'VW_CUST_EDIT',$kondisi);
		
		foreach($DataEdit as $kna){
			
			$company_code=$kna['COMPANY_CODE'];
			$cust_account=$kna['CUST_ACCOUNT'];
			$country_key=$kna['COUNTRY_KEY'];
			$name1=$kna['NAME1'];
			$name2=$kna['NAME2'];
			$city=$kna['CITY'];
			$postal_code=$kna['POSTAL_CODE'];
			$region=$kna['REGION'];
			$short_field=$kna['SHORT_FIELD'];
			$tlp1=$kna['TLP1'];
			$tlp2=$kna['TLP2'];
			$fax=$kna['FAX'];
			$address=$kna['ADDRESS'];
			$address2=$kna['ADDRESS2'];
			$address3=$kna['ADDRESS3'];
			$address4=$kna['ADDRESS4'];
			$search1=$kna['SEARCH_TERM1'];
			$search2=$kna['SEARCH_TERM2'];
			$title=$kna['TITLE_CP'];
			$allowpos=$kna['ALLOW_POS'];
			$nielsen=$kna['NIELSEN_ID'];
			$member_card=$kna['MEMBER_CARD'];
			$vatnum=$kna['VATNUM'];
			$email=$kna['EMAIL'];
			$industry_key=$kna['INDUSTRY_KEY'];
			$account_group=$kna['ACCOUNT_GROUP'];
			$user=$kna['USER_CR'];
			$auth_group=$kna['AUTH_GROUP'];
			$st_send=$kna['ST_SEND'];
			$new_st=$kna['NEW_ST'];
			$st=$kna['ST'];
			$tgl=$kna['TGL'];
			$reasonreject=$kna['REASONREJECT'];
			$date_posting=$kna['DATE_POSTING'];
			$date_approved=$kna['DATE_APPROVED'];
			$date_is=$kna['DATE_IS'];
			$date_delete=$kna['DATE_DELETE'];
			$nik_approved=$kna['NIK_APPROVED'];
			$nik_is=$kna['NIK_IS'];
			$cust_class=$kna['CUST_CLASS'];
			$subject=$kna['SUBJECT'];
			$date_modif=$kna['DATE_MODIF'];
			$nik_modif=$kna['NIK_MODIF'];
			$sales_org=$kna['SALES_ORG'];
			$dis_channel=$kna['DIS_CHANNEL'];
			$division=$kna['DIVISION'];
			$recon_account=$kna['RECONT_ACCOUNT'];
			$account_group=$kna['ACCOUNT_GROUP'];
			$top=$kna['TOP'];
			$sales_office=$kna['SALES_OFFICE'];
			$cust_group=$kna['CUST_GROUP'];
			$currency=$kna['CURR'];
			$inco1=$kna['INCO1'];
			$inco2=$kna['INCO2'];
			
			$industry_code1=$kna['INDUSTRY_CODE1'];
			$short_key=$kna['SHORT_KEY'];
			$sales_group=$kna['SALES_GROUP'];
			$cust_price=$kna['CUST_PRICE'];
			$cust_stat=$kna['CUST_STAT'];
			$relevan=$kna['RELEVAN_POD'];
			$account_ass=$kna['ACCOUNT_ASS'];
			$order_prob=$kna['ORDER_PROB'];
			
			$con_tlp=$kna['CON_TLP'];
			$con_hp=$kna['CON_HP'];
			$con_fax=$kna['CON_FAX'];
			$con_email=$kna['CON_EMAIL'];
			
		}
		
		$nik=$this->session->userdata('NIK');
		$stHak=$this->oci_model->cek_hak_akses($nik, $sales_org, $dis_channel, $division);
		if($stHak < 1){
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Sorry you do not have access, please contact the administrator !</div>');
			$url="customer/list_cust_is_edit";
			redirect($url);
		}
		
		//transport start
		//update via BAPI ZBAPI_TEST_INSERT_CUST
		$kna1=array(
			'KUNNR' => $cust_account, //ID Customer
			'LAND1' => $country_key, //Country
			'NAME1' => $name1, //Name1
			'NAME2' => $name2, //Name2
			'ORT01' => $city, //City
			'PSTLZ' => $postal_code, //Postal Code
			'REGIO' => $region, //Region
			'SORTL' => $short_field, //short
			'STRAS' => $address, //alamat jalan
			'TELF1' => $tlp1, //tlp1
			'TELFX' => $fax, //Fax
			'MCOD1' => $search1, //Search 1
			'MCOD2' => $search2, //Search 2
			'ANRED' => $title, //Title
			'BRSCH' => $industry_key, //Industry Key
			'KTOKD' => $account_group, //Customer Account Group
			'KUKLA' => $cust_class, //Customer classification
			'NIELS' => $nielsen, //Nielsen ID
			'ORT02' => $country_key, //Country
			'SPRAS' => "EN", //LAnguage
			'STCEG' => $vatnum, //Vatnum
			//'ERNAM' => "DEVELOPER",
			'TELF2' => $tlp2,
			'BRAN1' => $industry_code1
		);
		
		$knb1=array(
			'KUNNR' => $cust_account, 
			'BUKRS' => $company_code, //Company
			'AKONT' => $recon_account, //Recont account
			'ZTERM' => $top, //TOP
			'QLAND' => $country_key, //Withholding Tax Country Key
			//'ERNAM' => "DEVELOPER",
			'ZUAWA' => $short_key
		);
		
		$knvv=array(
			'KUNNR' => $cust_account, //Id Customer
			'VKORG' => $sales_org, //Sales Org.
			'VTWEG' => $dis_channel, //Distribution Channel
			'SPART' => $division, //Division
			'KDGRP' => $cust_group, //Customer Group
			'INCO1' => $inco1, //Incoterm 1
			'INCO2' => $inco2, //Incoterm 2
			'WAERS' => $currency, //Mata Uang
			'ZTERM' => $top, //top
			'VKBUR' => $sales_office, //Sales office
			'VKGRP' => $sales_group, //Sales Group
			'KALKS' => $cust_price, //Cust Price
			'VERSG' => $cust_stat, //Customer Statistic Group
			'KTGRD' => $account_ass, // Account assignment group for this customer
			'PODKZ' => $relevan, //Relevant for POD processing
			'AWAHR' => $order_prob // Order probability of the item
		);
		
		//$addr1=array(
		//	'ADDR_NO' => "48243",
		//	'FORMOFADDR' => $title,
		//	'NAME' => $name1,
		//	'NAME_2' => $name2,
		//	'CITY' => $city,
		//	'POSTL_COD1' => $postal_code,
		//	'STREET' => $address,
		//	'STR_SUPPL1' => $address2,
		//	'STR_SUPPL2' => $address3,
		//	'STR_SUPPL3' => $address4,
		//	'COUNTRY' => $country_key,
		//	'LANGU' => "EN",
		//	'REGION' => $region,
		//	'SORT1' => $search1,
		//	'SORT2' => $search2,
		//	'ADR_NOTES' => $member_card,
		//	'FAX_NUMBER' => $fax,
		//	'E_MAIL' => $email
		//);
		if($title == "Mr."){
			$kode_title = "0002";
		}elseif($title == "Ms."){
			$kode_title = "0001";
		}elseif($title == "Company"){
			$kode_title = "0003";
		}elseif($title == "Mr. and Mrs."){
			$kode_title = "0004";
		}else{
			$kode_title = "";
		}
		$this->load->library('saprfc');	
		$this->load->library('sapauth');		
		$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
		//Cek Connection SAP Status	
		$data['content']=$this->saprfc->callFunction("ZBAPI_TEST_INSERT_CUST",
			array(	array("IMPORT","X_KNA1",$kna1),
				array("IMPORT","X_KNB1",$knb1),
				array("IMPORT","X_KNVV",$knvv),
				//array("IMPORT","X_BAPIADDR1",$addr1),
				array("EXPORT","XKUNNR",array()),
				array("EXPORT","O_KNA1",array())
			     )
			);
		$this->saprfc->logoff();
		
		$this->load->library('saprfc');	
		$this->load->library('sapauth');		
		
		$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
		//Cek Connection SAP Status	
		$data['content']=$this->saprfc->callFunction("ZBAPI_ADDRESS_ALL2",
		array(	array("IMPORT","XKUNNR",$cust_account),
			array("IMPORT","XTLP",$tlp1),
			array("IMPORT","XHP",$tlp2),
			array("IMPORT","XFAX",$fax),
			array("IMPORT","XEMAIL",$email),
			array("IMPORT","XMEMBER",$member_card),
			array("IMPORT","XCON_TLP",$con_tlp),
			array("IMPORT","XCON_HP",$con_hp),
			array("IMPORT","XCON_FAX",$con_fax),
			array("IMPORT","XCON_EMAIL",$con_email),
			array("IMPORT","XCON_MEMBER","999"),
			array("IMPORT","XTITLE", $kode_title),
			array("IMPORT","XNAME", $name1),
			array("IMPORT","XNAME2", $name2),
			array("IMPORT","XCITY", $city),
			array("IMPORT","XDISTRICT", $country_key),
			array("IMPORT","XPOSTCOD", $postal_code),
			array("IMPORT","XSTREET", $address),
			array("IMPORT","XADDRESS1", $address2),
			array("IMPORT","XADDRESS2", $address3),
			array("IMPORT","XADDRESS3", $address4),
			array("IMPORT","XCOUNTRY", $country_key),
			array("IMPORT","XLANGUAGE", "EN"),
			array("IMPORT","XSORT1", $search1),
			array("IMPORT","XSORT2", $search2),
			array("IMPORT","XREGION", $region)
		     )
		); 	 	
		echo $this->saprfc->printStatus();
		echo $this->saprfc->getStatus();
		$this->saprfc->logoff();
		
		
		//EMAIL END USER
		$fieldU="DEV_USERS.GET_NAME_BY_NIK('".$user."') as NAMA, DEV_USERS.GET_EMAIL_BY_NIK('".$user."') AS EMAIL";
		//$kondisiU="NIK='".$user."'";
		$listNIK=$this->oci_model->select($fieldU, 'DUAL', false);
		
		$jml=count($listNIK);
		if($jml > 0){
			foreach($listNIK as $a){
				//$nik=$a['NIK'];
				$email = $a['EMAIL'];
				$nama = $a['NAMA'];
				if($email <> ""){
					//$this->send_mail2($email, "REQUEST CHANGE CUSTOMER", "masterdata", $nama, $KUNNR);
					$this->send_mail($email, "REQUEST CHANGE CUSTOMER", "masterdata","edit", $nama, $cust_account);
				}
			}
		}
		
		
		
		//----------------Update Data Local---------------------
		$nik=$this->session->userdata('NIK');
		
		//update customer extend
		$field="ST_SEND = '3', DATE_IS = TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI'),  NIK_IS = '".$nik."'";
		$kondisi="ID_EDIT = '".$id_edit."'";
		$exec=$this->oci_model->Exec($field, false, 'T_CUST_EDIT', $kondisi, 'update');
		
		$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
			<h4 class="alert-heading">Success!</h4>
			 Transport Edit Customer to SAP success. </div>');
		    redirect('customer/list_cust_is_edit');
		
		
	}
	
	function form_posting_cust(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$idCust=$this->uri->segment(3);
		
		$fieldKNA="*";
		$kondisiKNA="ID_CUST = '".$idCust."'";
		$KNA1=$this->oci_model->select($fieldKNA, 'VW_CUST',$kondisiKNA);
		foreach($KNA1 as $kna){
			$company_code=$kna['COMPANY_CODE'];
			$cust_account=$kna['CUST_ACCOUNT'];
			$country_key=$kna['COUNTRY_KEY'];
			$name1=$kna['NAME1'];
			$name2=$kna['NAME2'];
			$city=$kna['CITY'];
			$postal_code=$kna['POSTAL_CODE'];
			$region=$kna['REGION'];
			$short_field=$kna['SHORT_FIELD'];
			$tlp1=$kna['TLP1'];
			$tlp2=$kna['TLP2'];
			$fax=$kna['FAX'];
			$address=$kna['ADDRESS'];
			$address2=$kna['ADDRESS2'];
			$address3=$kna['ADDRESS3'];
			$search1=$kna['SEARCH_TERM1'];
			$search2=$kna['SEARCH_TERM2'];
			$title=$kna['TITLE_CP'];
			$allowpos=$kna['ALLOW_POS'];
			$nielsen=$kna['NIELSEN_ID'];
			$member_card=$kna['MEMBER_CARD'];
			$vatnum=$kna['VATNUM'];
			$email=$kna['EMAIL'];
			$industry_key=$kna['INDUSTRY_KEY'];
			$account_group=$kna['ACCOUNT_GROUP'];
			$user=$kna['USER_CR'];
			$auth_group=$kna['AUTH_GROUP'];
			$st_send=$kna['ST_SEND'];
			$new_st=$kna['NEW_ST'];
			$st=$kna['ST'];
			$tgl=$kna['TGL'];
			$reasonreject=$kna['REASONREJECT'];
			$date_posting=$kna['DATE_POSTING'];
			$date_approved=$kna['DATE_APPROVED'];
			$date_is=$kna['DATE_IS'];
			$date_delete=$kna['DATE_DELETE'];
			$nik_approved=$kna['NIK_APPROVED'];
			$nik_is=$kna['NIK_IS'];
			$cust_class=$kna['CUST_CLASS'];
			$subject=$kna['SUBJECT'];
			$date_modif=$kna['DATE_MODIF'];
			$nik_modif=$kna['NIK_MODIF'];
		}
		
		
		$fieldKNB1="*";
		$kondisiKNB1="ID_CUST = '".$idCust."'";
		$KNB1=$this->oci_model->select($fieldKNB1, 'M_CUST_KNB1',$kondisiKNB1);
		foreach($KNB1 as $knb){
			$rec_account=$knb['RECONT_ACC'];
		}
		
		$fieldKNVV="*";
		$kondisiKNVV="ID_CUST = '".$idCust."'";
		$KNVV=$this->oci_model->select($fieldKNVV, 'M_CUST_KNVV',$kondisiKNVV);
		foreach($KNVV as $knvv){
			$sales_org=$knvv['SALES_ORG'];
			$dis_channel=$knvv['DIS_CHANNEL'];
			$division=$knvv['DIVISION'];
			$cust_group=$knvv['CUST_GROUP'];
			$inco1=$knvv['INCO1'];
			$inco2=$knvv['INCO2'];
			$curency=$knvv['CURR'];
			$top=$knvv['TOP'];
			$sales_office=$knvv['SALES_OFFICE'];
		}
		
		//Contact Person
		$fieldCP="*";
		$kondisiCP="ID_CUST = '".$idCust."'";
		$data['cp']=$this->oci_model->select($fieldCP, 'M_CONTACT_PERSON',$kondisiCP);
		
		//Get Data Name
		$this->load->model('sap_model');
		$data_company=$this->sap_model->getCompanyCode();
		$data_industry=$this->sap_model->getIndustry();
		$data_customer_class=$this->sap_model->getCustomerClass();
		$data_top=$this->sap_model->getTOP();
		$data_customer_group=$this->sap_model->getCustomerGroup();
		$data_incoterm=$this->sap_model->getIncoterm();
		$data_nielsen=$this->sap_model->getNielsen();
		$data_dis_channel=$this->sap_model->getDistributionChannel();
		$data_division=$this->sap_model->getDivision();
		$data_sales_org=$this->sap_model->getSalesOrganization();
		$data_region=$this->sap_model->getRegion($country_key);
		$data_sales_office=$this->sap_model->getSalesOffice();
		$data_account_group=$this->sap_model->getAccountGroup();
		$data_recon_account=$this->sap_model->getReconAccount();
		
		$data['txt_company']="";
		$data['txt_dischannel']="";
		$data['txt_division']="";
		$data['txt_region']="";
		$data['txt_region']="";
		$data['txt_nielsen']="";
		$data['txt_industry']="";
		$data['txt_custclass']="";
		$data['txt_top']="";
		$data['txt_salesoffice']="";
		$data['txt_inco1']="";
		$data['txt_account_group']="";
		$data['txt_recon']="";
		$data['txt_cust_group']="";
		$data['txt_sales_org']="";
		
		foreach($data_company as $key1 => $com){
			if($key1 == 0 and $com['BUKRS'] == ''){
			continue;}
			if($com['BUKRS'] == $company_code && $com['LAND1'] == 'ID'){
				$data['txt_company']=$com['BUTXT'];
			}
		}
		foreach($data_dis_channel as $key2 => $dis){
			
			if($key2 == 0 and !isset($dis['VTWEG'])){
			continue;}
			if($dis['VTWEG'] == $dis_channel){
				$data['txt_dischannel']=$dis['VTEXT'];
			}
		}
		foreach($data_division as $key3 => $div){
			
			if($key3 == 0 and !isset($div['SPART'])){
			continue;}
			if($div['SPART'] == $division){
				$data['txt_division']=$div['VTEXT'];
			}
		}
		foreach($data_region as $key4 => $reg){
			
			if($key4 == 0 and !isset($reg['BLAND'])){
			continue;}
			if($reg['BLAND'] == $region){
				$data['txt_region']=$reg['BEZEI'];
			}
		}
		
		foreach($data_nielsen as $key5 => $nil){
			if($key5 == 0 and !isset($nil['NIELS'])){
			continue;}
			if($nil['NIELS'] == $nielsen){
				$data['txt_nielsen']=$nil['BEZEI'];
			}
		}
		
		foreach($data_industry as $key6 => $ind){
			if($key6 == 0 and !isset($ind['BRSCH'])){
			continue;}
			if($ind['BRSCH'] == $industry_key){
				$data['txt_industry']=$ind['BRTXT'];
			}
		}
		foreach($data_customer_class as $key7 => $cs){
			if($key7 == 0 and !isset($cs['KUKLA'])){
			continue;}
			if($cs['KUKLA'] == $cust_class){
				$data['txt_custclass']=$cs['VTEXT'];
			}
		}
		
		foreach($data_top as $key8 => $tp){
			if($key8 == 0 and !isset($tp['ZTERM'])){
			continue;}
			if($tp['ZTERM'] == $top){
				$data['txt_top']=$tp['VTEXT'];
			}
		}
		
		foreach($data_sales_office as $key9 => $sof){
			if($key9 == 0 and !isset($sof['VKBUR'])){
			continue;}
			if($sof['VKBUR'] == $sales_office){
				$data['txt_salesoffice']=$sof['BEZEI'];
			}
		}
		foreach($data_incoterm as $key10 => $inc){
			if($key10 == 0 and !isset($inc['INCO1'])){
			continue;}
			if($inc['INCO1'] == $inco1){
				$data['txt_inco1']=$inc['BEZEI'];
			}
		}
		foreach($data_account_group as $key11 => $accg){
			if($key11 == 0 and !isset($accg['KTOKD'])){
			continue;}
			if($accg['KTOKD'] == $account_group){
				$data['txt_account_group']=$accg['TXT30'];
			}
		}
		foreach($data_recon_account as $key12 => $reca){
			if($key12 == 0 and !isset($reca['SAKNR'])){
			continue;}
			if($reca['SAKNR'] == $rec_account){
				$data['txt_recon']=$reca['TXT50'];
			}
		}
		
		foreach($data_customer_group as $key13 => $cgp){
			if($key13 == 0 and !isset($cgp['KDGRP'])){
			continue;}
			if($cgp['KDGRP'] == $cust_group){
				$data['txt_cust_group']=$cgp['KTEXT'];
			}
		}
		
		foreach($data_sales_org as $key14 => $sor){
			if($key14 == 0 and !isset($sor['VKORG'])){
			continue;}
			if($sor['VKORG'] == $sales_org){
				$data['txt_sales_org']=$sor['VTEXT'];
			}
		}
		
		$data['company_code']=$company_code;
		$data['account_group']=$account_group;
		$data['recon_account']=$rec_account;
		$data['dis_channel']=$dis_channel;
		$data['division']=$division;
		$data['title']=$title;
		$data['name1']=$name1;
		$data['name2']=$name2;
		$data['nickname']=$short_field;
		$data['search1']=$search1;
		$data['search2']=$search2;
		$data['address']=$address;
		$data['address2']=$address2;
		$data['address3']=$address3;
		$data['country']=$country_key;
		$data['region']=$region;
		$data['city']=$city;
		$data['postal_code']=$postal_code;
		$data['tlp']=$tlp1;
		$data['fax']=$fax;
		$data['hp']=$tlp2;
		$data['email']=$email;
		$data['allowpos']=$allowpos;
		$data['subject']=$subject;
		if($allowpos == "1"){
			$data['nielsen']=$nielsen;
		}else{
			$data['nielsen']="";
			$data['txt_nielsen']="";
		}
		
		$data['member_card']=$member_card;
		$data['industry']=$industry_key;
		$data['customer_class']=$cust_class;
		$data['vat']=$vatnum;
		$data['top']=$top;
		$data['sales_office']=$sales_office;
		$data['cust_group']=$cust_group;
		$data['curr']=$curency;
		$data['inco1']=$inco1;
		$data['inco2']=$inco2;
		$data['tgl_create']=$tgl;
		$data['tgl_posting']=$date_posting;
		$data['user_create']=$user;
		$data['tgl_approved']=$date_approved;
		$data['user_approved']=$nik_approved;
		$data['tgl_is']=$date_is;
		$data['user_is']=$nik_is;
		$data['status']=$new_st;
		$data['sales_org']=$sales_org;
		$data['tgl_modif']=$date_modif;
		$data['nik_modif']=$nik_modif;
		
		$data['main_content']="customer/form_posting_cust";
		$this->load->view('template/main',$data);
	}
	
	function get_no_hp($kunnr){
		$this->load->library('saprfc');	
		$this->load->library('sapauth');		
		
		$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
		//Cek Connection SAP Status	
		$data['content']=$this->saprfc->callFunction("BAPI_ADDRESSORG_GETDETAIL",
			array(	array("IMPORT","OBJ_TYPE","KNA1"),
				array("IMPORT","OBJ_ID",$kunnr),
				array("IMPORT","OBJ_ID_EXT",""),
				array("IMPORT","CONTEXT","0001"),
				array("IMPORT","IV_CURRENT_COMM_DATA","X"),
				array("TABLE","BAPIADTEL",array())
			     )
			); 	
		//echo $this->saprfc->printStatus();
		//echo $this->saprfc->getStatus();
		//echo "<br/><br/>";
		//echo "<pre>";
		//print_r($data['content']["BAPIADTEL"]);
		//echo "</pre>";
		//echo "Jumlah Data :".count($data['content']["BAPIADTEL"])."<br/>";
		$jml = count($data['content']["BAPIADTEL"]);
		if($jml > 0){
			foreach($data['content']["BAPIADTEL"] as $a){
				if($a['STD_RECIP'] == "X" && $a['R_3_USER'] == "3"){
					$hp = $a['TELEPHONE'];
				}else{
					$hp = "";
				}
			}
		}else{
			$hp="";
		}
		//echo "No HP = ".$hp;
		return $hp;
	}
	
	function get_email($kunnr){
		$this->load->library('saprfc');	
		$this->load->library('sapauth');		
		
		$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
		//Cek Connection SAP Status	
		$data['content']=$this->saprfc->callFunction("BAPI_ADDRESSORG_GETDETAIL",
			array(	array("IMPORT","OBJ_TYPE","KNA1"),
				array("IMPORT","OBJ_ID",$kunnr),
				array("IMPORT","OBJ_ID_EXT",""),
				array("IMPORT","CONTEXT","0001"),
				array("IMPORT","IV_CURRENT_COMM_DATA","X"),
				array("TABLE","BAPIADSMTP",array())
			     )
			); 	
		
		$jml = count($data['content']["BAPIADSMTP"]);
		if($jml > 0){
			foreach($data['content']["BAPIADSMTP"] as $a){
				if($a['STD_NO'] == "X" && $a['HOME_FLAG'] == "X"){
					$hp = $a['E_MAIL'];
				}else{
					$hp = "";
				}
			}
		}else{
			$hp="";
		}
		//echo "No HP = ".$hp;
		return $hp;
	}
	
	function role_user(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->my_auth->hak_akses("ADMINISTRATOR");
		
		$this->load->model('oci_model');
		$this->load->model('sso_model');
		//$usr=$this->session->userdata('NIK');
		$fieldSSO="NIK, GET_NAME_BY_NIK(NIK) as NAMA";
		$kondisiSSO="APP_CODE= 'CUST'";
		$data['nik_sso']=$this->sso_model->select($fieldSSO, 'M_USER_APP', $kondisiSSO);
		
		$field="NIK, DEV_USERS.GET_NAME_BY_NIK(NIK) as NAME ,ROLE";
		$kondisi="";
		$data['row']=$this->oci_model->select($field, 'M_CUST_ROLE',FALSE);
		$data['main_content']="customer/role_user";
		$this->load->view('template/main',$data);
	}
	
	//function test_function(){
	//	$this->load->model('oci_model');
	//	echo $this->oci_model->test();
	//}
	
	function  add_role(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->my_auth->hak_akses("ADMINISTRATOR");
		$this->load->model('oci_model');
		$this->load->model('sso_model');
		//$usr=$this->session->userdata('NIK');
		$nik=$this->input->post('nik');
		$role=$this->input->post('role');
		$stCekRole=$this->oci_model->cekRole($nik,$role);
		
		if($stCekRole > 0){
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				User & Role already exists </div>');
			    redirect(site_url('customer/role_user'));;
		}
		$fieldRole='NIK, ROLE';
		$valueRole= "'".$nik."', '".$role."'";
		$exec=$this->oci_model->Exec($fieldRole, $valueRole, 'M_CUST_ROLE', FALSE, 'insert');
		
		
		$field="NIK, DEV_USERS.GET_NAME_BY_NIK(NIK) as NAME ,ROLE";
		$kondisi="";
		$data['row']=$this->oci_model->select($field, 'M_CUST_ROLE',FALSE);

		$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Success! </div>');
			    redirect(site_url('customer/role_user'));;
	}
	
	function hapus_role(){
		$this->load->model('oci_model');
		$nik=$this->input->post('nik');
		$role=$this->input->post('role');
		
		$kondisi="NIK = '".$nik."' AND ROLE = '".$role."'";
		$this->oci_model->Exec(FALSE, FALSE, 'M_CUST_ROLE', $kondisi, 'delete');
		$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Delete role success</div>');
	}
	
	function form_edit_role(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$this->load->model('sso_model');
		$nik=$this->uri->segment(3);
		$role=$this->uri->segment(4);
		
		$fieldDet="*";
		$kondisiDet="NIK = '$nik' and ROLE = '$role'";
		$det=$this->oci_model->select($fieldDet, "M_CUST_ROLE", $kondisiDet);
		foreach($det as $a){
			$data['xnik']=$a['NIK'];
			$data['xrole']=$a['ROLE'];
		}
		$fieldSSO="NIK, GET_NAME_BY_NIK(NIK) as NAMA";
		$kondisiSSO="APP_CODE= 'CUST'";
		$data['nik_sso']=$this->sso_model->select($fieldSSO, 'M_USER_APP', $kondisiSSO);
		$field="NIK, DEV_USERS.GET_NAME_BY_NIK(NIK) as NAME ,ROLE";
		$kondisi="";
		$data['row']=$this->oci_model->select($field, 'M_CUST_ROLE',FALSE);
		$data['main_content']="customer/form_edit_role";
		$this->load->view('template/main',$data);	
	}
	
	function edit_role(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->my_auth->hak_akses("ADMINISTRATOR");
		$this->load->model('oci_model');
		$this->load->model('sso_model');
		//$usr=$this->session->userdata('NIK');
		$nik=$this->input->post('nik');
		$role=$this->input->post('role');
		$role_lama=$this->input->post('role_lama');
		
		$stCekRole=$this->oci_model->cekRole($nik,$role);
		if($stCekRole > 0){
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				User & Role already exists </div>');
			    redirect(site_url('customer/role_user'));;
		}
		
		$kondisi="NIK = '".$nik."' AND ROLE = '".$role_lama."'";
		$this->oci_model->Exec(FALSE, FALSE, 'M_CUST_ROLE', $kondisi, 'delete');
		
		
		$fieldRole='NIK, ROLE';
		$valueRole= "'".$nik."', '".$role."'";
		$exec=$this->oci_model->Exec($fieldRole, $valueRole, 'M_CUST_ROLE', FALSE, 'insert');
		
		$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Success! </div>');
			    redirect(site_url('customer/role_user'));
	}
	
	
	function user_privilege(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->my_auth->hak_akses("ADMINISTRATOR");
		
		$this->load->model('oci_model');
		$this->load->model('sso_model');
		$this->load->model('sap_model');

		$fieldSSO="NIK, GET_NAME_BY_NIK(NIK) as NAMA";
		$kondisiSSO="APP_CODE= 'CUST'";
		$data['nik_sso']=$this->sso_model->select($fieldSSO, 'M_USER_APP', $kondisiSSO);
		
		$field="NIK, DEV_USERS.GET_NAME_BY_NIK(NIK) as NAME ,SALES_ORG, DIS_CHANNEL, DIVISION";
		$kondisi="";
		$data['row']=$this->oci_model->select($field, 'M_CUST_PRIVILEGE',FALSE);
		$data['dis_channel']=$this->sap_model->getDistributionChannel();
		$data['division']=$this->sap_model->getDivision();
		$data['sales_org']=$this->sap_model->getSalesOrganization();
		$data['main_content']="customer/user_privilege";
		$this->load->view('template/main',$data);
	}
	
	function add_priv(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->my_auth->hak_akses("ADMINISTRATOR");
		$this->load->model('oci_model');
		$this->load->model('sso_model');
		//$usr=$this->session->userdata('NIK');
		$nik=$this->input->post('nik');
		$sales_org=$this->input->post('sales_org');
		$dis_channel=$this->input->post('dis_channel');
		$division=$this->input->post('division');
		
		$stCekPriv=$this->oci_model->cekPriv($nik,$sales_org, $dis_channel, $division);
		if($stCekPriv > 0){
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				User & Role already exists </div>');
			    redirect(site_url('customer/user_privilege'));;
		}
		$fieldRole='NIK, SALES_ORG, DIS_CHANNEL, DIVISION';
		$valueRole= "'".$nik."', '".$sales_org."', '".$dis_channel."', '".$division."'";
		$exec=$this->oci_model->Exec($fieldRole, $valueRole, 'M_CUST_PRIVILEGE', FALSE, 'insert');
		
		$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Success! </div>');
			    redirect(site_url('customer/user_privilege'));
	}
	
	function hapus_priv(){
		$this->load->model('oci_model');
		$nik=$this->input->post('nik');
		$sales_org=$this->input->post('sales_org');
		$dis_channel=$this->input->post('dis_channel');
		$division=$this->input->post('division');
		
		$kondisi="NIK = '".$nik."' AND SALES_ORG = '".$sales_org."' AND DIS_CHANNEL ='".$dis_channel."' AND DIVISION = '".$division."'";
		$this->oci_model->Exec(FALSE, FALSE, 'M_CUST_PRIVILEGE', $kondisi, 'delete');
		$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Delete privilege success</div>');
	}
	
	function konfigurasi(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->my_auth->hak_akses("ADMINISTRATOR");
		
		$this->load->model('oci_model');
		$this->load->model('sso_model');
		$this->load->model('sap_model');

		
		$field="*";
		$kondisi="";
		$data['row']=$this->oci_model->select($field, 'M_CUST_KONF',FALSE);
		
		$data['company']=$this->sap_model->getCompanyCode();
		$data['dis_channel']=$this->sap_model->getDistributionChannel();
		$data['division']=$this->sap_model->getDivision();
		$data['sales_org']=$this->sap_model->getSalesOrganization();
		
		$data['main_content']="customer/konfigurasi";
		$this->load->view('template/main',$data);
	}
	
	function add_konfigurasi(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->my_auth->hak_akses("ADMINISTRATOR");
		$this->load->model('oci_model');
		$this->load->model('sso_model');
		//$usr=$this->session->userdata('NIK');
		$company=$this->input->post('company');
		$sales_org=$this->input->post('sales_org');
		$dis_channel=$this->input->post('dis_channel');
		$division=$this->input->post('division');
		$cust=$this->input->post('cust');
		
		$stCekComp=$this->oci_model->cekCompany($company ,$sales_org, $dis_channel, $division);
		if($stCekComp > 0){
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Configuration already exists </div>');
			    redirect(site_url('customer/konfigurasi'));;
		}
		$fieldRole='COMPANY_CODE, SALES_ORG, DIS_CHANNEL, DIVISION, CUST_REF';
		$valueRole= "'".$company."', '".$sales_org."', '".$dis_channel."', '".$division."', '".$cust."'";
		$exec=$this->oci_model->Exec($fieldRole, $valueRole, 'M_CUST_KONF', FALSE, 'insert');
		
		$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Success! </div>');
			    redirect(site_url('customer/konfigurasi'));;
	}
	
	function hapus_konfigurasi(){
		$this->load->model('oci_model');
		
		$company=$this->input->post('company');
		$sales_org=$this->input->post('sales_org');
		$dis_channel=$this->input->post('dis_channel');
		$division=$this->input->post('division');
		
		$kondisi="COMPANY_CODE ='".$company."' AND SALES_ORG ='".$sales_org."' AND DIS_CHANNEL='".$dis_channel."' AND DIVISION = '".$division."'";
		$this->oci_model->Exec(FALSE, FALSE, 'M_CUST_KONF', $kondisi, 'delete');
		$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Delete configuration succes/div>');
	}
	
	function extend_history(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$this->load->model('sap_model');
		//$usr=$this->session->userdata('NIK');
		$field="*";
		$kondisi="";
		$data['row']=$this->oci_model->select($field, 'VW_CUST_EXTEND',FALSE);
		$data['company']=$this->sap_model->getCompanyCode();
		$data['main_content']="customer/extend_history";
		$this->load->view('template/main',$data);	
	}
	
	function extend_history_filter(){
		
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}	
		$tgl1 = $this->input->post('tgl1');
		$tgl2 = $this->input->post('tgl2');
		$company_code = $this->input->post('company');
		$urlX = "customer/extend_history_result/".$tgl1."/".$tgl2."/".$company_code;
	    redirect($urlX);
	}
	
	function extend_history_result($tg1=false, $tgl2=false, $company_code=false){
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
		$data['row']=$this->oci_model->select($field, "VW_CUST_EXTEND","COMPANY2='$company_code' AND TO_DATE(DATE_CREATE,'dd-mm-yyyy hh24:mi') >=TO_DATE('$tgl1','dd-mm-yyyy hh24:mi') AND TO_DATE(DATE_CREATE,'dd-mm-yyyy hh24:mi') <=TO_DATE('$tgl2','dd-mm-yyyy hh24:mi')"); 
		$data['company']=$this->sap_model->getCompanyCode();
		$data['company_code']=$company_code;
		$data['main_content']="customer/extend_history_result";
		$this->load->view('template/main',$data);	
	}
	function edit_history(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$this->load->model('sap_model');
		//$usr=$this->session->userdata('NIK');
		$field="*";
		$kondisi="";
		$data['row']=$this->oci_model->select($field, 'VW_CUST_EDIT',FALSE);
		$data['company']=$this->sap_model->getCompanyCode();
		$data['main_content']="customer/edit_history";
		$this->load->view('template/main',$data);	
	}
	
	function edit_history_result($tg1=false, $tgl2=false, $company_code=false){
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
		$data['row']=$this->oci_model->select($field, "VW_CUST_EDIT","company_code='$company_code' AND TO_DATE(TGL,'dd-mm-yyyy hh24:mi') >=TO_DATE('$tgl1','dd-mm-yyyy hh24:mi') AND TO_DATE(TGL,'dd-mm-yyyy hh24:mi') <=TO_DATE('$tgl2','dd-mm-yyyy hh24:mi')"); 
		$data['company']=$this->sap_model->getCompanyCode();
		$data['company_code']=$company_code;
		$data['main_content']="customer/edit_history_result";
		$this->load->view('template/main',$data);	
	}
	
	function edit_history_filter(){
		
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}	
		$tgl1 = $this->input->post('tgl1');
		$tgl2 = $this->input->post('tgl2');
		$company_code = $this->input->post('company');
		$urlX = "customer/edit_history_result/".$tgl1."/".$tgl2."/".$company_code;
	    redirect($urlX);
	}
	
	function test1234(){
		$this->load->library('saprfc');	
		$this->load->library('sapauth');		
		
		$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
		//Cek Connection SAP Status	
		$data['content']=$this->saprfc->callFunction("ZBAPI_CHANGE_HP_CUSTOMER2",
			array(	array("IMPORT","XKUNNR","0001105450"),
				array("IMPORT","NO_HP","0800000030"),
				array("IMPORT","XCONS","016"),
				array("TABLE", "ZBAPIADTEL", array())
			     )
			); 	
		echo $this->saprfc->printStatus();
		echo $this->saprfc->getStatus();
		
		echo "<pre>";
		print_r($data['content']['ZBAPIADTEL']);
		echo "</pre>";
	}
	
	function get_sales_office(){
		$this->load->model('sap_model');
		$this->load->model('oci_model');
		$company=$this->input->post('id');
		
		$in=substr($company, 0, 1);
		
		//get data konfigurasi
		$field="DISTINCT(SALES_ORG)";
		$kondisi="COMPANY_CODE = '$company'";
		
		$dataSalesOffice=$this->sap_model->getSalesOffice();
		echo '<select name="sales_office" id="sales_office" class="span6" placeholder="Sales Office">
			<option></option>';
			
		foreach($dataSalesOffice as $key11 => $sof){
			if($key11 == 0 and !isset($sof['VKBUR'])){
				continue;}
				$x=substr($sof['VKBUR'],0,1);
				if($x == "2"){
					if($in == $x){
						if($sof['VKBUR'] < "2003"){
							echo "<option value='".$sof['VKBUR']."'>".$sof['VKBUR']." - ".$sof['BEZEI']."</option>";
						}
						
					}
				}else{
					if($in == $x){
						echo "<option value='".$sof['VKBUR']."'>".$sof['VKBUR']." - ".$sof['BEZEI']."</option>";
					}
				}
				
				
			}
		
		echo '</select>';
	}
	
	function tes_mail(){
		
		$config = array(
				'protocol'  => 'smtp',
				'smtp_host' => 'daemonsmtp.vivere.co.id',
				'smtp_port' => 25,
				'smtp_user' => 'hendra.nugroho@vivere.co.id',
				'smtp_pass' => 'ggs2007',
				'mailtype'  => 'html',
				'charset'   => 'utf-8',
				'wordwrap'  => TRUE
			);
		$this->load->library('email',$config);

		$this->email->from('hendra@vivere.co.id', 'HENDRA');
		//$this->email->to(trim($getemail));		//fito.tatontos@gmail.com
		$this->email->to('roni.kurniawan@vivere.co.id');
		//$this->email->cc('laely.oktaviaty@vivere.co.id');			
		//$this->email->bcc('fito.tatontos@vivere.co.id');
		
		$this->email->subject( 'TES EMAIL HENDRA' );
		$data['NIK']="aaaa";
		$this->email->message( $this->load->view('mailer/mail_template', $data,true) );
		$this->email->send();
	}
	
	function send_mail($to, $subject, $jenis, $type, $nama, $id_req){
		$this->load->model('oci_model');
		$fieldS="*";
		$kondisiS="ID = '1'";
		$emailData=$this->oci_model->select($fieldS, 'M_SETTING',$kondisiS);
		foreach($emailData as $a){
			$host=$a['SMTP_HOST'];
			$port=$a['SMTP_PORT'];
			$user=$a['SMTP_USER'];
			$pass=$a['SMTP_PASSWORD'];
			$data['url_app']=$a['URL_APP'];
			//--------------------------------------
			//Posting New Customer 
			$subject_posting_new=$a['SUBJECT_POSTING1'];
			$data['header_new_post']=$a['HEADER_EMAIL_POSTING1'];
			$data['body_new_post']=$a['BODY_EMAIL_POSTING1'];
			$data['footer_new_post']=$a['FOOTER_EMAIL_POSTING1'];
			
			//Approve New Customer
			$subject_approve_new=$a['SUBJECT_APPROVE1'];
			$data['header_new_approve']=$a['HEADER_EMAIL_APPROVE1'];
			$data['body_new_approve']=$a['BODY_EMAIL_APPROVE1'];
			$data['footer_new_approve']=$a['FOOTER_EMAIL_APPROVE1'];
			
			//Transport New Customer
			$subject_transport_new=$a['SUBJECT_TRANSPORT1'];
			$data['header_new_transport']=$a['HEADER_EMAIL_TRANSPORT1'];
			$data['body_new_transport']=$a['BODY_EMAIL_TRANSPORT1'];
			$data['footer_new_transport']=$a['FOOTER_EMAIL_TRANSPORT1'];
			
			//-------------------------------------
			//Posting Extend Customer
			$subject_posting_ex=$a['SUBJECT_POSTING2'];
			$data['header_ex_post']=$a['HEADER_EMAIL_POSTING2'];
			$data['body_ex_post']=$a['BODY_EMAIL_POSTING2'];
			$data['footer_ex_post']=$a['FOOTER_EMAIL_POSTING2'];
			
			//Approve Extend Customer
			$subject_approve_ex=$a['SUBJECT_APPROVE2'];
			$data['header_ex_approve']=$a['HEADER_EMAIL_APPROVE2'];
			$data['body_ex_approve']=$a['BODY_EMAIL_APPROVE2'];
			$data['footer_ex_approve']=$a['FOOTER_EMAIL_APPROVE2'];
			
			//Transport Extend Customer
			$subject_transport_ex=$a['SUBJECT_TRANSPORT2'];
			$data['header_ex_transport']=$a['HEADER_EMAIL_TRANSPORT2'];
			$data['body_ex_transport']=$a['BODY_EMAIL_TRANSPORT2'];
			$data['footer_ex_transport']=$a['FOOTER_EMAIL_TRANSPORT2'];
			
			
			//-------------------------------------
			//Posting Change Customer
			$subject_posting_change=$a['SUBJECT_POSTING3'];
			$data['header_change_post']=$a['HEADER_EMAIL_POSTING3'];
			$data['body_change_post']=$a['BODY_EMAIL_POSTING3'];
			$data['footer_change_post']=$a['FOOTER_EMAIL_POSTING3'];
			
			//Approve Change Customer
			$subject_approve_change=$a['SUBJECT_APPROVE3'];
			$data['header_change_approve']=$a['HEADER_EMAIL_APPROVE3'];
			$data['body_change_approve']=$a['BODY_EMAIL_APPROVE3'];
			$data['footer_change_approve']=$a['FOOTER_EMAIL_APPROVE3'];
			
			//Transport Change Customer
			$subject_transport_change=$a['SUBJECT_TRANSPORT3'];
			$data['header_change_transport']=$a['HEADER_EMAIL_TRANSPORT3'];
			$data['body_change_transport']=$a['BODY_EMAIL_TRANSPORT3'];
			$data['footer_change_transport']=$a['FOOTER_EMAIL_TRANSPORT3'];
			
			
			//CP
			$subject_cp_req=$a['SUBJECT_CP_REQ'];
			$data['header_cp_req']=$a['HEADER_CP_REQ'];
			$data['body_cp_req']=$a['BODY_CP_REQ'];
			$data['footer_cp_req']=$a['FOOTER_CP_REQ'];
			
			$subject_cp_transport=$a['SUBJECT_CP_TRANSPORT'];
			$data['header_cp_transport']=$a['HEADER_CP_TRANSPORT'];
			$data['body_cp_transport']=$a['BODY_CP_TRANSPORT'];
			$data['footer_cp_transport']=$a['FOOTER_CP_TRANSPORT'];
		}
		
		$config = array(
			'protocol'  => 'smtp',
			'smtp_host' => $host,
			'smtp_port' => $port,
			'smtp_user' => $user,
			'smtp_pass' => $pass,
			'mailtype'  => 'html',
			'charset'   => 'utf-8',
			'wordwrap'  => TRUE
		);
		$this->load->library('email',$config);
		
		$this->email->from($user, 'MASTER DATA');
		//$this->email->to(trim($getemail));		//fito.tatontos@gmail.com
		$this->email->to($to);
		//$this->email->cc('laely.oktaviaty@vivere.co.id');			
		//$this->email->bcc('fito.tatontos@vivere.co.id');
		$data['nama']=$nama;
		$data['type']=$type;
		$data['id_req']=$id_req;
		
		
		if($jenis == "requestor"){
			if($type == "new"){
				$this->email->subject($subject_posting_new);
			}elseif($type == "edit"){
				$this->email->subject($subject_posting_change);
			}else{
				$this->email->subject($subject_posting_ex);
			}
			$this->email->message( $this->load->view('mailer/mail_template_requester', $data,true) );
		}elseif($jenis == "approval"){
			if($type == "new"){
				$this->email->subject($subject_approve_new);
			}elseif($type == "edit"){
				$this->email->subject($subject_approve_change);
			}else{
				$this->email->subject($subject_approve_ex);
			}
			$this->email->message( $this->load->view('mailer/mail_template_accounting', $data,true) );
		}elseif($jenis == "cp"){
			if($type == "post"){
				$this->email->subject($subject_cp_req);
				$this->email->message( $this->load->view('mailer/mail_template_cp_req', $data,true) );
			}elseif($type == "konfirm"){
				$this->email->subject($subject_cp_transport);
				$this->email->message( $this->load->view('mailer/mail_template_cp_konfirm', $data,true) );
			}
			
		}else{
			if($type == "new"){
				$this->email->subject($subject_transport_new);
			}elseif($type == "edit"){
				$this->email->subject($subject_transport_change);
			}else{
				$this->email->subject($subject_transport_ex);
			}
			$this->email->message( $this->load->view('mailer/mail_template_masterdata', $data,true) );
		}
		
		$this->email->send();
	}
	
	
	function send_mail2($to, $subject, $jenis, $nama, $kunnr){
		$fieldS="*";
		$kondisiS="ID = '1'";
		$emailData=$this->oci_model->select($fieldS, 'M_SETTING',$kondisiS);
		foreach($emailData as $a){
			$host=$a['SMTP_HOST'];
			$port=$a['SMTP_PORT'];
			$user=$a['SMTP_USER'];
			$pass=$a['SMTP_PASSWORD'];
		}
		
		$config = array(
			'protocol'  => 'smtp',
			'smtp_host' => $host,
			'smtp_port' => $port,
			'smtp_user' => $user,
			'smtp_pass' => $pass,
			'mailtype'  => 'html',
			'charset'   => 'utf-8',
			'wordwrap'  => TRUE
		);
		$this->load->library('email',$config);
		
		$this->email->from($user, 'IS TEAM');
		//$this->email->to(trim($getemail));		//fito.tatontos@gmail.com
		$this->email->to($to);
		//$this->email->cc('laely.oktaviaty@vivere.co.id');			
		//$this->email->bcc('fito.tatontos@vivere.co.id');
		
		$this->email->subject($subject);
		$data['nama']=$nama;
		$data['kunnr']=$kunnr;
		if($jenis == "requestor"){
			$this->email->message( $this->load->view('mailer/mail_template_requester', $data,true) );
		}elseif($jenis == "approval"){
			$this->email->message( $this->load->view('mailer/mail_template_accounting', $data,true) );
		}else{
			$this->email->message( $this->load->view('mailer/mail_template_masterdata', $data,true) );
		}
		
		$this->email->send();
	}
	
	
	function test_mail(){
		$this->load->model('oci_model');
		$fieldS="*";
		$kondisiS="ID = '1'";
		$emailData=$this->oci_model->select($fieldS, 'M_SETTING',$kondisiS);
		foreach($emailData as $a){
			$host=$a['SMTP_HOST'];
			$port=$a['SMTP_PORT'];
			$user=$a['SMTP_USER'];
			$pass=$a['SMTP_PASSWORD'];
		}
		$config = array(
			'protocol'  => 'smtp',
			'smtp_host' => $host,
			'smtp_port' => $port,
			'smtp_user' => $user,
			'smtp_pass' => $pass,
			'mailtype'  => 'html',
			'charset'   => 'utf-8',
			'wordwrap'  => TRUE
		);
		$this->load->library('email',$config);
		
		$this->email->from('administrator@vivere.co.id', 'ADMINISTRATOR');
		//$this->email->to(trim($getemail));		//fito.tatontos@gmail.com
		$this->email->to('hendra.nugroho@vivere.co.id');
		//$this->email->cc('laely.oktaviaty@vivere.co.id');			
		//$this->email->bcc('fito.tatontos@vivere.co.id');
		
		$this->email->subject('teees');
		$data['nama']="";
		
			$this->email->message("adasdasdas");
		
		$this->email->send();
	}
	
	function email_setting(){
		$this->load->model('oci_model');
		$fieldS="*";
		$kondisiS="ID = '1'";
		$emailData=$this->oci_model->select($fieldS, 'M_SETTING',$kondisiS);
		foreach($emailData as $a){
			$data['url']=$a['URL_APP'];
			$data['smtp_port']=$a['SMTP_PORT'];
			$data['smtp_host']=$a['SMTP_HOST'];
			$data['smtp_user']=$a['SMTP_USER'];
			$data['smtp_password']=$a['SMTP_PASSWORD'];
			
			
			//--------------------------------------
			//Posting New Customer 
			$data['subject_posting_new']=$a['SUBJECT_POSTING1'];
			$data['header_new_post']=$a['HEADER_EMAIL_POSTING1'];
			$data['body_new_post']=$a['BODY_EMAIL_POSTING1'];
			$data['footer_new_post']=$a['FOOTER_EMAIL_POSTING1'];
			
			//Approve New Customer
			$data['subject_approve_new']=$a['SUBJECT_APPROVE1'];
			$data['header_new_approve']=$a['HEADER_EMAIL_APPROVE1'];
			$data['body_new_approve']=$a['BODY_EMAIL_APPROVE1'];
			$data['footer_new_approve']=$a['FOOTER_EMAIL_APPROVE1'];
			
			//Transport New Customer
			$data['subject_transport_new']=$a['SUBJECT_TRANSPORT1'];
			$data['header_new_transport']=$a['HEADER_EMAIL_TRANSPORT1'];
			$data['body_new_transport']=$a['BODY_EMAIL_TRANSPORT1'];
			$data['footer_new_transport']=$a['FOOTER_EMAIL_TRANSPORT1'];
			
			//-------------------------------------
			//Posting Extend Customer
			$data['subject_posting_ex']=$a['SUBJECT_POSTING2'];
			$data['header_ex_post']=$a['HEADER_EMAIL_POSTING2'];
			$data['body_ex_post']=$a['BODY_EMAIL_POSTING2'];
			$data['footer_ex_post']=$a['FOOTER_EMAIL_POSTING2'];
			
			//Approve Extend Customer
			$data['subject_approve_ex']=$a['SUBJECT_APPROVE2'];
			$data['header_ex_approve']=$a['HEADER_EMAIL_APPROVE2'];
			$data['body_ex_approve']=$a['BODY_EMAIL_APPROVE2'];
			$data['footer_ex_approve']=$a['FOOTER_EMAIL_APPROVE2'];
			
			//Transport Extend Customer
			$data['subject_transport_ex']=$a['SUBJECT_TRANSPORT2'];
			$data['header_ex_transport']=$a['HEADER_EMAIL_TRANSPORT2'];
			$data['body_ex_transport']=$a['BODY_EMAIL_TRANSPORT2'];
			$data['footer_ex_transport']=$a['FOOTER_EMAIL_TRANSPORT2'];
			
			
			//-------------------------------------
			//Posting Change Customer
			$data['subject_posting_change']=$a['SUBJECT_POSTING3'];
			$data['header_change_post']=$a['HEADER_EMAIL_POSTING3'];
			$data['body_change_post']=$a['BODY_EMAIL_POSTING3'];
			$data['footer_change_post']=$a['FOOTER_EMAIL_POSTING3'];
			
			//Approve Change Customer
			$data['subject_approve_change']=$a['SUBJECT_APPROVE3'];
			$data['header_change_approve']=$a['HEADER_EMAIL_APPROVE3'];
			$data['body_change_approve']=$a['BODY_EMAIL_APPROVE3'];
			$data['footer_change_approve']=$a['FOOTER_EMAIL_APPROVE3'];
			
			//Transport Change Customer
			$data['subject_transport_change']=$a['SUBJECT_TRANSPORT3'];
			$data['header_change_transport']=$a['HEADER_EMAIL_TRANSPORT3'];
			$data['body_change_transport']=$a['BODY_EMAIL_TRANSPORT3'];
			$data['footer_change_transport']=$a['FOOTER_EMAIL_TRANSPORT3'];
			
			//CP
			$data['subject_cp_req']=$a['SUBJECT_CP_REQ'];
			$data['header_cp_req']=$a['HEADER_CP_REQ'];
			$data['body_cp_req']=$a['BODY_CP_REQ'];
			$data['footer_cp_req']=$a['FOOTER_CP_REQ'];
			
			$data['subject_cp_transport']=$a['SUBJECT_CP_TRANSPORT'];
			$data['header_cp_transport']=$a['HEADER_CP_TRANSPORT'];
			$data['body_cp_transport']=$a['BODY_CP_TRANSPORT'];
			$data['footer_cp_transport']=$a['FOOTER_CP_TRANSPORT'];
			
		}
		$data['main_content']="customer/email_setting";
		$this->load->view('template/main',$data);
		
	}
	function save_email_cp_req(){
		$this->load->model('oci_model');
		
		$subject=$this->input->post('subject_cp_req');
		$header=$this->input->post('header_cp_req');
		$body=$this->input->post('body_cp_req');
		$footer=$this->input->post('footer_cp_req');
		
		$field="SUBJECT_CP_REQ = '".$subject."', HEADER_CP_REQ = '".$header."', BODY_CP_REQ = '".$body."', FOOTER_CP_REQ = '".$footer."'";
		$kondisi="ID = '1'";
		$exec=$this->oci_model->Exec($field, false, 'M_SETTING', $kondisi, 'update');
		if($exec == 1){
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Save Success</div>');
			redirect('customer/email_setting');
		}
	}
	
	
	function save_email_transport_cp(){
		$this->load->model('oci_model');
		
		$subject=$this->input->post('subject_cp_transport');
		$header=$this->input->post('header_cp_transport');
		$body=$this->input->post('body_cp_transport');
		$footer=$this->input->post('footer_cp_transport');
		
		$field="SUBJECT_CP_TRANSPORT = '".$subject."', HEADER_CP_TRANSPORT = '".$header."', BODY_CP_TRANSPORT = '".$body."', FOOTER_CP_TRANSPORT = '".$footer."'";
		$kondisi="ID = '1'";
		$exec=$this->oci_model->Exec($field, false, 'M_SETTING', $kondisi, 'update');
		if($exec == 1){
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Save Success</div>');
			redirect('customer/email_setting');
		}
	}
	function save_email_posting_new(){
		$this->load->model('oci_model');
		
		$subject=$this->input->post('subject_posting_new');
		$header=$this->input->post('header_posting_new');
		$body=$this->input->post('body_posting_new');
		$footer=$this->input->post('footer_posting_new');
		
		$field="SUBJECT_POSTING1 = '".$subject."', HEADER_EMAIL_POSTING1 = '".$header."', BODY_EMAIL_POSTING1 = '".$body."', FOOTER_EMAIL_POSTING1 = '".$footer."'";
		$kondisi="ID = '1'";
		$exec=$this->oci_model->Exec($field, false, 'M_SETTING', $kondisi, 'update');
		if($exec == 1){
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Save Success</div>');
			redirect('customer/email_setting');
		}
	}
	
	function save_email_approval_new(){
		$this->load->model('oci_model');
		
		$subject=$this->input->post('subject_approve_new');
		$header=$this->input->post('header_approve_new');
		$body=$this->input->post('body_approve_new');
		$footer=$this->input->post('footer_approve_new');
		
		$field="SUBJECT_APPROVE1 = '".$subject."', HEADER_EMAIL_APPROVE1 = '".$header."', BODY_EMAIL_APPROVE1 = '".$body."', FOOTER_EMAIL_APPROVE1 = '".$footer."'";
		$kondisi="ID = '1'";
		$exec=$this->oci_model->Exec($field, false, 'M_SETTING', $kondisi, 'update');
		if($exec == 1){
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Save Success</div>');
			redirect('customer/email_setting');
		}
	}
	
	function save_email_transport_new(){
		$this->load->model('oci_model');
		
		$subject=$this->input->post('subject_transport_new');
		$header=$this->input->post('header_transport_new');
		$body=$this->input->post('body_transport_new');
		$footer=$this->input->post('footer_transport_new');
		
		$field="SUBJECT_TRANSPORT1 = '".$subject."', HEADER_EMAIL_TRANSPORT1 = '".$header."', BODY_EMAIL_TRANSPORT1 = '".$body."', FOOTER_EMAIL_TRANSPORT1 = '".$footer."'";
		$kondisi="ID = '1'";
		$exec=$this->oci_model->Exec($field, false, 'M_SETTING', $kondisi, 'update');
		if($exec == 1){
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Save Success</div>');
			redirect('customer/email_setting');
		}
	}
	
	function save_email_posting_extend(){
		$this->load->model('oci_model');
		
		$subject=$this->input->post('subject_posting_extend');
		$header=$this->input->post('header_posting_extend');
		$body=$this->input->post('body_posting_extend');
		$footer=$this->input->post('footer_post_extend');
		
		$field="SUBJECT_POSTING2 = '".$subject."', HEADER_EMAIL_POSTING2 = '".$header."', BODY_EMAIL_POSTING2 = '".$body."', FOOTER_EMAIL_POSTING2 = '".$footer."'";
		$kondisi="ID = '1'";
		$exec=$this->oci_model->Exec($field, false, 'M_SETTING', $kondisi, 'update');
		if($exec == 1){
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Save Success</div>');
			redirect('customer/email_setting');
		}
	}
	
	function save_email_approval_extend(){
		$this->load->model('oci_model');
		
		$subject=$this->input->post('subject_approve_extend');
		$header=$this->input->post('header_approve_extend');
		$body=$this->input->post('body_approve_extend');
		$footer=$this->input->post('footer_approve_extend');
		
		$field="SUBJECT_APPROVE2 = '".$subject."', HEADER_EMAIL_APPROVE2 = '".$header."', BODY_EMAIL_APPROVE2 = '".$body."', FOOTER_EMAIL_APPROVE2 = '".$footer."'";
		$kondisi="ID = '1'";
		$exec=$this->oci_model->Exec($field, false, 'M_SETTING', $kondisi, 'update');
		if($exec == 1){
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Save Success</div>');
			redirect('customer/email_setting');
		}
	}
	
	function save_email_transport_extend(){
		$this->load->model('oci_model');
		
		$subject=$this->input->post('subject_transport_extend');
		$header=$this->input->post('header_transport_extend');
		$body=$this->input->post('body_transport_extend');
		$footer=$this->input->post('footer_transport_extend');
		
		$field="SUBJECT_TRANSPORT2 = '".$subject."', HEADER_EMAIL_TRANSPORT2 = '".$header."', BODY_EMAIL_TRANSPORT2 = '".$body."', FOOTER_EMAIL_TRANSPORT2 = '".$footer."'";
		$kondisi="ID = '1'";
		$exec=$this->oci_model->Exec($field, false, 'M_SETTING', $kondisi, 'update');
		if($exec == 1){
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Save Success</div>');
			redirect('customer/email_setting');
		}
	}
	
	function save_email_posting_change(){
		$this->load->model('oci_model');
		
		$subject=$this->input->post('subject_posting_change');
		$header=$this->input->post('header_posting_change');
		$body=$this->input->post('body_posting_change');
		$footer=$this->input->post('footer_posting_change');
		
		$field="SUBJECT_POSTING3 = '".$subject."', HEADER_EMAIL_POSTING3 = '".$header."', BODY_EMAIL_POSTING3 = '".$body."', FOOTER_EMAIL_POSTING3 = '".$footer."'";
		$kondisi="ID = '1'";
		$exec=$this->oci_model->Exec($field, false, 'M_SETTING', $kondisi, 'update');
		if($exec == 1){
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Save Success</div>');
			redirect('customer/email_setting');
		}
	}
	
	function save_email_approval_change(){
		$this->load->model('oci_model');
		
		$subject=$this->input->post('subject_approve_change');
		$header=$this->input->post('header_approve_change');
		$body=$this->input->post('body_approve_change');
		$footer=$this->input->post('footer_approve_change');
		
		$field="SUBJECT_APPROVE3 = '".$subject."', HEADER_EMAIL_APPROVE3 = '".$header."', BODY_EMAIL_APPROVE3 = '".$body."', FOOTER_EMAIL_APPROVE3 = '".$footer."'";
		$kondisi="ID = '1'";
		$exec=$this->oci_model->Exec($field, false, 'M_SETTING', $kondisi, 'update');
		if($exec == 1){
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Save Success</div>');
			redirect('customer/email_setting');
		}
	}
	
	function save_email_transport_change(){
		$this->load->model('oci_model');
		
		$subject=$this->input->post('subject_transport_change');
		$header=$this->input->post('header_transport_change');
		$body=$this->input->post('body_transport_change');
		$footer=$this->input->post('footer_transport_change');
		
		$field="SUBJECT_TRANSPORT3 = '".$subject."', HEADER_EMAIL_TRANSPORT3 = '".$header."', BODY_EMAIL_TRANSPORT3 = '".$body."', FOOTER_EMAIL_TRANSPORT3 = '".$footer."'";
		$kondisi="ID = '1'";
		$exec=$this->oci_model->Exec($field, false, 'M_SETTING', $kondisi, 'update');
		if($exec == 1){
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Save Success</div>');
			redirect('customer/email_setting');
		}
	}
	
	function save_email_config(){
		$this->load->model('oci_model');
		$urlApp=$this->input->post('url');
		$port=$this->input->post('port');
		$host=$this->input->post('host');
		$user=$this->input->post('user');
		$pass=$this->input->post('pass');
		$field="URL_APP = '".$urlApp."', SMTP_PORT = '".$port."', SMTP_HOST = '".$host."', SMTP_USER = '".$user."', SMTP_PASSWORD = '".$pass."'";
		$kondisi="ID = '1'";
		$exec=$this->oci_model->Exec($field, false, 'M_SETTING', $kondisi, 'update');
		if($exec == 1){
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Save Success</div>');
			redirect('customer/email_setting');
		}
	}
	
	function test_contact(){
		$this->load->library('saprfc');	
		$this->load->library('sapauth');		
		
		$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
		//Cek Connection SAP Status	
		$data['content']=$this->saprfc->callFunction("ZBAPI_CUSTOMER_CONTACTPERSON",
			array(	array("IMPORT","XKUNNR","0001105470"),
				array("IMPORT","JENIS","ADD"),
				array("IMPORT","XFIRSTNAME","SONY"),
				array("IMPORT","XLASTNAME", "TULUNG"),
				array("IMPORT","XTITLE","Mr."),
				array("IMPORT","XTLP","021938838"),
				array("IMPORT","XEXT","123"),
				array("IMPORT","XDEPARTEMEN","0002"),
				array("IMPORT","XFUNCTION","01"),
				array("IMPORT","XFAX","02133838"),
				array("IMPORT","XEMAIL","sn.hendra@gmail.com"),
				array("EXPORT","XPANNR",array())
			     )
			); 	
				
		echo $this->saprfc->printStatus();
		echo $this->saprfc->getStatus();
		echo "<br/><br/>";
		$id_contact = $data['content']["XPANNR"];
		echo $id_contact;
		$this->saprfc->logoff();
		
		
		$this->load->library('saprfc');	
		$this->load->library('sapauth');		
		
		$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
		//Cek Connection SAP Status	
		$data['content']=$this->saprfc->callFunction("ZBAPI_CUST_CONTACTPERSON_SAVE",
			array(	array("IMPORT","XKUNNR","0001105470"),
				array("IMPORT","XPANR",$id_contact),
				array("IMPORT","XFIRSTNAME","SONY"),
				array("IMPORT","XLASTNAME", "TULUNG"),
				array("IMPORT","XTITLE","0002"),
				array("IMPORT","XTLP","021938838"),
				array("IMPORT","XEXT","123"),
				array("IMPORT","XHP","085645252524"),
				array("IMPORT","XDEPARTEMEN","0002"),
				array("IMPORT","XFUNCTION","01"),
				array("IMPORT","XFAX","02133838"),
				array("IMPORT","XEMAIL","sn.hendra@gmail.com")
			     )
			); 	
				
		echo $this->saprfc->printStatus();
		echo $this->saprfc->getStatus();
		echo "<br/><br/>";
		
		$this->saprfc->logoff();
		
	}
	
	//function test_edit_contact(){
	//	$this->load->library('saprfc');	
	//	$this->load->library('sapauth');		
	//	
	//	$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
	//	//Cek Connection SAP Status	
	//	$data['content']=$this->saprfc->callFunction("ZBAPI_CUSTOMER_CONTACTPERSON",
	//		array(	array("IMPORT","XKUNNR","0001105470"),
	//			array("IMPORT","XIDCP","0000003727"),
	//			array("IMPORT","JENIS","EDIT"),
	//			array("IMPORT","XFIRSTNAME","AAAWA"),
	//			array("IMPORT","XLASTNAME", "AAAWWWWW"),
	//			array("IMPORT","XTITLE","Mr."),
	//			array("IMPORT","XTLP","021938838"),
	//			array("IMPORT","XEXT","123"),
	//			array("IMPORT","XDEPARTEMEN","0002"),
	//			array("IMPORT","XFUNCTION","01"),
	//			array("IMPORT","XFAX","02133838"),
	//			array("IMPORT","XEMAIL","sn.hendraaaa@gmail.com"),
	//			array("EXPORT","XPANNR",array())
	//		     )
	//		); 	
	//			
	//	echo $this->saprfc->printStatus();
	//	echo $this->saprfc->getStatus();
	//	echo "<br/><br/>";
	//	$id_contact = $data['content']["XPANNR"];
	//	echo $id_contact;
	//	$this->saprfc->logoff();
	//	
	//	
	//	$this->load->library('saprfc');	
	//	$this->load->library('sapauth');		
	//	
	//	$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
	//	//Cek Connection SAP Status	
	//	$data['content']=$this->saprfc->callFunction("ZBAPI_CUST_CONTACTPERSON_SAVE",
	//		array(	array("IMPORT","XKUNNR","0001105470"),
	//			array("IMPORT","XPANR","0000003727"),
	//			array("IMPORT","XFIRSTNAME","AAAWA"),
	//			array("IMPORT","XLASTNAME", "AAAWWWWW"),
	//			array("IMPORT","XTITLE","0002"),
	//			array("IMPORT","XTLP","02100000"),
	//			array("IMPORT","XEXT","123"),
	//			array("IMPORT","XHP","0856000000"),
	//			array("IMPORT","XDEPARTEMEN","0002"),
	//			array("IMPORT","XFUNCTION","01"),
	//			array("IMPORT","XFAX","02100000"),
	//			array("IMPORT","XEMAIL","sn.hendraaaa@gmail.com")
	//		     )
	//		); 	
	//			
	//	echo $this->saprfc->printStatus();
	//	echo $this->saprfc->getStatus();
	//	echo "<br/><br/>";
	//	
	//	$this->saprfc->logoff();
	//}
	
	
	//---------------------------------------UPLOAD EXCEL---------------------------------
	function form_upload(){
		
		$data['main_content']="customer/form_upload";
		$this->load->view('template/main',$data);
	}
	
	function upload_new_customer(){
		date_default_timezone_set('Asia/Jakarta');
                $tgl=date("Y-m-d H:i:s");
		$nik=$this->session->userdata('NIK');
		$namefile=$nik."_".strtotime($tgl);
		$config['upload_path'] ='./temp/new';
		$config['allowed_types'] = 'xls';
		$config['max_size']    = '0';
		$config['file_name'] = $namefile;
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Failed to upload ! Error : '.$error['error'].' </div>');
				$url="customer/form_upload";
				redirect($url);
			//print_r($error);
			//$this->load->view('upload_form', $error);
			//echo $_FILES['userfile']['type'];
			
		}
		else{
			//$data = array('upload_data' => $this->upload->data());
			//print_r($data);
			//$this->load->view('upload_success', $data);
			$file = './temp/new/'.$namefile.'.xls';
			//load the excel library
			$this->load->library('excel');
			//read file from path
			$objPHPExcel = PHPExcel_IOFactory::load($file);
			//get only the Cell Collection
			$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
			//extract to a PHP readable array format
			foreach ($cell_collection as $cell) {
			    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
			    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
			    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
			    //header will/should be in row 1 only. of course this can be modified to suit your need.
			    if ($row == 1) {
				$header[$row][$column] = $data_value;
			    } else {
				$arr_data[$row][$column] = $data_value;
			    }
			}
			//send the data in an array format
			//$data['header'] = $header;
			//$data['values'] = $arr_data;
			//
			//echo "<pre>";
			//print_r($arr_data);
			//echo "</pre>";
			//foreach($arr_data as $zz){
			//	if(isset($zz['A'])){
			//		echo $zz['A'];
			//	echo "<br/>";
			//	}
			//	
			//}
			foreach($arr_data as $a){
				if(isset($a['A'])){
					$this->load->model('oci_model');
					//General
					$id_cust=$this->oci_model->nextID('ID_CUST', 'M_CUST_KNA1',FALSE);
					
					if(isset($a['S'])){
						$country=$a['S'];
					}else{
						$country="";
					}
					
					if(isset($a['I'])){
						$name1=$a['I'];
					}else{
						$name1="";
					}
					
					if(isset($a['J'])){
						$name2=$a['J'];
					}else{
						$name2="";
					}
					
					if(isset($a['R'])){
						$city=$a['R'];
					}else{
						$city="";
					}
					
					if(isset($a['Q'])){
						$postalcode=$a['Q'];
					}else{
						$postalcode="";
					}
					
					if(isset($a['T'])){
						$region=$a['T'];
					}else{
						$region="";
					}
					
					$sotl=substr($name1, 0, 9);
					
					if(isset($a['U'])){
						$tlp1=$a['U'];
					}else{
						$tlp1="";
					}
					
					if(isset($a['V'])){
						$tlp2=$a['V'];
					}else{
						$tlp2="";
					}
					
					if(isset($a['W'])){
						$fax=$a['W'];
					}else{
						$fax="";
					}
					
					if(isset($a['M'])){
						$address=$a['M'];
					}else{
						$address="";
					}
					
					if(isset($a['N'])){
						$address2=$a['N'];
					}else{
						$address2="";
					}
					
					if(isset($a['O'])){
						$address3=$a['O'];
					}else{
						$address3="";
					}
					
					if(isset($a['P'])){
						$address4=$a['P'];
					}else{
						$address4="";
					}
					
					if(isset($a['K'])){
						$search1=$a['K'];
					}else{
						$search1="";
					}
					
					if(isset($a['L'])){
						$search2=$a['L'];
					}else{
						$search2="";
					}
					
					if(isset($a['H'])){
						$title=$a['H'];
					}else{
						$title="";
					}
					
					if(isset($a['Y'])){
						$allowpos=$a['Y'];
					}else{
						$allowpos="0";
					}
					
					if(isset($a['AB'])){
						$nielsen_id=$a['AB'];
					}else{
						$nielsen_id="";
					}
					
					if(isset($a['Z'])){
						$member_card=$a['Z'];
					}else{
						$member_card="";
					}
					
					
					if(isset($a['AE'])){
						$vatnum=$a['AE'];
					}else{
						$vatnum="";
					}
					
					if(isset($a['X'])){
						$email=$a['X'];
					}else{
						$email="";
					}
					
					if(isset($a['AA'])){
						$industry_key=$a['AA'];
					}else{
						$industry_key="";
					}
					
					if(isset($a['AD'])){
						$industry_code1=$a['AD'];
					}else{
						$industry_code1="";
					}
					
					if(isset($a['G'])){
						$account_group=$a['G'];
					}else{
						$account_group="";
					}
					
					if(isset($a['AT'])){
						$recont_account=$a['AT'];
					}else{
						$recont_account="";
					}
					
					
					
					$user_cr=$this->session->userdata('NIK');
					$st_send="0";
					$st="1";
					
					if(isset($a['B'])){
						$subject=$a['B'];
					}else{
						$subject="";
					}
					
					
					$no=$a['A'];
					
					if(isset($a['AC'])){
						$customer_class=$a['AC'];
					}else{
						$customer_class="";
					}
					
					
					$seskode=$this->session->userdata('seskode');
					
					if($allowpos == '0'){
						$nielsen_id ="";
					}
					if($allowpos == "1"){
						if($nielsen_id == ""){
							$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
								<h4 class="alert-heading">Error!</h4>
								Sebagian data gagal diupload karena pada data dengan No. ke '.$no.' tidak ada Nielsen ID, Nielsen ID wajib diisi jika Allow Data To POS dicentang.<br/>
								Perbaiki data di file, kemudian hapus sebagian data yang sudah terupload. Upload ulang data!</div>');
							$url="customer/form_upload";
							redirect($url);
						}
						if($member_card == ""){
							$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
								<h4 class="alert-heading">Error!</h4>
								Sebagian data gagal diupload karena pada data dengan No. ke '.$no.' tidak ada Member Card, Member Card wajib diisi jika Allow Data To POS dicentang.<br/>
								Perbaiki data di file, kemudian hapus sebagian data yang sudah terupload. Upload ulang data!</div>');
							$url="customer/form_upload";
							redirect($url);
						}
						if($industry_key == ""){
							$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
								<h4 class="alert-heading">Error!</h4>
								Sebagian data gagal diupload karena pada data dengan No. ke '.$no.' tidak ada Industry Key, Industry Key wajib diisi jika Allow Data To POS dicentang.<br/>
								Perbaiki data di file, kemudian hapus sebagian data yang sudah terupload. Upload ulang data!</div>');
							$url="customer/form_upload";
							redirect($url);
						}if($customer_class == ""){
							$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
								<h4 class="alert-heading">Error!</h4>
								Sebagian data gagal diupload karena pada data dengan No. ke '.$no.' tidak ada Customer Class, Customer Class wajib diisi jika Allow Data To POS dicentang.<br/>
								Perbaiki data di file, kemudian hapus sebagian data yang sudah terupload. Upload ulang data!</div></div>');
							$url="customer/form_upload";
							redirect($url);
						}
						if($industry_code1 == ""){
							$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
								<h4 class="alert-heading">Error!</h4>
								Sebagian data gagal diupload karena pada data dengan No. ke '.$no.' tidak ada Industry Code 1, Industry Code 1 wajib diisi jika Allow Data To POS dicentang.<br/>
								Perbaiki data di file, kemudian hapus sebagian data yang sudah terupload. Upload ulang data!</div>');
							$url="customer/form_upload";
							redirect($url);
						}
						
					}
					//Basic Data
					if(isset($a['C'])){
						$company=$a['C'];
					}else{
						$company="";
					}
					
					if(isset($a['D'])){
						$sales_org=$a['D'];
					}else{
						$sales_org="";
					}
					
					if(isset($a['E'])){
						$dis_channel=$a['E'];
					}else{
						$dis_channel="";
					}
					
					if(isset($a['F'])){
						$division=$a['F'];
					}else{
						$division="";
					}
					
					
					
					//Sales Area Data
					if(isset($a['AV'])){
						$top=$a['AV'];
					}else{
						$top="";
					}
					
					if(isset($a['BE'])){
						$sales_office=$a['BE'];
					}else{
						$sales_office="";
					}
					
					if(isset($a['BF'])){
						$cust_group=$a['BF'];
					}else{
						$cust_group="";
					}
					
					if(isset($a['AX'])){
						$currency=$a['AX'];
					}else{
						$currency="";
					}
					
					if(isset($a['BB'])){
						$inco1=$a['BB'];
					}else{
						$inco1="";
					}
					
					if(isset($a['BC'])){
						$inco2=$a['BC'];
					}else{
						$inco2="";
					}
					
					
					
					$nik=$this->session->userdata('NIK');
					
					$stHak=$this->oci_model->cek_hak_akses($nik, $sales_org, $dis_channel, $division);
					if($stHak < 1){
						$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
							<h4 class="alert-heading">Error!</h4>
							Sebagian data gagal diupload karena pada data dengan No. ke '.$no.', anda tidak mempunyai hak akses.<br/> Hubungi administrator untuk menambah hak akses.
							Kemudian hapus sebagian data yang sudah terupload. Upload ulang data!</div>');
						$url="customer/form_upload";
						redirect($url);
					}
					
					$stBasic=$this->oci_model->cek_data_basic($company, $sales_org, $dis_channel, $division);
					if($stBasic <> "1"){
						$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
							<h4 class="alert-heading">Error!</h4>
							Sebagian data gagal diupload karena pada data dengan No. ke '.$no.', memiliki kombinasi company code, sales org., dis. channel, dan division yang tidak sesuai.<br/>
							Perbaiki data di file, kemudian hapus sebagian data yang sudah terupload. Upload ulang data!</div>');
						$url="customer/form_upload";
						redirect($url);
					}
					date_default_timezone_set('Asia/Jakarta');
					$tgl=date("Y-m-d");
					
					//Insert KNA1
					$fieldKNA1="ID_CUST, COUNTRY_KEY, NAME1, NAME2, CITY, POSTAL_CODE, REGION, SHORT_FIELD, TLP1, TLP2, FAX, ADDRESS, SEARCH_TERM1, SEARCH_TERM2, TITLE_CP, ALLOW_POS, NIELSEN_ID, MEMBER_CARD, VATNUM, EMAIL, INDUSTRY_KEY, USER_CR, ST_SEND, ST, TGL, CUST_CLASS, SUBJECT, ADDRESS2, ADDRESS3, DATE_MODIF, NIK_MODIF, INDUSTRY_CODE1, ADDRESS4, ACCOUNT_GROUP";
					$valueKNA1="'".$id_cust."','".$country."','".$name1."', '".$name2."', '".$city."', '".$postalcode."', '".$region."', '".$sotl."', '".$tlp1."', '".$tlp2."', '".$fax."', '".$address."', '".$search1."', '".$search2."', '".$title."', '".$allowpos."', '".$nielsen_id."', '".$member_card."', '".$vatnum."', '".$email."', '".$industry_key."', '".$user_cr."', '".$st_send."', '".$st."', TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI'), '".$customer_class."', '".$subject."', '".$address2."', '".$address3."', TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI'), '".$user_cr."', '".$industry_code1."', '".$address4."', '".$account_group."'";
					$exec=$this->oci_model->Exec($fieldKNA1, $valueKNA1, 'M_CUST_KNA1', FALSE, 'insert');
					
					if($exec <= 0){
					    $this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
							<h4 class="alert-heading">Error!</h4>
							Sebagian data gagal diupload,data dengan No. ke '.$no.' gagal.</div>');
						$url="customer/form_upload";
						redirect($url);
					}else{
						//Insert KNVV
						if(isset($a['BH'])){
							$sales_group = $a['BH'];
						}else{
							$sales_group = "";
						}
						
						if(isset($a['AY'])){
							$cust_price = $a['AY'];
						}else{
							$cust_price = "";
						}
						
						if(isset($a['AZ'])){
							$cust_stat = $a['AZ'];
						}else{
							$cust_stat = "";
						}
						
						if(isset($a['BA'])){
							$relevan = $a['BA'];
						}else{
							$relevan = "";
						}
						
						if(isset($a['BG'])){
							$account_ass = $a['BG'];
						}else{
							$account_ass = "";
						}
						
						if(isset($a['AW'])){
							$order_prob = $a['AW'];
						}else{
							$order_prob = "";
						}
						
						
						//Insert KNB1
						if(isset($a['AU'])){
							$short_key = $a['AU'];
						}else{
							$short_key = "";
						}
						
						
						$fieldKNB1="COMPANY_CODE, ID_CUST, RECONT_ACC, SHORT_KEY";
						$valueKNB1="'".$company."', '".$id_cust."', '".$recont_account."', '".$short_key."'";
						$exec=$this->oci_model->Exec($fieldKNB1, $valueKNB1, 'M_CUST_KNB1', FALSE, 'insert');
						
						$fieldKNVV="SALES_ORG, DIS_CHANNEL, DIVISION, ID_CUST, INCO1, INCO2, CUST_GROUP, CURR, TOP, SALES_OFFICE, SALES_GROUP, CUST_PRICE, CUST_STAT, RELEVAN_POD, ACCOUNT_ASS, ORDER_PROB";
						$valueKNVV="'".$sales_org."', '".$dis_channel."', '".$division."', '".$id_cust."', '".$inco1."', '".$inco2."', '".$cust_group."', '".$currency."', '".$top."', '".$sales_office."', '".$sales_group."', '".$cust_price."', '".$cust_stat."' , '".$relevan."', '".$account_ass."', '".$order_prob."'";
						$exec=$this->oci_model->Exec($fieldKNVV, $valueKNVV, 'M_CUST_KNVV', FALSE, 'insert');
						
						
						
						
						//Insert Contact Person
						//Insert CP by Line Temp
						if(isset($a['AF'])){
							$title_cp = $a['AF'];
						}else{
							$title_cp = "";
						}
						
						if(isset($a['AG'])){
							$firstname_cp = $a['AG'];
						}else{
							$firstname_cp = "";
						}
						
						if(isset($a['AH'])){
							$name_cp = $a['AH'];
						}else{
							$name_cp = "";
						}
						
						if(isset($a['AJ'])){
							$tlp_cp = $a['AJ'];
						}else{
							$tlp_cp = "";
						}
						
						if(isset($a['AI'])){
							$gender_cp = $a['AI'];
						}else{
							$gender_cp = "";
						}
						
						if(isset($a['AK'])){
							$ext_cp = $a['AK'];
						}else{
							$ext_cp = "";
						}
						
						if(isset($a['AL'])){
							$hp_cp = $a['AL'];
						}else{
							$hp_cp = "";
						}
						
						if(isset($a['AM'])){
							$fax_cp = $a['AM'];
						}else{
							$fax_cp = "";
						}
						
						if(isset($a['AN'])){
							$email_cp = $a['AN'];
						}else{
							$email_cp = "";
						}
						
						if(isset($a['AO'])){
							$tgl_lahir_cp = $a['AO'];
						}else{
							$tgl_lahir_cp = "";
						}
						
						
						if(isset($a['AR'])){
							$call_cp = $a['AR'];
						}else{
							$call_cp = "";
						}
						
						if(isset($a['AS'])){
							$date_reg = $a['AS'];
						}else{
							$date_reg ="";
						}
						
						if(isset($a['AQ'])){
							$departemen_cp = $a['AQ'];
						}else{
							$departemen_cp = "";
						}
						
						if(isset($a['AP'])){
							$function_cp = $a['AP'];
						}else{
							$function_cp = "";
						}
						
						
						$id_cp = $this->oci_model->nextIDCP('ID_CP', 'M_CONTACT_PERSON',FALSE);
						$fieldCP='ID_CUST, ID_CP, TITLE_CP, FIRSTNAME_CP, NAME_CP, TLP_CP, EXT_CP, HP_CP, FAX_CP, EMAIL_CP, DEPARTMENT, FUNC, GENDER, TGL_LAHIR, CALL_FREQ, DATE_REGISTER';
						$valueCP= "'".$id_cust."', '".$id_cp."', '".$title_cp."', '".$firstname_cp."', '".$name_cp."', '".$tlp_cp."', '".$ext_cp."', '".$hp_cp."', '".$fax_cp."' , '".$email_cp."', '".$departemen_cp."', '".$function_cp."', '".$gender_cp."', '".$tgl_lahir_cp."', '".$call_cp."', '".$date_reg."'";
						$exec=$this->oci_model->Exec($fieldCP, $valueCP, 'M_CONTACT_PERSON', FALSE, 'insert');
					}
				}
			}
			$this->load->helper('file');
			$path="./temp/new/".$namefile.".xls";
			unlink($path);
			
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
						<h4 class="alert-heading">Success!</h4>
						 Upload data sukses, silahkan cek kembali data anda dan posting agar request anda segera diproses. </div>');
					    redirect(site_url('customer/form_upload'));
		}
	}
	
	
	function upload_extend_customer(){
		date_default_timezone_set('Asia/Jakarta');
                $tgl=date("Y-m-d H:i:s");
		$nik=$this->session->userdata('NIK');
		$namefile=$nik."_".strtotime($tgl);
		$config['upload_path'] ='./temp/extend';
		$config['allowed_types'] = 'xls';
		$config['max_size']    = '0';
		$config['file_name'] = $namefile;
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Failed to upload ! Error : '.$error['error'].' </div>');
				$url="customer/form_upload";
				redirect($url);
			//print_r($error);
			//$this->load->view('upload_form', $error);
			//echo $_FILES['userfile']['type'];
			
		}
		else{
			//$data = array('upload_data' => $this->upload->data());
			//print_r($data);
			//$this->load->view('upload_success', $data);
			$file = './temp/extend/'.$namefile.'.xls';
			//load the excel library
			$this->load->library('excel');
			//read file from path
			$objPHPExcel = PHPExcel_IOFactory::load($file);
			//get only the Cell Collection
			$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
			//extract to a PHP readable array format
			foreach ($cell_collection as $cell) {
			    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
			    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
			    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
			    //header will/should be in row 1 only. of course this can be modified to suit your need.
			    if ($row == 1) {
				$header[$row][$column] = $data_value;
			    } else {
				$arr_data[$row][$column] = $data_value;
			    }
			}
			echo "<pre>";
			print_r($arr_data);
			echo "</pre>";
			foreach($arr_data as $a){
				if(isset($a['A'])){
					$this->load->model('sap_model');
					$this->load->model('oci_model');
					
					
					$no=$a['A'];
					
					if(isset($a['C'])){
						$tipe=$a['C'];
					}else{
						$tipe="";
					}
						
					if(isset($a['D'])){
						$id_req_cust=$a['D'];
					}else{
						$id_req_cust="";
					}
					
					if(isset($a['B'])){
						$subject=$a['B'];
					}else{
						$subject="";
					}
					
					
					if($tipe == "WEB"){
						$kunnr = "";
						$company1="";
						$sales_org1="";
						$dis_channel1="";
						$division1="";
					}else{
						if(isset($a['E'])){
							$kunnr = $a['E'];
						}else{
							$kunnr = "";
						}
						
						if(isset($a['J'])){
							$company1=$a['J'];
						}else{
							$company1="";
						}
						
						if(isset($a['K'])){
							$sales_org1=$a['K'];
						}else{
							$sales_org1="";
						}
						
						if(isset($a['L'])){
							$dis_channel1=$a['L'];
						}else{
							$dis_channel1="";
						}
						
						if(isset($a['M'])){
							$division1=$a['M'];
						}else{
							$division1="";
						}
							
					}
					
					if(isset($a['F'])){
						$company2=$a['F'];
					}else{
						$company2="";
					}
					
					
					if(isset($a['G'])){
						$sales_org2=$a['G'];
					}else{
						$sales_org2="";
					}
					
					if(isset($a['H'])){
						$dis_channel2=$a['H'];
					}else{
						$dis_channel2="";
					}
					
					if(isset($a['I'])){
						$division2=$a['I'];
					}else{
						$division2="";
					}
					
					if(isset($a['N'])){
						$top=$a['N'];
					}else{
						$top="";
					}
					
					if(isset($a['O'])){
						$sales_office=$a['O'];
					}else{
						$sales_office="";
					}
					
					if(isset($a['P'])){
						$customer_group=$a['P'];
					}else{
						$customer_group="";
					}
					
					if(isset($a['Q'])){
						$currency=$a['Q'];
					}else{
						$currency="";
					}
					
					if(isset($a['R'])){
						$inco1=$a['R'];
					}else{
						$inco1="";
					}
					
					if(isset($a['S'])){
						$deskripsi=$a['S'];
					}else{
						$deskripsi="";
					}
					
					if(isset($a['T'])){
						$account_group=$a['T'];
					}else{
						$account_group="";
					}
					
					
					if(isset($a['U'])){
						$recon_account=$a['U'];
					}else{
						$recon_account="";
					}
					
					
					
					if($tipe == "WEB"){
						$jmlCust=$this->oci_model->getJmlStatusCustReq($id_req_cust);
						if($jmlCust == 0){
							$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
								<h4 class="alert-heading">Error!</h4>
								Data sebagian gagal diupload. Data gagal mulai No. '.$no.'. ID Request New Customer tidak ditemukan!</div>');
							redirect('customer/form_upload');
						}
						$cekKUNNR=$this->oci_model->cekKUNNR($id_req_cust);
						if($cekKUNNR == "3"){
							$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
								<h4 class="alert-heading">Error!</h4>
								Data sebagian gagal diupload. Data gagal mulai No. '.$no.'. Request New Customer sudah ditransport dan mempunyai Cust. Account (SAP), silahkan menggunakan cust. account untuk reference !</div>');
							redirect('customer/form_upload');
						}
					}else{
						
						//------------------cek----------------------
						//get sesuai KUNNR
						$this->load->library('saprfc');	
						$this->load->library('sapauth');
						$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
						//Cek Connection SAP Status	
						$data['content']=$this->saprfc->callFunction("ZBAPI_FIND_CUST",
								array(
								    array("IMPORT","XKUNNR",$kunnr),
								    array("TABLE","XKNA1",array()),
								    array("TABLE","XKNB1",array()),
								    array("TABLE","XKNVV",array())
								)); 				
						$this->saprfc->logoff();
						
						
						foreach($data['content']["XKNA1"] as $rowA){
							
							$dataA[]=$rowA;
						}
						foreach($data['content']["XKNB1"] as $rowB){
						    $dataB[]=$rowB;
						}
						foreach($data['content']["XKNVV"] as $rowC){
						    $dataC[]=$rowC;
						}
						
						if(count($data['content']["XKNA1"]) == 0){
							$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
								<h4 class="alert-heading">Error!</h4>
								Data sebagian gagal diupload. Data gagal mulai No. '.$no.'. Data reference tidak ditemukan</div>');
							redirect('customer/form_upload');
						}
						if(count($data['content']["XKNVV"]) == 0){
							$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
								<h4 class="alert-heading">Error!</h4>
								Data sebagian gagal diupload. Data gagal mulai No. '.$no.'. Data reference tidak ditemukan</div>');
							redirect('customer/form_upload');
						}else{
							$status="0";
							
							foreach($data['content']["XKNVV"] as $c){
								if($c['VKORG'] == $sales_org1 && $c['VTWEG'] == $dis_channel1 && $c['SPART'] == $division1){
									$status = $status + 1;
								}
							}
							if($status < 1){
								$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
									<h4 class="alert-heading">Error!</h4>
									Data sebagian gagal diupload. Data gagal mulai No. '.$no.'. Data reference tidak ditemukan</div>');
								redirect('customer/form_upload');
								//print_r($data['content']["XKNVV"]);
							}
						}
					}
					
					
					
					$nik=$this->session->userdata('NIK');
					$stHak=$this->oci_model->cek_hak_akses($nik, $sales_org2, $dis_channel2, $division2);
					if($stHak < 1){
						$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
							<h4 class="alert-heading">Error!</h4>
							Data sebagian gagal diupload. Data gagal mulai No. '.$no.'. Anda tidak mempunyai hak akses untuk company code tersebut, silahkan hubungi administrator !</div>');
						$url="customer/form_upload";
						redirect($url);
					}
					
					//COLUM : ID_EX, CUST_ACCOUNT, SUBJECT, COMPANY1, SALES_ORG1, DIS_CHANNEL1, DIVISION1, COMPANY2, SALES_ORG2, DIS_CHANNEL2, DIVISION2, TOP, SALES_OFFICE, CUSTOMER_GROUP, CURRENCY, INCO1, INCO2, ACCOUNT_GROUP, RECON_ACCOUNT, ST_SEND, DATE_CREATE, NIK_CREATE, DATE_POSTING, DATE_APPROVED, NIK_APPROVED, DATE_TRANSPORT, NIK_TRANSPORT, DATE_MODIF, NIK_MODIF, DATE_DELETE, ST
					$nextID=$this->oci_model->nextIDEX();
					$field="ID_EX, TIPE, ID_CUST, CUST_ACCOUNT, SUBJECT, COMPANY1, SALES_ORG1, DIS_CHANNEL1, DIVISION1, COMPANY2, SALES_ORG2, DIS_CHANNEL2, DIVISION2, TOP, SALES_OFFICE, CUSTOMER_GROUP, CURRENCY, INCO1, INCO2, ACCOUNT_GROUP, RECON_ACCOUNT, ST_SEND, DATE_CREATE, NIK_CREATE, DATE_MODIF, NIK_MODIF, ST";
					$value="'".$nextID."', '".$tipe."', '".$id_req_cust."', '".$kunnr."', '".$subject."' ,'".$company1."','".$sales_org1."', '".$dis_channel1."', '".$division1."', '".$company2."', '".$sales_org2."', '".$dis_channel2."', '".$division2."', '".$top."', '".$sales_office."', '".$customer_group."', '".$currency."', '".$inco1."', '".$deskripsi."', '".$account_group."', '".$recon_account."', '0', TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI'), '".$nik."', TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI'), '".$nik."','1'";
					$exec=$this->oci_model->Exec($field, $value, 'T_CUST_EXTEND', FALSE, 'insert');
					
					if($exec <= 0){
					    $this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
							<h4 class="alert-heading">Error!</h4>
							Data sebagian gagal diupload. Data gagal mulai No. '.$no.'.</div>');
						$url="customer/form_upload";
						redirect($url);
					}
					
				}
				
			}
			$this->load->helper('file');
			$path="./temp/extend/".$namefile.".xls";
			unlink($path);
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Success!</h4>
					Upload Extend Customer Success!</div>');
				$url="customer/form_upload";
				redirect($url);
		}
	}
	
	function upload_setting_new(){
		
		$path="./temp/format/format_upload_new.xls";
		unlink($path);
		
		$namefile="format_upload_new";
		$config['upload_path'] ='./temp/format';
		$config['allowed_types'] = 'xls';
		$config['max_size']    = '10000';
		$config['file_name'] = $namefile;
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Failed to upload ! Error : '.$error['error'].' </div>');
				$url="customer/email_setting";
				redirect($url);
			
		}
		else{
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Upload Success !</div>');
			redirect('customer/email_setting');
		}
	}
	
	function upload_setting_extend(){
		
		$path="./temp/format/format_upload_extend.xls";
		unlink($path);
		
		$namefile="format_upload_extend";
		$config['upload_path'] ='./temp/format';
		$config['allowed_types'] = 'xls';
		$config['max_size']    = '10000';
		$config['file_name'] = $namefile;
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					Failed to upload ! Error : '.$error['error'].' </div>');
				$url="customer/email_setting";
				redirect($url);
			
		}
		else{
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Upload Success !</div>');
			redirect('customer/email_setting');
		}
	}
	
	function form_contact_person1(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->my_auth->hak_akses("REQUESTER");
	    
		$data['main_content']="customer/form_contact_person1";
		$this->load->view('template/main',$data);
	}
	
	function list_contact_person(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->my_auth->hak_akses("REQUESTER");
		
		$kunnr=$this->input->post('cust_account');
		
		$this->load->library('saprfc');	
		$this->load->library('sapauth');		
		$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
		//Cek Connection SAP Status	
		$data['content']=$this->saprfc->callFunction("ZBAPI_CUST_GETCONTACTPERSON",
			array(	array("IMPORT","XKUNNR",$kunnr),
				array("TABLE","XKNVK",array())
			     )
			); 	
		$this->saprfc->logoff();
		
		//print_r($data['content']["XKNVK"]);
		$jmlCP = count($data['content']["XKNVK"]);	
		
		if($jmlCP > 0){
			foreach($data['content']["XKNVK"] as $rowA){
				$dataA[]=$rowA;
			}
			$data['knvk']=$dataA;
		}else{
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Error!</h4>
				Data not found !</div>');
			redirect('customer/form_contact_person1');
		}
		
		$data['kunnr']=$kunnr;
		$data['main_content']="customer/list_contact_person";
		$this->load->view('template/main',$data);
		
		
	}
	
	function form_edit_contact(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->my_auth->hak_akses("REQUESTER");
		$this->load->model('sap_model');
		$kunnr=$this->uri->segment(3);
		$parnr=$this->uri->segment(4);
		
		//--------------------------CONTACT PERSON ----------------------------//
		$this->load->library('saprfc');	
		$this->load->library('sapauth');		
		$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
		$data['content']=$this->saprfc->callFunction("ZBAPI_CUST_GETCONTACTPERSON",
			array(	array("IMPORT","XKUNNR",$kunnr),
				array("TABLE","XKNVK",array())
			     )
			); 	
		$this->saprfc->logoff();
		$jmlCP = count($data['content']["XKNVK"]);
		if($jmlCP > 0){
			foreach($data['content']["XKNVK"] as $cpdata){
				if($cpdata['PARNR'] == $parnr){
					$cp_parnr = $cpdata['PARNR'];
					$cp_firstname = $cpdata['NAMEV'];
					$cp_lastname =  $cpdata['NAME1'];
					$cp_tlp =  $cpdata['TELF1'];
					
					$cp_departemen =  $cpdata['ABTNR'];
					$cp_function = $cpdata['PAFKT'];
					$cp_title = $cpdata['ANRED'];
					$cp_gender = $cpdata['PARGE'];
					$cp_call = $cpdata['BRYTH'];
					$cp_tgl_lahir =$cpdata['GBDAT'];
					$cp_tgl_register = $cpdata['PARAU'];
					
					//Get Tlp, Ext, no HP, fax, email
					$this->load->library('saprfc');	
					$this->load->library('sapauth');		
					
					$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
					//Cek Connection SAP Status	
					$data['content']=$this->saprfc->callFunction("BAPI_ADDRESSCONTPART_GETDETAIL",
						array(	array("IMPORT","OBJ_TYPE_P","BUS1006001"),
							array("IMPORT","OBJ_ID_P",$cp_parnr),
							array("IMPORT","OBJ_TYPE_C","KNA1"),
							array("IMPORT","OBJ_ID_C",$kunnr),
						
							array("IMPORT","CONTEXT","0005"),
							array("IMPORT","IV_CURRENT_COMM_DATA","X"),
							array("TABLE","BAPIAD3VL",array()),
							array("TABLE","BAPIADTEL",array()),
							array("TABLE","BAPIADFAX",array()),
							array("TABLE","BAPIADSMTP",array())
						     )
						); 	
					$this->saprfc->logoff();
					//-----------tlp & hp---------------------
					$jmlbaiatel=count($data['content']['BAPIADTEL']);
					$cp_tlp = "";
					$cp_hp = "";
					$cp_ext = "";
					if($jmlbaiatel > 0){
						foreach($data['content']["BAPIADTEL"] as $atel){
							$cnt1_cp = $atel['R_3_USER'];
							if($atel['STD_RECIP'] == "X" && $atel['R_3_USER'] == "3"){
								$cp_hp = $atel['TELEPHONE'];
								
							}
							
							if($atel['STD_RECIP'] <> "X" && $atel['R_3_USER'] == "1"){
								$cp_tlp = $atel['TELEPHONE'];
								$cp_ext = $atel['EXTENSION'];
							}
						}
					}
					//-----------  F A X ---------------------
					$jmlFAXCP = count($data['content']["BAPIADFAX"]);
					$cp_fax = "";
					if($jmlFAXCP > 0){
						foreach($data['content']["BAPIADFAX"] as $faxxx){
							if($faxxx['STD_NO'] == "X"){
								$cp_fax = $faxxx['FAX'];
							}
						}
					}
					//--------------- EMAIL -------------------------
					
					$jmlEmailCP = count($data['content']["BAPIADSMTP"]);
					$cp_email = "";
					if($jmlEmailCP > 0){
						foreach($data['content']["BAPIADSMTP"] as $emailCPP){
							if($emailCPP['STD_NO'] == "X"){
								$cp_email = $emailCPP['E_MAIL'];
							}
						}
					}
					
					$data['parnr']=$parnr;
					$data['kunnr']=$kunnr;
					$data['title']=$cp_title;
					$data['firstname']=$cp_firstname;
					$data['lastname']=$cp_lastname;
					$data['gender']=$cp_gender;
					$data['tlp']=$cp_tlp;
					$data['xdepartemen']=$cp_departemen;
					$data['xfunction']=$cp_function;
					$data['tlp']=$cp_tlp;
					$data['call_freq']=$cp_call;
					$data['tgl_lahir']=$cp_tgl_lahir;
					$data['tgl_register']=$cp_tgl_register;
					$data['hp']=$cp_hp;
					$data['fax']=$cp_fax;
					$data['ext']=$cp_ext;
					$data['email']=$cp_email;
					
					$tgl_lahir_format = substr($cp_tgl_lahir,6,2)."-".substr($cp_tgl_lahir,4,2)."-".substr($cp_tgl_lahir,0,4);
					$data['tgl_lahir_format']=$tgl_lahir_format;
					
					$tgl_register_format=substr($cp_tgl_register,0,2)."-".substr($cp_tgl_register,3,2)."-".substr($cp_tgl_register,6,4);
					$data['tgl_register_format']=$tgl_register_format;
				}
			}
		}
		$data['call_frequency']=$this->sap_model->getCallFrequency();
		$data['departemen']=$this->sap_model->getDepartemen();
		$data['function']=$this->sap_model->getFunction();
		//--------------------------END CONTACT PERSON ------------------------//
		$data['main_content']="customer/form_edit_cp";
		$this->load->view('template/main',$data);
		
		
	}
	
	function save_change_cp(){
		$this->load->model('oci_model');
		
		$kunnr=$this->input->post('cust_account');
		$parnr=$this->input->post('parnr');
		$title=$this->input->post('title_cp');
		$firstname=$this->input->post('firstname_cp');
		
		$name=$this->input->post('name_cp');
		if($name == ""){
			$name = $firstname;
		}else{
			$name=$name;
		}
		$tlp=$this->input->post('tlp_cp');
		$ext=$this->input->post('ext_cp');
		$hp=$this->input->post('hp_cp');
		$fax=$this->input->post('fax_cp');
		$dept=$this->input->post('departemen');
		$func=$this->input->post('function');
		$email=$this->input->post('email_cp');
		$gender=$this->input->post('gender');
		$tgl_lahir=$this->input->post('tgl_lahir');
		$tgl_register=$this->input->post('tgl_register');
		$call_freq = $this->input->post('call_frequency');
		$seskode = $this->session->userdata('seskode');
		$user=$this->session->userdata('NIK');
		
		$idCP=$this->oci_model->nextIDCP_EDIT('ID_CP_EDIT', 'T_CP_EDIT',FALSE);
		$fieldH='ID_CP_EDIT,TITLE_CP,FIRSTNAME_CP,NAME_CP,TLP_CP,EXT_CP,HP_CP,FAX_CP,EMAIL_CP,DEPARTMENT,FUNC,SESKODE,GENDER,TGL_LAHIR,CALL_REQ,DATE_REGISTER,PARNR,KUNNR,ST,ST_SEND,JENIS, NIK_CREATE, DATE_CREATE, DATE_MODIFY, NIK_MODIFY';
		$valH= "'".trim($idCP)."', '".trim($title)."', '".trim($firstname)."', '".trim($name)."', '".trim($tlp)."', '".trim($ext)."', '".trim($hp)."', '".trim($fax)."' , '".trim($email)."', '".trim($dept)."',  '".trim($func)."', '".trim($seskode)."' , '".trim($gender)."', '".trim($tgl_lahir)."', '".trim($call_freq)."', '".trim($tgl_register)."', '".trim($parnr)."','".trim($kunnr)."','1','0','EDIT', '".trim($user)."', TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI'), TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI'), '".trim($user)."'";
		$exec=$this->oci_model->Exec($fieldH, $valH, 'T_CP_EDIT', FALSE, 'insert');
		
		$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Request Change Contact Person Success! </div>');
			    redirect(site_url('customer/list_cp_req'));
	}
	
	function list_cp_req(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->my_auth->hak_akses("REQUESTER");
		
		$this->load->model('oci_model');
		$usr=$this->session->userdata('NIK');
		$role=$this->session->userdata('role');
		
		if(strpos($this->session->userdata('role'),'ADMINISTRATOR') !== false){
			$field="ID_CP_EDIT,TITLE_CP,FIRSTNAME_CP,NAME_CP,TLP_CP,EXT_CP,HP_CP,FAX_CP,EMAIL_CP, 
				DEPARTMENT,FUNC,SESKODE, GENDER,TGL_LAHIR,CALL_REQ,DATE_REGISTER,PARNR,KUNNR,ST,ST_SEND, 
				CASE WHEN ST_SEND = 0 THEN 'OPEN' WHEN ST_SEND = 1 THEN 'POSTING' WHEN ST_SEND = 2 THEN 'IS APPROVED' END AS NEW_ST, 
				JENIS, NIK_CREATE,
				DATE_CREATE,DATE_MODIFY,NIK_MODIFY,DATE_POSTING,DATE_IS,NIK_IS,
				DEV_USERS.GET_NAME_BY_NIK(NIK_CREATE) AS NAME_CREATE ";
			$kondisi="ST = '1' ORDER BY ID_CP_EDIT DESC";
			$data['row']=$this->oci_model->select($field, 'T_CP_EDIT',$kondisi);
		}else{
			$field="ID_CP_EDIT,TITLE_CP,FIRSTNAME_CP,NAME_CP,TLP_CP,EXT_CP,HP_CP,FAX_CP,EMAIL_CP, 
				DEPARTMENT,FUNC,SESKODE, GENDER,TGL_LAHIR,CALL_REQ,DATE_REGISTER,PARNR,KUNNR,ST,ST_SEND, 
				CASE WHEN ST_SEND = 0 THEN 'OPEN' WHEN ST_SEND = 1 THEN 'POSTING' WHEN ST_SEND = 2 THEN 'IS APPROVED' END AS NEW_ST, 
				JENIS, NIK_CREATE,
				DATE_CREATE,DATE_MODIFY,NIK_MODIFY,DATE_POSTING,DATE_IS,NIK_IS,
				DEV_USERS.GET_NAME_BY_NIK(NIK_CREATE) AS NAME_CREATE ";
			$kondisi="ST = '1' AND NIK_CREATE = '".$usr."' ORDER BY ID_CP_EDIT DESC";
			$data['row']=$this->oci_model->select($field, 'T_CP_EDIT',$kondisi);
		}
		
		$data['main_content']="customer/list_cp_req";
		$this->load->view('template/main',$data);	
	}
	
	function del_cp(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$id=$this->input->post('id');
		date_default_timezone_set('Asia/Jakarta');
		$tgl=date("Y-m-d");
		
		$st=$this->oci_model->getStatusCP($id);
		if($st == "0"){
			$field="ST = '0', DATE_DELETE = TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI')";
			$kondisi="ID_CP_EDIT = '".$id."'";
			$exec=$this->oci_model->Exec($field, false, 'T_CP_EDIT', $kondisi, 'update');
			
			if($exec == 1){
				$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Success!</h4>
					 Delete customer request success</div>');
			}
		}else{
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					 Failed to delete customer, customer status is not "Open".</div>');
		}
		
	}
	
	function posting_cp(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		
		$id=$this->input->post('id');
		
		
		$fieldU="DISTINCT(NIK), DEV_USERS.GET_NAME_BY_NIK(NIK) as NAMA, DEV_USERS.GET_EMAIL_BY_NIK(NIK) AS EMAIL";
		$kondisiU="NIK IN (SELECT NIK FROM M_CUST_ROLE WHERE (ROLE='MASTERDATA' OR ROLE='ADMINISTRATOR'))";
		$listNIK=$this->oci_model->select($fieldU, 'M_CUST_PRIVILEGE',$kondisiU);
		
		$jml=count($listNIK);
		if($jml > 0){
			foreach($listNIK as $a){
				$nik=$a['NIK'];
				$email = $a['EMAIL'];
				$nama = $a['NAMA'];
				if($email <> ""){
					$this->send_mail($email, "REQUEST TRANSPORT CP", "cp", "post", $nama, $id);
				}
			}
		}
		
		date_default_timezone_set('Asia/Jakarta');
		$tgl=date("Y-m-d");
		$field="ST_SEND = '1', DATE_POSTING = TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI')";
		$kondisi="ID_CP_EDIT = '".$id."'";
		$exec=$this->oci_model->Exec($field, false, 'T_CP_EDIT', $kondisi, 'update');
		
		
		if($exec == 1){
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Posting Contact Person Request Success. Waiting for Transport.</div>');
		}
	}
	
	function unposting_cp(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$id=$this->input->post('id');
		date_default_timezone_set('Asia/Jakarta');
		$tgl=date("Y-m-d");
		
		$st=$this->oci_model->getStatusCP($id);
		if($st == "1"){
			$field="ST_SEND = '0', DATE_POSTING = ''";
			$kondisi="ID_CP_EDIT = '".$id."'";
			$exec=$this->oci_model->Exec($field, false, 'T_CP_EDIT', $kondisi, 'update');
			
			if($exec == 1){
				$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Success!</h4>
					 Unposting Change Contact Person Request Success</div>');
			}
		}else{
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
					<h4 class="alert-heading">Error!</h4>
					 Unposting failed, status contact person not "Posting".</div>');
		}
	}
	
	function form_edit_cp_edit(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$this->load->model('sap_model');
		$id=$this->uri->segment(3);
		
		$fieldU="ID_CP_EDIT,TITLE_CP,FIRSTNAME_CP,NAME_CP,TLP_CP,EXT_CP,HP_CP,FAX_CP,EMAIL_CP, 
				DEPARTMENT,FUNC,SESKODE, GENDER,TGL_LAHIR,CALL_REQ,DATE_REGISTER,PARNR,KUNNR,
				ST,ST_SEND, 
				CASE WHEN ST_SEND = 0 THEN 'OPEN' WHEN ST_SEND = 1 THEN 'POSTING' WHEN ST_SEND = 2 THEN 'IS APPROVED' END AS NEW_ST, 
				JENIS, NIK_CREATE,
				DATE_CREATE,DATE_MODIFY,NIK_MODIFY,DATE_POSTING,DATE_IS,NIK_IS,
				DEV_USERS.GET_NAME_BY_NIK(NIK_CREATE) AS NAME_CREATE ";
		$kondisiU="ID_CP_EDIT = '".$id."'";
		$dataCP=$this->oci_model->select($fieldU, 'T_CP_EDIT',$kondisiU);
		foreach($dataCP as $a){
			$data['id_cp_edit']=$a['ID_CP_EDIT'];
			$data['title']=$a['TITLE_CP'];
			$data['firstname']=$a['FIRSTNAME_CP'];
			$data['lastname']=$a['NAME_CP'];
			$data['tlp']=$a['TLP_CP'];
			$data['ext']=$a['EXT_CP'];
			$data['hp']=$a['HP_CP'];
			$data['fax']=$a['FAX_CP'];
			$data['email']=$a['EMAIL_CP'];
			$data['xdepartemen']=$a['DEPARTMENT'];
			$data['xfunction']=$a['FUNC'];
			$data['gender']=$a['GENDER'];
			$data['tgl_lahir']=$a['TGL_LAHIR'];
			$data['call_freq']=$a['CALL_REQ'];
			$data['tgl_register']=$a['DATE_REGISTER'];
			$data['parnr']=$a['PARNR'];
			$data['kunnr']=$a['KUNNR'];
			$data['st']=$a['ST'];
			$data['st_send']=$a['ST_SEND'];
			$data['new_st']=$a['NEW_ST'];
			$data['jenis']=$a['JENIS'];
			$data['nik_create']=$a['NIK_CREATE'];
			

		}
		$data['call_frequency']=$this->sap_model->getCallFrequency();
		$data['departemen']=$this->sap_model->getDepartemen();
		$data['function']=$this->sap_model->getFunction();
		$data['main_content']="customer/form_edit_cp_edit";
		$this->load->view('template/main',$data);	
		
	}
	
	function save_edit_change_cp(){
		$this->load->model('oci_model');
		
		$id_cp=$this->input->post('id_cp');
		$kunnr=$this->input->post('cust_account');
		$parnr=$this->input->post('parnr');
		$title=$this->input->post('title_cp');
		$firstname=$this->input->post('firstname_cp');
		$name=$this->input->post('name_cp');
		$tlp=$this->input->post('tlp_cp');
		$ext=$this->input->post('ext_cp');
		$hp=$this->input->post('hp_cp');
		$fax=$this->input->post('fax_cp');
		$dept=$this->input->post('departemen');
		$func=$this->input->post('function');
		$email=$this->input->post('email_cp');
		$gender=$this->input->post('gender');
		$tgl_lahir=$this->input->post('tgl_lahir');
		$tgl_register=$this->input->post('tgl_register');
		$call_freq = $this->input->post('call_frequency');
		$seskode = $this->session->userdata('seskode');
		$user=$this->session->userdata('NIK');
		
		
		$field="TITLE_CP = '".$title."', FIRSTNAME_CP = '".$firstname."', NAME_CP = '".$name."', TLP_CP = '".$tlp."', EXT_CP = '".$ext."',
			HP_CP = '".$hp."', FAX_CP = '".$fax."', EMAIL_CP = '".$email."' , DEPARTMENT = '".$dept."',FUNC = '".$func."',GENDER = '".$gender."',TGL_LAHIR = '".$tgl_lahir."',CALL_REQ = '".$call_freq."', DATE_REGISTER = '".$tgl_register."',
			NIK_MODIFY = '".$user."',
			DATE_MODIFY = TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI')";
		$kondisi="ID_CP_EDIT = '".$id_cp."'";
		$exec=$this->oci_model->Exec($field, false, 'T_CP_EDIT', $kondisi, 'update');
		
		$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Update Request Change Contact Person Success! </div>');
			    redirect(site_url('customer/list_cp_req'));
	}
	
	
	function view_cp(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$this->load->model('sap_model');
		$id=$this->uri->segment(3);
		
		$fieldU="ID_CP_EDIT,TITLE_CP,FIRSTNAME_CP,NAME_CP,TLP_CP,EXT_CP,HP_CP,FAX_CP,EMAIL_CP, 
				DEPARTMENT,FUNC,SESKODE, GENDER,TGL_LAHIR,CALL_REQ,DATE_REGISTER,PARNR,KUNNR,
				ST,ST_SEND, CASE WHEN ST_SEND = 0 THEN 'OPEN' WHEN ST_SEND = 1 THEN 'POSTING' WHEN ST_SEND = 2 THEN 'IS APPROVED' END AS NEW_ST, 
				JENIS, NIK_CREATE, DATE_CREATE,DATE_MODIFY,NIK_MODIFY,DATE_POSTING,DATE_IS,NIK_IS,
				DEV_USERS.GET_NAME_BY_NIK(NIK_CREATE) AS NAME_CREATE ";
		$kondisiU="ID_CP_EDIT = '".$id."'";
		$dataCP=$this->oci_model->select($fieldU, 'T_CP_EDIT',$kondisiU);
		foreach($dataCP as $a){
			$data['id_cp_edit']=$a['ID_CP_EDIT'];
			$data['title']=$a['TITLE_CP'];
			$data['firstname']=$a['FIRSTNAME_CP'];
			$data['lastname']=$a['NAME_CP'];
			$data['tlp']=$a['TLP_CP'];
			$data['ext']=$a['EXT_CP'];
			$data['hp']=$a['HP_CP'];
			$data['fax']=$a['FAX_CP'];
			$data['email']=$a['EMAIL_CP'];
			$data['xdepartemen']=$a['DEPARTMENT'];
			$data['xfunction']=$a['FUNC'];
			$data['gender']=$a['GENDER'];
			$data['tgl_lahir']=$a['TGL_LAHIR'];
			$data['call_freq']=$a['CALL_REQ'];
			$data['tgl_register']=$a['DATE_REGISTER'];
			$data['parnr']=$a['PARNR'];
			$data['kunnr']=$a['KUNNR'];
			$data['st']=$a['ST'];
			$data['st_send']=$a['ST_SEND'];
			$data['new_st']=$a['NEW_ST'];
			$data['jenis']=$a['JENIS'];
			$data['nik_create']=$a['NIK_CREATE'];
			$data['date_posting']=$a['DATE_POSTING'];
			$data['nik_modif']=$a['NIK_MODIFY'];
			$data['date_is']=$a['DATE_IS'];
			$data['nik_is']=$a['NIK_IS'];
			$data['tgl_create']=$a['DATE_CREATE'];
			$data['tgl_modif']=$a['DATE_MODIFY'];

		}
		$data['call_frequency']=$this->sap_model->getCallFrequency();
		$data['departemen']=$this->sap_model->getDepartemen();
		$data['function']=$this->sap_model->getFunction();
		$data['main_content']="customer/view_cp";
		$this->load->view('template/main',$data);	
		
	}
	function list_cp_is(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->my_auth->hak_akses("REQUESTER");
		
		$this->load->model('oci_model');
		$usr=$this->session->userdata('NIK');
		$role=$this->session->userdata('role');
		
		
		$field="ID_CP_EDIT,TITLE_CP,FIRSTNAME_CP,NAME_CP,TLP_CP,EXT_CP,HP_CP,FAX_CP,EMAIL_CP, 
			DEPARTMENT,FUNC,SESKODE, GENDER,TGL_LAHIR,CALL_REQ,DATE_REGISTER,PARNR,KUNNR,ST,ST_SEND, 
			CASE WHEN ST_SEND = 0 THEN 'OPEN' WHEN ST_SEND = 1 THEN 'POSTING' WHEN ST_SEND = 2 THEN 'IS APPROVED' END AS NEW_ST, 
			JENIS, NIK_CREATE,
			DATE_CREATE,DATE_MODIFY,NIK_MODIFY,DATE_POSTING,DATE_IS,NIK_IS,
			DEV_USERS.GET_NAME_BY_NIK(NIK_CREATE) AS NAME_CREATE ";
		$kondisi="ST = '1' AND ST_SEND = '1' ORDER BY ID_CP_EDIT DESC";
		$data['row']=$this->oci_model->select($field, 'T_CP_EDIT',$kondisi);
		
		
		$data['main_content']="customer/list_cp_is";
		$this->load->view('template/main',$data);	
	}
	
	function form_transport_cp(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->load->model('oci_model');
		$this->load->model('sap_model');
		$id=$this->uri->segment(3);
		
		$fieldU="ID_CP_EDIT,TITLE_CP,FIRSTNAME_CP,NAME_CP,TLP_CP,EXT_CP,HP_CP,FAX_CP,EMAIL_CP, 
				DEPARTMENT,FUNC,SESKODE, GENDER,TGL_LAHIR,CALL_REQ,DATE_REGISTER,PARNR,KUNNR,
				ST,ST_SEND, CASE WHEN ST_SEND = 0 THEN 'OPEN' WHEN ST_SEND = 1 THEN 'POSTING' WHEN ST_SEND = 2 THEN 'IS APPROVED' END AS NEW_ST, 
				JENIS, NIK_CREATE, DATE_CREATE,DATE_MODIFY,NIK_MODIFY,DATE_POSTING,DATE_IS,NIK_IS,
				DEV_USERS.GET_NAME_BY_NIK(NIK_CREATE) AS NAME_CREATE ";
		$kondisiU="ID_CP_EDIT = '".$id."'";
		$dataCP=$this->oci_model->select($fieldU, 'T_CP_EDIT',$kondisiU);
		foreach($dataCP as $a){
			$data['id_cp_edit']=$a['ID_CP_EDIT'];
			$data['title']=$a['TITLE_CP'];
			$data['firstname']=$a['FIRSTNAME_CP'];
			$data['lastname']=$a['NAME_CP'];
			$data['tlp']=$a['TLP_CP'];
			$data['ext']=$a['EXT_CP'];
			$data['hp']=$a['HP_CP'];
			$data['fax']=$a['FAX_CP'];
			$data['email']=$a['EMAIL_CP'];
			$data['xdepartemen']=$a['DEPARTMENT'];
			$data['xfunction']=$a['FUNC'];
			$data['gender']=$a['GENDER'];
			$data['tgl_lahir']=$a['TGL_LAHIR'];
			$data['call_freq']=$a['CALL_REQ'];
			$data['tgl_register']=$a['DATE_REGISTER'];
			$data['parnr']=$a['PARNR'];
			$data['kunnr']=$a['KUNNR'];
			$data['st']=$a['ST'];
			$data['st_send']=$a['ST_SEND'];
			$data['new_st']=$a['NEW_ST'];
			$data['jenis']=$a['JENIS'];
			$data['nik_create']=$a['NIK_CREATE'];
			$data['date_posting']=$a['DATE_POSTING'];
			$data['nik_modif']=$a['NIK_MODIFY'];
			$data['date_is']=$a['DATE_IS'];
			$data['nik_is']=$a['NIK_IS'];
			$data['tgl_create']=$a['DATE_CREATE'];
			$data['tgl_modif']=$a['DATE_MODIFY'];

		}
		$data['call_frequency']=$this->sap_model->getCallFrequency();
		$data['departemen']=$this->sap_model->getDepartemen();
		$data['function']=$this->sap_model->getFunction();
		$data['main_content']="customer/form_transport_cp";
		$this->load->view('template/main',$data);
	}
	
	function form_new_cp(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->my_auth->hak_akses("REQUESTER");
		$this->load->model('sap_model');
		$kunnr=$this->uri->segment(3);
		$data['kunnr']=$kunnr;
		$data['call_frequency']=$this->sap_model->getCallFrequency();
		$data['departemen']=$this->sap_model->getDepartemen();
		$data['function']=$this->sap_model->getFunction();
		$data['main_content']="customer/form_new_cp";
		$this->load->view('template/main',$data);
		
	}
	
	function save_new_cp(){
		$this->load->model('oci_model');
		
		$kunnr=$this->input->post('cust_account');
		//$parnr=$this->input->post('parnr');
		$title=$this->input->post('title_cp');
		$firstname=$this->input->post('firstname_cp');
		$name=$this->input->post('xname_cp');
		$tlp=$this->input->post('tlp_cp');
		$ext=$this->input->post('ext_cp');
		$hp=$this->input->post('hp_cp');
		$fax=$this->input->post('fax_cp');
		$dept=$this->input->post('departemen');
		$func=$this->input->post('function');
		$email=$this->input->post('email_cp');
		$gender=$this->input->post('gender');
		$tgl_lahir=$this->input->post('tgl_lahir');
		$tgl_register=$this->input->post('tgl_register');
		$call_freq = $this->input->post('call_frequency');
		$seskode = $this->session->userdata('seskode');
		$user=$this->session->userdata('NIK');
		
		$idCP=$this->oci_model->nextIDCP_EDIT('ID_CP_EDIT', 'T_CP_EDIT',FALSE);
		$fieldH='ID_CP_EDIT,TITLE_CP,FIRSTNAME_CP,NAME_CP,TLP_CP,EXT_CP,HP_CP,FAX_CP,EMAIL_CP,DEPARTMENT,FUNC,SESKODE,GENDER,TGL_LAHIR,CALL_REQ,DATE_REGISTER,PARNR,KUNNR,ST,ST_SEND,JENIS, NIK_CREATE, DATE_CREATE, DATE_MODIFY, NIK_MODIFY';
		$valH= "'".trim($idCP)."', '".trim($title)."', '".trim($firstname)."', '".trim($name)."', '".trim($tlp)."', '".trim($ext)."', '".trim($hp)."', '".trim($fax)."' , '".trim($email)."', '".trim($dept)."',  '".trim($func)."', '".trim($seskode)."' , '".trim($gender)."', '".trim($tgl_lahir)."', '".trim($call_freq)."', '".trim($tgl_register)."', '-','".trim($kunnr)."','1','0','NEW', '".trim($user)."', TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI'), TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI'), '".trim($user)."'";
		$exec=$this->oci_model->Exec($fieldH, $valH, 'T_CP_EDIT', FALSE, 'insert');
		
		$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				 Request Change Contact Person (New) Success! </div>');
			    redirect(site_url('customer/list_cp_req'));
	}
	
	function transport_cp(){
		if( $this->session->userdata('logged_state') !== true){
			redirect('home/login');
		}
		$this->my_auth->hak_akses("MASTERDATA");
		
		$this->load->model('oci_model');
		$this->load->model('sap_model');
		$id=$this->input->post('id_cp');
		
		$fieldU="ID_CP_EDIT,TITLE_CP,FIRSTNAME_CP,NAME_CP,TLP_CP,EXT_CP,HP_CP,FAX_CP,EMAIL_CP, 
				DEPARTMENT,FUNC,SESKODE, GENDER,TGL_LAHIR,CALL_REQ,DATE_REGISTER,PARNR,KUNNR,
				ST,ST_SEND, CASE WHEN ST_SEND = 0 THEN 'OPEN' WHEN ST_SEND = 1 THEN 'POSTING' WHEN ST_SEND = 2 THEN 'IS APPROVED' END AS NEW_ST, 
				JENIS, NIK_CREATE, DATE_CREATE,DATE_MODIFY,NIK_MODIFY,DATE_POSTING,DATE_IS,NIK_IS,
				DEV_USERS.GET_NAME_BY_NIK(NIK_CREATE) AS NAME_CREATE ";
		$kondisiU="ID_CP_EDIT = '".$id."'";
		$dataCP=$this->oci_model->select($fieldU, 'T_CP_EDIT',$kondisiU);
		foreach($dataCP as $a){
			$id_cp_edit=$a['ID_CP_EDIT'];
			$title=$a['TITLE_CP'];
			$firstname=$a['FIRSTNAME_CP'];
			$lastname=$a['NAME_CP'];
			$tlp=$a['TLP_CP'];
			$ext=$a['EXT_CP'];
			$hp=$a['HP_CP'];
			$fax=$a['FAX_CP'];
			$email=$a['EMAIL_CP'];
			$xdepartemen=$a['DEPARTMENT'];
			$xfunction=$a['FUNC'];
			$gender=$a['GENDER'];
			$tgl_lahir=$a['TGL_LAHIR'];
			$call_freq=$a['CALL_REQ'];
			$tgl_register=$a['DATE_REGISTER'];
			$parnr=$a['PARNR'];
			$kunnr=$a['KUNNR'];
			$st=$a['ST'];
			$st_send=$a['ST_SEND'];
			$new_st=$a['NEW_ST'];
			$jenis=$a['JENIS'];
			$nik_create=$a['NIK_CREATE'];
			$date_posting=$a['DATE_POSTING'];
			$nik_modif=$a['NIK_MODIFY'];
			$date_is=$a['DATE_IS'];
			$nik_is=$a['NIK_IS'];
			$tgl_create=$a['DATE_CREATE'];
			$tgl_modif=$a['DATE_MODIFY'];
		}
		
		if($jenis == "EDIT"){
			$this->load->library('saprfc');	
			$this->load->library('sapauth');		
			
			$tgl_lahir_cp2=substr($tgl_lahir,6,4).substr($tgl_lahir,3,2).substr($tgl_lahir,0,2);
			//tgl register
			$date_register_cp2=substr($tgl_register,0,2).".".substr($tgl_register,3,2).".".substr($tgl_register,6,4);
			$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
			$data['content']=$this->saprfc->callFunction("ZBAPI_CUSTOMER_CONTACTPERSON",
				array(	array("IMPORT","XKUNNR",$kunnr),
					array("IMPORT","JENIS","EDIT"),
					array("IMPORT","XIDCP", $parnr),
					array("IMPORT","XFIRSTNAME",$firstname),
					array("IMPORT","XLASTNAME", $lastname),
					array("IMPORT","XTITLE", $title),
					array("IMPORT","XTLP",$tlp),
					array("IMPORT","XEXT", $ext),
					array("IMPORT","XDEPARTEMEN", $xdepartemen),
					array("IMPORT","XFUNCTION", $xfunction),
					array("IMPORT","XFAX", $fax),
					array("IMPORT","XEMAIL",$email),
					array("IMPORT","XGENDER",$gender),
					array("IMPORT","XTGL_LAHIR",$tgl_lahir_cp2),
					array("IMPORT","XCALL_FREQ",$call_freq),
					array("IMPORT","XDATE_REGISTER",$date_register_cp2),
					array("EXPORT","XPANNR",array())
				     )
				); 	
					
			echo $this->saprfc->printStatus();
			echo $this->saprfc->getStatus();
			echo "<br/><br/>";
			$id_contact = $data['content']["XPANNR"];
			echo $id_contact;
			$this->saprfc->logoff();
			
			$this->load->library('saprfc');	
			$this->load->library('sapauth');		
			if($title == "Mr."){
				$kode_title_cp = "0002";
			}elseif($title == "Ms."){
				$kode_title_cp = "0001";
			}elseif($title == "Company"){
				$kode_title_cp = "0003";
			}elseif($title == "Mr. and Mrs."){
				$kode_title_cp = "0004";
			}else{
				$kode_title_cp = "";
			}
			$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
			//Cek Connection SAP Status	
			$data['content']=$this->saprfc->callFunction("ZBAPI_CUST_CONTACTPERSON_SAVE",
				array(	array("IMPORT","XKUNNR", $kunnr),
					array("IMPORT","XPANR", $parnr),
					array("IMPORT","XFIRSTNAME", $firstname),
					array("IMPORT","XLASTNAME", $lastname),
					array("IMPORT","XTITLE",$kode_title_cp),
					array("IMPORT","XTLP",$tlp),
					array("IMPORT","XEXT",$ext),
					array("IMPORT","XHP",$hp),
					array("IMPORT","XDEPARTEMEN", $xdepartemen),
					array("IMPORT","XFUNCTION", $xfunction),
					array("IMPORT","XFAX", $fax),
					array("IMPORT","XEMAIL", $email)
				     )
				); 	
					
			echo $this->saprfc->printStatus();
			echo $this->saprfc->getStatus();
			echo "<br/><br/>";
			
			$this->saprfc->logoff();
			
			$user=$this->session->userdata('NIK');
			$field="ST_SEND = '2', NIK_IS = '".$user."',DATE_IS = TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI')";
			$kondisi="ID_CP_EDIT = '".$id."'";
			$exec=$this->oci_model->Exec($field, false, 'T_CP_EDIT', $kondisi, 'update');
			
		}else{
			//NEW
			$this->load->library('saprfc');	
			$this->load->library('sapauth');
			
			//tgl lahir
			
			$tgl_lahir_cp2=substr($tgl_lahir,6,4).substr($tgl_lahir,3,2).substr($tgl_lahir,0,2);
			//tgl register
			$date_register_cp2=substr($tgl_register,0,2).".".substr($tgl_register,3,2).".".substr($tgl_register,6,4);
			
			$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
			$data['content']=$this->saprfc->callFunction("ZBAPI_CUSTOMER_CONTACTPERSON",
				array(	array("IMPORT","XKUNNR",$kunnr),
					array("IMPORT","JENIS","ADD"),
					array("IMPORT","XFIRSTNAME",$firstname),
					array("IMPORT","XLASTNAME", $lastname),
					array("IMPORT","XTITLE", $title),
					array("IMPORT","XTLP",$tlp),
					array("IMPORT","XEXT", $ext),
					array("IMPORT","XDEPARTEMEN", $xdepartemen),
					array("IMPORT","XFUNCTION", $xfunction),
					array("IMPORT","XFAX", $fax),
					array("IMPORT","XEMAIL",$email),
					array("IMPORT","XGENDER",$gender),
					array("IMPORT","XTGL_LAHIR",$tgl_lahir_cp2),
					array("IMPORT","XCALL_FREQ",$call_freq),
					array("IMPORT","XDATE_REGISTER",$date_register_cp2),
					array("EXPORT","XPANNR",array())
				     )
				); 	
					
			$id_contact = $data['content']["XPANNR"];
			echo $id_contact;
			$this->saprfc->logoff();
			
			if($title == "Mr."){
				$kode_title_cp = "0002";
			}elseif($title == "Ms."){
				$kode_title_cp = "0001";
			}elseif($title == "Company"){
				$kode_title_cp = "0003";
			}elseif($title == "Mr. and Mrs."){
				$kode_title_cp = "0004";
			}else{
				$kode_title_cp = "";
			}
				
			
			$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
			//Cek Connection SAP Status	
			$data['content']=$this->saprfc->callFunction("ZBAPI_CUST_CONTACTPERSON_SAVE",
				array(	array("IMPORT","XKUNNR",$kunnr),
					array("IMPORT","XPANR",$id_contact),
					array("IMPORT","XFIRSTNAME",$firstname),
					array("IMPORT","XLASTNAME", $lastname),
					array("IMPORT","XTITLE", $kode_title_cp),
					array("IMPORT","XTLP", $tlp),
					array("IMPORT","XHP",$hp),
					array("IMPORT","XEXT", $ext),
					array("IMPORT","XDEPARTEMEN", $xdepartemen),
					array("IMPORT","XFUNCTION", $xfunction),
					array("IMPORT","XFAX", $fax),
					array("IMPORT","XEMAIL",$email)
				     )
				); 	
					
			$this->saprfc->logoff();
			$user=$this->session->userdata('NIK');
			$field="ST_SEND = '2', PARNR = '".$id_contact."', NIK_IS = '".$user."',DATE_IS = TO_CHAR(SYSDATE, 'DD-MM-YYYY HH24:MI')";
			$kondisi="ID_CP_EDIT = '".$id."'";
			$exec=$this->oci_model->Exec($field, false, 'T_CP_EDIT', $kondisi, 'update');
			
		}
		
		//EMAIL END USER
		$fieldU="DEV_USERS.GET_NAME_BY_NIK('".$nik_create."') as NAMA, DEV_USERS.GET_EMAIL_BY_NIK('".$nik_create."') AS EMAIL";
		//$kondisiU="NIK='".$user."'";
		$listNIK=$this->oci_model->select($fieldU, 'DUAL', false);
		
		$jml=count($listNIK);
		if($jml > 0){
			foreach($listNIK as $a){
				//$nik=$a['NIK'];
				$email = $a['EMAIL'];
				$nama = $a['NAMA'];
				if($email <> ""){
					//$this->send_mail2($email, "REQUEST NEW CUSTOMER", "requestor", $nama, $xkunnr);
					$this->send_mail($email, "REQUEST Contact Person", "cp", "konfirm", $nama, $id);
				}
			}
		}
		
		$this->session->set_flashdata('msg','<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
				<h4 class="alert-heading">Success!</h4>
				Transport Contact Person Success, ID Contact Person : '.$id_contact.' </div>');
			redirect(site_url('customer/list_cp_is'));
			
	}
}
