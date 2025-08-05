<?php 
class Permission extends CI_Model
{
    function __construct()
    {
        $this->load->database();
    }
    function CheckPermission(){
        $user_data=$this->session->userdata('user_login_data');
        $user_id=$user_data['USER_ID'];
        $class=strtolower($this->router->fetch_class());
        $method=strtolower($this->router->fetch_method());

        if(str_starts_with($method, 'ajax')){
            return true;
        }

        $operation=$class.'_'.$method;          
        $query = $this->db->query("SELECT gp.OPERATION_NAME FROM `user` us 
        inner join user_group us_g on us.USER_ID=us_g.USER_ID
        inner join group_permission gp on gp.GROUP_ID=us_g.GROUP_ID
        where us.USER_ID=$user_id AND gp.OPERATION_NAME ='$operation'");
        $result = $query->result_array();
        $permission=false;
        if($result){
            $permission=true;
        }
       return $permission;

    }
    public function CheckPermissionClass($ClassName)
    {
        $user_data=$this->session->userdata('user_login_data');
        $user_id=$user_data['USER_ID'];

        $query = $this->db->query("SELECT gp.OPERATION_NAME FROM `user` us 
        inner join user_group us_g on us.USER_ID=us_g.USER_ID
        inner join group_permission gp on gp.GROUP_ID=us_g.GROUP_ID
        where us.USER_ID=$user_id AND gp.OPERATION_NAME LIKE '".$ClassName."_%'");
        $results = $query->result_array();
        $permission=false;
        if($results){
            $permission=true;
        }
       return $permission;
        
    }
    public function CheckPermissionOperation($OPERATION_NAME)
    {
        
        
        $user_data=$this->session->userdata('user_login_data');
        $user_id=$user_data['USER_ID'];
        if($OPERATION_NAME=='admin_index'){
            $result =true;
        }else{
            $query = $this->db->query("SELECT gp.OPERATION_NAME FROM `user` as us 
            inner join user_group us_g on us.USER_ID=us_g.USER_ID
            inner join group_permission gp on gp.GROUP_ID=us_g.GROUP_ID
            where us.USER_ID=$user_id AND gp.OPERATION_NAME = '".strtolower($OPERATION_NAME)."'");
            $result = $query->result_array();
        }
        $permission=false;
        if($result){
            $permission=true;
        }
       return $permission;
        
    }
    
}
