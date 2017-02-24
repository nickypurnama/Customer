<script type="text/javascript">
function hapus(xnik, xsales, xdis, xdiv){
	//alert(id);
    jConfirm("Do you want delete role?", "VI|VE|RE", function(r) {
	if(r == true){
	    $.ajax({
		type: 'POST', 
		url: "<?php echo site_url('customer/hapus_priv'); ?>",
		data: {
                    nik : xnik,
                    sales_org : xsales,
                    dis_channel : xdis,
                    division : xdiv
                }, 
		cache: false,
		success: function(msg){
		    document.location='<?php echo site_url('customer/user_privilege'); ?>';
		}
	    });	
	}
    });

//}
//function load_sales(){
//    var xid = $("#company").val();
//    $.ajax({ 
//        type: 'POST', 
//        url: "<?php echo site_url('customer/get_sales_org'); ?>", 
//        data:"id="+xid , 
//        success: function(msg) {
//                $("#div_sales_org").html(msg);
//		$("#division").val("");
//		$("#dis_channel").val("");
//        }
//    });
//  }
//  function load_distribution_channel(){
//    var xsls = $("#sales_org").val();
//    var xcom = $("#sales_org").val();
//    
//    $.ajax({ 
//        type: 'POST', 
//        url: "<?php echo site_url('customer/get_distribution_channel'); ?>", 
//        data: {
//	    company : xcom,
//	    sales_org : xsls
//	}, 
//        success: function(msg) {
//                $("#div_dis_channel").html(msg);
//        }
//    });
//  }
//  
//  function load_division(){
//    var xsls = $("#sales_org").val();
//    var xcom = $("#sales_org").val();
//    var xdis = $("#dis_channel").val();
//    
//    $.ajax({ 
//        type: 'POST', 
//        url: "<?php echo site_url('customer/get_division'); ?>", 
//        data: {
//	    company : xcom,
//	    sales_org :xcom,
//	    dis_channel : xdis
//	}, 
//        success: function(msg) {
//                $("#div_division").html(msg);
//        }
//    });
//  }
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
	    
                <form class="form-horizontal" method="post" action="<?php echo site_url('customer/add_priv'); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate">
                    
                    <div class="control-group">
                        <label class="control-label">NIK</label>
                        <div class="controls">
                            <select name="nik" id="nik" class="span11" >
                                <option></option>
                                <?php
                                  foreach($nik_sso as $cs){
                                    
                                      echo "<option value='".$cs['NIK']."'>".$cs['NIK']." - ".$cs['NAMA']."</option>";
                                  }
                                ?>
                            </select>
                        </div>
                    </div>
                    
		    <div class="control-group">
                            <label class="control-label"><b>Sales Organization *</b></label>
                            <div class="controls">
			      <div id="div_sales_org">
				  <select name="sales_org" id="sales_org" class="span6" placeholder="Sales Organization" >
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
			      <div id="div_dis_channel">
				   <select name="dis_channel" id="dis_channel" class="span6" placeholder="Distribution Channel" >
				      <option></option>
				      <?php
					foreach($dis_channel as $key3 => $div){
						if($key3 == 0 and !isset($div['VTWEG'])){
						    continue;}
						    echo "<option value='".$div['VTWEG']."'>".$div['VTWEG']." - ".$div['VTEXT']."</option>";
					}
				      ?>
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
				      <?php
					foreach($division as $key4 => $diva){
						if($key4 == 0 and !isset($diva['SPART'])){
						    continue;}
						    echo "<option value='".$diva['SPART']."'>".$diva['SPART']." - ".$diva['VTEXT']."</option>";
					}
				      ?>
				</select><br/><br/>
			      </div>
                                
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
                  <th>NIK</th>
                  <th>NAME</th>
		  <th>SALES ORG</th>
                  <th>DIS. CHANNEL</th>
                  <th>DIVISION</th>
                 
                  <th width='6%'>Hapus</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    if(isset($row)){
                        $no=1;
                        foreach($row as $a){
			    $url_edit= "customer/form_edit_priv/".$a['NIK']."/".$a['SALES_ORG']."/".$a['DIS_CHANNEL']."/".$a['DIVISION'];
                            $nik=$a['NIK'];
                            $sales_org=$a['SALES_ORG'];
                            $dis_channel=$a['DIS_CHANNEL'];
                            $division=$a['DIVISION'];
                            
                            echo "<tr>
                                    <td style='text-align:center'>".$no."</td>
                                   
                                    <td >".$a['NIK']."</td>
                                    <td >".$a['NAME']."</td>
				    <td >".$a['SALES_ORG']."</td>
                                    <td >".$a['DIS_CHANNEL']."</td>
                                     <td >".$a['DIVISION']."</td>
                                     
                                   
                                    <td style='text-align:center'>
                                        <a class='tip-top' data-original-title='Delete' href='javascript:hapus(\"$nik\",\"$sales_org\",\"$dis_channel\",\"$division\");'>
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

