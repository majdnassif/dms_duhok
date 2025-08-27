<?php

class Out extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('OutModel');
        $this->load->model('ImportModel');
        $this->load->model('ImportTraceModel');
        $this->load->model('UserModel');
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
        $data['page_title'] = 'Out Documents';
        $data['page_card_title'] = 'Out Documents';
        $filters = array();

        // Filters
        $filters['out_book_code'] = ['type'=>'text', 'name'=>'out_book_code', 'id'=>'filter_out_book_code', 'label'=>'Code'];
        $filters['out_book_number'] = ['type'=>'text', 'name'=>'out_book_number', 'id'=>'filter_out_book_number', 'label'=>'Book Number'];
        $filters['out_book_subject'] = ['type'=>'text', 'name'=>'out_book_subject', 'id'=>'filter_out_book_subject', 'label'=>'Subject'];
        // $filters['import_from_department'] = ['type'=>'tree', 'name'=>'import_from_department', 'id'=>'filter_import_from_department', 'label'=>'From Department', 'onclick'=>"OpenTree('department','filter_import_from_department','filter_import_from_department_id','1')"];


        $filters['out_from_department'] = ['type'=>'tree', 'name'=>'out_from_department', 'id'=>'filter_out_from_department', 'label'=>'From Department', 'onclick'=>"OpenTree('department','filter_out_from_department','filter_out_from_department_id','1', 'extra-section', 1)"];
        $filters['out_from_department_id'] = ['type'=>'hidden', 'name'=>'out_from_department_id', 'id'=>'filter_out_from_department_id', 'label'=>'import_from_department_id', 'value'=>''];


        $filters['out_to_department'] = ['type'=>'tree', 'name'=>'out_to_department', 'id'=>'filter_out_to_department', 'label'=>'To Department', 'onclick'=>"OpenTree('department','filter_out_to_department','filter_out_to_department_id','1')"];
        $filters['out_to_department_id'] = ['type'=>'hidden', 'name'=>'out_to_department_id', 'id'=>'filter_out_to_department_id', 'label'=>'out_to_department_id', 'value'=>''];


        $filters['out_body'] = ['type'=>'text', 'name'=>'out_body', 'id'=>'filter_out_body', 'label'=>'Body'];


        $filters['import_number'] = ['type'=>'text', 'name'=>'import_number', 'id'=>'filter_import_number', 'label'=>'Import Number'];

        $filters['answer_import_number'] = ['type'=>'text', 'name'=>'answer_import_number', 'id'=>'filter_answer_import_number', 'label'=>'Answer Import Number'];


        $sql_signed_by = "select import_signed_by as id, import_signed_by as name from (
                            SELECT  distinct import_signed_by FROM `import`
                            ) signed_by_list";
        $assigned_by_list = $this->db->query($sql_signed_by)->result_array();
        //  var_dump($assigned_by_list);
        $filters['out_signed_by'] = ['type'=>'select', 'name'=>'out_signed_by', 'id'=>'filter_out_signed_by', 'label'=>'Signed', 'list'=> $assigned_by_list, 'list_name' => 'name', 'list_id' =>'id', 'translate' => false];



        $filters['out_book_date'] = ['type'=>'custom_html' , 'content'=>'
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
                                                    <input type="date" id="filter_out_book_date_from" name="out_book_date_from"  class="form-control date-input">
                                                  </div>
                                             
                                                   <div class="col-auto">
                                                    <label class="custom-label"> ' . $this->Dictionary->GetKeyword("To") . '</label>
                                                  </div>
                                                  <div class="col-auto">
                                                    <input type="date" id="filter_out_book_date_to"  name="out_book_date_to" class="form-control date-input">
                                                  </div>
                                                  
                                                  <div class="col-auto">
                                                    <label class="custom-label" for="today"> ' . $this->Dictionary->GetKeyword("Today") . '</label>
                                                    <input class="form-check-input today-checkbox" type="checkbox" id="filter_out_book_date_today" name="out_book_date_today"  >
                                                  </div>
                                                
                                    
                                                </div>
                                              </div>
                                         </div>',
            'inputs' => [
                ['id' => 'filter_out_book_date_from', 'name' => 'out_book_date_from'],
                ['id' => 'filter_out_book_date_to', 'name' => 'out_book_date_to'],
                ['id' => 'filter_out_book_date_today', 'name' => 'out_book_date_today', 'type' => 'checkbox']
            ]

        ];



        $filters['out_created_at'] = ['type'=>'custom_html' , 'content'=>'
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
                                                    <input type="date" id="filter_out_register_date_from" name="import_out_date_from"  class="form-control date-input">
                                                  </div>

                                                   <div class="col-auto">
                                                    <label class="custom-label"> ' . $this->Dictionary->GetKeyword("To") . '</label>
                                                  </div>
                                                  <div class="col-auto">
                                                    <input type="date" id="filter_out_register_date_to"  name="import_out_date_to" class="form-control date-input">
                                                  </div>

                                                  <div class="col-auto">
                                                    <label class="custom-label" for="today"> ' . $this->Dictionary->GetKeyword("Today") . '</label>
                                                    <input class="form-check-input today-checkbox" type="checkbox" id="filter_out_register_date_today" name="out_register_date_today"  >
                                                  </div>


                                                </div>
                                              </div>
                                         </div>',
            'inputs' => [
                ['id' => 'filter_out_register_date_from', 'name' => 'out_register_date_from'],
                ['id' => 'filter_out_register_date_to', 'name' => 'out_register_date_to'],
                ['id' => 'filter_out_register_date_today', 'name' => 'out_register_date_today', 'type' => 'checkbox']
            ]

        ];




        $cols[0] = 'out_book_code';
        $cols[1] = 'out_book_number';
        $cols[2] = 'out_book_issue_date';
        $cols[3] = 'out_book_subject';
        $cols[4] = 'out_from_department';
        $cols[5] = 'Actions';

        $data['DataTable'] = DataTableBuilder('OutList', base_url("Out/AjaxList"), $cols, $filters);
        $this->_temp_output('Out/List', $data);
    }

    public function AjaxList()
    {
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $order = $this->input->post("order");

        $cols[0] = 'out_book_code';
        $cols[1] = 'out_book_number';
        $cols[2] = 'out_book_issue_date';
        $cols[3] = 'out_book_subject';
        $cols[4] = 'out_from_department';
        $cols[5] = 'id';

        if(isset($order[0]['column'])){
            $order = ' ORDER BY ' . $cols[$order[0]['column']] . ' ' . $order[0]['dir'];
        }

        $filter = "";

        // out_code
        $out_code = $this->input->post("out_book_code");
        if ($out_code && $out_code != "") {
            $filter .= " AND   concat(`out_book_code`, o.`id`) = '" . $this->db->escape_str($out_code) . "'";
        }

        // out_book_number
        $out_book_number = $this->input->post("out_book_number");
        if ($out_book_number && $out_book_number != "") {
            $filter .= " AND `out_book_number` = '" . $this->db->escape_str($out_book_number) . "'";
        }

        // out_from_department
        $out_from_department = $this->input->post("out_from_department_id");
        if ($out_from_department && $out_from_department != "") {
            $filter .= " AND `out_from_department_id` = '" . $this->db->escape_str($out_from_department) . "'";
        }

        $out_to_department = $this->input->post("out_to_department_id");
        if ($out_to_department && $out_to_department != "") {
            $filter .= " AND `out_to_department_id` = '" . $this->db->escape_str($out_to_department) . "'";
        }

        // out_book_subject
        $out_book_subject = $this->input->post("out_book_subject");
        if ($out_book_subject && $out_book_subject != "") {
            $filter .= " AND `out_book_subject` LIKE '%" . $this->db->escape_str($out_book_subject) . "%'";
        }


        $out_body = $this->input->post("out_body");
        if ($out_body && $out_body != "") {
            $filter .= " AND `out_book_body` LIKE '%" . $this->db->escape_str($out_body) . "%'";
        }


        $import_number = $this->input->post("import_number");
        if ($import_number && $import_number != "") {
            $import_sql = "SELECT import_id FROM `import`
                        where import_book_number = $import_number
                        ";
            $imports_data = $this->db->query($import_sql)->result_array();

            if ($imports_data) {
                $import_ids = array_column($imports_data, 'import_id');
                if (!empty($import_ids)) {
                    $filter .= " AND `import_id` IN (" . implode(',', $import_ids) . ")";
                }
            }

        }

        $answer_import_number = $this->input->post("answer_import_number");
        if ($answer_import_number && $answer_import_number != "") {
            $out_sql = "SELECT out_id FROM `out_answers`
                        where import_book_number = $answer_import_number
                        ";
            $answers_imports_data = $this->db->query($out_sql)->result_array();

            if ($answers_imports_data) {
                $answers_out_ids = array_column($answers_imports_data, 'out_id');
                if (!empty($answers_out_ids)) {
                    $filter .= " AND id IN (" . implode(',', $answers_out_ids) . ")";
                }
            }

        }

        $out_signed_by = $this->input->post("out_signed_by");
        if ($out_signed_by && $out_signed_by != "") {
            $filter .= " AND `out_signed_by` = '" . $this->db->escape_str($out_signed_by) . "'";
        }


        $out_book_date_from = $this->input->post('out_book_date_from');
        if ($out_book_date_from && $out_book_date_from != "") {
            $filter .= " AND `out_book_issue_date` >= '" . $this->db->escape_str($out_book_date_from) . "'";
        }
        $out_book_date_to = $this->input->post('out_book_date_to');
        if ($out_book_date_to && $out_book_date_to != "") {
            $filter .= " AND `out_book_issue_date` <= '" . $this->db->escape_str($out_book_date_to) . "'";
        }
        $out_book_date_today = $this->input->post('out_book_date_today');
        if ($out_book_date_today && $out_book_date_today != "false" ) {
            $today = date('Y-m-d');
            $filter .= " AND date(`out_book_issue_date`) = '" . $today . "'";
        }



        $out_register_date_from = $this->input->post('out_register_date_from');
        if ($out_register_date_from && $out_register_date_from != "") {
            $filter .= " AND `out_created_at` >= '" . $this->db->escape_str($out_register_date_from) . "'";
        }
        $out_register_date_to = $this->input->post('out_register_date_to');
        if ($out_register_date_to && $out_register_date_to != "") {
            $filter .= " AND `out_created_at` <= '" . $this->db->escape_str($out_register_date_to) . "'";
        }
        $out_register_date_today = $this->input->post('out_register_date_today');
        if ($out_register_date_today && $out_register_date_today != "false" ) {
            $today = date('Y-m-d');
            $filter .= " AND date(`out_created_at`) = '" . $today . "'";
        }


        $import_docs = $this->OutModel->GetOutList($filter, $start, $length, $order);
        $import_docs_data = $import_docs['data'];
        $num_rows = $import_docs['count'];
        $ajax = array();

        $canEdit =  $this->Permission->CheckPermissionOperation('out_edit');
        $canDelete =  $this->Permission->CheckPermissionOperation('out_delete');


        foreach($import_docs_data as $doc) {
            $actions = '<div class="btn-group btn-group-sm" dir="ltr">';


            // View Details
            if($doc['out_is_deleted'] != 1) {
                $actions .= '<a class="btn btn-sm btn-info" target="_blank" href="' . base_url("Out/Details/" . $doc['id']) . '" role="button"><i class="fa fa-eye"></i></a>';
            }

            if($canEdit && $doc['out_is_deleted'] != 1){
                // Edit
                $actions .= '<a class="btn btn-sm btn-primary" target="_blank" href="' . base_url("Out/Edit/" . $doc['id']) . '" role="button"><i class="fa fa-edit"></i></a>';
            }

            if($canDelete){

                if($doc['out_is_deleted'] == 1){
                    $actions .= '<a class="btn btn-sm btn-warning" onclick="RestoreOut(' . $doc['id'] . ', \'' . $doc['out_book_code'] . '\')" role="button"><i class="fa fa-undo"></i></a>';
                } else {
                    $actions .= '<a class="btn btn-sm btn-danger" onclick="DeleteOut(' . $doc['id'] . ', \'' . $doc['out_book_code'] . '\')" role="button"><i class="fa fa-trash"></i></a>';
                }

                // Delete
            }


            $actions .= '</div>';

            $ajax[] = [
                'out_id' => $doc['id'],
                'out_book_code' => $doc['out_book_code'],
                'out_book_number' => $doc['out_book_number'],
                'out_book_issue_date' => date('Y-m-d', strtotime($doc['out_book_issue_date'])) ,

                'out_from_department' => $doc['out_from_department'],
                //  'out_to_department' => $doc['out_to_department'],
                'out_book_subject' => $doc['out_book_subject'],
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


    public function RemoteList($branch_id)
    {

        $remote_location = RemoteConnectionMapperHelper::getLocation( $branch_id);
        $remote_location_name = isset($remote_location['name']) ? $remote_location['name'] : '';
        $data['page_title'] = 'Out Documents - ' . $remote_location_name;
        $data['page_card_title'] = 'Out Documents';
        $filters = array();

        // Filters
        $filters['out_book_code'] = ['type'=>'text', 'name'=>'out_book_code', 'id'=>'filter_out_book_code', 'label'=>'Code'];
        $filters['out_book_number'] = ['type'=>'text', 'name'=>'out_book_number', 'id'=>'filter_out_book_number', 'label'=>'Book Number'];
        $filters['out_book_subject'] = ['type'=>'text', 'name'=>'out_book_subject', 'id'=>'filter_out_book_subject', 'label'=>'Subject'];
        // $filters['import_from_department'] = ['type'=>'tree', 'name'=>'import_from_department', 'id'=>'filter_import_from_department', 'label'=>'From Department', 'onclick'=>"OpenTree('department','filter_import_from_department','filter_import_from_department_id','1')"];
        $filters['out_from_department_id'] = ['type'=>'hidden', 'name'=>'out_from_department_id', 'id'=>'filter_out_from_department_id', 'label'=>'import_from_department_id', 'value'=>''];



        $filters['out_is_new'] = ['type'=>'custom_html' , 'content'=>'
                                           <div class="form-group col-xl-8 col-md-8 col-sm-12 col-xs-12">
                                          <label></label>
                                            <div class=" border-top pt-3">
                                                <div class=" align-items-center">                                              
                                                  <div class="col-auto">
                                                    <label class="custom-label" for="out_is_new"> ' . $this->Dictionary->GetKeyword("New") . '</label>
                                                    <input class="form-check-input today-checkbox" type="checkbox" id="filter_out_is_new" name="out_is_new" checked >
                                                  </div>                                  
                                                </div>
                                              </div>
                                         </div>',
            'inputs' => [
                ['id' => 'filter_out_is_new', 'name' => 'out_is_new', 'type' => 'checkbox']
            ]

        ];

        $cols[0] = 'out_book_code';
        $cols[1] = 'out_book_number';
        $cols[2] = 'out_book_issue_date';
        $cols[3] = 'out_book_subject';
        $cols[4] = 'out_from_department';
        $cols[5] = 'out_book_attached';
        $cols[6] = 'Actions';

        $data['DataTable'] = DataTableBuilder('OutListRemote', base_url("Out/AjaxRemoteListData/").$branch_id, $cols, $filters);
        $this->_temp_output('Out/RemoteList', $data);
    }

    public function AjaxRemoteListData($branch_id)
    {
        // $remote_code = urldecode($remote_code);

        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $order = $this->input->post("order");


        $cols[0] = 'out_book_code';
        $cols[1] = 'out_book_number';
        $cols[2] = 'out_book_issue_date';
        $cols[3] = 'out_book_subject';
        $cols[4] = 'out_from_department';
        $cols[5] = 'out_book_attached';
        $cols[6] = 'id';



        if(isset($order[0]['column'])){
            $order = ' ORDER BY ' . $cols[$order[0]['column']] . ' ' . $order[0]['dir'];
        }

        $filter = "";

        // out_code
        $out_code = $this->input->post("out_book_code");
        if ($out_code && $out_code != "") {
            $filter .= " AND  concat(o.out_book_code, o.id) = '" . $this->db->escape_str($out_code) . "'";
        }

        // out_book_number
        $out_book_number = $this->input->post("out_book_number");
        if ($out_book_number && $out_book_number != "") {
            $filter .= " AND `out_book_number` = '" . $this->db->escape_str($out_book_number) . "'";
        }

        // out_from_department
//        $out_from_department = $this->input->post("out_from_department_id");
//        if ($out_from_department && $out_from_department != "") {
//            $filter .= " AND `out_from_department_id` = '" . $this->db->escape_str($out_from_department) . "'";
//        }




        // out_book_subject
        $out_book_subject = $this->input->post("out_book_subject");
        if ($out_book_subject && $out_book_subject != "") {
            $filter .= " AND `out_book_subject` LIKE '%" . $this->db->escape_str($out_book_subject) . "%'";
        }

        $out_is_new = $this->input->post("out_is_new");

        if ($out_is_new && ($out_is_new == 'true'  || $out_is_new == 'false')) {


            $local_ids_query = $this->db->query("SELECT distinct remote_out_id FROM `import` where remote_branch_id = $branch_id ");
            $local_ids = array_column($local_ids_query->result_array(), 'remote_out_id');
            $not_in_ids = empty($local_ids) ? [0] : $local_ids;

            // Sanitize and convert to comma-separated list
            $not_in_ids_str = implode(',', array_map('intval', $not_in_ids));


            // Append the NOT IN condition to your remote SQL
            $condition_in = $out_is_new == 'true' ? "NOT IN " : "  IN ";
            $filter .= " AND o.id $condition_in ($not_in_ids_str) ";

        }

        $import_docs = $this->OutModel->GetOutListRemote($branch_id, $filter, $start, $length, $order);
        $import_docs_data = $import_docs['data'];
        $num_rows = $import_docs['count'];
        $ajax = array();

        $canImportTheRemoteOutAsImport =  $this->Permission->CheckPermissionOperation('import_add');


        foreach($import_docs_data as $doc) {

            $actions = '<div class="btn-group btn-group-sm" dir="ltr">';

            // convert to import
            if($canImportTheRemoteOutAsImport){
                $actions .= '<a  class="btn btn-sm btn-warning" target="_blank" href="' . base_url("Import/Add/" . $doc['id'] . "/". $branch_id) . '" role="button"><i class="fa fa-mail-forward"></i></a>';

            }

            $actions .= '</div>';

            $attached = '<div>';

            if (isset($doc['out_attachment']) && !empty($doc['out_attachment'])) {

                $out_attachments = json_decode($doc['out_attachment'], true);

                foreach ($out_attachments as $index => $attachment){
                    $filePath = $attachment['file_path'];
                    $proxyUrl = base_url("out/proxy_remote_file?path=" . urlencode($filePath) . "&branch=" . $branch_id );

                    $attached .= '<p><span>' . $attachment['original_name'] . '</span>
                                    <div class="attachment-actions">
                                        <a href="' . $proxyUrl . '" class="btn btn-sm btn-info" target="_blank">
                                            <i class="fa fa-file"></i>
                                        </a>
                                    </div>
                                 </p>';
                }
            }

            $attached .= '</div>';
            $ajax[] = [
                'out_id' => $doc['id'],
                'out_book_code' => $doc['out_book_code'],
                'out_book_number' => $doc['out_book_number'],
                'out_from_department' => $doc['out_from_department'],
                //  'out_to_department' => $doc['out_to_department'],
                'out_book_subject' => $doc['out_book_subject'],
                'out_book_attached' => $attached,
                'out_book_issue_date' => $doc['out_book_issue_date'],
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

    public function proxy_remote_file()
    {
        $file_path = $this->input->get('path', true);
        $branch = $this->input->get('branch', true);


        // Get remote URL for branch (your existing helper)
        $remote_location = RemoteConnectionMapperHelper::getLocation($branch);
        $remote_location_url = isset($remote_location['base_url']) ? $remote_location['base_url'] : '';

        $remote_url = rtrim($remote_location_url, '/') . '/' . ltrim($file_path, '/');


        $cookieData = json_encode([
            'USER_ID' => $this->session->userdata('user_login_data')['USER_ID'],
            'LOGIN' => $this->session->userdata('user_login_data')['login'],
            'timestamp' => time()
        ]);

        $crypt = new Crypt();
        $encryptedCookie = $crypt->MediaEncrypt($cookieData);

        $cookie = 'auth_token_remote=' . $encryptedCookie;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $remote_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

        curl_close($ch);

        if ($httpCode !== 200) {
            show_error("Failed to fetch file, HTTP code: $httpCode", $httpCode);
            return;
        }

        // Output file to browser with proper headers
        header('Content-Type: ' . $contentType);
        echo $response;
    }




    public function Add()
    {
        $data['page_title'] = 'Add New Out Document';
        $data['page_card_title'] = 'Out Document Details';

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            // $this->form_validation->set_rules('out_book_code', 'Import Code', 'required');
            $this->form_validation->set_rules('out_book_subject', 'Book Subject', 'required');
            $this->form_validation->set_rules('out_from_department_id', 'To Department', 'required');
            $this->form_validation->set_rules('out_to_department_id', 'From Department', 'required');

            if ($this->form_validation->run() == TRUE) {
                $out_data = [
                    'out_book_code' => date('y').  date('m') , // $this->input->post('out_book_code'),
                    'out_book_number' => $this->input->post('out_book_number'),
                    'out_book_issue_date' => $this->input->post('out_book_issue_date') ? $this->input->post('out_book_issue_date') : null,
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
                        throw new Exception('Book number already exists in the current year');
                    }else{
                        $out_id = $this->OutModel->AddOut($out_data);

                        if ($out_id) {
                            if($out_data['out_is_answer'] == 1) {
                                $answer_data_import_book_numbers_arr = $this->input->post('answer_import_book_number');
                                $answer_data_import_book_dates_arr = $this->input->post('answer_import_book_date');
                                $answer_data__import_from_department_ids_arr = $this->input->post('answer_import_from_department_id');
                                foreach ($answer_data_import_book_numbers_arr as $key => $value) {

                                    $import_book_number  = $value;
                                    $import_book_date  = $answer_data_import_book_dates_arr[$key];
                                    $import_from_department_id = $answer_data__import_from_department_ids_arr[$key];
                                    $import = $this->ImportModel->GetImportRelatedToAnswer($import_book_number, $import_book_date, $import_from_department_id);
                                    $import_id = $import ? $import['id'] : null;
                                    $this->OutModel->AddOutAnswer($out_id, $import_id, $import_book_number, $import_book_date, $import_from_department_id);

                                }
                            }

                            $this->db->trans_commit();

                            // Check if the transaction was successful
                            if ($this->db->trans_status() === FALSE) {
                                throw new Exception('Transaction failed');
                            }


                            return $this->output
                                ->set_content_type('application/json')
                                ->set_output(json_encode([
                                    'status' => 'true',
                                    'out_id' => $out_id
                                ]));
                        } else {
                            throw new Exception('Failed to add import document');
                        }
                    }
                }
                catch (Exception $e) {

                    $this->db->trans_rollback();

                    return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode([
                            'status' => 'false',
                            'message' => $e->getMessage()
                        ]));

                }

            }
            else{

                return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode([
                        'status' => 'false',
                        'message' => 'Failed to add out document',
                        'errors' => $this->form_validation->error_array()
                    ]));
            }
        }

        $data['statuses'] = $this->OutModel->GetStatuses();
        $data['users'] = $this->UserModel->GetActiveUsers();

        $data['branches'] = $this->db->query("SELECT id, name FROM system_branches where is_current = 0")->result_array();

        $data['current_department'] = $this->db->query("SELECT id, fullpath FROM department where is_current = 1")->row();


        $this->_temp_output('Out/Add', $data);
    }



    public function Details($out_id)
    {
        $data['page_title'] = 'Out Document Details';
        $data['out'] = $this->OutModel->GetOutDetails($out_id, false);

        if (!$data['out']) {
            $this->session->set_flashdata('error', 'Out document not found');
            redirect('Out');
        }
        $data['import'] = null;
        if($data['out']['import_id']){
            $import_id = $data['out']['import_id'];
            $data['import'] = $this->ImportModel->GetImportDetails($import_id);
            $data['last_trace'] = $this->ImportTraceModel->GetLastImportLastTrace($import_id);
        }

        // Get all active users for user dropdowns
        $data['active_users'] = $this->UserModel->GetActiveUsers();
        $data['out_answers'] = $this->OutModel->GetAnswers($out_id);

        $this->_temp_output('Out/Details', $data);
    }

    public function Edit($out_id)
    {
        $data['page_title'] = 'Edit Out Document';
        $data['out'] = $this->OutModel->GetOutDetails($out_id, false);
        $data['out_answers'] = $this->OutModel->GetAnswers($out_id);
        if (!$data['out']) {
            $this->session->set_flashdata('error', 'Out document not found');
            redirect('Out');
        }

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            // $this->form_validation->set_rules('out_book_code', 'Import Code', 'required');
            $this->form_validation->set_rules('out_book_subject', 'Book Subject', 'required');
            $this->form_validation->set_rules('out_from_department_id', 'To Department', 'required');
            $this->form_validation->set_rules('out_to_department_id', 'From Department', 'required');

            if ($this->form_validation->run() == TRUE) {
                $out_data = [
                    // 'out_book_code' => $this->input->post('out_book_code'),
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
                ];

                $book_issue_date = $out_data['out_book_issue_date'];
                $year = date('Y', strtotime($book_issue_date));
                $isBookNumberExist = $this->OutModel->isBookNumberExistsInYear($out_data['out_book_number'], $year, $out_id);
                if($isBookNumberExist) {
                    $data['error'] = 'Book number already exists in the current year';
                }
                else{
                    // Handle uploads if any
                    if (!empty($_FILES['attachments']['name'][0])) {
                        $attachments = isset($data['out']['out_attachment']) ? $data['out']['out_attachment'] : [];
                        $temp_attachments = []; // store new uploads temporarily
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

                            $config['file_name'] = 'Out_' .time() . '_' . $files['name'][$i];
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

//                        if (!empty($attachments)) {
//                            $out_data['out_attachment'] = $attachments;
//                        }

                        // If any errors occurred, rollback all uploaded files and throw error
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

                            $out_data['out_attachment'] = $attachments;
                        }

                    }
                    if(empty($data['error'])) {

                        $update = $this->OutModel->UpdateOut($out_id, $out_data);

                        if ($update) {

                            if($out_data['out_is_answer']){
                                $this->OutModel->restoreAnswers($out_id);
                            }else{
                                $this->OutModel->SoftDeleteAnswers($out_id);
                            }
                            $this->session->set_flashdata('success', 'Out document updated successfully');
                            redirect('Out/Details/' . $out_id);
                        } else {
                            $data['error'] = 'Failed to update import document';
                        }
                    }



                }

            }
        }

        $data['branches'] = $this->db->query("SELECT id, name FROM system_branches where is_current = 0")->result_array();

        $this->_temp_output('Out/Edit', $data);
    }

    public function AjaxDeleteAttachment()
    {
        $out_id = $this->input->post('out_id');
        $file_index = $this->input->post('file_index');

        $out = $this->OutModel->GetOutDetails($out_id);

        if (!$out || empty($out['out_attachment'])) {
            echo json_encode(['status' => 'error', 'message' => 'Out document or attachment not found']);
            return;
        }

        $attachments = $out['out_attachment'];

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

        $update = $this->OutModel->UpdateOut($out_id, ['out_attachment' => $attachments]);

        if ($update) {
            echo json_encode(['status' => 'success', 'message' => 'Attachment deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update out document']);
        }
    }

    public function AjaxDelete()
    {
        $out_id = $this->input->post('out_id');

        $out = $this->OutModel->GetOutDetails($out_id);

        if (!$out) {
            echo json_encode(['status' => 'error', 'message' => 'Out document not found']);
            return;
        }

        // Delete attachments if any
//        if (!empty($out['out_attachment'])) {
//            foreach ($out['out_attachment'] as $attachment) {
//                $file_path = FCPATH . $attachment['file_path'];
//                if (file_exists($file_path)) {
//                    unlink($file_path);
//                }
//            }
//        }

        $delete = $this->OutModel->DeleteOut($out_id);

        if ($delete) {
            echo json_encode(['status' => 'success', 'message' => 'Out document deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete out document']);
        }
    }

    public function AjaxRestore()
    {
        $out_id = $this->input->post('out_id');

        $out = $this->OutModel->GetOutDetails($out_id, false);

        if (!$out) {
            echo json_encode(['status' => 'error', 'message' => 'Out document not found']);
            return;
        }


        $restore = $this->OutModel->RestoreOut($out_id);

        if ($restore) {
            echo json_encode(['status' => 'success', 'message' => 'Out document restored successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to restore out document']);
        }
    }

    /**
     * Ajax Details function to load import details without header/footer
     * Perfect for loading content in the inbox view
     */


    public function AjaxCheckImportExistence()
    {
        $import_book_number = $this->input->post('import_book_number');
        $import_book_date = $this->input->post('import_book_date');
        $import_from_department_id = $this->input->post('import_from_department_id');

        if ($import_book_number && $import_book_date && $import_from_department_id) {
            $import = $this->ImportModel->GetImportRelatedToAnswer($import_book_number, $import_book_date, $import_from_department_id);

            if ($import) {
                echo json_encode(['exists' => true,'import_subject' => $import['import_book_subject'],  'message' => 'Import document exists']);
                return;
            } else {
                echo json_encode(['exists' => false, 'message' => 'Import document does not exist']);
                return;
            }
        } else {
            echo json_encode(['exists' => false, 'message' => 'Invalid input']);
            return;
        }
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
        $answer = $this->OutModel->GetAnswerDetails($answer_id);

        if (!$answer ) {
            echo json_encode(['success' => false, 'message' => 'Answer record not found']);
            return;
        }

        $result = $this->OutModel->DeleteAnswer($answer_id);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Answer record deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete answer record']);
        }
    }


    public function AjaxAddAnswer()
    {

        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            redirect('Out/List');
        }

        $out_id = $this->input->post('out_id');

        if (!$out_id) {
            $this->session->set_flashdata('error', 'Invalid request');
            redirect('Out/List');
        }

        $this->form_validation->set_rules('answer_import_book_number', 'Book Number', 'required');
        $this->form_validation->set_rules('answer_import_book_date', 'Book Date', 'required');
        $this->form_validation->set_rules('answer_import_from_department_id', 'Sender Department', 'required');


        if ($this->form_validation->run() == TRUE) {

            $import_book_number = $this->input->post('answer_import_book_number');
            $import_book_date = $this->input->post('answer_import_book_date');
            $import_from_department_id = $this->input->post('answer_import_from_department_id');
            $import = $this->ImportModel->GetImportRelatedToAnswer($import_book_number, $import_book_date, $import_from_department_id);
            $import_id = $import ? $import['id'] : null;
            $answer_id = $this->OutModel->AddOutAnswer($out_id, $import_id,  $import_book_number, $import_book_date, $import_from_department_id);

            if ($answer_id) {
                $this->session->set_flashdata('success', 'Import Answer record added successfully');

            } else {
                $this->session->set_flashdata('error', 'Failed to add import answer record');
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
        }
        redirect('Out/Edit/' . $out_id);

    }


}