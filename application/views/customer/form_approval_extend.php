<script type="text/javascript">
  function getRecon(){
    var xid = $("#account_group").val();
    $.ajax({ 
        type: 'POST', 
        url: "<?php echo site_url('customer/get_recon'); ?>", 
        data:"id="+xid , 
        success: function(msg) {
                $("#div_rec").html(msg);
        }
    });
  }
  
  $(document).ready(function() {
      $("#btnApprove").click(function(){
	  $("#spinner").show();
      });
});
</script>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="<?php echo site_url('home/index'); ?>" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
        <a  href="#">Customer</a>
	<a class="current" href="#">Form Approval Extend Customer</a>
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
                    <h5>Account Group & Recon Account</h5>
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" action="<?php echo site_url('customer/add_approval_extend'); ?>" method="post" action="#" name="basic_validate" id="basic_validate" novalidate="novalidate">
                    <div class="control-group">
                        <label class="control-label">Account Group</label>
                        <div class="controls">
                            <select name="account_group" id="account_group" class="span11" placeholder="Account Group" onchange="getRecon();">
                                <option></option>
                                <?php
                                
                                  foreach($account_group as $key1 => $acg){
                                    
                                    if($key1 == 0 and !isset($acg['KTOKD'])){
                                        continue;}
                                    $acc = substr($acg['KTOKD'],0,1);
				    if($acc == "Z" && $acg['KTOKD'] <> "Z103" && $acg['KTOKD'] <> "Z107" && $acg['KTOKD'] <> "Z999"){
				       if($xaccount_group == $acg['KTOKD']){
                                            echo "<option selected='selected' value='".$acg['KTOKD']."'>".$acg['KTOKD']." - ".$acg['TXT30']."</option>";
                                       }else{
                                            echo "<option value='".$acg['KTOKD']."'>".$acg['KTOKD']." - ".$acg['TXT30']."</option>";
                                       }
                                       
				    }
                                    
                                  }
                                ?>
			    </select><br/><br/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Recon Account</label>
                        <div class="controls">
			  <div id="div_rec">
                            <select name="recon_account" id="recon_account" class="span11" readonly="readonly" placeholder="Recon Account">
                                <option></option>
                                <?php
                                
                                  foreach($recon_account as $key2 => $rec){
                                    
                                    if($key2 == 0 and !isset($rec['SAKNR'])){
                                        continue;}
                                    
                                    if($xrec_account == $rec['SAKNR']){
					echo "<option selected='selected' value='".$rec['SAKNR']."'>".$rec['SAKNR']." - ".$rec['TXT50']."</option>";
				    }else{
				      echo "<option value='".$rec['SAKNR']."'>".$rec['SAKNR']." - ".$rec['TXT50']."</option>";
				    }
                                  }
                                ?>
			    </select><br/><br/>
			  </div>
                            <input type="hidden" name="id_ex" id="id_ex" value="<?php echo $id_ex; ?>" >
                            
                        </div>
                    </div>
                   
                    <div class="form-actions">
                        <input type="submit" value="Approve" id="btnApprove" class="btn btn-success">
                    </div>
                </form>
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
                    <h5>Reference</h5>
                </div>
                <div class="widget-content nopadding">
                    <table class="table table-bordered">
                        <tbody>
			   <tr>
                                <td style="width: 30%;"><b>Tipe</b></td>
                                <td><?php echo $tipe; ?></td>
                            </tr>
			    <tr>
                                <td style="width: 30%;"><b>ID Req. New Customer</b></td>
                                <td><?php echo $id_req_cust." - ".$nama_new; ?></td>
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
			    <tr>
                                <td style="width: 30%;"><b>-</b></td>
                                <td>-</td>
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
        </div>
    </div>
    
  </div>
</div>
