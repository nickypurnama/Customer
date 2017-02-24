<script type="text/javascript">

</script>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="<?php echo site_url('home/index'); ?>" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
        <a  href="#">Customer</a>
	<a class="current" href="#">List Customer Edit Request</a>
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
                      <th style="width:4%;">No.</th>
		      <th style="width:7%;">Date</th>
		      <th style="width:8%;">Requestor</th>
		      <th style="width:5%;">ID Request</th>
                      <th style="width:5%;">Cust. Account</th>
		      <th style="width:5%;">Company Code</th>
                      <th style="width:5%;">Title</th>
		      <th >Name</th>
		      <th style="width:10%;">City</th>
		      
                      <th style="width:9%;">Status</th>
                      <th style="width:17%;">Action</th>
		  </tr>
		</thead>
		<tbody>
		    <?php
			$no=1;
			foreach($row as $a){
			    $urlView=base_url()."index.php/customer/view_cust_edit/".$a['ID_EDIT'];
			    $urlApp=base_url()."index.php/customer/form_approval_edit/".$a['ID_EDIT'];
			    $urlEditApp=base_url()."index.php/customer/form_edit_approval_edit/".$a['ID_EDIT'];
			    $id_edit=$a['ID_EDIT'];
			    echo "
				<tr>
				    <td>$no</td>
				    <td>".$a['TGL']."</td>
				     <td>".$a['NAME_CREATE']."</td>
				     <td>".$a['ID_EDIT']."</td>
				    <td>".$a['CUST_ACCOUNT']."</td>
				    <td>".$a['COMPANY_CODE']."</td>
				    <td>".$a['TITLE_CP']."</td>
				    <td>".$a['NAME1']."</td>
				    <td>".$a['CITY']."</td>
				     
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
