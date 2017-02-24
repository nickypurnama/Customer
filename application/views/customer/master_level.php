<script type="text/javascript">
function hapus(id){
	//alert(id);
    jConfirm("Do you want delete level approval?", "VI|VE|RE", function(r) {
	if(r == true){
	    $.ajax({
		type: 'POST', 
		url: "<?php echo site_url('customer/hapus_level'); ?>",
		data: "id="+id,
		cache: false,
		success: function(msg){
		    document.location='<?php echo site_url('customer/master_level'); ?>';
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
	<a class="current" href="#">Level Approval</a>
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
        <div class="span5"> 
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-tasks"></i></span>
                <h5>Form</h5>
                <div class="buttons"></div>
            </div>

            <div class="widget-content nopadding">
	    
                <form class="form-horizontal" method="post" action="<?php echo site_url('customer/add_level'); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate">
                    
                    <div class="control-group">
                        <label class="control-label">NIK</label>
                        <div class="controls">
                            <input type="text" name="nik" id="nik" class="span11">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">NIK Approval (Accounting)</label>
                        <div class="controls">
                            <input type="text" name="app" id="app" class="span11">
                        </div>
                    </div>
		    
                    <div class="form-actions">
                        <input type="submit" value="Simpan" class="btn btn-success">
                    </div>
                </form>
	</div>
        </div>
      </div>
    <div class="span7">
      <div class="widget-box">
          <div class="widget-title">
             <span class="icon"><i class="icon-th"></i></span> 
            <h5>Daftar Level Approval</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th width="5%">No.</th>
                  <th>NIK</th>
		  <th>User Approval</th>
                  <th width='6%'>Edit</th>
                  <th width='6%'>Hapus</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    if(isset($row)){
                        $no=1;
                        foreach($row as $a){
			    $url_edit= "customer/form_edit_level/".$a['NIK'];
                            $nik=$a['NIK'];
                            echo "<tr>
                                    <td style='text-align:center'>".$no."</td>
                                   
                                    <td >".$a['NIK']."</td>
				     <td >".$a['APP2']."</td>
                                    
                                    <td style='text-align:center'>
                                        <a class='tip-top' data-original-title='Update' href='".site_url($url_edit)."'>
                                            <i class='icon-pencil'></i>
                                        </a>
                                    </td>
                                    <td style='text-align:center'>
                                        <a class='tip-top' data-original-title='Delete' href='javascript:hapus(\"$nik\");'>
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

