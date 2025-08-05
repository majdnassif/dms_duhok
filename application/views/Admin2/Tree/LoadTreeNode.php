
<?php foreach($Nodes as $node):?>
        <li style="display:none">
            <span class="tree-span"
                        data-id="<?=$node['id']?>"
                        data-name="<?=$node['name']?>"
                        data-code="<?=$node['code']?>"
                        data-fullpath="<?=$node['fullpath']?>"
                        data-branch="<?=$node['branch_id']?>">
            <i class="fa fa-plus-square"></i>
              
            <label class="text-md"><?=$node['name']?></label>
                
            <div class="btn-group btn-group-sm float-left" dir="ltr">
                <?php if($this->Permission->CheckPermissionOperation('tree_delete')):?>
                    <a class="btn btn-xs btn-danger" onclick="CallDeleteNode('<?=$node['id']?>',<?=$parent_id?>)"  role="button"><i class="fa fa-trash" aria-hidden="true"></i></a>
                <?php endif;?>
                <?php if($this->Permission->CheckPermissionOperation('tree_edit')):?>
                    <a class="btn btn-xs btn-info" onclick="CallEditNode('<?=$node['id']?>',<?=$parent_id?>)" role="button"><i class="fa fa-edit" aria-hidden="true"></i></a>
                <?php endif;?>
                
                <?php if($node['selectable']):?>
                    <a class="btn btn-xs btn-default select-btn" href="javascript:;" data-id="<?=$node['id']?>" data-fullpath="<?=$node['fullpath']?>">
                        <i class="text-primary fa fa-check"></i>
                    </a>
                    
                <?php endif;?>
                </div>
            </span>
        </li>
<?php endforeach;?>
    <?php if($this->Permission->CheckPermissionOperation('tree_add')):?>
        <li id="li-add<?=$parent_id?>" style="display:none">
            <button class="btn btn-xs btn-success" onclick="$('#AddNode').show();$('#EditNode').hide();$('#Model-form-parent_id').val(<?=$parent_id?>);"><i class="fa fa-plus" aria-hidden="true"></i></button>
        </li>
    <?php endif?>
    <?php if($Nodes):?>
        <script>$(document).ready(function(){$('[data-toggle="tooltip"]').tooltip();});</script>
    <?php endif?>


