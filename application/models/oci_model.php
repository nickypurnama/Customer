<?php

class oci_model extends CI_Model {
	private $dboci;
	public function __construct()
	{
	     // Call the Model constructor
        parent::__construct();
		$this->dboci = $this->load->database('orcl',TRUE);
	}
	
	public function halaman($limit = array(),$field=FALSE,$table=FALSE,$kondisi=FALSE,$order=FALSE){	
		//$this->session->userdata('searchterm')
		$kondisi_rn =($kondisi)?" where ".$kondisi." ":"";
		$kondisi	=($kondisi)?" where ".$kondisi." and ":" where ";
		$field=($field)?$field:"*";
				  //exit; to_date(TGL,'DD-MM-YYYY'),judul,judul_url,keterangan,f_aktif
		if ($limit == NULL ):			
			$result=$this->dbintra->query("select $field from $table $kondisi_rn $order")->result_array();
		else:
			$qry="select $field from (SELECT a.*, row_number() over ($order) rn FROM $table a $kondisi_rn)
				  $kondisi rn between ".$limit['offset']." and ".($limit['offset']+$limit['perpage']);
			//echo $qry;
			//print_r($limit);	echo  $qry.'  '.$limit['offset']."   ".$limit['perpage']; 
			$result=$this->dboci->query($qry)->result_array();
		endif;
		$this->dboci->close();
		return $result;
	}
	
	function CountData($tbl=FALSE,$where=FALSE){
		$where=($where)?" where ".$where:"";
		$result=$this->dboci->query("select count(*) as  HASIL from $tbl $where ")->result_array();	
		//		echo "select count(*) as  HASIL from $tbl where $where ";
		$result = $result[0]['HASIL'];

		$this->dboci->close();

		return $result;
			
	}
	
	function datatotal($table=FALSE){
		$this->db->from($table);
		$result=$this->db->count_all_results();		
		
        return $result;
	}
	
	function LoadPlant($kdplant=FALSE)
    {
		if($kdplant){
			$result=$this->dboci->get_where('M_PLANT_OPNAME',array('PLANT' => $kdplant))->result_array();
		}else{
			$result=$this->dboci->query("select * from M_PLANT_OPNAME")->result_array();
		} 
		// echo oci_error($this->db->stmt_id);
		$this->dboci->close();
		return $result;      
    }

	function LoadSloc($kdloc=FALSE)
    {
		if($kdloc){
			$result=$this->dboci->query("select * from M_SLOC_OPNAME where PLANT='$kdloc'")->result_array();

		}else{
			$result=$this->dboci->query("select * from M_SLOC_OPNAME")->result_array();
		} 
		$this->dboci->close();
		return $result;      
    }
	
	function Std($val=FALSE){
		$result=$this->dboci->query($val);
		return $result;
	}
	
	public function Exec($field=false, $val=false, $tbl=false, $kondisi=false, $state=false){
		$kondisi=($kondisi)?'where '.$kondisi:"";
		if($state=='insert'){
			 // $result=$this->dbintra->insert($tbl, $val); 				
			$result=$this->dboci->query("insert into $tbl ($field) VALUES ($val)");
		}elseif($state=='update'){ 
			//echo $result="update $tbl set $field  where $kondisi";
			$result=$this->dboci->query("update $tbl set $field  $kondisi");
			//exit;
		}elseif($state=='delete'){ 
			//echo $result="update $tbl set $field  where $kondisi";
			$result=$this->dboci->query("delete from $tbl $kondisi");
		}
		$this->dboci->close();
		return $result;
		
	}
	public function select($field=FALSE, $table=FALSE,$kondisi=FALSE){
		$field=($field)?$field:'*';
		$table = ($table)?" from $table":"";
		$kondisi=($kondisi)?'where '.$kondisi:'';
		//echo "select $field from $table $kondisi";
		$result=$this->dboci->query("select $field $table $kondisi")->result_array();
		$this->dboci->close();
		return $result;
	}
	
	function GetSingle($field=FALSE, $table=FALSE,$kondisi=FALSE){
		// echo "select $field from $table where $kondisi and ROWNUM = 1 ";
		$result=$this->dboci->query("select $field from $table where $kondisi and ROWNUM = 1 ")->result_array();
		
		if(count($result)>0):
			foreach($result as $val){
				$data = $val[$field];
			}
		else:
			$data = NULL;
		endif;		 
		$this->dboci->close();
		return $data;
	}
	
