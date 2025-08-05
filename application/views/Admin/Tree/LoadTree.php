<?php if($tree_type=="government_departments"){
            $title=$this->Dictionary->GetKeyword("government_departments");
            }elseif($tree_type=="locations"){
            $title=$this->Dictionary->GetKeyword("Locations");
            }else{
            $title=$this->Dictionary->GetKeyword($tree_type);
            }?>
            <div class="modal-header">
              <h3 class="modal-title"><?=$title?> </h3>
              <button type="button" class="close" onclick="$('#listTree').html('');" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body p-3 text-right" id="tree-section">
                <form id="AddNode" onsubmit="CallAddNode(); return false;" method="post" <?php if($this->UserModel->language()=="ENGLISH"){?>dir="ltr"<?php }?> >
                        <div class="row <?php if($this->UserModel->language()=="ENGLISH"){?>text-left<?php }?>" >
                            <div class="form-group col-md-8" >
                                <label for="name"><?=$this->Dictionary->GetKeyword("New Node Name");?></label>
                                <input type="text" class="form-control" name="name" id="NodeName" placeholder="<?=$this->Dictionary->GetKeyword("New Node Name");?>" required>
                                <input class="form-control" id="Model-form-parent_id" name="parent_id" value="" type="hidden" readonly>
                            </div>
                            <!-- <div class="form-group col-md-4" >
                                <label for="code"><?=$this->Dictionary->GetKeyword("New Node Code");?></label>
                                <input type="text" class="form-control" name="code" id="NodeCode" placeholder="<?=$this->Dictionary->GetKeyword("New Node Code");?>" required>
                            </div> -->
                            <div class="form-group col-md-4" >
                                <button type="submit" class="btn btn-md btn-success" style="margin-top: 2rem !important;">
                                    <i class="fa fa-plus-square" aria-hidden="true"></i><?=$this->Dictionary->GetKeyword("Add");?> 
                                </button>
                                <button type="button" onclick="$('#AddNode').hide()" class="btn btn-md btn-warning" style="margin-top: 2rem !important;">
                                    <i class="fa fa-times" aria-hidden="true"></i> <?=$this->Dictionary->GetKeyword("cancel");?> 
                                </button>
                            </div>
                        </div>
                </form>
                <form id="EditNode" onsubmit="CallEditNodeSubmit(); return false;" method="post"  <?php if($this->UserModel->language()=="ENGLISH"){?>dir="ltr"<?php }?>>
                        <div class="row">
                            <div class="form-group col-md-8" >
                                <label for="name"><?=$this->Dictionary->GetKeyword("Edit Node Name");?></label>
                                <input type="text" class="form-control" name="name" id="EditNodeName" placeholder="<?=$this->Dictionary->GetKeyword("Edit Node Name");?>" required> 
                                <input type="hidden" id="EditNodeID" name="NodeID">
                                <input type="hidden" id="EditParentNodeID" name="ParentNodeID">
                            </div>
                            <!-- <div class="form-group col-md-4" >
                                <label for="code"><?=$this->Dictionary->GetKeyword("Edit Node Code");?></label>
                                <input type="text" class="form-control" name="code" id="EditNodeCode" placeholder="<?=$this->Dictionary->GetKeyword("Edit Node Code");?>" required>
                            </div> -->
                            <div class="form-group col-md-4" >
                                <button type="submit" class="btn btn-md btn-info" style="margin-top: 2rem !important;"><i class="fa fa-edit" aria-hidden="true"></i><?=$this->Dictionary->GetKeyword("Edit");?> 
                                </button>
                                
                                <button type="button" onclick="$('#EditNode').hide()" class="btn btn-md btn-warning" style="margin-top: 2rem !important;">
                                    <i class="fa fa-times" aria-hidden="true"></i><?=$this->Dictionary->GetKeyword("Cancel");?>
                                </button>
                            </div>
                        </div>
                </form>
                <div dir="rtl" class="tree well rtl-tree" data-treetype="<?=$tree_type?>">
                    <ul data-all_selectable='<?=$AllSelectable?>'>
                        <?php if($this->Permission->CheckPermissionOperation('tree_add')):?>
                            <li id="li-add-1" style="display:list-item">
                                <button class="btn btn-sm btn-success" onclick="$('#AddNode').show();$('#EditNode').hide();$('#Model-form-parent_id').val(-1);"><?=$this->Dictionary->GetKeyword("add_node");?></button>
                            </li>
                        <?php endif;?>   
                        <?php foreach($Nodes as $node):?>
                        <li style="display:list-item">
                            <span class="tree-span" data-id="<?=$node['id']?>" data-name="<?=$node['name']?>" data-code="<?=$node['code']?>" data-fullpath="<?=$node['fullpath']?>">
                                <i class="fa fa-plus-square"></i>
                                <label class="text-md"><?=$node['name']?></label>
                                <div class="btn-group btn-group-sm float-left" dir="ltr">
                                    
                                    <?php if($this->Permission->CheckPermissionOperation('tree_delete')):?>
                                    <a name="" id="" class="btn btn-xs btn-danger" onclick="CallDeleteNode(<?=$node['id']?>,-1)" role="button"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    <?php endif;?>
                                    <?php if($this->Permission->CheckPermissionOperation('tree_edit')):?>
                                    <a name="" id="" class="btn btn-xs btn-info" onclick="CallEditNode(<?=$node['id']?>,-1)"  role="button"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                    <?php endif;?>
                                    <?php if($AllSelectable==1):?>
                                    <a class="btn btn-xs btn-default select-btn" href="javascript:;" data-id="<?=$node['id']?>" data-fullpath="<?=$node['fullpath']?>"><i class="text-primary fa fa-check"></i></a>
                                    <?php endif;?>
                                </div>
                            </span>
                            
                        </li>
                        
                        <?php endforeach;?>
                        
                    </ul>
                </div>
                
            </div>
