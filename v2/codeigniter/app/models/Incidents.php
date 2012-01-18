<?php
class Incidents extends Model {



    function Incidents()
    {
        // Call the Model constructor
        parent::Model();
    }
    
    function get_last_ten_entries()
    {
        //$query = $this->db->get('entries', 10);
        //return $query->result();
    }

}

?>