<?php 
class Login extends CI_Model
{
    function __construct()
    {
        $this->load->database();
    }
    public function LoginCheckUser($username,$password, $passwordBeforeCrypt)
    {
        $query = $this->db
            ->query('SELECT  
                    us.USER_ID,
                    us.user_picture,
                    us.login,
                    us.name,
                    us.ui_language,
                    us.USER_STATUS_ID,
                    g.GROUP_ID,
                    g.GROUP_NAME,
                    us.google_auth,
                    us.google_secret_code,
                    us.user_access_department_id,
                    us.user_department_id,
                    us.old_password,
                    if('.$this->db->escape($passwordBeforeCrypt).' = us.old_password, 1, 0) as has_to_change_password
                    FROM `user` AS us
                    inner join user_group AS us_g on us.USER_ID=us_g.USER_ID
                    inner join `group` AS g on us_g.GROUP_ID =g.GROUP_ID
                    WHERE us.LOGIN	='.$this->db->escape($username).' AND us.PASSWORD ='.$this->db->escape($password).' ');
        $results = $query->result_array();
        if($results){
            $results=$results[0];
        }
        return $results;
    }
    
}
