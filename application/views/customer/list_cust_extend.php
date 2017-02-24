<script type="text/javascript">

function posting(xid, com, dis, div){
	//alert(id);
    jConfirm("Posting ? <br/>Note : Can't Edit/Delete after posting.", "VI|VE|RE GROUP", function(r) {
	if(r == true){
	     $("#spinner").show();
	    $.ajax({
		type: 'POST', 
		url: "<?php echo site_url('customer/posting_extend'); ?>",
		data: {
			id : xid,
			company : com,
			dis_channel : dis,
			division : div
		},
		cache: false,
		success: function(msg){
		    document.location='<?php echo site_url('customer/list_cust_extend'); ?>';
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
		url: "<?php echo site_url('customer/unposting_extend'); ?>",
		data: "id="+id,
		cache: false,
		success: function(msg){
		    document.location='<?php echo site_url('customer/list_cust_extend'); ?>';
		}
	    });	
	}
    });

}
function hapus(id){
	//alert(id);
    jConfirm("Delete Customer Extend Request? ", "VI|VE|RE GROUP", function(r) {
	if(r == true){
	    $.ajax({
		type: 'POST', 
		url: "<?php echo site_url('customer/delete_extend_cust'); ?>",
		data: "id="+id,
		cache: false,
		success: function(msg){
		    document.location='<?php echo site_url('customer/list_cust_extend'); ?>';
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
	<a class="current" href="#">List Customer Extend</a>
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
			<th style="width:5%;">Ref. Type</th>
			<th style="width:5%;">ID Req. New</th>
                        <th style="width:10%;">Status</th>
                        <th style="width:16%;">Action</th>
		  </tr>
		</thead>
		<tbody>
		    <?php
			$no=1;
			foreach($row as $a){
			    $urlView=base_url()."index.php/customer/view_extend/".$a['ID_EX'];
			    $urlEdit=base_url()."index.php/customer/form_edit_extend/".$a['ID_EX'];
			    $id_ex=$a['ID_EX'];
			    $sales_org=$a['SALES_ORG2'];
			    $dis_channel=$a['DIS_CHANNEL2'];
			    $division=$a['DIVISION2'];
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
				    <td>".$a['TIPE']."</td>
				    <td>".$a['ID_CUST']."</td>
				    <td>".$a['NEW_ST']."</td>";
			    echo "<td style='text-align: center;'>";    
			    if($a['ST_SEND'] == 0){
				echo "<a class='btn btn-info btn-mini' href='".$urlView."'>View</a>
					<a class='btn btn-warning btn-mini' href='".$urlEdit."'>Edit</a>
					<a class='btn btn-danger btn-mini' href='javascript:hapus(\"$id_ex\");'>Delete</a>
					<a class='btn btn-success btn-mini' href='javascript:posting(\"$id_ex\",\"$sales_org\",\"$dis_channel\", \"$division\");'>&nbsp;Posting&nbsp; &nbsp;</a>";
			    }elseif($a['ST_SEND'] == 1){
				echo "<a class='btn btn-info btn-mini' href='".$urlView."'>View</a>
					<button class='btn btn-mini'>Edit</button>
					<button class='btn btn-mini'>Delete</button>
					<a class='btn btn-inverse btn-mini' href='javascript:unposting(\"$id_ex\");'>Unposting</a>";
			    
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
