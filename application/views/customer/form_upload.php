<script type="text/javascript">
$(document).ready(function() {
      $("#btn_upload1").click(function(){
	  $("#spinner").show();
      });
      $("#btn_upload2").click(function(){
	  $("#spinner").show();
      });
});
</script>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="<?php echo site_url('home/index'); ?>" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
         <a  href="#">Customer Request</a>
	<a class="current" href="#">Upload Data</a>
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
                <h5>Upload New Customer</h5>
                <div class="buttons"></div>
            </div>

            <div class="widget-content nopadding">
	    
                <form class="form-horizontal" method="post" action="<?php echo site_url('customer/upload_new_customer'); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate" enctype="multipart/form-data" >
                    <div class="control-group">
                            <label class="control-label">Template</label>
                            <div class="controls">
                                    <a href="<?php echo base_url()."temp/format/format_upload_new.xls"; ?>"><img src="<?php echo base_url()."img/excel.png"; ?>"> Download Template New Customer</a>
                            </div>
                    </div>
                    <div class="control-group">
                            <label class="control-label">File New Customer</label>
                            <div class="controls">
                                    <input type="file" name="userfile" id="userfile" />
				    <br/>
				    File type must be ".XLS"
                            </div>
                    </div>
                    <div class="form-actions">
                        <input type="submit" value="Upload" id="btn_upload1" name="btn_upload1" class="btn btn-success">
                    </div>
                </form>
	</div>
        </div>
    </div>
    <div class="span6"> 
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-tasks"></i></span>
                <h5>Upload Extend Customer</h5>
                <div class="buttons"></div>
            </div>

            <div class="widget-content nopadding">
	    
                <form class="form-horizontal" method="post" action="<?php echo site_url('customer/upload_extend_customer'); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate" enctype="multipart/form-data">
                     <div class="control-group">
                            <label class="control-label">Template</label>
                            <div class="controls">
                                    <a href="<?php echo base_url()."temp/format/format_upload_extend.xls"; ?>"><img src="<?php echo base_url()."img/excel.png"; ?>"> Download Template Extend Customer</a>
                            </div>
                    </div>
                    <div class="control-group">
                            <label class="control-label">File Extend Customer</label>
                            <div class="controls">
                                    <input type="file" name="userfile" id="userfile" />
				     <br/>
				    File type must be ".XLS"
                            </div>
                    </div>
                    <div class="form-actions">
                        <input type="submit" value="Upload" id="btn_upload2" name="btn_upload2" class="btn btn-success">
                    </div>
                </form>
	</div>
        </div>
    </div>
    </div>
    
    </div>
</div>

