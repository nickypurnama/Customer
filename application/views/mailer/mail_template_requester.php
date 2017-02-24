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
<?php echo $header_new_post; ?> <?php echo $id_req; ?><br>

<p>
<font size="+1"><?php echo $body_new_post; ?> </font><br>
<a href="<?php echo $url_app; ?>index.php/home/login/approve_new/<?php echo $id_req; ?>"><font color="#0066FF" size="+2"><?php echo $url_app; ?></font></a>

</p>
<p>
<?php echo $footer_new_post; ?>
</p>

<?php
elseif($type == "edit") :
?>


<?php echo $header_change_post; ?> <?php echo $id_req; ?><br>
<p>
<font size="+1"><?php echo $body_change_post; ?> </font><br>
<a href="<?php echo $url_app; ?>index.php/home/login/approve_edit/<?php echo $id_req; ?>"><font color="#0066FF" size="+2"><?php echo $url_app; ?></font></a>
</p>
<p>
<?php echo $footer_change_post; ?>
</p>



<?php
elseif($type == "extend") :
?>

<?php echo $header_ex_post; ?> <?php echo $id_req; ?><br>
<p>
<font size="+1"><?php echo $body_ex_post; ?></font><br>
<a href="<?php echo $url_app; ?>index.php/home/login/approve_extend/<?php echo $id_req; ?>"><font color="#0066FF" size="+2"><?php echo $url_app; ?></font></a>
</p>

<p>
<?php echo $footer_ex_post; ?>
</p>

<?php
endif;
?>

  </body>
</html>

