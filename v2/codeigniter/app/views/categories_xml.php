<?php 


$this->load->helper('xml');
$dom = xml_dom();
$services = xml_add_child($dom, 'services');


foreach($query->result() as $row) {

$service = xml_add_child($services, 'service');

xml_add_child($service, 'service_code', $row->id);
xml_add_child($service, 'metadata', 'true');
xml_add_child($service, 'type', 'realtime');
xml_add_child($service, 'keywords', '');
xml_add_child($service, 'group', '');
xml_add_child($service, 'service_name', $row->form_title);
xml_add_child($service, 'description', $row->form_description);

}

xml_print($dom);



?>



