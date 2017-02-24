<script type="text/javascript">
  $(document).ready(function() {
    var xallow = "<?php echo $xallowpos; ?>";
    if(xallow == '1'){
        $("#div_nielsen").show();
    }else{
         $("#div_nielsen").hide();
    }
    
    $("#tabel_cp").load("<?php echo site_url('customer/load_tempCP'); ?>");
    
    $("#btnNext1").click(function(){
       $('#xtab2').addClass('active');
       $('#xtab1').removeClass('active');
       $('#xtab3').removeClass('active');
       $('#xtab4').removeClass('active');
    });
    $("#btnNext2").click(function(){
       $('#xtab2').removeClass('active');
       $('#xtab1').removeClass('active');
       $('#xtab3').addClass('active');
       $('#xtab4').removeClass('active');
    });
    $("#btnNext3").click(function(){
       $('#xtab2').removeClass('active');
       $('#xtab1').removeClass('active');
       $('#xtab3').removeClass('active');
       $('#xtab4').addClass('active');
    });
    
    $("#btnAdd").click(function(){
      //alert("asas");
       var xtitle= $("#title_cp").val();
      var xfirstname =  $("#firstname_cp").val();
      var xname =  $("#name_cp").val();
      var xtlp =  $("#tlp_cp").val();
      var xext = $("#ext_cp").val();
      var xhp = $("#hp_cp").val();
      var xfax = $("#fax_cp").val();
      var xemail = $("#email_cp").val();
      var xdept = $("#departemen").val();
      var xfunction = $("#function").val();
      var xcall = $("#call_frequency").val();
      var xgender = $("#gender").val();
      var xtgl_lahir = $("#tgl_lahir").val();
      var xtgl_register = $("#tgl_register").val();
      
	if(xname == '' || xtitle == ''){
	    alert("Title & Name harus terisi !")
	}else{
	    $.ajax({ 
		type: 'POST', 
		url: "<?php echo site_url('customer/add_tempCP'); ?>", 
		data: {
			title : xtitle,
			firstname : xfirstname,
			name : xname,
			tlp : xtlp,
			ext : xext,
			hp : xhp,
			fax : xfax,
			email : xemail,
			dept : xdept,
			func : xfunction,
			call_freq : xcall,
			gender : xgender,
			tgl_lahir : xtgl_lahir,
			tgl_register : xtgl_register
		}, 
		success: function(data) {
		    $("#tabel_cp").load("<?php echo site_url('customer/load_tempCP'); ?>");
		    $("#name_cp").val("");
		    $("#firstname_cp").val("");
		    $("#tlp_cp").val("");
		    $("#fax_cp").val("");
		    $("#ext_cp").val("");
		    $("#hp_cp").val("");
		    $("#email_cp").val("");
		    //$("#function").attr('selectedIndex', '-1').find("option:selected").removeAttr("selected");
		    //$("#departemen").val("-");
		}
	    }) ;
	}
	
    });
  });
  
  function loadRegion(){
    var xid = $("#country").val();
    $.ajax({ 
        type: 'POST', 
        url: "<?php echo site_url('customer/get_region'); ?>", 
        data:"id="+xid , 
        success: function(msg) {
                $("#div_reg").html(msg);
        }
    });
  }
  
  function show_nielsen(){
    var ck1 = document.getElementById('ck1');
    if(ck1.checked){
      //alert("checked");
      $("#div_nielsen").show();
      $("#ck1_h").val("1");
    }else{
      $("#div_nielsen").hide();
      $("#ck1_h").val("0");
    }
  }
  function hapusTemp(id,qty, qty_sisa){
    //alert(id);
    var idx = id;
    jConfirm("Delete Contact Person?", "VI|VE|RE", function(r) {
	    if(r == true){
		$.ajax({ 
		type: 'POST', 
		url: "<?php echo site_url('customer/hapus_tempCP'); ?>", 
		data: "id="+idx, 
		success: function(data) {
		    $("#tabel_cp").load("<?php echo site_url('customer/load_tempCP'); ?>");
		    
		}
	}) ;
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
  
</script>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="<?php echo site_url('home/index'); ?>" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
         <a class="current" href="#">Form Edit New Customer Request</a>
	
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
            <div class="widget-title">
	      <ul class="nav nav-tabs">
		<li id="xtab1" class="active"><a data-toggle="tab" href="#tab1">Basic</a></li>
		<li id="xtab2"><a data-toggle="tab" href="#tab2">General</a></li>
		<li id="xtab3"><a data-toggle="tab" href="#tab3">CP</a></li>
		<li id="xtab4"><a data-toggle="tab" href="#tab4">Sales</a></li>
	      </ul>
	    </div>
        <div class="widget-content padding tab-content">
	<div id="tab1" class="tab-pane active">
        <form  method="post" action="<?php echo site_url('customer/edit_customer'); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate">
            <div class="row-fluid">
            <div class="span12">
                <div class="widget-box" style="margin-top: -20px;">
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
                                <input type="text" name="subject" value="<?php echo $xsubject; ?>" class="span6" id="subject" maxlength="30" placeholder="Subject">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><b>Company Code *</b></label>
                            <div class="controls">
                                <select name="company" id="company" class="span6" placeholder="Company Code" readonly="readonly">
				      <option></option>
				      <?php
					foreach($company as $key1 => $com){
					  
					  if($key1 == 0 and $com['BUKRS'] == ''){
					      continue;}
					  
					  if($com['LAND1'] == 'ID'){
                                            if($xcompany_code == $com['BUKRS']){
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
                               <select name="sales_org" id="sales_org" class="span6" placeholder="Sales Organization" readonly="readonly">
				      <option></option>
				      <?php
				      
					foreach($sales_org as $key2a => $sls){
					  
					  if($key2a == 0 and !isset($sls['VKORG'])){
					      continue;}
					    if($xsales_org == $sls['VKORG']){
                                                echo "<option selected='selected' value='".$sls['VKORG']."'>".$sls['VKORG']." - ".$sls['VTEXT']."</option>";
                                            }else{
                                                echo "<option  value='".$sls['VKORG']."'>".$sls['VKORG']." - ".$sls['VTEXT']."</option>";
                                            }
					  
					}
				      ?>
				</select><br/><br/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><b>Distribution Channel *</b></label>
                            <div class="controls">
                               <select name="dis_channel" id="dis_channel" class="span6" placeholder="Distribution Channel" readonly="readonly">
				      <option></option>
				      <?php
				      
					foreach($dis_channel as $key2 => $dis){
					  
					  if($key2 == 0 and !isset($dis['VTWEG'])){
					      continue;}
					    if($xdis_channel == $dis['VTWEG']){
                                                echo "<option selected='selected' value='".$dis['VTWEG']."'>".$dis['VTWEG']." - ".$dis['VTEXT']."</option>";
                                            }else{
                                                echo "<option value='".$dis['VTWEG']."'>".$dis['VTWEG']." - ".$dis['VTEXT']."</option>";
                                            }
					  
					}
				      ?>
				</select><br/><br/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><b>Division *</b></label>
                            <div class="controls">
                                <select name="division" id="division" class="span6" placeholder="Division" readonly="readonly">
				      <option></option>
				      <?php
					foreach($division as $key3 => $div){
					  
					  if($key3 == 0 and !isset($div['SPART'])){
					      continue;}
					    if($xdivision == $div['SPART']){
                                                 echo "<option selected='selected' value='".$div['SPART']."'>".$div['SPART']." - ".$div['VTEXT']."</option>";
                                            }else{
                                                echo "<option value='".$div['SPART']."'>".$div['SPART']." - ".$div['VTEXT']."</option>";
                                            }
					   
					}
				      ?>
				</select><br/><br/>
                            </div>
			    
                        </div>
			
		      <div class="control-group">
                        <label class="control-label"><b>Account Group *</b></label>
                        <div class="controls">
                            <select name="account_group" id="account_group" class="span6" placeholder="Account Group" onchange="getRecon();">
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
					    echo "<option  value='".$acg['KTOKD']."'>".$acg['KTOKD']." - ".$acg['TXT30']."</option>";
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
                            <select name="recon_account" id="recon_account" class="span6" readonly="readonly" placeholder="Recon Account">
                                <option></option>
                                <?php
                                
                                  foreach($recon_account as $key2 => $rec){
                                    
                                    if($key2 == 0 and !isset($rec['SAKNR'])){
                                        continue;}
                                    if($xrecon_account == $rec['SAKNR']){
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
			
			<div class="control-group">
			  <a data-toggle="tab" href="#tab2"><input type="button" id="btnNext1" name="btnNext1" value="Next" class="btn btn-primary pull-right"></a><br/>
			</div>
			   
			
                    </div>
                </div>			
            </div>
	   
        </div>
       
	   
        <div class="row-fluid">
            
        </div>
        <div class="row-fluid">
            
	    
        </div>
        
	</div> <!--tab1-->
	<div id="tab2" class="tab-pane"> <!--start tab 2-->
	  <div class="row-fluid">
	    <div class="widget-box">
	      <div class="widget-title">
		<span class="icon">
		  <i class="icon-info-sign"></i>									
		</span>
		<h5>GENERAL AND COMPANY CODE DATA</h5>
              </div>
	      <div class="widget-content padding">
		
		<!--Start Control Box-->
		<div class="control-group">
		  <label class="control-label"><b>Title *</b></label>
		  <div class="controls">
                    
		    <select name="title" id="title" class="span3" placeholder="Title">
		      <?php
                            if($xtitle == "Company"){
                                echo "<option selected='selected' value='Company'>Company</option>
                                    <option value='Mr.'>Mr.</option>
                                    <option value='Ms.'>Ms.</option>
                                    <option value='Mr. and Ms.'>Mr. and Mrs.</option>";
                            }elseif($xtitle == "Mr."){
                                echo "<option  value='Company'>Company</option>
                                    <option selected='selected' value='Mr.'>Mr.</option>
                                    <option value='Ms.'>Ms.</option>
                                    <option value='Mr. and Ms.'>Mr. and Mrs.</option>";
                            }elseif($xtitle == "Ms."){
                                echo "<option  value='Company'>Company</option>
                                    <option  value='Mr.'>Mr.</option>
                                    <option selected='selected' value='Ms.'>Ms.</option>
                                    <option value='Mr. and Ms.'>Mr. and Mrs.</option>";
                            }elseif($xtitle == "Mr. and Ms."){
                                echo "<option  value='Company'>Company</option>
                                    <option  value='Mr.'>Mr.</option>
                                    <option  value='Ms.'>Ms.</option>
                                    <option selected='selected' value='Mr. and Ms.'>Mr. and Mrs.</option>";
                            }else{
			      echo "<option  value='Company'>Company</option>
                                    <option  value='Mr.'>Mr.</option>
                                    <option  value='Ms.'>Ms.</option>
                                    <option  value='Mr. and Ms.'>Mr. and Mrs.</option>";
			    }
                      ?>
		      
		    </select>
                    
		    <br/><br/>
		  </div>
		</div>
		
		<div class="control-group">
		    <label class="control-label"><b>Name *</b></label>
		    <div class="controls">
                        <input type="hidden" name="id_cust" id="id_cust" value="<?php echo $xid_cust; ?>">
			<input type="text" name="name1" value="<?php echo $xname1; ?>" class="span6" id="name1" placeholder="Name 1"  maxlength="35">
			<input type="hidden" name="nickname" value="<?php echo $xnickname; ?>" class="span4" id="nickname" placeholder="Last Name"  maxlength="16">
			<input type="text" name="name2" value="<?php echo $xname2; ?>" class="span6" id="name2" placeholder="Name 2"  maxlength="35">
			
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label"><b>Search Term 1 | Search Term 2</b></label>
		    <div class="controls">
			<input type="text" name="search1" value="<?php echo $xsearch1; ?>" class="span6" id="search1" placeholder="Search Term 1" maxlength="10">
			<input type="text" name="search2" value="<?php echo $xsearch2; ?>" class="span6" id="search2" placeholder="Search Term 2" maxlength="10">
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label"><b>Address</b></label>
		    <div class="controls">
			<input type="text" name="address" class="span11" id="address" value="<?php echo $xaddress; ?>" placeholder="Address 1 (Max 35 Char)" maxlength="35"><br/>
			<input type="text" name="address2" class="span11" id="address2" value="<?php echo $xaddress2; ?>" placeholder="Address 2 (Max 35 Char)" maxlength="35"><br/>
			<input type="text" name="address3" class="span11" id="address3" value="<?php echo $xaddress3; ?>" placeholder="Address 3 (Max 35 Char)" maxlength="35">
			<input type="text" name="address4" class="span11" id="address4" value="<?php echo $xaddress4; ?>" placeholder="Address 4(Max 35 Char)" maxlength="35">
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label"><b>Postal Code | City</b></label>
		    <div class="controls">
			<input type="text" value="<?php echo $xpostal_code; ?>" name="postalcode" class="span3" id="postalcode" placeholder="Postal Code" maxlength="5">
			  <input type="text" name="city" value="<?php echo $xcity; ?>" class="span3" id="city" placeholder="City" maxlength="35">
                          
                          <?php
                            if($xallowpos == "1"){
                                echo '<input type="checkbox" checked="checked" name="ck1" id="ck1" value="1" onchange="show_nielsen();"> Allow the data at POS (Nielsen ID, Member Card, Industry, Industry Code 1, & Customer Class is required)
                                     <input type="hidden" name="ck1_h" id="ck1_h" value="1">';
                            }else{
                                 echo '<input type="checkbox" name="ck1" id="ck1" value="1" onchange="show_nielsen();"> Allow the data at POS (Nielsen ID, Member Card, Industry, Industry Code 1, & Customer Class is required)
                                     <input type="hidden" name="ck1_h" id="ck1_h" value="0">';
                            }
                          ?>
			  
		    </div>
		</div>
		<div id="div_nielsen">
		<div class="control-group">
		    <label class="control-label"><b>Nielsen ID</b></label>
		    <div class="controls">
			<select name="nielsen" id="nielsen" class="span4" placeholder="Nielsen ID" >
			  <option></option>
			  <?php
			    
			    foreach($nielsen as $key5 => $n){
			      
				if($key5 == 0 and !isset($n['NIELS'])){
				  continue;}
                                    
                                    if($xnielsen == $n['NIELS']){
                                        echo "<option selected='selected' value='".$n['NIELS']."'>".$n['NIELS']." - ".$n['BEZEI']."</option>";
                                    }else{
                                        echo "<option value='".$n['NIELS']."'>".$n['NIELS']." - ".$n['BEZEI']."</option>";
                                    }
				  
				
			    }
			  ?>
			</select><br/><br/>
		    </div>
		</div>
		</div>
		<div class="control-group">
		    <label class="control-label"><b>Country * </b></label>
		    <div class="controls">
			<select name="country" id="country" class="span4" placeholder="Country" onchange="loadRegion();">
			  <option></option>
			  <?php
			    foreach($country as $key4 => $con){
			      if($key4 == 0 and $con['LAND1'] == ''){
				  continue;}
                                if($xcountry == $con['LAND1']){
                                    echo "<option selected='selected' value='".$con['LAND1']."'>".$con['LAND1']." - ".$con['LANDX']."</option>";
                                }else{
                                     echo "<option value='".$con['LAND1']."'>".$con['LAND1']." - ".$con['LANDX']."</option>";
                                }
				
			    }
			  ?>
			</select><br/><br/>
		       
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label"><b>Region </b></label>
		    <div class="controls">
		      <div id="div_reg">
			<select name="region" id="region" class="span4" onchange="getRegionChange();">
			  <option></option>
                          <?php
			    foreach($region_select as $key40 => $regse){
			      if($key40 == 0 and $regse['BLAND'] == ''){
				  continue;}
                                if($xregion == $regse['BLAND']){
                                    echo "<option selected='selected' value='".$regse['BLAND']."'>".$regse['BLAND']." - ".$regse['BEZEI']."</option>";
                                }else{
                                     echo "<option value='".$regse['BLAND']."'>".$regse['BLAND']." - ".$regse['BEZEI']."</option>";
                                }
				
			    }
			  ?>
			</select>
		      </div>
		      <input type="hidden" name="region_h" id="region_h" value="<?php echo $xregion; ?>">
			<br/>
			
		    </div>
		</div>
		
		<div class="control-group">
		    <label class="control-label"><b>Telephone | Fax | Mobile Phone | Email</b></label>
		    <div class="controls">
			<input type="text" name="tlp" value="<?php echo $xtlp; ?>" class="span3" id="tlp" placeholder="Telephone" maxlength="16">
			<input type="text" name="fax" value="<?php echo $xfax; ?>" class="span3" id="fax" placeholder="Fax" maxlength="30">
			<input type="text" name="hp" class="span3" value="<?php echo $xhp; ?>" id="hp" placeholder="Mobile Phone" maxlength="16">
			<input type="text" name="email" class="span3" value="<?php echo $xemail; ?>" id="email" placeholder="Email" maxlength="30">
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label"><b>Member Card | VAT Reg.</b></label>
		    <div class="controls">
		      <input type="text" name="membercard" value="<?php echo $xmember_card; ?>" class="span6" id="membercard" placeholder="Member Card" maxlength="30">
		      <input type="text" name="vat" value="<?php echo $xvat; ?>" class="span6" id="vat" placeholder="VAT. Reg. No." maxlength="20">
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label"><b>Industry *</b></label>
		    <div class="controls">
			<select name="industry" id="industry" class="span6" placeholder="Industry">
			  <option></option>
			  <?php
			    foreach($industry as $key6 => $i){
			      if($key6 == 0 and !isset($i['BRSCH'])){
				  continue;}
				if($xindustry == $i['BRSCH']){
                                    echo "<option selected='selected' value='".$i['BRSCH']."'>".$i['BRSCH']." - ".$i['BRTXT']."</option>";
                                }else{
                                    echo "<option value='".$i['BRSCH']."'>".$i['BRSCH']." - ".$i['BRTXT']."</option>";
                                }
				
			    }
			  ?>
			</select>
			
			<select name="customer_class" id="customer_class" class="span6" placeholder="Customer Class">
			  <option></option>
			  <?php
			    foreach($customer_class as $key7 => $cs){
			      
			       if($key7 == 0 and !isset($cs['KUKLA'])){
				  continue;}
                                if($xcustomer_class == $cs['KUKLA']){
                                    echo "<option selected='selected' value='".$cs['KUKLA']."'>".$cs['KUKLA']." - ".$cs['VTEXT']."</option>";
                                }else{
                                    echo "<option  value='".$cs['KUKLA']."'>".$cs['KUKLA']." - ".$cs['VTEXT']."</option>";
                                }
				
			    }
			  ?>
			</select>
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label"><b>Industry Code 1</b></label>
		    <div class="controls">
			<select name="industry_code1" id="industry_code1" class="span6" placeholder="Industry Code1">
			  <option></option>
			  <?php
			    foreach($industry_code as $key6a => $ic){
			      if($key6a == 0 and !isset($ic['BRACO'])){
				  continue;}
				if($xindustry_code == $ic['BRACO']){
				  echo "<option selected='selected' value='".$ic['BRACO']."'>".$ic['BRACO']." - ".$ic['VTEXT']."</option>";
				}else{
				  echo "<option value='".$ic['BRACO']."'>".$ic['BRACO']." - ".$ic['VTEXT']."</option>";
				}
				
			    }
			  ?>
			</select>
			
		    </div>
		</div>
		<br/><br/>
		<div class="control-group">
		  <a data-toggle="tab" href="#tab3"><input type="button" id="btnNext2" name="btnNext2" value="Next" class="btn btn-primary pull-right"></a><br/>
		</div>
		<!--End Control Box-->
	      </div>
	    </div>
	  </div>
	</div><!--end tab2-->
	
        <div id="tab3" class="tab-pane"> <!--start tab 3-->
	  <div class="row-fluid">
	    <div class="widget-box">
	      <div class="widget-title">
		<span class="icon">
		  <i class="icon-info-sign"></i>									
		</span>
		<h5>CONTACT PERSON</h5>
              </div>
	      <div class="widget-content padding">
		<div class="row-fluid">
		  <div class="span12"> <!--start span 4-->
		      <div class="control-group">
			  <label class="control-label"><b>Title * | Name</b></label>
			  <div class="controls">
			      <select name="title_cp" id="title_cp" class="span4" placeholder="Title" >
				<option></option>
				<option value='Company'>Company</option>
				<option value='Mr.'>Mr.</option>
				<option value='Ms.'>Ms.</option>
				<option value='Mr. and Ms. '>Mr. and Mrs.</option>
			      </select>
			      <input style="margin-left:4px;" type="text" class="span4" maxlength="35" name="firstname_cp" id="firstname_cp" placeholder="First Name">
				<input  type="text" class="span4" name="name_cp" id="name_cp" maxlength="35" placeholder="Name">
				<br/>
			  </div>
		      </div>
		      <div class="control-group">
			  <label class="control-label"><b>Gender</b></label>
			  <div class="controls">
			      <select name="gender" id="gender" class="span12" placeholder="Gender">
				<option ></option>
				<option value="1">1 - Male</option>
				<option value="2">2 - Female</option>
			      </select><br/><br/>
			  </div>
		      </div>
		      <div class="control-group">
			  <label class="control-label"><b>Date of Birth</b></label>
			  <div class="controls">
			      <input type="text" readonly="readonly" data-date="01-02-2013" name="tgl_lahir" id="tgl_lahir" data-date-format="dd-mm-yyyy" class="datepicker" />
			  </div>
		      </div>
		      <div class="control-group">
			  <label class="control-label"><b>Telp | Ext</b></label>
			  <div class="controls">
			      <input type="text" class="span8" name="tlp_cp" id="tlp_cp" placeholder="Telp" maxlength="16">
			      <input type="text" class="span4" name="ext_cp" id="ext_cp" placeholder="Ext." maxlength="4">
			  </div>
		      </div>
		      <div class="control-group">
			  <label class="control-label"><b>Mobile Phone</b></label>
			  <div class="controls">
			      <input type="text" class="span12" name="hp_cp" id="hp_cp" maxlength="16">
			  </div>
		      </div>
		      <div class="control-group">
			  <label class="control-label"><b>Fax | Email</b></label>
			  <div class="controls">
			      <input type="text" class="span6" name="fax_cp" id="fax_cp" placeholder="Fax" maxlength="16">
			      <input type="text" class="span6" name="email_cp" id="email_cp" placeholder="Email" maxlength="30">
			  </div>
		      </div>
		      
		      <div class="control-group">
			  <label class="control-label"><b>Call Frequency</b></label>
			  <div class="controls">
			      <select name="call_frequency" id="call_frequency" class="span12" placeholder="Call Frequency">
				<option ></option>
				<?php
				  foreach($call_frequency as $key11 => $cfr){
				     if($key8 == 0 and !isset($cfr['BRYTH'])){
					continue;}
				      if($cfr['BRYTH'] > 2000){
					echo "<option value='".$cfr['BRYTH']."'>".$cfr['BRYTH']." - ".$cfr['VTEXT']."</option>";

				      }
				  }
				?>
			      </select><br/><br/>
			  </div>
		      </div>
		      <div class="control-group">
			  <label class="control-label"><b>Register Date</b></label>
			  <div class="controls">
			      <input type="text" readonly="readonly" data-date="01-02-2013" name="tgl_register" id="tgl_register" data-date-format="dd-mm-yyyy" class="datepicker" />
			  </div>
		      </div>
		      <div class="control-group">
			  <label class="control-label"><b>Departement</b></label>
			  <div class="controls">
			      <select name="departemen" id="departemen" class="span12" placeholder="Departement">
				<option ></option>
				<?php
				  foreach($departemen as $key8 => $dep){
				     if($key8 == 0 and !isset($dep['ABTNR'])){
					continue;}
				      echo "<option value='".$dep['ABTNR']."'>".$dep['ABTNR']." - ".$dep['VTEXT']."</option>";
				  }
				?>
			      </select><br/><br/>
			  </div>
		      </div>
		      <div class="control-group">
			  <label class="control-label"><b>Function</b></label>
			  <div class="controls">
			      <select name="function" id="function" class="span12" placeholder="Function">
				<option ></option>
				<?php
				  foreach($function as $key9 => $f){
				    if($key9 == 0 and !isset($f['PAFKT'])){
					continue;}
				      echo "<option value='".$f['PAFKT']."'>".$f['PAFKT']." - ".$f['VTEXT']."</option>";
				  }
				?>
			      </select>
			  </div>
		      </div>
		      <br/><br/>
		      <input type="button" name="btnAdd" id="btnAdd" value="Save Contact Person" class="btn btn-success pull-right">
		     <br/><br/>
		  </div>
		  
		</div>
		<div class="row-fluid">
		  <div class="span12"> <!--start span 8-->
		    <div id="tabel_cp">
		      <table class="table table-bordered table-striped">
			<thead>
			<tr>
			  <th>No.</th>
			  <th>Title</th>
			  <th>First Name</th>
			  <th>Name</th>
			  <th>Gender</th>
			  <th>Telepon/Ext</th>
			  <th>Mobile Phone</th>
			  <th>Fax</th>
			  <th>Email</th>
			  <th>Date of Birth</th>
			  <th>Call Frequency</th>
			  <th>Date Reg.</th>
			  <th>Dept.</th>
			  <th>Func.</th>
			  <th>Del</th>
			</tr>
			</thead>
		      </table>
		    </div>
		  </div>
		</div>
		<div class="control-group">
		  <a data-toggle="tab" href="#tab4"><input type="button" id="btnNext3" name="btnNext3" value="Next" class="btn btn-primary pull-right"></a><br/>
		</div>
	      </div>
	    </div>
	  </div>
	</div><!--end tab3-->
	
	<div id="tab4" class="tab-pane"> <!--start tab4-->
	  <div class="row-fluid">
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
		    <label class="control-label"><b>Sales Office </b></label>
		    <div class="controls">
		       <select name="sales_office" id="sales_office" class="span6" placeholder="Sales Office">
			      <option></option>
			      <?php
				foreach($sales_office as $key11 => $sof){
				  
				   if($key11 == 0 and !isset($sof['VKBUR'])){
				      continue;}
				    $nn=substr($sof['VKBUR'],0,1);
				    
				    if($xc == $nn){
					if($xsales_office == $sof['VKBUR']){
					    echo "<option selected='selected' value='".$sof['VKBUR']."'>".$sof['VKBUR']." - ".$sof['BEZEI']."</option>";
					}else{
					    echo "<option  value='".$sof['VKBUR']."'>".$sof['VKBUR']." - ".$sof['BEZEI']."</option>";
					}
				    }
                                    
				    
				}
			      ?>
			</select><br/><br/>
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label"><b>Customer Group </b></label>
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
                                        echo "<option  value='".$cg['KDGRP']."'>".$cg['KDGRP']." - ".$cg['KTEXT']."</option>";
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
                                    if($xcurr == $cur['WAERS']){
                                        echo "<option selected='selected' value='".$cur['WAERS']."'>".$cur['WAERS']." - ".$cur['LTEXT']."</option>";
                                    }else{
                                        echo "<option  value='".$cur['WAERS']."'>".$cur['WAERS']." - ".$cur['LTEXT']."</option>";
                                    }
				    
				}
			      ?>
			</select><br/><br/>
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label"><b>Incoterm</b></label>
		    <div class="controls">
			<select name="incoterm" id="incoterm" class="span6" placeholder="Incoterm">
			      <option></option>
			      <?php
				foreach($incoterm as $key14 => $inc){
				  if($key14 == 0 and !isset($inc['INCO1'])){
				      continue;}
                                    if($xinco1 == $inc['INCO1']){
                                        echo "<option selected='selected' value='".$inc['INCO1']."'>".$inc['INCO1']." - ".$inc['BEZEI']."</option>";
                                    }else{
                                        echo "<option  value='".$inc['INCO1']."'>".$inc['INCO1']." - ".$inc['BEZEI']."</option>";
                                    }
				    
				}
			      ?>
			</select><br/><br/>
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label"><b>Description</b></label>
		    <div class="controls">
			<input type="text" value="<?php echo $xinco2; ?>" maxlength="25" class="span12" name="deskripsi" id="deskripsi">
		    </div>
		</div>
	      </div>
	    </div>
	  </div>
	  
	  <div class="form-actions">
              <input type="submit" value="SAVE" class="btn btn-success">
          </div>
	</form>
	</div><!--end tab4-->
	
	</div>
        </div>
      </div>
    
    </div>
    
  </div>
</div>

