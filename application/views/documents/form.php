<?php
//cabecera envio form
echo form_open('documents/save/'.$document_info->id_document,array('id'=>'document_form'));
//print_r($document_info);
?>
<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<fieldset id="supplier_basic_info">
<legend><?php echo $this->lang->line("suppliers_basic_information"); ?></legend>

<input name="existe_proveedor" id="existe_proveedor" type="hidden" value="0">
<input name="person_id" id="person_id" type="hidden" value="0">

<div class="field_row clearfix">	
<?php echo form_label('RUT:', 'rut', array('class'=>'required')); ?>
<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'rut',
		'id'=>'rut_input',
		'value'=>$document_info->fk_rut)
	);?>
	</div>
</div>
<div class="field_row clearfix">
<?php echo form_label($this->lang->line('documents_nombre_supplier').':', 'first_name', array('class'=>'required')); ?>
<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'company_name',
		'id'=>'company_name_input',
		'value'=>$document_info->company_name)
	);?>
	</div>
</div>
<div class="field_row clearfix">
<?php echo form_label($this->lang->line('documents_direccion_supplier').':', 'address_1', array('class'=>'required')); ?>
<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'address_1',
		'id'=>'address_1_input',
		'value'=>$document_info->address_1)
	);?>
	</div>
</div>
<div class="field_row clearfix">
<?php echo form_label($this->lang->line('documents_contacto_supplier').':', 'contacto'); ?>
<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'contacto',
		'id'=>'contacto_input',
		'value'=>$document_info->contacto)
	);?>
	</div>
</div>
<div class="field_row clearfix">
<?php echo form_label($this->lang->line('documents_fono_supplier').':', 'phone_number'); ?>
<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'phone_number',
		'id'=>'phone_number_input',
		'value'=>$document_info->phone_number)
	);?>
	</div>
</div>
<div class="field_row clearfix">
<?php echo form_label($this->lang->line('documents_tipo').':', 'nombre', array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_dropdown('fk_id_type_doc', $tipo_doc, $selected_tipo_doc);?>
	</div>
</div>
<div class="field_row clearfix">
<?php echo form_label($this->lang->line('documents_fecha').':', 'fecha'); ?>
<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'fecha',
		'id'=>'fecha_input',
		'value'=>$document_info->fecha)
	);?>
	</div>
</div>
<div class="field_row clearfix">
<?php echo form_label($this->lang->line('documents_num').':', 'num_doc'); ?>
<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'num_doc',
		'id'=>'num_doc_input',
		'value'=>$document_info->num_doc)
	);?>
	</div>
</div>
<div class="field_row clearfix">
<?php echo form_label($this->lang->line('documents_valor_neto').':', 'neto'); ?>
<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'neto',
		'id'=>'neto_input',
		'value'=>$document_info->neto)
	);?>
	</div>
</div>
<div class="field_row clearfix">
<?php echo form_label($this->lang->line('documents_valor_excento').':', 'afecto_adicional'); ?>
<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'afecto_adicional',
		'id'=>'afecto_adicional_input',
		'value'=>$document_info->afecto_adicional)
	);?>
	</div>
</div>
<div class="field_row clearfix">
<?php echo form_label($this->lang->line('documents_valor_adicional').':', 'valor_adicional'); ?>
<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'valor_adicional',
		'id'=>'valor_adicional_input',
		'value'=>$document_info->valor_adicional)
	);?>
	</div>
</div>
<div class="field_row clearfix">
<?php echo form_label($this->lang->line('documents_valor_iva').':', 'iva'); ?>
<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'iva',
		'id'=>'iva_input',
		'value'=>$document_info->iva)
	);?>
	</div>
</div>
<div class="field_row clearfix">
<?php echo form_label($this->lang->line('documents_valor_flete').':', 'valor_flete'); ?>
<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'valor_flete',
		'id'=>'valor_flete_input',
		'value'=>$document_info->valor_flete)
	);?>
	</div>
</div>
<div class="field_row clearfix">
<?php echo form_label($this->lang->line('documents_valor_total').':', 'total'); ?>
<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'total',
		'id'=>'total_input',
		'value'=>$document_info->total)
	);?>
	</div>
</div>
<?php
echo form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
	'value'=>$this->lang->line('common_submit'),
	'class'=>'submit_button float_right')
);
?>
</fieldset>
<?php 
echo form_close();
?>

<script type='text/javascript'>
$(document).ready(function()
{
	setTimeout(function(){
        $('#rut_input').focus();   
    },200);
    
$("#fecha_input").datepicker();

/*FUNCION IVA*/
$('#neto_input').focus(function(){

  $(this).css('border','1px solid #F2817F');
    
}).blur(function(){

	if($("select[name='fk_id_type_doc']").val() == 2)

		$("#iva_input").val(0).attr('disabled','disabled');

	else{
		var valor_neto = $("#neto_input").val();
		var iva = valor_neto*0.19;
		$("#iva_input").val(iva.toFixed(2)).attr('disabled','disabled');
 }
});

$('#valor_adicional_input').focus(function(){

  $(this).css('border','1px solid #F2817F');
    
}).blur(function(){

	var valor_neto = Number($("#neto_input").val());
	var iva = Number($("#iva_input").val());
	var valor_adicional = Number($("#valor_adicional_input").val());
	var total= Number(valor_neto+iva+valor_adicional);

	$("#total_input").val(total);
 
});

$('#valor_flete_input').focus(function(){

  $(this).css('border','1px solid #F2817F');
    
}).blur(function(){

	var subtotal = Number($("#total_input").val());
	var flete = Number($("#valor_flete_input").val());
	var total= Number(subtotal+flete);

	$("#total_input").val(total);
 
});


$('#rut_input').focus(function(){

  $(this).css('border','1px solid #F2817F');
    
}).blur(function(){

	var rut = $("#rut_input").val();

	var data = 'rut='+ rut; 

	var respuesta =$ .ajax({
		type: 'POST',
		url: 'application/views/documents/consulta_rut.php',
		data: data,
		dataType: "json",

success: function(data) {
//var response = data;
console.log(data.existe);
//alert(data.existe);
if(data.existe == 1)
	{
		$("#person_id").val(data.person_id);
		$("#existe_proveedor").val("1");
		$("#company_name_input").val(data.company_name);
		$("#company_name_input").attr('disabled','disabled');
		$("#address_1_input").val(data.address_1);
		$("#address_1_input").attr('disabled','disabled');
		$("#contacto_input").val(data.contacto);
		$("#contacto_input").attr('disabled','disabled');
		$("#phone_number_input").val(data.phone_number);
		$("#phone_number_input").attr('disabled','disabled');
	}
}
});
 	  
  //$(this).css('border','#CCC thin solid');
 
});
//validation and submit handling

	$('#document_form').validate({
		submitHandler:function(form)
		{	
			$(form).ajaxSubmit({
			success:function(response)
			{
				tb_remove();
				post_document_form_submit(response);
				document.location.href = "index.php/documents";
				//console.log('SUBMIT EXITO');
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules: 
		{	rut: "required",
			company_name: "required",
			address_1: "required"			
   		},
		messages: 
		{
     		company_name: "<?php echo $this->lang->line('suppliers_company_name_required'); ?>",
     		rut: "<?php echo $this->lang->line('common_last_name_required'); ?>",
     		address_1: "<?php echo $this->lang->line('common_email_invalid_format'); ?>"
		}
	});
});
</script>