	function GetSum($field=false, $tbl=FALSE, $kondisi=FALSE,$type=false){
		if($type=='SUM'){
			$fields="SUM( $field ) ";
		}
		if($type=='COUNT'){
			$fields="COUNT( $field ) ";
		}
		//echo "select $fields as HASIL from $tbl where $kondisi";
		$result=$this->dboci->query("select $fields as HASIL from $tbl where $kondisi")->result_array();
		
		if(count($result)>0):
            foreach($result as $val){
                $data = $val['HASIL'];
            }
        else:
                $data = 0;
        endif;
		
		$this->dboci->close();
		return $data;
	}
	
	function MaxID($field=FALSE,$table=FALSE,$kondisi=FALSE){
		//M_BATCHSTOKH
		$result=$this->dboci->query("select NVL(MAX($field),0) as MAXID from $table $kondisi")->result_array();
		//echo "select max(batchid) MAXID from $table";
		foreach($result as $val){
			$id = $val['MAXID'];
		}
		
		$this->dboci->close();
		return $id;
	}
	function getMaxID($table=FALSE){
		//M_BATCHSTOKH
		$result=$this->dboci->query("select MAX(BATCHID) as MAXID from $table ")->result_array();
		//echo "select max(batchid) MAXID from $table";
		foreach($result as $val){
			$id = $val['MAXID'];
		}
		
		$this->dboci->close();
		return $id;
	}
	
	function LoadHdr($plant=false,$sloc=false,$year=false){
		$result=$this->dboci->query("select * from m_batchstokh where PLANT='$plant' and sloc='$sloc' and tahun='$year' and flag=0")->result_array();
		$this->dboci->close();
		return $result;
	}
	
	function LoadDtl($batchno=false, $year=false){
		$result=$this->dboci->query("select * from m_batchstokd where batchno=$batchno and tahun=$year and FLAGED=0")->result_array();
		$this->dboci->close();
		return $result;
	}
	
	function GetData($tbl=FALSE, $kondisi=FALSE){
		//echo "select * from $tbl where $kondisi";
		$result=$this->dboci->query("select * from $tbl where $kondisi")->result_array();
		$this->dboci->close();
		return $result;
	}
	
	function GetDtl($plant=false,$sloc=false, $year=false, $flag=0, $order=FALSE){
		$result=$this->dboci->query("select row_number() OVER ($order) rn, a.* from m_batchstokd a where a.PLANT='$plant' and a.SLOC='$sloc' and a.FLAGED=$flag $order" )->result_array();
		//select * from  (SELECT a.*, row_number() over ($order) rn FROM $table a)
		//and TAHUN='$year' 
		$this->dboci->close();
		return $result;
	}
	
	function GetDetail($table = FALSE, $kondisi=false, $order=FALSE){
		//$plant=false,$sloc=false, $year=false,
		//a.PLANT='$plant' and a.SLOC='$sloc'
		$result=$this->dboci->query("select row_number() OVER ($order) rn, a.* from $table a where $kondisi $order" )->result_array();
		//select * from  (SELECT a.*, row_number() over ($order) rn FROM $table a)
		//and TAHUN='$year' 
		$this->dboci->close();
		return $result;
	}
	
	function BatchDetail($plant=FALSE,$sloc=FALSE){
		$result=$this->dboci->query("select DISTINCT BATCHNO from M_BATCHSTOKD where PLANT='$plant' and SLOC='$sloc' and FLAGED=0")->result_array();
		$joint='';
		foreach($result as $val){
			$joint .= trim($val['BATCHNO'])." ";
		}
		$this->dboci->close();
		return $joint;
	}
	
	function nextID($field=FALSE, $table=FALSE, $kondisi=FALSE){
		$result=$this->dboci->query("select NVL(MAX($field),0) as MAXID from $table $kondisi")->result_array();
		//echo "select max(batchid) MAXID from $table";
		foreach($result as $val){
			$id = $val['MAXID'];
		}
		
		$this->dboci->close();
		if($id == '0'){
			$id=1000000;
			
		}else{
			$id=$id + 1;
		}
		return $id;
	}
	function nextIDCP($field=FALSE, $table=FALSE, $kondisi=FALSE){
		$result=$this->dboci->query("select NVL(MAX($field),0) as MAXID from $table $kondisi")->result_array();
		//echo "select max(batchid) MAXID from $table";
		foreach($result as $val){
			$id = $val['MAXID'];
		}
		$this->dboci->close();
		if($id == '0'){
			$id=2000000;
			
		}else{
			$id=$id + 1;
		}
		$id=$id + 1;
		return $id;
	}
	
