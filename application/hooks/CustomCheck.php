<?php

class CustomCheck {
    private $_controllers = [];

    private $CI;

    public function __construct() {
        $this->CI =& get_instance();
    }

    public function BeforeRequest() {
         $class = $this->CI->router->fetch_class();
        $method = $this->CI->router->fetch_method();
         if ( strpos($method, 'Ajax') !== FALSE && $this->CI->input->is_ajax_request() === FALSE ) {
                //show_404();
        }
         elseif(
             strpos($method, 'Ajax') === FALSE &&
             strpos($method, 'changepassword') === FALSE &&
             strpos($method, 'login') ===FALSE &&
             strpos($method, 'logout') ===FALSE &&
             strpos(strtolower($method),'orderstatus')===FALSE
         ){

//             var_dump($this->CI->session->userdata('user_login_data'));
//             die();
            if(!$this->CI->session->userdata('user_login_data')){
                redirect(base_url('Admin/login'));
            }

            elseif($this->CI->session->userdata('user_login_data')['has_to_change_password'] == 1){
                redirect(base_url('Admin/changepassword'));
            }
            elseif($this->CI->session->userdata('user_login_data')['google_auth']==1 &&
                  $this->CI->session->userdata('user_login_data')['google_auth_check']==false){

                if($method!='google_auth'){
                    redirect(base_url('Admin/google_auth'));
                }

            }elseif(!$this->CI->Permission->CheckPermissionOperation($class.'_'.$method)){

                if($method!='google_auth'){
                    show_error("Permission Dose'nt",401,"You Don't Have Permission for this page");
                }
                
            }

        }elseif(strpos($method, 'changepassword') === FALSE &&
                strpos($method, 'login') ===FALSE &&
                strpos($method, 'logout') ===FALSE  &&
                strpos(strtolower($method),'orderstatus')===FALSE &&
                strpos(strtolower($method),'ajaxaddnewticket')===FALSE &&
                !$this->CI->session->userdata('user_login_data')
            ){
            exit('<div class="alert alert-danger">Your session has been destroy, please <a target="_blank" href="'.base_url('Admin/login').'">login</a> and try agin.</div>'); 
        } 
        
    }
}
