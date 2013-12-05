<?php
class Product extends Model
{	
	/*
	Determines if a given item_id is an item
	*/
	function exists($item_document)
	{
		$this->db->from('item_document');	
		$this->db->where('id_item_document',$item_document);
		$query = $this->db->get();
		
		return ($query->num_rows()==1);
	}
		
	/*
	Returns all the items
	*/
	function get_sum_products($document){
		
		$this->db->select_sum('g_total');
		$this->db->where('fk_id_document',$document);
		$query = $this->db->get('item_document');
		
		return $query->row()->g_total;

	}
	
	function get_cant_products($document){
		
		$this->db->from('item_document');	
		$this->db->where('fk_id_document',$document);
		$query = $this->db->get();
		$cantidad = $query->num_rows;
				
		return $cantidad; 
		
	}
	function get_valor_flete($document){
	$this->db->from('document');	
		$this->db->where('id_document',$document);
		$query = $this->db->get();
		$flete = $query->row()->valor_flete;
		return $flete;
	}
	function get_valor_tipodoc($document){
	$this->db->from('document');	
		$this->db->where('id_document',$document);
		$query = $this->db->get();
		$tipodoc = $query->row()->fk_id_type_doc;
		return $tipodoc;
	}
	function get_all()
	{
		$this->db->from('item_document');
		$this->db->where('fk_id_document',$document);
		$this->db->join('items', 'items.item_id = item_document.fk_item_id');
		$this->db->order_by("id_item_document", "asc");
		return $this->db->get();		
	}

	function get_all_principal($document)
	{
		$this->db->from('item_document');
		$this->db->where('fk_id_document',$document);
		$this->db->join('items', 'items.item_id = item_document.fk_item_id');
		$this->db->order_by("id_item_document", "asc");
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
	function get_info($product_id)
	{
		$this->db->from('item_document');
		$this->db->where('id_item_document',$product_id);
		//$this->db->join('items', 'items.items_id = item_document.fk_item_id');
		//$this->db->join('people', 'people.person_id = item_document.person_id');
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
			$fields = $this->db->list_fields('item_document');
			//print_r($fields);
			//$item_obj->fk_id_document = 666;
			//$item_obj->g_valor_exento = '';
			//$item_obj->g_cantidad = '';

			
			foreach ($fields as $field)
			{
				$item_obj->$field='';
			}
			
			return $item_obj;
		}
	}
	

	function get_items()
	{
		$this->db->from('items');
		$this->db->order_by("item_id", "asc");
		return $this->db->get();
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
	function save(&$product_data,$product_id=false)
	{		
		if (!$product_id or !$this->exists($product_id))
		{
		
			if($this->db->insert('item_document',$product_data))
			{
				$product_data['product_id']=$this->db->insert_id();
				return true;
			}
			return false;
			unset($product_data['fk_id_document']);
		}
		//con unset se saca el campo id_document que tiene un valor vacio para update
		
		$this->db->where('id_item_document', $product_id);
		return $this->db->update('item_document',$product_data);		
	}
	
	/*
	Updates multiple items at once
	*/
	function update_multiple($item_data,$item_ids)
	{
		$this->db->where_in('item_id',$item_ids);
		return $this->db->update('items',$item_data);		
	}

	function update_quantity($document){
		$retorno = false;
		$this->db->trans_start();
		$consulta = $this->db->query("SELECT * FROM item_document WHERE fk_id_document=".$document);
		if($consulta->num_rows() > 0)
		{	
			foreach ($consulta->result() as $fila) {
				$cantidad_actual= $this->db->query("SELECT quantity FROM items WHERE item_id=".$fila->fk_item_id);
				$cantidad = $cantidad_actual->row();
				$cantidad_total = $cantidad->quantity + $fila->g_cantidad;
				$data = array('quantity'=>$cantidad_total, 'unit_price'=>$fila->i_valor_venta);
				$this->db->update('items', $data, array('item_id'=>$fila->fk_item_id));
			}
				$data2 = array('cerrado'=>1);
				$retorno = $this->db->update('document', $data2, array('id_document'=>$document));	
			
		}	
		$this->db->trans_complete();
		return $retorno;
	}
	/*
	Deletes one item
	*/
	function delete($id_item_document)
	{
		return $this->db->delete('item_document', array('id_item_document' => $id_item_document)); 
	}
	
	/*
	Deletes a list of items
	*/
	function delete_list($id_item_document)
	{
		$this->db->where_in('id_item_document',$id_item_document);
		return $this->db->delete('item_document');		
 	}
 	
 	/*
	Get search suggestions to find items
	*/
	function get_search_suggestions($search,$limit=25)
	{
		$suggestions = array();
		
		$this->db->from('items');
		$this->db->like('name', $search); 
		$this->db->order_by("name", "asc");		
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=$row->name;		
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
