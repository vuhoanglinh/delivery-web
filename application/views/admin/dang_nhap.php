<!DOCTYPE html>
<html lang="en" class="app">
<head>  
  <meta charset="utf-8" />
  <title>Đăng Nhập Quản Trị</title>
  <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
  <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/animate.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/icon.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/font.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/app.css" type="text/css" />  
    <!--[if lt IE 9]>
    <script src="js/ie/html5shiv.js"></script>
    <script src="js/ie/respond.min.js"></script>
    <script src="js/ie/excanvas.js"></script>
  <![endif]-->
</head>
<body class="">
  <section id="content" class="m-t-lg wrapper-md animated fadeInUp">    
	  <?php if(isset($_SESSION['error']) && $_SESSION['error'] != ''){ ?>
	  <div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<!-- Noi dung -->
		<?php echo $_SESSION['error'];?>
	  </div>
	  <?php 
		unset($_SESSION['error']);
	  } ?>
	  <?php if(isset($_SESSION['success']) && $_SESSION['success'] != ''){ ?>
	  <div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<!-- Noi dung -->
		<?php echo $_SESSION['success'];?>
	  </div>
	  <?php 
		unset($_SESSION['success']);
	  } ?>	  
    <div class="container aside-xl">
      <a class="navbar-brand block" href="javascript:void(0)">Đăng Nhập Quản Trị</a>
      <section class="m-b-lg">      
        <form method="post" action="<?php echo base_url('admin/submit_log'); ?>">
          <div class="list-group">
            <div class="list-group-item">
              <input name="email" type="email" placeholder="Email" class="form-control no-border">
            </div>
            <div class="list-group-item">
               <input name="mat_khau" type="password" placeholder="Mật khẩu" class="form-control no-border">
            </div>
          </div>
          <button type="submit" class="btn btn-lg btn-primary btn-block">Đăng nhập</button>                   
        </form>
      </section>
    </div>
  </section>
  <!-- footer -->
  <footer id="footer">
    <div class="text-center padder">
      <p>
        <small>&copy; 2015</small>
      </p>
    </div>
  </footer>
  <!-- / footer -->
  <script src="<?php echo ASSETS_URL; ?>js/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="<?php echo ASSETS_URL; ?>js/bootstrap.js"></script>
  <!-- App -->
  <script src="<?php echo ASSETS_URL; ?>js/app.js"></script>  
  <script src="<?php echo ASSETS_URL; ?>js/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo ASSETS_URL; ?>js/app.plugin.js"></script>
</body>
</html>