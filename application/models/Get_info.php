<?php 
class Get_info extends CI_Model
{
    function __construct()
    {
        $this->load->database();
    }
    public function select($tablename,$where=null)
    {
        $query = $this->db->select('*')->from($tablename);
        if($where!=NULL){
            $query->where($where);
        }
        $query =$query->get();
        $results = $query->result_array();
        return $results;
    }
    public function select_data($select,$tablename,$where)
    {
        $query = $this->db->select($select)->from($tablename);
        if($where!=NULL){
            $query->where($where);
        }
        $query =$query->get();
        $results = $query->result_array();
        return $results;
    }
    public function select_query($query)
    {
        $data = $this->db->query($query);

        $results = $data->result_array();
        return $results;
    }
    
    function insert_data($tabelname,$data){
        $this->db->insert($tabelname,$data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    
}
