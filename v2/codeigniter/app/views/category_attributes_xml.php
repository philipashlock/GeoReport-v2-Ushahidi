<?php 


$this->load->helper('xml');
$dom = xml_dom();

$service_definition = xml_add_child($dom, 'service_definition');

	$service_code = xml_add_child($service_definition, 'service_code', $category_id);
	$attributes = xml_add_child($service_definition, 'attributes');


	foreach($attribute_data->result() as $row) {

	$attribute = xml_add_child($attributes, 'attribute');

	$required = ($row->field_required) ? 'true' : 'false';
	
	switch ($row->field_type) {
		case 1:
			$datatype = 'string';
			break;
		case 2:
			$datatype = 'text';
			break;			
		case 3:
			$datatype = 'datetime';
			break;
		case 4:
			$datatype = 'string';
			break;			
		case 5:
			$datatype = 'singlevaluelist';
			break;
		case 6:
			$datatype = 'multivaluelist';
			break;		
	}
	

	xml_add_child($attribute, 'variable', 'true');
	xml_add_child($attribute, 'code', $row->id);
	xml_add_child($attribute, 'datatype', $datatype);
	xml_add_child($attribute, 'required', $required);
	xml_add_child($attribute, 'datatype_description', '');
	xml_add_child($attribute, 'order', $row->field_position);
	xml_add_child($attribute, 'description', $row->field_name);
	xml_add_child($attribute, 'values', '');	


	}

xml_print($dom);



?>



