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
                <h3 class="m-b-none">Tìm kiếm đơn hàng</h3>				
              </div> 
			<div class="row">                
                <div class="col-sm-12">
                  <form class="form-inline" data-validate="parsley" method="get" action="<?php echo site_url('admin/tim_kiem_don_hang'); ?>">
                    <section class="panel panel-default">                     
                      <div class="panel-body">  
						  <div class="form-group pull-in clearfix">
                            <div class="col-sm-6">
                              <label>Mã đơn hàng</label>
                              <input type="text" name="ma_don_hang" class="form-control" placeholder="Mã đơn hàng" value="<?php if(isset($giao_nhan) && $giao_nhan['ten'] != ''){ echo $giao_nhan['ten']; } ?>">
                            </div>                           
                          </div>	
						  <div class="form-group pull-in clearfix">
                            <div class="col-sm-6">
                              <label>Trạng thái</label>
                              <select name="trang_thai_don_hang" class="form-control">                
								<option value="all">Tất cả</option>
								<option value="0">Chờ xác nhận</option>
								<option value="1">Đã xác nhận</option>
								<option value="2">Đang lấy hàng</option>
								<option value="3">Đang giao hàng</option>
								<option value="4">Giao thành công</option>									                                    
								<option value="5">Giao lỗi</option>									                                    
								<option value="6">Hủy đơn hàng</option>									                                    
							</select>
                            </div>                          
                          </div>
						  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">						 
						  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
						  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
						  <script language="javascript">
						  $.noConflict();
						  jQuery( document ).ready(function( $ ) {
							$( "#datepicker" ).datepicker({
							  changeMonth: true,
							  changeYear: true,
							  dateFormat: 'dd/mm/yy'
							});
						  });
						  </script>
						  <div class="form-group pull-in clearfix">
                             <div class="col-sm-6">
                              <label>Ngày tạo</label>
                              <input type="ngay_tao" id="datepicker"  name="ngay_tao" class="form-control" placeholder="Ngày tạo">
                            </div>                            
                          </div>                          						                          
                      </div>
                      <footer class="panel-footer text-left bg-light lter">
                        <button type="submit" class="btn btn-success btn-s-xs"><i class="fa fa-search"></i> Tìm kiếm</button>
                      </footer>
                    </section>
                  </form>
                </div>				
              </div>
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
			  
              <!-- .Search -->
              <section class="panel panel-default">       				
				
				<div class="row wrapper">      
				  <form action="<?php echo site_url('admin/tim_kiem'); ?>" method="get">
                  <div class="col-sm-3">
                    <div class="input-group">				
                      <input type="text" class="input-sm form-control" name="s" placeholder="Mã đơn hàng, điện thoại,...">
                      <span class="input-group-btn">                     
						<input type="submit" class="btn btn-sm btn-default" value="Tìm!"></div>
                      </span>					
                    </div>
				  </form>
					<div class="col-sm-6">
						<!--<div class="btn-group">
		                  <button class="btn btn-default">Sắp xếp</button>
		                  <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
		                  <ul class="dropdown-menu">
		                    <li><a href="#">Đơn hàng chờ xác nhận</a></li>
		                    <li><a href="#">Đơn hàng đã xác nhận</a></li>
							<li><a href="#">Đang lấy hàng</a></li>
							<li><a href="#">Đang giao hàng</a></li>
							<li><a href="#">Giao thành công</a></li>
							<li><a href="#">Đơn hàng giao lỗi</a></li>
							<li><a href="#">Hủy đơn hàng</a></li>
		                    <li class="divider"></li>
		                    <li><a href="#">Mã đơn hàng tăng dần</a></li>
							<li><a href="#">Mã đơn hàng giảm dần</a></li>
							<li><a href="#">Ngày gần nhất</a></li>
		                  </ul>
		                </div>-->
						<!--<select name="action" class="input-sm form-control input-s-sm inline v-middle">                        
							<option value='0' >Đơn hàng chờ xác nhận</option>
		                    <option value='1' >Đơn hàng đã xác nhận</option>
							<option value='2' >Đang lấy hàng</option>
							<option value='3' >Đang giao hàng</option>
							<option value='4' >Giao thành công</option>
							<option value='5' >Đơn hàng giao lỗi</option>
							<option value='6' >Hủy đơn hàng</option>	                    
		                    <option value='7' >Mã đơn hàng tăng dần</option>
							<option value='8' >Mã đơn hàng giảm dần</option>
							<option value='9' >Ngày gần nhất</option>
						</select>
						<select name="ngay" class="input-sm form-control" style="with:10px;">                        
							<?php for($i = 1;$i <= 31; $i++){ ?>
								<option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
							<?php } ?>
						</select>
						<select name="thang" class="input-sm form-control" style="with:10px;">                        
							<?php for($i = 1; $i <= 12; $i++){ ?>
								<option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
							<?php } ?>
						</select>
						<select name="nam" class="input-sm form-control" style="with:10px;">                        
							<?php for($i = date("Y"); $i <= (date("Y") - 5); $i--  ){ ?>
								<option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
							<?php } ?>
						</select>-->
					</div>
					<div class="col-sm-3">
						<div class="input-group " style="float:right;">				
						  <strong>Tổng: </strong><?php echo $tong; ?> (Đơn hàng)
						</div>
					  </div>
                </div>				
			
				<!-- /.Search -->	  
				<form action="<?php echo site_url('admin/do_action/')?>">
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
						<th>NV phụ trách</th>
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
						<td><?php if($don_hang['id_giao_nhan'] == 0){ echo "Chưa có NV"; }else{ echo $don_hang['ten']; } ?></td>
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
							<a title="Chi tiết dơn hàng" href="<?php echo site_url('admin/chi_tiet_don_hang/'.$don_hang['id']); ?>"><span class="i i-file-openoffice"></span></a>&nbsp;
							<a title="Xác nhận đơn hàng" href="<?php echo site_url('admin/cap_nhat_don_hang/'.$don_hang['id']); ?>"><span class="i i-pencil"></span></a>&nbsp;							
						</td>
                      </tr>
					 <?php
							}
						}else{
					  ?>
						<tr>
							<td colspan="9">Danh sách đơn hàng rỗng</td>
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
                        <option value="0">Xác nhận đơn hàng</option>                       
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