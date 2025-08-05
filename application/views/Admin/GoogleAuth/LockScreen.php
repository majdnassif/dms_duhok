<?php 
$user =$this->session->userdata('user_login_data');
?>

<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Lockscreen</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url('assets/')?>plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url('assets/')?>dist/css/adminlte.min.css">
</head>
<body class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
      <img src="<?=sys_info()['logo'];?>" width="100" alt="<?=sys_info()['name'];?>" class="brand-image bg-white img-circle elevation-3" style="opacity: .8">
      <!-- <span class="brand-text font-weight-light"><?=sys_info()['name']?></span> -->
  </div>
  <!-- User name -->
  <div class="lockscreen-name"><?=$user['name']?></div>

  <!-- START LOCK SCREEN ITEM -->
  <div class="lockscreen-item">
    <!-- lockscreen image -->
    <div class="lockscreen-image">
    <?php if(isset($user['user_picture']) && $user['user_picture']):?>
          <img src="<?=base_url('assets/uploads/users/');?><?=$user['user_picture']?>" class="img-circle elevation-2" alt="User Image">
          <?php else:?>
            
          <img src="<?=base_url('assets/uploads/users/');?>blank.png" alt="User Image">
            <?php endif;?>
    </div>
    <!-- /.lockscreen-image -->

    <!-- lockscreen credentials (contains the form) -->
    <form class="lockscreen-credentials" method="POST">
      <div class="input-group">
        <input type="code" class="form-control" name="code" placeholder="code">

        <div class="input-group-append">
          <button type="submit" class="btn">
            <i class="fas fa-arrow-right text-muted"></i>
          </button>
        </div>
      </div>
    </form>
    <!-- /.lockscreen credentials -->

  </div>
  <?php if(isset($message)):?>
  <div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-ban"></i></h5>
    <?=$message?>
  </div>
  <?php endif;?>
  <!-- /.lockscreen-item -->
  <div class="help-block text-center">
    Enter your Google Code to retrieve your session
  </div>
  <div class="text-center">
    <a href="<?=base_url('Admin/logout')?>">Or sign in as a different user</a>
  </div>
 <!--  <div class="lockscreen-footer text-center">
    Copyright &copy; 2014-2021 <b><a href="https://adminlte.io" class="text-black">AdminLTE.io</a></b><br>
    All rights reserved
  </div> -->
</div>
<!-- /.center -->

<!-- jQuery -->
<script src="<?=base_url('assets/')?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url('assets/')?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
