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
                <h3 class="m-b-none">Danh sách đơn hàng</h3>
              </div>              
              <section class="panel panel-default">               
                <div class="row wrapper">                                  
                  <div class="col-sm-3">
                    <div class="input-group">
                      <input type="text" class="input-sm form-control" placeholder="Search">
                      <span class="input-group-btn">
                        <button class="btn btn-sm btn-default" type="button">Go!</button>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped b-t b-light">
					<!-- .Head table -->
                    <thead>
                      <tr>
                        <th><label class="checkbox m-n i-checks"><input type="checkbox"><i></i></label></th>
                        <th>Mã đơn hàng</th>
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
                      <tr>
                        <td><label class="checkbox m-n i-checks"><input type="checkbox" name="post[]"><i></i></label></td>
                        <td>Idrawfast</td>
                        <td>4c</td>
						<td>4c</td>
						<td>4c</td>
                        <td>Jul 25, 2013</td>
                        <td>
                          Chờ xác nhận
                        </td> 
						<td> 
							<a title="Chi tiết dơn hàng" href="../chi_tiet_nhan_vien.html"><span class="i i-file-openoffice"></span></a>&nbsp;
							<a title="Xác nhận đơn hàng" href="../xac_nhan_don_hang.html"><span class="i i-pencil"></span></a>&nbsp;							
						</td>
                      </tr>
					  <tr>
                        <td><label class="checkbox m-n i-checks"><input type="checkbox" name="post[]"><i></i></label></td>
                        <td>Idrawfast</td>
                        <td>4c</td>
						<td>4c</td>
						<td>4c</td>
                        <td>Jul 25, 2013</td>
                        <td>
                          Chờ xác nhận
                        </td> 
						<td> 
							<a title="Chi tiết dơn hàng" href="../chi_tiet_nhan_vien.html"><span class="i i-file-openoffice"></span></a>&nbsp;
							<a title="Xác nhận đơn hàng" href="../xac_nhan_don_hang.html"><span class="i i-pencil"></span></a>&nbsp;							
						</td>
                      </tr>
					  <tr>
                        <td><label class="checkbox m-n i-checks"><input type="checkbox" name="post[]"><i></i></label></td>
                        <td>Idrawfast</td>
                        <td>4c</td>
						<td>4c</td>
						<td>4c</td>
                        <td>Jul 25, 2013</td>
                        <td>
                          Chờ xác nhận
                        </td> 
						<td> 
							<a title="Chi tiết dơn hàng" href="../chi_tiet_nhan_vien.html"><span class="i i-file-openoffice"></span></a>&nbsp;
							<a title="Xác nhận đơn hàng" href="../xac_nhan_don_hang.html"><span class="i i-pencil"></span></a>&nbsp;							
						</td>
                      </tr>					  
                    </tbody>
					<!-- /.Content table -->
                  </table>
                </div>
                <footer class="panel-footer">
                  <div class="row">
                    <div class="col-sm-4 hidden-xs">
                      <select class="input-sm form-control input-s-sm inline v-middle">
                        <option value="0">Bulk action</option>
                        <option value="1">Delete selected</option>
                        <option value="2">Bulk edit</option>
                        <option value="3">Export</option>
                      </select>
                      <button class="btn btn-sm btn-default">Apply</button>                  
                    </div>
                    <div class="col-sm-4 text-center">
                      <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
                    </div>
                    <div class="col-sm-4 text-right text-center-xs">                
                      <ul class="pagination pagination-sm m-t-none m-b-none">
                        <li><a href="#"><i class="fa fa-chevron-left"></i></a></li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#"><i class="fa fa-chevron-right"></i></a></li>
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
  <!-- .Header -->
  <?php include 'partial/header.php'; ?>
  <!-- /.Header -->
</body>
</html>