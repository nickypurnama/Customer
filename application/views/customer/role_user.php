<script type="text/javascript">
function hapus(xnik, xrole){
	//alert(id);
    jConfirm("Do you want delete role?", "VI|VE|RE", function(r) {
	if(r == true){
	    $.ajax({
		type: 'POST', 
		url: "<?php echo site_url('customer/hapus_role'); ?>",
		data: {
                    nik : xnik,
                    role : xrole
                }, 
		cache: false,
		success: function(msg){
		    document.location='<?php echo site_url('customer/role_user'); ?>';
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
	    
                <form class="form-horizontal" method="post" action="<?php echo site_url('customer/add_role'); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate">
                    
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
                        <label class="control-label">Role</label>
                        <div class="controls">
                            <select name="role" id="role" class="span11">
				<option></option>
				<option value="ADMINISTRATOR">ADMINISTRATOR</option>
				<option value="APPROVAL">APPROVAL</option>
				<option value="MASTERDATA">MASTERDATA</option>
				<option value="REQUESTER">REQUESTER</option>
			    </select>
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
		  <th>Role</th>
                  <th width='6%'>Edit</th>
                  <th width='6%'>Hapus</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    if(isset($row)){
                        $no=1;
                        foreach($row as $a){
			    $url_edit= "customer/form_edit_role/".$a['NIK']."/".$a['ROLE'];
                            $nik=$a['NIK'];
                            $role=$a['ROLE'];
                            if($a['ROLE'] == "REQUESTER"){
				$arole = "REQUESTOR";
			    }else{
				$arole = $role=$a['ROLE'];;
			    }
                            echo "<tr>
                                    <td style='text-align:center'>".$no."</td>
                                   
                                    <td >".$a['NIK']."</td>
                                    <td >".$a['NAME']."</td>
				     <td >".$arole."</td>
                                    
                                    <td style='text-align:center'>
                                        <a class='tip-top' data-original-title='Update' href='".site_url($url_edit)."'>
                                            <i class='icon-pencil'></i>
                                        </a>
                                    </td>
                                    <td style='text-align:center'>
                                        <a class='tip-top' data-original-title='Delete' href='javascript:hapus(\"$nik\",\"$role\");'>
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

