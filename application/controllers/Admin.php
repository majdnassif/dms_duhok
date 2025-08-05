<?php

use Sonata\GoogleAuthenticator\GoogleAuthenticator;

class Admin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('grocery_CRUD');
        $this->load->model('InboxModel');
        $this->load->model('OutModel');

    }
    public function index()
    {
        if($this->session->userdata('user_login_data')){
            if($this->Permission->CheckPermissionOperation('admin_dashboard')){
                redirect('Admin/Dashboard');
            }elseif($this->Permission->CheckPermissionOperation('posts_postslist')){
                redirect(base_url('Posts/PostsList'));
            }else{
                $this->_temp_output('index',['page_title'=>'Dashboard','page_card_title'=>'Dashboard']);
            }
        }else{
            return $this->load->view('Admin2/login');
        }
    }
    public function _temp_output($view,$output=null)
    {
        if($this->session->userdata('user_login_data')){
            $this->load->view("Admin2/header",(array)$output);
            $perm=$this->Permission->CheckPermission();
            if($perm==true){
                $this->load->view("Admin2/$view" ,(array)$output);
            }else{
                $this->load->view('Admin2/permission');
            }
            $this->load->view("Admin2/footer",(array)$output);
        }else{
            return $this->load->view('Admin2/login');
        }
    }

    public function AjaxNotification()
    {
        $data=$this->Notifications->Get();
        echo json_encode(array('count'=>count($data),'data'=>$data));
    }

    public function AjaxUnreadReceived()
    {
        $data=$this->Notifications->GetUnreadReceivedAsNotifications();

        echo json_encode(array('count'=>count($data),'data'=>$data));
    }

    public function AjaxReadNotification($nt_id)
    {
        $this->db->set('nt_status',1);
        $this->db->where('nt_id',$nt_id);
        $this->db->update('notifications');
    }
    public function AjaxChangeLang($lang)
    {
        $this->UserModel->ChangeLanguage($lang);
        echo json_encode(['status'=>'true']);
    }

    public function Login()
    {
        if($this->input->server('REQUEST_METHOD')=='POST'){

            $crypt= new Crypt();
            $username= $this->input->post('username',true);
            $passwordBeforeCrypt = $this->input->post('password',true);
            $password= $crypt->MediaEncrypt($passwordBeforeCrypt);
            $UserData=$this->Login->LoginCheckUser($username,$password, $passwordBeforeCrypt);
            if($UserData){
                if($UserData['USER_STATUS_ID']!=1){
                    $data['message']='Your Account Is Not Active, Please Contact The System Administrator.';
                    return $this->load->view('Admin2/login', $data);
                }
                if($UserData['google_auth']==1){
                    $UserData['google_auth_check']='0';
                }else{
                    $UserData['google_auth_check']='1';
                }
                $this->session->set_userdata('user_login_data',$UserData);
                $this->index();
            }else{
                $data['message']='Please Check Your Username Or Password.';
                return $this->load->view('Admin2/login', $data);
            }
        }else{
            $this->index();
        }
    }

    public function changepassword(){

        if(!$this->session->userdata('user_login_data')){
            redirect(base_url('Admin/login'));
        }
        if($this->input->server('REQUEST_METHOD')=='POST'){

            $data_post=$this->security->xss_clean($this->input->post());
            //password
            if($data_post['PASSWORD']!=''){
                $this->form_validation->set_rules('PASSWORD', 'Password', 'trim|required|min_length[6]');
                $this->form_validation->set_rules('PASSWORD_CONFIRM', 'Password Confirmation', 'trim|required|matches[PASSWORD]');
            }
            if ($this->form_validation->run() == FALSE)
            {
                $data['message'] = validation_errors();
                //return $this->load->view('Admin2/changepassword', $data);
                echo json_encode(['status' => 'failed', 'message' => $data['message']]);

            }else{

                $UserID = $this->session->userdata('user_login_data')['USER_ID'];
                $UserOldPassword = $this->session->userdata('user_login_data')['old_password'];


                if($UserOldPassword == $data_post['PASSWORD']){

                    $data['message'] = 'You can\'t use the old password';
                    //return $this->load->view('Admin2/changepassword', $data);
                    echo json_encode(['status' => 'failed', 'message' => $data['message']]);
                }
                else{
                    if($data_post['PASSWORD']!=''){
                        $crypt=new Crypt();
                        $data['PASSWORD']=$crypt->MediaEncrypt($data_post['PASSWORD']);
                    }
                    //Update session data
                    $this->db->update('user',$data,['USER_ID'=>$UserID]);
                    $this->UserModel->UpdateUserSession();
                    echo json_encode(['status' => 'success', 'message' => 'Password Updated Successfully']);
                    //redirect('admin/Dashboard');
                }

            }

        }
        else{

            return $this->load->view('Admin2/changepassword');
        }
    }
    public function google_auth()
    {
        $google_auth = new GoogleAuthenticator();
        if ( $this->input->method(true) === "POST" ) {
            $code = $this->input->post('code');
            $secret_code=$this->session->userdata('user_login_data')['google_secret_code'];
            if ( $google_auth->checkCode($secret_code, $code)) {
                $this->UserModel->GoogleAuthCheck('1');
                $this->index();
            } else {
                $data['message'] = "Entered Invalid code, try again";
                $this->load->view('Admin/GoogleAuth/LockScreen.php', $data);
            }
        }else{
            if($this->session->userdata('user_login_data')['google_secret_code']==1){
                $this->index();
            }else{
                $this->load->view('Admin/GoogleAuth/LockScreen.php');
            }
        }
    }
    public function Logout()
    {
        // Clear all session data first
        $this->session->unset_userdata('user_login_data');
        $this->session->unset_userdata('sidebar-collapse');

        // Destroy the session
        $this->session->sess_destroy();

        // Ensure we redirect to the login page
        redirect('admin/login');
    }
    public function AjaxSidebarCollapse($next_value)
    {
        $this->session->set_userdata('sidebar-collapse',$next_value);
    }

    public  function AjaxGetRemotesData(){

//        ignore_user_abort(true); // or false if you want to detect disconnects
//
//        // Check if the connection is aborted BEFORE doing heavy work
//        if (connection_aborted()) {
//            // Log if needed
//            log_message('info', 'Request aborted by client before processing.');
//            exit;
//        }
//
//        // 🔑 Send something small to flush output (for Nginx/PHP-FPM to detect aborts)
//        ob_start();
//        echo " ";
//        @ob_flush();
//        @flush();




//        $to_departments_ids = $this->getAllSystemDepartmentsIds();
//        $filter = " AND out_to_department_id IN (" . implode(',', $to_departments_ids) . ") ";
        $branches_id = $this->OutModel->getBranchIdsToBeAllowedToGetOutRemote();


        $filter = " AND elec_dep_reference IN (" . implode(',', $branches_id) . ") ";
        $sql = "SELECT
                    o.id
                FROM
                    `out` o
                WHERE
                    1 =1 $filter";

        $remote_locations = RemoteConnectionMapperHelper::all();

        $remote_location_data = [];
        foreach ($remote_locations as $name =>  $remote_location_info) {
            $count =  0 ;
            try{

//                // 🔄 Try flushing output early in each loop step to let the server detect disconnects
//                ob_start();
//                echo " ";
//                @ob_flush();
//                @flush();
//
//                if (connection_aborted()) {
//                    log_message('info', 'Request aborted by client during DB processing.');
//                    exit;
//                }

                $remote_db = $this->load->database($remote_location_info['code'], TRUE);
                $count_query = "SELECT count(*) AS `rows` FROM ($sql) AS `temp`";
                $count_result = $remote_db->query($count_query);
                if(!$count_result){
                    $count = 0;
                }else{
                    $count = $count_result->row_array()['rows'];
                }
            }
            catch (\Exception $e) {

                continue; // Skip this remote location if connection fails
            }


            $remote_location_data[$name] = $count;
        }


        echo json_encode($remote_location_data);
    }

    public function Dashboard()
    {
        $data['page_title']='Dashboard';

        $received_count_data = [['id' => -1, 'name' => 'received', 'icon' => 'fa fa-arrow-down', 'total' =>  $this->InboxModel->GetTotalCount(-1)]];
        $data['trace_types_data'] = array_merge($received_count_data, $this->InboxModel->GetTotalCountForAllDashboard() );

        $unread_count = $this->InboxModel->GetUnreadCount(-1);

        $total_count = $this->InboxModel->GetTotalCount();

        $data['all_read_unread']['total'] = number_format($total_count, 0, '.', ','); ;
        $data['all_read_unread']['unread'] = $unread_count;
        $data['all_read_unread']['read'] =  $total_count - $unread_count;






        $this->_temp_output('Dashboard',$data);
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

    public function Reports()
    {
        $data['page_title']='Reports';
        $user_access_department_id = $this->UserModel->user_access_department_id();


        $sql = "select department.`name`, avarage_delay.avg_time_to_close, avarage_delay.avg_time_formatted  from department join (

                    select import_trace_receiver_department_id , AVG(time_to_close) as 'avg_time_to_close',
                     CASE
                        WHEN AVG(time_to_close) < 365 THEN
                          CONCAT_WS(' ',
                            NULLIF(CONCAT(FLOOR(AVG(time_to_close) / 30), ' months'), '0 months'),
                            NULLIF(CONCAT(ROUND(AVG(time_to_close) % 30), ' days'), '0 days')
                          )
                        ELSE
                          CONCAT_WS(' ',
                            NULLIF(CONCAT(FLOOR(AVG(time_to_close) / 365), ' years'), '0 years'),
                            NULLIF(CONCAT(FLOOR((AVG(time_to_close) % 365) / 30), ' months'), '0 months'),
                            NULLIF(CONCAT(ROUND((AVG(time_to_close) % 365) % 30), ' days'), '0 days')
                          )
                      END AS avg_time_formatted
                         from (
                    SELECT   
                    import_trace_receiver_department_id,
                     TIMESTAMPDIFF(DAY , import_trace_sent_date, import_trace_close_date ) as 'time_to_close' 
                        FROM `import_trace`
                     where  TIMESTAMPDIFF(DAY , import_trace_sent_date, import_trace_close_date )  >= 0 -- for old corrupted data
                     and import_trace_receiver_department_id is not null -- for old corrupted data
						and import_trace_close_date is not null 
                     and  import_trace_receiver_department_id = '$user_access_department_id' 
                    ) a 
                    group by import_trace_receiver_department_id
                    
                    ) avarage_delay on department.id = avarage_delay.import_trace_receiver_department_id
                    order by 2 desc";
        $data['departmenst_delay_to_clos'] = $this->Get_info->select_query($sql);
        //var_dump($data['departmenst_delay_to_clos']);
        $this->_temp_output('Reports',$data);
    }

}
