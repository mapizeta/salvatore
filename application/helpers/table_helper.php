<?php
/*
Gets the html table to manage people.
*/
function get_people_manage_table($people,$controller)
{
	$CI =& get_instance();
	$table='<table class="tablesorter" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />', 
	$CI->lang->line('common_last_name'),
	$CI->lang->line('common_first_name'),
	$CI->lang->line('common_email'),
	$CI->lang->line('common_phone_number'),
	'&nbsp');
	
	$table.='<thead><tr>';
	foreach($headers as $header)
	{
		$table.="<th>$header</th>";
	}
	$table.='</tr></thead><tbody>';
	$table.=get_people_manage_table_data_rows($people,$controller);
	$table.='</tbody></table>';
	return $table;
}

/*
Gets the html data rows for the people.
*/
function get_people_manage_table_data_rows($people,$controller)
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($people->result() as $person)
	{
		$table_data_rows.=get_person_data_row($person,$controller);
	}
	
	if($people->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='6'><div class='warning_message' style='padding:7px;'>".$CI->lang->line('common_no_persons_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}

function get_person_data_row($person,$controller)
{
	$CI =& get_instance();
	$controller_name=$CI->uri->segment(1);
	$width = $controller->get_form_width();

	$table_data_row='<tr>';
	$table_data_row.="<td width='5%'><input type='checkbox' id='person_$person->person_id' value='".$person->person_id."'/></td>";
	$table_data_row.='<td width="20%">'.character_limiter($person->last_name,13).'</td>';
	$table_data_row.='<td width="20%">'.character_limiter($person->first_name,13).'</td>';
	$table_data_row.='<td width="30%" id="mail">'.mailto($person->email,character_limiter($person->email,22)).'</td>';
	$table_data_row.='<td width="20%">'.character_limiter($person->phone_number,13).'</td>';		
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view/$person->person_id/width:$width", $CI->lang->line('common_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_update'))).'</td>';		
	$table_data_row.='</tr>';
	
	return $table_data_row;
}

/*
Gets the html table to manage suppliers.
*/
function get_product_manage_table($products,$controller,$sumatotal,$valor_total, $id_document, $cantidad, $valor_flete)
{
	$xasignar = $valor_total-$sumatotal;
	$CI =& get_instance();
	$table='<table class="tablesorter" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />',
	$CI->lang->line('products_items'),//Nombre producto
	$CI->lang->line('products_grupo_cantidad'),//Cantidad
	$CI->lang->line('products_individual_valor_neto'),//Precio Unitario
	$CI->lang->line('products_individual_valor_venta'),//Descuento
	$CI->lang->line('products_individual_valor_sugerido'),//Valor sugerido de venta
	'&nbsp');
	
	$table.='<thead><tr>';
	if($cantidad)
	$xrepartir=$valor_flete/$cantidad;
	else
	$xrepartir = 0;
	
	if($cantidad)
	$boton_cerrar=anchor("/products/close_document/".$id_document, $CI->lang->line('documents_close'),array('id'=>'document_close', 'title'=>$CI->lang->line('documents_close_dialog')));
	else
	$boton_cerrar="";
	
	foreach($headers as $header)
	{
		$table.="<th>$header</th>";
	}
	$table.='</tr></thead><tbody>';
	$table.=get_product_manage_table_data_rows($products,$controller,$cantidad,$valor_total);
	$table.='</tbody><tfoot>';
	$table.='<tr><td colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VALOR TOTAL: <span class="documento_MONTO">$'.$sumatotal.'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FALTAN POR ASIGNAR: <span class="documento_MONTO">$'.$xasignar.'</span> Flete:'.$valor_flete.'</td><td colspan="3" align="right">'.$boton_cerrar.'</td></tr>';
	$table.='</tfoot></table>';
	
	return $table;
}

