<?php $this->load->view("partial/header1"); ?>
<br />
<h3><?php //echo $this->lang->line('common_welcome_message'); ?></h3>
<div id="home_module_list">
	<div style="width: 100%;height: 200px; text-align:left;">
	<?php
	
	foreach($allowed_modules->result() as $module5)
	{
	?>
	
	<div class="module_item" style="float:left;margin-right: 100px;margin-left:100px;margin-bottom:15px">
		<a href="<?php echo site_url("$module->module_id");?>">
		<img src="<?php echo base_url().'images/menubar/'.$module->module_id.'.png';?>" border="0" alt="Menubar Image" /><br />
		<a href="<?php echo site_url("$module->module_id");?>"><?php echo $this->lang->line("module_".$module->module_id) ?></a>
	 <?php //echo $this->lang->line('module_'.$module->module_id.'_desc');?>
	</div>
	
	<?php
	}
	?>
	</div>
	<!--
	<div style="width: 100%;height: 200px; text-align:left;">
		<div class="texto-secciones">VENTAS</div>
		<div class="module_item" style="float:left;margin-right: 70px;">
			<a href="http://localhost:8080/puntoventa/index.php/items">
			<img src="http://localhost:8080/puntoventa/images/menubar/items.png" border="0" alt="Menubar Image"></a><br />
			<a href="http://localhost:8080/puntoventa/index.php/items">Artículos</a>
		</div>
		<div class="module_item" style="float:left;margin-right: 70px;">
			<a href="http://localhost:8080/puntoventa/index.php/sales">
			<img src="http://localhost:8080/puntoventa/images/menubar/sales.png" border="0" alt="Menubar Image"></a><br />
			<a href="http://localhost:8080/puntoventa/index.php/sales">Ventas</a>
		</div>
	</div>
	<hr>
	<div style="width: 100%;height: 200px; text-align:left;margin-top: 15px;">
		<div class="texto-secciones">USUARIOS</div>
		<div class="module_item" style="float:left;margin-right: 70px;">
			<a href="http://localhost:8080/puntoventa/index.php/customers">
			<img src="http://localhost:8080/puntoventa/images/menubar/customers.png" border="0" alt="Menubar Image"></a><br />
			<a href="http://localhost:8080/puntoventa/index.php/customers">Clientes</a>
		</div>

		<div class="module_item" style="float:left;margin-right: 70px;">
			<a href="http://localhost:8080/puntoventa/index.php/suppliers">
			<img src="http://localhost:8080/puntoventa/images/menubar/suppliers.png" border="0" alt="Menubar Image"></a><br />
			<a href="http://localhost:8080/puntoventa/index.php/suppliers">Proveedor</a>
		</div>

		<div class="module_item" style="float:left;margin-right: 70px;">
			<a href="http://localhost:8080/puntoventa/index.php/employees">
			<img src="http://localhost:8080/puntoventa/images/menubar/employees.png" border="0" alt="Menubar Image"></a><br />
			<a href="http://localhost:8080/puntoventa/index.php/employees">Empleados</a>
		</div>
	</div>
	<hr>
	<div style="width: 100%;height: 200px; text-align:left;margin-top: 15px;">	
		<div class="texto-secciones">SISTEMA</div>
		<div class="module_item" style="float:left;margin-right: 70px;">
			<a href="http://localhost:8080/puntoventa/index.php/reports">
			<img src="http://localhost:8080/puntoventa/images/menubar/reports.png" border="0" alt="Menubar Image"></a><br />
			<a href="http://localhost:8080/puntoventa/index.php/reports">Reportes</a>
		</div>

		<div class="module_item" style="float:left;margin-right: 70px;">
			<a href="http://localhost:8080/puntoventa/index.php/config">
			<img src="http://localhost:8080/puntoventa/images/menubar/config.png" border="0" alt="Menubar Image"></a><br />
			<a href="http://localhost:8080/puntoventa/index.php/config">Configuarción de la Tienda</a>
		</div>
	</div>
-->

</div>
<?php $this->load->view("partial/footer"); ?>