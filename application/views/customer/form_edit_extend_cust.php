<script type="text/javascript">
 
  function load_sales(){
    var xid = $("#company").val();
    $.ajax({ 
        type: 'POST', 
        url: "<?php echo site_url('customer/get_sales_org'); ?>", 
        data:"id="+xid , 
        success: function(msg) {
                $("#div_sales_org").html(msg);
		$("#division").val("");
		$("#dis_channel").val("");
		load_sales_office();
		load_distribution_channel();
		load_division();
        }
    });
  }
  function load_distribution_channel(){
    var xsls = $("#sales_org").val();
    var xcom = $("#company").val();
    
    $.ajax({ 
        type: 'POST', 
        url: "<?php echo site_url('customer/get_distribution_channel'); ?>", 
        data: {
	    company : xcom,
	    sales_org : xsls
	}, 
        success: function(msg) {
                $("#div_dis_channel").html(msg);
		load_division();
        }
    });
  }
  
  function load_division(){
    var xsls = $("#sales_org").val();
    var xcom = $("#company").val();
    var xdis = $("#dis_channel").val();
    
    $.ajax({ 
        type: 'POST', 
        url: "<?php echo site_url('customer/get_division'); ?>", 
        data: {
	    company : xcom,
	    sales_org : xsls,
	    dis_channel : xdis
	}, 
        success: function(msg) {
                $("#div_division").html(msg);
        }
    });
  }
  
  function load_sales2(){
    var xid = $("#company2").val();
    $.ajax({ 
        type: 'POST', 
        url: "<?php echo site_url('customer/get_sales_org2'); ?>", 
        data:"id="+xid , 
        success: function(msg) {
                $("#div_sales_org2").html(msg);
		$("#division2").val("");
		$("#dis_channel2").val("");
		load_distribution_channel2();
        }
    });
  }
  
  function load_distribution_channel2(){
    var xsls = $("#sales_org2").val();
    var xcom = $("#company2").val();
    
    $.ajax({ 
        type: 'POST', 
        url: "<?php echo site_url('customer/get_distribution_channel2'); ?>", 
        data: {
	    company : xcom,
	    sales_org : xsls
	}, 
        success: function(msg) {
                $("#div_dis_channel2").html(msg);
		load_division2();
        }
    });
  }
  
  function load_division2(){
    var xsls = $("#sales_org2").val();
    var xcom = $("#company2").val();
    var xdis = $("#dis_channel2").val();
    
    $.ajax({ 
        type: 'POST', 
        url: "<?php echo site_url('customer/get_division2'); ?>", 
        data: {
	    company : xcom,
	    sales_org : xsls,
	    dis_channel : xdis
	}, 
        success: function(msg) {
                $("#div_division2").html(msg);
        }
    });
  }
  
  function getRegionChange(){
    var reg = $("#region").val();
    $("#region_h").val(reg);
  }
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
  function load_sales_office(){
    var xid = $("#company").val();
    $.ajax({ 
        type: 'POST', 
        url: "<?php echo site_url('customer/get_sales_office'); ?>", 
        data:"id="+xid , 
        success: function(msg) {
                $("#div_sales_office").html(msg);
		
        }
    });
  }
  $(document).ready(function() {
      var y = "<?php echo $tipe; ?>";
      if( y == "WEB" ){
	$("#div_cust_web").show();
	$("#div_cust_ref").hide();
      }else{
	$("#div_cust_web").hide();
	$("#div_cust_ref").show();
      }
      
  });
  
  function switch_reference(){
    var x = $("#tipe").val();
    if( x == "SAP"){
      $("#div_cust_web").hide();
      $("#div_cust_ref").show();
    }else{
      $("#div_cust_web").show();
      $("#div_cust_ref").hide();
    }
  }
  
  function change_id(){
      var kun= $("#cust_account").val();
      var id="";
      //alert(kun);
      var panjang = kun.length;
      //alert(panjang);
      
      if(panjang == 1){
	id="000000000" + kun;
      }else if(panjang == 2){
	id="00000000" + kun;
      }else if(panjang == 3){
	id="0000000" + kun;
      }else if(panjang == 4){
	id="000000" + kun;
      }else if(panjang == 5){
	id="00000" + kun;
      }else if(panjang == 6){
	id="0000" + kun;
      }else if(panjang == 7){
	id="000" + kun;
      }else if(panjang == 8){
	id="00" + kun;
      }else if(panjang == 9){
	id="0" + kun;
      }else if(panjang == 10){
	id = kun;
      }
      //alert(id);
      $("#cust_account").val(id);
      //return id;
  }
