<!DOCTYPE html>
<html lang="en" class="app">
<head>  
  <meta charset="utf-8" />
  <title>Bổ sung thêm thông tin</title>
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
  <section id="content" class="m-t-lg wrapper-md animated fadeInDown">
    <div class="container aside-xl">	  
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
      <a class="navbar-brand block" href="javascript:void(0)">Vui lòng bổ sung thêm thông tin</a>
      <section class="m-b-lg">       
        <form method="post" action="<?php echo site_url('khach_hang/submit_bo_sung_thong_tin'); ?>">
          <div class="list-group">
            <div class="list-group-item">
              <input name="ten" placeholder="Tên" data-required="true" value="<?php if(isset($_SESSION['data_fb']) && !empty($_SESSION['data_fb']['ten'])){ echo $_SESSION['data_fb']['ten']; } ?>" class="form-control no-border">
            </div>
            <div class="list-group-item">
              <input name="email" type="email" data-required="true" value="<?php if(isset($_SESSION['data_fb']) && !empty($_SESSION['data_fb']['email'])){ echo $_SESSION['data_fb']['email']; } ?>"  placeholder="Email" class="form-control no-border">
            </div>
            <div class="list-group-item">
               <input name="mat_khau" type="password" data-required="true" placeholder="Mật khẩu" class="form-control no-border">
            </div>
			<div class="list-group-item">
               <input name="re_mat_khau" type="password" data-required="true" placeholder="Nhập lại mật khẩu" class="form-control no-border">
            </div>
			 <div class="list-group-item">
              <input name="dia_chi" placeholder="Địa chỉ" data-required="true" value="<?php if(isset($_SESSION['data_fb']) && !empty($_SESSION['data_fb']['dia_chi'])){ echo $_SESSION['data_fb']['dia_chi']; } ?>" class="form-control no-border">
            </div>
			 <div class="list-group-item">
              <input name="dien_thoai" placeholder="Điện thoại" data-required="true" value="<?php if(isset($_SESSION['data_fb']) && !empty($_SESSION['data_fb']['dien_thoai'])){ echo $_SESSION['data_fb']['dien_thoai']; } ?>" class="form-control no-border">
            </div>
          </div>        
          <button type="submit" class="btn btn-lg btn-primary btn-block">Lưu</button>            
        </form>
      </section>
    </div>
  </section>
  <!-- footer -->
  <footer id="footer">
    <div class="text-center padder clearfix">
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