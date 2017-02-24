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
            <form name="basic_validate" id="basic_validate" novalidate="novalidate" class="form-vertical" method="post" action="<?php echo site_url('home/cek_login'); ?>">
		<div class="control-group normal_text" ><h4></h4><h3><img src="<?php echo base_url(); ?>img/vivere.jpg" style="text-align: center;"></h3></div>
                <?php
		    $msg=$this->session->flashdata('msg');
		    echo $msg;
		?>
		<div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on"><i class="icon-user"></i></span><input type="text" name="user" id="user" placeholder="Username" />
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on"><i class="icon-lock"></i></span>
			    <input type="password" name="pass" id="pass" placeholder="Password" />
			    <input type="hidden" name="jenis" value="<?php echo $jenis; ?>" id="jenis">
                        </div>
                    </div>
                </div>
                <div class="form-actions">
		     <span class="pull-left"><a href="#" class="flip-link btn btn-warning" id="to-recover">Lost password?</a></span>
                    <span class="pull-right"><input type="submit" class="btn btn-success" value="Login" /></span>
                </div>
            </form>
            <form id="recoverform" method="post" action="<?php echo site_url('home/proses_reset'); ?>" class="form-vertical">
		<p class="normal_text">Enter your NIK below and we will send you instructions <br/><font color="#FF6633">how to recover a password.</font></p>
		<div class="controls">
		    <div class="main_input_box">
			<span class="add-on"><i class="icon-user"></i></span><input name="nik_reset" id="nik_reset" type="text" placeholder="NIK" />
		    </div>
		</div>
		<div class="controls">
		    <div class="main_input_box" >
			<h4>Choose Reason</h4>
		    </div>
		</div>
		<div class="controls">
		    <div class="main_input_box">
			<span class="add-on"><input type="radio" checked="checked" name="reason" value="1" /></i></span><input type="text" readonly="readonly" value="LOST PASSWORD" />
			<span class="add-on"><input type="radio" name="reason" value="2" /></i></span><input type="text" readonly="readonly" value="Password Correct, but I Can't Access" />
			<span class="add-on"><input type="radio" name="reason" value="3" /></i></span><input type="text" readonly="readonly" value="Used by Someone" />
		    </div>
		</div>
                <div class="form-actions">
                    <span class="pull-left"><a href="#" class="flip-link btn btn-warning" id="to-login">&laquo; Back to login</a></span>
                    <span class="pull-right"><input type="submit" class="btn btn-info" value="Reset" /></span>
                </div>
            </form>
        </div>
	
        <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script> 
	<script src="<?php echo base_url(); ?>js/jquery.uniform.js"></script>
	<script src="<?php echo base_url(); ?>js/jquery.validate.js"></script>
	<script src="<?php echo base_url(); ?>js/maruti.login.js"></script> 
    </body>

</html>
