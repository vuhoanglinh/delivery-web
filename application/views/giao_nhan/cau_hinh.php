<body class="">
  <section class="vbox">
    <!-- .Header -->
	<?php  $this->load->view('giao_nhan/partial/header'); ?>
	<!-- /.Header -->
    <section>
      <section class="hbox stretch">
        <!-- .aside -->       
        <?php  $this->load->view('giao_nhan/partial/sidebar'); ?>        
        <!-- /.aside -->
        <section id="content">
          <section class="vbox">
            <section class="scrollable padder">
              <div class="m-b-md">
                <h3 class="m-b-none">Thiết lập tài khoản</h3>
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
                  <form data-validate="parsley" method="post" action="<?php echo site_url('giao_nhan/submit_cau_hinh'); ?>">
                    <section class="panel panel-default">                     
                      <div class="panel-body">  
						  <div class="form-group pull-in clearfix">
                            <div class="col-sm-6">
                              <label>Tên</label>
                              <input type="text" name="ten" class="form-control" placeholder="Tên" data-required="true" value="<?php if(isset($giao_nhan) && $giao_nhan['ten'] != ''){ echo $giao_nhan['ten']; } ?>">
                            </div>
                            <div class="col-sm-6">
                              <label>Email</label>
                              <input type="email"  name="email" class="form-control" placeholder="Email" data-required="true" value="<?php if(isset($giao_nhan) && $giao_nhan['email'] != ''){ echo $giao_nhan['email']; } ?>">
                            </div>
                          </div>					  
						  <div class="form-group pull-in clearfix">
                            <div class="col-sm-6">
                              <label>Điện thoại </label>
                              <input type="text" name="dien_thoai" data-required="true" class="form-control" placeholder="Điện thoại" value="<?php if(isset($giao_nhan) && $giao_nhan['dien_thoai'] != ''){ echo $giao_nhan['dien_thoai']; } ?>">
                            </div>                            
                          </div>
                          <div class="form-group">
                            <label>Địa chỉ</label>
                            <input type="text" name="dia_chi"  data-required="true" class="form-control" placeholder="Địa chỉ" value="<?php if(isset($giao_nhan) && $giao_nhan['dia_chi'] != ''){ echo $giao_nhan['dia_chi']; } ?>">
                          </div>
						  <div class="form-group pull-in clearfix">
                            <div class="col-sm-6">
								<label>Tỉnh/Thành phố</label>
								<select name="tinh_tp" class="form-control">                            
									<option  value="">Chọn Tỉnh/Thành phố</option>
									<option <?php if(isset($giao_nhan) && $giao_nhan['khu_vuc'] == 'HCM'){ echo 'selected="selected"'; } ?> value="HCM">Hồ Chí Minh</option>
									<option <?php if(isset($giao_nhan) && $giao_nhan['khu_vuc'] == 'DN'){ echo 'selected="selected"'; } ?> value="DN">Đà Nẵng</option>
									<option <?php if(isset($giao_nhan) && $giao_nhan['khu_vuc'] == 'HN'){ echo 'selected="selected"'; } ?> value="HN">Hà Nội</option>									                                    
								</select>
                            </div>
                            <div class="col-sm-6">
								<label>Quận/Huyện</label>
								<select name="quan_huyen" class="form-control">                           
									<option value="">Chọn Quận/Huyện</option>
									<option <?php if(isset($giao_nhan) && $giao_nhan['quan_huyen'] == 'Quan 1'){ echo 'selected="selected"'; } ?> value="Quan 1">Quận 1</option>
									<option <?php if(isset($giao_nhan) && $giao_nhan['quan_huyen'] == 'Quan 2'){ echo 'selected="selected"'; } ?> value="Quan 2">Quận 2</option>                          									
									<option <?php if(isset($giao_nhan) && $giao_nhan['quan_huyen'] == 'Quan 3'){ echo 'selected="selected"'; } ?> value="Quan 3">Quận 3</option>
									<option <?php if(isset($giao_nhan) && $giao_nhan['quan_huyen'] == 'Quan 4'){ echo 'selected="selected"'; } ?> value="Quan 4">Quận 4</option>                          									
									<option <?php if(isset($giao_nhan) && $giao_nhan['quan_huyen'] == 'Quan 5'){ echo 'selected="selected"'; } ?> value="Quan 5">Quận 5</option>
									<option <?php if(isset($giao_nhan) && $giao_nhan['quan_huyen'] == 'Quan 6'){ echo 'selected="selected"'; } ?> value="Quan 6">Quận 6</option>                          									
									<option <?php if(isset($giao_nhan) && $giao_nhan['quan_huyen'] == 'Quan 7'){ echo 'selected="selected"'; } ?> value="Quan 7">Quận 7</option>
									<option <?php if(isset($giao_nhan) && $giao_nhan['quan_huyen'] == 'Quan 8'){ echo 'selected="selected"'; } ?> value="Quan 8">Quận 8</option>                          									
									<option <?php if(isset($giao_nhan) && $giao_nhan['quan_huyen'] == 'Quan 9'){ echo 'selected="selected"'; } ?> value="Quan 9">Quận 9</option>
									<option <?php if(isset($giao_nhan) && $giao_nhan['quan_huyen'] == 'Quan 10'){ echo 'selected="selected"'; } ?> value="Quan 10">Quận 10</option>                          									
									<option <?php if(isset($giao_nhan) && $giao_nhan['quan_huyen'] == 'Quan 11'){ echo 'selected="selected"'; } ?> value="Quan 11">Quận 11</option>								
									<option <?php if(isset($giao_nhan) && $giao_nhan['quan_huyen'] == 'Quan 12'){ echo 'selected="selected"'; } ?> value="Quan 12">Quận 12</option>
									<option <?php if(isset($giao_nhan) && $giao_nhan['quan_huyen'] == 'Binh Thanh'){ echo 'selected="selected"'; } ?> value="Binh Thanh">Bình Thạnh</option>
									<option <?php if(isset($giao_nhan) && $giao_nhan['quan_huyen'] == 'Tan Phu'){ echo 'selected="selected"'; } ?> value="Tan Phu">Tân Phú</option>                          									
									<option <?php if(isset($giao_nhan) && $giao_nhan['quan_huyen'] == 'Go Vap'){ echo 'selected="selected"'; } ?> value="Go Vap">Gò Vấp</option>						
									<option <?php if(isset($giao_nhan) && $giao_nhan['quan_huyen'] == 'Tan Binh'){ echo 'selected="selected"'; } ?> value="Tan Binh">Tân Bình</option>									
								</select>
                            </div>
                          </div>
                          <div class="form-group pull-in clearfix">
                            <div class="col-sm-6">
								<label>Password</label>
								<input type="text" name="password"   class="form-control" placeholder="Password mới" >
							</div>
							<div class="col-sm-6">
								<label>Nhập lại password</label>
								<input type="text" name="re_password"   class="form-control" placeholder="Nhập lại password mới" >
							</div>
                          </div>
						  
                      </div>
                      <footer class="panel-footer text-right bg-light lter">
                        <button type="submit" class="btn btn-success btn-s-xs">Cập nhật</button>
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
  <?php $this->load->view('giao_nhan/partial/footer'); ?>
  <!-- /.Footer -->
</body>
</html>