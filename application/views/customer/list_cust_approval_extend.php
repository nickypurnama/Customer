<script type="text/javascript">

</script>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="<?php echo site_url('home/index'); ?>" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
        <a  href="#">Customer</a>
	<a class="current" href="#">List Customer Request Extend</a>
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
   
    <br/>
    <div class="row-fluid">
    <div class="span12">
	<div class="widget-box " style="margin-top: -30px;">
	    <div class="widget-content nopadding">
	      <table  class="table table-bordered data-table">
		<thead>
		  <tr>
			<th style="width:3%;">No.</th>
			<th style="width:5%;">Date</th>
			<th style="width:8%;">Requestor</th>
			<th style="width:3%;">ID Request</th>
                        <th style="width:10%;">Subject</th>
                        <th style="width:5%;">Cust. Account</th>
                        <th style="width:5%;">Company Code</th>
			<th style="width:5%;">Company Name</th>
                        <th style="width:5%;">Sales Org.</th>
                        <th style="width:5%;">Dis. Channel</th>
                        <th style="width:5%;">Division</th>
                        <th style="width:10%;">Status</th>
                        <th style="width:16%;">Action</th>
		  </tr>
		</thead>
		<tbody>
		    <?php
			$no=1;
			//print_r($row);
			foreach($row as $a){
                            $id_ex=$a['ID_EX'];
			    $urlView=base_url()."index.php/customer/view_extend/".$id_ex;
			    $urlApp=base_url()."index.php/customer/form_approval_extend/".$id_ex;
			    $urlEditApp=base_url()."index.php/customer/form_edit_approval_extend/".$id_ex;
			    
			    $sales_org=$a['SALES_ORG2'];
			    
			    if($sales_org == "1000"){
				$cname="GGS";
			    }elseif($sales_org == "2000"){
				$cname="VMK";
			    }elseif($sales_org == "3000"){
				$cname="LKS";
			    }elseif($sales_org == "4000"){
				$cname="PGM";
			    }elseif($sales_org == "5000"){
				$cname="VGS";
			    }elseif($sales_org == "6000"){
				$cname="VIS";
			    }
			    echo "
				<tr>
				   <td>$no</td>
				   <td>".$a['DATE_CREATE']."</td>
				   <td>".$a['NAME_CREATE']."</td>
				    <td>".$a['ID_EX']."</td>
				    <td>".$a['SUBJECT']."</td>
				    <td>".$a['CUST_ACCOUNT']."</td>
				    <td>".$a['COMPANY2']."</td>
				    <td>".$cname."</td>
				    <td>".$a['SALES_ORG2']."</td>
				    <td>".$a['DIS_CHANNEL2']."</td>
				    <td>".$a['DIVISION2']."</td>
				    <td>".$a['NEW_ST']."</td>";
			    echo "<td style='text-align: center;'>";    
                            if($a['ST_SEND'] == '1'){
                                echo "<a class='btn btn-info btn-mini' href='".$urlView."'>&nbsp;  View  &nbsp;</a>
                                    <a class='btn btn-success btn-mini' href='".$urlApp."'>Approval</a>
					";
                            }elseif($a['ST_SEND'] == '2'){
                                echo "<a class='btn btn-info btn-mini' href='".$urlView."'>&nbsp;  View  &nbsp;</a>
                                    <a class='btn btn-warning btn-mini' href='".$urlEditApp."'>&nbsp; &nbsp; Edit &nbsp; &nbsp;</a>
					";
                            }
                        
			    
			     echo "</td>"; 
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