<script>
    function CallAddNode(){
        $.post('<?=base_url('Tree/AjaxAddNode/'.$tree_type)?>',$('#AddNode').serialize(),function(response){
                            response=JSON.parse(response);
                            if(response.status=='True'){
                                RefreshNode($('#Model-form-parent_id').val());
                                $('#NodeName').val('');
                                //$('#NodeCode').val('');
                                $('#AddNode').hide();
                                toastr.success(response.message);
                            }else{
                                toastr.error(response.message);
                            }
                    });return false;
    }
    function CallDeleteNode(node_id,parent_id){
        $.confirmModal('Are you sure you want to Delete This Node?',{messageHeader:"Delete Node",HeaderClass:"bg-danger"}, function(el) {
        $.get('<?=base_url('Tree/AjaxDeleteNode/'.$tree_type.'/')?>'+node_id,function(response){
            response=JSON.parse(response);
            if(response.status=='True'){
                RefreshNode(parent_id);
                toastr.success(response.message);
            }else{
                toastr.error(response.message);
            }
        });});
    }
    function CallEditNode(node_id,parent_id){
        node_name=$('span[data-id="'+node_id+'"]').data('name');
        node_code=$('span[data-id="'+node_id+'"]').data('code');
        $("#EditNodeName").val(node_name);
        //$("#EditNodeCode").val(node_code);
        $("#EditNodeID").val(node_id);
        $("#EditParentNodeID").val(parent_id);
        
        $('#EditNode').show();
        $('#AddNode').hide();
        //RefreshNode(parent_id);
    }
    function CallEditNodeSubmit(){
        NodeID=$("#EditNodeID").val();
        ParentNodeID=$("#EditParentNodeID").val();
        $.post("<?=base_url("Tree/AjaxEditNode/".$tree_type.'/')?>"+NodeID,{name:$("#EditNodeName").val(),code:$("#EditNodeCode").val()},function(response){
            response=JSON.parse(response);
            if(response.status=='True'){
                $("#EditNodeName").val("");
                $("#EditNodeCode").val("");
                $("#EditNodeID").val("");
                $("#EditParentNodeID").val("");
                $('#EditNode').hide();
                toastr.success(response.message);
                RefreshNode(ParentNodeID);
            }else{
                toastr.error(response.message);
            }
        });
    }
    function RefreshNode(parent_id){
        if(parent_id==-1){
            OpenTree('<?=$tree_type?>','<?=$text_input_id?>','<?=$id_input_id?>','<?=$AllSelectable?>','<?=$view_section?>');
        }else{
            $('span[data-id="'+parent_id+'"]').parent().find("ul").remove();
            if($('span[data-id="'+parent_id+'"]').find('.select-btn').text()){
                $('span[data-id="'+parent_id+'"]').find('.select-btn').remove();
            }
            $('span[data-id="'+parent_id+'"]').find("label").click();
            $('span[data-id="'+parent_id+'"]').find("label").click();
            
        }
    }
    $('#AddNode').hide();
    $('#EditNode').hide();
    $('#tree-section').on('click', '.tree li > span > i', function (e) {
        $currentSpan = $(this).parent();
        OpenNode($currentSpan, "");
    });
    $('#tree-section').on('click', '.tree li > span > label', function (e) {
        $currentSpan = $(this).parent();
        OpenNode($currentSpan, "");
    });
/*     $('#tree-section').on('click', '.select_node_button', function () {
        $node_id = $(this).data("id");
        $node_text = $(this).data("fullpath");
        SelectNode($node_id, "#<?=$id_input_id?>", $node_text, "#<?=$text_input_id?>", "extra-modal");
        //ValidateSelectedCollege($node_id);
    }); */
    $('#tree-section').on('click', '.select-btn', function () {
        $node_id = $(this).data("id");
        $node_text = $(this).data("fullpath");
        SelectNode($node_id, "#<?=$id_input_id?>", $node_text, "#<?=$text_input_id?>", "extra-modal");
    });
    
</script>