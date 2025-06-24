<?php
require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");
class Products extends Secure_area implements iData_controller
{
	function __construct()
	{
		parent::__construct('products');
	}

	function index()
	{
		$data['controller_name']=strtolower($this->uri->segment(1));
		$data['form_width']=$this->get_form_width();
		$data['manage_table']=get_product_manage_table($this->Product->get_all(),$this);
		$this->load->view('products/manage',$data);
	}

	function principal($document, $valor_total)
	{
		$data['controller_name']=strtolower($this->uri->segment(1));
		$data['form_width']=$this->get_form_width();
		$data['manage_table']=get_product_manage_table($this->Product->get_all_principal($document),$this, $this->Product->get_sum_products($document), $valor_total, $document, $this->Product->get_cant_products($document), $this->Product->get_valor_flete($document));
		$data['id_document'] = $document;
		$data['valor_total'] = $valor_total;
 		$this->load->view('products/manage',$data);
	}
	
	function find_item_info()
	{
		$item_number=$this->input->post('scan_item_number');
		echo json_encode($this->Item->find_item_info($item_number));
	}

	function search()
	{
		$search=$this->input->post('search');
		$data_rows=get_documents_manage_table_data_rows($this->Item->search($search),$this);
		echo $data_rows;
	}

	/*
	Gives search suggestions based on what is being searched for
	*/
	function suggest()
	{
		$suggestions = $this->Item->get_search_suggestions($this->input->post('q'),$this->input->post('limit'));
		echo implode("\n",$suggestions);
	}

	/*
	Gives search suggestions based on what is being searched for
	*/
	function suggest_category()
	{
		$suggestions = $this->Item->get_category_suggestions($this->input->post('q'));
		echo implode("\n",$suggestions);
	}

	function get_row()
	{
		$document_id = $this->input->post('row_id');
		$data_row=get_document_data_row($this->Document->get_info($document_id),$this);
		echo $data_row;
	}
	function view($producto_id=-1)
	{
		
		$data['product_info']=$this->Product->get_info($producto_id);
		$item = array('' => $this->lang->line('items_none'));
		foreach($this->Product->get_items()->result_array() as $row)
		{
			$item[$row['item_id']] = $row['name'];
		}
		$data['item']=$item;
		$data['selected_item'] = $this->Product->get_info($producto_id)->fk_item_id;
		$this->load->view("products/form",$data);
	}
	function view_pre($producto_id=-1,$valor_total,$id_document)
	{
		
		$data['product_info']=$this->Product->get_info($producto_id);
		$item = array('' => $this->lang->line('items_none'));
		foreach($this->Product->get_items()->result_array() as $row)
		{
			$item[$row['item_id']] = $row['name'];
		}
		$data['item']=$item;
		$data['selected_item'] = $this->Product->get_info($producto_id)->fk_item_id;
		$data['valor_total']=$valor_total;
		$data['tipo_doc']=$this->Product->get_valor_tipodoc($id_document);
		$this->load->view("products/form",$data);
	}
	function view_new($id_document,$valor_total)
	{
		//echo $id_document;
		$producto_id=-1;
		$data['product_info']=$this->Product->get_info($producto_id);
		$item = array('' => $this->lang->line('items_none'));
		foreach($this->Product->get_items()->result_array() as $row)
		{
			$item[$row['item_id']] = $row['name'];
		}
		$data['item']=$item;
		$data['selected_item'] = $this->Product->get_info($producto_id)->id_item_document;
		$data['id_document'] = $id_document;
		$data['valor_total'] = $valor_total;
		$data['tipo_doc']=$this->Product->get_valor_tipodoc($id_document);
		$this->load->view("products/form",$data);
	}
	function close_document($id_document){
		if($this->Product->update_quantity($id_document))
			header ("Location:".site_url("documents"));
		else
			echo json_encode(array('success'=>true,'message'=>$this->lang->line('products_successful_adding').' '.
				$produc_data['fk_item_id'],'product_id'=>$produc_data['product_id']));
	} 
	function save($product_id=-1)
	{
		$produc_data = array(
		'fk_id_document'=>$this->input->post('fk_id_document'),
		'fk_item_id'=>$this->input->post('fk_item_id'),	
		'g_valor_neto'=>$this->input->post('g_valor_neto'),
		'g_valor_exento'=>$this->input->post('g_valor_exento'),
		'g_iva'=>$this->input->post('g_iva'),
		'g_total'=>$this->input->post('g_total'),
		'g_cantidad'=>$this->input->post('g_cantidad'),
		'i_valor_neto'=>$this->input->post('i_valor_neto'),
		'i_valor_exento'=>$this->input->post('i_valor_exento'),
		'i_iva'=>$this->input->post('i_iva'),
		'i_total'=>$this->input->post('i_total'),
		'i_valor_sugerido'=>$this->input->post('i_valor_sugerido'),
		'i_valor_venta'=>$this->input->post('i_valor_venta'),
		'porcentaje_desc'=>$this->input->post('porcentaje_desc')
		
		);
		//print_r($produc_data); 
		
		if($this->Product->save($produc_data,$product_id))
		{
			//New supplier
			if($product_id==-1)
			{
				echo json_encode(array('success'=>true,'message'=>$this->lang->line('products_successful_adding').' '.
				$produc_data['fk_item_id'],'product_id'=>$produc_data['product_id']));
			}
			else //previous supplier
			{
				echo json_encode(array('success'=>true,'message'=>$this->lang->line('products_successful_updating').' '.
				$produc_data['fk_item_id'],'product_id'=>$product_id));
			}
		}
		else//failure
		{	
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('products_error_adding_updating').' '.
			$produc_data['fk_item_id'],'product_id'=>-1));
		}
	
	}

	function delete()
	{
		$items_to_delete=$this->input->post('ids');

		if($this->Product->delete_list($items_to_delete))
		{
			echo json_encode(array('success'=>true,'message'=>$this->lang->line('items_successful_deleted').' '.
			count($items_to_delete).' '.$this->lang->line('items_one_or_multiple')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('items_cannot_be_deleted')));
		}
	}

	/*
	get the width for the add/edit form
	*/
	function get_form_width()
	{
		return 520;
	}
	
}
?>