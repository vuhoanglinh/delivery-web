<!-- .Head -->
<?php  $this->load->view('admin/partial/head'); ?>
<!-- /.Head -->
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
                <h3 class="m-b-none">Danh sách khách hàng
				</h3>
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
				 <!-- .Search -->
              <section class="panel panel-default">       				
				<form action="<?php echo site_url('admin/tim_kiem_khach_hang'); ?>" method="get">
				<div class="row wrapper">                                  
                  <div class="col-sm-3">
                    <div class="input-group">				
                      <input type="text" class="input-sm form-control" name="s" placeholder="Tên, điện thoại, email...">
                      <span class="input-group-btn">                     
						<input type="submit" class="btn btn-sm btn-default" value="Tìm!"></div>
                      </span>					
                    </div>
					<div class="col-sm-9">
						<div class="input-group " style="float:right;">				
						  <strong>Tổng khách hàng: </strong><?php echo $tong; ?>
						</div>
					  </div>
                  </div>
                </div>				
				</form>
				<!-- /.Search -->	
				<form action="<?php echo site_url('admin/do_action_khach_hang/')?>" method="post">				
                <div class="table-responsive">
                  <table class="table table-striped b-t b-light">
					<!-- .Head table -->
                    <thead>
                      <tr>
                        <th><label class="checkbox m-n i-checks"><input type="checkbox"><i></i></label></th>
                        <th>ID</th>
                        <th>Họ Tên</th>
						<th>Địa chỉ</th>
						<th>Điện thoại</th>
                        <th>Ngày tạo</th>                        
						<th>Trạng thái</th>                        
						<th></th>
                      </tr>
                    </thead>
					<!-- /.Head table -->
					<!-- .Content table -->
                    <tbody>
					<?php 
						if($danh_sach != null){
							foreach($danh_sach as $khach_hang){
					?>
                      <tr>
                        <td><label class="checkbox m-n i-checks"><input type="checkbox" name="check_item[]" value="<?php echo $khach_hang['id']; ?>"><i></i></label></td>
                        <td><?php echo $khach_hang['id']; ?></td>
                        <td><?php echo $khach_hang['ten']; ?></td>
						<td><?php echo $khach_hang['dia_chi']; ?></td>
						<td><?php echo $khach_hang['dien_thoai']; ?></td>
                        <td><?php echo date("m-d-Y H:i:s",$khach_hang['ngay_tao']); ?></td>                        
						<td><?php 
							if($khach_hang['xoa'] == 1){
								echo "Đã xóa";
							}else{
								if($khach_hang['xac_nhan'] == 1){
									echo "Đã xác nhận";
								}
								if($khach_hang['xac_nhan'] == 0){
									echo "Chưa xác nhận";
								}
							}
						?></td>
						<td> 							
							<a title="Chỉnh sửa" href="#"><span class="i i-pencil"></span></a>&nbsp;
							<a title="Xóa" onclick="return confirm('Bạn có muốn xóa khách hàng này?')" href="<?php echo site_url('admin/xoa_khach_hang/'.$khach_hang['id']); ?>"><span class="fa fa-trash-o"></span></a>
						</td>
                      </tr>
					  <?php 
							}
						}else{
					  ?>
						<tr>
							<td colspan="9">Danh sách khách hàng rỗng</td>
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
						<option value="0">Chọn thao tác</option>
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
				</form>
              </section>
            </section>
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
        </section>
      </section>
    </section>
  </section>
	<!-- .Footer -->
	<?php  $this->load->view('admin/partial/footer'); ?>
	<!-- /.Footer -->
</body>
</html>