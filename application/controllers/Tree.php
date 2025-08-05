<?php
class Tree extends CI_Controller
{
    public function __construct() {
        parent::__construct();
    }

    public function AjaxLoadTree($tree_type,$AllSelectable=0, $isCurrent = 0)
    {

        if($this->input->post()){
            $data["text_input_id"]=$this->input->post('text_input_id');
            $data["id_input_id"]=$this->input->post('id_input_id');
            $data["view_section"]=$this->input->post('view_section');
        }
        $data['AllSelectable']=$AllSelectable;
        $where = 'is_deleted = 0 and is_active = 1 ';
        if($isCurrent == 1){

            $where .= ' AND is_current = 1 ';
        }else{
            $where .= ' AND parent_id=-1 ';
        }

        $data['Nodes']=$this->Get_info->select($tree_type,$where);

        $data['branches']=$this->Get_info->select('system_branches');

        $data['tree_type']=$tree_type;
        $this->load->view("Admin2/Tree/LoadTree",$data);
    }
    public function AjaxLoadTreeNode($tree_type,$parent_id,$AllSelectable=0)
    {

        $data['AllSelectable']=$AllSelectable;
        $data['parent_id']=$parent_id;
        $data['tree_type']=$tree_type;

        $data['Nodes']=$this->Get_info->select($tree_type,"is_deleted = 0 and is_active = 1  AND parent_id= '". $parent_id ."'");

        foreach($data['Nodes'] as $key=>$Node){
            if($this->Get_info->select($tree_type,"is_deleted=0 AND parent_id='".$Node['id']."'") && $AllSelectable==0){
                $data['Nodes'][$key]['selectable']=0;
            }elseif($AllSelectable!=-1){
                $data['Nodes'][$key]['selectable']=1;
            }else{
                $data['Nodes'][$key]['selectable']=0;
            }
        }
        $this->load->view("Admin2/Tree/LoadTreeNode",$data);

    }

//    public function AjaxLoadTreeNode()
//    {
//        $tree_type = $this->input->post('tree_type');
//        $parent_id = $this->input->post('parent_id');
//        $AllSelectable = $this->input->post('all_selectable', true);
//
//        $data['AllSelectable'] = $AllSelectable;
//        $data['parent_id'] = $parent_id;
//        $data['tree_type'] = $tree_type;
//
//        $data['Nodes'] = $this->Get_info->select($tree_type, "is_deleted = 0 AND parent_id = '" . $parent_id . "'");
//
//        foreach ($data['Nodes'] as $key => $Node) {
//            if ($this->Get_info->select($tree_type, 'is_deleted=0 AND parent_id=' . $Node['id']) && $AllSelectable == 0) {
//                $data['Nodes'][$key]['selectable'] = 0;
//            } elseif ($AllSelectable != -1) {
//                $data['Nodes'][$key]['selectable'] = 1;
//            } else {
//                $data['Nodes'][$key]['selectable'] = 0;
//            }
//        }
//
//        $this->load->view("Admin2/Tree/LoadTreeNode", $data);
//    }

    public function AjaxAddNode($tree_type)
    {
        $NodeData=$this->input->post();


        $code = $this->db->query("SELECT count(1) total FROM `department`")->row_array()['total'];

        $branch_id = $NodeData['branch_id'];

        if($NodeData['parent_id']==-1){
            $NodeData['fullpath']=$NodeData['name']." / ";
            $NodeData['id'] = '*'.$code;
            $NodeData['parent_id'] = -1;
            $NodeData['branch_id'] = $branch_id;
        }else{
            $parent = $this->Get_info->select($tree_type,'id='. $this->db->escape($NodeData['parent_id']) )[0];
            $parent_fullpath=$parent['fullpath'];
            $NodeData['fullpath']=$parent_fullpath.$NodeData['name']." / ";
            $NodeData['id'] = $parent['id'] . '*' .$code;
            $NodeData['parent_id'] = $parent['id'];
            $NodeData['branch_id'] = $parent['branch_id'];
        }


        $this->Get_info->insert_data($tree_type,$NodeData);

        $new_node_id = $NodeData['id'];

//        $node_path = $new_node_id." / ";
//        if($NodeData['parent_id'] != -1){
//            $parent_node_path = $parent['node_path'];
//            $node_path = $parent_node_path.$node_path;
//        }
//        $this->db->update($tree_type,['node_path'=>$node_path],['id'=>$new_node_id]);


        $data['new_node']=$this->Get_info->select($tree_type,'id= '. $this->db->escape($new_node_id) )[0];
        if($new_node_id && $data['new_node']){
            echo json_encode(array('status'=>'True','message'=>"Added (".$data['new_node']["name"].") Succefullty"));
        }else{
            echo json_encode(array('status'=>'False','message'=>"We can't Add this Node."));
        }
    }
    public function AjaxDeleteNode($tree_type,$node_id)
    {
        if($this->db->update($tree_type, array('is_deleted' => 1), array('id' => $node_id))){
            echo json_encode(array('status'=>'True','message'=>"Deleted Succefullty"));
        }else{
            echo json_encode(array('status'=>'False','message'=>"we can't Delete this Node."));
        }
    }
    public function AjaxEditNode($tree_type,$node_id)
    {
        $NodeData=$this->input->post();

        if($this->db->update($tree_type,$NodeData, array('id' => $node_id))){
            echo json_encode(array('status'=>'True','message'=>"Updated Node Succefullty"));
        }else{
            echo json_encode(array('status'=>'False','message'=>"we can't Update this Node."));
        }
    }


}
