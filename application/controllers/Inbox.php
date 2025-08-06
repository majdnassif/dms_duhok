<?php

class Inbox extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('InboxModel');
        $this->load->model('UserModel');
        $this->load->model('Dictionary');
    }

    public function index()
    {
        $this->List();
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

    public function List($lastTraceTypeId = null)
    {

        $data['page_title']='Inbox';
        $data['page_card_title']='Inbox';
        $ajax_url=base_url("Inbox/AjaxList");
        if($lastTraceTypeId){
            $ajax_url.="/$lastTraceTypeId";
            if($lastTraceTypeId == -1){
                $trace_type_name='received';
            }else{
                $trace_type_name=$this->Get_info->select('import_trace_type',['import_trace_type_id'=>$lastTraceTypeId])[0]['import_trace_type_name'];
            }
            $data['page_card_title']= 'Inbox_'.$trace_type_name;
            $data['page_title']= 'Inbox_'.$trace_type_name;
        }
        $filters=array();
        //import_code
        $filters['import_code']=['type'=>'text','name'=>'import_code','id'=>'filter_import_code','label'=>'code'];
        //import_from_department_id
        $filters['import_from_department']=['type'=>'tree','name'=>'import_from_department','id'=>'filter_import_from_department','label'=>'from_department','onclick'=>"OpenTree('department','filter_import_from_department','filter_import_from_department_id','1')"];
        $filters['import_from_department_id']=array('type'=>'hidden','name'=>'import_from_department_id','id'=>'filter_import_from_department_id','label'=>'import_from_department_id','value'=>'');
        //import_book_subject
        $filters['import_book_subject']=['type'=>'text','name'=>'import_book_subject','id'=>'filter_import_book_subject','label'=>'subject'];

        $cols[0]='import_received_date';
        $cols[1]='import_code';
        $cols[2]='import_from_department';
        $cols[3]='import_book_subject';
        $cols[4]='Actions';

        $data['ajax_url']=$ajax_url;
        $data['DataTable']=DataTableBuilder('InboxList',$ajax_url,$cols,$filters);
        $this->_temp_output('Inbox/List',$data);
    }

    public function AjaxList($lastTraceTypeId = null)
    {
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $order= $this->input->post("order");


        $cols[0]='import_received_date';
        $cols[1]='import_code';
        $cols[2]='import_from_department';
        $cols[3]='import_book_subject';
        $cols[4]='import_id';
//        if(isset($order[0]['column'])){
//            $order=' ORDER BY '.$cols[$order[0]['column']] . ' ' . $order[0]['dir'];
//        }

        $order=' ORDER BY  import_trace_sent_date desc,  import_trace_id desc';

        $filter="";
        //import_code
        $filtered_on_code = false;

        $import_code=$this->input->post("import_code");
        if ($import_code && $import_code!="") {
            $filtered_on_code = true;
            $filter.=" AND  concat(`import`.import_code, `import`.import_id)   = '$import_code'";
        }
        //import_from_department
        $import_from_department=$this->input->post("import_from_department_id");
        if ($import_from_department && $import_from_department!="") {
            $filter.=" AND `import_from_department_id` = '$import_from_department'";
        }
        //import_book_subject
        $import_book_subject=$this->input->post("import_book_subject");
        if ($import_book_subject && $import_book_subject!="") {
            $filter.=" AND `import_book_subject` LIKE '%$import_book_subject%'";
        }

        $user_department_id = $this->UserModel->user_department_id();

        $filter_trace_type = '';
        if ($lastTraceTypeId == -1) {
            // For received items
            $filter_trace_type .= " AND `import_trace`.`import_trace_import_trace_type_id` = 1";
            $filter .= " AND `import_trace`.`import_trace_receiver_department_id`  = '$user_department_id' ";
        } elseif ($lastTraceTypeId !== null) {
            // For specific trace type
            $filter_trace_type .= " AND `import_trace`.`import_trace_import_trace_type_id` = $lastTraceTypeId";

            // Filter by sender/receiver based on trace type
            $user_field = ($lastTraceTypeId == 1) ? 'sender' : 'receiver';
            $filter .= " AND `import_trace`.`import_trace_{$user_field}_department_id` = '$user_department_id' ";
        }

        $filter .= $filter_trace_type;

        $InboxDocs = $this->InboxModel->GetInboxList($filter,$start,$length,$order);

        $InboxDocsData=$InboxDocs['data'];
        $num_rows=$InboxDocs['count'];
        $ajax=array();
        foreach($InboxDocsData as $InboxDoc) {

            $actions='<div class="btn-group btn-group-sm" dir="ltr">';

            /*  if($this->Permission->CheckPermissionOperation('units_view')){
            $actions.='<a class="btn btn-sm btn-success" data-toggle="modal" data-target="#extra-modal" onclick="CallViewModal('.$Order['id'].')" role="button"> <i class="fas fa-eye"></i></a>';
            }
            if($this->Permission->CheckPermissionOperation('orders_orderdetails')){
            $actions.='<a class="btn btn-sm btn-warning" onclick="CallHighliteOrder('.$Order['order_id'].','.$Order['order_highlight'].')" role="button"> <i class="fas fa-highlighter"></i></a>';
            } */
            // if($this->Permission->CheckPermissionOperation('clients_clientdetails')){
            //     $InboxDoc['client_name']='<a href="'.base_url("Clients/ClientDetails/".$InboxDoc['client_id']).'" target="_blank">'.$InboxDoc['client_name'].'</a>';
            // $actions.='<a class="btn btn-sm btn-primary" href="'.base_url("Clients/ClientDetails/".$InboxDoc['client_id']).'" role="button"> <i class="fas mr-1 ml-1 fa-info"></i></a>';
            // }
            /*
            if($this->Permission->CheckPermissionOperation('units_deleteUnit')){
            $actions.='<a class="btn btn-sm btn-danger" onclick="CallDelete('.$Order['id'].','."'".$Order['block_number']."'".')" role="button"> <i class="fas fa-trash"></i></a>';
            }
            if($this->Permission->CheckPermissionOperation('unitcheck_unitcheckdetails')){
            $actions.='<a class="btn btn-sm btn-warning" href="'.base_url("UnitCheck/UnitCheckDetails/".$Order['id']).'" role="button"> <i class="fas mr-1 ml-1 fa-check"></i></a>';
            } */


            $actions.='<a class="btn btn-sm btn-info" href="'.base_url("Import/Details/".$InboxDoc['import_id']).'" role="button"> <i class="fa fa-eye"></i></a>';
            $actions.='</div>';
            $ajax[]=[
                'import_id'=>$InboxDoc['import_id'],
                'import_code'=>$InboxDoc['import_code'],
                'import_from_department'=>$InboxDoc['import_from_department'],
                'import_book_subject'=>$InboxDoc['import_book_subject'],
                'import_received_date'=>$InboxDoc['import_received_date'],
                'import_trace_type_name'=> $this->Dictionary->GetKeyword( $InboxDoc['import_trace_type_name'] ),
                'import_trace_type_icon'=> ($lastTraceTypeId == -1 ) ? 'fa fa-arrow-down' :  $InboxDoc['import_trace_type_icon'],
                'import_trace_status_name'=>$InboxDoc['import_trace_status_name'],
                'import_trace_status_icon'=>$InboxDoc['import_trace_status_icon'],
                'import_trace_is_read'=>$InboxDoc['import_trace_is_read'],
                'import_trace_sent_date'=>$InboxDoc['import_trace_sent_date'],
                'selected_trace_type_id'=>$lastTraceTypeId,
                'last_trace_sender_department' => $InboxDoc['last_trace_sender_department'] ,
                'last_trace_sender_user' => $InboxDoc['last_trace_sender_user'] ,
                'Actions'=>$actions
            ];
        }
        $notFoundMessageData = [];
        if($num_rows == 0 && $filtered_on_code){
            //$notFoundMessage
            $filterWithoutType = str_replace($filter_trace_type, '', $filter);

            $dataInOtherType = $this->InboxModel->GetInboxFilteredCodeNotFoundInTheList($filterWithoutType);
            if($dataInOtherType){

                $notFoundMessageData[] =   $dataInOtherType['import_trace_import_trace_type_id'] ;
                $notFoundMessageData[] = $this->Dictionary->GetKeyword($dataInOtherType['import_trace_type_name']) ;

                if($dataInOtherType['import_trace_import_trace_type_id'] == 1 ){

                    if($dataInOtherType['import_trace_receiver_department_id'] = $user_department_id){
                        $notFoundMessageData[] = '-1' ;
                        $notFoundMessageData[] = $this->Dictionary->GetKeyword('Received') ;
                    }

                }


            }
//            var_dump($dataInOtherType,$user_department_id,  $notFoundMessage);
//            die();
        }
        echo json_encode([
            "draw" => $draw,
            "recordsTotal" => $num_rows,
            "recordsFiltered" => $num_rows,
            "data" => $ajax,
            "notFoundMessageData" => $notFoundMessageData
        ]);

    }

}