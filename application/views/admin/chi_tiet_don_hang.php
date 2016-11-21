<body class="">
  <section class="vbox">
    <!-- .Header -->
	<?php $this->load->view('admin/partial/header'); ?>
	<!-- /.Header -->
    <section>
      <section class="hbox stretch">
        <!-- .Navigation -->
        <?php $this->load->view('admin/partial/sidebar'); ?>
        <!-- /.Navigation -->
        <section id="content">
          <section class="vbox">
            <section class="scrollable padder">			
              <div class="m-b-md">
                <h3 class="m-b-none">Thông tin đơn hàng</h3>
              </div>
              <div class="row">
				<div class="col-sm-12">                
                    <section class="panel panel-default">                      
                      <div class="panel-body">                                       
                          <div class="form-group pull-in clearfix">
                            <div class="col-sm-6">
							 <header class="panel-heading">
								<span class="h4">Thông tin người gửi</span>
							  </header>	
								<!--<div class="form-group clearfix">	
									<label class="col-sm-3 control-label">Họ Tên:</label>
									<div class="col-sm-9"><?php echo $ten_nguoi_gui; ?></div>
								</div>		
								<div class="form-group clearfix">	
									<label class="col-sm-3 control-label">Số điện thoại:</label>
									<div class="col-sm-9"><?php echo $ten_nguoi_gui; ?></div>
								</div>-->
								<div class="form-group clearfix">	
									<label class="col-sm-3 control-label">Địa chỉ lấy hàng:</label>
									<div class="col-sm-9"><?php echo $don_hang['dia_chi_lay_hang']; ?></div>
								</div>									
                            </div>
                            <div class="col-sm-6">
							<header class="panel-heading">
								<span class="h4">Thông tin sản phẩm</span>
							  </header>								
								<div class="form-group clearfix">	
									<label class="col-sm-3 control-label">Sản phẩm:</label>
									<div class="col-sm-9"><?php echo $don_hang['ten_hang_hoa']; ?></div>
								</div>		
								<div class="form-group clearfix">	
									<label class="col-sm-3 control-label">Số lượng:</label>
									<div class="col-sm-9"><?php echo $don_hang['so_luong']; ?></div>
								</div>	
								<div class="form-group clearfix">	
									<label class="col-sm-3 control-label">Trọng lượng:</label>
									<div class="col-sm-9"><?php echo $don_hang['khoi_luong']; ?>gram</div>
								</div>	
								<div class="form-group clearfix">	
									<label class="col-sm-3 control-label">Tổng tiền:</label>
									<div class="col-sm-9"><?php echo number_format($don_hang['tong_tien']); ?>đ</div>
								</div>
								<div class="form-group clearfix">	
									<label class="col-sm-3 control-label">Mô tả	:</label>
									<div class="col-sm-9"><?php echo $don_hang['mo_ta']; ?></div>
								</div>								
                            </div>
							<div class="col-sm-6">
							 <header class="panel-heading">
								<span class="h4">Người nhận</span>
							  </header>	
								<div class="form-group clearfix">	
									<label class="col-sm-3 control-label">Họ Tên:</label>
									<div class="col-sm-9"><?php echo $don_hang['ten_nguoi_nhan']; ?></div>
								</div>		
								<div class="form-group clearfix">	
									<label class="col-sm-3 control-label">Số điện thoại:</label>
									<div class="col-sm-9"><?php echo $don_hang['dien_thoai_nguoi_nhan']; ?></div>
								</div>	
								<div class="form-group clearfix">	
									<label class="col-sm-3 control-label">Địa chỉ:</label>
									<div class="col-sm-9"><?php echo $don_hang['dia_chi_giao_hang']; ?></div>
								</div>									
                            </div>
                            <div class="col-sm-6">
							<header class="panel-heading">
								<span class="h4">Dịch vụ khác</span>
							  </header>								
								<div class="form-group clearfix">	
									<label class="col-sm-5 control-label">Tiền thu hộ (người nhận trả):</label>
									<div class="col-sm-7">0đ</div>
								</div>		
								<div class="form-group clearfix">	
									<label class="col-sm-5 control-label">Phí giao hàng (người nhận trả):</label>
									<div class="col-sm-7">0đ</div>
								</div>	
								<div class="form-group clearfix">	
									<label class="col-sm-5 control-label">Dịch vụ thêm:</label>
									<div class="col-sm-7"><?php if($don_hang['is_cod']){ echo "Giao hàng thu tiền(COD)"; }
														if($don_hang['is_free']){ echo "</br>Miễn phí giao hàng"; }
														if($don_hang['is_bao_hiem']){ echo "</br>Bảo hiểm hàng hóa"; }
														if($don_hang['is_de_vo']){ echo "</br>Hàng dễ vỡ"; }
									?></div>
								</div>									
								<div class="form-group clearfix">	
									<label class="col-sm-5 control-label">Ghi chú:</label>
									<div class="col-sm-7"><?php echo $don_hang['ghi_chu']; ?></div>
								</div>								
                            </div>
                          </div>                          
                      </div>                   
                    </section>                 
                </div>
              </div>              						  
            </section>
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
        </section>
      </section>
    </section>
  </section>
  <!-- .Header -->
  <?php $this->load->view('admin/partial/header'); ?>
  <!-- /.Header -->
</body>
</html>