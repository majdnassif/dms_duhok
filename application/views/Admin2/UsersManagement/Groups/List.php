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
            <div class="panel-heading bg-info">
                <h3 class="panel-title"><?= $this->Dictionary->GetKeyword('Filter'); ?></h3>

                <div class="panel-control">
                  <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" class="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>
            </div>
            <div class="panel-body p-2">
                <?= $DataTable['fields'] ?>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- Default box -->
        <div class="panel panel-success" id="ListCard">
            <div class="panel-heading bg-primary">
                <h3 class="panel-title" dir=''><?= $this->Dictionary->GetKeyword($page_card_title) ?></h3>

                <div class="panel-control">
                  <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" class="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>
            </div>
            <div class="panel-body p-4 table-responsive">
                <?php if ($this->Permission->CheckPermissionOperation('usersmanagement_addgroup')) { ?>
                    <div class="col-12 pb-4 text-center"> <a href="<?= base_url('UsersManagement/AddGroup/') ?>" class="btn btn-success"><i class="fa fa-plus"></i> <?= $this->Dictionary->GetKeyword('Add Group') ?></a>
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
</script>
<?= $DataTable['js'] ?>