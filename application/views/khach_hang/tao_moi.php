<body class="">
  <section class="vbox">
    <!-- .Header -->
	<?php  $this->load->view('khach_hang/partial/header'); ?>
	<!-- /.Header -->
    <section>
      <section class="hbox stretch">
        <!-- .Navigation -->
        <?php  $this->load->view('khach_hang/partial/sidebar'); ?>
        <!-- /.Navigation -->
        <section id="content">
          <section class="vbox">
            <section class="scrollable padder">
			<form action="<?php echo site_url('khach_hang/submit_creat'); ?>" method="post">
              <div class="m-b-md">
                <h3 class="m-b-none">Tạo mới đơn hàng</h3>
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
                    <section class="panel panel-default">
                      <header class="panel-heading">
                        <span class="h4">Dịch vụ</span>
                      </header>
                      <div class="panel-body">                                       
                          <div class="form-group pull-in clearfix">
                            <div class="col-sm-6">
								<label>Dịch vụ vận chuyển <span class="field-req">*</span></label>	
								<div class="form-group">	
									<div class="col-sm-12">   
										<div class="col-sm-6">
											<div class="radio">
											  <label>
												<input type="radio" name="dich_vu_van_chuyen" id="cp_nhanh" value="0" checked>
												Chuyển phát nhanh
											  </label>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="radio">
											  <label>
												<input type="radio" name="dich_vu_van_chuyen" id="cp_tiet_kiem" value="1">
												Chuyển phát tiết kiệm
											  </label>
											</div>	
										</div>
									</div>
								</div>									
                              <label>Địa chỉ lấy hàng <span class="field-req">*</span></label>
                              <input name="dia_chi_kho" type="text" class="form-control" placeholder="Địa chỉ lấy hàng" data-required="true">
                            </div>
                            <div class="col-sm-6">
								<label>Dịch vụ cộng thêm</label>	
								<div class="form-group">	
									<div class="col-sm-12">   
										<div class="col-sm-6">
											<div class="radio">
											  <label>
												<input type="checkbox" name="dich_vu[cod]" value="yes">
												Giao hàng thu tiền (CoD)
											  </label>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="radio">
											  <label>
												<input type="checkbox" name="dich_vu[free]" value="yes">
												Miễn phí vận chuyển cho người mua(nhận)
											  </label>
											</div>	
										</div>
									</div>
								</div>	
								<div class="form-group">	
									<div class="col-sm-12">   
										<div class="col-sm-6">
											<div class="radio">
											  <label>
												<input type="checkbox" name="dich_vu[bao_hiem]" value="yes">
												Bảo hiểm hàng hóa
											  </label>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="radio">
											  <label>
												<input type="checkbox" name="dich_vu[hang_de_vo]" value="yes">
												Hàng dễ vỡ
											  </label>
											</div>	
										</div>
									</div>
								</div>									
                            </div>
                          </div>                          
                      </div>                   
                    </section>                 
                </div>
			  
                <div class="col-sm-6">                
                    <section class="panel panel-default">
                      <header class="panel-heading">
                        <span class="h4">Thông tin hàng hóa</span>
                      </header>
                      <div class="panel-body">
                          <div class="form-group pull-in clearfix">
                            <div class="col-sm-6">
                              <label>Tên các loại hàng hóa <span class="field-req">*</span></label>
                              <input type="text" name="ten_hang_hoa" class="form-control" placeholder="Nhập tên sản phẩm" data-required="true">
                            </div>
                            <div class="col-sm-6">
                              <label>Tổng khối lượng (gram) <span class="field-req">*</span></label>
                              <input type="text" name="khoi_luong" class="form-control" placeholder="Tổng khối lượng sản phẩm (gram)" data-required="true">
                            </div>
                          </div>
                          <div class="form-group pull-in clearfix">
                            <div class="col-sm-6">
                              <label>Số lượng <span class="field-req">*</span></label>
                              <input type="text" name="so_luong" class="form-control" placeholder="Số lượng sản phẩm" data-required="true">
                            </div>
                            <div class="col-sm-6">
                              <label>Tổng giá trị hàng hóa <span class="field-req">*</span></label>
                              <input type="text" name="tong_gia_tri" class="form-control" placeholder="Tổng giá trị đơn hàng" data-required="true">
                            </div>
                          </div>
                          <div class="form-group">
                            <label>Mô tả</label>
                            <textarea name="mo_ta" class="form-control" rows="6" data-minwords="6" data-required="true" placeholder="Nhập mô tả hàng hóa"></textarea>
                          </div>
                      </div>                    
                    </section>                 
                </div>
                <div class="col-sm-6">                 
                    <section class="panel panel-default">
                      <header class="panel-heading">
                        <span class="h4">Người nhận hàng </span>
                      </header>
                      <div class="panel-body">                                           
                          <div class="form-group pull-in clearfix">
                            <div class="col-sm-6">
                              <label>Người nhận hàng <span class="field-req">*</span></label>
                              <input name="ten_nguoi_nhan" type="text" class="form-control" placeholder="Họ tên" data-required="true">
                            </div>
                            <div class="col-sm-6">
                              <label>Số điện thoại <span class="field-req">*</span></label>
                              <input name="so_dien_thoai" type="text" class="form-control" placeholder="Điện thoại" data-required="true">
                            </div>
                          </div>
                         <div class="form-group pull-in clearfix">
                            <div class="col-sm-6">
                              <label>Email</label>
                              <input name="email_nguoi_nhan" type="email" class="form-control" placeholder="Email" data-required="true">
                            </div>
                            <div class="col-sm-6">
                              <label>Số nhà/Ngõ/Hẻm/Tên đường phố <span class="field-req">*</span></label>
                              <input name="dia_chi_nguoi_nhan" type="text" class="form-control" placeholder="" data-required="true">
                            </div>
                          </div>
						  <div class="form-group pull-in clearfix">
                            <div class="col-sm-6">
								<label>Tỉnh/Thành phố <span class="field-req">*</span></label>
								<select name="tinh_tp" class="form-control">                            
									<option value="">Chọn Tỉnh/Thành phố</option>
									<option value="HCM">Hồ Chí Minh</option>
									<option value="DN">Đà Nẵng</option>
									<option value="HN">Hà Nội</option>									                                    
								</select>
                            </div>
                            <div class="col-sm-6">
								<label>Quận/Huyện <span class="field-req">*</span></label>
								<select name="quan_huyen" class="form-control">                           
									<option value="">Chọn Quận/Huyện</option>
									<option value="Quan 1">Quận 1</option>
									<option value="Quan 2">Quận 2</option>                          									
									<option value="Quan 12">Quận 12</option>
									<option value="Go Vap">Quận Gò Vấp</option>						
									<option value="Tan Binh">Quận Tân Bình</option>									
								</select>
                            </div>
                          </div>
                      </div>                     
                    </section>                  
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">                 
                    <section class="panel panel-default">
                      <header class="panel-heading">
                        <span class="h4">Ghi chú cho khách hàng</span>
                      </header>
                      <div class="panel-body">                                                               
                          <div class="form-group">                          
                            <textarea name="ghi_chu" class="form-control" rows="6" data-minwords="6" data-required="true" placeholder="Ghi chú dành cho khách hàng (người nhận)"></textarea>
                          </div>
                      </div>                      
                    </section>
                </div>
                <div class="col-sm-6">                 
                    <section class="panel panel-default">
                      <header class="panel-heading">
                        <span class="h4">Cước vận chuyển</span>
                      </header>
                      <div class="panel-body">                                           
                          <div class="form-group">   
							<div class="col-sm-6">						  
                              <label>Phí vận chuyển:</label>
							</div>
							<div class="col-sm-6">
                              <label>0đ</label>    
							</div>
                          </div>
						  <div class="form-group">
								<div class="col-sm-6">	
									<label>Tiền thu hộ (người nhận trả):</label>
								</div>
								<div class="col-sm-6">	
									<label>0đ</label>
								</div>
						  </div>
                          <div class="form-group">
							<div class="col-sm-6">	
								<label>Thời gian vận chuyển dữ kiến:</label>
							</div>
							<div class="col-sm-6">	
								<label>0 (h)</label>
							</div>
                          </div>                       
                      </div>
                     
                    </section>
                
                </div>
              </div>
			  <div class="row panel-footer text-right">				
					<button type="submit" class="btn btn-success btn-s-xs">Tạo đơn hàng</button>				
			  </div>
			  </form>
            </section>
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
        </section>
      </section>
    </section>
  </section>
  <!-- .Footer -->
  <?php $this->load->view('khach_hang/partial/footer'); ?>
  <!-- /.Footer -->
</body>
</html>