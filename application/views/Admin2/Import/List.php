<style>
    .custom-label {
        /*font-weight: bold;*/
        color: #0c0c39;
        margin: 0px 5px;

    }
    .date-input {
        width: 150px;

    }
    .today-checkbox {
        margin-right: 10px;
        margin-left: 5px;
    }
</style>
<?php if (isset($page_title)): ?>
  <div class="page-title">
    <h3><?= $page_title; ?></h3>
    <div class="page-breadcrumb">
      <ol class="breadcrumb">
        <li><a href="<?= base_url(); ?>"><?= $this->Dictionary->GetKeyword('Home'); ?></a></li>
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
                <h3 class="panel-title" dir=''>
                    <?= $this->Dictionary->GetKeyword($page_card_title) ?>
                </h3>
                <div class="panel-control">
                  <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" class="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>
            </div>
            <div class="panel-body pt-4 table-responsive">
                <?php if ($this->Permission->CheckPermissionOperation('Import_Add')): ?>
                <div class="col-12 text-center">
                    <a href="<?= base_url('Import/Add'); ?>" class="btn btn-sm btn-primary">
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
        $('#filter_import_signed_by').select2({
            placeholder: '<?php echo  $this->Dictionary->GetKeyword("Select_Signed_By" ); ?>',
            allowClear: true
        });
    });
    function refresh() {
        $('#Filter-btn').click();
    }
    
    function DeleteImport(importId, importCode) {
        if (confirm('Are you sure you want to delete Import Document: ' + importCode + '?')) {
            $.ajax({
                url: '<?= base_url('Import/AjaxDelete'); ?>',
                type: 'POST',
                data: {
                    import_id: importId
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

    function RestoreImport(importId, importCode) {
        if (confirm('Are you sure you want to Recover Import Document: ' + importCode + '?')) {
            $.ajax({
                url: '<?= base_url('Import/AjaxRestore'); ?>',
                type: 'POST',
                data: {
                    import_id: importId
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