function get_product_manage_table_data_rows($products,$controller,$cantidad,$valor_total)
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($products->result() as $supplier)
	{
		$table_data_rows.=get_product_data_row($supplier,$controller,$cantidad,$valor_total);
	}
	
	if($products->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>".$CI->lang->line('products_no_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}

function get_product_data_row($document,$controller,$cantidad,$valor_total)
{
	$CI =& get_instance();
	$controller_name=$CI->uri->segment(1);
	$width = $controller->get_form_width();
	$valor_sugerido_venta=$document->i_valor_sugerido+$cantidad;
	//print_r($document);

	$table_data_row='<tr>';
	$table_data_row.="<td width='5%'><input type='checkbox' id='document_$document->id_item_document' value='".$document->id_item_document."'/></td>";
	$table_data_row.='<td width="17%">'.character_limiter($document->name,13).'</td>';//Nombre item
	$table_data_row.='<td width="10%">'.character_limiter($document->g_cantidad,13).'</td>';//Cantidad
	$table_data_row.='<td width="10%">'.character_limiter($document->g_valor_neto,13).'</td>';//Precio Unitario
	$table_data_row.='<td width="15%">'.character_limiter($document->i_valor_venta,22).'</td>';//Cantidad 
	$table_data_row.='<td width="17%"><center>'.character_limiter($valor_sugerido_venta,13).'</center></td>';	//Valor sugerido venta
	//$table_data_row.='<td width="5%">'.anchor($controller_name."/view/$document->id_document/width:$width", $CI->lang->line('common_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_update'))).'</td>';
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view_pre/$document->id_item_document/$valor_total/$document->fk_id_document/width:$width", $CI->lang->line('common_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_update'))).'</td>';				
	$table_data_row.='</tr>';
	
	return $table_data_row;
}
function get_document_manage_table($documents,$controller)
{
	$CI =& get_instance();
	$table='<table class="tablesorter" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />',
	$CI->lang->line('documents_num'),//numero documento
	$CI->lang->line('documents_tipo'),//tipo documento
	$CI->lang->line('documents_fecha'),//fecha
	$CI->lang->line('documents_valor_total'),//valor total
	$CI->lang->line('documents_valor_flete'),//valor flete
	$CI->lang->line('documents_compania'),//compañia
	$CI->lang->line('documents_acciones'),//acciones
	'&nbsp');
	
	$table.='<thead><tr>';
	foreach($headers as $header)
	{
		$table.="<th>$header</th>";
	}
	$table.='</tr></thead><tbody>';
	$table.=get_document_manage_table_data_rows($documents,$controller);
	$table.='</tbody></table>';
	return $table;
}

function get_document_manage_table_data_rows($documents,$controller)
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($documents->result() as $document)
	{
		$table_data_rows.=get_document_data_row($document,$controller);
	}
	
	if($documents->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>".$CI->lang->line('common_no_persons_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}
function get_document_data_row($document,$controller)
{
	$CI =& get_instance();
	$controller_name=$CI->uri->segment(1);
	$width = $controller->get_form_width();
	//print_r($document);
	$table_data_row='<tr>';
	$table_data_row.="<td width='5%'><input type='checkbox' id='document_$document->id_document' value='".$document->id_document."'/></td>";
	$table_data_row.='<td width="17%">'.character_limiter($document->num_doc,13).'</td>';//documento
	$table_data_row.='<td width="17%">'.character_limiter($document->nombre,13).'</td>';//tipo documento
	$table_data_row.='<td width="10%">'.character_limiter($document->fecha,10).'</td>';//fecha
	$table_data_row.='<td width="10%">$ '.character_limiter($document->total,10).'</td>';//valor
	$table_data_row.='<td width="13%">$ '.character_limiter($document->valor_flete,8).'</td>';//valor flete
	$table_data_row.='<td width="13%">'.character_limiter($document->first_name,13).'</td>';		//compañia
	if($document->cerrado == 0){
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view/$document->id_document/width:$width", $CI->lang->line('common_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_update'))).'</td>';
	$table_data_row.='<td width="5%">'.anchor("/products/principal/".$document->id_document."/".$document->total, $CI->lang->line('documents_agregar'),array('title'=>$CI->lang->line($controller_name.'_update'))).'</td>';				
	}
	else{
	$table_data_row.='<td width="5%"></td>';
	$table_data_row.='<td width="5%"></td>';
	}
	$table_data_row.='</tr>';
	
	return $table_data_row;
}
function get_supplier_manage_table($suppliers,$controller)
{
	$CI =& get_instance();
	$table='<table class="tablesorter" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />',
	$CI->lang->line('suppliers_company_name'),
	$CI->lang->line('common_last_name'),
	$CI->lang->line('common_first_name'),
	$CI->lang->line('common_email'),
	$CI->lang->line('common_phone_number'),
	'&nbsp');
	
	$table.='<thead><tr>';
	foreach($headers as $header)
	{
		$table.="<th>$header</th>";
	}
	$table.='</tr></thead><tbody>';
	$table.=get_supplier_manage_table_data_rows($suppliers,$controller);
	$table.='</tbody></table>';
	return $table;
}

