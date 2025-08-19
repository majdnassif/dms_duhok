<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ImportTraceModel extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function GetTraces($import_id)
    {
        $sql = "SELECT
                    it.import_trace_id,
                    it.import_trace_sent_date,
                    it.import_trace_close_date,
                    if(it.import_trace_status_id = 1, 0, 1) as  `import_trace_is_read`,
                    o.id,
                    o.out_book_number,
                    o.out_book_issue_date,
                    do1.`fullpath` AS `out_to_department`,
                    do2.`fullpath` AS `out_from_department`,
                    bc.`book_category_name` AS `out_book_category`,
                    bl.`book_language_name` AS `out_book_language`,
                    itt.import_trace_type_name,
                    itt.import_trace_type_icon,
                    its.import_trace_status_id,
                    its.import_trace_status_name,
                    its.import_trace_status_icon,
                    d1.fullpath AS sender_department,
                    d2.fullpath AS receiver_department,
                    u1.NAME AS sender_user,
                    u2.NAME AS receiver_user,
                    ita.id AS action_type_id,
                    ita.name AS action_type_name
                FROM
                    import_trace it
                    LEFT JOIN `out` o ON o.id = it.out_id
                    LEFT JOIN book_category bc ON bc.book_category_id = o.out_book_category_id
                    LEFT JOIN book_language bl ON bl.book_language_id = o.out_book_language_id
                    LEFT JOIN department do1 ON do1.id = o.out_to_department_id
                    LEFT JOIN department do2 ON do2.id = o.out_from_department_id
                    LEFT JOIN import_trace_type itt ON itt.import_trace_type_id = it.import_trace_import_trace_type_id
                    LEFT JOIN import_trace_status its ON its.import_trace_status_id = it.import_trace_status_id
                    LEFT JOIN department d1 ON d1.id = it.import_trace_sender_department_id
                    LEFT JOIN department d2 ON d2.id = it.import_trace_receiver_department_id
                    LEFT JOIN user u1 ON u1.USER_ID = it.import_trace_sender_user_id
                    LEFT JOIN user u2 ON u2.USER_ID = it.import_trace_receiver_user_id 
                    LEFT JOIN import_trace_action_types ita ON ita.id = it.import_trace_action_type_id
                WHERE
                    it.import_trace_import_id = ? 
                ORDER BY
                    it.import_trace_id DESC";

        $data = $this->db->query($sql, [$import_id])->result_array();

        if ($data) {
            foreach ($data as &$trace) {
                // Convert attachment JSON to array if exists
                if (isset($trace['import_trace_attachment']) && !empty($trace['import_trace_attachment'])) {
                    $trace['import_trace_attachment'] = json_decode($trace['import_trace_attachment'], true);
                } else {
                    $trace['import_trace_attachment'] = [];
                }
            }
            return $data;
        } else {
            return [];
        }
    }

    public function GetTraceDetails($trace_id)
    {
        $sql = "SELECT
            it.*,
            itt.import_trace_type_name,
            its.import_trace_status_name,
            d1.fullpath as sender_department,
            d2.fullpath as receiver_department,
            u1.name as sender_user,
            u2.name as receiver_user,
            ita.id AS action_type_id,
            ita.name AS action_type_name
        FROM
            import_trace it
            LEFT JOIN import_trace_type itt ON itt.import_trace_type_id = it.import_trace_import_trace_type_id
            LEFT JOIN import_trace_status its ON its.import_trace_status_id = it.import_trace_status_id
            LEFT JOIN department d1 ON d1.id = it.import_trace_sender_department_id
            LEFT JOIN department d2 ON d2.id = it.import_trace_receiver_department_id
            LEFT JOIN user u1 ON u1.USER_ID = it.import_trace_sender_user_id
            LEFT JOIN user u2 ON u2.USER_ID = it.import_trace_receiver_user_id
        left JOIN import_trace_action_types ita ON ita.id = it.import_trace_action_type_id
        WHERE
            it.import_trace_id = ?";

        $data = $this->db->query($sql, [$trace_id])->row_array();

        if ($data) {
            // Convert attachment JSON to array if exists
            if (isset($data['import_trace_attachment']) && !empty($data['import_trace_attachment'])) {
                $data['import_trace_attachment'] = json_decode($data['import_trace_attachment'], true);
            } else {
                $data['import_trace_attachment'] = [];
            }
            return $data;
        } else {
            return null;
        }
    }

    public function GetTraceTypes()
    {
        $sql = "SELECT * FROM import_trace_type ORDER BY import_trace_type_id";
        return $this->db->query($sql)->result_array();
    }

    public function GetActionTypes()
    {
        $sql = "SELECT * FROM import_trace_action_types ORDER BY id";
        return $this->db->query($sql)->result_array();
    }

    public function GetTraceStatuses()
    {
        $sql = "SELECT * FROM import_trace_status ORDER BY import_trace_status_id";
        return $this->db->query($sql)->result_array();
    }

    public function AddTrace($data)
    {
        $this->db->trans_begin();

        try {
            // close previous trace if it exists
            if( $this->ClosePreviousTrace($data['import_trace_import_id']) ){
                // Handle attachments
                if (isset($data['import_trace_attachment']) && is_array($data['import_trace_attachment'])) {
                    $data['import_trace_attachment'] = json_encode($data['import_trace_attachment']);
                }

                // Set sender user ID (current user)
                if (!isset($data['import_trace_sender_user_id']) || empty($data['import_trace_sender_user_id'])) {
                    $data['import_trace_sender_user_id'] = $this->UserModel->user_id();
                }


                // $this->db->insert('import_trace', $data);
                if (!$this->db->insert('import_trace', $data)) {
                    throw new Exception('Insert failed: ' . $this->db->last_query());
                }
                $insert_id = $this->db->insert_id();

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    throw new Exception('Transaction failed');
                }
                $this->db->trans_commit();

                // $this->UserModel->AddUserLog('import_trace', 'add', $insert_id);
                return $insert_id;
            }else{
                throw new Exception('Close previous trace failed');
            }

        } catch (Exception $e) {
            // Rollback the transaction explicitly in case of an exception
            $this->db->trans_rollback();
            log_message('error', $e->getMessage());
            return false;
        }
    }


    public function AddFirstTrace($data)
    {
        $this->db->trans_begin();

        try {

            if (isset($data['import_trace_attachment']) && is_array($data['import_trace_attachment'])) {
                $data['import_trace_attachment'] = json_encode($data['import_trace_attachment']);
            }

            // Set sender user ID (current user)
            if (!isset($data['import_trace_sender_user_id']) || empty($data['import_trace_sender_user_id'])) {
                $data['import_trace_sender_user_id'] = $this->UserModel->user_id();
            }

            $this->db->insert('import_trace', $data);
            $insert_id = $this->db->insert_id();

            // Complete the transaction
            $this->db->trans_commit();

            // Check if the transaction was successful
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Transaction failed');
            }
            $this->UserModel->AddUserLog('import_trace', 'add', $insert_id);
            return $insert_id;


        } catch (Exception $e) {
            // Rollback the transaction explicitly in case of an exception
            $this->db->trans_rollback();
            log_message('error', $e->getMessage());
            return false;
        }
    }

    public function ClosePreviousTrace($importId)
    {
        $lastTrace = $this->GetLastImportLastTrace($importId);

        if ($lastTrace) {
            $data = [
                'import_trace_close_date' => date('Y-m-d H:i:s'),
                'import_trace_status_id' =>  3, // Assuming 3 is the status ID for closed
            ];
            $this->db->where('import_trace_id', $lastTrace['import_trace_id']);
            $update =  $this->db->update('import_trace', $data);
            if ($update) {
                // $this->UserModel->AddUserLog('import_trace', 'update', $lastTrace['import_trace_id']);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function UpdateTrace($trace_id, $data)
    {
        // Handle attachments
        if (isset($data['import_trace_attachment']) && is_array($data['import_trace_attachment'])) {
            $data['import_trace_attachment'] = json_encode($data['import_trace_attachment']);
        }

        $this->db->where('import_trace_id', $trace_id);
        $update = $this->db->update('import_trace', $data);

        if ($update) {
            $this->UserModel->AddUserLog('import_trace', 'update', $trace_id);
            return true;
        } else {
            return false;
        }
    }

    public function DeleteTrace($trace_id)
    {
        $this->db->where('import_trace_id', $trace_id);
        $delete = $this->db->delete('import_trace');

        if ($delete) {
            $this->UserModel->AddUserLog('import_trace', 'delete', $trace_id);
            return true;
        } else {
            return false;
        }
    }

    public function GetLastImportTraceType($import_id)
    {
        $sql = "SELECT import_trace_type_id 
                            FROM import_trace
                            join import_trace_type on import_trace.import_trace_import_trace_type_id = import_trace_type.import_trace_type_id
                            WHERE import_trace_import_id = ? and import_trace_status_id != 3";
        $result = $this->db->query($sql, [$import_id])->row_array();

        if ($result) {
            return $result['import_trace_type_id'];
        } else {
            return null;
        }
    }

    public function GetLastImportLastTrace($import_id)
    {
        $sql = "SELECT 
                import_trace.import_trace_id,
			    import_trace.import_trace_receiver_user_id,
				import_trace.import_trace_status_id,
				import_trace.import_trace_close_date,
				import_trace.import_trace_receiver_department_id,
				import_trace.out_id,
                import_trace_type.*,
                import_trace_status.*,
                import_trace_action_types.name AS action_type_name
                FROM import_trace 
                join import_trace_type on import_trace.import_trace_import_trace_type_id = import_trace_type.import_trace_type_id
                join import_trace_status on import_trace.import_trace_status_id = import_trace_status.import_trace_status_id
                left join import_trace_action_types on import_trace.import_trace_action_type_id = import_trace_action_types.id
                WHERE
                    -- import_trace.import_trace_status_id != 3
                    -- and 
                    import_trace_import_id = ? 
                    order by import_trace.import_trace_id desc
                    limit 1
                    ";
        $result = $this->db->query($sql, [$import_id])->row_array();

        if ($result) {
            return $result;
        } else {
            return null;
        }
    }

    public function UpdateLastTraceIsRead($import_id)
    {
        $sql = "UPDATE import_trace 
                SET 
                    import_trace_read_date = now(),
                    import_trace_read_user_id = ?,
                    import_trace_status_id = 4 -- Assuming 4 is the status ID for read
                WHERE import_trace_import_id = ?
                and import_trace_status_id != 3 -- Exclude closed traces
                ";
        $this->db->query($sql, [$this->UserModel->user_id(), $import_id]);
    }
} 