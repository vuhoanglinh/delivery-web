<!-- .Head -->
<?php include 'partial/head.php'; ?>
<!-- /.Head -->
<body class="">
  <section class="vbox">
    <!-- .Header -->
	<?php include 'partial/header.php'; ?>
	<!-- /.Header -->
    <section>
      <section class="hbox stretch">
        <!-- .aside -->
        <?php include 'partial/sidebar.php'; ?>
        <!-- /.aside -->
        <section id="content">
          <section class="vbox">
            <section class="scrollable padder">
              <div class="m-b-md">
                <h3 class="m-b-none">Xác nhận đơn hàng [Mã đơn hàng]</h3>
              </div>
              <div class="row">                
                <div class="col-sm-6">
                  <form data-validate="parsley">
                    <section class="panel panel-default">                     
                      <div class="panel-body">  						 
                          <div class="form-group">
                            <label>Trạng thái <span class="field-req">*</span></label>
                            <select class="form-control">                            								
								<option value="AR">Đang lấy hàng</option>
								<option value="AR">Đang giao hàng</option>
								<option value="AL">Giao hàng thành công</option>
								<option value="IL">Giao lỗi</option>									                                    
							</select>
                          </div>
                          <div class="form-group">
                            <label>Lý do <span class="field-req">*</span></label>
                            <textarea class="form-control" rows="6" data-minwords="6" data-required="true" placeholder="Lý do giao hàng lỗi (Giao nhận phải ghi rõ lý do. VD: Khách hàng vắng mặt, không đúng mặt hàng, hàng lỗi, sai địa chỉ...)"></textarea>
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
  <!-- .Header -->
  <?php include 'partial/header.php'; ?>
  <!-- /.Header -->
</body>
</html>