<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<?php if(isset($page_title)):?>
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?=$this->Dictionary->GetKeyword($page_title);?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>"><?=$this->Dictionary->GetKeyword('Home');?></a></li>
              <li class="breadcrumb-item active"><?=$this->Dictionary->GetKeyword($page_title);?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
	<?php endif;?>
    
<div class="content">
        <div class="card">
        <div class="card-header">
          <h3 class="card-title" dir='rtl'><?=$this->Dictionary->GetKeyword($page_card_title);?></h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <!-- <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button> -->
          </div>
        </div>
        <div class="card-body p-2 row">
          <div class="col-md-3 p-2">
              <button type="button" class="btn btn-primary" onclick="OpenTree('government_departments','','','-1','listTree');" ><i class="fa fa-tree" aria-hidden="true"></i> <?=$this->Dictionary->GetKeyword('government_departments_tree')?></button><br>
              <button type="button" class="btn btn-primary mt-4" onclick="OpenTree('locations','','','-1','listTree');" ><i class="fa fa-tree" aria-hidden="true"></i> <?=$this->Dictionary->GetKeyword('locations_tree')?></button>
            </div>
            <div class="col-md-9" id="listTree" style="border: 1px solid #999;">
            
            </div>
        </div>
        <!-- /.card-body -->
      </div>
            
            
                
</div>
</div>