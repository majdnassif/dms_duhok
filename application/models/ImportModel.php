<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ImportModel extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function GetImportList($filter='', $start=0, $length='-1', $order = '')
    {
//        $access_nodes = $this->UserModel->access_nodes();
//        $filter .= " AND import_to_department_id in $access_nodes";
        $user_access_department_id = $this->UserModel->user_access_department_id();
        $filter .= " AND ( import_to_department_id like '$user_access_department_id%' or import_to_department_id is null )";


        $sql = "SELECT
        `import`.import_id,
        concat(`import`.import_code, `import`.import_id) as import_code,
        `import`.import_book_number,
        `import`.import_book_date,
        `import`.import_book_subject,
        `import`.import_to_department_id,
        d1.`fullpath` as `import_to_department`,
        `import`.import_from_department_id,
        d2.`fullpath` as `import_from_department`,
        `import`.import_received_date,
        `import`.import_incoming_number,
        `import`.import_signed_by,
        `import`.import_book_category_id,
        bc.`book_category_name` as `import_book_category`,
        `import`.import_book_language_id,
        bl.`book_language_name` as `import_book_language`,
        `import`.import_created_by,
        u.`name` as `created_by_name`,
        `import`.import_is_direct,
        `import`.import_is_answer,
        `import`.import_created_at,
           `import`.is_deleted,
        import_trace.import_trace_id,
        import_trace.import_trace_import_trace_type_id,
        import_trace.import_trace_status_id
        
        FROM
        `import`
        left JOIN department d1 ON d1.id = import.import_to_department_id
        left JOIN department d2 ON d2.id = import.import_from_department_id
        LEFT JOIN book_category bc ON bc.book_category_id = import.import_book_category_id
        LEFT JOIN book_language bl ON bl.book_language_id = import.import_book_language_id
        LEFT JOIN user u ON u.USER_ID = import.import_created_by
         left JOIN import_trace  ON import_trace.import_trace_import_id = `import`.import_id   and import_trace.import_trace_status_id != 3

        WHERE 1=1 $filter 
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

    public function GetImportDetails($import_id, $not_deleted = true)
    {
        // If ignore_deleted is true, we will not filter out deleted imports
        if ($not_deleted) {
            $deleted_filter = ' AND import.is_deleted != 1';

        } else {
            $deleted_filter = '';
        }

        // Prepare the SQL query to fetch import details

        $sql = "SELECT
        `import`.*,
         concat( `import`.import_code, `import`.import_id) as import_code,
        d1.`fullpath` as `import_to_department`,
        d2.`fullpath` as `import_from_department`,
        bc.`book_category_name` as `import_book_category`,
        bl.`book_language_name` as `import_book_language`,
        bil.`book_importance_level_name` as `import_book_importance_level`,
        u.`name` as `created_by_name`,
        contacts.name as `contact_name`,
        contacts.email as `contact_email`,
        contacts.phone as `contact_phone`,
        remote_branch.`name` as `remote_branch_name`
        FROM
        `import`
        left JOIN department d1 ON d1.id = import.import_to_department_id
        left JOIN department d2 ON d2.id = import.import_from_department_id
        LEFT JOIN book_category bc ON bc.book_category_id = import.import_book_category_id
        LEFT JOIN book_language bl ON bl.book_language_id = import.import_book_language_id
        LEFT JOIN book_importance_level bil ON bil.book_importance_level_id = import.import_book_importance_level_id
        LEFT JOIN user u ON u.USER_ID = import.import_created_by
        left join contacts on contacts.import_id = import.import_id
        left join system_branches  remote_branch on  `import`.remote_branch_id = remote_branch.id
        WHERE  import.import_id = ?  $deleted_filter";

        $data = $this->db->query($sql, [$import_id])->row_array();

        if ($data) {
            // Convert attachment JSON to array if exists
            if (isset($data['import_attachment']) && !empty($data['import_attachment'])) {
                $data['import_attachment'] = json_decode($data['import_attachment'], true);
            } else {
                $data['import_attachment'] = [];
            }
            return $data;
        } else {
            return null;
        }
    }

    public function AddImport($data)
    {
        // Handle attachments
        if (isset($data['import_attachment']) && is_array($data['import_attachment'])) {
            $data['import_attachment'] = json_encode($data['import_attachment']);
        }

        // Set created by user
        $data['import_created_by'] = $this->UserModel->user_id();
        $data['import_created_by_dep_id'] = $this->UserModel->user_department_id();

        $import_book_date = $data['import_book_date'];
        $year = date('Y', strtotime($import_book_date));
        $isImportExists = $this->isImportExists($data['import_book_number'], $year, $data['import_from_department_id']);

        if($isImportExists){
            $this->session->set_flashdata('error', 'Book number already exists in the current year from this department.');
            return false;
        }


        $this->db->insert('import', $data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            $this->UserModel->AddUserLog('import', 'add', $insert_id);
            return $insert_id;
        } else {
            return false;
        }
    }

    public function UpdateImport($import_id, $data)
    {
        // Handle attachments
        if (isset($data['import_attachment']) && is_array($data['import_attachment'])) {
            $data['import_attachment'] = json_encode($data['import_attachment']);
        }

        $this->db->where('import_id', $import_id);
        $update = $this->db->update('import', $data);

        if ($update) {
            $this->UserModel->AddUserLog('import', 'update', $import_id);
            return true;
        } else {
            return false;
        }
    }

    public function DeleteImport($import_id)
    {

        $this->db->where('import_id', $import_id);
        $data = [
            'is_deleted' => 1
        ];
        $update = $this->db->update('import', $data);

//        $this->db->where('import_id', $import_id);
//        $delete = $this->db->delete('import');

        if ($update) {
            $this->UserModel->AddUserLog('import', 'delete', $import_id);
            return true;
        } else {
            return false;
        }
    }

    public function RestoreImport($import_id)
    {

        $this->db->where('import_id', $import_id);
        $data = [
            'is_deleted' => 0
        ];
        $update = $this->db->update('import', $data);

//        $this->db->where('import_id', $import_id);
//        $delete = $this->db->delete('import');

        if ($update) {
            $this->UserModel->AddUserLog('import', 'restored', $import_id);
            return true;
        } else {
            return false;
        }
    }



    public function AddImportAnswer($import_id, $out_id, $out_book_number, $out_book_date, $out_from_department_id)
    {

        $data = [
            'import_id' => $import_id,
            'out_id' => $out_id,
            'out_book_number' => $out_book_number,
            'out_book_issue_date' => $out_book_date,
            'out_from_department_id' => $out_from_department_id,
            'created_by' => $this->UserModel->user_id(),
        ];
        $this->db->insert('import_answers', $data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            $this->UserModel->AddUserLog('import_answers', 'add', $insert_id);
            return $insert_id;
        } else {
            return false;
        }
    }

    public function GetAnswers($import_id)
    {
        $sql = "SELECT
        ia.*,
        d.`fullpath` as `out_from_department`,
        u.`name` as `created_by_name`
        FROM
        `import_answers` ia
        INNER JOIN department d ON d.id = ia.out_from_department_id
        LEFT JOIN user u ON u.USER_ID = ia.created_by
        WHERE import_id = ?
        and ia.deleted_at IS NULL
        order by ia.id desc";

        $data = $this->db->query($sql, [$import_id])->result_array();

        if ($data) {
            return $data;
        } else {
            return [];
        }
    }

    public function DeleteAnswers($import_id)
    {
        $this->db->where('import_id', $import_id);
        $this->db->delete('import_answers');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function SoftDeleteAnswers($import_id)
    {
        $this->db->where('import_id', $import_id);
        $this->db->update('import_answers', ['deleted_at' => date('Y-m-d H:i:s')]);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function restoreAnswers($import_id)
    {
        $this->db->where('import_id', $import_id);
        $this->db->update('import_answers', ['deleted_at' => null]);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }



    public function GetAnswerDetails($answer_id)
    {
        $sql = "
           SELECT
            ia.*,
            d.`fullpath` as `out_from_department`,
            u.`name` as `created_by_name`
            FROM
            `import_answers` ia
            INNER JOIN department d ON d.id = ia.out_from_department_id
            LEFT JOIN user u ON u.USER_ID = ia.created_by
            WHERE ia.id = ?
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
        $delete = $this->db->delete('import_answers');

        if ($delete) {
            $this->UserModel->AddUserLog('import_answers', 'delete', $answer_id);
            return true;
        } else {
            return false;
        }
    }

    public function GetImportRelatedToAnswer($import_book_number = null, $import_book_date = null, $import_from_department_id = null)
    {

        $filters = "import_book_number = '$import_book_number' ";

        if ($import_book_date) {
            $filters .= " AND import_book_date = '$import_book_date' ";
        }
        if ($import_from_department_id) {
            $filters .= " AND import_from_department_id = '$import_from_department_id' ";
        }

        $sql = "select import_id as 'id', import_book_subject from  `import` where $filters";

        $data = $this->db->query($sql)->row_array();

        if ($data) {
            return $data;
        } else {
            return null;
        }
    }

    public function AddSpecialForm($data)
    {

        $this->db->insert('import_special_form', $data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            $this->UserModel->AddUserLog('import_special_form', 'add', $insert_id);
            return $insert_id;
        } else {
            return false;
        }
    }

    public function AddContact($data)
    {

        $this->db->insert('contacts', $data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            $this->UserModel->AddUserLog('contacts', 'add', $insert_id);
            return $insert_id;
        } else {
            return false;
        }
    }

    public function GetSpecialForms($import_id)
    {
        $sql = "SELECT 
                  import_special_form.*,
                  u.`name` as `created_by_name`
                 FROM `import_special_form`
                join  `user` u on import_special_form.created_by =  u.USER_ID
                 where import_id = ?
              order by id asc";

        $data = $this->db->query($sql, [$import_id])->result_array();

        if ($data) {
            return $data;
        } else {
            return [];
        }
    }

    public function GetSpecialFormDetails($id)
    {
        $sql = "SELECT * from import_special_form 
                where id = ?";

        $data = $this->db->query($sql, [$id])->row_array();

        if ($data) {
            $import_id = $data['import_id'];
            $sql_total_note_block =  "SELECT (sum(page_number) * 4 )  as 'total_blocks'  FROM `import_special_form`
                                    where import_id = $import_id
                                    and id <= $id";
            $data['total_blocks'] = $this->Get_info->select_query($sql_total_note_block)[0]['total_blocks'];
            $data['start_from_block'] = $data['total_blocks'] - ( $data['page_number'] * 4)  ;
            return $data;
        } else {
            return null;
        }
    }


    public function isImportExists($book_number, $year, $from_department_id , $import_id = null)
    {
        // If out_id is provided, exclude it from the check
        if ($import_id) {
            $sql = "SELECT COUNT(*) AS count FROM`import` 
                        WHERE import_book_number = ? 
                         AND YEAR ( import_book_date ) = ? 
                         And import_from_department_id = ?
                          AND import_id != ?";
            $result = $this->db->query($sql, [$book_number, $year, $from_department_id,  $import_id])->row_array();
        } else{
            $sql = "SELECT COUNT(*) AS count FROM`import` 
                        WHERE import_book_number = ? 
                         AND YEAR ( import_book_date ) = ? 
                         And import_from_department_id = ?";

            $result = $this->db->query($sql, [$book_number, $year, $from_department_id])->row_array();
        }


        if ($result) {
            return $result['count'] > 0;
        } else {
            return false;
        }
    }

} 