	function nextIDCP_EDIT($field=FALSE, $table=FALSE, $kondisi=FALSE){
		$result=$this->dboci->query("select NVL(MAX($field),0) as MAXID from $table $kondisi")->result_array();
		//echo "select max(batchid) MAXID from $table";
		foreach($result as $val){
			$id = $val['MAXID'];
		}
		$this->dboci->close();
		if($id == '0'){
			$id=5000000;
			
		}else{
			$id=$id + 1;
		}
		$id=$id + 1;
		return $id;
	}
	
	function nextIDEX(){
		$result=$this->dboci->query("select NVL(MAX(ID_EX),0) as MAXID from T_CUST_EXTEND")->result_array();
		//echo "select max(batchid) MAXID from $table";
		foreach($result as $val){
			$id = $val['MAXID'];
		}
		$this->dboci->close();
		if($id == '0'){
			$id=3000000;
			
		}else{
			$id=$id + 1;
		}
		$id=$id + 1;
		return $id;
	}
	
	function getIdRecon($id_account){
		$id="";
		$result=$this->dboci->query("select RECON_ACCOUNT from M_CUST_ACCOUNT where ACCOUNT_GROUP = '".$id_account."'")->result_array();
		foreach($result as $val){
			$id = $val['RECON_ACCOUNT'];
		}
		$this->dboci->close();
		
		return $id;
	}
	
	function cek_data_basic($com, $sls, $dis, $div){
		$jml="";
		$result=$this->dboci->query("select COUNT(*) as JML from M_CUST_KONF where COMPANY_CODE = '".$com."' AND SALES_ORG = '".$sls."' AND DIS_CHANNEL = '".$dis."' AND DIVISION = '".$div."'")->result_array();
		foreach($result as $val){
			$jml = $val['JML'];
		}
		$this->dboci->close();
		
		return $jml;
	}
	
	function cek_data_sales($account_group, $rec_account){
		$jml="";
		$result=$this->dboci->query("select COUNT(*) as JML from M_CUST_ACCOUNT where ACCOUNT_GROUP = '".$account_group."' AND RECON_ACCOUNT = '".$rec_account."'")->result_array();
		foreach($result as $val){
			$jml = $val['JML'];
		}
		$this->dboci->close();
		
		return $jml;
	}
	function cek_data_sales2($account_group){
		$jml="";
		$result=$this->dboci->query("select COUNT(*) as JML from M_CUST_ACCOUNT where ACCOUNT_GROUP = '".$account_group."'")->result_array();
		foreach($result as $val){
			$jml = $val['JML'];
		}
		$this->dboci->close();
		
		return $jml;
	}
	function getCustomerRef($com, $sls, $dis, $div){
		$jml="";
		$result=$this->dboci->query("select CUST_REF from M_CUST_KONF where COMPANY_CODE = '".$com."' AND SALES_ORG = '".$sls."' AND DIS_CHANNEL = '".$dis."' AND DIVISION = '".$div."'")->result_array();
		foreach($result as $val){
			$jml = $val['CUST_REF'];
		}
		$this->dboci->close();
		
		return $jml;
	}
	function getStatusCustomer($id){
		$jml="";
		$result=$this->dboci->query("select ST_SEND from M_CUST_KNA1 where ID_CUST = '".$id."'")->result_array();
		foreach($result as $val){
			$jml = $val['ST_SEND'];
		}
		$this->dboci->close();
		
		return $jml;
	}
	function getStatusCP($id){
		$jml="";
		$result=$this->dboci->query("select ST_SEND from T_CP_EDIT where ID_CP_EDIT = '".$id."'")->result_array();
		foreach($result as $val){
			$jml = $val['ST_SEND'];
		}
		$this->dboci->close();
		
		return $jml;
	}
	function getStatusExtendCustomer($id){
		$jml="";
		$result=$this->dboci->query("select ST_SEND from T_CUST_EXTEND where ID_EX = '".$id."'")->result_array();
		foreach($result as $val){
			$jml = $val['ST_SEND'];
		}
		$this->dboci->close();
		
		return $jml;
	}
	function getStatusEditCustomer($id){
		$jml="";
		$result=$this->dboci->query("select ST_SEND from T_CUST_EDIT where ID_EDIT = '".$id."'")->result_array();
		foreach($result as $val){
			$jml = $val['ST_SEND'];
		}
		$this->dboci->close();
		
		return $jml;
	}
	
