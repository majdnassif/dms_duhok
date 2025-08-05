<?php if (isset($page_title)): ?>
  <div class="page-title">
    <h3><?= $this->Dictionary->GetKeyword($page_title); ?></h3>
    <div class="page-breadcrumb">
      <ol class="breadcrumb">
        <li><a href="<?= base_url(); ?>"><?= $this->Dictionary->GetKeyword('Home'); ?></a></li>
        <li class="active"><?=  $this->Dictionary->GetKeyword($page_title); ?></li>
      </ol>
    </div>
  </div>
<?php endif; ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-success">
        <div class="panel-heading">
          <h3 class="panel-title"><?= $this->Dictionary->GetKeyword('System Settings'); ?></h3>
        </div>
        <div class="panel-body">
          <div class="row">
            <?php foreach ($tables as $table_name => $config): ?>
              <div class="col-md-4 col-sm-6 mb-4">
                <div class="card">
                  <div class="card-body text-center">
                    <h4 class="card-title"><?= $config['title']; ?></h4>
                    <p class="card-text">
                      <?= $this->Dictionary->GetKeyword('Manage'); ?> <?= strtolower($config['title']); ?> 
                      <?= $this->Dictionary->GetKeyword('settings for your system'); ?>.
                    </p>
                    <a href="<?= base_url('Settings/listItems/' . $table_name); ?>" class="btn btn-primary">
                      <i class="fa fa-cog"></i> <?= $this->Dictionary->GetKeyword('Manage'); ?>
                    </a>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.card {
  border: 1px solid #ddd;
  border-radius: 4px;
  padding: 15px;
  height: 100%;
  margin-bottom: 20px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  transition: all 0.3s ease;
}
.card:hover {
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
  transform: translateY(-5px);
}
.card-title {
  font-weight: 600;
  margin-bottom: 15px;
}
.mb-4 {
  margin-bottom: 1.5rem;
}
</style> 