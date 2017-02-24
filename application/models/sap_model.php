<?php
class sap_model extends CI_Model {
    
    function getCompanyCode(){
        $this->load->library('saprfc');	
	$this->load->library('sapauth');
        $data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
        //Cek Connection SAP Status	
	$data['content']=$this->saprfc->callFunction("ZBAPI_GET_COMPANY_CODE",
			array(	
			    array("TABLE","XT001",array())
			)); 				
	$now=date("Ymd");	
	$this->saprfc->logoff();
        foreach($data['content']["XT001"] as $row){
            $dataA[]=$row;
        }
        return $dataA;
    }
    
    function getCountry(){
        $this->load->library('saprfc');	
	$this->load->library('sapauth');
        $data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
        //Cek Connection SAP Status	
	$data['content']=$this->saprfc->callFunction("ZBAPI_GET_COUNTRY",
			array(
                            array("IMPORT","XSPRAS","EN"),
			    array("TABLE","XT005T",array())
			)); 				
	$now=date("Ymd");	
	$this->saprfc->logoff();
        foreach($data['content']["XT005T"] as $row){
            $dataA[]=$row;
        }
        return $dataA;
    }
    
    function getRegion($land1){
        $this->load->library('saprfc');	
	$this->load->library('sapauth');
        $data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
        //Cek Connection SAP Status	
	$data['content']=$this->saprfc->callFunction("ZBAPI_GET_REGION",
			array(
                            array("IMPORT","XSPRAS","EN"),
                            array("IMPORT","XLAND1",$land1),
			    array("TABLE","XT005U",array())
			)); 				
	$this->saprfc->logoff();
        $dataA[]="";
        foreach($data['content']["XT005U"] as $row){
            $dataA[]=$row;
        }
        //print_r($dataA);
        return $dataA;
    }
    
    function getIndustry(){
        $this->load->library('saprfc');	
	$this->load->library('sapauth');
        $data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
        //Cek Connection SAP Status	
	$data['content']=$this->saprfc->callFunction("ZBAPI_GET_INDUSTRY",
			array(
                            array("IMPORT","XSPRAS","EN"),
			    array("TABLE","XT016T",array())
			)); 				
	$this->saprfc->logoff();
        $dataA[]="";
        foreach($data['content']["XT016T"] as $row){
            $dataA[]=$row;
        }
        //print_r($dataA);
        return $dataA;
    }
    function getIndustryCode(){
        $this->load->library('saprfc');	
	$this->load->library('sapauth');
        $data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
        //Cek Connection SAP Status	
	$data['content']=$this->saprfc->callFunction("ZBAPI_GET_INDUSTRY_CODE",
			array(
                            array("IMPORT","XSPRAS","EN"),
			    array("TABLE","XTBRCT",array())
			)); 				
	$this->saprfc->logoff();
        $dataA[]="";
        foreach($data['content']["XTBRCT"] as $row){
            $dataA[]=$row;
        }
        //print_r($dataA);
        return $dataA;
    }
    function getCustomerClass(){
        $this->load->library('saprfc');	
	$this->load->library('sapauth');
        $data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
        //Cek Connection SAP Status	
	$data['content']=$this->saprfc->callFunction("ZBAPI_GET_CUSTOMER_CLASS",
			array(
                            array("IMPORT","XSPRAS","EN"),
			    array("TABLE","XTKUKT",array())
			)); 				
	$this->saprfc->logoff();
        $dataA[]="";
        foreach($data['content']["XTKUKT"] as $row){
            $dataA[]=$row;
        }
        //print_r($dataA);
        return $dataA;
    }
    
    function getTOP(){
        $this->load->library('saprfc');	
	$this->load->library('sapauth');
        $data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
        //Cek Connection SAP Status	
	$data['content']=$this->saprfc->callFunction("ZBAPI_GET_TOP",
			array(
			    array("TABLE","XTVZBT",array())
			)); 				
	$this->saprfc->logoff();
        $dataA[]="";
        foreach($data['content']["XTVZBT"] as $row){
            $dataA[]=$row;
        }
        //print_r($dataA);
        return $dataA;
    }
    
