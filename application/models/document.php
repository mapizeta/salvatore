<?php
class Document extends Person
{	
	/*
	Determines if a given item_id is an item
	*/
	function exists($document_id)
	{
		$this->db->from('document');	
		$this->db->where('id_document',$document_id);
		$query = $this->db->get();
		
		return ($query->num_rows()==1);
	}
		
	/*
	Returns all the items
	*/
	function get_all()
	{
		$this->db->from('document');
		$this->db->join('suppliers', 'suppliers.person_id = document.person_id');
		$this->db->join('people', 'people.person_id = document.person_id');
		$this->db->join('type_doc', 'type_doc.id_type_doc = document.fk_id_type_doc');
		$this->db->order_by("id_document", "asc");
		return $this->db->get();

	}
	/*
	Retorna los tipos de documentos, ej: facturas, guias de despacho
	*/
	function get_type_doc(){
		$this->db->from('type_doc');
		$this->db->order_by("id_type_doc", "asc");
		return $this->db->get();
	}
	/*
	Gets information about a particular item
	*/
	function get_info($document_id)
	{
		$this->db->from('document');
		$this->db->where('id_document',$document_id);
		$this->db->join('suppliers', 'suppliers.person_id = document.person_id');
		$this->db->join('people', 'people.person_id = document.person_id');
		$query = $this->db->get();
		
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//Get empty base parent object, as $item_id is NOT an item
			$item_obj= new stdClass();
			
			//Get all the fields from items table
			$fields = $this->db->list_fields('document');
			$item_obj->company_name = '';
			$item_obj->address_1 = '';
			$item_obj->phone_number = '';

			foreach ($fields as $field)
			{
				$item_obj->$field='';
			}
			//print_r($item_obj);
			return $item_obj;
		}
	}
	
	/*
	Get an item id given an item number
	*/
	function get_item_id($item_number)
	{
		$this->db->from('items');
		$this->db->where('item_number',$item_number);
		$query = $this->db->get();
		
		if($query->num_rows()==1)
		{
			return $query->row()->item_id;
		}
		
		return false;
	}
	
	/*
	Gets information about multiple items
	*/
	function get_multiple_info($item_ids)
	{
		$this->db->from('items');
		$this->db->where_in('item_id',$item_ids);
		$this->db->order_by("item", "asc");
		return $this->db->get();		
	}
	
	/*
	Inserts or updates a item
	*/
	function save(&$person_data, &$supplier_data, &$document_data, $document_id=false)
	{

		$success=false;
		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();

		if($supplier_data['existe_proveedor'] == 1){

		$document_data['person_id'] = $supplier_data['person_id'];
		
		//quito los campos del arreglo para ejecutar correctamente la consulta
		unset($supplier_data['existe_proveedor']);
		unset($supplier_data['person_id']);
		
		$success = $this->db->insert('document',$document_data);

		}

		else
			if(parent::save($person_data,$document_id))//ingresamos datos de tabla people para obtener el person_id
				{	//echo "se creo persona";
					if (!$document_id or !$this->exists($document_id))
					{	
						//cambio fechas
						$fecha_origen = $document_data['fecha'];
						$fecha_nueva = date("Y-m-d", strtotime($fecha_origen));
						$document_data['fecha'] = $fecha_nueva;
						//fin cambio fechas
						$document_data['person_id'] = $person_data['person_id'];
						$supplier_data['person_id'] = $person_data['person_id'];
						unset($supplier_data['existe_proveedor']);

						//echo "document_data:".$document_data['person_id'];
						//echo "supplier_data:".$supplier_data['person_id'];

						if($this->db->insert('suppliers',$supplier_data)){
							//echo "se creo supplier se inserto documento";
							$success = $this->db->insert('document',$document_data);				
							}
					}
					else
					{
						$this->db->where('id_document', $document_id);
						$success = $this->db->update('document',$document_data);
					}	
				}

		$this->db->trans_complete();		
		return $success;
	}
	
	/*
	Updates multiple items at once
	*/
	function update_multiple($item_data,$item_ids)
	{
		$this->db->where_in('item_id',$item_ids);
		return $this->db->update('items',$item_data);		
	}
	
	/*
	Deletes one item
	*/
	function delete($document_id)
	{
		$success=false;
		
		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();
		
		//delete from customers table
		if($this->db->delete('document', array('document_id' => $document_id)))
		{
			//delete from Person table
			//$success = parent::delete($supplier_id);
		}
		
		$this->db->trans_complete();		
		return $success;
		
	}
	
	/*
	Deletes a list of items
	*/
	function delete_list($id_document)
	{
		$this->db->where_in('id_document',$id_document);
		return $this->db->delete('document');		
 	}
 	
 	/*
	Get search suggestions to find items
	*/
	function get_search_suggestions($search,$limit=25)
	{
		$suggestions = array();
		
		$this->db->from('document');
		$this->db->like('num_doc', $search); 
		$this->db->order_by("num_doc", "asc");		
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=$row->num_doc;		
		}
		
		$this->db->select('category');		
		$this->db->from('items');
		$this->db->distinct();		
		$this->db->like('category', $search); 
		$this->db->order_by("category", "asc");		
		$by_category = $this->db->get();
		foreach($by_category->result() as $row)
		{
			$suggestions[]=$row->category;		
		}

		$this->db->from('items');
		$this->db->like('item_number', $search); 
		$this->db->order_by("item_number", "asc");		
		$by_item_number = $this->db->get();
		foreach($by_item_number->result() as $row)
		{
			$suggestions[]=$row->item_number;		
		}

				
		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;
	
	}
	
	function get_item_search_suggestions($search,$limit=25)
	{
		$suggestions = array();
		
		$this->db->from('items');
		$this->db->like('name', $search); 
		$this->db->order_by("name", "asc");		
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=$row->item_id.'|'.$row->name;		
		}
		
		$this->db->from('items');
		$this->db->like('item_number', $search); 
		$this->db->order_by("item_number", "asc");		
		$by_item_number = $this->db->get();
		foreach($by_item_number->result() as $row)
		{
			$suggestions[]=$row->item_id.'|'.$row->item_number;		
		}
		
		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;

	}
	
	function get_category_suggestions($search)
	{
		$suggestions = array();
		$this->db->distinct();
		$this->db->select('category');
		$this->db->from('items');
		$this->db->like('category', $search); 		
		$this->db->order_by("category", "asc");		
		$by_category = $this->db->get();
		foreach($by_category->result() as $row)
		{
			$suggestions[]=$row->category;		
		}
				
		return $suggestions;
	}
	
	/*
	Preform a search on items
	*/
	function search($search)
	{
		$this->db->from('document');
		$this->db->like('num_doc', $search); 
		$this->db->or_like('fk_rut', $search);
		$this->db->order_by("id_document", "asc");				
		return $this->db->get();	
	}
	
	function get_categories()
	{
		$this->db->select('category');		
		$this->db->from('items');
		$this->db->distinct();		
		$this->db->order_by("category", "asc");		
		
		return $this->db->get();
	}
	
}
?>
