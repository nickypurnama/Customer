<script type="text/javascript">

</script>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="<?php echo site_url('home/index'); ?>" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
        <a  href="#">Customer Request</a>
	<a class="current" href="#">List Contact Person</a>
    </div>
  </div>
  
  <div class="container-fluid">
    <div class="row-fluid">
    <div class="span12">
        
        <?php
            $msg=$this->session->flashdata('msg');
            echo $msg;
	?>
    </div>
    </div>
   <div class="row-fluid">
    <div class="span12">
	
        <a href="<?php $url = "customer/form_new_cp/".$kunnr; echo site_url($url); ?>"><input type="button"  value="Add New Contact Person" class="btn btn-info"></a>
    </div>
    </div>
   
    <div class="row-fluid">
    <div class="span12">
	<div class="widget-box " >
	    <div class="widget-content nopadding">
	      <table  class="table table-bordered data-table">
		<thead>
		  <tr>
                      <th style="width:4%;">No.</th>
		      <th >ID CP</th>
                      <th >Title</th>
                      <th >Firstname</th>
		      <th >Lastname</th>
                      <th >Gender</th>
                      <th >Telephone</th>
                      <th >Action</th>
		  </tr>
		</thead>
		<tbody>
		    <?php
                        $no=1;
			foreach($knvk as $a){
                            
                            $kunnr=$a['KUNNR'];
                            $parnr=$a['PARNR'];
                            $gender=$a['PARGE'];
                            $tlp=$a['TELF1'];
                            $firsname=$a['NAMEV'];
                            $lastname=$a['NAME1'];
                            $title=$a['ANRED'];
                            $urlDetail=base_url()."index.php/customer/form_edit_contact/".$kunnr."/".$parnr;
			    if($gender == '1'){
			      $sgender = "Male";
			    }elseif($gender == '2'){
			      $sgender = "Female";
			    }else{
			      $sgender = "";
			    }
                            echo "<tr>
                                <td>$no</td>
                                <td>$parnr</td>";
                            
                            echo "<td>$title</td>";
                            echo "<td>$firsname</td>";
                            echo "<td>$lastname</td>";
                            echo "<td>$sgender</td>";
                            echo "<td>$tlp</td>";
                             echo "<td style='text-align:center;'><a href='".$urlDetail."' class='btn btn-mini btn-success'>Edit</a></td>";
                            echo "</tr>";
                            $no++;
                        }
		    ?>
		    
		</tbody>
	      </table>
	    </div>
	  </div>
            
	                            
    </div>
    </div>
  </div>
</div>
