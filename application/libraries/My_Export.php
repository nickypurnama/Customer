<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class My_Export {

//	function export_harian($title=FALSE,$hdr=FALSE,$content=FALSE,$getdate=FALSE){
//		$this->CI =& get_instance();
//		$absendb=$this->CI->db();
//		//global $absendb;
//		$today=($getdate)?$getdate:date("Y-m-d");
//
//		$countfield=$absendb->num_fields($content);
//		
//		$tothdr=count($hdr);
//		$table='<div align="center"><h3>'.$title.'</h3></div>
//				<table cellspacing="0" cellpadding="0" border="1">
//				<tr><thead>';
//		for($i=0; $i<$tothdr; $i++):
//			$table .='<th>'.$hdr[$i].'</th>';
//		endfor;	
//		$table .='</thead></tr>
//				<tbody>';
//		
//		
////echo "<pre>"; print_r($content); echo "</pre>"; 
//		$no=1;
//		while($data = $absendb->fetch_array($content)):
//			$table .='<tr><td>'.$no.'</td>';
//				for($x=0; $x<$countfield; $x++):
//					$table .='<td>'.$data[$x].'</td>';
//				endfor;
//			$table .='<td>'.trim($this->hitung_telat("08:30:00",$data['jamin'].":00")).'</td></tr>';
//			$no++;
//		endwhile;
//		$table .='</tbody></table>';
//		//echo $table;
//		return $table;
//		
//	}
//	function export_bulanan($title=FALSE,$hdr=FALSE,$content=FALSE){
//		global $absendb;
//		$today=($getdate)?$getdate:date("Y-m-d");
//
//		$countfield=$absendb->num_fields($content);
//		
//		$tothdr=count($hdr);
//		$table='<div align="center"><h3>'.$title.'</h3></div>
//				<table cellspacing="0" cellpadding="0" border="1">
//				<tr><thead>';
//		for($i=0; $i<$tothdr; $i++):
//			$table .='<th>'.$hdr[$i].'</th>';
//		endfor;	
//		$table .='</thead></tr>
//				<tbody>';
//		
//		
////echo "<pre>"; print_r($content); echo "</pre>"; 
//		$no=1;
//		while($data = $absendb->fetch_array($content)):
//			$table .='<tr><td>'.$no.'</td>';
//				for($x=0; $x<$countfield; $x++):
//					$table .='<td>'.$data[$x].'</td>';
//				endfor;
//			//$table .='<td>'.trim($this->hitung_telat("08:30:00",$data['jamin'].":00")).'</td></tr>';
//			$no++;
//		endwhile;
//		$table .='</tbody></table>';
//		//echo $table;
//		return $table;
//		
//	}
	  
} 
?>