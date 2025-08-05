<?php

use Sonata\GoogleAuthenticator\GoogleAuthenticator;

class User extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function AjaxGetUsersByDepartment()
    {
        $department_id = $this->input->post('department_id', true);
        $this->load->model('Get_info');
        $this->load->model('UserModel');
        $users = $this->Get_info->select('user', " user_department_id like '".$department_id .'%'. "' and USER_STATUS_ID = 1 ");
        if($users){
            $data = array();
            foreach ($users as $user) {
                $data[] = array(
                    'id' => $user['USER_ID'],
                    'name' => $user['NAME']
                );
            }
            echo json_encode($data);
        }else{
            echo json_encode(array());
        }
    }
    public function EditProfile()
    {
        $UserID=$this->UserModel->user_id();
        $data['page_title']='Edit Profile';
        $data['page_card_title']='Edit Profile';
        if(!$this->UserModel->GoogleSecretCode()){
            $this->UserModel->GenerateGoogleSecretCode();
        }
        $user_info=$this->Get_info->select('user','USER_ID ='.$UserID);
        if($user_info){
            $data['UserInfo']=$user_info[0];
            $data['GoogleSecretCode']= $this->UserModel->GoogleSecretCode();
            $google_auth = new GoogleAuthenticator();
            $data['user_2fa_qrCode']=$google_auth->getURL($data['UserInfo']['LOGIN'], 'cms.midyatech.net',$this->UserModel->GoogleSecretCode());
            $this->load->view('Admin2/User/EditProfile',$data);
        }else{
            redirect('Admin/index');
        }
    }

    public function AjaxUpdateProfile(int $UserID)
    {
        if($this->input->post()){
            $data_post=$this->security->xss_clean($this->input->post());
            $this->form_validation->set_rules('NAME', 'User Name', 'trim|required');
            $this->form_validation->set_rules('LOGIN', 'Login', 'trim|required|edit_unique[user.LOGIN.'.$UserID.']');
            $this->form_validation->set_rules('telephone', 'User Phone', 'trim|required');
            //password
            if($data_post['PASSWORD']!=''){
                $this->form_validation->set_rules('PASSWORD', 'Password', 'trim|required|min_length[6]');
                $this->form_validation->set_rules('PASSWORD_CONFIRM', 'Password Confirmation', 'trim|required|matches[PASSWORD]');
            }
            if ($this->form_validation->run() == FALSE)
            {
                echo json_encode(array('status'=>'error','message'=>validation_errors()));
            }else{
                $data['NAME']=$data_post['NAME'];
                $data['LOGIN']=$data_post['LOGIN'];
                $data['telephone']=$data_post['telephone'];
                if(isset($data_post['google_auth']) && $data_post['google_auth']!=''){
                    $data['google_auth']=1;
                }else{
                    $data['google_auth']=0;
                }
                if($data_post['PASSWORD']!=''){
                    $crypt=new Crypt();
                    $data['PASSWORD']=$crypt->MediaEncrypt($data_post['PASSWORD']);
                }
                //Update session data
                $this->db->update('user',$data,['USER_ID'=>$UserID]);
                $this->UserModel->UpdateUserSession();
                echo json_encode(array('status'=>'success','message'=>$this->Dictionary->GetKeyword('Profile Updated Successfully')));
            }
        }
    }

}