/*
Gets the html data rows for the supplier.
*/
function get_supplier_manage_table_data_rows($suppliers,$controller)
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($suppliers->result() as $supplier)
	{
		$table_data_rows.=get_supplier_data_row($supplier,$controller);
	}
	
	if($suppliers->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>".$CI->lang->line('common_no_persons_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}

function get_supplier_data_row($supplier,$controller)
{
	$CI =& get_instance();
	$controller_name=$CI->uri->segment(1);
	$width = $controller->get_form_width();

	$table_data_row='<tr>';
	$table_data_row.="<td width='5%'><input type='checkbox' id='person_$supplier->person_id' value='".$supplier->person_id."'/></td>";
	$table_data_row.='<td width="17%">'.character_limiter($supplier->company_name,13).'</td>';
	$table_data_row.='<td width="17%">'.character_limiter($supplier->last_name,13).'</td>';
	$table_data_row.='<td width="17%">'.character_limiter($supplier->first_name,13).'</td>';
	$table_data_row.='<td width="22%" id="mails">'.mailto($supplier->email,character_limiter($supplier->email,22)).'</td>';
	$table_data_row.='<td width="17%">'.character_limiter($supplier->phone_number,13).'</td>';		
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view/$supplier->person_id/width:$width", $CI->lang->line('common_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_update'))).'</td>';		
	$table_data_row.='</tr>';
	
	return $table_data_row;
}




/*
Gets the html table to manage items.
*/
function get_items_manage_table($items,$controller)
{
	$CI =& get_instance();
	$table='<table class="tablesorter" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />', 
	$CI->lang->line('items_item_number'),
	$CI->lang->line('items_name'),
	$CI->lang->line('items_category'),
	$CI->lang->line('items_cost_price'),
	$CI->lang->line('items_unit_price'),
	$CI->lang->line('items_tax_percents'),
	$CI->lang->line('items_quantity'),
	'&nbsp');
	
	$table.='<thead><tr>';
	foreach($headers as $header)
	{
		$table.="<th>$header</th>";
	}
	$table.='</tr></thead><tbody>';
	$table.=get_items_manage_table_data_rows($items,$controller);
	$table.='</tbody></table>';
	return $table;
}

/*
Gets the html data rows for the items.
*/
function get_items_manage_table_data_rows($items,$controller)
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($items->result() as $item)
	{
		$table_data_rows.=get_item_data_row($item,$controller);
	}
	
	if($items->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='9'><div class='warning_message' style='padding:7px;'>".$CI->lang->line('items_no_items_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}

function get_documents_manage_table_data_rows($items,$controller)
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($items->result() as $document)
	{
		$table_data_rows.=get_document_data_row($document,$controller);
	}
	
	if($items->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='9'><div class='warning_message' style='padding:7px;'>".$CI->lang->line('items_no_items_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}

function get_item_data_row($item,$controller)
{
	$CI =& get_instance();
	$item_tax_info=$CI->Item_taxes->get_info($item->item_id);
	$tax_percents = '';
	foreach($item_tax_info as $tax_info)
	{
		$tax_percents.=$tax_info['percent']. '%, ';
	}
	$tax_percents=substr($tax_percents, 0, -2);
	$controller_name=$CI->uri->segment(1);
	$width = $controller->get_form_width();

	$table_data_row='<tr>';
	$table_data_row.="<td width='5%'><input type='checkbox' id='item_$item->item_id' value='".$item->item_id."'/></td>";
	$table_data_row.='<td width="18%">'.$item->item_number.'</td>';
	$table_data_row.='<td width="17%">'.$item->name.'</td>';
	$table_data_row.='<td width="14%">'.$item->category.'</td>';
	$table_data_row.='<td width="14%">'.to_currency($item->cost_price).'</td>';
	$table_data_row.='<td width="14%">'.to_currency($item->unit_price).'</td>';
	$table_data_row.='<td width="14%">'.$tax_percents.'</td>';	
	$table_data_row.='<td width="14%">'.$item->quantity.'</td>';
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view/$item->item_id/width:$width", $CI->lang->line('common_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_update'))).'</td>';		
	$table_data_row.='</tr>';
	
	return $table_data_row;
}
?>