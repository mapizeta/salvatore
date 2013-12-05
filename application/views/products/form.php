<?php
//cabecera envio form
echo form_open('products/save/'.$product_info->id_item_document,array('id'=>'product_form'));
//print_r($product_info);
//echo $valor_total;
//echo $tipo_doc;
?>
<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>

<legend><?php echo $this->lang->line("products_basic_information"); ?></legend>
<?php 
if(!$product_info->fk_id_document)
$idocument=$id_document;
else
$idocument=$product_info->fk_id_document;
?>
<input name="fk_id_document" id="fk_id_document" type="hidden" value="<?php echo $idocument;?>">
<input name="tipo_doc" id="tipo_doc" type="hidden" value="<?php echo $tipo_doc;?>">

<div class="field_row clearfix">

<?php echo form_label($this->lang->line('products_code_bar').':', 'g_valor_neto'); ?>
<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'input_item',
		'id'=>'input_item')		
	); ?>
	</div>
</div>

<div class="field_row clearfix">
<?php echo form_label($this->lang->line('products_items').':', 'producto',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_dropdown('fk_item_id', $item, $selected_item);?>
	</div>
</div>
<legend><?php echo $this->lang->line("products_valor_total_information"); ?></legend>

<fieldset id="supplier_basic_info">

<div class="field_row clearfix">

<?php echo form_label($this->lang->line('products_grupo_valor_neto').':', 'g_valor_neto', array('class'=>'required')); ?>
<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'g_valor_neto',
		'id'=>'g_valor_neto_input',
		'value'=>$product_info->g_valor_neto)
	);?>
	</div>
</div>
<div class="field_row clearfix">
<?php echo form_label($this->lang->line('products_grupo_valor_exento').':', 'g_valor_exento', array('class'=>'required')); ?>
<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'g_valor_exento',
		'id'=>'g_valor_exento_input',
		'value'=>$product_info->g_valor_exento)
	);?>
	</div>
</div>
<div class="field_row clearfix">
<?php echo form_label($this->lang->line('products_grupo_iva').':', 'g_iva'); ?>
<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'g_iva',
		'id'=>'g_iva_input',
		'value'=>$product_info->g_iva)
	);?>
	</div>
</div>
<div class="field_row clearfix">
<?php echo form_label($this->lang->line('products_porcentaje_desc').':', 'porcentaje_desc'); ?>
<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'porcentaje_desc',
		'id'=>'porcentaje_desc_input',
		'value'=>$product_info->porcentaje_desc)
	);?>
	</div>
</div>
<div class="field_row clearfix">
<?php echo form_label($this->lang->line('products_grupo_total').':', 'g_total'); ?>
<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'g_total',
		'id'=>'g_total_input',
		'value'=>$product_info->g_total)
	);?>
	</div>
</div>
<div class="field_row clearfix">
<?php echo form_label($this->lang->line('products_grupo_cantidad').':', 'g_cantidad'); ?>
<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'g_cantidad',
		'id'=>'g_cantidad_input',
		'value'=>$product_info->g_cantidad)
	);?>
	</div>
</div>
</fieldset>
<br>
<legend><?php echo $this->lang->line("products_valor_individual_information"); ?></legend>

<fieldset id="supplier_basic_info">
<div class="field_row clearfix">
<?php echo form_label($this->lang->line('products_individual_valor_neto').':', 'i_valor_neto'); ?>
<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'i_valor_neto',
		'id'=>'i_valor_neto_input',
		'value'=>$product_info->i_valor_neto)
	);?>
	</div>
</div>
<div class="field_row clearfix">
<?php echo form_label($this->lang->line('products_individual_valor_exento').':', 'i_valor_exento'); ?>
<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'i_valor_exento',
		'id'=>'i_valor_exento_input',
		'value'=>$product_info->i_valor_exento)
	);?>
	</div>
</div>
<div class="field_row clearfix">
<?php echo form_label($this->lang->line('products_individual_iva').':', 'i_iva'); ?>
<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'i_iva',
		'id'=>'i_iva_input',
		'value'=>$product_info->i_iva)
	);?>
	</div>
</div>
<div class="field_row clearfix">
<?php echo form_label($this->lang->line('products_individual_total').':', 'i_total'); ?>
<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'i_total',
		'id'=>'i_total_input',
		'value'=>$product_info->i_total)
	);?>
	</div>
</div>
<div class="field_row clearfix">
<?php echo form_label($this->lang->line('products_individual_valor_sugerido').':', 'i_valor_sugerido'); ?>
<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'i_valor_sugerido',
		'id'=>'i_valor_sugerido_input',
		'value'=>$product_info->i_valor_sugerido)
	);?>
	</div>
</div>
<div class="field_row clearfix">
<?php echo form_label($this->lang->line('products_individual_valor_venta').':', 'i_valor_venta'); ?>
<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'i_valor_venta',
		'id'=>'i_valor_venta_input',
		'value'=>$product_info->i_valor_venta)
	);?>
	</div>
