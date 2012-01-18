<?php

class Reports extends Controller {

	function Reports()
	{
		parent::Controller();
		$this->load->helper('xml');
		
		// Be sure to comment out or disable this for production
		$this->load->scaffolding('georeport_reports');
        
			
	}
	
	function index()
	{
		$data['query'] = $this->db->get('georeport_reports');
		
		$this->load->view('reports_xml', $data);
	}
	
	
	
	

	function post_report($format)
	{
		
		
		$service_code = (!empty($_POST['service_code'])) ? $_POST['service_code'] : '';
		$description = (!empty($_POST['description'])) ? $_POST['description'] : '';
		$lat = (!empty($_POST['lat'])) ? $_POST['lat'] : '';
		$long = (!empty($_POST['long'])) ? $_POST['long'] : '';
		$requested_datetime = (!empty($_POST['requested_datetime'])) ? $_POST['requested_datetime'] : date("Y-m-d H:i:s",time());
		$address_string = (!empty($_POST['address_string'])) ? $_POST['address_string'] : '';
		$address_id = (!empty($_POST['address_id'])) ? $_POST['address_id'] : '';
		$email = (!empty($_POST['email'])) ? $_POST['email'] : '';
		$device_id = (!empty($_POST['device_id'])) ? $_POST['device_id'] : '';
		$account_id = (!empty($_POST['account_id'])) ? $_POST['account_id'] : '';
		$first_name = (!empty($_POST['first_name'])) ? $_POST['first_name'] : '';
		$last_name = (!empty($_POST['last_name'])) ? $_POST['last_name'] : '';
		$phone = (!empty($_POST['phone'])) ? $_POST['phone'] : '';
		$media_url = (!empty($_POST['media_url'])) ? $_POST['media_url'] : '';		



		$location = array(
					'location_name' 	=> $address_string      ,
			        'latitude'			=> $lat               ,
			        'longitude' 		=> $long              ,
			        'location_date' 	=> $requested_datetime
		            );
		
		$this->db->insert('location', $location); 		
		$location_id = $this->db->insert_id();
				
				
		$incident = array(				
					'location_id'               => $location_id     	,
					'form_id'                   => $service_code       				,
					'locale'                    => 'en_US'              ,
					'user_id'                   => 0	                ,
					'incident_description'      => $description    		,
					'incident_date'             => $requested_datetime  ,
					'incident_mode'             => 1             		,
					'incident_active'           => 0         			,
					'incident_verified'       	=> 0        			,
					'incident_rating'           => 0             		,
					'incident_dateadd'          => $requested_datetime	,         
					'incident_alert_status'     => 0
					);  			

		
		$this->db->insert('incident', $incident); 
		
		$report_id = $this->db->insert_id();
		
		// process response depending on format
		if ($format == 'xml') {
			return $this->get_xml_post_response($report_id);
		}
		else {
			// just use xml as the default
			return $this->get_xml_post_response($report_id);
		}
	}



	function get_feed($format)
	{
		// if we're receiving a POST report call. 
		if(!empty($_POST['service_code'])) {
			return $this->post_report($format);
		}
		
		
		$this->db->limit(1000);		

		$this->db->from('incident');		

		$this->db->join('form', 'form.id = incident.form_id', 'left');		
		$this->db->join('location', 'location.id = incident.location_id', 'left');

		/*
		$this->db->from('incident_category');		

		$this->db->join('category', 'incident_category.category_id = category.id');
		$this->db->join('incident', 'incident_category.incident_id = incident.id');		
		$this->db->join('location', 'location.id = incident.location_id');
		*/


		
		// filter the query by each parameter
		if (!empty($_GET['status'])) {
			$this->db->where('incident.incident_active', $_GET['status']);									
		}
		
		if (!empty($_GET['service_code'])) {									
			$this->db->where('form.id', $_GET['service_code']);									
		}		
		
		if (!empty($_GET['start_date'])) {
			$start_date = date("Y-m-d H:i:s", strtotime($_GET['start_date']));
			$this->db->where('incident.incident_date >=', $start_date);									
		}		
		
		if (!empty($_GET['end_date'])) {
			$end_date = date("Y-m-d H:i:s", strtotime($_GET['end_date']));			
			$this->db->where('incident.incident_date <=', $end_date);									
		}	
		
		$data['query'] = $this->db->get();		
		
		// echo $this->db->last_query();
		
 		switch ($format) {
			case "xml":
				$this->load->view('reports_xml', $data);	
				break;
			case "json":
				$this->load->view('reports_json', $data);	
				break;				
		}
		
	}


	
	function get_xml_report($report_id)
	{
	
		$this->db->from('incident');		

		$this->db->join('form', 'form.id = incident.form_id', 'left');		
		$this->db->join('location', 'location.id = incident.location_id', 'left');
	
		$this->db->where('incident.id', $report_id);						
		$data['query'] = $this->db->get();

		
		$this->load->view('reports_xml', $data);
	}	
	
	
	
	function get_xml_post_response($report_id)
	{
	
		$this->db->from('incident');		

		$this->db->join('form', 'form.id = incident.form_id', 'left');		
		$this->db->join('location', 'location.id = incident.location_id', 'left');
	
		$this->db->where('incident.id', $report_id);						
		$data['query'] = $this->db->get();

		
		$this->load->view('reports_post_response_xml', $data);
	}	
	
	


	
}


?>
