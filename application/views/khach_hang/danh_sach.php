<body class="">
  <section class="vbox">
    <!-- .Header -->
	<?php  $this->load->view('khach_hang/partial/header'); ?>
	<!-- /.Header -->
    <section>
      <section class="hbox stretch">
        <!-- .aside -->        
        <?php  $this->load->view('khach_hang/partial/sidebar'); ?>        
        <!-- /.aside -->
        <section id="content">
          <section class="vbox">
            <section class="scrollable padder">
              <div class="m-b-md">
                <h3 class="m-b-none">Danh sách đơn hàng</h3>
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
			<form action="<?php echo site_url('khach_hang/do_action'); ?>" method="post">
              <section class="panel panel-default">                              
                <div class="table-responsive">
                  <table class="table table-striped b-t b-light">
					<!-- .Head table -->
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
					<!-- /.Head table -->
					<!-- .Content table -->
                    <tbody>
					<?php 
						if($danh_sach != null){
							foreach($danh_sach as $don_hang){
					?>
                      <tr>
                        <td><label class="checkbox m-n i-checks"><input type="checkbox" name="check_item[]" value="<?php echo $don_hang['id']; ?>"><i></i></label></td>
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
						  }
						  ?>
                        </td> 
						<td> 
							<a title="Chi tiết đơn hàng" href="<?php echo site_url('khach_hang/chi_tiet/'.$don_hang['id']); ?>"><span class="i i-file-openoffice"></span></a>&nbsp;
							<?php if($don_hang['trang_thai_don_hang'] == 0 || $don_hang['trang_thai_don_hang'] == 1 ){ ?>
							<a title="Chỉnh sửa đơn hàng" href="<?php echo site_url('khach_hang/cap_nhat/'.$don_hang['id']); ?>"><span class="i i-pencil"></span></a>&nbsp;
							<?php } ?>
							<a title="Xóa đơn hàng" onclick="return confirm('Bạn có muốn xóa đơn hàng này');" href="<?php echo site_url('khach_hang/xoa/'.$don_hang['id']); ?>"><span class="fa fa-trash-o"></span></a>&nbsp;
							<?php if($don_hang['trang_thai_don_hang'] == 0 || $don_hang['trang_thai_don_hang'] == 1 || $don_hang['trang_thai_don_hang'] == 2){ ?>
							<a title="Hủy đơn hàng" onclick="return confirm('Bạn có muốn hủy đơn hàng này');" href="<?php echo site_url('khach_hang/huy_don_hang/'.$don_hang['id']); ?>"><span class="i i-cancel"></span></a>
							<?php } ?>
						</td>
                      </tr> 
					<?php 
							}
						}else{
					?>
						<tr>
							<td colspan="8">Bạn chưa có đơn hàng nào trong danh sách</td>
						</tr>
					<?php
						}
					?>					  					  					 
                    </tbody>
					<!-- /.Content table -->
                  </table>
                </div>
                <footer class="panel-footer">
                  <div class="row">
                    <div class="col-sm-4 hidden-xs">
                      <select name="action" class="input-sm form-control input-s-sm inline v-middle">                                                          
						<option value="1">Xóa các mục chọn</option>
						<option value="2">Bỏ xóa các mục chọn</option>
                      </select>
                      <button class="btn btn-sm btn-default">Submit</button>
                    </div>
                    <div class="col-sm-4 text-center">
                      <!--<small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>-->
                    </div>
                    <div class="col-sm-4 text-right text-center-xs">                
                      <ul class="pagination pagination-sm m-t-none m-b-none">
                        <!--<li><a href="#"><i class="fa fa-chevron-left"></i></a></li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#"><i class="fa fa-chevron-right"></i></a></li>-->
						<?php echo $pagination; ?>
                      </ul>
                    </div>
                  </div>
                </footer>
              </section>
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