</script>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="<?php echo site_url('home/index'); ?>" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
         <a  href="#">Customer</a>
         <a class="current" href="#">Form Extend Customer</a>
	
    </div>
  </div>
  
  <div class="container-fluid">
    <div class="row-fluid">
    <div class="span12">
        
        <?php
            $msg=$this->session->flashdata('msg');
            echo $msg;
	?>
	<br/>
    </div>
  </div>
    <div class="row-fluid">
        <div class="span12"> 
        <div class="widget-box" style="margin-top: -30px;">
            
	<form  method="post" action="<?php echo site_url('customer/edit_extend_customer'); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate">
        <div class="widget-content padding tab-content" >
	<div id="tab1" class="tab-pane active">
            <div class="row-fluid">
            <div class="span6">
                <div class="widget-box" style="margin-top: -10px;">
                    <div class="widget-title">
                        <span class="icon">
                                <i class="icon-info-sign"></i>									
                        </span>
                        <h5>BASIC DATA</h5>
                    </div>
                    <div class="widget-content padding">
		      <div class="control-group">
                            <label class="control-label"><b>Subject *</b></label>
                            <div class="controls">
                                <input type="text" name="subject" class="span10" value="<?php echo $xsubject; ?>" id="subject" placeholder="Subject" maxlength="30">
                                <input type="hidden" name="id_ex" class="span10" id="id_ex" value="<?php echo $id_ex; ?>">
                            </div>
                        </div>
                        <div class="control-group">
                              <label class="control-label"><b>Customer Account *</b></label>
                              <div class="controls">
                                  <input type="text" name="cust_account" value="<?php echo $xkunnr; ?>" class="span10" id="cust_account" onchange="change_id();"  maxlength="10">
                              </div>
                          </div>
                        <div class="control-group">
                            <label class="control-label"><b>Company Code *</b></label>
                            <div class="controls">
                                <select name="company" id="company" class="span10"  placeholder="Company Code" onchange="load_sales();">
				      <option></option>
				      <?php
					foreach($company as $key1 => $com){
					  
					  if($key1 == 0 and $com['BUKRS'] == ''){
					      continue;}
					  
					  if($com['LAND1'] == 'ID'){
                                            if($xcompany2 == $com['BUKRS']){
                                                echo "<option selected='selected' value='".$com['BUKRS']."'>".$com['BUKRS']." - ".$com['BUTXT']."</option>";
                                            }else{
                                                echo "<option value='".$com['BUKRS']."'>".$com['BUKRS']." - ".$com['BUTXT']."</option>";
                                            }
					    
					  }
					  
					}
				      ?>
				    </select><br/><br/>
                            </div>
                        </div>
			<div class="control-group">
                            <label class="control-label"><b>Sales Organization *</b></label>
                            <div class="controls">
			      <div id="div_sales_org">
				  <select name="sales_org" id="sales_org" readonly="readonly" class="span10" placeholder="Sales Organization" onchange="load_distribution_channel();">
				       <option selected="selected" value="<?php echo $xsales_org2; ?>"><?php echo $xsales_org2; ?></option>
				</select><br/><br/>
			      </div>
                               
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><b>Distribution Channel *</b></label>
                            <div class="controls">
			      <div id="div_dis_channel">
				   <select name="dis_channel" id="dis_channel" readonly="readonly" class="span10" placeholder="Distribution Channel" onchange="load_division();">
				      <option selected="selected" value="<?php echo $xdis_channel2; ?>"><?php echo $xdis_channel2; ?></option>
				      
				    </select><br/><br/>
			      </div>
                              
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><b>Division *</b></label>
                            <div class="controls">
			      <div id="div_division">
				<select name="division" id="division" readonly="readonly"  class="span10" placeholder="Division" >
				      <option selected="selected" value="<?php echo $xdivision2; ?>"><?php echo $xdivision2; ?></option>
				      
				</select><br/><br/>
			      </div>
                                
                            </div>
			    
                        </div>
			   
                    </div>
                </div>			
            </div>
            <div class="span6">
                <div class="widget-box" style="margin-top: -10px;">
                    <div class="widget-title">
                        <span class="icon">
                                <i class="icon-info-sign"></i>									
                        </span>
                        <h5>Reference</h5>
                    </div>
                    <div class="widget-content padding">
		      <div class="control-group">
                            <label class="control-label"><b>Reference Type</b></label>
                            <div class="controls">
                                <select name="tipe" id="tipe" class="span10"  onchange="javascript:switch_reference();">
				      <?php
					if($tipe == "WEB"){
					  echo '<option value="SAP">SAP Reference</option>
						<option selected="selected" value="WEB">WEB Reference</option>';
					}else{
					  echo '<option selected="selected" value="SAP">SAP Reference</option>
						<option  value="WEB">WEB Reference</option>';
					}
				      ?>
				      
				</select><br/><br/>
                            </div>
                      </div>
		      <div id="div_cust_web">
			  <div class="control-group">
				<label class="control-label"><b>ID Req. New Customer</b></label>
				<div class="controls">
				    <input type="text" value="<?php echo $id_cust_req; ?>" name="id_req_cust" class="span10" id="id_req_cust" maxlength="7" placeholder="ID Request New Customer (7 Char)">
				</div>
			  </div>
		      </div>
		      <div id="div_cust_ref">
                        <div class="control-group">
                            <label class="control-label"><b>Company Code *</b></label>
                            <div class="controls">
                                <select name="company2" id="company2"  class="span10" placeholder="Company Code" onchange="javascript:load_sales2();">
				      <option></option>
				      <?php
					foreach($company as $key1 => $com){
					  
					  if($key1 == 0 and $com['BUKRS'] == ''){
					      continue;}
					  
					  if($com['LAND1'] == 'ID'){
					    if($xcompany1 == $com['BUKRS']){
                                                echo "<option selected='selected' value='".$com['BUKRS']."'>".$com['BUKRS']." - ".$com['BUTXT']."</option>";
                                            }else{
						echo "<option  value='".$com['BUKRS']."'>".$com['BUKRS']." - ".$com['BUTXT']."</option>";
					    }
					  }
					  
					}
				      ?>
				    </select><br/><br/>
                            </div>
                        </div>
			<div class="control-group">
                            <label class="control-label"><b>Sales Organization *</b></label>
                            <div class="controls">
			      <div id="div_sales_org2">
				  <select name="sales_org2" id="sales_org2" class="span10" readonly="readonly" placeholder="Sales Organization" onchange="load_distribution_channel2();">
				      <option selected="selected" value="<?php echo $xsales_org1; ?>"><?php echo $xsales_org1; ?></option>
				</select><br/><br/>
			      </div>
                               
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><b>Distribution Channel *</b></label>
                            <div class="controls">
			      <div id="div_dis_channel2">
				   <select name="dis_channel2" id="dis_channel2" readonly="readonly" class="span10" placeholder="Distribution Channel" onchange="load_division2();">
				      <option selected="selected" value="<?php echo $xdis_channel1; ?>"><?php echo $xdis_channel1; ?></option>
				      
				    </select><br/><br/>
			      </div>
                              
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><b>Division *</b></label>
                            <div class="controls">
			      <div id="div_division2">
				<select name="division2" id="division2" readonly="readonly" class="span10" placeholder="Division" >
				      <option selected="selected" value="<?php echo $xdivision1; ?>"><?php echo $xdivision1; ?></option>
				      
				</select><br/><br/>
			      </div>
                                
                            </div>
			    
                        </div>
		      </div>  
                    </div>
                </div>			
            </div>
        </div>
	   
        <div class="row-fluid">
            <div class="span6">
	    <div class="widget-box">
	      <div class="widget-title">
		<span class="icon">
		  <i class="icon-info-sign"></i>									
		</span>
		<h5>SALES AREA DATA</h5>
              </div>
	      <div class="widget-content padding">
		  <div class="control-group">
		    <label class="control-label"><b>Term of Payment *</b></label>
		    <div class="controls">
			<select name="top" id="top" class="span6" placeholder="Term of Payment">
			      <option></option>
			      <?php
				foreach($top as $key10 => $tp){
				  if($key10 == 0 and !isset($tp['ZTERM'])){
				      continue;}
				  
				  $zterm = substr($tp['ZTERM'],0,1);
				  $zterm2 = substr($tp['ZTERM'],0,2);
				    if($zterm == 'Z'){
				      if($zterm2 <> 'ZB'){
					  
					  if($xtop == $tp['ZTERM']){
					      echo "<option selected='selected' value='".$tp['ZTERM']."'>".$tp['ZTERM']." - ".$tp['VTEXT']."</option>";
					  }else{
					    echo "<option value='".$tp['ZTERM']."'>".$tp['ZTERM']." - ".$tp['VTEXT']."</option>";
					  }
					 
				      }
				    }
				}
			      ?>
			</select><br/><br/>
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label"><b>Sales Office *</b></label>
		    <div class="controls">
		      <div id="div_sales_office">
		       <select name="sales_office" id="sales_office" class="span6" placeholder="Sales Office">
			      <option></option>
			      <?php
				foreach($sales_office as $key11 => $sof){
				  
				   if($key11 == 0 and !isset($sof['VKBUR'])){
				      continue;}
				    $nn=substr($sof['VKBUR'],0,1);
				    $in=substr($xcompany2,0,1);
				    
				    
				    $x=substr($sof['VKBUR'],0,1);
				    if($x == "2"){
					    if($in == $x){
						    if($sof['VKBUR'] < "2003"){
							if($xsales_office == $sof['VKBUR']){
							  echo "<option selected='selected' value='".$sof['VKBUR']."'>".$sof['VKBUR']." - ".$sof['BEZEI']."</option>";
							}else{
							    echo "<option value='".$sof['VKBUR']."'>".$sof['VKBUR']." - ".$sof['BEZEI']."</option>";
							}
						    }
					    }
						    
					    
				    }else{
					    if($in == $x){
						    echo "<option value='".$sof['VKBUR']."'>".$sof['VKBUR']." - ".$sof['BEZEI']."</option>";
					    }
				    }
				    
				    
				}
			      ?>
			</select><br/><br/>
		      </div>		       
		       
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label"><b>Customer Group *</b></label>
		    <div class="controls">
		      
			<select name="customer_group" id="customer_group" class="span6" placeholder="Customer Group">
			      <option></option>
			      <?php
				foreach($customer_group as $key12 => $cg){
				  if($key12 == 0 and !isset($cg['KDGRP'])){
				      continue;}
				    if($xcust_group == $cg['KDGRP']){
				      echo "<option selected='selected' value='".$cg['KDGRP']."'>".$cg['KDGRP']." - ".$cg['KTEXT']."</option>";
				    }else{
				      echo "<option value='".$cg['KDGRP']."'>".$cg['KDGRP']." - ".$cg['KTEXT']."</option>";
				    }
				    
				}
			      ?>
			</select><br/><br/>
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label"><b>Currency *</b></label>
		    <div class="controls">
			<select name="currency" id="currency" class="span6" placeholder="Currency">
			      <option></option>
			      <?php
				foreach($currency as $key13 => $cur){
				  if($key13 == 0 and !isset($cur['WAERS'])){
				      continue;}
				    if($xcurrency == $cur['WAERS']){
				      echo "<option selected='selected' value='".$cur['WAERS']."'>".$cur['WAERS']." - ".$cur['LTEXT']."</option>";
				    }else{
				      echo "<option value='".$cur['WAERS']."'>".$cur['WAERS']." - ".$cur['LTEXT']."</option>";
				    }
				    
				}
			      ?>
			</select><br/><br/>
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label"><b>Incoterm *</b></label>
		    <div class="controls">
			<select name="incoterm" id="incoterm" class="span6" placeholder="Incoterm">
			      <option></option>
			      <?php
				foreach($incoterm as $key14 => $inc){
				  if($key14 == 0 and !isset($inc['INCO1'])){
				      continue;}
				    if($xinco == $inc['INCO1']){
				      echo "<option selected='selected' value='".$inc['INCO1']."'>".$inc['INCO1']." - ".$inc['BEZEI']."</option>";
				    }else{
				      echo "<option value='".$inc['INCO1']."'>".$inc['INCO1']." - ".$inc['BEZEI']."</option>";
				    }
				    
				}
			      ?>
			</select><br/><br/>
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label"><b>Description</b></label>
		    <div class="controls">
			<input type="text" class="span12" name="deskripsi" id="deskripsi (max : 25 char)" value="<?php echo $xdeskripsi; ?>" maxlength="25">
		    </div>
		</div>
	      </div>
	    </div>
	  </div>
        <div class="span6">
	    <div class="widget-box">
	      <div class="widget-title">
		<span class="icon">
		  <i class="icon-info-sign"></i>									
		</span>
		<h5>Account Group & Recon Account</h5>
              </div>
	      <div class="widget-content padding">
		  <div class="control-group">
		    <label class="control-label"><b>Account Group *</b></label>
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
		    <label class="control-label"><b>Recon Account</b></label>
		    <div class="controls">
			<div id="div_rec">
                            <select name="recon_account" id="recon_account" class="span11"  readonly="readonly" placeholder="Recon Account">
                                <option></option>
                                <?php
                                
                                  foreach($recon_account as $key2 => $rec){
                                    
                                    if($key2 == 0 and !isset($rec['SAKNR'])){
                                        continue;}
                                    if($xrec_account ==   $rec['SAKNR']){
                                        echo "<option selected='selected' value='".$rec['SAKNR']."'>".$rec['SAKNR']." - ".$rec['TXT50']."</option>";
                                    }else{
                                        echo "<option value='".$rec['SAKNR']."'>".$rec['SAKNR']." - ".$rec['TXT50']."</option>";
                                    }
                                    
                                  }
                                ?>
			    </select><br/><br/>
			  </div>
                        </div>
		    </div>
		
	      </div>
	    </div>
	  </div>
	
        </div>
        <div class="form-actions">
              <input type="submit" value="SAVE" class="btn btn-success">
          </div>
        </form>
	</div> <!--tab1-->
	
	
	
	</div>
        </div>
      </div>
    
    </div>
    
  </div>
</div>

