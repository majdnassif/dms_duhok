<?php 
if($Group['OPERATIONS_NAME']!=''){
    $GroupPermissions=explode(',',$Group['OPERATIONS_NAME']);
}else{
    $GroupPermissions=[];
}?>
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
<?php if (isset($page_title)): ?>
  <div class="page-title">
    <h3><?= $this->Dictionary->GetKeyword($page_title); ?></h3>
    <div class="page-breadcrumb">
      <ol class="breadcrumb">
        <li><a href="<?= base_url(); ?>"><?= $this->Dictionary->GetKeyword('Home') ?></a></li>
        <li class="active"><?= $this->Dictionary->GetKeyword($page_title); ?></li>
      </ol>
    </div>
  </div>
<?php endif; ?>

<div class="container-fluid">
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title" dir=''><?= $this->Dictionary->GetKeyword($page_card_title) ?></h3>
            </div>
            <div class="panel-body p-4">   
                <form id="EditGroupForm" class="col-12">
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="GROUP_NAME"><?= $this->Dictionary->GetKeyword('GROUP_NAME') ?>*</label>
                            <input id='GROUP_NAME' name='GROUP_NAME' aria-describedby="helpGROUP_NAME" class="form-control" type="text" value="<?=$Group['GROUP_NAME']?>" required>
                            <small id="helpGROUP_NAME" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group col-6">
                            <label for="STATUS_ID"><?= $this->Dictionary->GetKeyword('STATUS') ?>*</label>
                            <select id="STATUS_ID" name="STATUS_ID" class="form-control select2" required>
                                <option value="1" <?= $Group['STATUS_ID']==1?'selected':'';?>><?= $this->Dictionary->GetKeyword('active') ?></option>
                                <option value="0" <?= $Group['STATUS_ID']==0?'selected':'';?>><?= $this->Dictionary->GetKeyword('inactive') ?></option>
                            </select>
                            <small id="helpUI_LANGUAGE" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group col-12">
                        
                        <select class="duallistbox" name="PERMISSION[]" multiple="multiple">
                            <?php foreach($Operations as $Operation):?>
                            <option value="<?=$Operation['OPERATION_CODE']?>" <?= in_array($Operation['OPERATION_CODE'],$GroupPermissions)?'selected':'';?>><?=$Operation['NAME']?></option>
                            <?php endforeach;?>
                        </select>
                        </div>
                        <div class="form-group col-12 text-center">
                            <!-- submit -->
                            <button type="submit" class="btn btn-primary"><?= $this->Dictionary->GetKeyword('Update') ?></button>
                            <a href="<?=base_url('UsersManagement/GroupsList')?>" class="btn btn-default"><?= $this->Dictionary->GetKeyword('Close') ?></a>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<style>
            .bootstrap-duallistbox-container .buttons{
                width: calc(100% - 25px);
                margin-bottom: 4px;
            }
        </style>
        <script src="<?=base_url('assets/dist/js/')?>bootstrap-show-password.min.js"></script>
<script>


    
    $(document).ready(function() {
        $('#EditGroupForm').validate({
            ignore: "",
            rules: {
                GROUP_NAME:{
                    required: true,
                    minlength: 3,
                    maxlength: 50
                },
            },
            highlight: function(element) {
                $(element).parent('.form-group').removeClass('has-success');
                $(element).parent('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).parent('.form-group').removeClass('has-error');
                $(element).parent('.form-group').addClass('has-success');
            },
            success: function(element) {
                $(element).parent('.form-group').removeClass('has-error');
                $(element).parent('.form-group').addClass('has-success');
            },
            errorPlacement: function(error, element) {
                $(element).closest('.form-group').find('small').html(error.html());
            }
        });
        $('.select2').select2();
            //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox({
            infoText: 'Showing all {0}',
            selectorMinimalHeight: 250,
            moveOnSelect: false,
            nonSelectedListLabel: '<?= $this->Dictionary->GetKeyword('Available') ?>',
            selectedListLabel: '<?= $this->Dictionary->GetKeyword('Selected') ?>',
            preserveSelectionOnMove: 'moved',
            moveSelectedLabel: '<?= $this->Dictionary->GetKeyword('Move Selected') ?>',
            moveAllLabel: '<?= $this->Dictionary->GetKeyword('Move All') ?>',
            removeSelectedLabel: '<?= $this->Dictionary->GetKeyword('Remove Selected') ?>',
            removeAllLabel: '<?= $this->Dictionary->GetKeyword('Remove All') ?>{0}',
            filterPlaceHolder: '<?= $this->Dictionary->GetKeyword('Filter') ?>',
            filterTextClear: '<?= $this->Dictionary->GetKeyword('Show All') ?>',
            filterText: '<?= $this->Dictionary->GetKeyword('Filter') ?>',
            moveOnSelect: false,

        });
        $('#EditGroupForm').submit(function() {
            if ($('#EditGroupForm').valid()) {
                //delete PERMISSION[]_helper1 input
                FormData = $('#EditGroupForm').serializeArray();
                //delete PERMISSION[]_helper1
                FormData = FormData.filter(function(item) {
                    return item.name !== 'PERMISSION[]_helper1' && item.name !== 'PERMISSION[]_helper2';
                });
                $('#EditGroupForm input[name="PERMISSION[]_helper1"]').remove();
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('UsersManagement/EditGroup/'.$Group_id); ?>",
                    data: FormData,
                    success: function(response) {
                        response = JSON.parse(response);
                        if (response.status == 'success') {
                            toastr.success(response.message);
                            location.reload();
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function() {
                        toastr.error("we have n't updated the information");
                    }
                });
            }
            return false;
        });

    });
</script>

<!-- Bootstrap4 Duallistbox -->
<script src="<?=base_url('assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')?>"></script>