    function getSalesOffice(){
        $this->load->library('saprfc');	
	$this->load->library('sapauth');
        $data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
        //Cek Connection SAP Status	
	$data['content']=$this->saprfc->callFunction("ZBAPI_GET_SALES_OFFICE",
			array(
                            array("IMPORT","XSPRAS","EN"),
			    array("TABLE","XTVKBT",array())
			)); 				
	$this->saprfc->logoff();
        $dataA[]="";
        foreach($data['content']["XTVKBT"] as $row){
            $dataA[]=$row;
        }
        //print_r($dataA);
        return $dataA;
    }
    
    function getCustomerGroup(){
        $this->load->library('saprfc');	
	$this->load->library('sapauth');
        $data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
        //Cek Connection SAP Status	
	$data['content']=$this->saprfc->callFunction("ZBAPI_GET_CUSTOMER_GROUP",
			array(
                            array("IMPORT","XSPRAS","EN"),
			    array("TABLE","XT151T",array())
			)); 				
	$this->saprfc->logoff();
        $dataA[]="";
        foreach($data['content']["XT151T"] as $row){
            $dataA[]=$row;
        }
        //print_r($dataA);
        return $dataA;
    }
    
    function getCurrency(){
        $this->load->library('saprfc');	
	$this->load->library('sapauth');
        $data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
        //Cek Connection SAP Status	
	$data['content']=$this->saprfc->callFunction("ZBAPI_GET_CURRENCY",
			array(
                            array("IMPORT","XSPRAS","EN"),
			    array("TABLE","XTCURT",array())
			)); 				
	$this->saprfc->logoff();
        $dataA[]="";
        foreach($data['content']["XTCURT"] as $row){
            $dataA[]=$row;
        }
        //print_r($dataA);
        return $dataA;
    }
    
    function getIncoterm(){
        $this->load->library('saprfc');	
	$this->load->library('sapauth');
        $data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
        //Cek Connection SAP Status	
	$data['content']=$this->saprfc->callFunction("ZBAPI_GET_INCOTERM",
			array(
                            array("IMPORT","XSPRAS","EN"),
			    array("TABLE","XTINCT",array())
			)); 				
	$this->saprfc->logoff();
        $dataA[]="";
        foreach($data['content']["XTINCT"] as $row){
            $dataA[]=$row;
        }
        //print_r($dataA);
        return $dataA;
    }
    
    function getDepartemen(){
        $this->load->library('saprfc');	
	$this->load->library('sapauth');
        $data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
        //Cek Connection SAP Status	
	$data['content']=$this->saprfc->callFunction("ZBAPI_GET_DEPARTEMENT",
			array(
                            array("IMPORT","XSPRAS","EN"),
			    array("TABLE","XTSABT",array())
			)); 				
	$this->saprfc->logoff();
        $dataA[]="";
        foreach($data['content']["XTSABT"] as $row){
            $dataA[]=$row;
        }
        //print_r($dataA);
        return $dataA;
    }
    
    function getFunction(){
        $this->load->library('saprfc');	
	$this->load->library('sapauth');
        $data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
        //Cek Connection SAP Status	
	$data['content']=$this->saprfc->callFunction("ZBAPI_GET_FUNCTION",
			array(
                            array("IMPORT","XSPRAS","EN"),
			    array("TABLE","XTPFKT",array())
			)); 				
	$this->saprfc->logoff();
        $dataA[]="";
        foreach($data['content']["XTPFKT"] as $row){
            $dataA[]=$row;
        }
        //print_r($dataA);
        return $dataA;
    }
    
    function getNielsen(){
	$this->load->library('saprfc');	
	$this->load->library('sapauth');
        $data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
        //Cek Connection SAP Status	
	$data['content']=$this->saprfc->callFunction("ZBAPI_GET_NIELSEN_ID",
			array(
                            array("IMPORT","XSPRAS","EN"),
			    array("TABLE","XTNLST",array())
			)); 				
	$this->saprfc->logoff();
        $dataA[]="";
        foreach($data['content']["XTNLST"] as $row){
            $dataA[]=$row;
        }
        //print_r($dataA);
        return $dataA;
    }
    
