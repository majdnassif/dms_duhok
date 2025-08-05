  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<?php if(isset($page_title)):?>
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?=$page_title;?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item active"><?=$page_title;?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
	<?php endif;?>

    <!-- Main content -->
	<?php if(isset($output)):?>
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title" dir='rtl'><?=$page_card_title;?></h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <!-- <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button> -->
          </div>
        </div>
        <div class="card-body p-0">
          

          
          <?php if(isset($output)){echo $output;}?>
          <?php if(isset($back)):?>
          <div class=" m-4 text-left">
            <a class="btn btn-warning" href='<?=$back['url']?>' ><strong><?=$back['title']?></strong></a>
          </div>
          <?php endif;?>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </section>
	<?php endif;?>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



