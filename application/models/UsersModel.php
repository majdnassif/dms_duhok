<?php
class UsersModel extends CI_Model
{
    function __construct()
    {
        $this->load->database();
    }
    public function GetUserDetails(int $UserID)
    {
        $data = $this->Get_info->select_query("SELECT
        `user`.USER_ID, 
        `user`.`LOGIN`, 
        `user`.`PASSWORD`, 
        `user`.`NAME`, 
        `user`.UI_LANGUAGE, 
        `user`.USER_STATUS_ID, 
        `user`.user_picture, 
        `user`.telephone, 
        GROUP_CONCAT(`group`.GROUP_NAME) as `group`,
        GROUP_CONCAT(`group`.GROUP_ID) as `GROUP_IDS`,
        user_status.USER_STATUS,
        `user`.user_access_department_id,
        access_department.name as `access_department_name`,
        `user`.user_department_id,
        user_department.name as `user_department_name`
    FROM
        `user`
        INNER JOIN user_status ON `user`.USER_STATUS_ID = user_status.USER_STATUS_ID
        INNER JOIN `user_group` ON `user_group`.USER_ID=`user`.USER_ID
        INNER JOIN `group` ON `group`.GROUP_ID=`user_group`.GROUP_ID
        LEFT JOIN `department` access_department ON access_department.id=`user`.user_access_department_id
        LEFT JOIN `department` user_department ON user_department.id=`user`.user_department_id
        WHERE `user`.USER_ID=$UserID
        GROUP BY `user_group`.USER_ID");
        if ($data) {
            return $data[0];
        } else {
            return false;
        }
    }
    public function GetUsersList($filter='', $start=0, $length='-1', $order = '')
    {
        $sql = "SELECT
        `user`.USER_ID, 
        `user`.LOGIN, 
        `user`.`PASSWORD`, 
        `user`.`NAME`, 
        `user`.UI_LANGUAGE, 
        `user`.USER_STATUS_ID, 
        `user`.user_picture, 
        `user`.telephone, 
        GROUP_CONCAT(`group`.GROUP_NAME) as `GROUPS`,
        GROUP_CONCAT(`group`.GROUP_ID) as `GROUP_IDS`,
        user_status.USER_STATUS,
        user_department.id as user_department_id,
        user_department.fullpath as user_department_fullpath,
        user_access_department.id as user_access_department_id,
        user_access_department.fullpath as user_access_department_fullpath
    FROM
        `user`
        INNER JOIN user_status ON `user`.USER_STATUS_ID = user_status.USER_STATUS_ID
        INNER JOIN `user_group` ON `user_group`.USER_ID=`user`.USER_ID
        INNER JOIN `group` ON `group`.GROUP_ID=`user_group`.GROUP_ID
        left join  department as user_department on user_department.id = `user`.user_department_id
		left join  department as user_access_department on user_access_department.id = `user`.user_access_department_id
        WHERE 1=1 $filter 
        GROUP BY `user_group`.USER_ID
        $order";


        $count = $this->Get_info->select_query("SELECT count(*) AS `rows` FROM ($sql) AS `temp`")[0]['rows'];
        if ($length != '-1') {
            $sql .= " LIMIT $start,$length";
        }
        $data = $this->Get_info->select_query($sql);

        if ($data) {
            return ['data' => $data, 'count' => $count];
        } else {
            return ['data' => array(), 'count' => 0];
        }
    }
    //GetGroups
    public function GetGroups()
    {
        $data = $this->Get_info->select_query("SELECT * FROM `group`");
        if ($data) {
            return $data;
        } else {
            return [];
        }
    }
    //GetUserStatusList
    public function GetUserStatusList()
    {
        $data = $this->Get_info->select_query("SELECT * FROM user_status");
        if ($data) {
            return $data;
        } else {
            return [];
        }
    }
    public function GetGroupsList($filter, $start, $length, $order = '')
    {
        $sql = "SELECT
        `group`.GROUP_ID, 
        `group`.GROUP_NAME, 
        `group`.STATUS_ID, 
        GROUP_CONCAT(group_permission.OPERATION_NAME) as `OPERATIONS_NAME`
    FROM
        `group`
        INNER JOIN group_permission ON  `group`.GROUP_ID = group_permission.GROUP_ID
        WHERE 1=1 $filter 
            GROUP BY GROUP_ID
        $order";
        $count = $this->Get_info->select_query("SELECT count(*) AS `rows` FROM ($sql) AS `temp`")[0]['rows'];
        if ($length != '-1') {
            $sql .= " LIMIT $start,$length";
        }
        $data = $this->Get_info->select_query($sql);

        if ($data) {
            return ['data' => $data, 'count' => $count];
        } else {
            return ['data' => array(), 'count' => 0];
        }
    }
    //GetGroupDetails($GroupID)
    public function GetGroupDetails($GroupID)
    {
        $data = $this->Get_info->select_query("SELECT
        `group`.GROUP_ID, 
        `group`.GROUP_NAME, 
        `group`.STATUS_ID, 
        GROUP_CONCAT(group_permission.OPERATION_NAME) as `OPERATIONS_NAME`
    FROM
        `group`
        LEFT JOIN group_permission ON  `group`.GROUP_ID = group_permission.GROUP_ID
        WHERE `group`.GROUP_ID=$GroupID 
            GROUP BY GROUP_ID");
        if ($data) {
            return $data[0];
        } else {
            return false;
        }
    }
    //GetOperations
    public function GetOperations()
    {
        $data = $this->Get_info->select_query("SELECT * FROM `permission`");
        if ($data) {
            return $data;
        } else {
            return [];
        }
    }
}
