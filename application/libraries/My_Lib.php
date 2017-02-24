<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class My_Lib {
	
	function alldate($date=FALSE)
    {
        $bln = array ("13"=>'',"01"=>'January',"02"=>'February',"03"=>'March',"04"=>'April',"05"=>'May',"06"=>'June',"07"=>'July',"08"=>'August',"09"=>'September',"10"=>'October',"11"=>'November',"12"=>'December');
        //print_r($bln);
		$tempfirst = explode(' ', $date);
		
        $getdate = explode('-', $tempfirst[0]);
		$gettime= explode(':', $tempfirst[1]);
		
	        $bulan = date("m",strtotime($date));         
            $tgl = date("d",strtotime($date));
            $yr = date("Y",strtotime($date));
		$hour=$gettime[0]; $minute=$gettime[1];
           return $tgl." ".$bln[$bulan]." ".$yr.", ".$hour.":".$minute;
        
    }
	
	function splitdate($date=FALSE)
    {
        $bln = array ("13"=>'',"01"=>'Jan',"02"=>'Feb',"03"=>'Mar',"04"=>'Apr',"05"=>'May',"06"=>'Jun',"07"=>'Jul',"08"=>'Aug',"09"=>'Sep',"10"=>'Oct',"11"=>'Nov',"12"=>'Dec');
        //print_r($bln);
		$tempfirst = explode(' ', $date);
		
        $getdate = explode('-', $tempfirst[0]);
		$gettime= explode(':', $tempfirst[1]);
		
	        $bulan = date("m",strtotime($date));         
            $tgl = date("d",strtotime($date));
            $yr = date("Y",strtotime($date));
		$hour=$gettime[0]; $minute=$gettime[1];
         return array("tgl"=>$tgl,"bln"=>$bln[$bulan],"m"=>$bulan,"thn"=>$yr,"jam"=>$hour,"menit"=>$minute);
        
    }
	
	function strCODErep($var=FALSE){
		$strRep=array("'");
		return str_replace($strRep,"`",$var);
	}
	
	function strTags($var=FALSE) {
			$var=preg_replace ('/<[^>]*>/', '', $var);		
			//$count=strlen($var);
			//$strx=decodeAndStripHTML($var);
			$string=explode(" ", trim($var));
			$strx="";
			while (list(,$v) = each($string)):
				$strx .= preg_replace('/\s*/m', '',$v)." ";
			endwhile;
			
			return $strx;
	}
	
    function conv($var=FALSE) {
		
		return isset($var) ? htmlspecialchars(stripslashes(trim($this->strURLrep($this->strCODErep($var))))) : "";
	}
	
	function deconv($var){
		$result=str_replace(Chr(13), "",html_entity_decode($var));
		return $result;
	}
	
	function strcut ($var=FALSE, $len=FALSE) {
		$countvar=substr_count($this->decodeAndStripHTML($var), " "); 
		$leng=($countvar<$len)?$countvar:$len;
		$strx=$this->decodeAndStripHTML($var);
		$string=explode(" ", $strx);
		$str="";
		for($i=0; $i<=$leng; $i++):
			$str .= $string[$i]." ";
		endfor;
		return ucwords($str)."$countvar - $leng ...";
	}
	function decodeAndStripHTML($string=FALSE){ 
   	 return strip_tags(htmlspecialchars_decode($string)); 
	}
	
	
    /******************************************************************************************************************************************************/
    function outerdate($datetime=FALSE)
    {
        return date("F, d Y H:i:s", strtotime($datetime));
    }

	function listdate($date=FALSE)
    {
        $bln = array ("13"=>'',"01"=>'Jan',"02"=>'Feb',"03"=>'Mar',"04"=>'Apr',"05"=>'Mei',"06"=>'Jun',"07"=>'Jul',"08"=>'Agu',"09"=>'Sep',"10"=>'Okt',"11"=>'Nov',"12"=>'Des');
        //print_r($bln);
		$tempfirst = explode(' ', $date);
		
        $getdate = explode('-', $tempfirst[0]);
		$gettime= explode(':', $tempfirst[1]);
		
	        $bulan = date("m",strtotime($date));         
            $tgl = date("d",strtotime($date));
            $yr = date("Y",strtotime($date));
		$hour=$gettime[0]; $minute=$gettime[1];
		//$tgl." ".$bln[$bulan]." ".$yr.", ".$hour.":".$minute;
           return array('tgl'=>$tgl,'bulan'=>$bln[$bulan],'tahun'=>$yr,'jam'=>$hour, 'menit'=>$minute);
        
    }
	
	function getbln($bulan=FALSE){
		 $bln = array ("13"=>'',"01"=>'Jan',"02"=>'Feb',"03"=>'Mar',"04"=>'Apr',"05"=>'Mei',"06"=>'Jun',"07"=>'Jul',"08"=>'Agu',"09"=>'Sep',"10"=>'Oktober',"11"=>'Nov',"12"=>'Des');
		 
		return $bln[$bulan];
	}
	// ***************************************************************************/
	
 	function engdate($date=FALSE)
		{
			$temp = explode('-', $date);
			if (!checkdate($temp[1], $temp[2], $temp[0])):
				echo '-';
			else:
				echo date("F d, Y", strtotime($date));
			endif;
		}
	/*************************************************************hitung Absen keterlambatan**************************************************************/	
	function count_telat($var=false){
		$totaljam = (($var % 3600)>0)?round($var/3600):0;
		$totalmenit = round(($var % 3600)/60);
		$formatwaktu= $this->formatit($totaljam).":".$this->formatit($totalmenit);

		return $formatwaktu; 
	}
	function formatit($var=FALSE){
		$zeroit=(strlen($var)>1)?$var:"0".$var;
		return $zeroit;
	}
	
	function hitung_telat($shiftin=FALSE,$jamin=FALSE) { 
		list($h,$m,$s) = explode(":",$shiftin); 
		$dtAwal = mktime($h,$m,$s,"1","1","1"); 
		list($hh,$mm,$ss) = explode(":",$jamin); 		
		$dtAkhir = mktime($hh,$mm,$ss,"1","1","1"); 
		if($dtAkhir<=$dtAwal){ return ""; }
		$dtSelisih = $dtAkhir-$dtAwal;
		//echo $dtSelisih." = ".$dtAkhir ." ". $dtAwal."<br>";
		$totaljam = (($dtSelisih % 3600)>0)?round($dtSelisih/3600):0;
		
		$totalmenit = round(($dtSelisih % 3600)/60);
		$formatwaktu= $this->formatit($totaljam).":".$this->formatit($totalmenit);

		return $formatwaktu; 
	} 
	
	function inadate($date=FALSE)
		{
			$bln = array ("13"=>'',"01"=>'Januari',"02"=>'Februari',"03"=>'Maret',"04"=>'April',"05"=>'Mei',"06"=>'Juni',"07"=>'Juli',"08"=>'Agustus',"09"=>'September',"10"=>'Oktober',"11"=>'November',"12"=>'Desember');
			//$temp = explode('-', $date);
//			echo $tgl."-".$bln[$bulan]."-".$yr;
				$bulan = date("m",strtotime($date));
				$tgl = date("d",strtotime($date));
				$yr = date("Y",strtotime($date));
				return $tgl." ".$bln[$bulan]." ".$yr;
			
			
		 }
	
	function convdate($date=FALSE)
    {  	 $arrcek=str_replace('/','-',$date);    
		 $tempfirst = explode('-', $arrcek);
		 
            
		 return $tempfirst[2]."-".$tempfirst[0]."-".$tempfirst[1];
    }	
	function gettime($date=FALSE)
    {
       
		$tempfirst = explode(' ', $date);
		
        $getdate = explode('-', $tempfirst[0]);
		$gettime= explode(':', $tempfirst[1]);
		
	        $bulan = date("m",strtotime($date));         
            $tgl = date("d",strtotime($date));
            $yr = date("Y",strtotime($date));
			$hour=$gettime[0]; $minute=$gettime[1];
			//echo $tgl." ".$bln[$bulan]." ".$yr;
           return $hour.":".$minute.":"."00";
        
    }
	
	function getDateTime($date=false,$what=false)
    {
       
		if($what=='tgl'):
	        return date("d",strtotime($date));  
		elseif($what=='bln'):       
            return date("m",strtotime($date));
		elseif($what=='thn'):
            return date("Y",strtotime($date));	
		endif;	
		//$hour=$gettime[0]; $minute=$gettime[1];	//$tgl." ".$bln[$bulan]." ".$yr." ".
    }
	
	function namaBulan($var){
		$bln = array ("13"=>'',"01"=>'Januari',"02"=>'Februari',"03"=>'Maret',"04"=>'April',"05"=>'Mei',"06"=>'Juni',"07"=>'Juli',"08"=>'Agustus',"09"=>'September',"10"=>'Oktober',"11"=>'November',"12"=>'Desember');
		
		return $bln[$var];
	}
	 
	function indodate($date=FALSE)
    {
        $bulan = array ("13"=>'',"01"=>'Januari',"02"=>'Februari',"03"=>'Maret',"04"=>'April',"05"=>'Mei',"06"=>'Juni',"07"=>'Juli',"08"=>'Agustus',"09"=>'September',"10"=>'Oktober',"11"=>'November',"12"=>'Desember');
        //print_r($bln);
		$tempfirst = explode(' ', $date);
		
        $getdate = explode('-', $tempfirst[0]);
		
		
		$bln = date("m",strtotime($date));         
		$tgl = date("d",strtotime($date));
		$yr = date("Y",strtotime($date));
	
	   return $tgl." ".$bulan[$bln]." ".$yr;
	
    }
	
    function stddate($date=FALSE)
    {       
       // $temp = explode('-', $date);
		$bulan = date("m",strtotime($date));         
		$tgl = date("d",strtotime($date));
		$yr = date("Y",strtotime($date));
        if (!checkdate($bulan, $tgl, $yr)):
            return '-';
        else:
            return date("Y-m-d", strtotime($date));
        endif;
    }
	
	function clearData($str=FALSE) { // escape tab characters 
	$str = preg_replace("/\t/", "\\t", $str); 
	// escape new lines 
	$str = preg_replace("/\r?\n/", "\\n", $str); 
	// convert 't' and 'f' to boolean values 
	if($str == 't') $str = 'TRUE'; 
	if($str == 'f') $str = 'FALSE'; 
	// force certain number/date formats to be imported as strings 
	if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
		$str = "$str"; 
	} 
	// escape fields that include double quotes 
	//if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
	
		return $str;
	}
	  
} 
?>