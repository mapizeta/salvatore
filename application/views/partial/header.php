<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<base href="<?php echo base_url();?>" />
	<link rel="icon" href="<?php echo base_url();?>images/menubar/favicon.ico" >
	<title>Salvatore</title>
	<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/phppos.css" />
	<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/phppos_print.css"  media="print"/>
	<link rel="stylesheet" href="<?php echo base_url();?>css/ui.datepicker.css" type="text/css" >
	<script src="<?php echo base_url();?>js/jquery-1.2.6.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.color.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.metadata.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.form.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.tablesorter.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.ajax_queue.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.bgiframe.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.autocomplete.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.validate.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/ui.datepicker.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/thickbox.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/common.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/manage_tables.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/swfobject.js" type="text/javascript" language="javascript" charset="UTF-8"></script>

<style type="text/css">
/*ESTILO para td informacion documento*/
.documento_MONTO {
	color: #FF0000;
	font-weight: bold;
}
html {
    overflow: auto;
}
.embed + img { position: relative; left: -21px; top: -1px; }
</style>
</head>
<body>
<div id="menubar">
	<div id="menubar_container">
		<div id="menubar_company_info">
		<span id="company_title"><img src="<?php echo base_url();?>images/menubar/logologin1.png"></span><br />
	</div>

		<div id="menubar_navigation">
			
			<?php
				
				//print_r($allowed_modules->result());
			foreach($allowed_modules->result() as $module)
			{
				if($module->module_id != 'products'){
			?>
			<a href="<?php echo site_url("$module->module_id");?>">
			<div class="menu_item">
				
				<div style="width: 77px;height: 77px;">
<img src="<?php echo base_url().'images/menubar/'.$module->module_id.'77.png';?>" border="0" alt="Menubar Image" /></div>
				<div style="text-align: center;width: 44px;margin-top: -42px;margin-left: 81px;">
					<?php echo $this->lang->line("module_".$module->module_id) ?></div>
			</div>
			</a>


			<?php
			} }
			?>
		</div>

		<div id="menubar_footer">
		<?php echo $this->lang->line('common_welcome')." $user_info->first_name $user_info->last_name! | "; ?>
		<?php echo anchor("home/logout",$this->lang->line("common_logout")); ?>
		</div>

		<!--div id="menubar_date">
		<?php
		$mes=date("F");
 
			if ($mes=="January") $mes="Enero";
			if ($mes=="February") $mes="Febrero";
			if ($mes=="March") $mes="Marzo";
			if ($mes=="April") $mes="Abril";
			if ($mes=="May") $mes="Mayo";
			if ($mes=="June") $mes="Junio";
			if ($mes=="July") $mes="Julio";
			if ($mes=="August") $mes="Agosto";
			if ($mes=="September") $mes="Setiembre";
			if ($mes=="October") $mes="Octubre";
			if ($mes=="November") $mes="Noviembre";
			if ($mes=="December") $mes="Diciembre";
			 
		$ano=date("Y");
		$dia2=date("d");
		echo "$dia2 de $mes de $ano";?>
		</div-->

	</div>
</div>
<div id="content_area_wrapper">
<div id="content_area">