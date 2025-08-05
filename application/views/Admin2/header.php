<?php
$class=strtolower($this->router->fetch_class());
$method=strtolower($this->router->fetch_method());
$user =$this->session->userdata('user_login_data');
$sidebar_collapse='';
if($this->session->userdata('sidebar-collapse')){
  $sidebar_collapse='small-sidebar';
  $sidebar_collapse_nextvalue=0;
}else{

  $sidebar_collapse_nextvalue=1;
}
?>
<!-- new theme -->
  <!DOCTYPE html>
<html>
    <head>

        <!-- Title -->
        <link rel="icon" href="<?=sys_info()['logo']?>" type="image/jpg" sizes="16x16"/>
        <title><?=sys_info()['title']?> | <?=$this->router->fetch_method()?></title>

        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta charset="UTF-8">
        <meta name="description" content="Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Steelcoders" />
        <script src="<?=base_url('assets/admin2/')?>plugins/jquery/jquery-2.1.4.min.js"></script>
        <!-- Styles -->
        <link href="<?=base_url('assets/admin2/');?>plugins/uniform/css/uniform.default.min.css" rel="stylesheet"/>
        <link href="<?=base_url('assets/admin2/');?>plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?=base_url('assets/admin2/');?>plugins/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="<?=base_url('assets/admin2/');?>plugins/line-icons/simple-line-icons.css" rel="stylesheet" type="text/css"/>
        <link href="<?=base_url('assets/admin2/');?>plugins/offcanvasmenueffects/css/menu_cornerbox.css" rel="stylesheet" type="text/css"/>
        <link href="<?=base_url('assets/admin2/');?>plugins/waves/waves.min.css" rel="stylesheet" type="text/css"/>
        <!-- <link href="<?=base_url('assets/admin2/');?>plugins/switchery/switchery.min.css" rel="stylesheet" type="text/css"/> -->
        <!-- <link href="<?=base_url('assets/admin2/');?>plugins/3d-bold-navigation/css/style.css" rel="stylesheet" type="text/css"/> -->
        <link href="<?=base_url('assets/admin2/');?>plugins/slidepushmenus/css/component.css" rel="stylesheet" type="text/css"/>

        <!-- Theme Styles -->
        <link href="<?=base_url('assets/admin2/');?>css/modern.css" rel="stylesheet" type="text/css"/>
        <link href="<?=base_url('assets/admin2/');?>css/themes/green.css" class="theme-color" rel="stylesheet" type="text/css"/>
        <link href="<?=base_url('assets/admin2/');?>css/custom.css" rel="stylesheet" type="text/css"/>

        <link rel="stylesheet" href="<?=base_url('assets/admin2/');?>plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="<?=base_url('assets/');?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
        <link rel="stylesheet" href="<?=base_url('assets/tree/tree.css');?>">
        <link rel="stylesheet" href="<?=base_url('assets/tree/tree_rtl.css');?>">

        <?php if($this->UserModel->language()!="ENGLISH"){?>
           <link rel="stylesheet" media="all" href="<?=base_url('assets/');?>dist/css/custom-rtl.css?v=107">
         <?php }?>

        <link href="<?=base_url('assets/admin2/');?>plugins/toastr/toastr.min.css" rel="stylesheet" type="text/css"/>


        <link href="<?=base_url('assets/admin2/');?>plugins/datatables/css/jquery.datatables.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?=base_url('assets/admin2/');?>plugins/datatables/css/jquery.datatables_themeroller.css" rel="stylesheet" type="text/css"/>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script src="<?=base_url('assets/');?>dist/js/apexcharts.min.js"></script>

        <?php  if(isset($output)):?>
            <?php foreach($css_files as $file): ?>
                <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
            <?php endforeach; ?>
        <?php endif; ?>

        <style>
            p-1{
                padding: 0.5vh;
            }
            p-2{
                padding: 1vh;
            }
            p-3{
                padding: 1.5vh;
            }
            p-4{
                padding: 2vh;
            }
            /*.sidebar-fixed{*/
            /*    bottom: 0;*/
            /*    float: none;*/
            /*    left: 0;*/
            /*    position: fixed;*/
            /*    top: 0;*/
            /*}*/
            .sidebar-custom {
                height: 4rem;
                padding: .85rem .5rem;
                border-top: 1px solid #4f5962;
            }
            .img-fluid {
                max-width: 100%;
                height: auto;
            }

            .brand-link {
                display: block;
                font-size: 1.25rem;
                line-height: 1.5;
                padding: .8125rem .5rem;
                transition: width .3s ease-in-out;
                white-space: nowrap;

            }
            .brand-link .brand-image {
                float: left;
                line-height: .8;
                /*margin-left: .8rem;*/
                /*margin-right: .5rem;*/
                margin-top: 11px;
                max-height: 33px;
                width: auto;
            }
            .font-weight-light {
                font-weight: 300 !important;
            }

        </style>
    </head>
    <body class="page-header-fixed compact-menu <?=$sidebar_collapse;?>">

        <form class="search-form" action="#" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control search-input" placeholder="Search...">
                <span class="input-group-btn">
                    <button class="btn btn-default close-search waves-effect waves-button waves-classic" type="button"><i class="fa fa-times"></i></button>
                </span>
            </div>
        </form>
        <main class="page-content content-wrap" style="position: relative">

            <div class="navbar">
                <div class="navbar-inner">
                    <div class="sidebar-pusher">
                        <a href="javascript:void(0);" class="waves-effect waves-button waves-classic push-sidebar" onclick="$.get('<?=base_url('Admin/AjaxSidebarCollapse/'.$sidebar_collapse_nextvalue)?>')">
                            <i class="fa fa-bars"></i>
                        </a>
                    </div>
                    <div class="logo-box">
