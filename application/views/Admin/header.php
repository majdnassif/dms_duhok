<?php 
$class=strtolower($this->router->fetch_class());
$method=strtolower($this->router->fetch_method());
$user =$this->session->userdata('user_login_data');
$sidebar_collapse='';
if($this->session->userdata('sidebar-collapse')){
  $sidebar_collapse='sidebar-collapse';
  $sidebar_collapse_nextvalue=0;
}else{
  
  $sidebar_collapse_nextvalue=1;
}
?>
        
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="<?=sys_info()['logo']?>" type="image/jpg" sizes="16x16"/>
  <title><?=sys_info()['title']?> | <?=$this->router->fetch_method()?></title>
  
	 <link rel="stylesheet" media="all" href="<?=base_url('assets/');?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" media="all" href="<?=base_url('assets/');?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" media="all" href="<?=base_url('assets/');?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" media="all" href="<?=base_url('assets/');?>plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" media="all" href="<?=base_url('assets/');?>dist/css/adminlte.css">
  
  <link rel="stylesheet"  href="<?=base_url('assets/');?>plugins/toastr/toastr.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?=base_url('assets/');?>plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?=base_url('assets/');?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <link rel="stylesheet" href="<?=base_url('assets/');?>plugins/bootstrap-treeview/bootstrap-treeview.min.css">
  <link rel="stylesheet" href="<?=base_url('assets/tree/tree.css');?>">
  <link rel="stylesheet" href="<?=base_url('assets/tree/tree_rtl.css');?>">
  
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?=base_url('assets/');?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="<?=base_url('assets/');?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="<?=base_url('assets/');?>plugins/bootstrap-datepicker/css/bootstrap-datepicker3.standalone.min.css">
  <link rel="stylesheet" href="<?=base_url('assets/');?>dist/Leaflet/leaflet.css"/>
<link rel="stylesheet" href="<?=base_url('assets/');?>dist/Leaflet.markercluster/MarkerCluster.css" />
	<link rel="stylesheet" href="<?=base_url('assets/');?>dist/Leaflet.markercluster/MarkerCluster.Default.css" />
  <!-- C:\xampp\htdocs\ozcan\assets\plugins\jquery-ui\jquery-ui.min.css -->
  <link rel="stylesheet" href="<?=base_url('assets/');?>plugins/jquery-ui/jquery-ui.css?v=2">
<script src="<?=base_url('assets/');?>plugins/jquery/jquery.min.js"></script>

<script src="<?=base_url('assets/');?>dist/js/apexcharts.min.js"></script>
  <?php  if(isset($output)){
		foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php  endforeach; 
} ?>
<style>
  .pop{
    cursor: pointer;
  }
  .rtl{
    direction: rtl !important;
  }
  .for-print{display: none;}
	.panel-footer{
		text-align: center !important;
	}
	div.dataTables_wrapper div.dataTables_paginate ul.pagination {
    /* margin: 2px 0; */
    justify-content: center!important;
    /* white-space: nowrap; */
}
@media print {
  .for-print{display: block;}
  .card-tools{display: none;}
  .main-footer{display: none;}
  .dataTables_paginate{display: none;}
  .btn-print{display: none;}
  .card-title{color:black;}
  .dataTables_length {display: none;}.dataTables_filter{display: none;}.dataTables_info{display: none;}
  .odd {background-color: rgba(0,0,0,.05) !important;}
  .rm-print{display: none;}
}
.fc .fc-daygrid-day-frame {
    position: relative;
    min-height: 100px !important;
    max-height: 100px !important;
}
.fc-day-other{
    background-color: #f1f1f1;
}
.fc-h-event .fc-event-title-container {

    font-size: 25px;
    text-align: center;
}

</style> 

<link rel="stylesheet" href="<?=base_url('assets/')?>plugins/fullcalendar/main.css">
<?php if($this->UserModel->language()!="ENGLISH"){?>
<link rel="stylesheet" media="all" href="<?=base_url('assets/');?>dist/css/custom-rtl.css?v=1">
  <?php }?>
  <style>
      *::-webkit-scrollbar {
    width: 8px;
    background-color: #F5F5F5;
}

*::-webkit-scrollbar-thumb {
    box-shadow: inset 0 0 6px rgb(0 0 0 / 10%);
    border-radius: 10px;
    -webkit-box-shadow: inset 0 0 6px rgb(0 0 0 / 10%);
    background-color: #82B1FF;
}
*::-webkit-scrollbar-track {
    box-shadow: inset 0 0 6px rgb(0 0 0 / 10%);
    -webkit-box-shadow: inset 0 0 6px rgb(0 0 0 / 10%);
    background-color: #F5F5F5;
    border-radius: 10px;
}
.nav-sidebar .nav-treeview{
  background-color: #494e53 !important;
}
  </style>
