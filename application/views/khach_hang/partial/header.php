<header class="bg-white header header-md navbar navbar-fixed-top-xs box-shadow">
      <div class="navbar-header aside-md dk">
        <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen" data-target="#nav">
          <i class="fa fa-bars"></i>
        </a>
        <a href="#" class="navbar-brand">
          <img src="<?php echo ASSETS_URL; ?>images/logo.png" class="m-r-sm" alt="scale">
          <span class="hidden-nav-xs">Khách hàng</span>
        </a>
        <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".user">
          <i class="fa fa-cog"></i>
        </a>
      </div>    
      <form action="<?php echo site_url('khach_hang/tim_kiem'); ?>" method="get" class="navbar-form navbar-left input-s-lg m-t m-l-n-xs hidden-xs" role="search">
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-btn">
              <button type="submit" class="btn btn-sm bg-white b-white btn-icon"><i class="fa fa-search"></i></button>
            </span>
            <input type="text" name="s" class="form-control input-sm no-border" placeholder="Mã đơn hàng, điện thoại...">            
          </div>
        </div>
      </form>
      <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user user">        
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <span class="thumb-sm avatar pull-left">
              <img src="<?php echo ASSETS_URL; ?>images/a0.png" alt="...">
            </span>
            <?php echo $_SESSION['login_info']['ten']; ?> <b class="caret"></b>
          </a>
          <ul class="dropdown-menu animated fadeInRight">            
            <li>
              <span class="arrow top"></span>
              <a href="<?php echo site_url('khach_hang/cau_hinh'); ?>">Thiết lập tài khoản</a>
            </li>                               
            <li class="divider"></li>
            <li>
              <a href="<?php echo site_url('khach_hang/logout'); ?>">Đăng xuất</a>
            </li>
          </ul>
        </li>
      </ul>      
    </header>