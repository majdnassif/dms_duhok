<?php

class Import extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('ImportModel');
        $this->load->model('ImportTraceModel');
        $this->load->model('UserModel');
        $this->load->model('OutModel');
        $this->load->model('Dictionary');
        $this->load->database();
    }

    public function index()
    {
        $this->List();
    }

    public function _temp_output($view, $output=null)
    {
        if($this->session->userdata('user_login_data')){
            $this->load->view("Admin2/header", (array)$output);
            $perm = $this->Permission->CheckPermission();
            if($perm == true){
                $this->load->view("Admin2/$view", (array)$output);
            }else{
                $this->load->view('Admin2/permission');
            }
            $this->load->view("Admin2/footer", (array)$output);
        }else{
            return $this->load->view('Admin2/login');
        }
    }

    public function List()
    {

        $data['page_title'] = 'Import Documents';
        $data['page_card_title'] = 'Import Documents';
        $filters = array();

        // Filters
        $filters['import_incoming_number'] = ['type'=>'text', 'name'=>'import_incoming_number', 'id'=>'filter_import_incoming_number', 'label'=>'Incoming Number'];
        $filters['import_book_number'] = ['type'=>'text', 'name'=>'import_book_number', 'id'=>'filter_import_book_number', 'label'=>'Book Number'];
        $filters['import_from_department'] = ['type'=>'tree', 'name'=>'import_from_department', 'id'=>'filter_import_from_department', 'label'=>'From Department', 'onclick'=>"OpenTree('department','filter_import_from_department','filter_import_from_department_id','1')"];
        $filters['import_from_department_id'] = ['type'=>'hidden', 'name'=>'import_from_department_id', 'id'=>'filter_import_from_department_id', 'label'=>'import_from_department_id', 'value'=>''];
        $filters['import_book_subject'] = ['type'=>'text', 'name'=>'import_book_subject', 'id'=>'filter_import_book_subject', 'label'=>'Subject'];
        $filters['import_code'] = ['type'=>'text', 'name'=>'import_code', 'id'=>'filter_import_code', 'label'=>'Code'];

        $filters['import_to_department'] = ['type'=>'tree', 'name'=>'import_to_department', 'id'=>'filter_import_to_department', 'label'=>'To Department', 'onclick'=>"OpenTree('department','filter_import_to_department','filter_import_to_department_id','1')"];
        $filters['import_to_department_id'] = ['type'=>'hidden', 'name'=>'import_to_department_id', 'id'=>'filter_import_to_department_id', 'label'=>'import_to_department_id', 'value'=>''];

        $filters['import_is_direct'] = ['type'=>'custom_html' , 'content'=>'
                                           <div class="form-group col-xl-6 col-md-4 col-sm-6 col-xs-12">
                                          <label></label>
                                            <div class=" border-top pt-3">
                                                <div class=" align-items-center" style="display: flex; justify-content: space-around;">
                                                 <div class="col-auto">
                                                  
                                                      <label>' . $this->Dictionary->GetKeyword("Is Direct") . '</label>
                                                  </div>  
                                                   <div class="col-auto">
                                                    <label class="custom-label" for="filter_import_is_direct_all"> ' . $this->Dictionary->GetKeyword("All") . '</label>
                                                    <input class="form-check-input " style="margin-left: -8px !important;" type="radio" id="filter_import_is_direct_all" name="import_is_direct" value="all" checked >
                                                  </div>
                                                  
                                                  <div class="col-auto">
                                                    <label class="custom-label" for="filter_import_is_direct_yes"> ' . $this->Dictionary->GetKeyword("Yes") . '</label>
                                                    <input class="form-check-input" style="margin-left: -8px !important;"  type="radio" id="filter_import_is_direct_yes" name="import_is_direct" value="yes" >
                                                  </div>
                                                  
                                                    <div class="col-auto">
                                                    <label class="custom-label" for="filter_import_is_direct_no">  ' . $this->Dictionary->GetKeyword("No") . '</label>
                                                    <input class="form-check-input" style="margin-left: -8px !important;"  type="radio" id="filter_import_is_direct_no" name="import_is_direct" value="no" >
                                                  </div>
                                                
                                    
                                                </div>
                                              </div>
                                         </div>',
            'inputs' => [
                ['id' => 'filter_import_is_direct_all', 'name' => 'import_is_direct', 'type' => 'radio'],
                ['id' => 'filter_import_is_direct_yes', 'name' => 'import_is_direct', 'type' => 'radio'],
                ['id' => 'filter_import_is_direct_no', 'name' => 'import_is_direct', 'type' => 'radio']
            ]

        ];


//        $filters['import_book_date'] = ['type'=>'date', 'name'=>'import_book_date', 'id'=>'filter_import_book_date', 'label'=>'Book Date From'];

        $filters['import_body'] = ['type'=>'text', 'name'=>'import_body', 'id'=>'filter_import_body', 'label'=>'Body'];

        $filters['out_number'] = ['type'=>'text', 'name'=>'out_number', 'id'=>'filter_out_number', 'label'=>'Out Number'];


        $filters['import_book_date'] = ['type'=>'custom_html' , 'content'=>'
                                           <div class="form-group col-xl-8 col-md-8 col-sm-12 col-xs-12">
                                          <label></label>
                                            <div class=" border-top pt-3">
                                                <div class=" align-items-center" style="display: flex; justify-content: space-around;">
                                                 <div class="col-2">
                                                    <label > ' . $this->Dictionary->GetKeyword("Book Date") . '</label>
                                                  </div>    
                                                 <div class="col-auto">
                                                    <label class="custom-label"> ' . $this->Dictionary->GetKeyword("From") . '</label>
                                                  </div>      
                                                  <div class="col-auto">
                                                    <input type="date" id="filter_import_book_date_from" name="import_book_date_from"  class="form-control date-input">
                                                  </div>
                                             
                                                   <div class="col-auto">
                                                    <label class="custom-label"> ' . $this->Dictionary->GetKeyword("To") . '</label>
                                                  </div>
                                                  <div class="col-auto">
                                                    <input type="date" id="filter_import_book_date_to"  name="import_book_date_to" class="form-control date-input">
                                                  </div>
                                                  
                                                  <div class="col-auto">
                                                    <label class="custom-label" for="today"> ' . $this->Dictionary->GetKeyword("Today") . '</label>
                                                    <input class="form-check-input today-checkbox" type="checkbox" id="filter_import_book_date_today" name="import_book_date_today"  >
                                                  </div>
                                                
                                    
                                                </div>
                                              </div>
                                         </div>',
            'inputs' => [
                ['id' => 'filter_import_book_date_from', 'name' => 'import_book_date_from'],
                ['id' => 'filter_import_book_date_to', 'name' => 'import_book_date_to'],
                ['id' => 'filter_import_book_date_today', 'name' => 'import_book_date_today', 'type' => 'checkbox']
            ]

        ];



        $sql_signed_by = "select import_signed_by as id, import_signed_by as name from (
                            SELECT  distinct import_signed_by FROM `import`
                            ) signed_by_list";
        $assigned_by_list = $this->db->query($sql_signed_by)->result_array();
        //  var_dump($assigned_by_list);
        $filters['import_signed_by'] = ['type'=>'select', 'name'=>'import_signed_by', 'id'=>'filter_import_signed_by', 'label'=>'Signed', 'list'=> $assigned_by_list, 'list_name' => 'name', 'list_id' =>'id', 'translate' => false];


        $filters['import_received_date'] = ['type'=>'custom_html' , 'content'=>'
                                           <div class="form-group col-xl-8 col-md-8 col-sm-12 col-xs-12">
                                             <label></label>
                                                <div class=" border-top pt-3">
                                                
                                                    <div class=" align-items-center" style="display: flex; justify-content: space-around;">
                                                    
                                                        <div class="col-auto">
                                                            <label > ' . $this->Dictionary->GetKeyword("Received Date") . '</label>
                                                         </div>  
                                                         <div class="col-auto">
                                                            <label class="custom-label"> ' . $this->Dictionary->GetKeyword("From") . '</label>
                                                          </div>      
                                                          <div class="col-auto">
                                                            <input type="date" id="filter_import_received_date_from" name="import_received_date_from"  class="form-control date-input">
                                                          </div>
                                                     
                                                           <div class="col-auto">
                                                            <label class="custom-label"> ' . $this->Dictionary->GetKeyword("To") . '</label>
                                                          </div>
                                                          <div class="col-auto">
                                                            <input type="date" id="filter_import_received_date"  name="import_received_date_to" class="form-control date-input">
                                                          </div>
                                                          
                                                          <div class="col-auto">
                                                            <label class="custom-label" for="today"> ' . $this->Dictionary->GetKeyword("Today") . '</label>
                                                            <input class="form-check-input today-checkbox" type="checkbox" id="filter_import_received_date_today" name="import_received_date_today"  >
                                                          </div>
                                                          
                                                    </div>
                                                    
                                                 </div>
                                         </div>',
            'inputs' => [
                ['id' => 'filter_import_received_date_from', 'name' => 'import_received_date_from'],
                ['id' => 'filter_import_received_date_to', 'name' => 'import_received_date_to'],
                ['id' => 'filter_import_received_date_today', 'name' => 'import_received_date_today', 'type' => 'checkbox']
            ]

        ];



        $sql_import_type = "SELECT import_trace_type_id as id, 	import_trace_type_name	as name FROM `import_trace_type`";
        $import_types = $this->db->query($sql_import_type)->result_array();
        $filters['import_type'] = ['type'=>'select', 'name'=>'import_type', 'id'=>'filter_import_type', 'label'=>'Type', 'list'=> $import_types, 'list_name' => 'name', 'list_id' =>'id', 'translate' => false];



        $filters['import_created_at'] = ['type'=>'custom_html' , 'content'=>'
                                           <div class="form-group col-xl-8 col-md-8 col-sm-12 col-xs-12">
                                          <label></label>
                                            <div class=" border-top pt-3">
                                                <div class=" align-items-center" style="display: flex; justify-content: space-around;">
                                                 <div class="col-auto">
                                                    <label > ' . $this->Dictionary->GetKeyword("Registration Date") . '</label>
                                                  </div>  
                                                 <div class="col-auto">
                                                    <label class="custom-label"> ' . $this->Dictionary->GetKeyword("From") . '</label>
                                                  </div>      
                                                  <div class="col-auto">
                                                    <input type="date" id="filter_import_register_date_from" name="import_register_date_from"  class="form-control date-input">
                                                  </div>
                                             
                                                   <div class="col-auto">
                                                    <label class="custom-label"> ' . $this->Dictionary->GetKeyword("To") . '</label>
                                                  </div>
                                                  <div class="col-auto">
                                                    <input type="date" id="filter_import_register_date_to"  name="import_register_date_to" class="form-control date-input">
                                                  </div>
                                                  
                                                  <div class="col-auto">
                                                    <label class="custom-label" for="today"> ' . $this->Dictionary->GetKeyword("Today") . '</label>
                                                    <input class="form-check-input today-checkbox" type="checkbox" id="filter_import_register_date_today" name="import_register_date_today"  >
                                                  </div>
                                                
                                    
                                                </div>
                                              </div>
                                         </div>',
            'inputs' => [
                ['id' => 'filter_import_register_date_from', 'name' => 'import_register_date_from'],
                ['id' => 'filter_import_register_date_to', 'name' => 'import_register_date_to'],
                ['id' => 'filter_import_register_date_today', 'name' => 'import_register_date_today', 'type' => 'checkbox']
            ]

        ];




        $sql_import_type = "SELECT
                                import_trace_status_id AS id,
                                import_trace_status_name AS name 
                            FROM
                                `import_trace_status`";
        $import_statuses = $this->db->query($sql_import_type)->result_array();
        //var_dump($import_statuses);
        $content = '<div class="form-group col-xl-6 col-md-6 col-sm-6 col-xs-12">
                                          <label></label>
                                            <div class=" border-top pt-3">
                                                <div class=" align-items-center" style="display: flex; justify-content: space-around;">
                                                 <div class="col-auto">
                                                    <label > ' . $this->Dictionary->GetKeyword("Status") . '</label>
                                                  </div>';
        foreach ($import_statuses as $status) {
            $content .= ' <div class="col-auto">
                                <label class="custom-label" for="today">' . $this->Dictionary->GetKeyword($status['name']) . '</label>
                                <input class="form-check-input today-checkbox" type="checkbox" id="filter_trace_statuses_'.$status['id'] .'" name="trace_statuses" value=" ' .$status['id']. '" checked >
                          </div> ';
        }

        $content .=         '</div>
                              </div>
                         </div>';

        $filters['trace_status_id'] =
            //['type'=>'select', 'name'=>'trace_status_id', 'id'=>'filter_trace_status_id', 'label'=>'Trace Status', 'list'=> $import_statuses, 'list_name' => 'name', 'list_id' =>'id', 'translate' => false, 'multiple' => true];
            ['type'=>'custom_html' , 'content'=>$content,
                'inputs' => [
                    ['id' => 'filter_trace_statuses', 'name' => 'trace_statuses', 'type' => 'checkbox_group']
                ]

            ];


        $cols[0] = 'import_code';
        $cols[1] = 'import_book_number';
        $cols[2] = 'import_book_date';
        $cols[3] = 'import_book_subject';
        $cols[4] = 'import_from_department';
        $cols[5] = 'Actions';

        $data['DataTable'] = DataTableBuilder('ImportList', base_url("Import/AjaxList"), $cols, $filters);
        $this->_temp_output('Import/List', $data);
    }

    public function AjaxList()
    {
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $order = $this->input->post("order");

        $cols[0] = 'import_code';
        $cols[1] = 'import_book_number';
        $cols[2] = 'import_book_date';
        $cols[3] = 'import_book_subject';
        $cols[4] = 'import_from_department';
        $cols[5] = 'import_id';

        if(isset($order[0]['column'])){
            $order = ' ORDER BY ' . $cols[$order[0]['column']] . ' ' . $order[0]['dir'];
        }

        $filter = "";

        // import_incoming_number
        $import_incoming_number =   $this->input->post("import_incoming_number");


        if ($import_incoming_number && $import_incoming_number != "") {
            $filter .= " AND `import_incoming_number` = '" . $this->db->escape_str($import_incoming_number) . "'";
        }
        // import_book_number
        $import_book_number = $this->input->post("import_book_number");
        if ($import_book_number && $import_book_number != "") {
            $filter .= " AND `import_book_number` = '" . $this->db->escape_str($import_book_number) . "'";
        }

        // import_from_department
        $import_from_department = $this->input->post("import_from_department_id");
        if ($import_from_department && $import_from_department != "") {
            $filter .= " AND `import_from_department_id` = '" . $this->db->escape_str($import_from_department) . "'";
        }
        // import_book_subject
        $import_book_subject = $this->input->post("import_book_subject");
        if ($import_book_subject && $import_book_subject != "") {
            $filter .= " AND `import_book_subject` LIKE '%" . $this->db->escape_str($import_book_subject) . "%'";
        }

        // import_code
        $import_code = $this->input->post("import_code");
        if ($import_code && $import_code != "") {
            $filter .= " AND   concat(`import`.import_code, `import`.import_id)   = '" . $this->db->escape_str($import_code) . "'";
        }


        $import_to_department = $this->input->post("import_to_department_id");
        if ($import_to_department && $import_to_department != "") {
            $filter .= " AND `import_to_department_id` = '" . $this->db->escape_str($import_to_department) . "'";
        }





        $import_book_date_from = $this->input->post('import_book_date_from');
        if ($import_book_date_from && $import_book_date_from != "") {
            $filter .= " AND `import_book_date` >= '" . $this->db->escape_str($import_book_date_from) . "'";
        }
        $import_book_date_to = $this->input->post('import_book_date_to');
        if ($import_book_date_to && $import_book_date_to != "") {
            $filter .= " AND `import_book_date` <= '" . $this->db->escape_str($import_book_date_to) . "'";
        }
        $import_book_date_today = $this->input->post('import_book_date_today');
        if ($import_book_date_today && $import_book_date_today != "false" ) {
            $today = date('Y-m-d');
            $filter .= " AND `import_book_date` = '" . $today . "'";
        }


        $import_body = $this->input->post("import_body");
        if ($import_body && $import_body != "") {
            $filter .= " AND `import_body` LIKE '%" . $this->db->escape_str($import_body) . "%'";
        }



        $import_received_date_from = $this->input->post('import_received_date_from');
        if ($import_received_date_from && $import_received_date_from != "") {
            $filter .= " AND `import_received_date` >= '" . $this->db->escape_str($import_received_date_from) . "'";
        }
        $import_received_date_to = $this->input->post('import_received_date_to');
        if ($import_received_date_to && $import_received_date_to != "") {
            $filter .= " AND `import_received_date` <= '" . $this->db->escape_str($import_received_date_to) . "'";
        }
        $import_received_date_today = $this->input->post('import_received_date_today');
        if ($import_received_date_today && $import_received_date_today != "false" ) {
            $today = date('Y-m-d');
            $filter .= " AND `import_received_date` = '" . $today . "'";
        }




        $import_is_direct = $this->input->post('import_is_direct');
        if ($import_is_direct && $import_is_direct != "all") {
            if ($import_is_direct == 'yes') {
                $filter .= " AND `import_is_direct` = 1";
            } elseif ($import_is_direct == 'no') {
                $filter .= " AND `import_is_direct` = 0";
            }
        }



        $import_register_date_from = $this->input->post('import_register_date_from');
        if ($import_register_date_from && $import_register_date_from != "") {
            $filter .= " AND `import_created_at` >= '" . $this->db->escape_str($import_register_date_from) . "'";
        }
        $import_register_date_to = $this->input->post('import_register_date_to');
        if ($import_register_date_to && $import_register_date_to != "") {
            $filter .= " AND `import_created_at` <= '" . $this->db->escape_str($import_register_date_to) . "'";
        }
        $import_register_date_today = $this->input->post('import_register_date_today');
        if ($import_register_date_today && $import_register_date_today != "false" ) {
            $today = date('Y-m-d');
            $filter .= " AND `import_created_at` = '" . $today . "'";
        }



        $import_signed_by = $this->input->post("import_signed_by");
        if ($import_signed_by && $import_signed_by != "") {
            $filter .= " AND `import_signed_by` = '" . $this->db->escape_str($import_signed_by) . "'";
        }


        $import_type = $this->input->post("import_type");
        if ($import_type && $import_type != "") {
            $filter .= " AND `import_trace_import_trace_type_id` = '" . $this->db->escape_str($import_type) . "'";
        }


//        $trace_status_ids = $this->input->post("trace_statuses");
//        if ($trace_status_ids && $trace_status_ids != "") {
//            $filter .= " AND `import_trace_status_id` IN (" . $trace_status_ids . ")";
//        }


        $out_number = $this->input->post("out_number");
        if ($out_number && $out_number != "") {
            $out_sql = "SELECT import_id FROM `out`
                        where out_book_number = $out_number";
            $outs_data = $this->db->query($out_sql)->result_array();

            if ($outs_data) {
                $out_ids = array_column($outs_data, 'import_id');
                if (!empty($out_ids)) {
                    $filter .= " AND `import_id` IN (" . implode(',', $out_ids) . ")";
                }
            }

        }



        //  $start = microtime(true);
        $import_docs = $this->ImportModel->GetImportList($filter, $start, $length, $order);
        //  $end = microtime(true);
        // var_dump("Query Time: " . ($end - $start) . " seconds");

        $import_docs_data = $import_docs['data'];
        $num_rows = $import_docs['count'];
        $ajax = array();

        $canEdit = $this->Permission->CheckPermissionOperation('import_edit');
        $canDelete = $this->Permission->CheckPermissionOperation('import_delete');

        foreach($import_docs_data as $doc) {
            $actions = '<div class="btn-group btn-group-sm" dir="ltr">';

            // View Details
            if($doc['is_deleted'] != 1) {
                $actions .= '<a class="btn btn-sm btn-info" target="_blank" href="' . base_url("Import/Details/" . $doc['import_id']) . '" role="button"><i class="fa fa-eye"></i></a>';
            }
            // Edit
            if($canEdit && $doc['is_deleted'] != 1){
                $actions .= '<a class="btn btn-sm btn-primary" target="_blank" href="' . base_url("Import/Edit/" . $doc['import_id']) . '" role="button"><i class="fa fa-edit"></i></a>';
            }

            if($canDelete){
                // Delete

                if($doc['is_deleted'] == 1){
                    $actions .= '<a class="btn btn-sm btn-warning" onclick="RestoreImport(' . $doc['import_id'] . ', \'' . $doc['import_code'] . '\')" role="button"><i class="fa fa-undo"></i></a>';
                } else {
                    $actions .= '<a class="btn btn-sm btn-danger" onclick="DeleteImport(' . $doc['import_id'] . ', \'' . $doc['import_code'] . '\')" role="button"><i class="fa fa-trash"></i></a>';
                }
            }


            $actions .= '</div>';

            $ajax[] = [
                'import_id' => $doc['import_id'],
                'import_code' => $doc['import_code'],
                'import_book_number' => $doc['import_book_number'],
                'import_book_date' => $doc['import_book_date'],
                'import_book_subject' => $doc['import_book_subject'],
                'import_from_department' => $doc['import_from_department'],
                'Actions' => $actions
            ];
        }

        echo json_encode([
            "draw" => $draw,
            "recordsTotal" => $num_rows,
            "recordsFiltered" => $num_rows,
            "data" => $ajax
        ]);
    }

    public function Add($remote_out_id = null, $branch_id = null)
    {
        $data['page_title'] = 'Add New Import Document';
        $data['page_card_title'] = 'Import Document Details';

        if ($this->input->server('REQUEST_METHOD') == 'POST') {


//            $this->form_validation->set_rules('import_code', 'Import Code', 'required');
            $this->form_validation->set_rules('import_book_subject', 'Book Subject', 'required');
            $this->form_validation->set_rules('import_to_department_id', 'To Department', 'required');
            $this->form_validation->set_rules('import_from_department_id', 'From Department', 'required');
            $this->form_validation->set_rules('trace_receiver_department_id', 'Trace Receiver Department', 'required');
            $this->form_validation->set_rules('trace_receiver_user_id', 'Trace Receiver User', 'required');

            if ($this->input->post('contact_name')) {
                $this->form_validation->set_rules('contact_name', 'Contact Name', 'required');
                // $this->form_validation->set_rules('contact_email', 'Contact Email', 'valid_email');
                $this->form_validation->set_rules('contact_phone', 'Contact Phone', 'required');

            }
//            var_dump($this->input->post());
//            die();
            if ($this->form_validation->run() == TRUE) {

                $import_data = [
                    'import_code' =>  date('y').  date('m') ,  // $this->input->post('import_code'),
                    'import_book_number' => $this->input->post('import_book_number'),
                    'import_book_date' => $this->input->post('import_book_date'),
                    'import_book_subject' => $this->input->post('import_book_subject'),
                    'import_to_department_id' => $this->input->post('import_to_department_id'),
                    'import_from_department_id' => $this->input->post('import_from_department_id'),
                    'import_received_date' => $this->input->post('import_received_date'),
                    'import_incoming_number' => $this->input->post('import_incoming_number'),
                    'import_signed_by' => $this->input->post('import_signed_by'),
                    'import_book_category_id' => $this->input->post('import_book_category_id'),
                    'import_book_language_id' => $this->input->post('import_book_language_id'),
                    'import_book_importance_level_id' => $this->input->post('import_book_importance_level_id'),
                    'import_is_direct' => $this->input->post('import_is_direct') ? 1 : 0,
                    'import_is_answer' => $this->input->post('import_is_answer') ? 1 : 0,
                    'import_note' => $this->input->post('import_note'),
                    'remote_out_id' => $this->input->post('remote_out_id') ? $this->input->post('remote_out_id') : null,
                    'remote_branch_id' => $this->input->post('remote_branch_id') ? $this->input->post('remote_branch_id') : null,
                ];


                $this->db->trans_begin();
                try{
                    // Handle uploads if any
                    if (!empty($_FILES['attachments']['name'][0])) {
                        $attachments = [];
                        $temp_attachments = [];  // temp storage
                        $upload_errors = [];
                        $files = $_FILES['attachments'];
                        $config['upload_path'] = './assets/uploads/attachments/';
                        $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf|doc|docx|xls|xlsx';
                        $config['max_size'] = 102400; // 5MB

                        // Make sure upload directory exists
                        if (!is_dir($config['upload_path'])) {
                            mkdir($config['upload_path'], 0777, TRUE);
                        }

                        $this->load->library('upload', $config);

                        for ($i = 0; $i < count($files['name']); $i++) {
                            $_FILES['file']['name'] = $files['name'][$i];
                            $_FILES['file']['type'] = $files['type'][$i];
                            $_FILES['file']['tmp_name'] = $files['tmp_name'][$i];
                            $_FILES['file']['error'] = $files['error'][$i];
                            $_FILES['file']['size'] = $files['size'][$i];

                            $config['file_name'] = 'In_' . time() . '_' . $files['name'][$i];
                            $this->upload->initialize($config);

                            if ($this->upload->do_upload('file')) {
                                $upload_data = $this->upload->data();
//                                $attachments[] = [
//                                    'filename' => $upload_data['file_name'],
//                                    'original_name' => $files['name'][$i],
//                                    'file_path' => 'attachments/' . $upload_data['file_name']
//                                ];
                                $temp_attachments[] = [
                                    'filename' => $upload_data['file_name'],
                                    'original_name' => $files['name'][$i],
                                    'file_path' => 'attachments/' . $upload_data['file_name'],
                                    'full_path' => $upload_data['full_path'], // for cleanup
                                ];
                            }
                            else {
                                $upload_errors[] = [
                                    'file' => $files['name'][$i],
                                    'error' => $this->upload->display_errors('', '')
                                ];
                            }
                        }
//
//                        if (!empty($attachments)) {
//                            $import_data['import_attachment'] = $attachments;
//                        }

                        // If any errors occurred, delete uploaded files and throw
                        if (!empty($upload_errors)) {

                            foreach ($temp_attachments as $temp) {
                                if (file_exists($temp['full_path'])) {
                                    unlink($temp['full_path']); // rollback
                                }
                            }
                            throw new Exception('Error in File '. $upload_errors[0]['file']. ': ' . $upload_errors[0]['error']); // or handle all errors
                        }

                        // All successful
                        if (!empty($temp_attachments)) {
                            $attachments = $temp_attachments;
                            $import_data['import_attachment'] = $attachments;
                        }
                    }



                    $import_book_date = $import_data['import_book_date'];
                    $year = date('Y', strtotime($import_book_date));
                    $isImportExists = $this->ImportModel->isImportExists($import_data['import_book_number'], $year, $import_data['import_from_department_id'] );

                    if($isImportExists) {
                        $book_number = $import_data['import_book_number'];
                        throw new Exception( "Book number ( $book_number ) already exists in the current year ( $year ) in the from department ");
                    }else {

                        $import_id = $this->ImportModel->AddImport($import_data);

                        if ($import_id) {

                            if ($this->input->post('contact_name')) {
                                $import_contact_data = [
                                    'import_id' => $import_id,
                                    'name' => $this->input->post('contact_name'),
                                    'email' => $this->input->post('contact_email'),
                                    'phone' => $this->input->post('contact_phone'),
                                ];

                                $this->ImportModel->AddContact($import_contact_data);
                            }

                            if ($this->input->post('special_form_pages_count')) {

                                $import_special_form_data = [
                                    'page_number' => $this->input->post('special_form_pages_count'),
                                    'note' => $this->input->post('special_form_note'),
                                    'import_id' => $import_id,
                                    'created_by' => $this->UserModel->user_id(),
                                ];

                                $this->ImportModel->AddSpecialForm($import_special_form_data);
                            }


                            $first_trace = [
                                'import_trace_import_id' => $import_id,
                                'import_trace_import_trace_type_id' => 1,
                                'import_trace_status_id' => 1, // $this->input->post('trace_status_id'),
                                'import_trace_action_type_id' => $this->input->post('trace_action_type_id'),
                                'import_trace_sender_department_id' => $this->input->post('import_from_department_id'),
                                'import_trace_sent_date' => date('Y-m-d H:i:s'),
                                'import_trace_receiver_department_id' => $this->input->post('trace_receiver_department_id'),
//                        'import_trace_received_date' => $this->input->post('trace_received_date'),
                                'import_trace_receiver_user_id' => $this->input->post('trace_receiver_user_id'),
                                'import_trace_note' => $this->input->post('trace_note'),
                            ];

                            $trace_id = $this->ImportTraceModel->AddFirstTrace($first_trace);

                            if (!$trace_id) {
                                throw new Exception('Failed to add first trace');
                            }


                            if ($import_data['import_is_answer'] == 1) {
                                $answer_data_out_book_numbers_arr = $this->input->post('answer_out_book_number');
                                $answer_data_out_book_dates_arr = $this->input->post('answer_out_book_date');
                                $answer_data_out_department_ids_arr = $this->input->post('answer_out_to_department_id');
                                foreach ($answer_data_out_book_numbers_arr as $key => $value) {

                                    $out_book_number = $value;
                                    $out_book_date = $answer_data_out_book_dates_arr[$key];
                                    $out_from_department_id = $answer_data_out_department_ids_arr[$key];
                                    $out = $this->OutModel->GetOUtRelatedToAnswer($out_book_number, $out_book_date);
                                    $out_id = $out ? $out['id'] : null;
                                    $this->ImportModel->AddImportAnswer($import_id, $out_id, $out_book_number, $out_book_date, $out_from_department_id);

                                }
                            }

                            // Complete the transaction
                            $this->db->trans_commit();

                            // Check if the transaction was successful
                            if ($this->db->trans_status() === FALSE) {
                                throw new Exception('Transaction failed');
                            }

                            $this->session->set_flashdata('success', 'Import document added successfully');

                            return $this->output
                                ->set_content_type('application/json')
                                ->set_output(json_encode([
                                    'status' => 'true',
                                    'import_id' => $import_id
                                ]));

                        } else {
                            $data['error'] = 'Failed to add import document';
                            throw new Exception('Transaction failed');
                        }
                    }
                }
                catch (Exception $e) {

                    $this->db->trans_rollback();
                    // $this->session->set_flashdata('error', $e->getMessage());

                    return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode([
                            'status' => 'false',
                            'message' => $e->getMessage()
                        ]));

                }

            }else{

                return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode([
                        'status' => 'false',
                        'message' => 'Failed to add import document',
                        'errors' => $this->form_validation->error_array()
                    ]));
            }
        }

        if($remote_out_id && $branch_id) {
            $remote_out_id = intval($remote_out_id);
            $data['remote_out'] = $this->OutModel->GetRemoteOutDetails($branch_id, $remote_out_id);
            $data['remote_branch_id'] = $branch_id;

        }
        // $data['trace_types'] = $this->ImportTraceModel->GetTraceTypes();
        //  $data['trace_statuses'] = $this->ImportTraceModel->GetTraceStatuses();
        $data['trace_action_types'] = $this->ImportTraceModel->GetActionTypes();
        //  $data['users'] = $this->UserModel->GetActiveUsers();

        $data['current_department'] = $this->db->query("SELECT id, fullpath FROM department where is_current = 1")->row();

        $this->_temp_output('Import/Add', $data);
    }

    public function Details($import_id)
    {


        $data['page_title'] = 'Import Document Details';
        $data['import'] = $this->ImportModel->GetImportDetails($import_id, false);

        if (!$data['import']) {
            $this->session->set_flashdata('error', 'Import document not found');
            redirect('Import');
        }

        // Get import traces
        $data['import_traces'] = $this->ImportTraceModel->GetTraces($import_id);

        // Get trace types and statuses for the add form
        $data['trace_types'] = $this->ImportTraceModel->GetTraceTypes();

        //$data['trace_statuses'] = $this->ImportTraceModel->GetTraceStatuses();
        $data['trace_action_types'] = $this->ImportTraceModel->GetActionTypes();
        // Get all active users for user dropdowns
        $data['active_users'] = $this->UserModel->GetActiveUsers();


        $data['import_answers'] = $this->ImportModel->GetAnswers($import_id);

        $data['import_special_forms'] = $this->ImportModel->GetSpecialForms($import_id);

        $data['last_trace'] = $this->ImportTraceModel->GetLastImportLastTrace($import_id);

        $this->_temp_output('Import/Details', $data);
    }

    public function Edit($import_id)
    {
        $data['page_title'] = 'Edit Import Document';
        $data['import'] = $this->ImportModel->GetImportDetails($import_id, false);


        if (!$data['import']) {
            $this->session->set_flashdata('error', 'Import document not found');
            redirect('Import');
        }
        $data['import_answers'] = $this->ImportModel->GetAnswers($import_id);
        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            // $this->form_validation->set_rules('import_code', 'Import Code', 'required');
            $this->form_validation->set_rules('import_book_subject', 'Book Subject', 'required');
            $this->form_validation->set_rules('import_to_department_id', 'To Department', 'required');
            $this->form_validation->set_rules('import_from_department_id', 'From Department', 'required');

            if ($this->form_validation->run() == TRUE) {
                $import_data = [
                    // 'import_code' => $this->input->post('import_code'),
                    'import_book_number' => $this->input->post('import_book_number'),
                    'import_book_date' => $this->input->post('import_book_date'),
                    'import_book_subject' => $this->input->post('import_book_subject'),
                    'import_to_department_id' => $this->input->post('import_to_department_id'),
                    'import_from_department_id' => $this->input->post('import_from_department_id'),
                    'import_received_date' => $this->input->post('import_received_date'),
                    'import_incoming_number' => $this->input->post('import_incoming_number'),
                    'import_signed_by' => $this->input->post('import_signed_by'),
                    'import_book_category_id' => $this->input->post('import_book_category_id'),
                    'import_book_language_id' => $this->input->post('import_book_language_id'),
                    'import_book_importance_level_id' => $this->input->post('import_book_importance_level_id'),
                    'import_is_direct' => $this->input->post('import_is_direct') ? 1 : 0,
                    'import_is_answer' => $this->input->post('import_is_answer') ? 1 : 0,
                    'import_note' => $this->input->post('import_note')
                ];

                // Handle uploads if any
                if (!empty($_FILES['attachments']['name'][0])) {
                    $attachments = isset($data['import']['import_attachment']) ? $data['import']['import_attachment'] : [];
                    $temp_attachments = []; // store new uploads temporarily
                    $upload_errors = [];
                    $files = $_FILES['attachments'];
                    $config['upload_path'] = './assets/uploads/attachments/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf|doc|docx|xls|xlsx';
                    $config['max_size'] = 102400; // 5MB

                    // Make sure upload directory exists
                    if (!is_dir($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, TRUE);
                    }

                    $this->load->library('upload', $config);

                    for ($i = 0; $i < count($files['name']); $i++) {
                        $_FILES['file']['name'] = $files['name'][$i];
                        $_FILES['file']['type'] = $files['type'][$i];
                        $_FILES['file']['tmp_name'] = $files['tmp_name'][$i];
                        $_FILES['file']['error'] = $files['error'][$i];
                        $_FILES['file']['size'] = $files['size'][$i];

                        $config['file_name'] = 'In_' . time() . '_' . $files['name'][$i];
                        $this->upload->initialize($config);

                        if ($this->upload->do_upload('file')) {
                            $upload_data = $this->upload->data();
//                            $attachments[] = [
//                                'filename' => $upload_data['file_name'],
//                                'original_name' => $files['name'][$i],
//                                'file_path' => 'attachments/' . $upload_data['file_name']
//                            ];
                            $temp_attachments[] = [
                                'filename' => $upload_data['file_name'],
                                'original_name' => $files['name'][$i],
                                'file_path' => 'attachments/' . $upload_data['file_name'],
                                'full_path' => $upload_data['full_path'],
                            ];
                        }
                        else {
                            $upload_errors[] = [
                                'file' => $files['name'][$i],
                                'error' => $this->upload->display_errors('', '')
                            ];
                        }
                    }

//                    if (!empty($attachments)) {
//                        $import_data['import_attachment'] = $attachments;
//                    }

                    if (!empty($upload_errors)) {
                        foreach ($temp_attachments as $temp) {
                            if (file_exists($temp['full_path'])) {
                                unlink($temp['full_path']);
                            }
                        }
                        //throw new Exception('Error in File '. $upload_errors[0]['file'] . ': ' . $upload_errors[0]['error']);
                        $data['error'] = 'Error in File '. $upload_errors[0]['file'] . ': ' . $upload_errors[0]['error'];
                    }

                    // All files uploaded successfully
                    if (!empty($temp_attachments)) {
                        $attachments = array_merge($attachments, array_map(function ($item) {
                            unset($item['full_path']); // remove full_path before saving
                            return $item;
                        }, $temp_attachments));

                        $import_data['import_attachment'] = $attachments;
                    }


                }
                if(empty($data['error'])) {
                    $book_number = $import_data['import_book_number'];
                    $import_book_date = $import_data['import_book_date'];
                    $year = date('Y', strtotime($import_book_date));
                    $isImportExists = $this->ImportModel->isImportExists($import_data['import_book_number'], $year, $import_data['import_from_department_id'], $import_id );

                    if($isImportExists) {
                        $data['error'] = "Book number ( $book_number ) already exists in the current year ( $year ) in the from department ";
                    }else {

                        $update = $this->ImportModel->UpdateImport($import_id, $import_data);

                        if ($update) {
                            if ($import_data['import_is_answer']) {
                                $this->ImportModel->restoreAnswers($import_id);
                            } else {
                                $this->ImportModel->SoftDeleteAnswers($import_id);
                            }
                            $this->session->set_flashdata('success', 'Import document updated successfully');
                            redirect('Import/Details/' . $import_id);
                        } else {
                            $data['error'] = 'Failed to update import document';
                        }
                    }
                }
            }
        }

        $this->_temp_output('Import/Edit', $data);
    }

    public function AjaxDeleteAttachment()
    {
        $import_id = $this->input->post('import_id');
        $file_index = $this->input->post('file_index');

        $import = $this->ImportModel->GetImportDetails($import_id);

        if (!$import || empty($import['import_attachment'])) {
            echo json_encode(['status' => 'error', 'message' => 'Import document or attachment not found']);
            return;
        }

        $attachments = $import['import_attachment'];

        if (!isset($attachments[$file_index])) {
            echo json_encode(['status' => 'error', 'message' => 'Attachment not found']);
            return;
        }

        // Remove file physically if it exists
        $file_path = FCPATH . $attachments[$file_index]['file_path'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Remove from database
        unset($attachments[$file_index]);
        $attachments = array_values($attachments); // Reset array keys

        $update = $this->ImportModel->UpdateImport($import_id, ['import_attachment' => $attachments]);

        if ($update) {
            echo json_encode(['status' => 'success', 'message' => 'Attachment deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update import document']);
        }
    }

    public function AjaxDelete()
    {
        $import_id = $this->input->post('import_id');

        $import = $this->ImportModel->GetImportDetails($import_id);

        if (!$import) {
            echo json_encode(['status' => 'error', 'message' => 'Import document not found']);
            return;
        }

        // Delete attachments if any
//        if (!empty($import['import_attachment'])) {
//            foreach ($import['import_attachment'] as $attachment) {
//                $file_path = FCPATH . $attachment['file_path'];
//                if (file_exists($file_path)) {
//                    unlink($file_path);
//                }
//            }
//        }

        $delete = $this->ImportModel->DeleteImport($import_id);

        if ($delete) {
            echo json_encode(['status' => 'success', 'message' => 'Import document deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete import document']);
        }
    }


    public function AjaxRestore()
    {
        $import_id = $this->input->post('import_id');

        $import = $this->ImportModel->GetImportDetails($import_id);

        if (!$import) {
            echo json_encode(['status' => 'error', 'message' => 'Import document not found']);
            return;
        }

        // Delete attachments if any
//        if (!empty($import['import_attachment'])) {
//            foreach ($import['import_attachment'] as $attachment) {
//                $file_path = FCPATH . $attachment['file_path'];
//                if (file_exists($file_path)) {
//                    unlink($file_path);
//                }
//            }
//        }

        $restore = $this->ImportModel->RestoreImport($import_id);

        if ($restore) {
            echo json_encode(['status' => 'success', 'message' => 'Import document restored successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to restore import document']);
        }
    }

    /**
     * Ajax Details function to load import details without header/footer
     * Perfect for loading content in the inbox view
     */
    public function AjaxDetails($import_id, $selected_trace_type)
    {


        $data['import'] = $this->ImportModel->GetImportDetails($import_id);

        if (!$data['import']) {
            echo 'Import document not found';
            return;
        }


        // it took about 2 seconds !!!!!
        //  $this->ImportTraceModel->UpdateLastTraceIsRead($import_id);



        $data['import_answers'] = $this->ImportModel->GetAnswers($import_id);


        $data['import_traces'] = $this->ImportTraceModel->GetTraces($import_id);


        // $data['active_users'] = $this->UserModel->GetActiveUsers();
        // $data['trace_statuses'] = $this->ImportTraceModel->GetTraceStatuses();


        $data['trace_action_types'] = $this->ImportTraceModel->GetActionTypes();

        $last_trace = $this->ImportTraceModel->GetLastImportLastTrace($import_id);

        $is_assigned_to_me = $last_trace ? ($last_trace['import_trace_receiver_user_id'] == $this->UserModel->user_id()) : false;
        $data['is_assigned_to_me'] = $is_assigned_to_me;
        $data['last_trace_type'] = $last_trace ? $last_trace['import_trace_type_id'] : -1;
        $data['last_trace_id'] = $last_trace ? $last_trace['import_trace_id'] : 0;
        $is_last_trace_read = 0;
        if($last_trace && $last_trace['import_trace_status_id'] != 1){
            $is_last_trace_read = 1;
        }


        $data['last_trace_is_read'] = $is_last_trace_read;

        $data['last_trace'] = $last_trace ? $last_trace : null;

        if ($last_trace && $is_assigned_to_me && !$is_last_trace_read){
            $update_last_trace_data = [
                'import_trace_read_date' => date('Y-m-d H:i:s'),
                'import_trace_read_user_id' => $this->UserModel->user_id(),
                'import_trace_status_id' => 4,
            ];
            $this->ImportTraceModel->UpdateTrace($last_trace['import_trace_id'], $update_last_trace_data);
        }

        $data['branches'] = $this->db->query("SELECT id, name FROM system_branches where is_current = 0")->result_array();

        $data['selected_trace_type'] = $selected_trace_type;

        $this->load->view('Admin2/Import/AjaxDetails', $data);
    }



    public function AjaxAddSpecialForm()
    {

        // var_dump($this->input->post());
        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            redirect('Import');
        }

        $import_id = $this->input->post('import_id');

        if (!$import_id) {
            $this->session->set_flashdata('error', 'Invalid request');
            redirect('Import');
        }

        $this->form_validation->set_rules('special_form_page_number', 'Page Number', 'required');


        if ($this->form_validation->run() == TRUE) {

            $special_form_data = [
                'note' => $this->input->post('special_form_note'),
                'import_id' => $import_id,
                'page_number' => $this->input->post('special_form_page_number'),
                'created_by' => $this->UserModel->user_id(),
            ];

            $special_form_id =  $this->ImportModel->AddSpecialForm($special_form_data);

            if ($special_form_id) {
                $this->session->set_flashdata('success', 'Special Form  added successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to add Special Form  record');
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            return json_encode(['success' => false, 'message' => 'Validation errors occurred']);
        }
        redirect('Import/Details/' . $import_id);
        //return json_encode(['success' => true, 'message' => 'Special Form added successfully']);

    }



    public function AddTrace($isSelf = false)
    {

        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            redirect('Import');
        }

        $import_id = $this->input->post('import_id');

        if (!$import_id) {
            $this->session->set_flashdata('error', 'Invalid request');
            redirect('Import');
        }

        $this->form_validation->set_rules('import_trace_type_id', 'Trace Type', 'required');
        $this->form_validation->set_rules('import_trace_action_type_id', 'Action Type', 'required');

        if(!$isSelf){
            //  $this->form_validation->set_rules('import_trace_sender_department_id', 'Sender Department', 'required');
            $this->form_validation->set_rules('import_trace_receiver_department_id', 'Receiver Department', 'required');
        }


        if ($this->form_validation->run() == TRUE) {
            try{

                if($isSelf) {
                    $trace_data = [
                        'import_trace_import_id' => $import_id,
                        'import_trace_import_trace_type_id' => $this->input->post('import_trace_type_id'),
                        'import_trace_status_id' => 1, // $this->input->post('import_trace_status_id'),
                        'import_trace_action_type_id' =>  $this->input->post('import_trace_action_type_id'),
                        'import_trace_note' => $this->input->post('import_trace_note'),

                        'import_trace_sent_date' =>  date('Y-m-d H:i:s'),
//                    'import_trace_received_date' =>  date('Y-m-d'),
                        'import_trace_receiver_department_id' => $this->UserModel->user_department_id(),
                        'import_trace_sender_department_id' => $this->UserModel->user_department_id(),

                    ];

                }else{
                    $trace_data = [
                        'import_trace_import_id' => $import_id,
                        'import_trace_import_trace_type_id' => $this->input->post('import_trace_type_id'),
                        'import_trace_status_id' => 1, // $this->input->post('import_trace_status_id'),
                        'import_trace_action_type_id' =>  $this->input->post('import_trace_action_type_id'),
                        'import_trace_note' => $this->input->post('import_trace_note'),

                        'import_trace_sent_date' =>  date('Y-m-d H:i:s'),
//                    'import_trace_received_date' => $this->input->post('import_trace_received_date'),
                        'import_trace_sender_department_id' => $this->UserModel->user_department_id(),
                        'import_trace_receiver_department_id' => $this->input->post('import_trace_receiver_department_id'),
                    ];
                }



                // Handle sender user ID
                if ($this->input->post('import_trace_sender_user_id')) {
                    $trace_data['import_trace_sender_user_id'] = $this->input->post('import_trace_sender_user_id');
                } else {
                    $trace_data['import_trace_sender_user_id'] = $this->UserModel->user_id();
                }

                // Handle receiver user ID
                if ($this->input->post('import_trace_receiver_user_id')) {
                    $trace_data['import_trace_receiver_user_id'] = $this->input->post('import_trace_receiver_user_id');
                } else if($isSelf) {
                    $trace_data['import_trace_receiver_user_id'] = $this->UserModel->user_id();
                }

                // Handle trace attachments if any
                if (!empty($_FILES['attachments']['name'][0])) {
                    $attachments = [];
                    $temp_attachments = [];  // temp storage
                    $upload_errors = [];
                    $files = $_FILES['attachments'];
                    $config['upload_path'] = './assets/uploads/attachments/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf|doc|docx|xls|xlsx';
                    $config['max_size']      = 102400; // 100MB in KB

                    // Make sure upload directory exists
                    if (!is_dir($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, TRUE);
                    }

                    $this->load->library('upload', $config);

                    for ($i = 0; $i < count($files['name']); $i++) {
                        $_FILES['file']['name'] = $files['name'][$i];
                        $_FILES['file']['type'] = $files['type'][$i];
                        $_FILES['file']['tmp_name'] = $files['tmp_name'][$i];
                        $_FILES['file']['error'] = $files['error'][$i];
                        $_FILES['file']['size'] = $files['size'][$i];

                        $config['file_name'] = 'Trace_' . time() . '_' . $files['name'][$i];
                        $this->upload->initialize($config);

                        if ($this->upload->do_upload('file')) {
                            $upload_data = $this->upload->data();
//                        $attachments[] = [
//                            'filename' => $upload_data['file_name'],
//                            'original_name' => $files['name'][$i],
//                            'file_path' => 'attachments/' . $upload_data['file_name']
//                        ];

                            $temp_attachments[] = [
                                'filename' => $upload_data['file_name'],
                                'original_name' => $files['name'][$i],
                                'file_path' => 'attachments/' . $upload_data['file_name'],
                                'full_path' => $upload_data['full_path'], // for cleanup
                            ];
                        }
                        else {
                            $upload_errors[] = [
                                'file' => $files['name'][$i],
                                'error' => $this->upload->display_errors('', '')
                            ];
                        }
                    }

//                if (!empty($attachments)) {
//                    $trace_data['import_trace_attachment'] = $attachments;
//                }

                    // If any errors occurred, delete uploaded files and throw
                    if (!empty($upload_errors)) {

                        foreach ($temp_attachments as $temp) {
                            if (file_exists($temp['full_path'])) {
                                unlink($temp['full_path']); // rollback
                            }
                        }
                        throw new Exception('Error in File '. $upload_errors[0]['file']. ': ' . $upload_errors[0]['error']); // or handle all errors

//                        $this->session->set_flashdata('error', 'Error in File '. $upload_errors[0]['file']. ': ' . $upload_errors[0]['error']);
//                        return json_encode(['success' => false, 'message' => 'Error in File '. $upload_errors[0]['file']. ': ' . $upload_errors[0]['error']]);
                    }

                    // All successful
                    if (!empty($temp_attachments)) {
                        $attachments = $temp_attachments;
                        $trace_data['import_trace_attachment'] = $attachments;
                    }

                }


                $trace_id = $this->ImportTraceModel->AddTrace($trace_data);

                if ($trace_id) {
                    //$this->session->set_flashdata('success', 'Trace record added successfully');
                    return  $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode(['success' => true,   'status' => 'true', 'message' => 'Trace added successfully']));
                } else {
                    // $this->session->set_flashdata('error', 'Failed to add trace record');
                    throw new Exception('Failed to add trace record');
                }


            }
            catch (Exception $e) {

                $this->db->trans_rollback();
                $this->session->set_flashdata('error', $e->getMessage());

                return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode([
                        'status' => 'false',
                        'message' => $e->getMessage()
                    ]));

            }
        } else {
//            $this->session->set_flashdata('error', validation_errors());
//            return json_encode(['success' => false, 'message' => 'Validation errors occurred']);



            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'false',
                    'message' => 'Validation errors occurred',
                    'errors' => $this->form_validation->error_array()
                ]));

        }

        return json_encode(['success' => true, 'message' => 'Trace record added successfully']);



