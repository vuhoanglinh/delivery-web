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
                <h3 class="m-b-none">Liên hệ</h3>
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
                  <form data-validate="parsley" method="post" action="<?php echo site_url('khach_hang/submit_lien_he'); ?>">
                    <section class="panel panel-default">                     
                      <div class="panel-body">  
						  <div class="form-group pull-in clearfix">
                            <div class="col-sm-6">
                              <label>Tên *</label>
                              <input type="text" name="ten" class="form-control" placeholder="Tên" data-required="true" value="<?php if(isset($_SESSION['last_data']['ten'])){ echo $_SESSION['last_data']['ten']; }?>">
                            </div>
                            <div class="col-sm-6">
                              <label>Email *</label>
                              <input type="email"  name="email" class="form-control" placeholder="Email" data-required="true" value="<?php if(isset($_SESSION['last_data']['email'])){ echo $_SESSION['last_data']['email']; }?>">
                            </div>
                          </div>					  
						  <div class="form-group pull-in clearfix">
                            <div class="col-sm-6">
                              <label>Điện thoại </label>
                              <input type="text" name="dien_thoai" class="form-control" placeholder="Điện thoại" value="<?php if(isset($_SESSION['last_data']['dien_thoai'])){ echo $_SESSION['last_data']['dien_thoai']; }?>">
                            </div>                            
                          </div>
                          <div class="form-group">
                            <label>Tiêu đề *</label>
                            <input type="text" name="tieu_de"  data-required="true" class="form-control" placeholder="Tiêu đề" value="<?php if(isset($_SESSION['last_data']['tieu_de'])){ echo $_SESSION['last_data']['tieu_de']; }?>">
                          </div>
                          <div class="form-group">
                            <label>Nội dung *</label>
                            <textarea name="noi_dung" class="form-control" rows="6" data-minwords="6" data-required="true" placeholder="Nội dung"><?php if(isset($_SESSION['last_data']['noi_dung'])){ echo $_SESSION['last_data']['noi_dung']; }?></textarea>
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
  <?php $this->load->view('khach_hang/partial/footer'); ?>
  <!-- /.Footer -->
</body>
</html>