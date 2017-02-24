<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class sapauth {
	function dummy(){
		$connect = array("logindata"=>array(
				"ASHOST"=>"192.168.0.33"		// application server
				,"SYSNR"=>"10"				// system number
				,"CLIENT"=>"120"			// client
				,"USER"=>"developer"			// user
				,"PASSWD"=>"123777"		// password
				)
				,"show_errors"=>true			// let class printout errors
				,"debug"=>false) ; 				// detailed debugging information
		return $connect;
				
	}
	function dummygo(){
		$connect = array("logindata"=>array(
				"ASHOST"=>"192.168.0.34"		// application server
				,"SYSNR"=>"20"				// system number
				,"CLIENT"=>"200"			// client
				,"USER"=>"developer"			// user
				,"PASSWD"=>"123777"		// password
				)
				,"show_errors"=>false			// let class printout errors
				,"debug"=>false) ; 				// detailed debugging information
		return $connect;
				
	}
	function dummylive(){
		$connect = array("logindata"=>array(
				"ASHOST"=>"192.168.0.62"		// application server
				,"SYSNR"=>"30"				// system number
				,"CLIENT"=>"300"			// client
				,"USER"=>"MM01"			// user
				,"PASSWD"=>"testing909"		// password
				)
				,"show_errors"=>false			// let class printout errors
				,"debug"=>false) ; 				// detailed debugging information
		return $connect;
				
	}
	function live(){
	   $connect = array("logindata"=>array(
            "ASHOST"=>"192.168.0.62"		// application server
            ,"SYSNR"=>"30"				// system number
            ,"CLIENT"=>"312"			// client
            ,"USER"=>"interface"			// user
            ,"PASSWD"=>"vivere1012"		// password
            )
            ,"show_errors"=>false			// let class printout errors
            ,"debug"=>false) ; 				// detailed debugging information
		return $connect;
	}
}
?>