//        if($isSelf) {
//
//            // return json_encode(['success' => true, 'message' => 'Trace record added successfully']);
//            redirect('Import/Details/' . $import_id);
//        } else {
//            redirect('Import/Details/' . $import_id);
//        }
    }

    public function AjaxAddOutTrace()
    {

        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            redirect('Import');
        }

        $import_id = $this->input->post('import_id');

        if (!$import_id) {
            $this->session->set_flashdata('error', 'Invalid request');
            redirect('Import');
        }

        $this->form_validation->set_rules('import_trace_type_id', 'Trace Type', 'required');
        $this->form_validation->set_rules('import_trace_status_id', 'Status', 'required');
//        $this->form_validation->set_rules('out_book_code', 'Out Code', 'required');
        $this->form_validation->set_rules('out_book_subject', 'Book Subject', 'required');
        $this->form_validation->set_rules('out_from_department_id', 'To Department', 'required');
        $this->form_validation->set_rules('out_to_department_id', 'From Department', 'required');
        if ($this->form_validation->run() == TRUE) {

            $out_data = [
                'out_book_code' => date('y').  date('m') ,
                'out_book_number' => $this->input->post('out_book_number'),
                'out_book_issue_date' => $this->input->post('out_book_issue_date'),
                'out_book_subject' => $this->input->post('out_book_subject'),
                'out_to_department_id' => $this->input->post('out_to_department_id'),
                'out_from_department_id' => $this->input->post('out_from_department_id'),
                //'out_book_entry_date' => $this->input->post('out_book_entry_date'),
                //'out_status_id' => $this->input->post('out_status_id'),
                'out_signed_by' => $this->input->post('out_signed_by'),
                'out_book_category_id' => $this->input->post('out_book_category_id'),
                'out_book_language_id' => $this->input->post('out_book_language_id'),
                'out_book_body' => $this->input->post('out_book_body'),
                'out_is_answer' => $this->input->post('out_is_answer') ? 1 : 0,
                'out_note' => $this->input->post('out_note'),
                'out_book_copy_list' => $this->input->post('out_book_copy_list'),
                'elec_dep_reference' => $this->input->post('elec_dep_reference'),
                'import_id' => $import_id,
            ];

            $this->db->trans_begin();

            try{
                // Handle uploads if any
                if (!empty($_FILES['attachments']['name'][0])) {
                    $attachments = [];
                    $temp_attachments = [];  // temp storage
                    $upload_errors = [];
                    $files = $_FILES['attachments'];
                    $config['upload_path'] = './assets/uploads/attachments/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf|doc|docx|xls|xlsx';
                    $config['max_size']      = 102400; // 100MB in KB

                    // Make sure upload directory exists
                    if (!is_dir($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, TRUE);
                    }

                    $this->load->library('upload', $config);

                    for ($i = 0; $i < count($files['name']); $i++) {
                        $_FILES['file']['name'] = $files['name'][$i];
                        $_FILES['file']['type'] = $files['type'][$i];
                        $_FILES['file']['tmp_name'] = $files['tmp_name'][$i];
                        $_FILES['file']['error'] = $files['error'][$i];
                        $_FILES['file']['size'] = $files['size'][$i];

                        $config['file_name'] = 'Out_' . time() . '_' . $files['name'][$i];
                        $this->upload->initialize($config);

                        if ($this->upload->do_upload('file')) {
                            $upload_data = $this->upload->data();
//                            $attachments[] = [
//                                'filename' => $upload_data['file_name'],
//                                'original_name' => $files['name'][$i],
//                                'file_path' => 'attachments/' . $upload_data['file_name']
//                            ];
                            $temp_attachments[] = [
                                'filename' => $upload_data['file_name'],
                                'original_name' => $files['name'][$i],
                                'file_path' => 'attachments/' . $upload_data['file_name'],
                                'full_path' => $upload_data['full_path'], // for cleanup
                            ];

                        }
                        else {
                            $upload_errors[] = [
                                'file' => $files['name'][$i],
                                'error' => $this->upload->display_errors('', '')
                            ];
                        }
                    }

//                    if (!empty($attachments)) {
//                        $out_data['out_attachment'] = $attachments;
//                    }
                    // If any errors occurred, delete uploaded files and throw
                    if (!empty($upload_errors)) {

                        foreach ($temp_attachments as $temp) {
                            if (file_exists($temp['full_path'])) {
                                unlink($temp['full_path']); // rollback
                            }
                        }
                        throw new Exception('Error in File '. $upload_errors[0]['file']. ': ' . $upload_errors[0]['error']); // or handle all errors
                    }

                    // All successful
                    if (!empty($temp_attachments)) {
                        $attachments = $temp_attachments;
                        $out_data['out_attachment'] = $attachments;
                    }
                }

                $book_issue_date = $out_data['out_book_issue_date'];
                $year = date('Y', strtotime($book_issue_date));
                $isBookNumberExist = $this->OutModel->isBookNumberExistsInYear($out_data['out_book_number'], $year);

                if($isBookNumberExist) {
                    //$this->session->set_flashdata('error', 'Book number already exists in the current year.');
                    throw new Exception('Book number already exists in the current year');
                }else{
                    $out_id =  $this->OutModel->AddOut($out_data);

                    if ($out_id) {
                        $trace_data = [
                            'import_trace_import_id' => $import_id,
                            'import_trace_import_trace_type_id' => $this->input->post('import_trace_type_id'),
                            'import_trace_status_id' => (int) $this->input->post('import_trace_status_id'),
                            'import_trace_action_type_id' => '1',
                            'import_trace_note' => '',
                            // 'import_trace_note' => $this->input->post('import_trace_note'),
                            'import_trace_sent_date' =>  date('Y-m-d H:i:s'),
//                        'import_trace_received_date' =>  date('Y-m-d'),
                            'import_trace_receiver_department_id' => $this->UserModel->user_department_id(),
                            'import_trace_sender_department_id' => $this->UserModel->user_department_id(),

                            'import_trace_receiver_user_id' =>  $this->UserModel->user_id(),
                            // 'out_id' => $out_id,
                        ];



                        // Handle sender user ID
                        if ($this->input->post('import_trace_sender_user_id')) {
                            $trace_data['import_trace_sender_user_id'] = $this->input->post('import_trace_sender_user_id');
                        } else {
                            $trace_data['import_trace_sender_user_id'] = $this->UserModel->user_id();
                        }

                        $trace_id = $this->ImportTraceModel->AddTrace($trace_data);

                        if ($trace_id) {
                            $this->db->trans_commit();
                            //  $this->session->set_flashdata('success', 'Trace record added successfully');
                            return  $this->output
                                ->set_content_type('application/json')
                                ->set_output(json_encode(['success' => true,   'status' => 'true', 'message' => 'Out Document and Trace added successfully']));
                        } else {
                            $this->db->trans_rollback();
                            return  $this->output
                                ->set_content_type('application/json')
                                ->set_output(json_encode(['success' => false,  'status' => 'false', 'message' => 'Failed to add trace record']));


                        }

                    } else {
                        //    $this->session->set_flashdata('error', 'Failed to add out document');
                        $this->db->trans_rollback();
                        return  $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode(['success' => false,  'status' => 'false', 'message' => 'Failed to add out document']));

                    }
                }
            }
            catch (Exception $e) {

                $this->db->trans_rollback();
                $this->session->set_flashdata('error', $e->getMessage());

                return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode([
                        'status' => 'false',
                        'message' => $e->getMessage()
                    ]));

            }




        } else {

            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'false',
                    'message' => 'Failed to add import document',
                    'errors' => $this->form_validation->error_array()
                ]));

        }

        return json_encode(['success' => true, 'message' => 'Trace record added successfully']);


    }


    public function GetTraceDetails($trace_id)
    {
        $trace = $this->ImportTraceModel->GetTraceDetails($trace_id);

        if (!$trace) {
            echo 'Trace record not found';
            return;
        }

        $data['trace'] = $trace;
        $this->load->view('Admin2/Import/TraceDetails', $data);
    }

    public function DeleteTrace()
    {
        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        $trace_id = $this->input->post('trace_id');

        if (!$trace_id) {
            echo json_encode(['success' => false, 'message' => 'Invalid trace ID']);
            return;
        }

        // Check permission
        if (!$this->Permission->CheckPermission('import_trace_edit')) {
            echo json_encode(['success' => false, 'message' => 'Permission denied']);
            return;
        }

        // Get trace details to get import_id for redirection
        $trace = $this->ImportTraceModel->GetTraceDetails($trace_id);

        if (!$trace) {
            echo json_encode(['success' => false, 'message' => 'Trace record not found']);
            return;
        }

        $result = $this->ImportTraceModel->DeleteTrace($trace_id);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Trace record deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete trace record']);
        }
    }

    /**
     * Marks a trace as read via AJAX
     * Updates the import_trace_is_read status to 1 (read)
     */
    public function AjaxMarkTraceAsRead()
    {
        // Check if AJAX request
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        // Get trace ID from POST data
        $trace_id = $this->input->post('trace_id');

        // Validate trace ID
        if (!$trace_id || !is_numeric($trace_id)) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Invalid trace ID']));
            return;
        }



        // Update the trace status
        $update_data = [
            'import_trace_read_date' => date('Y-m-d H:i:s'),
            'import_trace_read_user_id' => $this->UserModel->user_id(),
            'import_trace_status_id' => 4,
        ];

        $result = $this->ImportTraceModel->UpdateTrace($trace_id, $update_data);

        // Send response
        if ($result) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => true]));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Failed to update trace status']));
        }
    }
    public function AjaxMarkTraceAsUnread()
    {
        // Check if AJAX request
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        // Get trace ID from POST data
        $trace_id = $this->input->post('trace_id');

        // Validate trace ID
        if (!$trace_id || !is_numeric($trace_id)) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Invalid trace ID']));
            return;
        }

        // Load the required model
        $this->load->model('ImportTraceModel');

        // Update the trace status
        $update_data = [
            'import_trace_read_date' => null,
            'import_trace_read_user_id' => $this->UserModel->user_id(),
            'import_trace_status_id' => 1, // Reset status to "New"
        ];

        $result = $this->ImportTraceModel->UpdateTrace($trace_id, $update_data);

        // Send response
        if ($result) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => true]));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Failed to update trace status']));
        }
    }

    public function AjaxAssignTraceToCurrentUser()
    {
        // Check if AJAX request
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        // Get trace ID from POST data
        $trace_id = $this->input->post('trace_id');

        // Validate trace ID
        if (!$trace_id || !is_numeric($trace_id)) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Invalid trace ID']));
            return;
        }

        // Load the required model
        $this->load->model('ImportTraceModel');

        // Update the trace status
        $update_data = [
            'import_trace_receiver_user_id' => $this->UserModel->user_id(),
        ];

        $result = $this->ImportTraceModel->UpdateTrace($trace_id, $update_data);

        // Send response
        if ($result) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => true]));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Failed to update trace status']));
        }
    }

    public function AjaxAddAnswer()
    {

        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            redirect('Import/List');
        }

        $import_id = $this->input->post('import_id');

        if (!$import_id) {
            $this->session->set_flashdata('error', 'Invalid request');
            redirect('Import/List');
        }

        $this->form_validation->set_rules('answer_out_book_number', 'Book Number', 'required');
        $this->form_validation->set_rules('answer_out_book_date', 'Book Date', 'required');
        //$this->form_validation->set_rules('answer_out_to_department_id', 'Sender Department', 'required');


        if ($this->form_validation->run() == TRUE) {

            $out_book_number = $this->input->post('answer_out_book_number');
            $out_book_date = $this->input->post('answer_out_book_date');
            $out_from_department_id = $this->input->post('answer_out_to_department_id');
            $out = $this->OutModel->GetOUtRelatedToAnswer($out_book_number, $out_book_date);
            $out_id = $out ? $out['id'] : null;
            $answer_id = $this->ImportModel->AddImportAnswer($import_id, $out_id, $out_book_number, $out_book_date, $out_from_department_id);

            if ($answer_id) {
                $this->session->set_flashdata('success', 'Import Answer record added successfully');

            } else {
                $this->session->set_flashdata('error', 'Failed to add import answer record');
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
        }
        redirect('Import/Edit/' . $import_id);

    }


    public function AjaxDeleteAnswer()
    {
        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        $answer_id = $this->input->post('answer_id');

        if (!$answer_id) {
            echo json_encode(['success' => false, 'message' => 'Invalid answer ID']);
            return;
        }

        // Check permission
//        if (!$this->Permission->CheckPermission('import_edit')) {
//            echo json_encode(['success' => false, 'message' => 'Permission denied']);
//            return;
//        }

        // Get trace details to get import_id for redirection
        $answer = $this->ImportModel->GetAnswerDetails($answer_id);

        if (!$answer ) {
            echo json_encode(['success' => false, 'message' => 'Answer record not found']);
            return;
        }

        $result = $this->ImportModel->DeleteAnswer($answer_id);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Answer record deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete answer record']);
        }
    }


    public function AjaxCheckOutExistence()
    {
        $out_book_number = $this->input->post('out_book_number');
        $out_book_date = $this->input->post('out_book_date');
        $out_from_department_id = $this->input->post('out_from_department_id');
        if ($out_book_number && $out_book_date && $out_from_department_id) {
            $out = $this->OutModel->GetOUtRelatedToAnswer($out_book_number, $out_book_date, $out_from_department_id);

            if ($out) {
                echo json_encode(['exists' => true,'out_subject' => $out['out_book_subject'],  'message' => 'Out document exists']);
                return;
            } else {
                echo json_encode(['exists' => false, 'message' => 'Out document does not exist']);
                return;
            }
        } else {
            echo json_encode(['exists' => false, 'message' => 'Invalid input']);
            return;
        }
    }
    public function AjaxGetRemoteImportData()
    {
        $from_department_id = $this->input->post('from_department_id');
        $book_number = $this->input->post('book_number');
        $book_date = $this->input->post('book_date');
//        var_dump($this->input->post());
//        die();
        if ($from_department_id && $book_number && $book_date) {

            // get branch_id for the from_department_id
            $sql = "SELECT branch_id FROM department WHERE id = ?";
            $branch_id = $this->db->query($sql, [$from_department_id])->row_array()['branch_id'];
            if (!$branch_id) {
                echo json_encode(['exists' => false, 'message' => 'Invalid department! This Department Has no branch']);
                return;
            }




            $out = $this->OutModel->GetRemoteOutDetails($branch_id, null, $book_number, $book_date, $from_department_id);

            if ($out) {
                echo json_encode(['exists' => true,'out_info' => $out, 'branch_id' => $branch_id, 'message' => 'Out document exists']);
                return;
            } else {
                echo json_encode(['exists' => false, 'message' => 'Out document does not exist']);
                return;
            }
        } else {
            echo json_encode(['exists' => false, 'message' => 'Invalid input']);
            return;
        }
    }

    public function SpecialForm($id)
    {
        $data['special_form'] = $this->ImportModel->GetSpecialFormDetails($id);

        $data['import'] = $this->ImportModel->GetImportDetails( $data['special_form']['import_id'], false);

        return  $this->load->view('Admin2/SpecialForm', $data);
    }



} 