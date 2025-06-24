<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" rev="stylesheet" href="<?php echo protocol_relative_url();?>css/login.css" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Eco Drive</title>
<script src="<?php echo protocol_relative_url();?>js/jquery-1.2.6.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
<script type="text/javascript">
$(document).ready(function()
{
	$("#login_form input:first").focus();
});
</script>
</head>
<body >
	<div class="header">
	 <!--h1>Punto de venta</h1-->
	</div>
<?php
if ($_SERVER['HTTP_HOST'] == 'demo.phppointofsale.com')
{
?>
<h2>Username = admin</h2>
<h2>Password = pointofsale</h2>
<?php
}
?>
<?php echo form_open('login') ?>
<div id="container">
<?php echo validation_errors(); ?>
	<!--div id="top">
	<?php //echo $this->lang->line('login_login'); ?>
	</div-->
	<div id="login_form">
		<div id="welcome_message">
			<img src="<?php echo protocol_relative_url();?>images/menubar/logologin.png">
		<?php //echo $this->lang->line('login_welcome_message'); ?>
		</div>
		
		<div class="form_field_label_user"><?php echo $this->lang->line('login_username'); ?>: </div>
		
		<?php echo form_input(array(
		'name'=>'username', 
		'value'=>set_value('username'),
		'size'=>'20')); ?>
		

		<div class="form_field_label_pass"><?php echo $this->lang->line('login_password'); ?>: </div>
		
		<?php echo form_password(array(
		'name'=>'password', 
		'value'=>set_value('password'),
		'size'=>'20')); ?>
		
		
		
		<div id="submit_button">
		<?php echo form_submit('loginButton','Ingresar'); ?>
		</div>
	</div>
</div>
	<div class="footer">Punto de venta creado por Pyzarro.</div>

<?php echo form_close(); ?>
</body>
</html>
