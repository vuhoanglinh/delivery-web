<!-- .Head -->
<?php  $this->load->view('giao_nhan/partial/head'); ?>
<!-- /.Head -->
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
                <h3 class="m-b-none"><?php echo $page_title; ?> (Tổng: <?php echo $tong; ?>)</h3>
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
			  
			  <!--<form action="<?php echo site_url('giao_nhan/do_action/')?>">
              <section class="panel panel-default">                               
                <div class="table-responsive">
                  <table class="table table-striped b-t b-light">				
                    <thead>
                      <tr>
                        <th><label class="checkbox m-n i-checks"><input type="checkbox"><i></i></label></th>
                        <th>Mã</th>
                        <th>Người nhận</th>
						<th>Điện thoại</th>
						<th>Địa chỉ nhận</th>
                        <th>Ngày tạo</th>						
                        <th>Trạng Thái</th>
						<th></th>
                      </tr>
                    </thead>					
                    <tbody>
					<?php
						if($danh_sach != null){
							foreach($danh_sach as $don_hang){
					?>
                      <tr>
                        <td><label class="checkbox m-n i-checks"><input type="checkbox" name="check_item[]"><i></i></label></td>
                        <td><?php echo $don_hang['id']; ?></td>
                        <td><?php echo $don_hang['ten_nguoi_nhan']; ?></td>
						<td><?php echo $don_hang['dien_thoai_nguoi_nhan']; ?></td>
						<td><?php echo $don_hang['dia_chi_giao_hang']; 
									if($don_hang['quan_huyen'] != ""){
										echo ", ".$don_hang['quan_huyen'];
									}
									if($don_hang['khu_vuc'] != ""){
										echo ", ".$don_hang['khu_vuc'];
									}
							?></td>						
                        <td><?php echo date("d-m-Y H:i:s", $don_hang['ngay_tao']); ?></td>						
                        <td>
                         <?php
							 if($don_hang['xoa'] == 1){
							  echo 'Đã xóa';
						  } else {
								 switch($don_hang['trang_thai_don_hang']){
										case 0:	echo 'Chờ xác nhận';
											break;
										case 1:	echo 'Đã xác nhận';
											break;
										case 2:	echo 'Đang lấy hàng';
											break;								
										case 3:	echo 'Đang giao hàng';
											break;		
										case 4:	echo 'Giao thành công';
											break;		
										case 5:	echo 'Giao lỗi';
											break;		
										case 6:	echo 'Hủy đơn hàng';
											break;									
								  } 
						  }?>
                        </td> 
						<td> 
							<a title="Chi tiết dơn hàng" href="<?php echo site_url('giao_nhan/chi_tiet_don_hang/'.$don_hang['id']); ?>"><span class="i i-file-openoffice"></span></a>&nbsp;
							<a title="Xác nhận đơn hàng" href="<?php echo site_url('giao_nhan/cap_nhat_don_hang/'.$don_hang['id']); ?>"><span class="i i-pencil"></span></a>&nbsp;							
						</td>
                      </tr>
					 <?php
							}
						}
					 ?>						  
                    </tbody>					
                  </table>
                </div>
                <footer class="panel-footer">
                  <div class="row">
                    <div class="col-sm-4 hidden-xs">                   
                    </div>
                    <div class="col-sm-4 text-center">                    
                    </div>
                    <div class="col-sm-4 text-right text-center-xs">                
                      <ul class="pagination pagination-sm m-t-none m-b-none">                      
						<?php echo $pagination; ?>
                      </ul>
                    </div>
                  </div>
                </footer>
              </section>
			  </form>-->
				<div class="row">
					<div class="col-lg-12">
						<div class="row">
						<?php
						if($danh_sach != null){
							foreach($danh_sach as $don_hang){
						?>
						<div class="col-md-4 clearfix">
							<header class="panel-heading bg-info">
	                          <div class="clearfix">
	                            <a href="" class="pull-left thumb-md avatar b-3x m-r">
	                              <img src="<?php echo base_url('assets/images/a1.png') ?>">
	                            </a>
	                            <div class="clear">
	                              <div class="h3 m-t-xs m-b-xs">
	                                <?php echo $don_hang['ten_nguoi_nhan']?>
	                                <i class="fa fa-circle text-success pull-right text-xs m-t-sm"></i>
	                              </div>
	                            </div>
	                          </div>
	                        </header>
							<section class="panel panel-default">
								<div class="panel-body">
									<h4>Địa chỉ: 	
										<?php echo $don_hang['dia_chi_giao_hang']; 
											if($don_hang['quan_huyen'] != ""){
												echo ", ".$don_hang['quan_huyen'];
											}
											if($don_hang['khu_vuc'] != ""){
												echo ", ".$don_hang['khu_vuc'];
											}
									?>
									<h4>
									<h2>	
										<a href="tel:<?php echo $don_hang['dien_thoai_nguoi_nhan']?>"><i class="fa fa-phone-square"></i>&nbsp; <?php echo $don_hang['dien_thoai_nguoi_nhan']?></a>
									</h2>
									<hr>
									<div class="form-group clearfix col-xs-8">	
										<label class="control-label" style="font-size:1em"><?php
									 if($don_hang['xoa'] == 1){
									  echo 'Đã xóa';
								  } else {
										 switch($don_hang['trang_thai_don_hang']){
												case 0:	echo 'Chờ xác nhận';
													break;
												case 1:	echo 'Đã xác nhận';
													break;
												case 2:	echo 'Đang lấy hàng';
													break;								
												case 3:	echo 'Đang giao hàng';
													break;		
												case 4:	echo 'Giao thành công';
													break;		
												case 5:	echo 'Giao lỗi';
													break;		
												case 6:	echo 'Hủy đơn hàng';
													break;									
										  } 
								  }?></label>
									</div>
									<div class="form-group clearfix col-xs-4">	
										<a title="Chi tiết dơn hàng" href="<?php echo site_url('giao_nhan/chi_tiet_don_hang/'.$don_hang['id']); ?>"><span class="i i-file-openoffice"></span></a>&nbsp;&nbsp;	
									<a title="Xác nhận đơn hàng" href="<?php echo site_url('giao_nhan/cap_nhat_don_hang/'.$don_hang['id']); ?>"><span class="i i-pencil"></span></a>						
									</div>
								</div>
							</section>
						</div>
						<?php 
							}
							if($tong > LIST_LIMIT){
						?>		
						</div>		
						<div class="clearfix"></div>
						<footer class="panel-footer">
						  <div class="row">
							<div class="col-sm-4 hidden-xs">                   
							</div>
							<div class="col-sm-4 text-center">                    
							</div>
							<div class="col-sm-4 text-right text-center-xs">                
							  <ul class="pagination pagination-sm m-t-none m-b-none">                      
								<?php echo $pagination; ?>
							  </ul>
							</div>
						  </div>
						</footer>
						<?php
							}
						}else{
							echo '<div class="col-lg-12"><i>Danh sách đơn hàng rỗng</i></div>';							
						}
						?>	
						
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
    <?php  $this->load->view('giao_nhan/partial/footer'); ?>
	<!-- /.Footer -->
</body>
</html>