<!--                        <a href="--><?php //=base_url()?><!--" class="logo-text"><span>--><?php //=sys_info()['title']?><!--</span></a>-->
                            <a href="<?=base_url();?>" class="brand-link logo-text">
                              <img src="<?=sys_info()['gov_logo'];?>" alt="<?=sys_info()['name'];?>" class="brand-image bg-white img-circle elevation-3" style="opacity: .8">
                              <span class="brand-text font-weight-light"><?=sys_info()['title']?></span>
                            </a>

                    </div><!-- Logo Box -->
                    <div class="search-button">
                        <a href="javascript:void(0);" class="waves-effect waves-button waves-classic show-search"><i class="fa fa-search"></i></a>
                    </div>
                </div>

                <div class="topmenu-outer">
                        <div class="top-menu">
                            <ul class="nav navbar-nav navbar-left">
                                <li>
                                    <a href="javascript:void(0);" class="waves-effect waves-button waves-classic sidebar-toggle" onclick="$.get('<?=base_url('Admin/AjaxSidebarCollapse/'.$sidebar_collapse_nextvalue)?>')"><i class="fa fa-bars"></i></a>
                                </li>
                                <!-- <li>
                                    <a href="#cd-nav" class="waves-effect waves-button waves-classic cd-nav-trigger"><i class="fa fa-diamond"></i></a>
                                </li> -->
                                <li>
                                    <a href="javascript:void(0);" class="waves-effect waves-button waves-classic toggle-fullscreen"><i class="fa fa-expand"></i></a>
                                </li>
                                <!-- <li class="dropdown">
                                    <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown">
                                        <i class="fa fa-cogs"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-md dropdown-list theme-settings" role="menu">
                                        <li class="li-group">
                                            <ul class="list-unstyled">
                                                <li class="no-link" role="presentation">
                                                    Fixed Header
                                                    <div class="ios-switch pull-right switch-md">
                                                        <input type="checkbox" class="js-switch pull-right fixed-header-check" checked>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="li-group">
                                            <ul class="list-unstyled">
                                                <li class="no-link" role="presentation">
                                                    Fixed Sidebar
                                                    <div class="ios-switch pull-right switch-md">
                                                        <input type="checkbox" class="js-switch pull-right fixed-sidebar-check">
                                                    </div>
                                                </li>
                                                <li class="no-link" role="presentation">
                                                    Horizontal bar
                                                    <div class="ios-switch pull-right switch-md">
                                                        <input type="checkbox" class="js-switch pull-right horizontal-bar-check">
                                                    </div>
                                                </li>
                                                <li class="no-link" role="presentation">
                                                    Toggle Sidebar
                                                    <div class="ios-switch pull-right switch-md">
                                                        <input type="checkbox" class="js-switch pull-right toggle-sidebar-check">
                                                    </div>
                                                </li>
                                                <li class="no-link" role="presentation">
                                                    Compact Menu
                                                    <div class="ios-switch pull-right switch-md">
                                                        <input type="checkbox" class="js-switch pull-right compact-menu-check" checked>
                                                    </div>
                                                </li>
                                                <li class="no-link" role="presentation">
                                                    Hover Menu
                                                    <div class="ios-switch pull-right switch-md">
                                                        <input type="checkbox" class="js-switch pull-right hover-menu-check">
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="li-group">
                                            <ul class="list-unstyled">
                                                <li class="no-link" role="presentation">
                                                    Boxed Layout
                                                    <div class="ios-switch pull-right switch-md">
                                                        <input type="checkbox" class="js-switch pull-right boxed-layout-check">
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="li-group">
                                            <ul class="list-unstyled">
                                                <li class="no-link" role="presentation">
                                                    Choose Theme Color
                                                    <div class="color-switcher">
                                                        <a class="colorbox color-blue" href="?theme=blue" title="Blue Theme" data-css="blue"></a>
                                                        <a class="colorbox color-green" href="?theme=green" title="Green Theme" data-css="green"></a>
                                                        <a class="colorbox color-red" href="?theme=red" title="Red Theme" data-css="red"></a>
                                                        <a class="colorbox color-white" href="?theme=white" title="White Theme" data-css="white"></a>
                                                        <a class="colorbox color-purple" href="?theme=purple" title="purple Theme" data-css="purple"></a>
                                                        <a class="colorbox color-dark" href="?theme=dark" title="Dark Theme" data-css="dark"></a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="no-link"><button class="btn btn-default reset-options">Reset Options</button></li>
                                    </ul>
                                </li> -->
                            </ul>
                            <ul class="nav navbar-nav navbar-right">

                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown"><i class="fa fa-envelope"></i>
                                     <span id="nt_count" class="badge badge-success pull-right">0</span>
                                    </a>
                                    <ul class="dropdown-menu title-caret dropdown-lg"  role="menu">
                                        <li class="dropdown-menu-list slimscroll messages">
                                            <ul class="list-unstyled" id="nt_list">
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <?php if($this->Permission->CheckPermissionOperation('user_editprofile')):?>
                                  <li>
                                    <a class="waves-effect waves-button waves-classic" onclick="EditUserProfile()" href="#" title="<?= $this->Dictionary->GetKeyword("edit Profile")?>">
                                      <i class="fa fa-user"></i>
                                    </a>
                                  </li>
                                <?php endif?>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown">
                                        <span class="user-name"><i class="fa fa-language"></i> <?= ucwords(strtolower($this->UserModel->language()))?></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-list" role="menu">
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
                                            <li role="presentation"><a href="#" onclick="$.get('<?=base_url('Admin/AjaxChangeLang/'.$key)?>',{success:function(data){setTimeout(function(){location.reload();}, 500);}})" class="dropdown-item dropdown-footer"><?=$value?></a></li>
                                          <?php endif?>
                                        <?php endforeach?>
                                    </ul>
                                </li>
                                <li>
                                    <a href="<?=base_url('admin/logout')?>" class="log-out waves-effect waves-button waves-classic">
                                        <span><i class="fa fa-sign-out m-r-xs"></i></span>
                                    </a>
                                </li>
                            </ul><!-- Nav -->
                        </div><!-- Top Menu -->
                    </div>
                </div>
            </div>
            <!-- Navbar -->
            <div class="page-sidebar sidebar sidebar-fixed">
                <div class="page-sidebar-inner slimscroll">
                    <div class="sidebar-header">
                        <div class="sidebar-profile">
                            <a href="javascript:void(0);" id="profile-menu-link">
                                <div class="sidebar-profile-image">
                                    <?php if ($user['user_picture']): ?>
                                        <img src="<?=base_url('assets/uploads/users/');?><?=$user['user_picture']?>" class="img-circle img-responsive" alt="">
                                    <?php else: ?>
                                        <img src="<?=base_url('assets/uploads/users/blank.png');?>" class="img-circle img-responsive" alt="">
                                    <?php endif; ?>
                                </div>
                                <div class="sidebar-profile-details">
                                    <span><?=$user['name']?></span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php $this->load->view('Admin2/menu',['class'=>$class,'method'=>$method])?>

                </div><!-- Page Sidebar Inner -->

             <div class="sidebar-custom">
                      <a href="https://midyatech.com/" target="_blank" rel="noopener noreferrer">
                        <img class="img-fluid" src="<?=sys_info()['sidebar_footer']?>" alt="">
                      </a>
                    </div>
            </div><!-- Page Sidebar -->


            <div class="page-inner" style="position: relative">

               <div class="overlay">
                  <div class="overlay-content">
                      <div class="overlay-icon">
                          <i class="fa fa-spinner fa-spin"></i>
                      </div>
                      <div class="overlay-text">
                          Loading...
                      </div>
                  </div>

              </div>





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