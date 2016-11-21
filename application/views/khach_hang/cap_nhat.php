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
			<form action="<?php echo site_url('khach_hang/submit_cap_nhat'); ?>" method="post">
				<input type="hidden" name="ma_don_hang" value="<?php echo $don_hang['id']; ?>" >
              <div class="m-b-md">
                <h3 class="m-b-none">Chỉnh sửa đơn hàng</h3>
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
												<input type="radio" name="dich_vu_van_chuyen" id="cp_nhanh" value="0" <?php if($don_hang['hinh_thuc_giao_hang'] == 0){ echo "checked"; } ?>>
												Chuyển phát nhanh
											  </label>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="radio">
											  <label>
												<input type="radio" name="dich_vu_van_chuyen" id="cp_tiet_kiem" value="1" <?php if($don_hang['hinh_thuc_giao_hang'] == 1){ echo "checked"; } ?>>
												Chuyển phát tiết kiệm
											  </label>
											</div>	
										</div>
									</div>
								</div>									
                              <label>Địa chỉ lấy hàng <span class="field-req">*</span></label>
                              <input value="<?php echo $don_hang['dia_chi_lay_hang']; ?>" name="dia_chi_kho" type="text" class="form-control" placeholder="Địa chỉ lấy hàng" data-required="true">
                            </div>
                            <div class="col-sm-6">
								<label>Dịch vụ cộng thêm</label>	
								<div class="form-group">	
									<div class="col-sm-12">   
										<div class="col-sm-6">
											<div class="radio">
											  <label>
												<input type="checkbox" name="dich_vu[cod]" value="yes" <?php if($don_hang['is_cod'] == 1){ echo "checked"; } ?>>
												Giao hàng thu tiền (CoD)
											  </label>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="radio">
											  <label>
												<input type="checkbox" name="dich_vu[free]" value="yes" <?php if($don_hang['is_free'] == 1){ echo "checked"; } ?>>
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
												<input type="checkbox" name="dich_vu[bao_hiem]" value="yes" <?php if($don_hang['is_bao_hiem'] == 1){ echo "checked"; } ?>>
												Bảo hiểm hàng hóa
											  </label>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="radio">
											  <label>
												<input type="checkbox" name="dich_vu[hang_de_vo]" value="yes" <?php if($don_hang['is_de_vo'] == 1){ echo "checked"; } ?>>
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
                              <input value="<?php echo $don_hang['ten_hang_hoa']; ?>" type="text" name="ten_hang_hoa" class="form-control" placeholder="Nhập tên sản phẩm" data-required="true">
                            </div>
                            <div class="col-sm-6">
                              <label>Tổng khối lượng (gram) <span class="field-req">*</span></label>
                              <input value="<?php echo $don_hang['khoi_luong']; ?>" type="text" name="khoi_luong" class="form-control" placeholder="Tổng khối lượng sản phẩm (gram)" data-required="true">
                            </div>
                          </div>
                          <div class="form-group pull-in clearfix">
                            <div class="col-sm-6">
                              <label>Số lượng <span class="field-req">*</span></label>
                              <input value="<?php echo $don_hang['so_luong']; ?>" type="text" name="so_luong" class="form-control" placeholder="Số lượng sản phẩm" data-required="true">
                            </div>
                            <div class="col-sm-6">
                              <label>Tổng giá trị hàng hóa <span class="field-req">*</span></label>
                              <input value="<?php echo $don_hang['tong_tien']; ?>" type="text" name="tong_gia_tri" class="form-control" placeholder="Tổng giá trị đơn hàng" data-required="true">
                            </div>
                          </div>
                          <div class="form-group">
                            <label>Mô tả</label>
                            <textarea name="mo_ta" class="form-control" rows="6" data-minwords="6" data-required="true" placeholder="Nhập mô tả hàng hóa"><?php echo $don_hang['mo_ta']; ?></textarea>
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
                              <input value="<?php echo $don_hang['ten_nguoi_nhan']; ?>" name="ten_nguoi_nhan" type="text" class="form-control" placeholder="Họ tên" data-required="true">
                            </div>
                            <div class="col-sm-6">
                              <label>Số điện thoại <span class="field-req">*</span></label>
                              <input value="<?php echo $don_hang['dien_thoai_nguoi_nhan']; ?>" name="so_dien_thoai" type="text" class="form-control" placeholder="Điện thoại" data-required="true">
                            </div>
                          </div>
                         <div class="form-group pull-in clearfix">
                            <div class="col-sm-6">
                              <label>Email</label>
                              <input value="<?php echo $don_hang['email_nguoi_nhan']; ?>" name="email_nguoi_nhan" type="email" class="form-control" placeholder="Email" data-required="true">
                            </div>
                            <div class="col-sm-6">
                              <label>Số nhà/Ngõ/Hẻm/Tên đường phố <span class="field-req">*</span></label>
                              <input value="<?php echo $don_hang['dia_chi_giao_hang']; ?>" name="dia_chi_nguoi_nhan" type="text" class="form-control" placeholder="" data-required="true">
                            </div>
                          </div>
						  <div class="form-group pull-in clearfix">
                            <div class="col-sm-6">
								<label>Tỉnh/Thành phố <span class="field-req">*</span></label>
								<select name="tinh_tp" class="form-control">                            
									<option  value="">Chọn Tỉnh/Thành phố</option>
									<option <?php if($don_hang['khu_vuc'] == 'HCM'){ echo 'selected="selected"'; } ?> value="HCM">Hồ Chí Minh</option>
									<option <?php if($don_hang['khu_vuc'] == 'DN'){ echo 'selected="selected"'; } ?> value="DN">Đà Nẵng</option>
									<option <?php if($don_hang['khu_vuc'] == 'HN'){ echo 'selected="selected"'; } ?> value="HN">Hà Nội</option>									                                    
								</select>
                            </div>
                            <div class="col-sm-6">
								<label>Quận/Huyện <span class="field-req">*</span></label>
								<select name="quan_huyen" class="form-control">                           
									<option value="">Chọn Quận/Huyện</option>
									<option <?php if($don_hang['quan_huyen'] == 'Quan 1'){ echo 'selected="selected"'; } ?> value="Quan 1">Quận 1</option>
									<option <?php if($don_hang['quan_huyen'] == 'Quan 2'){ echo 'selected="selected"'; } ?> value="Quan 2">Quận 2</option>                          									
									<option <?php if($don_hang['quan_huyen'] == 'Quan 3'){ echo 'selected="selected"'; } ?> value="Quan 3">Quận 1</option>
									<option <?php if($don_hang['quan_huyen'] == 'Quan 4'){ echo 'selected="selected"'; } ?> value="Quan 4">Quận 2</option>                          									
									<option <?php if($don_hang['quan_huyen'] == 'Quan 5'){ echo 'selected="selected"'; } ?> value="Quan 5">Quận 1</option>
									<option <?php if($don_hang['quan_huyen'] == 'Quan 6'){ echo 'selected="selected"'; } ?> value="Quan 6">Quận 2</option>                          									
									<option <?php if($don_hang['quan_huyen'] == 'Quan 7'){ echo 'selected="selected"'; } ?> value="Quan 7">Quận 1</option>
									<option <?php if($don_hang['quan_huyen'] == 'Quan 8'){ echo 'selected="selected"'; } ?> value="Quan 8">Quận 2</option>                          									
									<option <?php if($don_hang['quan_huyen'] == 'Quan 9'){ echo 'selected="selected"'; } ?> value="Quan 9">Quận 1</option>
									<option <?php if($don_hang['quan_huyen'] == 'Quan 10'){ echo 'selected="selected"'; } ?> value="Quan 10">Quận 2</option>                          									
									<option <?php if($don_hang['quan_huyen'] == 'Quan 11'){ echo 'selected="selected"'; } ?> value="Quan 11">Quận 1</option>								
									<option <?php if($don_hang['quan_huyen'] == 'Quan 12'){ echo 'selected="selected"'; } ?> value="Quan 12">Quận 12</option>
									<option <?php if($don_hang['quan_huyen'] == 'Binh Thanh'){ echo 'selected="selected"'; } ?> value="Binh Thanh">Bình Thạnh</option>
									<option <?php if($don_hang['quan_huyen'] == 'Tan Phu'){ echo 'selected="selected"'; } ?> value="Tan Phu">Tân Phú</option>                          									
									<option <?php if($don_hang['quan_huyen'] == 'Go Vap'){ echo 'selected="selected"'; } ?> value="Go Vap">Gò Vấp</option>						
									<option <?php if($don_hang['quan_huyen'] == 'Tan Binh'){ echo 'selected="selected"'; } ?> value="Tan Binh">Tân Bình</option>									
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
                            <textarea name="ghi_chu" class="form-control" rows="6" data-minwords="6" data-required="true" placeholder="Ghi chú dành cho khách hàng (người nhận)"><?php echo $don_hang['ghi_chu']; ?></textarea>
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
					<button type="submit" class="btn btn-success btn-s-xs">Cập nhật đơn hàng</button>				
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