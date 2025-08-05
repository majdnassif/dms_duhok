<?php if (isset($page_title)): ?>
  <div class="page-title">
    <h3><?= $page_title; ?></h3>
    <div class="page-breadcrumb">
      <ol class="breadcrumb">
        <li><a href="<?= base_url(); ?>">Home</a></li>
        <li class="active"><?= $page_title; ?></li>
      </ol>
    </div>
  </div>
<?php endif; ?>
<div class="container-fluid">
    <!-- Main content -->
    <section class="content">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><?= $this->Dictionary->GetKeyword('Filter'); ?></h3>
                <div class="panel-control">
                  <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" class="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>
            </div>
            <!-- panel-control -->
            
            <div class="panel-body p-2">
                <?= $DataTable['fields'] ?>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- Default box -->
        <div class="panel panel-success" id="ListCard">
            <div class="panel-heading">
                <h3 class="panel-title" dir=''><?= $this->Dictionary->GetKeyword($page_card_title) ?></h3>
                <div class="panel-control">
                  <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" class="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>
            </div>
            <div class="panel-body pt-4 table-responsive">
                <?php if ($this->Permission->CheckPermissionOperation('usersmanagement_adduser')) { ?>
                    <div class="col-12 pb-4 text-center"> <a href="<?= base_url('UsersManagement/AddUser/') ?>" class="btn btn-success"><i class="fa fa-plus"></i> <?= $this->Dictionary->GetKeyword('Add User') ?></a>
                    </div>

                <?php } ?>
                <div class="col-12">
                    <?= $DataTable['html'] ?>
                </div>
            </div>
            <!-- /.card-body -->
        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
    function refresh() {
        $('#Filter-btn').click();
    }
<?php if($this->Permission->CheckPermissionOperation('usersmanagement_changeuserstatus')):?>
function CallDeleteUser(User_id){
    Swal.fire({
                title: "<?= $this->Dictionary->GetKeyword('Are You Sure you want to do that ?') ?>",
                text: "<?= $this->Dictionary->GetKeyword('Delete User') ?>",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<?= $this->Dictionary->GetKeyword('Yes') ?>',
                cancelButtonText: '<?= $this->Dictionary->GetKeyword('No') ?>',
              }).then((result) => {
                if (result.isConfirmed) {
                  $.ajax({
                    url: "<?= base_url('UsersManagement/AjaxDeleteUser/') ?>"+User_id,
                    type: "POST",
                    dataType: "json",
                    success: function(data) {
                      if (data.status == 'success') {
                        refresh();
                        toastr.success(data.message);
                      }else{
                        toastr.error(data.message);
                      }
                    }
                  });
                }
              });
}
function CallLockUser(User_id){
    Swal.fire({
                title: "<?= $this->Dictionary->GetKeyword('Are You Sure you want to do that ?') ?>",
                text: "<?= $this->Dictionary->GetKeyword('Lock User') ?>",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<?= $this->Dictionary->GetKeyword('Yes') ?>',
                cancelButtonText: '<?= $this->Dictionary->GetKeyword('No') ?>',
              }).then((result) => {
                if (result.isConfirmed) {
                  $.ajax({
                    url: "<?= base_url('UsersManagement/AjaxLockUser/') ?>"+User_id,
                    type: "POST",
                    dataType: "json",
                    success: function(data) {
                      if (data.status == 'success') {
                        refresh();
                        toastr.success(data.message);
                      }else{
                        toastr.error(data.message);
                      }
                    }
                  });
                }
              });
}
function CallInActiveUser(User_id){
    Swal.fire({
                title: "<?= $this->Dictionary->GetKeyword('Are You Sure you want to do that ?') ?>",
                text: "<?= $this->Dictionary->GetKeyword('InActive User') ?>",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<?= $this->Dictionary->GetKeyword('Yes') ?>',
                cancelButtonText: '<?= $this->Dictionary->GetKeyword('No') ?>',
              }).then((result) => {
                if (result.isConfirmed) {
                  $.ajax({
                    url: "<?= base_url('UsersManagement/AjaxInActiveUser/') ?>"+User_id,
                    type: "POST",
                    dataType: "json",
                    success: function(data) {
                      if (data.status == 'success') {
                        refresh();
                        toastr.success(data.message);
                      }else{
                        toastr.error(data.message);
                      }
                    }
                  });
                }
              });
}
function CallActiveUser(User_id){
    Swal.fire({
                title: "<?= $this->Dictionary->GetKeyword('Are You Sure you want to do that ?') ?>",
                text: "<?= $this->Dictionary->GetKeyword('Active User') ?>",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<?= $this->Dictionary->GetKeyword('Yes') ?>',
                cancelButtonText: '<?= $this->Dictionary->GetKeyword('No') ?>',
              }).then((result) => {
                if (result.isConfirmed) {
                  $.ajax({
                    url: "<?= base_url('UsersManagement/AjaxActiveUser/') ?>"+User_id,
                    type: "POST",
                    dataType: "json",
                    success: function(data) {
                      if (data.status == 'success') {
                        refresh();
                        toastr.success(data.message);
                      }else{
                        toastr.error(data.message);
                      }
                    }
                  });
                }
              });
}
<?php endif; ?>
</script>
<?= $DataTable['js'] ?>