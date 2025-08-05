<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=sys_info()['title']?> | Login</title>
  <!-- add favicon icon -->
  <link rel="shortcut icon" href="<?=sys_info()['logo']?>" type="image/x-icon">
  <link rel="icon" href="<?=sys_info()['logo']?>" type="image/x-icon">
  
  <!-- Google Font: Source Sans Pro -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> -->
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">

<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="<?=base_url();?>" class="h1"><?=sys_info()['name']?></a>
      
    </div>
    <div class="card-body">

      <p class="login-box-msg">Sign in</p>

      <form action="<?=base_url('admin/login');?>" method="post">
        <div class="input-group mb-3">
          <input type="text" name="username" class="form-control" placeholder="Username" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
          <?php if(isset($message)):?>
				<div class="alert alert-danger"><?=$message;?></div>
          <?php endif;?>
          </div>
          <!-- /.col -->
          <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->
<div class="login-box mt-2 text-center">
  <img class="img-fluid" src="<?=sys_info()['login_logo']?>" alt="">
</div>
<!-- jQuery -->
<script src="<?=base_url('assets');?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url('assets');?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url('assets');?>/dist/js/adminlte.min.js"></script>
</body>
</html>
