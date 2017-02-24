<?php

class global_model extends CI_Model {

	public function __construct()
	{
	     // Call the Model constructor
        parent::__construct();
	}

    public function LoadBisnis()
	{
		$query = $this->db->query("SELECT * FROM tm_pt order by vakronim ");
		if($query){
			return $query->result_array();
		}else{
			return FALSE;
		} 
	}
	    public function getBisnis($kode=FALSE)
	{
		$query = $this->db->query("SELECT vakronim FROM tm_pt where ket_pt=$kode ");
		if($query){
			return $query->result_array();
		}else{
			return FALSE;
		} 
	}
	public function LoadKaryawan($var=FALSE)
	{
//		if(is_array($result)){	 unset($result);	}
			$Array=array();
			$karyawan="SELECT vid,vname FROM tm_karyawan where vname like '%$var%' and sel_grade not in ('18.2', '17.2','17.0', '16.2',	'16.1', '16.0','Non Grade') "; 
			//$total=$this->db->query($karyawan)->num_rows();	    //hitung total data	
			$load=$this->db->query($karyawan)->result_array(); 	//load fetch data dengan array
			
			
			if(count($load)>0){					
						//echo "<pre>".print_r($result)."</pre>";										
				foreach($load as $data){				
				 		 //if(!empty($data['vid']) and !empty($data['vname']) ){
						array_push($Array,array('vid'=>$data['vid'],'vname'=>$data['vname']));
										
				}
				$result=$Array;				
			}
		  
			
			
			unset($Array);	
				//}else{
			//unset($result);
					
				//}
		
		return $result;
	}
	
	public function GetNamaKaryawan($NIK=FALSE)
	{
		$query = $this->db->query("SELECT * FROM tm_pt where vid=$NIK ");
		if($query){
			return $query->result_array();
		}else{
			return FALSE;
		} 
	}
	
	public function GetProfilKaryawan($NIK=FALSE)
	{
		
		$query = $this->db->query("select (SELECT vakronim FROM `tm_pt` WHERE key_pt = kar.key_pt) as pt,  
		(SELECT nm_divisi FROM `tm_divisi` WHERE key_divisi=kar.key_divisi) as divisi, kar.vname, kar.vid
		FROM tm_karyawan kar where kar.vid = '$NIK' ");
		
		if($query){
//			$result=array();
//			foreach($query as $data){
//				array_push($result,array($data['pt'],$data['divisi'],$data['vid'],$data['vname']);
//			}
			return $query->result_array();
		}else{
			return FALSE;
		} 
	}
	
}