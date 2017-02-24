<script type="text/javascript">

function posting(id){
	//alert(id);
    jConfirm("Posting Approval? <br/>Note : Can't Edit/Delete after posting.", "VI|VE|RE GROUP", function(r) {
	if(r == true){
	    $.ajax({
		type: 'POST', 
		url: "<?php echo site_url('customer/approval_acc'); ?>",
		data: "id="+id,
		cache: false,
		success: function(msg){
		    document.location='<?php echo site_url('customer/list_cust_req'); ?>';
		}
	    });	
	}
    });

}
function unposting(id){
	//alert(id);
    jConfirm("Do you want unposting request?", "VI|VE|RE GROUP", function(r) {
	if(r == true){
	    $.ajax({
		type: 'POST', 
		url: "<?php echo site_url('customer/unposting_cust'); ?>",
		data: "id="+id,
		cache: false,
		success: function(msg){
		    document.location='<?php echo site_url('customer/list_cust_req'); ?>';
		}
	    });	
	}
    });

}
function hapus(id){
	//alert(id);
    jConfirm("Delete Customer Request? ", "VI|VE|RE GROUP", function(r) {
	if(r == true){
	    $.ajax({
		type: 'POST', 
		url: "<?php echo site_url('customer/del_cust'); ?>",
		data: "id="+id,
		cache: false,
		success: function(msg){
		    document.location='<?php echo site_url('customer/list_cust_req'); ?>';
		}
	    });	
	}
    });

}
</script>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="<?php echo site_url('home/index'); ?>" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
        <a  href="#">Approval</a>
	<a class="current" href="#">List Customer Request</a>
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
			    $urlView=base_url()."index.php/customer/view_cust/".$a['ID_CUST'];
			    $urlTransport=base_url()."index.php/customer/form_transport/".$a['ID_CUST'];
			    $urlEdit=base_url()."index.php/customer/form_edit_cust/".$a['ID_CUST'];
			    $id_cust=$a['ID_CUST'];
			    echo "
				<tr>
				    <td>$no</td>
				    
				     <td>".$a['TGL']."</td>
				      <td>".$a['NAME_CREATE']."</td>
				      <td>".$a['ID_CUST']."</td>
				    <td>".$a['CUST_ACCOUNT']."</td>
				    <td>".$a['COMPANY_CODE']."</td>
				    <td>".$a['TITLE_CP']."</td>
				    <td>".$a['NAME1']."</td>
				    <td>".$a['CITY']."</td>
				  
				    <td>".$a['NEW_ST']."</td>";
			    echo "<td style='text-align: center;'>";    
			    if($a['ST_SEND'] == 2){
				echo "<a class='btn btn-info btn-mini' href='".$urlView."'>&nbsp; View &nbsp;</a>
				    <a class='btn btn-warning btn-mini' href='".$urlEdit."'>&nbsp; Edit &nbsp;</a>
					<a class='btn btn-success btn-mini' href='".$urlTransport."'>Transport</a>";
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
