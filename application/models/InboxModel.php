<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InboxModel extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function GetInboxList($filter='', $start=0, $length='-1', $order = '')
    {

        //  $access_nodes=$this->UserModel->access_nodes();
        //$filter .= " AND import_to_department_id IN $access_nodes ";

        // $user_access_department_id = $this->UserModel->user_access_department_id();
        // $filter .= " AND import_to_department_id like '$user_access_department_id%'";

        $sql = "SELECT
        `import`.import_id,
        concat(`import`.import_code,`import`.import_id) as `import_code`,
        `import`.import_from_department_id,
        `department`.`fullpath` as `import_from_department`,
        `import`.import_book_subject,
        `import`.import_received_date,
        `import_trace`.`import_trace_sent_date`,
        `import_trace`.`import_trace_id`,
        `import_trace_type`.`import_trace_type_name`,
        `import_trace_type`.`import_trace_type_icon`,
        `import_trace_status`.`import_trace_status_name`,
        `import_trace_status`.`import_trace_status_icon`,
        IF(`import_trace`.`import_trace_status_id` = 1, 0, 1) as `import_trace_is_read`
        FROM
        `import`
        INNER JOIN department ON department.id = `import`.import_from_department_id
        JOIN import_trace on import_trace.import_trace_import_id = `import`.import_id
				 and import_trace.import_trace_status_id != 3
        LEFT JOIN import_trace_type ON import_trace_type.import_trace_type_id = import_trace.import_trace_import_trace_type_id
        LEFT JOIN import_trace_status ON import_trace_status.import_trace_status_id = import_trace.import_trace_status_id
        WHERE  `import`.is_deleted != 1  $filter 
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

    /**
     * Get count of unread inbox items
     *
     * @param int|null $import_trace_type_id Optional trace type filter
     * @return int Count of unread inbox items
     */
    public function GetUnreadCount($import_trace_type_id = null)
    {
//        $access_nodes = $this->UserModel->access_nodes();
//        $filter = " AND import_to_department_id IN $access_nodes ";

        $user_access_department_id = $this->UserModel->user_access_department_id();
        //  $filter = " AND import_to_department_id like '$user_access_department_id%'";

        // $user_id = $this->UserModel->user_id();
        $filter = "";
        if ($import_trace_type_id == -1) {
            // For received items
            $filter .= " AND `import_trace`.`import_trace_import_trace_type_id` = 1";
            $filter .= " AND `import_trace`.`import_trace_receiver_department_id`  = '$user_access_department_id' ";
        } elseif ($import_trace_type_id !== null) {
            // For specific trace type
            $filter .= " AND `import_trace`.`import_trace_import_trace_type_id` = $import_trace_type_id";

            // Filter by sender/receiver based on trace type
            $user_field = ($import_trace_type_id == 1) ? 'sender' : 'receiver';
            $filter .= " AND `import_trace`.`import_trace_{$user_field}_department_id` = '$user_access_department_id' ";
        }

//        $sql = "SELECT COUNT(1) as count
//                FROM `import`
//                INNER JOIN department ON department.id = `import`.import_from_department_id
//               JOIN import_trace on import_trace.import_trace_import_id = `import`.import_id and import_trace.import_trace_status_id != 3
//                WHERE (IFNULL(`import_trace`.`import_trace_is_read`, 1) = 0 OR `import_trace`.`import_trace_is_read` = 0)
//                $filter";

        $sql = "SELECT COUNT(1) as count
                FROM import_trace 
                WHERE import_trace.import_trace_status_id = 1
                $filter";



        $result = $this->Get_info->select_query($sql);
        return isset($result[0]['count']) ? (int)$result[0]['count'] : 0;
    }

    /**
     * Get total count of inbox items
     *
     * @param int|null $import_trace_type_id Optional trace type filter
     * @return int Total count of inbox items
     */
    public function GetTotalCount($import_trace_type_id = null)
    {
//        $start = microtime(true);
        $access_nodes = $this->UserModel->access_nodes();
//        $filter = " AND import_to_department_id IN $access_nodes ";

        $user_access_department_id = $this->UserModel->user_access_department_id();
        //$filter = " AND import_to_department_id like '$user_access_department_id%'";


        $filter = "";
        // $user_id = $this->UserModel->user_id();

        if ($import_trace_type_id == -1) {
            // For received items
            $filter .= " AND `import_trace`.`import_trace_import_trace_type_id` = 1";
            $filter .= " AND `import_trace`.`import_trace_receiver_department_id`  = '$user_access_department_id' ";
        } elseif ($import_trace_type_id !== null) {
            // For specific trace type
            $filter .= " AND `import_trace`.`import_trace_import_trace_type_id` = $import_trace_type_id";

            // Filter by sender/receiver based on trace type
            $user_field = ($import_trace_type_id == 1) ? 'sender' : 'receiver';
            $filter .= " AND `import_trace`.`import_trace_{$user_field}_department_id` = '$user_access_department_id' ";
        }else{
            // For all items, no specific trace type

            $filter .= " AND `import_trace`.`import_trace_receiver_department_id` = '$user_access_department_id' ";
        }

        $sql = "SELECT COUNT(1) as count
                FROM `import`
                INNER JOIN department ON department.id = `import`.import_from_department_id
                LEFT JOIN import_trace ON import_trace.import_trace_import_id = `import`.import_id and import_trace.import_trace_status_id != 3
                WHERE 1=1 $filter";

        $result = $this->Get_info->select_query($sql);
//        $end = microtime(true);
//        var_dump("GetTotalCount execution time: " . ($end - $start) . " seconds");
//       die();
        return isset($result[0]['count']) ? (int)$result[0]['count'] : 0;
    }



    public function GetTotalCountForAll()
    {
        $user_department_id = $this->UserModel->user_department_id();
        $sql = "select import_trace_type.import_trace_type_id, import_trace_type.import_trace_type_name,
                        import_trace_type.show_order,
                         IFNULL(total_per_type.total,0) as 'total'
                from import_trace_type left join (
                SELECT 
                import_trace_type.import_trace_type_id, 
                 COUNT(1) as 'total'
                    FROM `import`
                    INNER JOIN department ON department.id = `import`.import_from_department_id
                    JOIN import_trace ON import_trace.import_trace_import_id = `import`.import_id and import_trace.import_trace_status_id != 3
                     join import_trace_type on import_trace.import_trace_import_trace_type_id = import_trace_type.import_trace_type_id
                    WHERE 1=1 
                    AND (
                    (import_trace_type.import_trace_type_id = 1 AND import_trace.import_trace_sender_department_id = '$user_department_id')
                    OR 
                    (import_trace_type.import_trace_type_id != 1 AND import_trace.import_trace_receiver_department_id = '$user_department_id')
                )
                 group by import_trace_type.import_trace_type_id
                 
                 ) total_per_type  on total_per_type.import_trace_type_id = import_trace_type.import_trace_type_id
                    order by  import_trace_type.show_order asc
                ";

        $result = $this->Get_info->select_query($sql);

        if ($result) {
            return $result;
        } else {
            return [];
        }
    }


    public function GetTotalCountForAllDashboard()
    {
        $user_department_id = $this->UserModel->user_department_id();
        $sql = "select import_trace_type.import_trace_type_id as id,
                       import_trace_type.import_trace_type_name as name,
                       import_trace_type.import_trace_type_icon as icon,
                        format(IFNULL(total_per_type.total,0), 0) as 'total'
                from import_trace_type left join (
                SELECT 
                import_trace_type.import_trace_type_id, 
                 COUNT(1) as 'total'
                    FROM `import`
                    INNER JOIN department ON department.id = `import`.import_from_department_id
                    JOIN import_trace ON import_trace.import_trace_import_id = `import`.import_id and import_trace.import_trace_status_id != 3
                     join import_trace_type on import_trace.import_trace_import_trace_type_id = import_trace_type.import_trace_type_id
                    WHERE 1=1 
                    and import_trace_type.import_trace_type_id not in (3,4)
                    AND (
                    (import_trace_type.import_trace_type_id = 1 AND import_trace.import_trace_sender_department_id = '$user_department_id')
                    OR 
                    (import_trace_type.import_trace_type_id != 1 AND import_trace.import_trace_receiver_department_id = '$user_department_id')
                )
                 group by import_trace_type.import_trace_type_id
                 
                 ) total_per_type  on total_per_type.import_trace_type_id = import_trace_type.import_trace_type_id
                 where  import_trace_type.import_trace_type_id not in (3,4)
                    order by  import_trace_type.show_order asc
                ";

        $result = $this->Get_info->select_query($sql);

        if ($result) {
            return $result;
        } else {
            return [];
        }
    }

    public function getReceivedTotals()
    {
        $user_department_id = $this->UserModel->user_department_id();

        $sql = "SELECT
                    COUNT( 1 ) AS 'total',
                    COUNT( if( import_trace.import_trace_status_id =1 , 0, 1) ) AS 'unread'
                --  FROM	import_trace 
                  FROM `import`
                  INNER JOIN department ON department.id = `import`.import_from_department_id
                  JOIN import_trace on import_trace.import_trace_import_id = `import`.import_id and import_trace.import_trace_status_id != 3
                WHERE
                    1 = 1 
                    AND import_trace.import_trace_status_id != 3 
                    AND `import_trace`.`import_trace_import_trace_type_id` = 1 
                    AND `import_trace`.`import_trace_receiver_department_id` = '$user_department_id' ";

        $result = $this->Get_info->select_query($sql);

        if ($result) {
            return $result[0];
        } else {
            return [];
        }

    }


}
