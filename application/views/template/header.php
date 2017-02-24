<!DOCTYPE html>
<html lang="en">

<head>
<?php
    //$is_logged_in=$this->session->userdata('logged_state');
    //    if(!isset($is_logged_in) || $is_logged_in != true){
    //        redirect('home/login');
    //        die();
    //    }
        
        
?>
<title>Customer Request | Vivere Group</title><meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/uniform.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/select2.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/datepicker.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/maruti-style.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/maruti-media.css" class="skin-color" />

<link href="<?php echo base_url(); ?>js/allert/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen" />
<script src="<?php echo base_url(); ?>js/jquery.min.js"></script> 
<script src="<?php echo base_url(); ?>js/jquery.ui.custom.js"></script>
<script src="<?php echo base_url(); ?>js/highcharts.js"></script>
<script src="<?php echo base_url(); ?>js/exporting.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.preimage.js"></script>
<script src="<?php echo base_url(); ?>js/fancybox/jquery.fancybox.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>js/fancybox/jquery.fancybox.css">
<script>
$(document).ready(function()
{
    $('.file').preimage();
    $("#spinner").hide();
});
</script>
<style>
    #spinner {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: rgba( 255, 255, 255, .5 ) 
                url('<?php echo base_url()."img/waiting.gif" ?>') 
                50% 50% 
                no-repeat;
	}

</style>
</head>
<body>
    <div id="spinner"></div>
<?php
$this->load->view("template/panel");
?>

<?php
$this->load->view("template/menu");
?>