</div>

<?php /*
echo form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
	'value'=>$this->lang->line('common_submit'),
	'class'=>'submit_button float_right')
);
*/?>
<input type="button" class="submit_button float_right" id="submit" value="Enviar" name="submit">
</fieldset>

<?php 
echo form_close();
?>
<script type='text/javascript'>

$(document).ready(function()
{
	setTimeout(function(){
	        $('#input_item').focus();   
	    },200);

$('#submit').click(function() {
$('#product_form').submit();
});



$('#g_cantidad_input').focus(function(){

  $(this).css('border','1px solid #F2817F');
    
}).blur(function(){
	var cantidad = Number($("#g_cantidad_input").val());
	var valor_neto = $("#g_valor_neto_input").val();
	var valor_exento = $("#g_valor_exento_input").val();
	var iva = $("#g_iva_input").val();
	var valor_total = $("#g_total_input").val();
	var valor_sugerido = (valor_total/cantidad) + (valor_total/cantidad)*0.5;
		
//$("#total_input").val(valor_neto-iva);
if($("#tipo_doc").val() == 2)
	$("#i_iva_input").val(0).attr('disabled','disabled');
else
	$("#i_iva_input").val((iva/cantidad).toFixed(2)).attr('readonly', true);

$("#i_valor_neto_input").val((valor_neto/cantidad).toFixed(2)).attr('readonly', true);
$("#i_valor_exento_input").val((valor_exento/cantidad).toFixed()).attr('readonly', true);
$("#i_total_input").val((valor_total/cantidad).toFixed(2)).attr('readonly', true);
$("#i_valor_sugerido_input").val(valor_sugerido.toFixed(2)).attr('readonly', true);

 
});

$('#g_valor_neto_input').focus(function(){

  $(this).css('border','1px solid #F2817F');
    
}).blur(function(){

	var valor_neto = $("#g_valor_neto_input").val();
	var iva = valor_neto*0.19;
if($("#tipo_doc").val() == 2)		
	$("#g_iva_input").val(0).attr('disabled','disabled');
else
	$("#g_iva_input").val(iva.toFixed()).attr('readonly', true);
});
$('#porcentaje_desc_input').focus(function(){

  $(this).css('border','1px solid #F2817F');
    
}).blur(function(){

	var desc = ($("#porcentaje_desc_input").val())/100;
	var semitotal = Number($("#g_iva_input").val())+Number($('#g_valor_neto_input').val());
	var descuento = semitotal*desc;
	var total = semitotal-descuento;
			

$("#g_total_input").val(total.toFixed(2)).attr('readonly', true);

 
});



$('#input_item').bind("enterKey",function(e){
	
	   var input_item = $("#input_item").val();
	   
		var data = 'input_item='+ input_item; 

		var respuesta =$ .ajax({
			type: 'POST',
			url: 'application/views/products/consulta_num_item.php',
			data: data,
			dataType: "json",

			success: function(data) {
			//var response = data;
			console.log(data.existe);
			//alert(data.existe);
			if(data.existe == 1)
				{
					$("select[name='fk_item_id']").val(data.item_id);
					$('#g_valor_neto_input').focus();
										
				}
			}
			});
});
$('#input_item').keyup(function(e){
if(e.keyCode == 13)
{
  $(this).trigger("enterKey");
}
});

/*
$('#input_item').focus(function(){

  $(this).css('border','1px solid #F2817F');
    
}).blur(function(){

	var input_item = $("#input_item").val();

	var data = 'input_item='+ input_item; 

	var respuesta =$ .ajax({
		type: 'POST',
		url: 'application/views/products/consulta_num_item.php',
		data: data,
		dataType: "json",

success: function(data) {
//var response = data;
console.log(data.existe);
//alert(data.existe);
if(data.existe == 1)
	{
		$("#g_valor_neto_input").val(data.name);
		
	}
}
});
 	  
  //$(this).css('border','#CCC thin solid');
 
});*/

	$('#product_form').validate({
		submitHandler:function(form)
		{
		
			$(form).ajaxSubmit({
			success:function(response)
			{
				console.log('SUBMIT EXITO');
				tb_remove();
				post_person_form_submit(response);
				document.location.href = "index.php/products/principal/<?php echo $idocument."/".$valor_total;?>";
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules: 
		{
			g_valor_neto: "required",
			g_valor_exento: "required",
			last_name: "required",
    		email: "email"
   		},
		messages: 
		{
     		g_valor_neto: "<?php echo $this->lang->line('suppliers_company_name_required'); ?>",
     		g_valor_exento: "<?php echo $this->lang->line('common_last_name_required'); ?>",
     		email: "<?php echo $this->lang->line('common_email_invalid_format'); ?>"
		}
	});
});
</script>