<script type="text/javascript">
function hapus(xcompany, xsales, xdis, xdiv){
	//alert(id);
    jConfirm("Do you want delete role?", "VI|VE|RE", function(r) {
	if(r == true){
	    $.ajax({
		type: 'POST', 
		url: "<?php echo site_url('customer/hapus_konfigurasi'); ?>",
		data: {
                    company : xcompany,
                    sales_org : xsales,
                    dis_channel : xdis,
                    division : xdiv
                }, 
		cache: false,
		success: function(msg){
		    document.location='<?php echo site_url('customer/konfigurasi'); ?>';
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
         <a  href="#">Master</a>
	<a class="current" href="#">User Role</a>
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
        <div class="span6"> 
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-tasks"></i></span>
                <h5>Form</h5>
                <div class="buttons"></div>
            </div>

            <div class="widget-content nopadding">
	    
                <form class="form-horizontal" method="post" action="<?php echo site_url('customer/add_konfigurasi'); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate">
                    
                    <div class="control-group">
                        <label class="control-label">Company Code</label>
                        <div class="controls">
                            <select name="company" id="company" class="span11" >
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
                                      <?php
                                        foreach($sales_org as $key => $sls){
                                            if($key == 0 and !isset($sls['VKORG']) ){
                                                    continue;}
                                                    echo "<option value='".$sls['VKORG']."'>".$sls['VKORG']." - ".$sls['VTEXT']."</option>";
                                        }
                        
                                      ?>
				</select><br/><br/>
			      </div>
                               
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><b>Distribution Channel *</b></label>
                            <div class="controls">
			      
				   <select name="dis_channel" id="dis_channel" class="span10" placeholder="Distribution Channel" onchange="load_division();">
				      <option></option>
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
                            <label class="control-label"><b>Division *</b></label>
                            <div class="controls">
			      
				<select name="division" id="division" class="span10" placeholder="Division" >
				      <option></option>
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
                        <div class="control-group">
                            <label class="control-label"><b>Cust. Reference *</b></label>
                            <div class="controls">
                                <input type="text" name="cust" id="cust" class="span6">
                                
                            </div>
			    
                        </div>
                    <div class="form-actions">
                        <input type="submit" value="Save" class="btn btn-success">
                    </div>
                </form>
	</div>
        </div>
      </div>
    <div class="span6">
      <div class="widget-box">
          <div class="widget-title">
             <span class="icon"><i class="icon-th"></i></span> 
            <h5>User Role</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th width="5%">No.</th>
                  <th>COMPANY CODE</th>
		  <th>SALES ORG</th>
                  <th>DIS. CHANNEL</th>
                  <th>DIVISION</th>
                    <th>CUST. REF.</th>
                  <th width='6%'>Hapus</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    if(isset($row)){
                        $no=1;
                        foreach($row as $a){
			    //$url_edit= "customer/form_edit_priv/".$a['NIK']."/".$a['SALES_ORG']."/".$a['DIS_CHANNEL']."/".$a['DIVISION'];
                            $company=$a['COMPANY_CODE'];
                            $sales_org=$a['SALES_ORG'];
                            $dis_channel=$a['DIS_CHANNEL'];
                            $division=$a['DIVISION'];
                            
                            echo "<tr>
                                    <td style='text-align:center'>".$no."</td>
                                    <td >".$a['COMPANY_CODE']."</td>
				    <td >".$a['SALES_ORG']."</td>
                                    <td >".$a['DIS_CHANNEL']."</td>
                                     <td >".$a['DIVISION']."</td>
                                     <td >".$a['CUST_REF']."</td>
                                    <td style='text-align:center'>
                                        <a class='tip-top' data-original-title='Delete' href='javascript:hapus(\"$company\",\"$sales_org\",\"$dis_channel\",\"$division\");'>
                                            <i class='icon-remove'></i>
                                        </a>
                                    </td>
                                </tr>";
                            $no++;
                        } 
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

