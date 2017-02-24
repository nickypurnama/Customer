<script type="text/javascript">

</script>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="<?php echo site_url('home/index'); ?>" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
         <a  href="#">Master</a>
	<a class="current" href="#">Email Setting</a>
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
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"><span class="icon"><i class="icon-tasks"></i></span>
                <h5>Setting</h5>
                <div class="buttons"></div>
                </div>
                <div class="widget-content nopadding">
                     <form class="form-horizontal" method="post" action="<?php echo site_url('customer/save_email_config'); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate">
                        <div class="control-group">
                               <label class="control-label"><b>URL App.  </b></label>
                               <div class="controls">
                                   <input type="text" name="url" class="span11" id="url" value="<?php echo $url; ?>">
                                   
                               </div>
                        </div>
                        <div class="control-group">
                               <label class="control-label"><b>Email Host  </b></label>
                               <div class="controls">
                                   <input type="text" name="host" class="span11" id="host" value="<?php echo $smtp_host; ?>">
                                   
                               </div>
                        </div>
                        <div class="control-group">
                               <label class="control-label"><b>Email Port  </b></label>
                               <div class="controls">
                                   <input type="text" name="port" class="span2" id="port" value="<?php echo $smtp_port; ?>">
                                   
                               </div>
                        </div>
                        <div class="control-group">
                               <label class="control-label"><b>Email User  </b></label>
                               <div class="controls">
                                   <input type="text" name="user" class="span11" id="user" value="<?php echo $smtp_user; ?>">
                                   
                               </div>
                        </div>
                        <div class="control-group">
                               <label class="control-label"><b>Email Password  </b></label>
                               <div class="controls">
                                   <input type="password" name="pass" class="span11" id="pass" value="<?php echo $smtp_password; ?>">
                               </div>
                        </div>
                        <div class="form-actions">
                        <input type="submit" value="Save" class="btn btn-success">
                    </div>
                     </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span6">
            <div class="widget-box">
                <div class="widget-title"><span class="icon"><i class="icon-tasks"></i></span>
                <h5>Template Upload New Customer</h5>
                <div class="buttons"></div>
                </div>
                <div class="widget-content nopadding">
                     <form class="form-horizontal" method="post" action="<?php echo site_url('customer/upload_setting_new'); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate" enctype="multipart/form-data">
                        <div class="control-group">
                               <label class="control-label"><b>Template  </b></label>
                               <div class="controls">
                                  <a href="<?php echo base_url()."temp/format/format_upload_new.xls"; ?>"><img src="<?php echo base_url()."img/excel.png"; ?>"> Template New Customer</a>
                               </div>
                        </div>
                        <div class="control-group">
                               <label class="control-label"><b>Upload Template  </b></label>
                               <div class="controls">
                                   <input type="file" name="userfile" id="userfile" />
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
                <div class="widget-title"><span class="icon"><i class="icon-tasks"></i></span>
                <h5>Setting</h5>
                <div class="buttons"></div>
                </div>
                <div class="widget-content nopadding">
                     <form class="form-horizontal" method="post" action="<?php echo site_url('customer/upload_setting_extend'); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate" enctype="multipart/form-data">
                        <div class="control-group">
                                <label class="control-label"><b>Template  </b></label>
                               <div class="controls">
                                  <a href="<?php echo base_url()."temp/format/format_upload_extend.xls"; ?>"><img src="<?php echo base_url()."img/excel.png"; ?>"> Template Extend Customer</a>
                               </div>
                        </div>
                        <div class="control-group">
                               <label class="control-label"><b>Upload Template  </b></label>
                               <div class="controls">
                                   <input type="file" name="userfile" id="userfile" />
                               </div>
                        </div>
                        <div class="form-actions">
                        <input type="submit" value="Save" class="btn btn-success">
                    </div>
                     </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid">
    <div class="span4"> 
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-tasks"></i></span>
                <h5>Email Posting New Customer</h5>
                <div class="buttons"></div>
            </div>

            <div class="widget-content nopadding">
	    
                <form class="form-horizontal" method="post" action="<?php echo site_url('customer/save_email_posting_new'); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate">
                    
                    <div class="control-group">
                            <label class="control-label"><b>Subject  </b></label>
                            <div class="controls">
                                <input type="text" name="subject_posting_new" class="span11" id="subject_posting_new" value="<?php echo $subject_posting_new; ?>">
				  <input type="hidden" name="id"  id="id" value="1">
				
                            </div>
                    </div>
                    <div class="control-group">
                            <label class="control-label"><b>Header  </b></label>
                            <div class="controls">
                                <textarea id="header_posting_new" rows="5"  class="span11" name="header_posting_new"><?php echo $header_new_post; ?></textarea>
                                
                            </div>
                    </div>
                     <div class="control-group">
                            <label class="control-label"><b>Body  </b></label>
                            <div class="controls">
                                <textarea id="body_posting_new" rows="5"  class="span11" name="body_posting_new"><?php echo $body_new_post; ?></textarea>
                                
                            </div>
                    </div>
                     <div class="control-group">
                            <label class="control-label"><b>Footer </b></label>
                            <div class="controls">
                                <textarea rows="5" id="footer_posting_new" class="span11" name="footer_posting_new"><?php echo $footer_new_post; ?></textarea>
                                
                            </div>
                    </div>
                    <div class="form-actions">
                        <input type="submit" value="Save" class="btn btn-success">
                    </div>
                </form>
	</div>
        </div>
    </div>
    <div class="span4"> 
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-tasks"></i></span>
                <h5>Email Approval New Customer</h5>
                <div class="buttons"></div>
            </div>

            <div class="widget-content nopadding">
	    
                <form class="form-horizontal" method="post" action="<?php echo site_url('customer/save_email_approval_new'); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate">
                    
                    <div class="control-group">
                            <label class="control-label"><b>Subject </b></label>
                            <div class="controls">
                                <input type="text" name="subject_approve_new" class="span11" id="subject_approve_new" value="<?php echo $subject_approve_new; ?>">
				  <input type="hidden" name="id"  id="id" value="1">
				
                            </div>
                    </div>
                    <div class="control-group">
                            <label class="control-label"><b>Header </b></label>
                            <div class="controls">
                                <textarea id="header_approve_new" rows="5"  class="span11" name="header_approve_new"><?php echo $header_new_approve; ?></textarea>
                                
                            </div>
                    </div>
                    <div class="control-group">
                            <label class="control-label"><b>Body </b></label>
                            <div class="controls">
                                <textarea id="body_approve_new" rows="5"  class="span11" name="body_approve_new"><?php echo $body_new_approve; ?></textarea>
                                
                            </div>
                    </div>
                     <div class="control-group">
                            <label class="control-label"><b>Footer </b></label>
                            <div class="controls">
                                <textarea rows="5" id="footer_approve_new" class="span11" name="footer_approve_new"><?php echo $footer_new_approve; ?></textarea>
                                
                            </div>
                    </div>
                    <div class="form-actions">
                        <input type="submit" value="Save" class="btn btn-success">
                    </div>
                </form>
	</div>
        </div>
    </div>
    <div class="span4"> 
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-tasks"></i></span>
                <h5>Email Transport New Customer</h5>
                <div class="buttons"></div>
            </div>

            <div class="widget-content nopadding">
	    
                <form class="form-horizontal" method="post" action="<?php echo site_url('customer/save_email_transport_new'); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate">
                    
                    <div class="control-group">
                            <label class="control-label"><b>Subject  </b></label>
                            <div class="controls">
                                <input type="text" name="subject_transport_new" class="span11" id="subject_transport_new" value="<?php echo $subject_transport_new; ?>">
				  <input type="hidden" name="id"  id="id" value="1">
				
                            </div>
                    </div>
                    <div class="control-group">
                            <label class="control-label"><b>Header  </b></label>
                            <div class="controls">
                                <textarea id="header_transport_new" rows="5"  class="span11" name="header_transport_new"><?php echo $header_new_transport; ?></textarea>
                                
                            </div>
                    </div>
                    <div class="control-group">
                            <label class="control-label"><b>Body  </b></label>
                            <div class="controls">
                                <textarea rows="5" id="body_transport_new" class="span11" name="body_transport_new"><?php echo $body_new_transport; ?></textarea>
                                
                            </div>
                    </div>
                     <div class="control-group">
                            <label class="control-label"><b>Footer </b></label>
                            <div class="controls">
                                <textarea rows="5" id="footer_transport_new" class="span11" name="footer_transport_new"><?php echo $footer_new_transport; ?></textarea>
                                
                            </div>
                    </div>
                    <div class="form-actions">
                        <input type="submit" value="Save" class="btn btn-success">
                    </div>
                </form>
	</div>
        </div>
    </div>
    
    </div>
    
    
    <div class="row-fluid">
    <div class="span4"> 
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-tasks"></i></span>
                <h5>Email Posting Extend Customer</h5>
                <div class="buttons"></div>
            </div>

            <div class="widget-content nopadding">
	    
                <form class="form-horizontal" method="post" action="<?php echo site_url('customer/save_email_posting_extend'); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate">
                    
                    <div class="control-group">
                            <label class="control-label"><b>Subject </b></label>
                            <div class="controls">
                                <input type="text" name="subject_posting_extend" class="span11" id="subject_posting_extend" value="<?php echo $subject_posting_ex; ?>">
				  <input type="hidden" name="id"  id="id" value="1">
				
                            </div>
                    </div>
                    <div class="control-group">
                            <label class="control-label"><b>Header </b></label>
                            <div class="controls">
                                <textarea id="header_posting_extend" rows="5"  class="span11" name="header_posting_extend"><?php echo $header_ex_post; ?></textarea>
                                
                            </div>
                    </div>
                    <div class="control-group">
                            <label class="control-label"><b>Body </b></label>
                            <div class="controls">
                                <textarea id="body_posting_extend" rows="5"  class="span11" name="body_posting_extend"><?php echo $body_ex_post; ?></textarea>
                                
                            </div>
                    </div>
                     <div class="control-group">
                            <label class="control-label"><b>Footer </b></label>
                            <div class="controls">
                                <textarea rows="5" id="footer_post_extend" class="span11" name="footer_post_extend"><?php echo $footer_ex_post; ?></textarea>
                                
                            </div>
                    </div>
                    <div class="form-actions">
                        <input type="submit" value="Save" class="btn btn-success">
                    </div>
                </form>
	</div>
        </div>
    </div>
    
    <div class="span4"> 
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-tasks"></i></span>
                <h5>Email Approval Extend Customer</h5>
                <div class="buttons"></div>
            </div>

            <div class="widget-content nopadding">
	    
                <form class="form-horizontal" method="post" action="<?php echo site_url('customer/save_email_approval_extend'); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate">
                    
                    <div class="control-group">
                            <label class="control-label"><b>Subject </b></label>
                            <div class="controls">
                                <input type="text" name="subject_approve_extend" class="span11" id="subject_approve_extend" value="<?php echo $subject_approve_ex; ?>">
				  <input type="hidden" name="id"  id="id" value="1">
				
                            </div>
                    </div>
                    <div class="control-group">
                            <label class="control-label"><b>Header </b></label>
                            <div class="controls">
                                <textarea id="header_approve_extend" rows="5"  class="span11" name="header_approve_extend"><?php echo $header_ex_approve; ?></textarea>
                                
                            </div>
                    </div>
                    <div class="control-group">
                            <label class="control-label"><b>Body </b></label>
                            <div class="controls">
                                <textarea id="body_approve_extend" rows="5"  class="span11" name="body_approve_extend"><?php echo $body_ex_approve; ?></textarea>
                                
                            </div>
                    </div>
                     <div class="control-group">
                            <label class="control-label"><b>Footer </b></label>
                            <div class="controls">
                                <textarea rows="5" id="footer_approve_extend" class="span11" name="footer_approve_extend"><?php echo $footer_ex_approve; ?></textarea>
                                
                            </div>
                    </div>
                    <div class="form-actions">
                        <input type="submit" value="Save" class="btn btn-success">
                    </div>
                </form>
	</div>
        </div>
    </div>
    <div class="span4"> 
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-tasks"></i></span>
                <h5>Email Transport Extend Customer</h5>
                <div class="buttons"></div>
            </div>

            <div class="widget-content nopadding">
	    
                <form class="form-horizontal" method="post" action="<?php echo site_url('customer/save_email_transport_extend'); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate">
                    
                    <div class="control-group">
                            <label class="control-label"><b>Subject Transport</b></label>
                            <div class="controls">
                                <input type="text" name="subject_transport_extend" class="span11" id="subject_transport_extend" value="<?php echo $subject_transport_ex; ?>">
				  <input type="hidden" name="id"  id="id" value="1">
				
                            </div>
                    </div>
                    <div class="control-group">
                            <label class="control-label"><b>Header Transport </b></label>
                            <div class="controls">
                                <textarea id="header_transport_extend" rows="5"  class="span11" name="header_transport_extend"><?php echo $header_ex_transport; ?></textarea>
                                
                            </div>
                    </div>
                    <div class="control-group">
                            <label class="control-label"><b>Body Transport </b></label>
                            <div class="controls">
                                <textarea id="body_transport_extend" rows="5"  class="span11" name="body_transport_extend"><?php echo $body_ex_transport; ?></textarea>
                                
                            </div>
                    </div>
                     <div class="control-group">
                            <label class="control-label"><b>Footer Transport</b></label>
                            <div class="controls">
                                <textarea rows="5" id="footer_transport_extend" class="span11" name="footer_transport_extend"><?php echo $footer_ex_transport; ?></textarea>
                                
                            </div>
                    </div>
                    <div class="form-actions">
                        <input type="submit" value="Save" class="btn btn-success">
                    </div>
                </form>
	</div>
        </div>
    </div>
    
    </div>
    
    <div class="row-fluid">
    <div class="span4"> 
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-tasks"></i></span>
                <h5>Email Posting Change Customer</h5>
                <div class="buttons"></div>
            </div>

            <div class="widget-content nopadding">
	    
                <form class="form-horizontal" method="post" action="<?php echo site_url('customer/save_email_posting_change'); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate">
                    
                    <div class="control-group">
                            <label class="control-label"><b>Subject </b></label>
                            <div class="controls">
                                <input type="text" name="subject_posting_change" class="span11" id="subject_posting_change" value="<?php echo $subject_posting_change; ?>">
				  <input type="hidden" name="id"  id="id" value="1">
				
                            </div>
                    </div>
                    <div class="control-group">
                            <label class="control-label"><b>Header </b></label>
                            <div class="controls">
                                <textarea id="header_posting_change" rows="5"  class="span11" name="header_posting_change"><?php echo $header_change_post; ?></textarea>
                                
                            </div>
                    </div>
                    <div class="control-group">
                            <label class="control-label"><b>Body </b></label>
                            <div class="controls">
                                <textarea id="body_posting_change" rows="5"  class="span11" name="body_posting_change"><?php echo $body_change_post; ?></textarea>
                                
                            </div>
                    </div>
                     <div class="control-group">
                            <label class="control-label"><b>Footer </b></label>
                            <div class="controls">
                                <textarea rows="5" id="footer_posting_change" class="span11" name="footer_posting_change"><?php echo $footer_change_post; ?></textarea>
                                
                            </div>
                    </div>
                    <div class="form-actions">
                        <input type="submit" value="Save" class="btn btn-success">
                    </div>
                </form>
	</div>
        </div>
    </div>
    
    <div class="span4"> 
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-tasks"></i></span>
                <h5>Email Approval Change Customer</h5>
                <div class="buttons"></div>
            </div>

            <div class="widget-content nopadding">
	    
                <form class="form-horizontal" method="post" action="<?php echo site_url('customer/save_email_approval_change'); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate">
                    
                    <div class="control-group">
                            <label class="control-label"><b>Subject </b></label>
                            <div class="controls">
                                <input type="text" name="subject_approve_change" class="span11" id="subject_approve_change" value="<?php echo $subject_approve_change; ?>">
				  <input type="hidden" name="id"  id="id" value="1">
				
                            </div>
                    </div>
                    <div class="control-group">
                            <label class="control-label"><b>Header </b></label>
                            <div class="controls">
                                <textarea id="header_approve_change" rows="5"  class="span11" name="header_approve_change"><?php echo $header_change_approve; ?></textarea>
                                
                            </div>
                    </div>
                    <div class="control-group">
                            <label class="control-label"><b>Body </b></label>
                            <div class="controls">
                                <textarea id="body_approve_change" rows="5"  class="span11" name="body_approve_change"><?php echo $body_change_approve; ?></textarea>
                                
                            </div>
                    </div>
                     <div class="control-group">
                            <label class="control-label"><b>Footer </b></label>
                            <div class="controls">
                                <textarea rows="5" id="footer_approve_change" class="span11" name="footer_approve_change"><?php echo $footer_change_approve; ?></textarea>
                                
                            </div>
                    </div>
                    <div class="form-actions">
                        <input type="submit" value="Save" class="btn btn-success">
                    </div>
                </form>
	</div>
        </div>
    </div>
    <div class="span4"> 
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-tasks"></i></span>
                <h5>Email Transport Change Customer</h5>
                <div class="buttons"></div>
            </div>

            <div class="widget-content nopadding">
	    
                <form class="form-horizontal" method="post" action="<?php echo site_url('customer/save_email_transport_change'); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate">
                    
                    <div class="control-group">
                            <label class="control-label"><b>Subject</b></label>
                            <div class="controls">
                                <input type="text" name="subject_transport_change" class="span11" id="subject_transport_change" value="<?php echo $subject_transport_change; ?>">
				  <input type="hidden" name="id"  id="id" value="1">
				
                            </div>
                    </div>
                    <div class="control-group">
                            <label class="control-label"><b>Header </b></label>
                            <div class="controls">
                                <textarea id="header_transport_change" rows="5"  class="span11" name="header_transport_change"><?php echo $header_change_transport; ?></textarea>
                                
                            </div>
                    </div>
                    <div class="control-group">
                            <label class="control-label"><b>Body </b></label>
                            <div class="controls">
                                <textarea id="body_transport_change" rows="5"  class="span11" name="body_transport_change"><?php echo $body_change_transport; ?></textarea>
                                
                            </div>
                    </div>
                     <div class="control-group">
                            <label class="control-label"><b>Footer </b></label>
                            <div class="controls">
                                <textarea rows="5" id="footer_transport_change" class="span11" name="footer_transport_change"><?php echo $footer_change_transport; ?></textarea>
                                
                            </div>
                    </div>
                    <div class="form-actions">
                        <input type="submit" value="Save" class="btn btn-success">
                    </div>
                </form>
	</div>
        </div>
    </div>
    
    </div>
    <div class="row-fluid">
    
    
    <div class="span6"> 
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-tasks"></i></span>
                <h5>Email Posting Change Contact Person</h5>
                <div class="buttons"></div>
            </div>

            <div class="widget-content nopadding">
	    
                <form class="form-horizontal" method="post" action="<?php echo site_url('customer/save_email_cp_req'); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate">
                    
                    <div class="control-group">
                            <label class="control-label"><b>Subject </b></label>
                            <div class="controls">
                                <input type="text" name="subject_cp_req" class="span11" id="subject_cp_req" value="<?php echo $subject_cp_req; ?>">
				  <input type="hidden" name="id"  id="id" value="1">
				
                            </div>
                    </div>
                    <div class="control-group">
                            <label class="control-label"><b>Header </b></label>
                            <div class="controls">
                                <textarea id="header_cp_req" rows="5"  class="span11" name="header_cp_req"><?php echo $header_cp_req; ?></textarea>
                                
                            </div>
                    </div>
                    <div class="control-group">
                            <label class="control-label"><b>Body </b></label>
                            <div class="controls">
                                <textarea id="body_cp_req" rows="5"  class="span11" name="body_cp_req"><?php echo $body_cp_req; ?></textarea>
                                
                            </div>
                    </div>
                     <div class="control-group">
                            <label class="control-label"><b>Footer </b></label>
                            <div class="controls">
                                <textarea rows="5" id="footer_cp_req" class="span11" name="footer_cp_req"><?php echo $footer_cp_req; ?></textarea>
                                
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
            <div class="widget-title"><span class="icon"><i class="icon-tasks"></i></span>
                <h5>Email Transport Change Contact Person</h5>
                <div class="buttons"></div>
            </div>

            <div class="widget-content nopadding">
	    
                <form class="form-horizontal" method="post" action="<?php echo site_url('customer/save_email_transport_cp'); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate">
                    
                    <div class="control-group">
                            <label class="control-label"><b>Subject</b></label>
                            <div class="controls">
                                <input type="text" name="subject_cp_transport" class="span11" id="subject_cp_transport" value="<?php echo $subject_cp_transport; ?>">
				  <input type="hidden" name="id"  id="id" value="1">
				
                            </div>
                    </div>
                    <div class="control-group">
                            <label class="control-label"><b>Header </b></label>
                            <div class="controls">
                                <textarea id="header_cp_transport" rows="5"  class="span11" name="header_cp_transport"><?php echo $header_cp_transport; ?></textarea>
                                
                            </div>
                    </div>
                    <div class="control-group">
                            <label class="control-label"><b>Body </b></label>
                            <div class="controls">
                                <textarea id="body_cp_transport" rows="5"  class="span11" name="body_cp_transport"><?php echo $body_cp_transport; ?></textarea>
                                
                            </div>
                    </div>
                     <div class="control-group">
                            <label class="control-label"><b>Footer </b></label>
                            <div class="controls">
                                <textarea rows="5" id="footer_cp_transport" class="span11" name="footer_cp_transport"><?php echo $footer_cp_transport; ?></textarea>
                                
                            </div>
                    </div>
                    <div class="form-actions">
                        <input type="submit" value="Save" class="btn btn-success">
                    </div>
                </form>
	</div>
        </div>
    </div>
    
    </div>
    
  
  </div>
</div>

