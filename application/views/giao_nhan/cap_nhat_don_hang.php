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
                <h3 class="m-b-none">Cập nhật đơn hàng</h3>
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
                <div class="col-sm-6">
                  <form data-validate="parsley" method="post" action="<?php echo site_url('giao_nhan/submit_cap_nhat_don_hang/'.$don_hang['id']); ?>">
					<input type="hidden" name="ma_don_hang" value="<?php echo $don_hang['id']; ?>" >
                    <section class="panel panel-default">                     
                      <div class="panel-body">  						 						 
                          <div class="form-group">							
                            <label>Trạng thái <span class="field-req">*</span></label>
                            <select name="trang_thai_don_hang" class="form-control">                
								<option value="0" <?php if($don_hang['trang_thai_don_hang'] == '0'){ echo 'selected="selected"'; } ?>>Chờ xác nhận</option>
								<option value="1" <?php if($don_hang['trang_thai_don_hang'] == '1'){ echo 'selected="selected"'; } ?>>Đã xác nhận</option>
								<option value="2" <?php if($don_hang['trang_thai_don_hang'] == '2'){ echo 'selected="selected"'; } ?>>Đang lấy hàng</option>
								<option value="3" <?php if($don_hang['trang_thai_don_hang'] == '3'){ echo 'selected="selected"'; } ?>>Đang giao hàng</option>
								<option value="4" <?php if($don_hang['trang_thai_don_hang'] == '4'){ echo 'selected="selected"'; } ?>>Giao thành công</option>									                                    
								<option value="5" <?php if($don_hang['trang_thai_don_hang'] == '5'){ echo 'selected="selected"'; } ?>>Giao lỗi</option>									                                    
								<option value="6" <?php if($don_hang['trang_thai_don_hang'] == '6'){ echo 'selected="selected"'; } ?>>Hủy đơn hàng</option>									                                    
							</select>
                          </div>						 
                          <div class="form-group">
                            <label>Lý do/Ghi chú giao hàng (nếu có):</label>
                            <textarea name="ly_do" class="form-control" rows="6"  placeholder="Lý do giao hàng lỗi (Nếu có giao nhận phải ghi rõ lý do. VD: Khách hàng vắng mặt, không đúng mặt hàng, hàng lỗi, sai địa chỉ...)"><?php echo $don_hang['ly_do']; ?></textarea>
                          </div>
                      </div>
                      <footer class="panel-footer text-right bg-light lter">
                        <button type="submit" class="btn btn-success btn-s-xs">Gửi</button>
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
    <?php  $this->load->view('giao_nhan/partial/footer'); ?>
	<!-- /.Footer -->
</body>
</html>