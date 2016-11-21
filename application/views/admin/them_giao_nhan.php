<body class="">
  <section class="vbox">
    <!-- .Header -->
	<?php  $this->load->view('admin/partial/header'); ?>
	<!-- /.Header -->
    <section>
      <section class="hbox stretch">
        <!-- .aside -->       
        <?php  $this->load->view('admin/partial/sidebar'); ?>        
        <!-- /.aside -->
        <section id="content">
          <section class="vbox">
            <section class="scrollable padder">
              <div class="m-b-md">
                <h3 class="m-b-none">Thêm mới giao nhận</h3>
              </div>
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
              <div class="row">                
                <div class="col-sm-12">
                  <form data-validate="parsley" method="post" action="<?php echo site_url('admin/submit_them_giao_nhan'); ?>">
                    <section class="panel panel-default">                     
                      <div class="panel-body">  
						  <div class="form-group pull-in clearfix">
                            <div class="col-sm-6">
                              <label>Tên</label>
                              <input type="text" name="ten" class="form-control" placeholder="Tên" data-required="true" value="<?php if(isset($admin) && $admin['ten'] != ''){ echo $admin['ten']; } ?>">
                            </div>
                            <div class="col-sm-6">
                              <label>Email</label>
                              <input type="email"  name="email" class="form-control" placeholder="Email" data-required="true" value="<?php if(isset($admin) && $admin['email'] != ''){ echo $admin['email']; } ?>">
                            </div>
                          </div>	
						  <div class="form-group pull-in clearfix">
                            <div class="col-sm-6">
                              <label>Password</label>
                              <input type="password" name="mat_khau" class="form-control" placeholder="Password" data-required="true" value="<?php if(isset($admin) && $admin['ten'] != ''){ echo $admin['ten']; } ?>">
                            </div>
                            <div class="col-sm-6">
                              <label>Re-Password</label>
                              <input type="password"  name="re_mat_khau" class="form-control" placeholder="Re-Password" data-required="true" value="<?php if(isset($admin) && $admin['email'] != ''){ echo $admin['email']; } ?>">
                            </div>
                          </div>						  
						  <div class="form-group pull-in clearfix">
                            <div class="col-sm-6">
                              <label>Điện thoại </label>
                              <input type="text" name="dien_thoai" data-required="true" class="form-control" placeholder="Điện thoại" value="<?php if(isset($admin) && $admin['dien_thoai'] != ''){ echo $admin['dien_thoai']; } ?>">
                            </div>                            
                          </div>
                          <div class="form-group">
                            <label>Địa chỉ</label>
                            <input type="text" name="dia_chi"  data-required="true" class="form-control" placeholder="Địa chỉ" value="<?php if(isset($admin) && $admin['dia_chi'] != ''){ echo $admin['dia_chi']; } ?>">
                          </div>
						  <div class="form-group pull-in clearfix">
                            <div class="col-sm-6">
								<label>Tỉnh/Thành phố</label>
								<select name="tinh_tp" class="form-control">                            
									<option  value="">Chọn Tỉnh/Thành phố</option>
									<option  value="HCM">Hồ Chí Minh</option>
									<option  value="DN">Đà Nẵng</option>
									<option  value="HN">Hà Nội</option>									                                    
								</select>
                            </div>
                            <div class="col-sm-6">
								<label>Quận/Huyện</label>
								<select name="quan_huyen" class="form-control">                           
									<option value="">Chọn Quận/Huyện</option>
									<option  value="Quan 1">Quận 1</option>
									<option  value="Quan 2">Quận 2</option>                          									
									<option  value="Quan 3">Quận 3</option>
									<option  value="Quan 4">Quận 4</option>                          									
									<option  value="Quan 5">Quận 5</option>
									<option  value="Quan 6">Quận 6</option>                          									
									<option  value="Quan 7">Quận 7</option>
									<option  value="Quan 8">Quận 8</option>                          									
									<option  value="Quan 9">Quận 9</option>
									<option  value="Quan 10">Quận 10</option>                          									
									<option  value="Quan 11">Quận 11</option>								
									<option  value="Quan 12">Quận 12</option>
									<option  value="Binh Thanh">Bình Thạnh</option>
									<option  value="Tan Phu">Tân Phú</option>                          									
									<option  value="Go Vap">Gò Vấp</option>						
									<option  value="Tan Binh">Tân Bình</option>									
								</select>
                            </div>
                          </div>                         
                      </div>
                      <footer class="panel-footer text-right bg-light lter">
                        <button type="submit" class="btn btn-success btn-s-xs">Thêm mới</button>
                      </footer>
                    </section>
                  </form>
                </div>				
              </div>              
            </section>
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
        </section>
      </section>
    </section>
  </section>
  <!-- .Footer -->
  <?php $this->load->view('admin/partial/footer'); ?>
  <!-- /.Footer -->
</body>
</html>