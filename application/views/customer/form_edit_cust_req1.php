<script type="text/javascript">
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
</script>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="<?php echo site_url('home/index'); ?>" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
         <a  href="#">Customer</a>
	<a class="current" href="#">Change Customer Request (Input Cust. Account)</a>
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
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-tasks"></i></span>
                <h5>Input Cust. Account</h5>
                <div class="buttons"></div>
            </div>

            <div class="widget-content nopadding">
	    
                <form class="form-horizontal" method="post" action="<?php echo site_url('customer/form_edit_cust_req2'); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate">
                    
                    <div class="control-group">
                        <label class="control-label">Cust. Account</label>
                        <div class="controls">
                            <input type="text" name="cust_account" id="cust_account" onchange="change_id();" maxlength="10" class="span11" placeholder="ex : 1105392 (10 char)">
                        </div>
                    </div>
                    <div class="control-group">
                            <label class="control-label"><b>Company Code</b></label>
                            <div class="controls">
                                <select name="company" id="company" class="span6" placeholder="Company Code" onchange="load_sales();">
				      <option></option>
				      <?php
					foreach($company as $key1 => $com){
					  
					  if($key1 == 0 and $com['BUKRS'] == ''){
					      continue;}
					  
					  if($com['LAND1'] == 'ID'){
					    echo "<option value='".$com['BUKRS']."'>".$com['BUKRS']." - ".$com['BUTXT']."</option>";
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
				  <select name="sales_org" id="sales_org" class="span6" placeholder="Sales Organization" onchange="load_distribution_channel();">
				      <option></option>
				</select><br/><br/>
			      </div>
                               
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><b>Distribution Channel *</b></label>
                            <div class="controls">
			      <div id="div_dis_channel">
				   <select name="dis_channel" id="dis_channel" class="span6" placeholder="Distribution Channel" onchange="load_division();">
				      <option></option>
				      
				    </select><br/><br/>
			      </div>
                              
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><b>Division *</b></label>
                            <div class="controls">
			      <div id="div_division">
				<select name="division" id="division" class="span6" placeholder="Division" >
				      <option></option>
				      
				</select><br/><br/>
			      </div>
                                
                            </div>
			    
                        </div>
                    <div class="form-actions">
                        <input type="submit" value="Change" class="btn btn-success">
                    </div>
                </form>
	</div>
        </div>
      </div>
   
    </div>
    
  </div>
</div>

