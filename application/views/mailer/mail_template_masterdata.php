<html>
  <head>
    <meta http-equiv="content-type" content="text/html; ">
  </head>
<style>
body {
	
	font:Arial, Helvetica, sans-serif;
}
</style>  
  <body>
  
<?php
if($type == "new") :
?>
<?php echo $header_new_transport." "; ?> <?php echo $nama; ?>
<p>
  <?php echo $body_new_transport; ?><?php echo $id_req; ?>
</p>
<p>
<?php echo $footer_new_transport; ?>
</p>

<?php
elseif($type == "edit") :
?>
<?php echo $header_change_transport." "; ?> <?php echo $nama; ?>
<p>
  <?php echo $body_change_transport; ?><?php echo $id_req; ?>
</p>
<p>
<?php echo $footer_change_transport; ?>
</p>

<?php
elseif($type == "extend") :
?>
<?php echo $header_ex_transport." "; ?> <?php echo $nama; ?>
<p>
  <?php echo $body_ex_transport; ?><?php echo $id_req; ?>
</p>
<p>
<?php echo $footer_ex_transport; ?>
</p>

<?php
endif;
?>
  </body>
</html>

