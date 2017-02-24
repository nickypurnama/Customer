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
<?php echo $header_new_approve; ?> <?php echo $id_req; ?><br> 

<p>
<font size="+1"><?php echo $body_new_approve; ?> </font><br>
<a href="<?php echo $url_app; ?>index.php/home/login/is_new/<?php echo $id_req; ?>"><font color="#0066FF" size="+2"><?php echo $url_app; ?></font></a>
</p>
<p>
<?php echo $footer_new_approve; ?>
</p>


<?php
elseif($type == "edit") :
?>

<?php echo $header_change_approve; ?> <?php echo $id_req; ?><br> 

<p>
<font size="+1"><?php echo $body_change_approve; ?> </font><br>
<a href="<?php echo $url_app; ?>index.php/home/login/is_edit/<?php echo $id_req; ?>"><font color="#0066FF" size="+2"><?php echo $url_app; ?></font></a>

<p>
<?php echo $footer_change_approve; ?>
</p>

<?php
elseif($type == "extend") :
?>

<?php echo $header_ex_approve; ?> <?php echo $id_req; ?><br> 
<p>
<font size="+1"><?php echo $body_ex_approve; ?></font><br>
<a href="<?php echo $url_app; ?>index.php/home/login/is_extend/<?php echo $id_req; ?>"><font color="#0066FF" size="+2"><?php echo $url_app; ?></font></a>

<p>
<?php echo $footer_ex_approve; ?>
</p>

<?php
endif;
?>

  </body>
</html>

