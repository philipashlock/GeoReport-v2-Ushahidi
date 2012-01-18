<?php

class Categories extends Controller {

	function Categories()
	{
		parent::Controller();
		$this->load->helper('xml');
		      
			
	}
	
	function index()
	{
		$data['categories'] = $this->db->get('categories');
		
		$this->load->view('categories_xml', $data);
	}
	

	function get_feed($format)
	{

		$this->db->limit(1000);		
		$this->db->from('form');
		
		$data['query'] = $this->db->get();			
		
 		switch ($format) {
			case "xml":
				$this->load->view('categories_xml', $data);	
				break;
			case "json":
				$this->load->view('categories_json', $data);	
				break;				
		}
		
	}


	
	function get_xml_category($category_id)
	{
	
		$this->db->where('form_id', $category_id);
		$this->db->order_by("field_position", "asc"); 						
		$data['attribute_data'] = $this->db->get('form_field');
		$data['category_id'] = $category_id;
	
		$this->load->view('category_attributes_xml', $data);
	}	
	


	
}


?>
