<?php 

class Settings extends CI_Controller
{
    private $tables;
    
    function __construct()
    {   
        parent::__construct();
        $this->load->model('SettingsModel');
        $this->load->model('UserModel');
        
        // Define all tables with their configuration
        $this->tables = [
            'book_category' => [
                'title' => 'Book Categories',
                'primary_key' => 'book_category_id',
                'name_field' => 'book_category_name',
                'fields' => [
                    'book_category_name' => [
                        'label' => 'Category Name',
                        'type' => 'text',
                        'required' => true
                    ]
                ]
            ],
            'book_importance_level' => [
                'title' => 'Book Importance Levels',
                'primary_key' => 'book_importance_level_id',
                'name_field' => 'book_importance_level_name',
                'fields' => [
                    'book_importance_level_name' => [
                        'label' => 'Importance Level Name',
                        'type' => 'text',
                        'required' => true
                    ]
                ]
            ],
            'book_language' => [
                'title' => 'Book Languages',
                'primary_key' => 'book_language_id',
                'name_field' => 'book_language_name',
                'fields' => [
                    'book_language_name' => [
                        'label' => 'Language Name',
                        'type' => 'text',
                        'required' => true
                    ]
                ]
            ],
            'department_category' => [
                'title' => 'Department Categories',
                'primary_key' => 'department_category_id',
                'name_field' => 'department_category_name',
                'fields' => [
                    'department_category_name' => [
                        'label' => 'Category Name',
                        'type' => 'text',
                        'required' => true
                    ]
                ]
            ],
            'department_secret_level' => [
                'title' => 'Department Secret Levels',
                'primary_key' => 'department_secret_level_id',
                'name_field' => 'department_secret_level_name',
                'fields' => [
                    'department_secret_level_name' => [
                        'label' => 'Secret Level Name',
                        'type' => 'text',
                        'required' => true
                    ]
                ]
            ],
            'department_status' => [
                'title' => 'Department Status',
                'primary_key' => 'department_status_id',
                'name_field' => 'department_status_name',
                'fields' => [
                    'department_status_name' => [
                        'label' => 'Status Name',
                        'type' => 'text',
                        'required' => true
                    ]
                ]
            ],
            'import_trace_status' => [
                'title' => 'Import Trace Status',
                'primary_key' => 'import_trace_status_id',
                'name_field' => 'import_trace_status_name',
                'fields' => [
                    'import_trace_status_name' => [
                        'label' => 'Status Name',
                        'type' => 'text',
                        'required' => true
                    ],
                    'import_trace_status_icon' => [
                        'label' => 'Status Icon',
                        'type' => 'text',
                        'required' => true
                    ]
                ]
            ],
            'import_trace_type' => [
                'title' => 'Import Trace Type',
                'primary_key' => 'import_trace_type_id',
                'name_field' => 'import_trace_type_name',
                'fields' => [
                    'import_trace_type_name' => [
                        'label' => 'Type Name',
                        'type' => 'text',
                        'required' => true
                    ],
                    'import_trace_type_icon' => [
                        'label' => 'Type Icon',
                        'type' => 'text',
                        'required' => true
                    ]
                ]
            ],
            'dictionary' => [
                'title' => 'Dictionary',
                'primary_key' => 'KEYWORD',
                'name_field' => 'KEYWORD',
                'fields' => [
                    'KEYWORD' => [
                        'label' => 'Keyword',
                        'type' => 'text',
                        'required' => true
                    ],
                    'ENGLISH'=> [
                        'label' => 'English',
                        'type' => 'text',
                        'required' => true
                    ],
                    'ARABIC' => [
                        'label' => 'Arabic',
                        'type' => 'text',
                        'required' => true
                    ],
                    'KURDISH' => [
                        'label' => 'Kurdish',
                        'type' => 'text',
                        'required' => true
                    ]
                ]
            ]
        ];
	}
	
	public function index()
	{
        // Show all available settings
        $data['page_title'] = 'System Settings';
        $data['tables'] = $this->tables;
        
        $this->_temp_output('Index', $data);
	}

    public function _temp_output($view, $output=null)
    {
        if($this->session->userdata('user_login_data')){
            $this->load->view("Admin2/header", (array)$output);
            $perm = $this->Permission->CheckPermission();
            if($perm == true){
                $this->load->view("Admin2/Settings/$view", (array)$output);
            }else{
                $this->load->view('Admin2/permission');
            }
            $this->load->view("Admin2/footer", (array)$output);
        }else{
            return $this->load->view('Admin2/login');
        }
    }
    
    // Generic list method that works for all tables
    public function listItems($table)
    {
        if (!array_key_exists($table, $this->tables)) {
            show_404();
        }
        
        $config = $this->tables[$table];
        
        $data['page_title'] = $config['title']; 
        $data['page_card_title'] = $config['title'];
        $data['table'] = $table;
        $data['config'] = $config;
        
        $filters = [];
        $filters[$config['name_field']] = ['type' => 'text', 'name' => $config['name_field'], 'id' => 'filter_' . $config['name_field'], 'label' => $config['fields'][$config['name_field']]['label']];
        
        $cols[0] = $config['primary_key'];
        $i = 1;
        foreach($config['fields'] as $field => $field_config){
            if($field != $config['primary_key']){
                $cols[$i] = $field;
                $i++;
            }
        }
        $cols[$i] = 'Actions';
        
        $data['DataTable'] = DataTableBuilder($table . 'List', base_url("Settings/AjaxListItems/" . $table), $cols, $filters);
        $this->_temp_output('List', $data);
    }
    
