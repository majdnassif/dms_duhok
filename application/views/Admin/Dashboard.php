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
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>"><?= $this->Dictionary->GetKeyword('Home') ?></a></li>
              <li class="breadcrumb-item active"><?= $this->Dictionary->GetKeyword($page_title); ?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
  <?php endif; ?>

  <section class="content">
    <!-- <div class="card">
      <div class="card-header bg-success">
        <h3 class="card-title"><?= $this->Dictionary->GetKeyword('Balance'); ?></h3>

        <div class="card-tools">
          <button class="btn btn-tool" id="card-OrderItems" data-card-widget="card-refresh" data-source="<?= base_url('Admin/AjaxUserBalance/') ?>"><i class="fas fa-sync-alt"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse"><i class="fas fa-minus"></i></button>
        </div>
      </div>
      <div class="card-body mt-2 m-0 p-0">
      </div>
    </div> -->
  </section>
</div>