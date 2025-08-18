<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OutModel extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function GetOutList($filter='', $start=0, $length='-1', $order = '')
    {
//        $access_nodes = $this->UserModel->access_nodes();
//        $filter .= " AND out_from_department_id IN $access_nodes ";


        $user_access_department_id = $this->UserModel->user_access_department_id();
        $filter .= " AND ( out_from_department_id like '$user_access_department_id%' or out_from_department_id is null ) ";

        $sql = "SELECT
                    o.id,
                    o.out_book_subject,
                    o.out_from_department_id,
                    o.out_book_number,
                    o.out_is_deleted,
                    concat(o.out_book_code, o.id) as  out_book_code,
                    o.out_book_issue_date,
                    d1.`fullpath` AS `out_to_department`,
                    d2.`fullpath` AS `out_from_department`,
                    bc.`book_category_name` AS `out_book_category`,
                    bl.`book_language_name` AS `out_book_language`,
                    u.`name` AS `created_by_name` 
                FROM
                    `out` o
                    left JOIN department d1 ON d1.id = o.out_to_department_id
                    left JOIN department d2 ON d2.id = o.out_from_department_id
                    LEFT JOIN book_category bc ON bc.book_category_id = o.out_book_category_id
                    LEFT JOIN book_language bl ON bl.book_language_id = o.out_book_language_id
                    LEFT JOIN user u ON u.USER_ID = o.out_created_by 
                WHERE
                    1=1  $filter 
                $order";


        $count = $this->Get_info->select_query("SELECT count(1) AS `rows` FROM ($sql) AS `temp`")[0]['rows'];
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


    public function GetOutListRemote($branch_id, $filter='', $start=0, $length='-1', $order = '')
    {
//        $access_nodes = $this->UserModel->access_nodes();
//
//        $filter .= " AND out_from_department_id IN $access_nodes ";


        //  $to_departments_ids = $this->getAllSystemDepartmentsIds();
        // $filter .= " AND out_to_department_id IN (" . implode(',', $to_departments_ids) . ") ";

//        $form_department_id = $this->getAllRemoteDepartmentsIds($remote_code);
//        $sql_import = "SELECT CONCAT(import_book_number, '#',YEAR(import_book_date),'#',import_from_department_id) as 'compined_romte_ifo' FROM `import`";

        $branches_id = $this->getBranchIdsToBeAllowedToGetOutRemote();

        $filter .= " AND elec_dep_reference IN (" . implode(',', $branches_id) . ") and out_is_deleted != 1";






        $sql = "SELECT
    
                    o.id,
                    concat(o.out_book_code, o.id) as out_book_code,
                    o.out_book_number,
                    o.out_book_subject,
                    o.out_attachment,
                    o.out_book_issue_date,
                    o.out_from_department_id,
                    o.out_to_department_id,
                    o.elec_dep_reference,
                    d1.`fullpath` AS `out_to_department`,
                    d2.`fullpath` AS `out_from_department`,
                    bc.`book_category_name` AS `out_book_category`,
                    bl.`book_language_name` AS `out_book_language`,
                    u.`name` AS `created_by_name` 
                FROM
                    `out` o
                    INNER JOIN department d1 ON d1.id = o.out_to_department_id
                    INNER JOIN department d2 ON d2.id = o.out_from_department_id
                    LEFT JOIN book_category bc ON bc.book_category_id = o.out_book_category_id
                    LEFT JOIN book_language bl ON bl.book_language_id = o.out_book_language_id
                    LEFT JOIN user u ON u.USER_ID = o.out_created_by 
                WHERE
                    1 =1
                     $filter 
                $order";

        $remote_location = RemoteConnectionMapperHelper::getLocation( $branch_id);

        $remote_db_config = array(
            'dsn'	=> '',
            'hostname' => isset($remote_location['hostname']) ? $remote_location['hostname'] : '',
            'username' => isset($remote_location['username']) ? $remote_location['username'] : '',
            'password' => isset($remote_location['password']) ? $remote_location['password'] : '',
            'database' => isset($remote_location['database']) ? $remote_location['database'] : '',
            'dbdriver' => 'mysqli',
            'dbprefix' => '',
            'pconnect' => FALSE,
            'db_debug' => (ENVIRONMENT !== 'production'),
            'cache_on' => FALSE,
            'cachedir' => '',
            'char_set' => 'utf8',
            'dbcollat' => 'utf8_general_ci',
            'swap_pre' => '',
            'encrypt' => FALSE,
            'compress' => FALSE,
            'stricton' => FALSE,
            'failover' => array(),
            'save_queries' => TRUE
        );

        // run the query on the remote database
        $remote_db = $this->load->database($remote_db_config, TRUE);

        // $remote_db->db_debug = false; // Disable error reporting for remote queries
        $count_query = "SELECT count(*) AS `rows` FROM ($sql) AS `temp`";
        $count_result = $remote_db->query($count_query);


        if (!$count_result) {
            // Handle error if the count query fails
            return ['data' => [], 'count' => 0];
        }


        $count = $count_result->row_array()['rows'];
        if ($length != '-1') {
            $sql .= " LIMIT $start,$length";
        }
        $data = $remote_db->query($sql)->result_array();
        if ($data) {
            return ['data' => $data, 'count' => $count];
        } else {
            return ['data' => [], 'count' => 0];
        }

//        $count = $this->Get_info->select_query("SELECT count(*) AS `rows` FROM ($sql) AS `temp`")[0]['rows'];
//        if ($length != '-1') {
//            $sql .= " LIMIT $start,$length";
//        }
//        $data = $this->Get_info->select_query($sql);
//
//        if ($data) {
//            return ['data' => $data, 'count' => $count];
//        } else {
//            return ['data' => array(), 'count' => 0];
//        }
    }


    public function getAllSystemDepartmentsIds(){
        $sql = "
        WITH RECURSIVE department_paths AS (
            SELECT
                id,
                parent_id
            FROM department
            WHERE 
                is_current = 1
        
            UNION ALL
            -- Recursive member: join child departments to their parents
            SELECT
                d.id,
                d.parent_id
         
            FROM department d
            INNER JOIN department_paths dp ON d.parent_id = dp.id
        )
        SELECT  CONCAT('\'',id,'\'') as id FROM `department_paths`";

        $result = $this->db->query($sql)->result_array();
        $department_ids = array_column($result, 'id');
        return $department_ids;
    }

    public function getBranchIdsToBeAllowedToGetOutRemote(){
        $sql = "select id from system_branches where is_current = 1 or id = 99";

        $result = $this->db->query($sql)->result_array();

        $branches_ids = array_column($result, 'id');
        return $branches_ids;
    }

    public function getAllRemoteDepartmentsIds($remote_code){

        $sql = "
        WITH RECURSIVE department_paths AS (
            SELECT
                id,
                parent_id
            FROM department
            WHERE 
                id = '" .$remote_code. "'
        
            UNION ALL
            -- Recursive member: join child departments to their parents
            SELECT
                d.id,
                d.parent_id
         
            FROM department d
            INNER JOIN department_paths dp ON d.parent_id = dp.id
        )
        SELECT  CONCAT('\'',id,'\'') as id FROM `department_paths`";

        $result = $this->db->query($sql)->result_array();
        $department_ids = array_column($result, 'id');
        return $department_ids;
    }
    public function GetOutDetails($out_id, $not_deleted = true)
    {
        // If ignore_deleted is true, we will not filter out deleted imports
        if ($not_deleted) {
            $deleted_filter = ' AND o.out_is_deleted != 1';
        } else {
            $deleted_filter = '';

        }

        $sql = "SELECT
                    o.*,
                     concat(o.out_book_code, o.id) as  out_book_code,
                    d1.`fullpath` AS `out_to_department`,
                    d2.`fullpath` AS `out_from_department`,
                    bc.`book_category_name` AS `out_book_category`,
                    bl.`book_language_name` AS `out_book_language`,
                    u.`name` AS `created_by_name`,
                    remote_branch.`name` as `remote_branch_name`
                FROM
                    `out` o
                    left JOIN department d1 ON d1.id = o.out_to_department_id
                    left JOIN department d2 ON d2.id = o.out_from_department_id
                    LEFT JOIN book_category bc ON bc.book_category_id = o.out_book_category_id
                    LEFT JOIN book_language bl ON bl.book_language_id = o.out_book_language_id
                    LEFT JOIN user u ON u.USER_ID = o.out_created_by
                	left join system_branches  remote_branch on  o.elec_dep_reference = remote_branch.id
                WHERE
                    o.id = ?  $deleted_filter";

        $data = $this->db->query($sql, [$out_id])->row_array();

        if ($data) {
            // Convert attachment JSON to array if exists
            if (isset($data['out_attachment']) && !empty($data['out_attachment'])) {
                $data['out_attachment'] = json_decode($data['out_attachment'], true);
            } else {
                $data['out_attachment'] = [];
            }
            return $data;
        } else {
            return null;
        }
    }


    public function GetRemoteOutDetails($branch_id, $remote_out_id = null, $remote_out_number = null, $remote_out_date = null, $remote_out_from_department_id = null)
    {
        $filters = "1=1";
        if ($remote_out_id) {
            $filters .= " AND o.id = '$remote_out_id'";
        }
        if ($remote_out_number) {
            $filters .= " AND o.out_book_number = '$remote_out_number'";
        }
        if ($remote_out_date) {
            $filters .= " AND o.out_book_issue_date = '$remote_out_date'";
        }
        if ($remote_out_from_department_id) {
            $filters .= " AND o.out_from_department_id = '$remote_out_from_department_id'";
        }

        $sql = "SELECT
                    o.*,
                    d1.`fullpath` AS `out_to_department`,
                    d2.`fullpath` AS `out_from_department`,
                    bc.`book_category_name` AS `out_book_category`,
                    bl.`book_language_name` AS `out_book_language`,
                    u.`name` AS `created_by_name`
                FROM
                    `out` o
                    INNER JOIN department d1 ON d1.id = o.out_to_department_id
                    INNER JOIN department d2 ON d2.id = o.out_from_department_id
                    LEFT JOIN book_category bc ON bc.book_category_id = o.out_book_category_id
                    LEFT JOIN book_language bl ON bl.book_language_id = o.out_book_language_id
                    LEFT JOIN user u ON u.USER_ID = o.out_created_by
                WHERE  $filters
                  order by o.id desc
                    limit 1
                  ";

        /* i added these two lines to the query
                     order by o.id desc
                     limit 1
                * to ensure that we get the latest out record based on the provided filters.
                * in case of old duplicated out records, this will ensure that we get the latest one.
         * */



        $remote_location = RemoteConnectionMapperHelper::getLocation( $branch_id);

        $remote_db_config = array(
            'dsn'	=> '',
            'hostname' => isset($remote_location['hostname']) ? $remote_location['hostname'] : '',
            'username' => isset($remote_location['username']) ? $remote_location['username'] : '',
            'password' => isset($remote_location['password']) ? $remote_location['password'] : '',
            'database' => isset($remote_location['database']) ? $remote_location['database'] : '',
            'dbdriver' => 'mysqli',
            'dbprefix' => '',
            'pconnect' => FALSE,
            'db_debug' => (ENVIRONMENT !== 'production'),
            'cache_on' => FALSE,
            'cachedir' => '',
            'char_set' => 'utf8',
            'dbcollat' => 'utf8_general_ci',
            'swap_pre' => '',
            'encrypt' => FALSE,
            'compress' => FALSE,
            'stricton' => FALSE,
            'failover' => array(),
            'save_queries' => TRUE
        );

        // run the query on the remote database
        $remote_db = $this->load->database($remote_db_config, TRUE);

        $data = $remote_db->query($sql)->row_array();

        if ($data) {
            return $data;
        } else {
            return null;
        }
    }


    public function AddOut($data)
    {
        // Handle attachments
        if (isset($data['out_attachment']) && is_array($data['out_attachment'])) {
            $data['out_attachment'] = json_encode($data['out_attachment']);
        }

        // Set created by user
        $data['out_created_by'] = $this->UserModel->user_id();

        $data['out_created_by_dep_id'] = $this->UserModel->user_department_id();

        $book_issue_date = $data['out_book_issue_date'];
        $year = date('Y', strtotime($book_issue_date));
        $isBookNumberExist = $this->isBookNumberExistsInYear($data['out_book_number'], $year);
        if($isBookNumberExist) {
            $this->session->set_flashdata('error', 'Book number already exists in the current year.');
            return false;
        }

        $this->db->insert('out', $data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            $this->UserModel->AddUserLog('out', 'add', $insert_id);
            return $insert_id;
        } else {
            return false;
        }
    }

    public function UpdateOut($out_id, $data)
    {
        // Handle attachments
        if (isset($data['out_attachment']) && is_array($data['out_attachment'])) {
            $data['out_attachment'] = json_encode($data['out_attachment']);
        }

        $this->db->where('id', $out_id);
        $update = $this->db->update('out', $data);

        if ($update) {
            $this->UserModel->AddUserLog('out', 'update', $out_id);
            return true;
        } else {
            return false;
        }
    }

    public function DeleteOut($out_id)
    {
        $this->db->where('id', $out_id);
        $data = [
            'out_deleted_at' => date('Y-m-d H:i:s'),
            'out_deleted_by' => $this->UserModel->user_id(),
            'out_is_deleted' => 1
        ];
        $update = $this->db->update('out', $data);
        // $delete = $this->db->delete('import');

        if ($update) {
            $this->UserModel->AddUserLog('out', 'delete', $out_id);
            return true;
        } else {
            return false;
        }
    }

    public function RestoreOut($out_id)
    {

        $this->db->where('id', $out_id);
        $data = [
            'out_is_deleted' => 0
        ];
        $update = $this->db->update('out', $data);

//        $this->db->where('import_id', $import_id);
//        $delete = $this->db->delete('import');

        if ($update) {
            $this->UserModel->AddUserLog('out', 'restored', $out_id);
            return true;
        } else {
            return false;
        }
    }

    public function GetStatuses()
    {
        $sql = "SELECT * FROM out_status ORDER BY id";
        return $this->db->query($sql)->result_array();
    }

    public function GetOUtRelatedToAnswer($out_book_number, $out_book_date = null, $out_from_department_id = null)
    {

        $filters = "out_book_number = '$out_book_number' ";

        if ($out_book_date) {
            $filters .= " AND out_book_issue_date = '$out_book_date' ";
        }
        if($out_from_department_id) {
            $filters .= " AND out_from_department_id = '$out_from_department_id' ";
        }


        $sql = "select id , out_book_subject from `out` where $filters";

        $data = $this->db->query($sql)->row_array();


        if ($data) {
            return $data;
        } else {
            return null;
        }
    }

    public function isBookNumberExistsInYear($book_number, $year, $out_id = null)
    {
        // If out_id is provided, exclude it from the check
        if ($out_id) {
            $sql = "SELECT COUNT(*) as count FROM `out` WHERE out_book_number = ? AND YEAR(out_book_issue_date) = ? AND id != ?";
            $result = $this->db->query($sql, [$book_number, $year, $out_id])->row_array();
        } else{
            $sql = "SELECT COUNT(*) as count FROM `out` WHERE out_book_number = ? AND YEAR(out_book_issue_date) = ?";
            $result = $this->db->query($sql, [$book_number, $year])->row_array();
        }


        if ($result) {
            return $result['count'] > 0;
        } else {
            return false;
        }
    }

    public function AddOutAnswer($out_id, $import_id, $import_book_number, $import_book_date, $import_from_department_id)
    {
        $data = [
            'out_id' => $out_id,
            'import_id' => $import_id,
            'import_book_number' => $import_book_number,
            'import_book_date' => $import_book_date,
            'import_from_department_id' => $import_from_department_id,
            'created_by' => $this->UserModel->user_id(),
        ];
        $this->db->insert('out_answers', $data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            $this->UserModel->AddUserLog('out_answers', 'add', $insert_id);
            return $insert_id;
        } else {
            return false;
        }
    }

    public function GetAnswers($out_id)
    {
        $sql = "SELECT
                    oa.*,
                    d.`fullpath` AS `import_from_department`,
                    u.`name` AS `created_by_name` 
                FROM
                    `out_answers` oa
                    INNER JOIN department d ON d.id = oa.import_from_department_id
                    LEFT JOIN user u ON u.USER_ID = oa.created_by 
                WHERE
                    out_id = ?
                    AND oa.deleted_at IS NULL";

        $data = $this->db->query($sql, [$out_id])->result_array();

        if ($data) {
            return $data;
        } else {
            return [];
        }
    }

    public function GetAnswerDetails($answer_id)
    {
        $sql = "SELECT
                    oa.*,
                    d.`fullpath` AS `import_from_department`,
                    u.`name` AS `created_by_name` 
                FROM
                    `out_answers` oa
                    INNER JOIN department d ON d.id = oa.import_from_department_id
                    LEFT JOIN user u ON u.USER_ID = oa.created_by 
                WHERE
                    oa.id = ?
            ";

        $data = $this->db->query($sql, [$answer_id])->row_array();

        if ($data) {
            return $data;
        } else {
            return null;
        }
    }

    public function DeleteAnswer($answer_id)
    {
        $this->db->where('id', $answer_id);
        $delete = $this->db->delete('out_answers');

        if ($delete) {
            $this->UserModel->AddUserLog('out_answers', 'delete', $answer_id);
            return true;
        } else {
            return false;
        }
    }


    public function SoftDeleteAnswers($out_id)
    {
        $this->db->where('out_id', $out_id);
        $this->db->update('out_answers', ['deleted_at' => date('Y-m-d H:i:s')]);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function restoreAnswers($out_id)
    {
        $this->db->where('out_id', $out_id);
        $this->db->update('out_answers', ['deleted_at' => null]);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }


} 