    // Generic AJAX handler for listing items
    public function AjaxListItems($table)
    {
        if (!array_key_exists($table, $this->tables)) {
            show_404();
        }
        
        $config = $this->tables[$table];
        
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $order = $this->input->post("order");
        
        $cols[0] = $config['primary_key'];
        $i = 1;
        foreach($config['fields'] as $field => $field_config){
            if($field != $config['primary_key']){
                $cols[$i] = $field;
                $i++;
            }
        }
        $cols[$i] = 'Actions';
        
        if(isset($order[0]['column'])){
            $order = ' ORDER BY ' . $cols[$order[0]['column']] . ' ' . $order[0]['dir'];
        }
        
        $filter = "";
        
        // Name field filter
        $name = $this->input->post($config['name_field']);
        if ($name && $name != "") {
            $filter .= " AND `" . $config['name_field'] . "` LIKE '%" . $this->db->escape_str($name) . "%'";
        }
        
        $items = $this->SettingsModel->getItemsList($table, $config, $filter, $start, $length, $order);
        $items_data = $items['data'];
        $num_rows = $items['count'];
        $ajax = array();
        
        foreach($items_data as $item) {
            $actions = '<div class="btn-group btn-group-sm" dir="ltr">';
            
            // Edit
            $actions .= '<a class="btn btn-sm btn-primary" href="' . base_url("Settings/editItem/" . $table . "/" . $item[$config['primary_key']]) . '" role="button"><i class="fa fa-edit"></i></a>';
            
            // Delete
            $actions .= '<a class="btn btn-sm btn-danger" onclick="deleteItem(\'' . $table . '\', ' . $item[$config['primary_key']] . ', \'' . $item[$config['name_field']] . '\')" role="button"><i class="fa fa-trash"></i></a>';
            
            $actions .= '</div>';
            
            $ajax[] = [
                ...$item,
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
    
    // Generic add method
    public function addItem($table)
    {
        if (!array_key_exists($table, $this->tables)) {
            show_404();
        }
        
        $config = $this->tables[$table];
        
        $data['page_title'] = 'Add New ' . rtrim($config['title'], 's');
        $data['page_card_title'] = 'Add ' . rtrim($config['title'], 's');
        $data['table'] = $table;
        $data['config'] = $config;
        
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            // Set validation rules
            foreach ($config['fields'] as $field => $field_config) {
                if (!empty($field_config['required'])) {
                    $this->form_validation->set_rules($field, $field_config['label'], 'required');
                }
            }
            
            if ($this->form_validation->run() == TRUE) {
                $item_data = [];
                
                // Get posted data for each field
                foreach ($config['fields'] as $field => $field_config) {
                    $item_data[$field] = $this->input->post($field);
                }
                
                $insert_id = $this->SettingsModel->addItem($table, $item_data);
                
                if ($insert_id) {
                    $this->session->set_flashdata('success', rtrim($config['title'], 's') . ' added successfully');
                    redirect('Settings/listItems/' . $table);
                } else {
                    $data['error'] = 'Failed to add ' . rtrim($config['title'], 's');
                }
            }
        }
        
        $this->_temp_output('Form', $data);
    }
    
    // Generic edit method
    public function editItem($table, $id)
    {
        if (!array_key_exists($table, $this->tables)) {
            show_404();
        }
        
        $config = $this->tables[$table];
        
        $data['page_title'] = 'Edit ' . rtrim($config['title'], 's');
        $data['page_card_title'] = 'Edit ' . rtrim($config['title'], 's');
        $data['table'] = $table;
        $data['config'] = $config;
        
        $data['item'] = $this->SettingsModel->getItemDetails($table, $config, $id);
        
        if (!$data['item']) {
            $this->session->set_flashdata('error', rtrim($config['title'], 's') . ' not found');
            redirect('Settings/listItems/' . $table);
        }
        
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            // Set validation rules
            foreach ($config['fields'] as $field => $field_config) {
                if (!empty($field_config['required'])) {
                    $this->form_validation->set_rules($field, $field_config['label'], 'required');
                }
            }
            
            if ($this->form_validation->run() == TRUE) {
                $item_data = [];
                
                // Get posted data for each field
                foreach ($config['fields'] as $field => $field_config) {
                    $item_data[$field] = $this->input->post($field);
                }
                
                $update = $this->SettingsModel->updateItem($table, $config, $id, $item_data);
                
                if ($update) {
                    $this->session->set_flashdata('success', rtrim($config['title'], 's') . ' updated successfully');
                    redirect('Settings/listItems/' . $table);
                } else {
                    $data['error'] = 'Failed to update ' . rtrim($config['title'], 's');
                }
            }
        }
        
        $this->_temp_output('Form', $data);
    }
    
    // Generic AJAX delete handler
    public function AjaxDeleteItem()
    {
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        
        if (!array_key_exists($table, $this->tables)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid table']);
            return;
        }
        
        $config = $this->tables[$table];
        
        $item = $this->SettingsModel->getItemDetails($table, $config, $id);
        
        if (!$item) {
            echo json_encode(['status' => 'error', 'message' => rtrim($config['title'], 's') . ' not found']);
            return;
        }
        
        $delete = $this->SettingsModel->deleteItem($table, $config, $id);
        
        if ($delete) {
            echo json_encode(['status' => 'success', 'message' => rtrim($config['title'], 's') . ' deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete ' . rtrim($config['title'], 's')]);
        }
    }
} 