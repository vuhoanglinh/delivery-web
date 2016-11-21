<?php if(!isset($_SESSION['login_admin_confirm']) || $_SESSION['login_admin_confirm'] != 1){
	$_SESSION['error'] = 'Bạn phải đăng nhập trước khi xem trang này';
	header('Location: '.site_url('admin/login'));
	exit;
}
?>
<!DOCTYPE html>
<html lang="en" class="app">
<head>  
  <meta charset="utf-8" />
  <title>Thống kê đơn hàng</title>
  <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
  <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/animate.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/icon.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/font.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/app.css" type="text/css" />  
  
  <!--[if lt IE 9]>
    <script src="js/ie/html5shiv.js"></script>
    <script src="js/ie/respond.min.js"></script>
    <script src="js/ie/excanvas.js"></script>
  <![endif]-->
</head>
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
                <div class="row">
                  <div class="col-sm-6">
                    <h3 class="m-b-none">Thống kê</h3>                 
                  </div>                 
                </div>
              </div>
              <section class="panel panel-default">
                <!-- chart ở đây -->
					<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
					<script type="text/javascript">
						$(function () {
							$('#container').highcharts({
								title: {
									text: 'Thống kê đơn hàng theo ngày',
									x: -20 //center
								},
								subtitle: {
									text: '',
									x: -20
								},
								xAxis: {
									categories: [<?php echo $danh_sach_ngay; ?>]
								},
								yAxis: {
									title: {
										text: 'Số đơn hàng'
									},
									plotLines: [{
										value: 0,
										width: 1,
										color: '#808080'
									}]
								},
								tooltip: {
									valueSuffix: ' (Đơn)'
								},
								legend: {
									layout: 'vertical',
									align: 'right',
									verticalAlign: 'middle',
									borderWidth: 0
								},
								series: [{
									name: 'Đơn hàng mới',
									data: [<?php echo $danh_sach_don_hang_0; ?>]
								},{
									name: 'Đơn hàng đã giao',
									data: [<?php echo $danh_sach_don_hang_4; ?>]
								},{
									name: 'Đơn hàng giao lỗi',
									data: [<?php echo $danh_sach_don_hang_5; ?>]
								},
								{
									name: 'Đơn hàng đã hủy',
									data: [<?php echo $danh_sach_don_hang_6; ?>]
								}]
							});
						});
					</script>
					<script src="<?php echo ASSETS_URL; ?>hightchart/highcharts.js"></script>					
					<script src="<?php echo ASSETS_URL; ?>hightchart/modules/exporting.js"></script>

					<!-- Additional files for the Highslide popup effect -->
					<script type="text/javascript" src="http://www.highcharts.com/media/com_demo/highslide-full.min.js"></script>
					<script type="text/javascript" src="http://www.highcharts.com/media/com_demo/highslide.config.js" charset="utf-8"></script>
					<link rel="stylesheet" type="text/css" href="http://www.highcharts.com/media/com_demo/highslide.css" />
					<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto">
					</div>				
              </section>
            </section>
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
        </section>
      </section>
    </section>
  </section>
 
  <!-- Bootstrap -->
  <script src="<?php echo ASSETS_URL; ?>js/bootstrap.js"></script>
  <!-- App -->
  <script src="<?php echo ASSETS_URL; ?>js/app.js"></script>  
  <script src="<?php echo ASSETS_URL; ?>js/slimscroll/jquery.slimscroll.min.js"></script>
    <!-- Sparkline Chart -->
  <script src="<?php echo ASSETS_URL; ?>js/charts/sparkline/jquery.sparkline.min.js"></script>
  <!-- Easy Pie Chart -->
  <script src="<?php echo ASSETS_URL; ?>js/charts/easypiechart/jquery.easy-pie-chart.js"></script>
  <!-- Flot -->
  <script src="<?php echo ASSETS_URL; ?>js/charts/flot/jquery.flot.min.js"></script>
  <script src="<?php echo ASSETS_URL; ?>js/charts/flot/jquery.flot.tooltip.min.js"></script>
  <script src="<?php echo ASSETS_URL; ?>js/charts/flot/jquery.flot.resize.js"></script>
  <script src="<?php echo ASSETS_URL; ?>js/charts/flot/jquery.flot.orderBars.js"></script>
  <script src="<?php echo ASSETS_URL; ?>js/charts/flot/jquery.flot.pie.min.js"></script>
  <script src="<?php echo ASSETS_URL; ?>js/charts/flot/jquery.flot.grow.js"></script>
  <script src="<?php echo ASSETS_URL; ?>js/charts/flot/demo.js"></script>
  <script src="<?php echo ASSETS_URL; ?>js/app.plugin.js"></script>
</body>
</html>