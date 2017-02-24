<script type="text/javascript">

function posting(xid){
	//alert(id);
    jConfirm("Posting Transport? <br/>Note : Can't Edit/Delete after posting.", "VI|VE|RE GROUP", function(r) {
	if(r == true){
	    $("#spinner").show();
	    $.ajax({
		type: 'POST', 
		url: "<?php echo site_url('customer/posting_cp'); ?>",
		data: {
			id : xid
		},
		cache: false,
		success: function(msg){
		    document.location='<?php echo site_url('customer/list_cp_req'); ?>';
		}
	    });	
	}
    });

}
function unposting(id){
    jConfirm("Do you want unposting request?", "VI|VE|RE GROUP", function(r) {
	if(r == true){
	    $("#spinner").show();
	    $.ajax({
		type: 'POST', 
		url: "<?php echo site_url('customer/unposting_cp'); ?>",
		data: "id="+id,
		cache: false,
		success: function(msg){
		    document.location='<?php echo site_url('customer/list_cp_req'); ?>';
		}
	    });	
	}
    });

}

function hapus(id){
	//alert(id);
	
    jConfirm("Delete CP Request? ", "VI|VE|RE GROUP", function(r) {
	if(r == true){
	    $.ajax({
		type: 'POST', 
		url: "<?php echo site_url('customer/del_cp'); ?>",
		data: "id="+id,
		cache: false,
		success: function(msg){
		    document.location='<?php echo site_url('customer/list_cp_req'); ?>';
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
        <a  href="#">Customer</a>
	<a class="current" href="#">List Contact Person Request</a>
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
		      <th style="width:7%;">Date</th>
		      <th style="width:8%;">Requestor</th>
		      <th style="width:5%;">ID Request</th>
                      <th style="width:5%;">Type</th>
                      <th style="width:5%;">Cust. Account</th>
                      <th style="width:5%;">C.Person ID</th>
                      <th style="width:5%;">Title</th>
		      <th style="width:7%;">Firstname</th>
		      <th style="width:7%;">Lastname</th>
                      <th style="width:9%;">Status</th>
                      <th style="width:17%;">Action</th>
		  </tr>
		</thead>
		<tbody>
		    <?php
			$no=1;
			foreach($row as $a){
			    $urlView=base_url()."index.php/customer/view_cp/".$a['ID_CP_EDIT'];
			    $urlEdit=base_url()."index.php/customer/form_edit_cp_edit/".$a['ID_CP_EDIT'];
			    $id_req=$a['ID_CP_EDIT'];
			    
			    echo "
				<tr>
				    <td>$no</td>
				    <td>".$a['DATE_CREATE']."</td>
				     <td>".$a['NAME_CREATE']."</td>
				    <td>".$a['ID_CP_EDIT']."</td>
                                    <td>".$a['JENIS']."</td>
				    <td>".$a['KUNNR']."</td>
				    <td>".$a['PARNR']."</td>
				    <td>".$a['TITLE_CP']."</td>
				    <td>".$a['FIRSTNAME_CP']."</td>
				    <td>".$a['NAME_CP']."</td>
				    <td>".$a['NEW_ST']."</td>";
			    echo "<td style='text-align: center;'>";    
			    if($a['ST_SEND'] == 0){
				echo "<a class='btn btn-info btn-mini' href='".$urlView."'>View</a>
					<a class='btn btn-warning btn-mini' href='".$urlEdit."'>Edit</a>
					<a class='btn btn-danger btn-mini' href='javascript:hapus(\"$id_req\");'>Delete</a>
					<a class='btn btn-success btn-mini' href='javascript:posting(\"$id_req\");'>&nbsp;Posting&nbsp; &nbsp;</a>";
			    }elseif($a['ST_SEND'] == 1){
				echo "<a class='btn btn-info btn-mini' href='".$urlView."'>View</a>
					<button class='btn btn-mini'>Edit</button>
					<button class='btn btn-mini'>Delete</button>
					<a class='btn btn-inverse btn-mini' href='javascript:unposting(\"$id_req\");'>Unposting</a>";
			    
			    }else{
				echo "<a class='btn btn-info btn-mini' href='".$urlView."'>View</a>
					<button class='btn btn-mini'>Edit</button>
					<button class='btn btn-mini'>Delete</button>
					<button class='btn btn-mini'>&nbsp;Posting&nbsp; &nbsp;</button>";
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