    function getDistributionChannel(){
	$this->load->library('saprfc');	
	$this->load->library('sapauth');
        $data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
        //Cek Connection SAP Status	
	$data['content']=$this->saprfc->callFunction("ZBAPI_GET_DISTRIBUTION_CHANNEL",
			array(
                            array("IMPORT","XSPRAS","EN"),
			    array("TABLE","XTVTWT",array())
			)); 				
	$this->saprfc->logoff();
        $dataA[]="";
        foreach($data['content']["XTVTWT"] as $row){
            $dataA[]=$row;
        }
        //print_r($dataA);
        return $dataA;
    }
    
    function getDivision(){
	$this->load->library('saprfc');	
	$this->load->library('sapauth');
        $data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
        //Cek Connection SAP Status	
	$data['content']=$this->saprfc->callFunction("ZBAPI_GET_DIVISION",
			array(
                            array("IMPORT","XSPRAS","EN"),
			    array("TABLE","XTSPAT",array())
			)); 				
	$this->saprfc->logoff();
        $dataA[]="";
        foreach($data['content']["XTSPAT"] as $row){
            $dataA[]=$row;
        }
        //print_r($dataA);
        return $dataA;
    }
    
    function getSalesOrganization(){
	$this->load->library('saprfc');	
	$this->load->library('sapauth');
        $data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
        //Cek Connection SAP Status	
	$data['content']=$this->saprfc->callFunction("ZBAPI_GET_SALES_ORGANIZATION",
			array(
                            array("IMPORT","XSPRAS","EN"),
			    array("TABLE","XTVKOT",array())
			)); 				
	$this->saprfc->logoff();
        $dataA[]="";
        foreach($data['content']["XTVKOT"] as $row){
            $dataA[]=$row;
        }
        //print_r($dataA);
        return $dataA;
    }
    
    function getAccountGroup(){
	$this->load->library('saprfc');	
	$this->load->library('sapauth');
	$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
        //Cek Connection SAP Status	
	$data['content']=$this->saprfc->callFunction("ZBAPI_GET_ACCOUNT_GROUP",
			array(
                            array("IMPORT","XSPRAS","EN"),
			    array("TABLE","XT077X",array())
			)); 				
	$this->saprfc->logoff();
        $dataA[]="";
        foreach($data['content']["XT077X"] as $row){
            $dataA[]=$row;
        }
        //print_r($dataA);
        return $dataA;
    }
    
    function getReconAccount(){
	$this->load->library('saprfc');	
	$this->load->library('sapauth');
	$data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
        //Cek Connection SAP Status	
	$data['content']=$this->saprfc->callFunction("ZBAPI_GET_RECONT_ACCOUNT_CUST",
			array(
                            array("IMPORT","XSPRAS","EN"),
			    array("TABLE","XSKAT",array())
			)); 				
	$this->saprfc->logoff();
        $dataA[]="";
        foreach($data['content']["XSKAT"] as $row){
            $dataA[]=$row;
        }
        //print_r($dataA);
        return $dataA;
    }
    
    function getCustomerFindByKUNNR($kunnr){
	$this->load->library('saprfc');	
	$this->load->library('sapauth');
        $data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
        //Cek Connection SAP Status	
	$data['content']=$this->saprfc->callFunction("ZBAPI_FIND_CUST",
			array(
                            array("IMPORT","XKUNNR",$kunnr),
			    array("TABLE","XKNA1",array()),
			    array("TABLE","XKNB1",array()),
			    array("TABLE","XKNVV",array()),
			)); 				
	$this->saprfc->logoff();
        $dataA[]="";
        foreach($data['content']["XTSPAT"] as $row){
            $dataA[]=$row;
        }
        //print_r($dataA);
        return $dataA;
    }
    
    function getCallFrequency(){
	$this->load->library('saprfc');	
	$this->load->library('sapauth');
        $data['SAP']=$this->saprfc->saprfc($this->sapauth->dummy());   //live //dummylive
        //Cek Connection SAP Status	
	$data['content']=$this->saprfc->callFunction("ZBAPI_GET_CALL_FREQ_CP",
			array(
                            array("IMPORT","XSPRAS","EN"),
			    array("TABLE","XTVBRT",array())
			)); 				
	$this->saprfc->logoff();
        $dataA[]="";
        foreach($data['content']["XTVBRT"] as $row){
            $dataA[]=$row;
        }
        //print_r($dataA);
        return $dataA;
    }
}
?>