<script type="text/javascript">
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
	<a class="current" href="#">View Customer Edit Request</a>
    </div>
  </div>
  
  <div class="container-fluid">
    
   
    <br/>
    <div class="row-fluid">
    <div class="span5">
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
                            <td style="width: 30%;"><b>Subject</b></td>
                            <td><?php echo $subject; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%;"><b>Cust. Account</b></td>
                            <td><?php echo $kunnr; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%;"><b>Company Code</b></td>
                            <td><?php echo $company_code." - ".$txt_company; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%;"><b>Sales Organization</b></td>
                            <td><?php echo $sales_org." - ".$txt_sales_org; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%;"><b>Account Group</b></td>
                            <td><?php echo $account_group." - ".$txt_account_group; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%;"><b>Recon Account</b></td>
                            <td><?php echo $recon_account." - ".$txt_recon ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%;"><b>Distribution Channel</b></td>
                            <td><?php echo $dis_channel." - ".$txt_dischannel; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%;"><b>Division</b></td>
                            <td><?php echo $division." - ".$txt_division; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-eye-open"></i>
                </span>
                <h5>General & Company Code Data</h5>
            </div>
            <div class="widget-content nopadding">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td style="width: 30%;"><b>Title</b></td>
                            <td><?php echo $title; ?></td>
                        </tr>
                        <tr>
                             <td style="width: 30%;"><b>Name 1 / Name 2</b></td>
                            <td><?php echo $name1." / ".$name2; ?></td>
                        </tr>
                        
                        <!--<tr>
                             <td style="width: 30%;"><b>Last Name</b></td>
                            <td><?php //echo $nickname; ?></td>
                        </tr>-->
                        <tr>
                             <td style="width: 30%;"><b>Search Term 1 / Search Term 2</b></td>
                            <td><?php echo $search1." / ".$search2; ?></td>
                        </tr>
                        <tr>
                             <td style="width: 30%;"><b>Address</b></td>
                            <td><?php echo $address.", ".$address2.", ".$address3.", ".$address4; ?></td>
                        </tr>
                        <tr>
                             <td style="width: 30%;"><b>Country</b></td>
                            <td><?php echo $country; ?></td>
                        </tr>
                        <tr>
                             <td style="width: 30%;"><b>Region</b></td>
                            <td><?php echo $region." - ".$txt_region; ?></td>
                        </tr>
                         <tr>
                             <td style="width: 30%;"><b>City</b></td>
                            <td><?php echo $city; ?></td>
                        </tr>
                        <tr>
                             <td style="width: 30%;"><b>Postal Code</b></td>
                            <td><?php echo $postal_code; ?></td>
                        </tr>
                        <tr>
                             <td style="width: 30%;"><b>Telephone</b></td>
                            <td><?php echo $tlp; ?></td>
                        </tr>
                        <tr>
                             <td style="width: 30%;"><b>Fax</b></td>
                            <td><?php echo $fax; ?></td>
                        </tr>
                        <tr>
                             <td style="width: 30%;"><b>Mobile Phone</b></td>
                            <td><?php echo $hp; ?></td>
                        </tr>
                        <tr>
                             <td style="width: 30%;"><b>E-Mail</b></td>
                            <td><?php echo $email; ?></td>
                        </tr>
                        <tr>
                             <td style="width: 30%;"><b>Allow Data to POS</b></td>
                            <td><?php if($allowpos == '1'){echo "YES";}else{echo "NO"; }?></td>
                        </tr>
                        <tr>
                             <td style="width: 30%;"><b>Nielsen ID</b></td>
                            <td><?php echo $nielsen." - ".$txt_nielsen; ?></td>
                        </tr>
                        <tr>
                             <td style="width: 30%;"><b>Member Card</b></td>
                            <td><?php echo $member_card; ?></td>
                        </tr>
                        <tr>
                             <td style="width: 30%;"><b>Industry</b></td>
                            <td><?php echo $industry." - ".$txt_industry; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%;"><b>Customer Class</b></td>
                            <td><?php echo $customer_class." - ".$txt_custclass; ?></td>
                        </tr>
                        <tr>
                             <td style="width: 30%;"><b>VAT Reg. No.</b></td>
                            <td><?php echo $vat; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> 
    </div>
    <div class="span7">
	<div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-eye-open"></i>
                </span>
                <h5>Sales Area Data</h5>
            </div>
            <div class="widget-content nopadding">
                <table class="table table-bordered">
                    
                    <tbody>
                        <tr>
                            <td style="width: 30%;"><b>Term of Payment</b></td>
                            <td><?php echo $top." - ".$txt_top; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%;"><b>Sales Office</b></td>
                            <td><?php echo $sales_office." - ".$txt_salesoffice; ?></td>
                        </tr>
                        
                        <tr>
                            <td style="width: 30%;"><b>Customer Group</b></td>
                            <td><?php echo $cust_group." - ".$txt_cust_group; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%;"><b>Currency</b></td>
                            <td><?php echo $curr; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%;"><b>Incoterm</b></td>
                            <td><?php echo $inco1." - ".$txt_inco1; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%;"><b>Description</b></td>
                            <td><?php echo $inco2; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center;">
                                <form name="form1" id="form1" action="<?php echo site_url('customer/transport_edit'); ?>" method="post">
                                    <input type="hidden" name="id_edit" id="id_edit" value="<?php echo $id_edit; ?>">
                                    <input type="submit" id="btnApprove"  value="TRANSPORT SAP" class="btn btn-success"> 
                                </form>
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!--<div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-eye-open"></i>
                </span>
                <h5>Contact Person</h5>
            </div>
            <div class="widget-content nopadding">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th >Title</th>
                            <th>Name</th>
                            <th>Telp/Ext</th>
                            <th>Mobile Phone</th>
                            <th>Fax</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Function</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //    foreach($cp as $a){
                        //        echo "
                        //            <tr>
                        //                <td>".$a['TITLE_CP']."</td>
                        //                <td>".$a['FIRSTNAME_CP']." / ".$a['NAME_CP']."</td>
                        //                <td>".$a['TLP_CP']." / ".$a['EXT_CP']."</td>
                        //                <td>".$a['HP_CP']."</td>
                        //                <td>".$a['FAX_CP']."</td>
                        //                <td>".$a['EMAIL_CP']."</td>
                        //                <td>".$a['DEPARTMENT']."</td>
                        //                <td>".$a['FUNC']."</td>
                        //                
                        //            </tr>
                        //        ";
                        //    }
                        ?>
                        
                    </tbody>
                </table>
            </div>
        </div>-->
        
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
                            <td style="width: 30%;"><b>Status</b></td>
                            <td><?php echo $status; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%;"><b>User Request</b></td>
                            <td><?php echo $user_create; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%;"><b>Date Request</b></td>
                            <td><?php echo $tgl_create; ?></td>
                        </tr>
			 <tr>
                            <td style="width: 30%;"><b>Last Modified</b></td>
                            <td><?php echo $tgl_modif; ?></td>
                        </tr>
			  <tr>
                            <td style="width: 30%;"><b>Last Modified By</b></td>
                            <td><?php echo $nik_modif; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%;"><b>Date Posting</b></td>
                            <td><?php echo $tgl_posting; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%;"><b>Date Accounting Approval</b></td>
                            <td><?php echo $tgl_approved; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%;"><b>User Accounting Approval</b></td>
                            <td><?php echo $user_approved; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%;"><b>Date IS Approval</b></td>
                            <td><?php echo $tgl_is; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%;"><b>User IS Approval</b></td>
                            <td><?php echo $user_is; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
  </div>
</div>
