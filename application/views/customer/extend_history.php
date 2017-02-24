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
        <a  href="#">Customer</a>
	<a class="current" href="#">List Customer Request</a>
    </div>
  </div>
  
  <div class="container-fluid">
    <form action='<?php echo site_url('customer/extend_history_filter'); ?>' method='POST'>
	<div class="row-fluid">
		
		<div class='span3'>
			<div class='control-group'>
				<label class="control-label"><b>Date Start</b></label>
					<div class="controls">
						<input type='text' required name='tgl1' id='tgl1' data-date="01-02-2013" data-date-format="dd-mm-yyyy" class="datepicker"  placeholder='DD-MM-YYYY'/>
					</div>
			</div>
		</div>
		<div class='span3'>
			<div class='control-group'>
				<label class="control-label"><b>Date End</b></label>
					<div class="controls">
						<input type='text' required name='tgl2' id='tgl2' data-date="01-02-2013" data-date-format="dd-mm-yyyy" class="datepicker"  placeholder='DD-MM-YYYY'/>
					</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class='span3'>
			<div class='control-group'>
				<label class="control-label"><b>Company of</b></label>
					<div class="controls">
						<select name='company' id='company_of'>
							<?php
							foreach($company as $key1 => $com){
					  
								 if($key1 == 0 and $com['BUKRS'] == ''){
										continue;
								 }
					  
								 if($com['LAND1'] == 'ID'){
									echo "<option value='".$com['BUKRS']."'>".$com['BUKRS']." - ".$com['BUTXT']."</option>";
								 }
					  
							}
				      ?>
						</select>
					</div>
			</div>
		</div>
		<div class='span3'>
			<div class='control-group'>
					<label class="control-label"><b><br></b></label>
					<div class="controls">			
						<input type='submit' value='Choose Filter' class='btn btn-primary'/>
					</div>
			</div>
		</div>
	</div>
	</form>
		
    </div>

  </div>
</div>