	function valid_login(){
		date_default_timezone_set('Asia/Jakarta');
                $tgl=date("Y-m-d H:i:s")
                ;
		//$this->load->library('session');
		$nik = $this->input->post('user');
		$pas =  $this->input->post('pass');
                $qry   = "SELECT NIK, PASSWORD FROM USER_LOGIN WHERE NIK = '".$nik."' and PASSWORD = '".$pas."'";
		
		$result=$this->dboci->query($qry)->result_array();
		if(count($result)==1){
			foreach($result as $usr):
				//Get Role User Login
				$query = "SELECT ROLE FROM M_CUST_ROLE WHERE NIK='".$nik."'";
				$hasil=$this->dboci->query($query)->result_array();
				$role="";
				foreach($hasil as $a){
					$role=$role."-".$a['ROLE'];
				}
				$session_login = array('NIK' => trim($usr['NIK']), 
							'seskode' => $nik.strtotime($tgl),
							'role' => $role,
							'logged_state' => TRUE );
			endforeach;			
			$this->session->set_userdata($session_login);
			
			echo $this->session->userdata('role');
			//echo "<br/>";
			//echo $this->session->userdata('role2');
			//echo "<br/>";
			//echo $this->session->userdata('role3');
			//echo "<br/>";
			//echo $this->session->userdata('NIK');
			//echo "<br/>";
			 //print_r($this->session->all_userdata()); 
			redirect(site_url('home/index')); 
		}
		elseif(count($result) >= 2){
			$this->session->set_flashdata('msg', "Please Contact your IT Dept for your Access"); // Double		
			redirect(site_url('home/login')); 
		}
		else{
			$this->session->set_flashdata('msg','<div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">x</a>
                            <h4 class="alert-heading">Error!</h4>
                             Username/Password Salah!</div>');		
			redirect(site_url('home/login')); 
		}
	}
	
	function cek_hak_akses($nik, $sales_org, $dis_channel, $division){
		$jml="";
		$result=$this->dboci->query("select COUNT(*) as JML from M_CUST_PRIVILEGE where NIK = '".$nik."' AND SALES_ORG = '".$sales_org."' AND DIS_CHANNEL = '".$dis_channel."' AND DIVISION = '".$division."'")->result_array();
		foreach($result as $val){
			$jml = $val['JML'];
		}
		$this->dboci->close();
		
		return $jml;
	}
	function test(){
		$id="";
		$result=$this->dboci->query("select DEV_USERS.GET_NAME_BY_NIK('040600262') as ID from dual")->result_array();
		foreach($result as $val){
			$id = $val['ID'];
		}
		$this->dboci->close();
		
		return $id;
	}
	
	
	function cekRole($nik, $role){
		$jml="";
		$result=$this->dboci->query("select COUNT(*) as JML from M_CUST_ROLE where NIK = '".$nik."' AND ROLE = '".$role."'")->result_array();
		foreach($result as $val){
			$jml = $val['JML'];
		}
		$this->dboci->close();
		
		return $jml;
	}
	
	function cekPriv($nik,$sales_org, $dis_channel, $division){
		$jml="";
		$result=$this->dboci->query("select COUNT(*) as JML from M_CUST_PRIVILEGE where NIK = '".$nik."' AND SALES_ORG = '".$sales_org."' AND DIS_CHANNEL = '".$dis_channel."' AND DIVISION='".$division."'")->result_array();
		foreach($result as $val){
			$jml = $val['JML'];
		}
		$this->dboci->close();
		
		return $jml;
	}
	function cekCompany($company,$sales_org, $dis_channel, $division){
		$jml="";
		$result=$this->dboci->query("select COUNT(*) as JML from M_CUST_KONF where COMPANY_CODE = '".$company."' AND SALES_ORG = '".$sales_org."' AND DIS_CHANNEL = '".$dis_channel."' AND DIVISION='".$division."'")->result_array();
		foreach($result as $val){
			$jml = $val['JML'];
		}
		$this->dboci->close();
		
		return $jml;
	}
	
	function getJmlStatusCustReq($id){
		$jml="";
		$result=$this->dboci->query("select COUNT(*) as JML from M_CUST_KNA1 where ID_CUST = '".$id."'")->result_array();
		foreach($result as $val){
			$jml = $val['JML'];
		}
		$this->dboci->close();
		
		return $jml;
	}
	
	function cekKUNNR($id){
		$jml="";
		$result=$this->dboci->query("select ST_SEND as ID from M_CUST_KNA1 where ID_CUST = '".$id."'")->result_array();
		foreach($result as $val){
			$jml = $val['ID'];
		}
		$this->dboci->close();
		
		return $jml;
	}
	function getNamaKNA1($id){
		$jml="";
		$result=$this->dboci->query("select NAME1 as ID from M_CUST_KNA1 where ID_CUST = '".$id."'")->result_array();
		foreach($result as $val){
			$jml = $val['ID'];
		}
		$this->dboci->close();
		
		return $jml;
	}
	
	
}
