<?php 

class UsersManagement extends CI_Controller
{
    function __construct()
    {   
        parent::__construct();
        $this->load->library('grocery_CRUD');
        $this->load->model('UsersModel');
        $group_concat_max_len=$this->db->query('select  @@global.group_concat_max_len as global_group_concat_max_len  , @@session.group_concat_max_len as session_group_concat_max_len')->first_row();
        if($group_concat_max_len->global_group_concat_max_len <4048 || $group_concat_max_len->session_group_concat_max_len<4048){
            $this->db->query('SET GLOBAL group_concat_max_len = 4048;');
            $this->db->query('SET SESSION group_concat_max_len = 4048;');
        }
	}
	public function index()
	{
        if($this->session->userdata('user_login_data')){
           $this->UsersList();
        }else{
            return $this->load->view('Admin/login');
        }
	}

    public function UsersList()
    {
        $data['page_title']='Users List'; 
        $data['page_card_title']='Users';
        $filters=array();
        //login
        $filters['login']=array('type'=>'text','name'=>'login','id'=>'filter_login','label'=>'login');
        //user_name
        $filters['user_name']=array('type'=>'text','name'=>'user_name','id'=>'filter_user_name','label'=>'user_name');
        //user_status
        $filters['user_status']=array('type'=>'select','name'=>'user_status','id'=>'filter_user_status','label'=>'user_status','list_name'=>'USER_STATUS','list_id'=>'USER_STATUS_ID','list'=>$this->UsersModel->GetUserStatusList(),'translate'=>true);
        //group
        $filters['group']=array('type'=>'select','name'=>'group','id'=>'filter_group','label'=>'group','list_name'=>'GROUP_NAME','list_id'=>'GROUP_ID','list'=>$this->UsersModel->GetGroups(),'translate'=>false);
        //telephone
        $filters['telephone']=array('type'=>'text','name'=>'telephone','id'=>'filter_telephone','label'=>'telephone');

        $filters['user_access_department'] = ['type'=>'tree', 'name'=>'user_access_department', 'id'=>'filter_user_access_department', 'label'=>'Access Department', 'onclick'=>"OpenTree('department','filter_user_access_department','filter_user_access_department_id','1', 'extra-section', 1)"];
        $filters['user_access_department_id'] = ['type'=>'hidden', 'name'=>'user_access_department_id', 'id'=>'filter_user_access_department_id', 'label'=>'user_access_department_id', 'value'=>''];



        $filters['user_department'] = ['type'=>'tree', 'name'=>'user_department', 'id'=>'filter_user_department', 'label'=>'Department', 'onclick'=>"OpenTree('department','filter_user_department','filter_user_department_id','1', 'extra-section', 1)"];
        $filters['user_department_id'] = ['type'=>'hidden', 'name'=>'user_department_id', 'id'=>'filter_user_department_id', 'label'=>'user_department_id', 'value'=>''];


        $cols[]='login';
        $cols[]='user_name';
        $cols[]='user_department';
        $cols[]='user_access_department';
        $cols[]='groups';
        $cols[]='user_status';
        $cols[]='telephone';
        $cols[]='Actions';
        
        $data['DataTable']=DataTableBuilder('UsersList',base_url("UsersManagement/AjaxUsersList"),$cols,$filters);
        $this->_temp_output('UsersManagement/Users/List',$data);
    }
    public function AjaxUsersList()
    {
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $order= $this->input->post("order");
        
        $cols[]='`LOGIN`';
        $cols[]='`NAME`';
        $cols[]='user_department_fullpath';
        $cols[]='user_access_department_fullpath';
        $cols[]='`GROUPS`';
        $cols[]='USER_STATUS';
        $cols[]='telephone';
        $cols[]='USER_ID';
        if(isset($order[0]['column'])){
            $order=' ORDER BY '.$cols[$order[0]['column']] . ' ' . $order[0]['dir'];
        }
        $filter="";
        //login
        $login=$this->input->post("login");
        if($login!=''){
            $filter.=" AND  `user`.`LOGIN` LIKE '%$login%'";
        }
        //user_name
        $user_name=$this->input->post("user_name");
        if($user_name!=''){
            $filter.=" AND  `user`.`NAME` LIKE '%$user_name%'";
        }
        //user_status
        $user_status=$this->input->post("user_status");
        if($user_status!=''){
            $filter.=" AND `user`.USER_STATUS_ID='$user_status'";
        }
        //group
        $group=$this->input->post("group");
        if($group!=''){
            $filter.=" AND `group`.GROUP_ID='$group'";
        }
        //telephone
        $telephone=$this->input->post("telephone");
        if($telephone!=''){
            $filter.=" AND `telephone` LIKE '%$telephone%'";
        }

        $user_access_department_id = $this->input->post("user_access_department_id");
        if ($user_access_department_id && $user_access_department_id != "") {
            $filter .= " AND `user_access_department_id` = '" . $this->db->escape_str($user_access_department_id) . "'";
        }

        $user_department_id = $this->input->post("user_department_id");
        if ($user_department_id && $user_department_id != "") {
            $filter .= " AND `user_department_id` = '" . $this->db->escape_str($user_department_id) . "'";
        }

        $Data=$this->UsersModel->GetUsersList($filter,$start,$length,$order);
        $RowsData=$Data['data'];
        $num_rows=$Data['count'];
        $ajax=array();
        foreach($RowsData as $Row){
            if($Row['GROUPS']==''){
                $Row['GROUPS']='<span class="badge badge-danger">No Groups</span>';
            }else{
                //explode groups
                $groups=explode(',',$Row['GROUPS']);
                $Row['GROUPS']='';
                foreach($groups as $group){
                    $Row['GROUPS'].='<span class="badge badge-secondary">'.$group.'</span> ';
                }
            }
            if($Row['USER_STATUS_ID']==1){
                $Row['USER_STATUS']='<span class="badge badge-success">'.$this->Dictionary->GetKeyword('ACTIVE').'</span>';
            }else{
                $Row['USER_STATUS']='<span class="badge badge-danger">'.$this->Dictionary->GetKeyword($Row['USER_STATUS']).'</span>';
            }
        $actions='<div class="btn-group btn-group-sm" dir="ltr">';
        if($this->Permission->CheckPermissionOperation('usersmanagement_edituser')){
            $actions.='<a href="'.base_url('UsersManagement/EditUser/'.$Row['USER_ID']).'" class="btn btn-primary"><i class="fa fa-edit"></i></a>';
        }
        if($this->Permission->CheckPermissionOperation('usersmanagement_changeuserstatus')){
            $deletebtn='<button onclick="CallDeleteUser('.$Row['USER_ID'].')" class="btn btn-danger"><i class="fa fa-trash"></i></button>';
            $activebtn='<button onclick="CallActiveUser('.$Row['USER_ID'].')" class="btn btn-success"><i class="fa fa-check"></i></button>';
          //  $inactivebtn='<button onclick="CallInActiveUser('.$Row['USER_ID'].')" class="btn btn-warning"><i class="fa fa-times"></i></button>';
            $lockbtn='<button onclick="CallLockUser('.$Row['USER_ID'].')" class="btn btn-warning"><i class="fa fa-lock"></i></button>';
//            if($Row['USER_STATUS_ID']==1){
//                $actions.=$deletebtn.$inactivebtn.$lockbtn;
//            }elseif($Row['USER_STATUS_ID']==2){
//                $actions.=$deletebtn.$activebtn.$lockbtn;
//            }elseif($Row['USER_STATUS_ID']==3){
//                $actions.=$activebtn.$inactivebtn.$lockbtn;
//            }elseif($Row['USER_STATUS_ID']==4){
//                $actions.=$deletebtn.$inactivebtn.$activebtn;
//            }

            if($Row['USER_STATUS_ID']==1){
                $actions.=$deletebtn.$lockbtn;
            }else{
                $actions.=$deletebtn.$activebtn;
            }
        }
        $actions.='</div>';
        $ajax[]=[
            'login'=>$Row['LOGIN'],
            'user_name'=>$Row['NAME'],
            'user_department'=>$Row['user_department_fullpath'],
            'user_access_department' =>$Row['user_access_department_fullpath'],
            'groups'=>$Row['GROUPS'],
            'user_status'=>$Row['USER_STATUS'],
            'telephone'=>$Row['telephone'],
            'Actions'=>$actions
            ];
        }
        $result = array(
            "draw" => $draw,
              "recordsTotal" => $num_rows,
              "recordsFiltered" => $num_rows,
              "data" => $ajax
         );
        echo json_encode($result);

    }
    
    
    // function to load the page and parse the data to view
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
    //AddUser
    public function AddUser()
    {
        if($this->input->post()){
            $data_post=$this->security->xss_clean($this->input->post());
            $this->form_validation->set_rules('NAME', 'User Name', 'trim|required');
            $this->form_validation->set_rules('LOGIN', 'Login', 'trim|required|is_unique[user.LOGIN]');
           // $this->form_validation->set_rules('telephone', 'User Phone', 'trim');
            $this->form_validation->set_rules('UI_LANGUAGE', 'UI_Language', 'trim|required');
            $this->form_validation->set_rules('user_department_id', 'User Department', 'required');
            $this->form_validation->set_rules('user_access_department_id', 'User Access Department', 'required');
            if(!$this->input->post('groups')){
                $this->form_validation->set_rules('groups', 'Groups', 'trim|xss_clean|numeric|required');
            }
            /* $this->form_validation->set_rules('groups', 'Groups', 'trim|xss_clean|numeric|required'); */
            //password
            if($data_post['PASSWORD']!=''){
                $this->form_validation->set_rules('PASSWORD', 'Password', 'trim|required|min_length[6]');
                $this->form_validation->set_rules('PASSWORD_CONFIRM', 'Password Confirmation', 'trim|required|matches[PASSWORD]');
            }else{
                $data_post['PASSWORD']="123456";
            }
            if ($this->form_validation->run() == FALSE){
                echo json_encode(array('status'=>'error','message'=>validation_errors()));
            }else{
                $data['NAME']=$data_post['NAME'];
                $data['LOGIN']=$data_post['LOGIN'];
                $data['telephone']=$data_post['telephone'];
                $data['UI_LANGUAGE']=$data_post['UI_LANGUAGE'];
                $data['USER_STATUS_ID']=1;
                $data['user_access_department_id']=$data_post['user_access_department_id'];
                $data['user_department_id']=$data_post['user_department_id'];
                $dataGroup=array();
                if(isset($data_post['groups'])){
                    $dataGroup=$data_post['groups'];
                }
                if($data_post['PASSWORD']!=''){
                    $crypt=new Crypt();
                    $data['PASSWORD']=$crypt->MediaEncrypt($data_post['PASSWORD']);
                }

                $UserID=$this->Get_info->insert_data('user',$data);
                if($UserID){
                    //add groups
                    if(count($dataGroup)>0){
                        foreach($dataGroup as $group=>$value){
                            $this->db->insert('user_group',array('USER_ID'=>$UserID,'GROUP_ID'=>$value));
                        }
                    }
                    echo json_encode(array('status'=>'success','message'=>'User Added Successfully'));
                }else{
                    echo json_encode(array('status'=>'error','message'=>'Error Adding User'));
                } 
            }
        }else{
            $data['page_title']='Add User'; 
            $data['page_card_title']='Add User';
            $data['Groups']=$this->UsersModel->GetGroups();
            $this->_temp_output('UsersManagement/Users/AddUser',$data);
        }
    }
    //EditUser
    public function EditUser($User_id)
    {
        if($this->input->post()){
            $data_post=$this->security->xss_clean($this->input->post());
            $this->form_validation->set_rules('NAME', 'User Name', 'trim|required');
            $this->form_validation->set_rules('LOGIN', 'Login', 'trim|required|edit_unique[user.LOGIN.'.$User_id.']');
            //$this->form_validation->set_rules('telephone', 'User Phone', 'trim|required');
            $this->form_validation->set_rules('user_department_id', 'User Department', 'required');
            $this->form_validation->set_rules('user_access_department_id', 'User Access Department', 'required');
            if(!$this->input->post('groups')){
                $this->form_validation->set_rules('groups', 'Groups', 'trim|xss_clean|numeric|required');
            }
            //password
            if($data_post['PASSWORD']!=''){
                $this->form_validation->set_rules('PASSWORD', 'Password', 'trim|required|min_length[6]');
                $this->form_validation->set_rules('PASSWORD_CONFIRM', 'Password Confirmation', 'trim|required|matches[PASSWORD]');
            }
            if ($this->form_validation->run() == FALSE){
                echo json_encode(array('status'=>'error','message'=>validation_errors()));
            }else{
                $data['NAME']=$data_post['NAME'];
                $data['LOGIN']=$data_post['LOGIN'];
                $data['telephone']=$data_post['telephone'];
                $data['UI_LANGUAGE']=$data_post['UI_LANGUAGE'];
                $data['user_access_department_id']=$data_post['user_access_department_id'];
                $data['user_department_id']=$data_post['user_department_id'];
                //$data['is_new'] = 1;
                $dataGroup=array();
                if(isset($data_post['groups'])){
                    $dataGroup=$data_post['groups'];
                }
                if($data_post['PASSWORD']!=''){
                    $crypt=new Crypt();
                    $data['PASSWORD']=$crypt->MediaEncrypt($data_post['PASSWORD']);
                }
                $this->db->update('user',$data,array('USER_ID'=>$User_id));

                //add groups
                if(count($dataGroup)>0){
                                    //delete old groups
                                    $this->db->delete('user_group',array('USER_ID'=>$User_id));
                    foreach($dataGroup as $group=>$value){
                        $this->db->insert('user_group',array('USER_ID'=>$User_id,'GROUP_ID'=>$value));
                    }
                }
                echo json_encode(array('status'=>'success','message'=>'User Updated Successfully'));
            }
        }else{
            $data['page_title']='Edit User'; 
            $data['page_card_title']='Edit User';
            $data['Groups']=$this->UsersModel->GetGroups();
            $data['User_id']=$User_id;
            $data['User']=$this->UsersModel->GetUserDetails($User_id);
            if($data['User']){

                $crypt=new Crypt();
                $data['User']['PASSWORD']=$crypt->MediaDecrypt($data['User']['PASSWORD']);
                $this->_temp_output('UsersManagement/Users/EditUser',$data);
            }else{
                redirect('UsersManagement/UsersList');
            }
        }
    }
    //DeleteUser
    public function AjaxDeleteUser($User_id)
    {
        //Update user_status_id to DELETED => 3
        if($this->db->update('user',array('USER_STATUS_ID'=>3),array('USER_ID'=>$User_id))){
            echo json_encode(array('status'=>'success','message'=>'User Deleted Successfully'));
        }else{
            echo json_encode(array('status'=>'error','message'=>'Error Deleting User'));
        }
    }
    //LockUser
    public function AjaxLockUser($User_id)
    {
        //Update user_status_id to LOCKED => 4
        if($this->db->update('user',array('USER_STATUS_ID'=>4),array('USER_ID'=>$User_id))){
            echo json_encode(array('status'=>'success','message'=>'User Locked Successfully'));
        }else{
            echo json_encode(array('status'=>'error','message'=>'Error Locking User'));
        }
    }
    //InActiveUser
    public function AjaxInActiveUser($User_id)
    {
        //Update user_status_id to INACTIVE => 2
        if($this->db->update('user',array('USER_STATUS_ID'=>2),array('USER_ID'=>$User_id))){
            echo json_encode(array('status'=>'success','message'=>'User InActivated Successfully'));
        }else{
            echo json_encode(array('status'=>'error','message'=>'Error InActivating User'));
        }
    }
    //ActiveUser
    public function AjaxActiveUser($User_id)
    {
        //Update user_status_id to ACTIVE => 1
        if($this->db->update('user',array('USER_STATUS_ID'=>1),array('USER_ID'=>$User_id))){
            echo json_encode(array('status'=>'success','message'=>'User Activated Successfully'));
        }else{
            echo json_encode(array('status'=>'error','message'=>'Error Activating User'));
        }
    }
    
