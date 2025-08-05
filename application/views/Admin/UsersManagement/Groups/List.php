<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php if (isset($page_title)) : ?>
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><?= $this->Dictionary->GetKeyword($page_title); ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>"><?= $this->Dictionary->GetKeyword('Home'); ?></a></li>
                            <li class="breadcrumb-item active"><?= $this->Dictionary->GetKeyword($page_title); ?></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    <?php endif; ?>

    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-title"><?= $this->Dictionary->GetKeyword('Filter'); ?></h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-2">
                <?= $DataTable['fields'] ?>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- Default box -->
        <div class="card" id="ListCard">
            <div class="card-header bg-primary">
                <h3 class="card-title" dir=''><?= $this->Dictionary->GetKeyword($page_card_title) ?></h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-4 table-responsive">
                <?php if ($this->Permission->CheckPermissionOperation('usersmanagement_addgroup')) { ?>
                    <div class="col-12 pb-4 text-center"> <a href="<?= base_url('UsersManagement/AddGroup/') ?>" class="btn btn-success"><i class="fas fa-plus"></i> <?= $this->Dictionary->GetKeyword('Add Group') ?></a>
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