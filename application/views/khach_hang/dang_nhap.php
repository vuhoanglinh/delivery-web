<!DOCTYPE html>
<html lang="en" class="app">
<head>  
  <meta charset="utf-8" />
  <title>Đăng Nhập</title>
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
  <script language="javascript">
	window.fbAsyncInit = function () {
	  FB.init({
		appId: '1420355971604779',
		status: true,
		cookie: true,
		xfbml: true
	  });
	};

	(function (doc) {
	  var js;
	  var id = 'facebook-jssdk';
	  var ref = doc.getElementsByTagName('script')[0];
	  if (doc.getElementById(id)) {
		return;
	  }
	  js = doc.createElement('script');
	  js.id = id;
	  js.async = true;
	  js.src = "//connect.facebook.net/en_US/all.js";
	  ref.parentNode.insertBefore(js, ref);
	}(document));
	function Login() {		
	  FB.login(function (response) {
		if (response.authResponse) {
			 FB.api('/me', function (response) {
				document.getElementById("ten_fb").value = response.name;				
				document.getElementById("email_fb").value = response.email;	
				document.getElementById("form_login_fb").submit();
			  });
		} else {
		  alert("Login attempt failed!");
		}
	  }, { scope: 'email' });

	}
  </script>
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
      <a class="navbar-brand block" href="javascript:void(0)">Đăng Nhập</a>
      <section class="m-b-lg">      
        <form method="post" action="<?php echo base_url('khach_hang/submit_log'); ?>">
          <div class="list-group">
            <div class="list-group-item">
              <input name="email" type="email" data-required="true" placeholder="Email" class="form-control no-border">
            </div>
            <div class="list-group-item">
               <input name="mat_khau" type="password" data-required="true" placeholder="Mật khẩu" class="form-control no-border">
            </div>
          </div>
          <button type="submit" class="btn btn-lg btn-primary btn-block">Đăng nhập</button>
		  <span onclick="Login()" class="btn btn-lg btn-primary btn-block"><i class="fa fa-facebook-square"></i>&nbsp; Đăng nhập với facebook</span>
          <div class="text-center m-t m-b"><a href="#"><small>Quên mật khẩu?</small></a></div>
          <div class="line line-dashed"></div>
          <p class="text-muted text-center"><small>Bạn chưa có tài khoản?</small></p>
          <a href="<?php echo base_url('khach_hang/register'); ?>" class="btn btn-lg btn-default btn-block">Đăng ký thành viên</a>
        </form>
      </section>
    </div>
  </section>
  <!-- form hidden login facebook -->
  <form method="post" id="form_login_fb" action="<?php echo site_url('khach_hang/login_facebook'); ?>">
	<input type="hidden" name="ten" id="ten_fb"  />
	<input type="hidden" name="email" id="email_fb" />	
  </form>
  <!-- form hidden login facebook - end -->
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