<?php if (isset($page_title)): ?>
  <div class="page-title">
    <h3><?= $page_title; ?></h3>
    <div class="page-breadcrumb">
      <ol class="breadcrumb">
        <li><a href="<?= base_url(); ?>"><?= $this->Dictionary->GetKeyword('Home'); ?></a></li>
        <li><a href="<?= base_url('Settings'); ?>"><?= $this->Dictionary->GetKeyword('System Settings'); ?></a></li>
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
                <div class="col-12 text-center mb-4">
                    <a href="<?= base_url('Settings/addItem/' . $table); ?>" class="btn btn-sm btn-primary">
                        <i class="fa fa-plus"></i> <?= $this->Dictionary->GetKeyword('Add New'); ?>
                    </a>
                    <a href="<?= base_url('Settings'); ?>" class="btn btn-sm btn-default">
                        <i class="fa fa-arrow-left"></i> <?= $this->Dictionary->GetKeyword('Back to Settings'); ?>
                    </a>
                </div>
                <div class="col-12">
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?= $this->session->flashdata('success'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?= $this->session->flashdata('error'); ?>
                        </div>
                    <?php endif; ?>
                    
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
    
    function deleteItem(table, id, name) {
        if (confirm('<?= $this->Dictionary->GetKeyword('Are you sure you want to delete'); ?>: ' + name + '?')) {
            $.ajax({
                url: '<?= base_url('Settings/AjaxDeleteItem'); ?>',
                type: 'POST',
                data: {
                    table: table,
                    id: id
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
                    toastr.error('<?= $this->Dictionary->GetKeyword('An error occurred while processing your request'); ?>');
                }
            });
        }
    }
</script>
<?= $DataTable['js'] ?>
