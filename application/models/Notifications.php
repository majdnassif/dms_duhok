<?php 
class Notifications extends CI_Model
{
    protected $user_id='';
    function __construct()
    {
        $user_data=$this->session->userdata('user_login_data');
        if($user_data){
            $this->user_id=$user_data['USER_ID'];
        }
        $this->load->database();
    }
    public function Add($title,$link='#',$user_id=0)
    {
        $this->db->insert('notifications',array('nt_title'=>$title,'nt_link'=>$link,'nt_us_id'=>$user_id));
    }
    public function Get()
    {
        $data=$this->Get_info->select_query("SELECT * FROM notifications where nt_status =0  AND ( nt_us_id = $this->user_id)");
        if($data){
            foreach ($data as $key => $value) {
                $interval = date_create('now')->diff(new DateTime($value['nt_create_date']) );
                    $suffix = ( $interval->invert ? ' ago' : '' );
                    if ( $interval->d >= 1 ){
                        if($interval->d == 1){
                            $data[$key]['nt_create_date']=$interval->d .' day' . $suffix;
                        }else{
                            $data[$key]['nt_create_date']=$interval->d .' days' . $suffix;
                        }
                    }elseif ( $interval->h >= 1 ){
                        if( $interval->h == 1 ){
                            $data[$key]['nt_create_date']=$interval->h .' hour'. $suffix;
                        }else{
                            $data[$key]['nt_create_date']=$interval->h .' hours'. $suffix;
                        }
                    }elseif ($interval->i >= 1 ) {
                        if($interval->i == 1 ) {
                            $data[$key]['nt_create_date']=$interval->i .' minute'. $suffix;
                        }else{
                            $data[$key]['nt_create_date']=$interval->i .' minutes'. $suffix;
                        }
                    }else{
                        $data[$key]['nt_create_date']=$interval->s .' seconds'. $suffix;
                    }
            }
            return $data;
        }else{
            return array();
        }
    }

    public function GetUnreadReceivedAsNotifications()
    {
        $access_nodes = $this->UserModel->access_nodes();

        $filter = " AND import_to_department_id IN $access_nodes ";

        $user_id = $this->UserModel->user_id();


        $filter .= " AND `import_trace`.`import_trace_import_trace_type_id` = 1";
        $filter .= " AND `import_trace`.`import_trace_receiver_user_id` = $user_id";


        $sql = "SELECT import_id as nt_id, import.import_received_date as nt_received_data,  CONCAT('Book Number: ', import_book_number) as nt_title  
                FROM `import`
                INNER JOIN department ON department.id = `import`.import_from_department_id
                JOIN import_trace on import_trace.import_trace_import_id = `import`.import_id
				 and import_trace.import_trace_status_id = 1
                LEFT JOIN import_trace_type ON import_trace_type.import_trace_type_id = import_trace.import_trace_import_trace_type_id
                LEFT JOIN import_trace_status ON import_trace_status.import_trace_status_id = import_trace.import_trace_status_id
                WHERE 1=1
                $filter";

        $data=$this->Get_info->select_query($sql);

        if($data){
//            foreach ($data as $key => $value) {
//                $interval = date_create('now')->diff(new DateTime($value['nt_create_date']) );
//                $suffix = ( $interval->invert ? ' ago' : '' );
//                if ( $interval->d >= 1 ){
//                    if($interval->d == 1){
//                        $data[$key]['nt_create_date']=$interval->d .' day' . $suffix;
//                    }else{
//                        $data[$key]['nt_create_date']=$interval->d .' days' . $suffix;
//                    }
//                }elseif ( $interval->h >= 1 ){
//                    if( $interval->h == 1 ){
//                        $data[$key]['nt_create_date']=$interval->h .' hour'. $suffix;
//                    }else{
//                        $data[$key]['nt_create_date']=$interval->h .' hours'. $suffix;
//                    }
//                }elseif ($interval->i >= 1 ) {
//                    if($interval->i == 1 ) {
//                        $data[$key]['nt_create_date']=$interval->i .' minute'. $suffix;
//                    }else{
//                        $data[$key]['nt_create_date']=$interval->i .' minutes'. $suffix;
//                    }
//                }else{
//                    $data[$key]['nt_create_date']=$interval->s .' seconds'. $suffix;
//                }
//            }
            return $data;
        }else{
            return array();
        }
    }

    private  function GetUnreadCount($import_trace_type_id = -1)
    {

        $result = $this->Get_info->select_query($sql);
        return isset($result[0]['count']) ? (int)$result[0]['count'] : 0;
    }
    
}
