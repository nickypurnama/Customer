<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class My_AdminLibrary {
var $ci;
	
	public function __construct() {
	//utk constructor ci library
		$this->ci = &get_instance();
	}
	
	public function upload_img($inputname=FALSE, $filename=FALSE,$abspath=FALSE,$allowed=FALSE,$width=0,$height=0,$pict_type=0,$thumb_width=0,$thumb_height=0){
		
		
		$fileNameParts   = explode( '.', $filename ); // explode file name to two part
		$fileExtension   = end( $fileNameParts ); // give extension
		$fileExtension   = strtolower($fileExtension); // convert to lower case
		list($usec, $sec) = explode(" ", microtime());
		$time_start = (float)$usec + (float)$sec;	
		$microname 	= str_replace(".", "",time()+$time_start);
		$renamed 	= $microname.'.'.$fileExtension;
		
		$pic_name=""; $thumb_name="";

		$config = array(  'file_name' => $filename, 
						  'orig_name' => $filename, 
						  'upload_path' => './images/'.$abspath, 
						  'allowed_types' => $allowed,
						  'overwrite' => TRUE,
						  'remove_spaces' => TRUE,
						  'max_size' => '2000');
		$this->ci->load->library('upload', $config);

		$img_data = $this->ci->upload->data();
		//print_r($img_data)."<br>";
		//list($widtH, $heighT, $type, $attr) = getimagesize(FCPATH.'images/'.$abspath.$img_data['raw_name']);
		//echo $widtH; exit;
		if(!$this->ci->upload->do_upload($inputname)){
			
			$file_upload =  $img_data['full_path'];		
			echo "<pre>".print_r($img_data)."</pre><br>";
			echo $file_upload."<br>";
			$msg = array('error' => $this->ci->upload->display_errors());
			echo $msg['error'];
			exit;
			
		}else{ $msg = array('error' => false);	}
			//list($width, $height, $type, $attr) = getimagesize($img_data['full_path']);  // get original width & height
			//Create Original Pict
			if($pict_type=='1'):
				$this->ci->load->library('image_lib');
				
				$confpict = array( 'image_library' 	=> 'gd2',
								   'source_image' 	=> $img_data['full_path'],
								   'new_image'	 	=> $img_data['file_path'].$renamed,
								   'maintain_ratio' => TRUE,
								   'overwrite' 		=> TRUE,
								   'width' 			=> ($width)?$width:'800',
								   'height'			=> ($height)?$height:'600'
								 );
				$this->ci->image_lib->clear();				 
				$this->ci->image_lib->initialize($confpict);	
				
				if ( ! $this->ci->image_lib->resize())
				{
					$this->ci->image_lib->display_errors('<p>', '</p>');
					exit;
				}
				
				$pic_name   = $abspath.$microname.'.'.$fileExtension; 
			endif;
		
			//Create Thumbnail Pict
			if($pict_type=='2'):
			
				$this->ci->load->library('image_lib');
				
				$confthumb['image_library'] = 'gd2';
				$confthumb['source_image'] 	= $img_data['full_path'];
				$confthumb['new_image']		= $img_data['file_path'].$renamed;
				$confthumb['maintain_ratio'] = TRUE;
				$confthumb['create_thumb'] 	= TRUE;
				$confthumb['thumb_marker'] 	= '_thumb';
				$confthumb['width'] 		= ($thumb_width)?$thumb_width:150;
				$confthumb['height'] 		= ($thumb_height)?$thumb_height:100;	//$thumb_height;
								
				$this->ci->image_lib->clear();
				$this->ci->image_lib->initialize($confthumb);	
			//$this->ci->load->library('image_lib',$confthumb);
				
				if ( ! $this->ci->image_lib->resize())
				{
					$this->ci->image_lib->display_errors('<p>', '</p>');
					exit;
				}
				
				$thumb_name   = $abspath.$microname.'_thumb.'.$fileExtension; 
			endif;
			
			// Create Thumb & Picture
			if($pict_type=='3'):
				$this->ci->load->library('image_lib');
				
				//Create Big Pict
				$confpict = array( 'image_library' 	=> 'gd2',
								   'source_image' 	=> $img_data['full_path'],
								   'new_image'	 	=> $img_data['file_path'].$renamed,
								   'maintain_ratio' => TRUE,
								   'overwrite' 		=> TRUE,
								   'width' 			=> ($width)?$width:'800',
								   'height'			=> ($height)?$height:'600'
								 );
							 
				$this->ci->image_lib->initialize($confpict);	
				
				if ( ! $this->ci->image_lib->resize())
				{
					$this->ci->image_lib->display_errors('<p>', '</p>');
					exit;
				}
				
				$confthumb = array( 'image_library' 	=> 'gd2',
								    'source_image' 	=> $img_data['full_path'],
								    'new_image'	 	=> $img_data['file_path'].$renamed,
								    'maintain_ratio' => TRUE,
								    'create_thumb'	=> TRUE,
								    'thumb_marker'	=> '_thumb',
								    'width' 			=> ($thumb_width)?$thumb_width:'150',
								    'height'			=> ($thumb_height)?$thumb_height:'100'
								 );
								
				$this->ci->image_lib->clear();
				$this->ci->image_lib->initialize($confthumb);	
			//$this->ci->load->library('image_lib',$confthumb);
				
				if ( ! $this->ci->image_lib->resize())
				{
					$this->ci->image_lib->display_errors('<p>', '</p>');
					exit;
				}
				
				$thumb_name   = $abspath.$microname.'_thumb.'.$fileExtension; 				
				$pic_name   = $abspath.$microname.'.'.$fileExtension; 
			endif;
		@unlink($img_data['full_path']);					
		//print_r($img_data);	
		unset($config);
			
	
		return array($thumb_name,$pic_name);
	}
	
	public function image_thumb( $thumbsrc=false, $srcpath=FALSE, $abspath=false, $width=0, $height=0,$flag=0 ) { // $thumb_path=false,
    // Get the CodeIgniter super object				
				$this->ci->image_lib->clear();
   				$config['image_library'] = 'gd2';
				$config['source_image'] = $srcpath.$thumbsrc;
				$confpict['new_image'] 	= $this->ci->upload->upload_path;		
				$confpict['create_thumb'] = ($flag>0)?TRUE:FALSE;	
				//$config2['thumb_marker'] = '_thumb';
				$config['maintain_ratio'] = TRUE;	
				$config['width'] = $width;
				$config['height'] = $height;			
				
				//
				$this->ci->image_lib->initialize($config);			
				$this->ci->image_lib->resize();				
	
				if ( ! $this->ci->image_lib->resize())
				{
					$this->ci->image_lib->display_errors('<p>', '</p>');
					exit;
				}
				
				$thumb_expl   = explode( '.', $thumbsrc ); 
				
				$thumb_name = $abspath.$thumb_expl[0].'_thumb'.'.'.$thumb_expl[1];

		return $thumb_name;
	}
	
	public function upload_file($filename=FALSE,$abspath=FALSE,$allowed=FALSE,$maxsize=0){
		$fileNameParts   = explode( '.', $filename ); // explode file name to two part
		$fileExtension   = end( $fileNameParts ); // give extension
		$fileExtension   = strtolower($fileExtension); // convert to lower case
		//date("Y-m-d H:i:s", mktime(0, 0, 0));
		$srcfile_name   = strtotime(date("Y-m-d H:i:s"),time()).'.'.$fileExtension;  // new file name
		
		$config['file_name'] = $srcfile_name; //set file name		
		$config['upload_path'] = './'.$abspath;
		$config['allowed_types'] = $allowed;  	//$config['allowed_types'] = '*';
		$config['overwrite'] = false;
		$config['remove_spaces'] = true;
		$config['max_size'] = $maxsize;

					 
		$this->ci->load->library('upload', $config);
		$this->ci->upload->initialize($config);
		$src_data = $this->ci->upload->data();
		if(!$this->ci->upload->do_upload('f_file')){
			
			$file_upload =  $src_data['full_path'];		
			//echo $file_upload;	exit;			
			$msg = array('error' => $this->ci->upload->display_errors());
			echo $msg['error'];
			exit;
			
		}else{ $msg = array('error' => false); }
		
		unset($config);
		//exit;
		return $srcfile_name;
	}
	
	public function cmbSet($data=false,$select=FALSE){
			$pool = array();
			foreach ($data as $dt_tree):
				$p_id = $dt_tree['KAT_PID']; 
				$pool[$p_id][] = $dt_tree; 	  
			endforeach;
        //echo '<pre>';	print_r($data);	 echo '</pre>'; exit;			
		$result=$this->cmbVal($pool,0,0,$select);
		return $result;
	}
	
	public function cmbVal($data,$pid=0,$level=0,$select=FALSE) {
	   $str=""; $haschild="";
  		//echo '<pre>';	print_r($data);	 echo '</pre>'; exit;//echo $pid." "; print_r($data[$pid]); echo "<br>";
	   if(isset($data[$pid])){ 	
	   	     
			for($i=0;$i<($level);$i++ ) {
				$haschild .='&nbsp;';	
	   		}	
			foreach($data[$pid] as $val){ 
			  $selected=($val['KAT_ID']==$select)?'selected':"";
			  $child = $this->cmbVal($data,$val['KAT_ID'],$val['KAT_ID'],$select);
			  $str .= '<option value="' . $val['KAT_ID'] . '" '.$selected.'>'.$haschild.trim($val['KAT_NAME']).'</option>';			  				  
			  $str .= trim($child);				 
			}
			return $str;
		}
	}

	public function build_menu($data=array(),$parent=0){ 
		  $str="";
		  //$rev = array(); echo '<pre>'; print_r(usort($data,$rev)); echo '</pre>';
		  if(isset($data[$parent])): 	
			
			foreach($data[$parent] as $val):
				$link_url = ($val['CTRL'])?site_url($val['CTRL']):"#";
		  	  	$str .= '<li><a href="'.$link_url.'">'.$val['NAMA_MENU'].'</a>';
				$child = $this->build_child($data,$val['MID']);			  	
				if($child) $str .= '<ul>'.$child.'</ul>';
				$str .= '</li>';	  
			endforeach;
							
			return $str;
		  else: 
		  	return false;	  
		  endif;
	}	
	
	public function build_child($data,$parent){
		$str="";  
		if(isset($data[$parent])):
			foreach($data[$parent] as $val):
			 $link_url = ($val['CTRL'])?site_url($val['CTRL']):"#";
			//echo " curl: ".current_url()." db: ".site_url($val['controller']).'<br>';			
			  $str .= '<li><a href="'.$link_url.'">'.trim($val['NAMA_MENU']).'</a></li>';
			
			endforeach;
			return $str;	
		else: 
		  	return false;	  
		 endif;
		
	}
	
	public function scale_img($var=false,$scale=0){
		list($width, $height, $type, $attr) = getimagesize(FCPATH.$var);  // get original width & height
			 //$width = $this->getWidth() * $scale/100; $height = $this->getheight() * $scale/100; 
			$newwidth =  $width * ($scale/100) ;
			
			$newheight = $height * ($scale/100);
		
		return array('w'=>round($newwidth,0), 'h'=>round($newheight,0));
	}
	
	public function file_del($filenpath=FALSE){
		@unlink($filenpath);
		//exit;
		return 1;
	}
	
	public function CleanLogin($var=FALSE){
		$Ilegal=array("'",'/',';','*','%','#','(',')','+','=');
		
		return stripslashes(strip_tags(str_replace($Ilegal,"",$var)));
	}
	public function gen_URL($var=FALSE){
		//First Ilegal Filter
		$firstFilter = array(",","&","'",'/',';','*','%','#','(',')','+','=','-');
		$charClean=str_replace($firstFilter," ",$var);
		//Second Filter - Compile it
		$midClean  = str_replace(array('  ','   ','    '), " ", trim($charClean));
		
		$endClean  = str_replace(' ', "-", $midClean);
		//Cut string only 10 words
		//$cutString = $this->strcut($endClean,10);
		
		$genResult = strtolower($endClean);
		//implode(',', $key)
		return $genResult;
	}
	public function genURL($var=FALSE){
		//First Ilegal Filter
		$firstFilter = array(",","&","'",'/',';','*','%','#','(',')','+','=');
		$charClean=stripslashes(strip_tags(str_replace($firstFilter," ",$var)));
		//Second Filter - Compile it
		$midClean  = str_replace(array(' ','   ','    '), " ", $charClean);
		
		$endClean  = str_replace(array('--','---'), "-", $midClean);
		//Cut string only 10 words
		$cutString = $this->strcut($endClean,10);
		
		$genResult = strtolower(str_replace(" ",'-',$cutString));
		
		return $genResult;
	}
	
	
	public function alldate($date=FALSE)
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
	
	public function splitdate($date=FALSE)
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
	    public function stringToUnixTime($var=FALSE)
    {
        $date = strtok($var, " ");
        $time = strtok(" ");
     
        // These are the actual codes for the PHP date format
        $d /* day     */ = strtok($date, "/");
        $m /* month   */ = strtok("/");
        $Y /* year    */ = strtok("/");
     
        $s /* seconds */ = strtok($time, "-");
        $i /* minutes */ = strtok("-");
        $h /* hours   */ = strtok("-");
       
        return mktime($h, $i, $s, $m, $d, $Y);
    } 


	public function strCODErep($var=FALSE){
		$search = array("'","&nbsp;");
		$replace = array("`"," ");
		return str_replace($search, $replace,$var);
	}
	
	public function strTags($var=FALSE) {
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
	
    public function conv($var=FALSE) {
		
		return isset($var) ? trim(stripslashes(htmlspecialchars($this->strCODErep($var)))) : "";
	}
	
	public function deconv($var){
		$result=str_replace(Chr(13), "",html_entity_decode($var));
		return $result;
	}
	
	public function strcut($var=FALSE, $len=FALSE) {
		$countvar=substr_count($this->decodeAndStripHTML($var), " "); 
		$leng=($countvar<$len)?$countvar:$len;
		$strx=$this->decodeAndStripHTML($var);
		$string=explode(" ", $strx);
		$str="";
		for($i=0; $i<=$leng; $i++):
			if($i == $leng):
				$str .= $string[$i]; //end of $var
			else:
				$str .= $string[$i]." ";
			endif;
		endfor;
		return ucwords($str); //$leng ." ..."
	}
	public function decodeAndStripHTML($string=FALSE){ 
   	 return strip_tags(htmlspecialchars_decode($string)); 
	}
	
	
    /******************************************************************************************************************************************************/
    public function datetime($var=FALSE)
    {
        return date("F, d Y H:i:s", strtotime($var));
    }
	public function dateformat($var=FALSE)
    {
        return date("d F Y", strtotime($var));
    }
	
		
	public function shortmonth($bulan=FALSE,$lang=FALSE){
		if($lang=='in'):
		 $bln = array ("13"=>'',"01"=>'Jan',"02"=>'Feb',"03"=>'Mar',"04"=>'Apr',"05"=>'Mei',"06"=>'Jun',"07"=>'Jul',"08"=>'Agu',"09"=>'Sep',"10"=>'Oktober',"11"=>'Nov',"12"=>'Des');
		 elseif($lang=='en'):
		  $bln = array ("1"=>'JAN',"2"=>'FEB',"3"=>'MAR',"4"=>'APR',"5"=>'MAY',"06"=>'JUN',"7"=>'JUL',"8"=>'AUG',"9"=>'SEP',"10"=>'OCT',"11"=>'NOV',"12"=>'DES');
		 endif;
		 
		return $bln[$bulan];
	}
	// ***************************************************************************/
	
 	public function engdate($date=FALSE)
		{
			$temp = explode('-', $date);
			if (!checkdate($temp[1], $temp[2], $temp[0])):
				echo '-';
			else:
				echo date("F d, Y", strtotime($date));
			endif;
		}
		
	
	public function inadate($date=FALSE)
		{
			$bln = array ("13"=>'',"01"=>'Januari',"02"=>'Februari',"03"=>'Maret',"04"=>'April',"05"=>'Mei',"06"=>'Juni',"07"=>'Juli',"08"=>'Agustus',"09"=>'September',"10"=>'Oktober',"11"=>'November',"12"=>'Desember');
			//$temp = explode('-', $date);
//			echo $tgl."-".$bln[$bulan]."-".$yr;
				$bulan = date("m",strtotime($date));
				$tgl = date("d",strtotime($date));
				$yr = date("Y",strtotime($date));
				return $tgl." ".$bln[$bulan]." ".$yr;
			
			
		 }
	
	public function convdate($date=FALSE)
    {  	 $arrcek=str_replace('/','-',$date);    
		 $tempfirst = explode('-', $arrcek);
  
		 return $tempfirst[2]."-".$tempfirst[0]."-".$tempfirst[1];
    }	
	public function gettime($date=FALSE)
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
	
	
	 
	public function oci_date($var=FALSE,$to=FALSE){
		if($to=='in'):
			$bulan = array ('JAN'=>'01','FEB'=>'02','MAR'=>'3','APR'=>'04','MAY'=>'05','JUN'=>'06','JUL'=>'07','AUG'=>'08','SEP'=>'09','OCT'=>'10','NOV'=>'11','DEC'=>'12');
        elseif($to=='out'):
			$bulan = array ("1"=>'JAN',"2"=>'FEB',"3"=>'MAR',"4"=>'APR',"5"=>'MAY',"6"=>'JUN',"7"=>'JUL',"8"=>'AUG',"9"=>'SEP',
							"01"=>'JAN',"02"=>'FEB',"03"=>'MAR',"04"=>'APR',"05"=>'MAY',"06"=>'JUN',"07"=>'JUL',"08"=>'AUG',"09"=>'SEP',"10"=>'OCT',"11"=>'NOV',"12"=>'DES');
		endif;
		//print_r($bln); $split[0].'-'
		
		$split = explode('-', $var);
		
		//echo $split[0].'-'.$split[1].'-'.$split[2];
		$tgl = date("d",strtotime($split[0]));
		$bln = date("m",strtotime($split[1]));         
		$yr = $split[2];
	
	   return trim($split[0]."-".$bulan[$split[1]]."-".$yr);
	}
	
	public function indodate($date=FALSE)
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
	
    public function stddate($date=FALSE)
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
	
	public function clearData($str=FALSE) { // escape tab characters 
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