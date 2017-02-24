<script type="text/javascript">
function posting(id){
	//alert(id);
    jConfirm("Posting ? <br/>Note : Can't Edit/Delete after posting.", "VI|VE|RE GROUP", function(r) {
	if(r == true){
	    $.ajax({
		type: 'POST', 
		url: "<?php echo site_url('customer/posting_extend'); ?>",
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
	<a class="current" href="#">View Extend Customer Request</a>
    </div>
  </div>
  
  <div class="container-fluid">
    
   
    <br/>
    <div class="row-fluid">
        <div class="span6">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-eye-open"></i>
                    </span>
                    <h5>BASIC DATA</h5>
                </div>
                <div class="widget-content nopadding">
                    <table class="table table-bordered">
                        <tbody>
			    <tr>
                                <td style="width: 30%;"><b>ID Request Extend</b></td>
                                <td><?php echo $id_ex; ?></td>
                            </tr>
			    
                            <tr>
                                <td style="width: 30%;"><b>Subject</b></td>
                                <td><?php echo $xsubject; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 30%;"><b>Cust. Account</b></td>
                                <td><?php echo $xkunnr; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 30%;"><b>Company Code</b></td>
                                <td><?php echo $xcompany2." - ".$txt_company2; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 30%;"><b>Sales Organization</b></td>
                                <td><?php echo $xsales_org2." - ".$txt_sales_org2; ?></td>
                            </tr>
                            
                            <tr>
                                <td style="width: 30%;"><b>Distribution Channel</b></td>
                                <td><?php echo $xdis_channel2." - ".$txt_dischannel2; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 30%;"><b>Division</b></td>
                                <td><?php echo $xdivision2." - ".$txt_division2; ?></td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
        <div class="span6">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-eye-open"></i>
                    </span>
                    <h5>Reference</h5>
                </div>
                <div class="widget-content nopadding">
                    <table class="table table-bordered">
                        <tbody>
			    <tr>
                                <td style="width: 30%;"><b>Tipe Ref.</b></td>
                                <td><?php echo $tipe; ?></td>
                            </tr>
			    <tr>
                                <td style="width: 30%;"><b>ID Req. New Customer</b></td>
                                <td><?php echo $id_cust_req." - ".$nama_new; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 30%;"><b>Company Code</b></td>
                                <td><?php echo $xcompany1." - ".$txt_company1; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 30%;"><b>Sales Organization</b></td>
                                <td><?php echo $xsales_org1." - ".$txt_sales_org1; ?></td>
                            </tr>
                            
                            <tr>
                                <td style="width: 30%;"><b>Distribution Channel</b></td>
                                <td><?php echo $xdis_channel1." - ".$txt_dischannel1; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 30%;"><b>Division</b></td>
                                <td><?php echo $xdivision1." - ".$txt_division1; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 30%;"><b> -</b></td>
                                <td>-</td>
                            </tr>
			   
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span6">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-eye-open"></i>
                    </span>
                    <h5>Account Group & Recon Account</h5>
                </div>
                <div class="widget-content nopadding">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td style="width: 30%;"><b>Account Group</b></td>
                                <td><?php echo $xaccount_group." - ".$txt_account_group; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 30%;"><b>Recon Account</b></td>
                                <td><?php echo $xrec_account." - ".$txt_recon ?></td>
                            </tr>
			    <tr>
                            <td style="width: 30%;"><b>Term of Payment</b></td>
                            <td><?php echo $xtop." - ".$txt_top; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%;"><b>Sales Office</b></td>
                            <td><?php echo $xsales_office." - ".$txt_salesoffice; ?></td>
                        </tr>
                        
                        <tr>
                            <td style="width: 30%;"><b>Customer Group</b></td>
                            <td><?php echo $xcust_group." - ".$txt_cust_group; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%;"><b>Currency</b></td>
                            <td><?php echo $xcurrency; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%;"><b>Incoterm</b></td>
                            <td><?php echo $xinco1." - ".$txt_inco1; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%;"><b>Description</b></td>
                            <td><?php echo $xinco2; ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
        <div class="span6">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-eye-open"></i>
                    </span>
                    <h5>History</h5>
                </div>
                <div class="widget-content nopadding">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td style="width: 30%;"><b>User Create</b></td>
                                <td><?php echo $xnik_create; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 30%;"><b>Date Create</b></td>
                                <td><?php echo $xdate_create; ?></td>
                            </tr>
                            
                            <tr>
                                <td style="width: 30%;"><b>Date Posting</b></td>
                                <td><?php echo $xdate_posting; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 30%;"><b>Last Modified</b></td>
                                <td><?php echo $xdate_modif; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 30%;"><b>User Modified</b></td>
                                <td><?php echo $xnik_modif; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 30%;"><b>Date Accounting Approval</b></td>
                                <td><?php echo $xdate_approve; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 30%;"><b>User Accounting Approval</b></td>
                                <td><?php echo $xnik_approve; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 30%;"><b>Date IS Approval</b></td>
                                <td><?php echo $xdate_transport; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 30%;"><b>User IS Approval</b></td>
                                <td><?php echo $xnik_transport; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
	    <?php
	  $nikA=$this->session->userdata('NIK');
	  
	  if($st_send == 0 and $st='1' and ($xnik_create == $nikA or strpos($this->session->userdata('role'),'ADMINISTRATOR') !== false)) :
	?>
	<div class="form-actions">
            <a href='javascript:posting("<?php echo $id_ex; ?>")'><input type="button" value="POSTING" class="btn btn-success"></a>
        </div>
	<?php
	  endif;
	?>
        </div>
    </div>
    
  </div>
</div>