    public function GroupsList()
    {
        //   $this->updatePasswords();
        $data['page_title']='Groups List'; 
        $data['page_card_title']='Groups';
        $filters=array();
        //group_name
        $filters['group_name']=array('type'=>'text','name'=>'group_name','id'=>'filter_group_name','label'=>'group_name');
        //status
        $filters['status']=array('type'=>'select','name'=>'status','id'=>'filter_status','label'=>'status','list_name'=>1,'list_id'=>0,'list'=>[['1','Active'],['0','Inactive']],'translate'=>true);
        $cols[]='group_name';
        $cols[]='status';
        $cols[]='Actions';
        $data['DataTable']=DataTableBuilder('GroupsList',base_url("UsersManagement/AjaxGroupsList"),$cols,$filters);
        $this->_temp_output('UsersManagement/Groups/List',$data);
    }

    private function updatePasswords(){
        $query = $this->db->query("SELECT USER_ID, old_password FROM `user` WHERE `old_password` IS NOT NULL");
        $users = $query->result_array();

        foreach ($users as $user) {
            // Encrypt the old_password
            $crypt= new Crypt();
            $encryptedPassword = $crypt->MediaEncrypt($user['old_password']);

            // Update the PASSWORD field
            $this->db->update('user', ['PASSWORD' => $encryptedPassword], ['USER_ID' => $user['USER_ID']]);
        }
    }
    public function AjaxGroupsList()
    {
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $order= $this->input->post("order");
        
        $cols[]='`GROUP_NAME`';
        $cols[]='`STATUS_ID`';
        $cols[]='GROUP_ID';
        if(isset($order[0]['column'])){
            $order=' ORDER BY '.$cols[$order[0]['column']] . ' ' . $order[0]['dir'];
        }
        $filter="";
        //group_name
        $group_name=$this->input->post("group_name");
        if($group_name!=''){
            $filter.=" AND `GROUP_NAME` LIKE '%$group_name%'";
        }
        //status
        $status=$this->input->post("status");
        if($status!=''){
            $filter.=" AND `STATUS_ID` = '$status'";
        }

        $Data=$this->UsersModel->GetGroupsList($filter,$start,$length,$order);
        $RowsData=$Data['data'];
        $num_rows=$Data['count'];
        $ajax=array();
        foreach($RowsData as $Row){
            if($Row['STATUS_ID']=='1'){
                $Row['STATUS_ID']='<span class="badge badge-success">'.$this->Dictionary->GetKeyword('ACTIVE').'</span>';
            }else{
                $Row['STATUS_ID']='<span class="badge badge-danger">'.$this->Dictionary->GetKeyword('inactive').'</span>';
            }
        $actions='<div class="btn-group btn-group-sm" dir="ltr">';
        if($this->Permission->CheckPermissionOperation('usersmanagement_editgroup')){
            $actions.='<a href="'.base_url('UsersManagement/EditGroup/'.$Row['GROUP_ID']).'" class="btn btn-primary"><i class="fa fa-edit"></i></a>';
        }
        $actions.='</div>';
        $ajax[]=[
            'group_name'=>$Row['GROUP_NAME'],
            'status'=>$Row['STATUS_ID'],
            'Actions'=>$actions
            ];
        }
        $result = array(
            "draw" => $draw,
              "recordsTotal" => $num_rows,
              "recordsFiltered" => $num_rows,
              "data" => $ajax
         );
        echo json_encode($result);
    }
    //Add Group
    public function AddGroup()
    {
        $data_post=$this->input->post();
        if($data_post){
            $this->form_validation->set_rules('GROUP_NAME', 'group_name', 'required');
            $this->form_validation->set_rules('STATUS_ID', 'status', 'required');
            if ($this->form_validation->run() == FALSE){
                echo json_encode(array('status'=>'error','message'=>validation_errors()));
            }else{
                $data['GROUP_NAME']=$data_post['GROUP_NAME'];
                $data['STATUS_ID']=$data_post['STATUS_ID'];
                $PERMISSION_array=array();
                if(isset($data_post['PERMISSION'])){
                    $PERMISSION_array=array_unique($data_post['PERMISSION']);
                }
                 $Group_id=$this->Get_info->insert_data('group',$data);
                if($Group_id){
                    //add permissions for GROUP_PERMISSION [GROUP_ID,OPERATION_NAME]
                    if(count($PERMISSION_array)>0){
                        foreach($PERMISSION_array as $PERMISSION=>$value){
                            $this->db->insert('group_permission',array('GROUP_ID'=>$Group_id,'OPERATION_NAME'=>$value));
                        }
                    }
                    echo json_encode(array('status'=>'success','message'=>'Group Added Successfully'));
                }else{
                    echo json_encode(array('status'=>'error','message'=>'Error in Adding Group'));
                }
            }
        }else{
            $data['page_title']='Add Group'; 
            $data['page_card_title']='Add Group';
            $data['Operations']=$this->UsersModel->GetOperations();
            $this->_temp_output('UsersManagement/Groups/AddGroup',$data);
        }
    }
    //Edit Group
    public function EditGroup($Group_id)
    {
        $data_post=$this->input->post();
        if($data_post){
             $this->form_validation->set_rules('GROUP_NAME', 'group_name', 'required');
            $this->form_validation->set_rules('STATUS_ID', 'status', 'required');
            if ($this->form_validation->run() == FALSE){
                echo json_encode(array('status'=>'error','message'=>validation_errors()));
            }else{
                $data['GROUP_NAME']=$data_post['GROUP_NAME'];
                $data['STATUS_ID']=$data_post['STATUS_ID'];
                $PERMISSION_array=array();
                if(isset($data_post['PERMISSION'])){
                    $PERMISSION_array=array_unique($data_post['PERMISSION']);
                }
                $this->db->update('group',$data,array('GROUP_ID'=>$Group_id));
                //delete old permissions
                $this->db->delete('group_permission',array('GROUP_ID'=>$Group_id));
                //add permissions for GROUP_PERMISSION [GROUP_ID,OPERATION_NAME]
                if(count($PERMISSION_array)>0){
                    foreach($PERMISSION_array as $PERMISSION=>$value){
                        $this->db->insert('group_permission',array('GROUP_ID'=>$Group_id,'OPERATION_NAME'=>$value));
                    }
                }
                echo json_encode(array('status'=>'success','message'=>'Group Updated Successfully'));
            }
        }else{
            $data['page_title']='Edit Group'; 
            $data['page_card_title']='Edit Group';
            $data['Group_id']=$Group_id;
            $data['Operations']=$this->UsersModel->GetOperations();
            $data['Group']=$this->UsersModel->GetGroupDetails($Group_id);
            if($data['Group']){
                $this->_temp_output('UsersManagement/Groups/EditGroup',$data);
            }else{
                redirect('UsersManagement/GroupsList');
            }
        }
    }
    //  Permission  
    public function Permission()
    {
        $data['page_title']='Permissions List'; 
        $data['page_card_title']='Permission';
        $crud = new grocery_CRUD();
			$crud->set_table('permission');
            $crud->set_subject('permission'); 
            $crud->unset_read();
            $crud->unset_clone();
            $crud->unset_print();
            $crud->unset_export();
            //$crud->set_primary_key('OPERATION_NAME','permission');
            $this->load->library('ControllerList');
            $LIST=new ControllerList();
            $OPERATIONS=$LIST->getControllers();
            $methods=array(''=>'Select');
            foreach($OPERATIONS as $key=>$value){
                $class_name=$key;
                foreach($value as $row => $meth){
                    $OPERATION_CODE=strtolower($class_name.'_'.$meth);
                    $CheckIfExists=$this->Get_info->select('permission',"OPERATION_CODE = '$OPERATION_CODE'");
                    if(!$CheckIfExists){
                    $methods[$OPERATION_CODE]=$class_name.'/'.$meth;
                    }
                }
             }
            $crud->required_fields(array('OPERATION_CODE','NAME'));
            $crud->field_type('OPERATION_CODE','dropdown',$methods);
            $output = $crud->render();
            $output =array_merge((array)$output,$data)   ;

			 $this->_temp_output('index',$output); 
    }
}
