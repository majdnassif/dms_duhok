<?php

class Clients extends CI_Controller
{
    function __construct()
    {   
        parent::__construct();
        $this->load->library('grocery_CRUD');
        $this->load->model('Order');
        $this->load->model('Client');
	}
	public function index()
	{
        $this->ClientsList();
	}
    public function _temp_output($view,$output=null)
    {
        if($this->session->userdata('user_login_data')){
                $this->load->view("Admin/header",(array)$output);
                $perm=$this->Permission->CheckPermission();
            if($perm==true){
                $this->load->view("Admin/$view" ,(array)$output);
            }else{
                $this->load->view('Admin/permission');
            }
                $this->load->view("Admin/footer",(array)$output);
        }else{
            return $this->load->view('Admin/login');
        }
    }
    public function ClientsList()
    {
        $data['page_title']='Clients List'; 
        $data['page_card_title']='Clients List';
        $data['platforms']=$this->Client->GetPlatforms();
        $data['regions']=$this->Client->GetRegions();
        /* $filters['code']=array('type'=>'text','name'=>'code','id'=>'filter_code','label'=>'code');
        $filters['block_number']=array('type'=>'text','name'=>'block_number','id'=>'filter_block_number','label'=>'block_number');
        $filters['folder_no']=array('type'=>'text','name'=>'folder_no','id'=>'filter_folder_no','label'=>'folder_no');
        $filters['space']=array('type'=>'text','name'=>'space','id'=>'filter_space','label'=>'space');
        $filters['tenant_name']=array('type'=>'text','name'=>'tenant_name','id'=>'filter_tenant_name','label'=>'tenant_name');
        $filters['phone']=array('type'=>'text','name'=>'phone','id'=>'phone','label'=>'phone');
        $filters['projects']=array('type'=>'select','name'=>'project_id','id'=>'filter_project_id','label'=>'project_name','list'=>$data['projects'],'list_id'=>'id','list_name'=>'project_name','translate'=>false);
        $filters['data_entry_follow_up_status']=array('type'=>'select','name'=>'data_entry_follow_up_id','id'=>'filter_data_entry_follow_up_id','label'=>'data_entry_follow_up_status','list'=>$data['data_entry_follow_up_status'],'list_id'=>'id','list_name'=>'status','translate'=>true); */
        $filters=array();
        //client_code
        $filters['client_code']=array('type'=>'text','name'=>'client_code','id'=>'filter_client_code','label'=>'code');
        //client_name
        $filters['client_name']=array('type'=>'text','name'=>'client_name','id'=>'filter_client_name','label'=>'name');
        //client_profile
        $filters['client_profile']=array('type'=>'text','name'=>'client_profile','id'=>'filter_client_profile','label'=>'profile');
        //client_mobile
        $filters['client_mobile']=array('type'=>'text','name'=>'client_mobile','id'=>'filter_client_mobile','label'=>'mobile');
        //client_address
        $filters['client_address']=array('type'=>'text','name'=>'client_address','id'=>'filter_client_address','label'=>'address');
        //client_blacklisted select ['0'=>'No','1'=>'Yes']
        $filters['client_blacklisted']=array('type'=>'select','name'=>'client_blacklisted','id'=>'filter_client_blacklisted','label'=>'blacklisted','list'=>[['id'=>'0','name'=>'No'],['id'=>'1','name'=>'Yes']],'list_id'=>'id','list_name'=>'name','translate'=>true);
        //platform_id
        $filters['platform_id']=array('type'=>'select','name'=>'platform_id','id'=>'filter_platform_id','label'=>'platform','list'=>$data['platforms'],'list_id'=>'platform_id','list_name'=>'platform_name_en','translate'=>true);
        //region_id
        $filters['region_id']=array('type'=>'select','name'=>'region_id','id'=>'filter_region_id','label'=>'region','list'=>$data['regions'],'list_id'=>'region_id','list_name'=>'region_name_en','translate'=>true);
        $cols[0]='code';
        $cols[1]='name';
        /* $cols[2]='profile'; */
        $cols[2]='mobile_1';
        /* $cols[4]='mobile_2'; */
        /* $cols[5]='address_1';
        $cols[6]='address_2'; */
        /* $cols[3]='blacklisted'; */
        /* $cols[6]='platform_name_en'; */
        $cols[3]='region_name_en';

        $cols[4]='Actions';
        
        $data['DataTable']=DataTableBuilder('OrderList',base_url("Clients/AjaxList"),$cols,$filters);
        $this->_temp_output('Clients/List',$data);
    }
    
