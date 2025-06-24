
<?php $this->load->view("partial/header"); ?>
<div id="page_title" style="margin-bottom:8px;"><?php echo $this->lang->line('reports_reports'); ?></div>
<div id="welcome_message"><?php echo $this->lang->line('reports_welcome_message'); ?>
	<div class="graf">Informes Gráficos</div>
<ul class="report_list">
	
			<li><a href="<?php echo site_url('reports/graphical_summary_sales');?>"><img src="images/menubar/sales80.png"><div><?php echo $this->lang->line('reports_sales'); ?></div></a></li>
			<li><a href="<?php echo site_url('reports/graphical_summary_categories');?>"><img src="images/menubar/categorias80.png"><div><?php echo $this->lang->line('reports_categories'); ?></div></a></li>
			<li><a href="<?php echo site_url('reports/graphical_summary_customers');?>"><img src="images/menubar/customers80.png"><div><?php echo $this->lang->line('reports_customers'); ?></div></a></li>
			<li><a href="<?php echo site_url('reports/graphical_summary_suppliers');?>"><img src="images/menubar/suppliers80.png"><div><?php echo $this->lang->line('reports_suppliers'); ?></div></a></li>
			<li><a href="<?php echo site_url('reports/graphical_summary_items');?>"><img src="images/menubar/items80.png"><div><?php echo $this->lang->line('reports_items'); ?></div></a></li>
			<li><a href="<?php echo site_url('reports/graphical_summary_employees');?>"><img src="images/menubar/employees80.png"><div><?php echo $this->lang->line('reports_employees'); ?></div></a></li>
			<li><a href="<?php echo site_url('reports/graphical_summary_taxes');?>"><img src="images/menubar/taxes80.png"><div><?php echo $this->lang->line('reports_tax'); ?></div></a></li>
	</ul>

	<div class="graf" >Informes Resumidos</div>
	<ul class="report_list1">
		
			<li><a href="<?php echo site_url('reports/summary_sales');?>"><img src="images/menubar/sales80.png"><div><?php echo $this->lang->line('reports_sales'); ?></div></a></li>
			<li><a href="<?php echo site_url('reports/summary_categories');?>"><img src="images/menubar/categorias80.png"><div><?php echo $this->lang->line('reports_categories'); ?></div></a></li>
			<li><a href="<?php echo site_url('reports/summary_customers');?>"><img src="images/menubar/customers80.png"><div><?php echo $this->lang->line('reports_customers'); ?></div></a></li>
			<li><a href="<?php echo site_url('reports/summary_suppliers');?>"><img src="images/menubar/suppliers80.png"><div><?php echo $this->lang->line('reports_suppliers'); ?></div></a></li>
			<li><a href="<?php echo site_url('reports/summary_items');?>"><img src="images/menubar/items80.png"><div><?php echo $this->lang->line('reports_items'); ?></div></a></li>
			<li><a href="<?php echo site_url('reports/summary_employees');?>"><img src="images/menubar/employees80.png"><div><?php echo $this->lang->line('reports_employees'); ?></div></a></li>
			<li><a href="<?php echo site_url('reports/summary_taxes');?>"><img src="images/menubar/taxes80.png"><div><?php echo $this->lang->line('reports_tax'); ?></div></a></li>
	</ul>
	<div class="graf">Informes Detallados</div>
	<ul class="report_list2">
			<li><a href="<?php echo site_url('reports/detailed_sales');?>"><img src="images/menubar/sales80.png"><div><?php echo $this->lang->line('reports_sales'); ?></div></a></li>
			<li><a href="<?php echo site_url('reports/specific_customer');?>"><img src="images/menubar/customers80.png"><div><?php echo $this->lang->line('reports_customers'); ?></div></a></li>
			<li><a href="<?php echo site_url('reports/specific_employee');?>"><img src="images/menubar/employees80.png"><div><?php echo $this->lang->line('reports_employees'); ?></div></a></li>
	</ul>
<?php
if(isset($error))
{
	echo "<div class='error_message'>".$error."</div>";
}
?>
<?php //$this->load->view("partial/footer"); ?>

<script type="text/javascript" language="javascript">
$(document).ready(function()
{
});
</script>
