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

<script type="text/javascript">
$(document).ready(function() {
      $("#btnGet").click(function(){
	  $("#spinner").show();
      });
      
});
</script>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="<?php echo site_url('home/index'); ?>" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
         <a  href="#">Customer</a>
	<a class="current" href="#">Change Contact Person (Input Cust. Account)</a>
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
	    
                <form class="form-horizontal" method="post" action="<?php echo site_url('customer/list_contact_person'); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate">
                    
                    <div class="control-group">
                        <label class="control-label">Cust. Account</label>
                        <div class="controls">
                            <input type="text" name="cust_account" id="cust_account" onchange="change_id();" maxlength="10" class="span11" placeholder="ex : 1105392 (10 char)">
                        </div>
                    </div>
                       
                    <div class="form-actions">
                        <input type="submit" value="Get Contact Person" id="btnGet" name="btnGet" class="btn btn-success">
                    </div>
                </form>
	</div>
        </div>
      </div>
   
    </div>
    
  </div>
</div>

