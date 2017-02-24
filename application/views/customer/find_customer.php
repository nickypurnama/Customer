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
</script>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="<?php echo site_url('home/index'); ?>" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
	<a class="current" href="#">Find Customer</a>
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
    <div class="row-fluid">
        <div class="span8"> 
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-tasks"></i></span>
                <h5>Search</h5>
                <div class="buttons"></div>
            </div>

            <div class="widget-content nopadding">
	    
                <form class="form-horizontal" method="post" action="<?php echo site_url('customer/find_cust_proses2'); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate">
                    
                    <div class="control-group">
                        <label class="control-label">Customer Name</label>
                        <div class="controls">
                            <input type="text" name="name_find" id="name_find" class="span11" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Sales Org.</label>
                        <div class="controls">
                            <select name="sales_org" id="sales_org" class="span6" placeholder="Sales Organization">
                                <option value="ALL">All</option>
                                <?php
                                
                                  foreach($sales_org as $key2a => $sls){
                                    
                                    if($key2a == 0 and !isset($sls['VKORG'])){
                                        continue;}
                                      
                                    echo "<option value='".$sls['VKORG']."'>".$sls['VKORG']." - ".$sls['VTEXT']."</option>";
                                  }
                                ?>
				</select><br/><br/>
                        </div>
                    </div>
		    <div class="control-group">
                        <label class="control-label">Dist.Channel</label>
                        <div class="controls">
                            <select name="dis_channel" id="dis_channel" class="span6" placeholder="Distribution Channel">
                                <option value="ALL">All</option>
                                <?php
                                
                                  foreach($dis_channel as $key2 => $dis){
                                    
                                    if($key2 == 0 and !isset($dis['VTWEG'])){
                                        continue;}
                                      
                                    echo "<option value='".$dis['VTWEG']."'>".$dis['VTWEG']." - ".$dis['VTEXT']."</option>";
                                  }
                                ?>
                            </select><br/><br/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Division</label>
                        <div class="controls">
                            <select name="division" id="division" class="span6" placeholder="Division">
                                <option value="ALL">All</option>
                                <?php
                                  foreach($division as $key3 => $div){
                                    
                                    if($key3 == 0 and !isset($div['SPART'])){
                                        continue;}
                                      
                                      echo "<option value='".$div['SPART']."'>".$div['SPART']." - ".$div['VTEXT']."</option>";
                                  }
                                ?>
			    </select><br/><br/>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <input type="submit" value="Search" class="btn btn-success">
                    </div>
                </form>
	</div>
        </div>
      </div>
            <div class="span4"> 
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-tasks"></i></span>
                <h5>Search By Cust. Account</h5>
                <div class="buttons"></div>
            </div>

            <div class="widget-content nopadding">
	    
                <form class="form-horizontal" method="post" action="<?php echo site_url('customer/find_cust_proses'); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate">
                    <div class="control-group">
                        <label class="control-label">Cust. Account</label>
                        <div class="controls">
                            <input type="text" name="cust_account" id="cust_account" class="span11" onchange="change_id()" placeholder="ex : 0001105392 (10 char)" maxlength="10" >
                        </div>
                    </div>
                    
                    
                    <div class="form-actions">
                        <input type="submit" value="Search" class="btn btn-success">
                    </div>
                </form>
	</div>
        </div>
      </div>
    </div>
    
  </div>
</div>

