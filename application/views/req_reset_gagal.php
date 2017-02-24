<!DOCTYPE html>
<html lang="en">
    
<head>
    <title>Customer Request</title><meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-responsive.min.css" />
    <!--<link rel="stylesheet" href="<?php echo base_url(); ?>css/fullcalendar.css" />-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/uniform.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/select2.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/maruti-style.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/maruti-media.css" class="skin-color" />
    <script src="<?php echo base_url(); ?>js/jquery.min.js"></script> 
    <script src="<?php echo base_url(); ?>js/jquery.ui.custom.js"></script> 
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/maruti-login.css" />
    </head>
    <body>
       <br/><br/><br/>
        <div id="loginbox">
            <form name="basic_validate" id="basic_validate" novalidate="novalidate" class="form-vertical" method="post" action="">
		<div class="control-group normal_text" ><h4></h4><h3><img src="<?php echo base_url(); ?>img/vivere.jpg" style="text-align: center;"></h3></div>
                <?php
		    $msg=$this->session->flashdata('msg');
		    echo $msg;
		?>
		
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
			    <h4 style="color: red;">RESET PASSWORD FAILED !!!</h4>
                            Please check your <b>NIK</b> and try again.<br/>
                            Thank You.
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <span class="pull-right"><a href="<?php echo site_url('home/login'); ?>"><input type="button" class="btn btn-success" value="Back to Login" /></a></span>
                </div>
            </form>
            
        </div>
        <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script> 
	<script src="<?php echo base_url(); ?>js/jquery.uniform.js"></script>
	<script src="<?php echo base_url(); ?>js/jquery.validate.js"></script>
	<!--<script src="<?php echo base_url(); ?>js/maruti.form_validation.js"></script>-->
	<!--<script src="<?php echo base_url(); ?>js/maruti.form_common.js"></script>-->
	<script src="<?php echo base_url(); ?>js/maruti.login.js"></script> 
    </body>

</html>
