<?php 
class UserModel extends CI_Model
{
    protected $user_id='';
    protected $group_id='';
    protected $user_department_id='';
    protected $user_access_department_id='';
    protected $access_nodes;

    function __construct()
    {
        $user_data=$this->session->userdata('user_login_data');
        if($user_data){
            $this->user_id=$user_data['USER_ID'];
            $this->user_name=$user_data['name'];
            $this->group_id=$user_data['GROUP_ID'];
            $this->user_access_department_id=$user_data['user_access_department_id'];
            $this->user_department_id=$user_data['user_department_id'];
            $this->access_nodes=$this->GetAccessNodes();
        }else{
            $this->user_name='';
            $this->user_id='0';
            $this->group_id='0';
            $this->user_access_department_id='0';
            $this->user_department_id='0';
            $this->access_nodes='(0)';
        }
        $this->load->database();
    }

    public function access_nodes()
    {
        return $this->access_nodes;
    }


    public function GetAccessNodes()
    {
        $user_id=$this->user_id;
//        $node_code=$this->db->query('SELECT node_path from department
//		inner join `user` on department.id=user_access_department_id where USER_ID='.$user_id)->first_row();
//
//        if($node_code){
//            $node_code=$node_code->node_path;
//        }else{
//            $node_code='';
//        }
//
//        $query = $this->db->query("SELECT
//        GROUP_CONCAT(DISTINCT CONCAT(\"'\", id, \"'\") SEPARATOR ',') AS node_ids
//        FROM department WHERE node_path LIKE '%" . $node_code . "%'");
//
//        $result = $query->result_array();
//        return '(' . $result[0]['node_ids'] . ')';



        $user_access_code=$this->db->query('SELECT user_access_department_id from `user` where USER_ID='.$user_id)->first_row();
        if($user_access_code){
            $user_access_code=$user_access_code->user_access_department_id;
        }else{
            $user_access_code='';
        }

        $this->db->query("SET SESSION group_concat_max_len = 1000000");

        $query = $this->db->query("SELECT
        GROUP_CONCAT(DISTINCT CONCAT(\"'\", id, \"'\") SEPARATOR ',') AS node_ids
        FROM department WHERE id LIKE '".$user_access_code . "%'");

        $result = $query->result_array();
        return '(' . $result[0]['node_ids'] . ')';


//        $query = $this->db->query("SELECT
//        GROUP_CONCAT(DISTINCT id) AS node_ids
//            FROM
//            department WHERE node_path LIKE '%".$node_code."%' ");
//
//        $result=$query->result_array();
//        //return '('.$result[0]['node_ids'].')';
//        return '('.rtrim($result[0]['node_ids'], ',').')';


    }
    
    public function user_access_department_id()
    {
        return $this->user_access_department_id;
    }

    public function user_department_id()
    {
        return $this->user_department_id;
    }

    public function user_id()
    {
        return $this->user_id;
    }
    public function UserName()
    {
        return $this->user_name;
    }
    //group_id
    public function GroupID()
    {
        return $this->group_id;
    }
    public function GetBalance()
    {
        $data=$this->db->query("SELECT SUM(IFNULL(transactions.credit,0))-SUM(IFNULL(transactions.debit,0)) as balance 
        from transactions
        where user_id='".$this->user_id."'");
        if($data->num_rows()>0){
            $row=$data->row();
            return $row->balance;
        }else{
            return 0;
        }
    }
    // GetOrdersCount()
    public function GetOrdersCount()
    {
        $data=$this->db->query("SELECT COUNT(*) as count from `order` where order_user_id='".$this->user_id."'");
        if($data->num_rows()>0){
            $row=$data->row();
            return $row->count;
        }else{
            return 0;
        }
    }
    public function language()
    {
        $user_data=$this->session->userdata('user_login_data');
        return $user_data['ui_language'];
    }
    public function ChangeLanguage($lang){
        
        $user_data=$this->session->userdata('user_login_data');
        $user_data['ui_language']=$lang;
        $this->session->set_userdata('user_login_data', $user_data);

        $this->db->update('user',array('ui_language'=>$lang),array('USER_ID'=>$this->user_id));

        return true;

    }
    public function GoogleAuthCheck($value)
    {
        $user_data=$this->session->userdata('user_login_data');
        $user_data['google_auth_check']=$value;
        $this->session->set_userdata('user_login_data', $user_data);

    }
    // function to add action for user on log table
    public function AddUserLog($table_name,$action,$ID=null,$user_id='')
    {
        if($user_id==''){
            $user_id=$this->user_id;
        }

        /*
                            **** Important Note ****
                        I commented this code because it breaks the consistency of the transaction

        */

        // create table if not exist
//        $this->db->query("CREATE TABLE IF NOT EXISTS `user_log` (
//            `id` int(11) NOT NULL AUTO_INCREMENT,
//            `USER_ID` int(11) NOT NULL,
//            `TABLE_NAME` varchar(255) NOT NULL,
//            `REFERENCE_ID` int(11) NULL,
//            `ACTION` varchar(255) NOT NULL,
//            `ACTION_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
//            PRIMARY KEY (`id`)
//            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
        $data=array(
            'USER_ID'=>$user_id,
            'TABLE_NAME'=>$table_name,
            'REFERENCE_ID'=>$ID,
            'ACTION'=>$action,
        );
        $this->db->insert('user_log',$data);
    }
    
    public function UpdateUserSession()
    {
        $user_id=$this->user_id;
        $query = $this->db->query('SELECT 
            us.USER_ID,
            us.user_picture,
            us.login,
            us.name,
            us.ui_language,
            g.GROUP_ID,
            g.GROUP_NAME,
            us.google_auth,
            us.google_secret_code,
            us.user_department_id,
            us.user_access_department_id,
            us.old_password,
            0 as has_to_change_password
        FROM `user` AS us
        inner join user_group AS us_g on us.USER_ID=us_g.USER_ID
        inner join `group` AS g on us_g.GROUP_ID =g.GROUP_ID
        WHERE us.USER_ID='.$this->db->escape($user_id).' ');
        $results = $query->result_array();
        if($results){
            $results=$results[0];
            if($this->session->userdata('user_login_data')['google_auth_check']=='1'){
                $results['google_auth_check']='1';
                }else{
                    $results['google_auth_check']='0';
                }
            $this->session->set_userdata('user_login_data', $results);
        }
        return true;
    }
    public function GoogleSecretCode()
    {
        $user_data=$this->session->userdata('user_login_data');
        return $user_data['google_secret_code'];
    }
    public function GenerateGoogleSecretCode()
    {
        $this->load->library('Two_FactorAuth');
        $google_auth = $this->two_factorauth->init();
        $secret_code=$google_auth->generateSecret();
        $user_id=$this->user_id;
        if($this->db->update('user',array('google_secret_code'=>$secret_code),array('USER_ID'=>$user_id))){
            $this->UpdateUserSession();
            return true;
        }else{
            return false;
        };
    }
    public function UpdateUserCounter($counter_id)
    {
        $que_counter_user_row=$this->db->query('SELECT * FROM `que_counter_user` WHERE `user_id`='.$this->db->escape($this->user_id))->first_row();
        if($que_counter_user_row){
            $this->db->update('que_counter_user',array('counter_id'=>$counter_id),array('user_id'=>$this->user_id));
        }else{
            $this->db->insert('que_counter_user',array('user_id'=>$this->user_id,'counter_id'=>$counter_id));
        }
    }
    public function GetUserCounterID()
    {
        $que_counter_user_row=$this->db->query('SELECT * FROM `que_counter_user` WHERE `user_id`='.$this->db->escape($this->user_id))->first_row();
        if($que_counter_user_row){
            return $que_counter_user_row->counter_id;
        }else{
            return 0;
        }
    }
    
    public function GetUserCounterTypeID(){
        $CounterId=$this->GetUserCounterID();
        if($CounterId){
            $type_id=$this->db->query('SELECT * FROM `que_counters` WHERE `id`='.$this->db->escape($CounterId))->first_row()->type_id;
            return $type_id;
        }else{
            return 0;
        }
    }
    // GetDrivers
    public function GetDrivers()
    {
        $query = $this->db->query('SELECT  us.USER_ID,us.NAME
        FROM `user` AS us
        inner join user_group AS us_g on us.USER_ID=us_g.USER_ID
        inner join `group` AS g on us_g.GROUP_ID =g.GROUP_ID
        WHERE g.GROUP_NAME="Driver" ');
        $results = $query->result_array();
        return $results;
    }
    // GetTransferUsers
    public function GetTransferUsers()
    {
        $query = $this->db->query('SELECT  us.USER_ID,us.NAME
        FROM `user` AS us
        inner join user_group AS us_g on us.USER_ID=us_g.USER_ID
        inner join `group` AS g on us_g.GROUP_ID =g.GROUP_ID
        WHERE (g.GROUP_NAME="Admin" OR  g.GROUP_NAME="Warehouse") AND us.USER_ID <> '.$this->user_id);
        $results = $query->result_array();
        return $results;
    }

    public function GetActiveUsers() {
        // Get active users only
        $query = $this->db->query("SELECT 
            u.USER_ID as id, 
            u.NAME as `name`,
            u.user_access_department_id as `department_id`
            FROM user u 
            WHERE u.USER_STATUS_ID = 1
            ORDER BY u.NAME");
        
        return $query->result_array();
    }
}
