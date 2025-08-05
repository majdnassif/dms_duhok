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
<div id="main-wrapper">
  <?php if (isset($output)): ?>
    <div class="row">
      <?= $output ?>
      <?php if (isset($back)): ?>
        <div class=" m-4 text-left">
          <a class="btn btn-warning" href='<?= $back['url'] ?>'><strong><?= $back['title'] ?></strong></a>
        </div>
      <?php endif; ?>
    </div><!-- Row -->
  <?php endif; ?>
</div><!-- Main Wrapper -->