</head><!-- dark-mode -->
<body class="hold-transition sidebar-mini  <?=$sidebar_collapse;?> layout-fixed ">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake rounded-circle" src="<?=sys_info()['logo'];?>" alt="<?=sys_info()['name'];?>Logo" height="80" width="80">
  </div>
	  <!-- Navbar -->
	  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
       <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" onclick="$.get('<?=base_url('Admin/AjaxSidebarCollapse/'.$sidebar_collapse_nextvalue)?>')" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <?php if($this->Permission->CheckPermissionOperation('orders_new')):?>
       <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" title="<?=$this->Dictionary->GetKeyword('add order')?>" data-target="#extra-modal" onclick="AddNewOrder()" role="button"><i class="fas fa-cart-plus"></i></a>
      </li>
      <?php endif;?>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav <?php if($this->UserModel->language()=="ENGLISH"){echo "ml-auto";}else{echo "mr-auto";}?>">
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i id="lang" class="fa fa-language"></i> <?= ucwords(strtolower($this->UserModel->language()))?>
        </a>
        <div id="lang_list" class="dropdown-menu dropdown-menu-right">
          <script>
          function changeLanguage(langKey) {
            $.get(base_url + 'Admin/AjaxChangeLang/' + langKey, {
              success: function(data) {
                setTimeout(function() {
                  location.reload();
                }, 500);
              }
            });
          }
          </script>
          <?php foreach(lang_array() as $key=>$value):?>
          <?php if($this->UserModel->language() != $key):?>
          <a href="#" onclick="changeLanguage('<?=$key?>')" class="dropdown-item dropdown-footer"><?=$value?></a>
          <?php endif?>
          <?php endforeach?>
        </div>
      </li>
      <?php if($this->Permission->CheckPermissionOperation('user_editprofile')):?>
      <li class="nav-item">
        <a class="nav-link" onclick="EditUserProfile()" href="#" title="<?= $this->Dictionary->GetKeyword("edit Profile")?>">
          <i class="fas fa-user-edit"></i> 
        </a>
      </li>
      <?php endif?>
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span id="nt_count" class="badge badge-success navbar-badge">0</span>
        </a>
        <div id="nt_list" class="dropdown-menu dropdown-menu-right">
        </div>
      </li>
	<li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button" title='Full Screen'>
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="<?=base_url('admin/logout')?>" title='Logout'>
          <i class="fas fa-sign-out-alt"></i>
        </a>
      </li>
      
      <!-- <li class="nav-item" role="button">
        <button href="#" class=" btn-sm btn-danger ">Logout</button>
      </li> -->
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar  main-sidebar-custom sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=base_url('admin/index');?>" class="brand-link">
      <img src="<?=sys_info()['logo'];?>" alt="<?=sys_info()['name'];?>" class="brand-image bg-white img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"><?=sys_info()['name']?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <?php if(isset($user['user_picture']) && $user['user_picture']):?>
          <img src="<?=base_url('assets/uploads/users/');?><?=$user['user_picture']?>" class="img-circle elevation-2" alt="User Image">
          <?php else:?>
            
          <img src="<?=base_url('assets/uploads/users/');?>blank.png" class="img-circle elevation-2" alt="User Image">
            <?php endif;?>
        </div>
        <div class="info">
          <a href="#" class="d-block"><?=$user['name']?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <?php $this->load->view('Admin/menu',['class'=>$class,'method'=>$method])?>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
    <div class="sidebar-custom">
      <a href="https://midyatech.com/" target="_blank" rel="noopener noreferrer">
        <img class="img-fluid" src="<?=sys_info()['sidebar_footer']?>" alt=""></a>
    </div>
  </aside>
  
  <?php if($this->Permission->CheckPermissionOperation('user_editprofile')):?>
  <script>
    function EditUserProfile(){
      
      $('#extra-modal').modal('show');
      $( "#extra-section").html('<div class="modal-content" style="border-radius: 20px;" id="edit-section"><div class="modal-header"><h3 class="modal-title">Loading</h3><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body text-center"><div class="text-primary"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading Please Wait...</div></div></div>');
                $.get( '<?=base_url('User/EditProfile/')?>', function( data ) {
                  $( "#extra-section").html( data );
                  
                });
    }
  </script>
  <?php endif?>