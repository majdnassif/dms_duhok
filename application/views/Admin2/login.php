<!DOCTYPE html>
<html>
    <head>
        
        <!-- Title -->
        <title><?=sys_info()['title']?> | Login</title>
        
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta charset="UTF-8">
        <meta name="description" content="Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Steelcoders" />
        
        <!-- Styles -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
        <link href="<?=base_url('assets/admin2/')?>plugins/pace-master/themes/blue/pace-theme-flash.css" rel="stylesheet"/>
        <link href="<?=base_url('assets/admin2/')?>plugins/uniform/css/uniform.default.min.css" rel="stylesheet"/>
        <link href="<?=base_url('assets/admin2/')?>plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?=base_url('assets/admin2/')?>plugins/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="<?=base_url('assets/admin2/')?>plugins/line-icons/simple-line-icons.css" rel="stylesheet" type="text/css"/>	
        <link href="<?=base_url('assets/admin2/')?>plugins/offcanvasmenueffects/css/menu_cornerbox.css" rel="stylesheet" type="text/css"/>	
        <link href="<?=base_url('assets/admin2/')?>plugins/waves/waves.min.css" rel="stylesheet" type="text/css"/>	
        <link href="<?=base_url('assets/admin2/')?>plugins/switchery/switchery.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?=base_url('assets/admin2/')?>plugins/3d-bold-navigation/css/style.css" rel="stylesheet" type="text/css"/>	
        
        <!-- Theme Styles -->
        <link href="<?=base_url('assets/admin2/')?>css/modern.css" rel="stylesheet" type="text/css"/>
        <link href="<?=base_url('assets/admin2/')?>css/themes/green.css" class="theme-color" rel="stylesheet" type="text/css"/>
        <link href="<?=base_url('assets/admin2/')?>css/custom.css" rel="stylesheet" type="text/css"/>
        
        <script src="<?=base_url('assets/admin2/')?>plugins/3d-bold-navigation/js/modernizr.js"></script>
        <script src="<?=base_url('assets/admin2/')?>plugins/offcanvasmenueffects/js/snap.svg-min.js"></script>
        
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        
    </head>
    <body class="page-login">
        <main class="page-content">
            <div class="page-inner">
                <div id="main-wrapper">
                    <div class="row">
                        <div class="col-md-3 center">
                            <div class="login-box">
                                <a href="<?=base_url();?>" class="logo-name text-lg text-center"><?=sys_info()['name']?></a>
                                <!-- <p class="text-center m-t-md">Please login into your account.</p> -->
                                <form class="m-t-md" action="<?=base_url('admin/login');?>" method="post">
                                    <div class="form-group">
                                        <input type="text" name="username" class="form-control" placeholder="Username" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                                    </div>
                                    <?php if(isset($message)):?>
                                        <div class="alert alert-danger"><?=$message;?></div>
                                    <?php endif;?>
                                    <button type="submit" class="btn btn-success btn-block">Login</button>
                                </form>

                                <img style="margin-top: 20px;" class="img-fluid" src="<?=sys_info()['login_logo']?>" alt="">
                            </div>
                        </div>
                    </div><!-- Row -->
                </div><!-- Main Wrapper -->
            </div><!-- Page Inner -->
                </div><!-- Main Wrapper -->
            </div><!-- Page Inner -->
        </main><!-- Page Content -->
	

        <!-- Javascripts -->
        <script src="<?=base_url('assets/admin2/')?>plugins/jquery/jquery-2.1.4.min.js"></script>
        <script src="<?=base_url('assets/admin2/')?>plugins/jquery-ui/jquery-ui.min.js"></script>
        <script src="<?=base_url('assets/admin2/')?>plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="<?=base_url('assets/admin2/')?>plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?=base_url('assets/admin2/')?>plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="<?=base_url('assets/admin2/')?>plugins/switchery/switchery.min.js"></script>
        <script src="<?=base_url('assets/admin2/')?>plugins/uniform/jquery.uniform.min.js"></script>
        <script src="<?=base_url('assets/admin2/')?>plugins/offcanvasmenueffects/js/classie.js"></script>
        <script src="<?=base_url('assets/admin2/')?>plugins/waves/waves.min.js"></script>
        <script src="<?=base_url('assets/admin2/')?>js/modern.min.js"></script>
        
    </body>
</html>