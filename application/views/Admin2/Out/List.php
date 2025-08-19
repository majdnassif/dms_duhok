<?php if (isset($page_title)): ?>
  <div class="page-title">
    <h3><?= $this->Dictionary->GetKeyword($page_title); ?></h3>
    <div class="page-breadcrumb">
      <ol class="breadcrumb">
        <li><a href="<?= base_url(); ?>"><?= $this->Dictionary->GetKeyword('Home'); ?></a></li>
        <li class="active"><?= $this->Dictionary->GetKeyword($page_title); ?></li>
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
                <h3 class="panel-title" dir=''>
                    <?= $this->Dictionary->GetKeyword($page_card_title) ?>
                </h3>
                <div class="panel-control">
                  <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" class="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>
            </div>
            <div class="panel-body pt-4 table-responsive">
                <?php if ($this->Permission->CheckPermissionOperation('Out_Add')): ?>
                <div class="col-12 text-center">
                    <a href="<?= base_url('Out/Add'); ?>" class="btn btn-sm btn-primary">
                        <i class="fa fa-plus"></i> <?= $this->Dictionary->GetKeyword('Add New'); ?>
                    </a>
                </div>
                <?php endif; ?>
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

    $(document).ready(function() {
        // Initialize select2 for the element
        $('#filter_out_signed_by').select2({
            placeholder: '<?php echo  $this->Dictionary->GetKeyword("Select_Signed_By" ); ?>',
            allowClear: true
        });
    });

    function refresh() {
        $('#Filter-btn').click();
    }
    
    function DeleteOut(outId, outCode) {
        if (confirm('Are you sure you want to delete Out Document: ' + outCode + '?')) {
            $.ajax({
                url: '<?= base_url('Out/AjaxDelete'); ?>',
                type: 'POST',
                data: {
                    out_id: outId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        refresh();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error('An error occurred while processing your request.');
                }
            });
        }
    }

    function RestoreOut(outId, outCode) {
        if (confirm('Are you sure you want to Recover Out Document: ' + outCode + '?')) {
            $.ajax({
                url: '<?= base_url('Out/AjaxRestore'); ?>',
                type: 'POST',
                data: {
                    out_id: outId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        refresh();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error('An error occurred while processing your request.');
                }
            });
        }
    }
</script>
<?= $DataTable['js'] ?> 