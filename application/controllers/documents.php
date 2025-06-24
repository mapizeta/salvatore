<?php
require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");
class Documents extends Secure_area implements iData_controller
{
	function __construct()
	{
		parent::__construct('documents');
	}

	function index()
	{
		$data['controller_name']=strtolower($this->uri->segment(1));
		$data['form_width']=$this->get_form_width();
		$data['manage_table']=get_document_manage_table($this->Document->get_all(),$this);
		$this->load->view('documents/manage',$data);
	}

	function find_item_info()
	{
		$item_number=$this->input->post('scan_item_number');
		echo json_encode($this->Item->find_item_info($item_number));
	}

	function search()
	{
		$search=$this->input->post('search');
		$data_rows=get_documents_manage_table_data_rows($this->Document->search($search),$this);
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
	function view($supplier_id=-1)
	{
		$data['document_info']=$this->Document->get_info($supplier_id);
		$tipo_doc = array('' => $this->lang->line('items_none'));
		foreach($this->Document->get_type_doc()->result_array() as $row)
		{
			$tipo_doc[$row['id_type_doc']] = $row['nombre'];
		}
		$data['tipo_doc']=$tipo_doc;
		$data['selected_tipo_doc'] = $this->Document->get_info($supplier_id)->fk_id_type_doc;
		$this->load->view("documents/form",$data);
	}
		
	function bulk_edit()
	{
		$data = array();
		$suppliers = array('' => $this->lang->line('items_none'));
		foreach($this->Supplier->get_all()->result_array() as $row)
		{
			$suppliers[$row['person_id']] = $row['first_name'] .' '. $row['last_name'];
		}
		$data['suppliers'] = $suppliers;
		$this->load->view("items/form_bulk", $data);
	}

	function save($document_id=-1)
	{
		$person_data = array(
		'first_name'=>$this->input->post('company_name'),
		'last_name'=> '',
		'email'=> '',
		'phone_number'=>$this->input->post('phone_number'),
		'address_1'=>$this->input->post('address_1'),
		'address_2'=> '',
		'city'=> '',
		'state'=> '',
		'zip'=> '',
		'country'=> '',
		'comments'=> ''		
		);
		$supplier_data=array(
		'company_name'=>$this->input->post('company_name'),
		'rut'=>$this->input->post('rut'),
		'existe_proveedor'=>$this->input->post('existe_proveedor'),
		'person_id'=>$this->input->post('person_id')
		);
		$document_data = array(
		'num_doc'=>$this->input->post('num_doc'),
		'fecha'=>$this->input->post('fecha'),
		'contacto'=>$this->input->post('contacto'),
		'subtotal'=>$this->input->post('subtotal'),
		'afecto_adicional'=>$this->input->post('afecto_adicional'),
		'valor_adicional'=>$this->input->post('valor_adicional'),
		'neto'=>$this->input->post('neto'),
		'iva'=>$this->input->post('iva'),
		'total'=>$this->input->post('total'),
		'fk_id_type_doc'=>$this->input->post('fk_id_type_doc'),
		'fk_rut'=>$this->input->post('rut'),	
		'valor_flete'=>$this->input->post('valor_flete')	
			
		);
		$fecha_origen = $document_data['fecha'];
		$fecha_nueva = date("Y-m-d", strtotime($fecha_origen));
		$document_data['fecha'] = $fecha_nueva;
		
	
		if($this->Document->save($person_data,$supplier_data,$document_data,$document_id))
		{
			//New supplier
			if($document_id==-1)
			{
				echo json_encode(array('success'=>true,'message'=>$this->lang->line('suppliers_successful_adding').' '.
				$document_data['num_doc'],'document_id'=>$document_data['num_doc']));
			}
			else //previous supplier
			{
				echo json_encode(array('success'=>true,'message'=>$this->lang->line('suppliers_successful_updating').' '.
				$document_data['num_doc'],'document_id'=>$document_id));
			}
		}
		else//failure
		{	
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('suppliers_error_adding_updating').' '.
			$document_data['num_doc'],'document_id'=>-1));
		}
	}

	function bulk_update()
	{
		$items_to_update=$this->input->post('item_ids');
		$item_data = array();

		foreach($_POST as $key=>$value)
		{
			//This field is nullable, so treat it differently
			if ($key == 'supplier_id')
			{
				$item_data["$key"]=$value == '' ? null : $value;
			}
			elseif($value!='' and !(in_array($key, array('item_ids', 'tax_names', 'tax_percents'))))
			{
				$item_data["$key"]=$value;
			}
		}

		//Item data could be empty if tax information is being updated
		if(empty($item_data) || $this->Item->update_multiple($item_data,$items_to_update))
		{
			$items_taxes_data = array();
			$tax_names = $this->input->post('tax_names');
			$tax_percents = $this->input->post('tax_percents');
			for($k=0;$k<count($tax_percents);$k++)
			{
				if (is_numeric($tax_percents[$k]))
				{
					$items_taxes_data[] = array('name'=>$tax_names[$k], 'percent'=>$tax_percents[$k] );
				}
			}
			$this->Item_taxes->save_multiple($items_taxes_data, $items_to_update);

			echo json_encode(array('success'=>true,'message'=>$this->lang->line('items_successful_bulk_edit')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('items_error_updating_multiple')));
		}
	}

	function delete()
	{
		$items_to_delete=$this->input->post('ids');

		if($this->Document->delete_list($items_to_delete))
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