    public function AjaxList()
    {
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $order= $this->input->post("order");
        
        $cols[0]='client_code';
        $cols[1]='client_name';
        /* $cols[2]='client_profile'; */
        $cols[2]='client_mobile_1';
        /* $cols[4]='client_mobile_2'; */
        /* $cols[5]='client_address_1';
        $cols[6]='client_address_2'; */
        /* $cols[3]='client_blacklisted'; */
       /*  $cols[8]='platform_name_en'; */
        $cols[3]='region_name_en';
        $cols[4]='client_id';
        if(isset($order[0]['column'])){
            $order=' ORDER BY '.$cols[$order[0]['column']] . ' ' . $order[0]['dir'];
        }
        $filter="";
        //client_code
        $client_code=$this->input->post("client_code");
        if ($client_code && $client_code!="") {
            $filter.=" AND `client_code` = '$client_code'";
        }
        //client_name
        $client_name=$this->input->post("client_name");
        if ($client_name && $client_name!="") {
            $filter.=" AND `client_name` LIKE '%$client_name%'";
        }
        //client_profile
        $client_profile=$this->input->post("client_profile");
        if ($client_profile && $client_profile!="") {
            $filter.=" AND `client_profile` LIKE '%$client_profile%'";
        }
        //client_mobile
        $client_mobile=$this->input->post("client_mobile");
        if ($client_mobile && $client_mobile!="") {
            $filter.=" AND (`client_mobile_1` LIKE '%$client_mobile%' OR `client_mobile_2` LIKE '%$client_mobile%')";
        }
        //client_address
        $client_address=$this->input->post("client_address");
        if ($client_address && $client_address!="") {
            $filter.=" AND (`client_address_1` LIKE '%$client_address%' OR `client_address_2` LIKE '%$client_address%')";
        }
        //client_blacklisted
        $client_blacklisted=$this->input->post("client_blacklisted");
        if ($client_blacklisted && $client_blacklisted!="") {
            $filter.=" AND `client_blacklisted` = '$client_blacklisted'";
        }
        //platform_id
        $platform_id=$this->input->post("platform_id");
        if ($platform_id && $platform_id!="") {
            $filter.=" AND platform.`platform_id` = '$platform_id'";
        }
        //region_id
        $region_id=$this->input->post("region_id");
        if ($region_id && $region_id!="") {
            $filter.=" AND region.`region_id` = '$region_id'";
        }
        $Clients=$this->Client->GetClientList($filter,$start,$length,$order);
        $ClientsData=$Clients['data'];
        $num_rows=$Clients['count'];
        $ajax=array();
        foreach($ClientsData as $Client){
            
        $actions='<div class="btn-group btn-group-sm" dir="ltr">';
        
       /*  if($this->Permission->CheckPermissionOperation('units_view')){
        $actions.='<a class="btn btn-sm btn-success" data-toggle="modal" data-target="#extra-modal" onclick="CallViewModal('.$Order['id'].')" role="button"> <i class="fas fa-eye"></i></a>';
        }
        if($this->Permission->CheckPermissionOperation('orders_orderdetails')){
        $actions.='<a class="btn btn-sm btn-warning" onclick="CallHighliteOrder('.$Order['order_id'].','.$Order['order_highlight'].')" role="button"> <i class="fas fa-highlighter"></i></a>';
        } */
        if($this->Permission->CheckPermissionOperation('clients_clientdetails')){
            $Client['client_name']='<a href="'.base_url("Clients/ClientDetails/".$Client['client_id']).'" target="_blank">'.$Client['client_name'].'</a>';
        $actions.='<a class="btn btn-sm btn-primary" href="'.base_url("Clients/ClientDetails/".$Client['client_id']).'" role="button"> <i class="fas mr-1 ml-1 fa-info"></i></a>';
        }/* 
        if($this->Permission->CheckPermissionOperation('units_deleteUnit')){
        $actions.='<a class="btn btn-sm btn-danger" onclick="CallDelete('.$Order['id'].','."'".$Order['block_number']."'".')" role="button"> <i class="fas fa-trash"></i></a>';
        }
        if($this->Permission->CheckPermissionOperation('unitcheck_unitcheckdetails')){
        $actions.='<a class="btn btn-sm btn-warning" href="'.base_url("UnitCheck/UnitCheckDetails/".$Order['id']).'" role="button"> <i class="fas mr-1 ml-1 fa-check"></i></a>';
        } */
        if($Client['client_blacklisted']){
            $blacklisted='<span class="badge badge-danger"><i class="fa fa-times" aria-hidden="true"></i></span>'; 
        }else{ 
            $blacklisted= '<span class="badge badge-success"><i class="fa fa-check" aria-hidden="true"></i></span>';
        }
        $actions.='</div>';
        $ajax[]=[
            'code'=>$blacklisted.' '.$Client['client_code'],
            'name'=>$Client['client_name'],
            'profile'=>$Client['client_profile'],
            'mobile_1'=>$Client['client_mobile_1'].'<br>'.$Client['client_mobile_2'],
            /* 'mobile_2'=>$Client['client_mobile_2'], */
            /* 'address_1'=>$Client['client_address_1'],
            'address_2'=>$Client['client_address_2'], */
            'blacklisted'=>$blacklisted,
            /* 'platform_name_en'=>$Client['platform_name_en'], */
            'region_name_en'=>$Client['region_name_en'],
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
    public function ClientDetails($ClientID){
        $data['page_title']="client_details";
        $data['ClientDetails']=$this->Client->GetClientDetails($ClientID);
        if($data['ClientDetails']){
            $data['ClientID']=$ClientID;
            $this->_temp_output('Clients/ClientDetails',$data);
        }else{
            redirect(base_url("Clients/ClientList"));
        }
    }
    //AjaxClientInformation($ClientID)
    public function AjaxClientInformation($ClientID){
        $data['ClientDetails']=$this->Client->GetClientDetails($ClientID);
        $this->load->view('Admin/Clients/ClientInformation',$data);
    }
    //AjaxClientOrders
    public function AjaxClientOrders($ClientID){
        $data['ClientOrders']=$this->Client->GetClientOrders($ClientID);
        $this->load->view('Admin/Clients/ClientOrders',$data);
    }
    
}