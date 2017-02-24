<script type="text/javascript">
//$(document).ready(function() {
//    var oTable = $('#table_cust').dataTable( {
//       	    "bProcessing": true,
//	    "bStateSave": true,
//            "bServerSide": true,
//            "bAutoWidth": false,
//            "bSearchable": true,
//            "sAjaxSource": '<?php echo site_url('customer/getCustomerReq'); ?>',
//            "sPaginationType": "full_numbers", "aLengthMenu" :[[25, 50, 100],[25, 50, 100]],
//	    "bJQueryUI": true,	    
//	   
//	    "oLanguage": {
//                "sProcessing": "<img src='<?php echo base_url(); ?>/img/spinner.gif' class=\"pull-right\" style=\"margin-top:8px;margin-right:6px;\">"
//            },
//            'fnServerData': function (sSource, aoData, fnCallback) {
//                $.ajax
//                ({
//                    'dataType': 'json',
//                    'type': 'POST',
//                    'url': sSource,
//                    'data': aoData,
//                    'success': fnCallback
//                });
//            }
//        });
//   
//});
function posting(xid, com, dis, div){
	//alert(id);
    jConfirm("Posting Approval? <br/>Note : Can't Edit/Delete after posting.", "VI|VE|RE GROUP", function(r) {
	if(r == true){
	    $("#spinner").show();
	    $.ajax({
		type: 'POST', 
		url: "<?php echo site_url('customer/posting_cust_edit'); ?>",
		data: {
			id : xid,
			company : com,
			dis_channel : dis,
			division : div
		},
		cache: false,
		success: function(msg){
		    document.location='<?php echo site_url('customer/list_cust_edit'); ?>';
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
		url: "<?php echo site_url('customer/unposting_cust_edit'); ?>",
		data: "id="+id,
		cache: false,
		success: function(msg){
		    document.location='<?php echo site_url('customer/list_cust_edit'); ?>';
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
		url: "<?php echo site_url('customer/del_cust_edit'); ?>",
		data: "id="+id,
		cache: false,
		success: function(msg){
		    document.location='<?php echo site_url('customer/list_cust_edit'); ?>';
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
	<a class="current" href="#">List Change Customer Request</a>
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
		      <th style="width:4%;">ID Request</th>
                      <th style="width:5%;">Cust. Account</th>
		      <th style="width:5%;">Company Code</th>
                      <th style="width:5%;">Title</th>
		      <th >Name</th>
		      <th style="width:7%;">City</th>
		      
			
		      <!--<th style="width:5%;">Postal Code</th>-->
		      
                      <th style="width:10%;">Status</th>
                      <th style="width:17%;">Action</th>
		  </tr>
		</thead>
		<tbody>
		    <?php
			$no=1;
			foreach($row as $a){
			    $urlView=base_url()."index.php/customer/view_cust_edit/".$a['ID_EDIT'];
			    $urlEdit=base_url()."index.php/customer/form_edit_cust_req/".$a['ID_EDIT'];
			    $id_edit=$a['ID_EDIT'];
			    $sales_org=$a['SALES_ORG'];
			    $dis_channel=$a['DIS_CHANNEL'];
			    $division=$a['DIVISION'];
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
			    if($a['ST_SEND'] == 0){
				echo "<a class='btn btn-info btn-mini' href='".$urlView."'>View</a>
					<a class='btn btn-warning btn-mini' href='".$urlEdit."'>Edit</a>
					<a class='btn btn-danger btn-mini' href='javascript:hapus(\"$id_edit\");'>Delete</a>
					<a class='btn btn-success btn-mini' href='javascript:posting(\"$id_edit\",\"$sales_org\",\"$dis_channel\",\"$division\");'>&nbsp;Posting&nbsp; &nbsp;</a>";
			    }elseif($a['ST_SEND'] == 1){
				echo "<a class='btn btn-info btn-mini' href='".$urlView."'>View</a>
					<button class='btn btn-mini'>Edit</button>
					<button class='btn btn-mini'>Delete</button>
					<a class='btn btn-inverse btn-mini' href='javascript:unposting(\"$id_edit\");'>Unposting</a>";
			    
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
