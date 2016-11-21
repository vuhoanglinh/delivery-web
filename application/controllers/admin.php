<?php
session_start();
class Admin extends CI_Controller {  
    function __construct(){
        parent::__construct();
		$this->load->model('General');	
		$this->load->library('My_PHPMailer');	
		$this->load->model('Pagination_model');		
	}
	
	function index(){
		if(isset($_SESSION['login_admin_confirm']) && $_SESSION['login_admin_confirm'] == 1 && isset($_SESSION['login_admin_info']) && $_SESSION['login_admin_info'] != NULL){
			header("Location: ".site_url("admin/danh_sach_don_hang"));
		}else{
			header("Location: ".site_url("admin/login"));
		}
	}
	
	function login(){
		$this->load->view('admin/dang_nhap');
	}
	
	function submit_log(){
		if($this->input->post()){	
			$data = $this->input->post();
			if($data['email'] == ''){					
				$_SESSION['error'] = 'Vui lòng điền email đăng nhập';				
				header('Location: '.site_url('admin/login'));
				exit;
			}				
			if($data['mat_khau'] == '' ){
				$_SESSION['error'] = 'Vui lòng điền mật khẩu';
				header('Location: '.site_url('admin/login'));
				exit;
			}
			
			$res_count_user = $this->General->getItemsNoneActiveRecord("Select count(*) as countUser From user Where email = '".$data['email']."' && password = '".md5($data['mat_khau'])."' && loai_user = 3");
			if($res_count_user['0']['countUser'] == 0){
				$_SESSION['error'] = 'Tài khoản hoặc mật khẩu không đúng. Vui lòng thử lại';
				header('Location: '.site_url('admin/login'));
				exit;
			}	
			
			$res_info_user = $this->General->getItemsNoneActiveRecord("Select * From user Where email = '".$data['email']."' && password = '".md5($data['mat_khau'])."' && loai_user = 3");
			$_SESSION['login_admin_confirm'] = '1';
			$_SESSION['login_admin_info'] = $res_info_user['0'];
			
			$_SESSION['success'] = 'Ðăng nhập thành công';
			header('Location: '.site_url('admin/danh_sach_don_hang'));
			exit;			
		} else {
			$_SESSION['error'] = 'Vui lòng điền email và mật khẩu';
			header('Location: '.site_url('admin/login'));
			exit;
		}	
	}
	
	
	
	function danh_sach_don_hang(){
		if(isset($_SESSION['login_admin_confirm']) && $_SESSION['login_admin_confirm'] == 1 && isset($_SESSION['login_admin_info']) && $_SESSION['login_admin_info'] != NULL){
			$user_detail_login =  $_SESSION['login_admin_info'];
		}else{
			$_SESSION['error'] = "Bạn phải đăng nhập trước khi xem trang này";
			header("Location: ".site_url("admin/login"));
			exit;
		}
		
		$head_data['title'] = "Danh sách đơn hàng";
		$this->load->view('admin/partial/head',$head_data);
		
		/*PAGINATION*/
		 // pagination
		 $per_page = LIST_LIMIT;
		 
		 //$total_books = $this->Pagination_model->getTotal($table_name);		
		 $total_books = $this->General->getItemsNoneActiveRecord("Select count(*) as  total_ads From don_hang Order By ngay_tao DESC");
		 $this->load->library('pagination');
		 $config['total_rows'] = $total_books['0']['total_ads'];
		 $config['per_page'] = $per_page;
		 $config['next_link'] = '';
		 $config['prev_link'] = '';
		 $config['num_tag_open'] = '<li>';
		 $config['num_tag_close'] = '</li>';
		 $config['num_links']	= 5;
		 $config['cur_tag_open'] = '<li class="active"><a>';
		 $config['cur_tag_close'] = '</a></li>';
		 //$config['page_query_string'] = TRUE;
		 $config['base_url'] = base_url().'admin/danh_sach_don_hang/';
		 $config['uri_segment']	= 3; 
		 # Khởi tạo phân trang 
		 $this->pagination->initialize($config); 
		 # Tạo link phân trang 
		 $data['pagination'] = $this->pagination->create_links();		
		 $offset = ($this->uri->segment(3)=='') ? 0 : $this->uri->segment(3);		
		 //$offset = ($this->input->get('per_page')=='') ? 0 : $this->input->get('per_page');
         $limit = array('num_record' => $per_page, 'start' => $offset);		 
		/*End PAGINATION*/		
		
		$danh_sach_don_hang = $this->General->getItemsNoneActiveRecord("Select * From don_hang Order By ngay_tao DESC LIMIT ".$offset.",".$per_page);
		
		foreach($danh_sach_don_hang as $key => $dh){
			if($dh['id_giao_nhan'] != '0'){
				$res_gn = $this->General->getItemsNoneActiveRecord("Select ten from user where id = ".$dh['id_giao_nhan']." and loai_user = 2");			
				$danh_sach_don_hang[$key]['ten'] = $res_gn['0']['ten'];
			}		
		}
		
		$data['danh_sach'] = $danh_sach_don_hang;
		$data['tong'] = $total_books['0']['total_ads'];
		$this->load->view('admin/danh_sach_don_hang', $data);
	}
	
	function chi_tiet_don_hang($ma_don_hang){
		if(isset($_SESSION['login_admin_confirm']) && $_SESSION['login_admin_confirm'] == 1 && isset($_SESSION['login_admin_info']) && $_SESSION['login_admin_info'] != NULL){
			$user_detail_login =  $_SESSION['login_admin_info'];
		}else{
			$_SESSION['error'] = "Bạn phải đăng nhập trước khi xem trang này";
			header("Location: ".site_url("admin/login"));
			exit;
		}
		
		if(isset($ma_don_hang) && $ma_don_hang != ''){
			$thong_tin_don_hang = $this->General->getItemsNoneActiveRecord("Select * From don_hang Where id = ".$ma_don_hang);			
			if(count($thong_tin_don_hang) == 1){
				$data['don_hang'] = $thong_tin_don_hang['0'];
				$head_data['title'] = "Chi tiết đơn hàng";
				$this->load->view('admin/partial/head',$head_data);
				
				$this->load->view('admin/chi_tiet_don_hang',$data);
			}else{
				$_SESSION['error'] = 'Đơn hàng không tồn tại hoặc bị khóa bởi người quản trị';
				header('Location: '.site_url('admin/danh_sach_don_hang'));
				exit;
			}			
		}	
	}
	
	function cap_nhat_don_hang($ma_don_hang){
		if(isset($_SESSION['login_admin_confirm']) && $_SESSION['login_admin_confirm'] == 1 && isset($_SESSION['login_admin_info']) && $_SESSION['login_admin_info'] != NULL){
			$user_detail_login =  $_SESSION['login_admin_info'];
		}else{
			$_SESSION['error'] = "Bạn phải đăng nhập trước khi xem trang này";
			header("Location: ".site_url("admin/login"));
			exit;
		}
		
		if(isset($ma_don_hang) && $ma_don_hang != ''){
			$thong_tin_don_hang = $this->General->getItemsNoneActiveRecord("Select * From don_hang Where id = ".$ma_don_hang);			
			if(count($thong_tin_don_hang) == 1){
				$data['don_hang'] = $thong_tin_don_hang['0'];
				$head_data['title'] = "Cập nhật đơn hàng";
				$this->load->view('admin/partial/head',$head_data);
				
				$data['ds_nhan_vien'] = $this->General->getItemsNoneActiveRecord("Select id, ten From user Where loai_user = 2");							 
				$detail_don_hang = $this->General->getItemsNoneActiveRecord("Select * From don_hang Where id =".$ma_don_hang);							 
				$data['don_hang'] = $detail_don_hang['0'];
				
				$this->load->view('admin/cap_nhat_don_hang',$data);
			}else{
				$_SESSION['error'] = 'Đơn hàng không tồn tại hoặc bị khóa bởi người quản trị';
				header('Location: '.site_url('admin/danh_sach'));
				exit;
			}			
		}
	}
	
	function submit_cap_nhat_don_hang($ma_don_hang){
		if($this->input->post()){
			$data = $this->input->post();
			$ma_don_hang = $data['ma_don_hang'];
			
			if($data['ma_nhan_vien'] == ""){
				$_SESSION['error'] = 'Bạn chưa chọn nhân viên phụ trách đơn hàng';
				header('Location: '.site_url('admin/cap_nhat_don_hang/'.$ma_don_hang));
				exit;
			}
			
			if($data['trang_thai_don_hang'] == ""){
				$_SESSION['error'] = 'Bạn chưa chọn trạng thái đơn hàng';
				header('Location: '.site_url('admin/cap_nhat_don_hang/'.$ma_don_hang));
				exit;
			}
			
			if($data['trang_thai_don_hang'] == 5 && $data['ly_do'] == ""){
				$_SESSION['error'] = 'Bạn phải điền lý do giao hàng lỗi';
				header('Location: '.site_url('admin/cap_nhat_don_hang/'.$ma_don_hang));
				exit;
			}
			//cap nhat
			$data_update = array('id_giao_nhan' => $data['ma_nhan_vien'],
								'trang_thai_don_hang' => $data['trang_thai_don_hang'],
								'ly_do' => $data['ly_do']
								);
			$res = $this->General->updateItem('don_hang', $data_update, array('id' => $ma_don_hang));
			if($res){
				$_SESSION['success'] = 'Cập nhật đơn hàng thành công';
				header('Location: '.site_url('admin/danh_sach_don_hang'));
				exit;
			}else{
				$_SESSION['error'] = 'Cập nhật đơn hàng thất bại';
				header('Location: '.site_url('admin/cap_nhat_don_hang/'.$ma_don_hang));
				exit;
			}
		}else{
			$_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin đơn hàng';
			header('Location: '.site_url('admin/cap_nhat_don_hang/'.$ma_don_hang));
			exit;
		}
	}
	function logout(){
		unset($_SESSION['login_admin_confirm']);
		unset($_SESSION['login_admin_info']);
		$_SESSION['success'] = 'Bạn đã đăng xuất';
		header('Location: '.site_url('admin/login'));
		exit;
	}
	
	function tim_kiem(){
		if(isset($_SESSION['login_admin_confirm']) && $_SESSION['login_admin_confirm'] == 1 && isset($_SESSION['login_admin_info']) && $_SESSION['login_admin_info'] != NULL){
			$user_detail_login =  $_SESSION['login_admin_info'];
		}else{
			$_SESSION['error'] = "Bạn phải đăng nhập trước khi thực hiện thao tác này";
			header("Location: ".site_url("admin/danh_sach_don_hang"));
			exit;
		}
		
		if(!isset($_GET['s']) || empty($_GET['s'])){
			header('Location: '.site_url('admin/danh_sach_don_hang'));
			exit;
		}
				
		$s = $_GET['s'];			
		
		/*PAGINATION*/
		 // pagination
		 $per_page = LIST_LIMIT;
		 
		 //$total_books = $this->Pagination_model->getTotal($table_name);		
		 $total_books = $this->General->getItemsNoneActiveRecord("Select count(*) as  total_ads From don_hang WHERE dien_thoai_nguoi_nhan like '%".$s."%' or id = '%".$s."%' Order By ngay_tao DESC");
		 
		 $this->load->library('pagination');
		 $config['total_rows'] = $total_books['0']['total_ads'];
		 $config['per_page'] = $per_page;
		 $config['next_link'] = '';
		 $config['prev_link'] = '';
		 $config['num_tag_open'] = '<li>';
		 $config['num_tag_close'] = '</li>';
		 $config['num_links']	= 5;
		 $config['cur_tag_open'] = '<li class="active"><a>';
		 $config['cur_tag_close'] = '</a></li>';
		 $config['page_query_string'] = TRUE;
		 $config['base_url'] = base_url().'admin/tim_kiem/?s='.$s;		
		 //$config['uri_segment']	= 3; 
		 # Khởi tạo phân trang 
		 $this->pagination->initialize($config); 
		 # Tạo link phân trang 
		 $data['pagination'] = $this->pagination->create_links();		
		 $offset = ($this->input->get('per_page')=='') ? 0 : $this->input->get('per_page');		
         $limit = array('num_record' => $per_page, 'start' => $offset);		 
		/*End PAGINATION*/		
		
		$res_tim_kiem = $this->General->getItemsNoneActiveRecord("SELECT * FROM don_hang WHERE dien_thoai_nguoi_nhan like '%".$s."%' or id = '%".$s."%' Order By ngay_tao DESC LIMIT ".$offset.",".$per_page);
		
		foreach($res_tim_kiem as $key => $dh){
			if($dh['id_giao_nhan'] != '0'){
				$res_gn = $this->General->getItemsNoneActiveRecord("Select ten from user where id = ".$dh['id_giao_nhan']." and loai_user = 2");			
				$res_tim_kiem[$key]['ten'] = $res_gn['0']['ten'];
			}		
		}
		
		$head_data['title'] = "Tìm kiếm đơn hàng";
		$this->load->view('admin/partial/head',$head_data);
		
		$data['danh_sach'] = $res_tim_kiem;
		
		$data['tong'] = $total_books['0']['total_ads'];
		$this->load->view('admin/danh_sach_don_hang', $data);
	}
	
	function cau_hinh(){
		if(isset($_SESSION['login_admin_confirm']) && $_SESSION['login_admin_confirm'] == 1 && isset($_SESSION['login_admin_info']) && $_SESSION['login_admin_info'] != NULL){
			$user_detail_login =  $_SESSION['login_admin_info'];
		}else{
			$_SESSION['error'] = "Bạn phải đăng nhập trước khi thực hiện thao tác này";
			header("Location: ".site_url("admin/login"));
			exit;
		}
		
		$head_data['title'] = "Thiết lập tài khoản";
		$this->load->view('admin/partial/head',$head_data);
		
		$rs_detail = $this->General->getItemsNoneActiveRecord("Select * From user Where id = ".$user_detail_login['id']." and loai_user = 3");
		$data['admin'] = $rs_detail['0'];
	
		$this->load->view('admin/cau_hinh', $data);
	}
	
	function submit_cau_hinh(){
		if(isset($_SESSION['login_admin_confirm']) && $_SESSION['login_admin_confirm'] == 1 && isset($_SESSION['login_admin_info']) && $_SESSION['login_admin_info'] != NULL){
			$user_detail_login =  $_SESSION['login_admin_info'];
		}else{
			$_SESSION['error'] = "Bạn phải đăng nhập trước khi thực hiện thao tác này";
			header("Location: ".site_url("admin/login"));
			exit;
		}
		
		if($this->input->post()){
			$data = $this->input->post();			
			if($data['ten'] == ''){
				$_SESSION['ten'] = 'Vui lòng điền tên';
				header('Location: '.site_url('admin/cau_hinh'));
				exit;
			}
			if($data['dia_chi'] == ''){
				$_SESSION['error'] = 'Vui lòng điền địa chỉ';
				header('Location: '.site_url('admin/cau_hinh'));
				exit;
			}
			if($data['dien_thoai'] == ''){
				$_SESSION['error'] = 'Vui lòng điền số điện thoại';
				header('Location: '.site_url('admin/cau_hinh'));
				exit;
			}	
			if($data['email'] == ''){
				$_SESSION['error'] = 'Vui lòng điền email';
				header('Location: '.site_url('admin/cau_hinh'));
				exit;
			}			
			
			$data_update = array(	
									'ten' => $data['ten'],
									'dia_chi' => $data['dia_chi'], 
									'dien_thoai' => $data['dien_thoai'],								
									'email' => $data['email'],
									'khu_vuc' => $data['tinh_tp'],
									'quan_huyen' =>$data['quan_huyen']																		
								);
			if($data['password'] == "" && $data['re_password'] != ""){
				if($data['password'] == $data['re_password']){
					$data_update['password'] = md5($data['password']);
				}else{
					$_SESSION['error'] = 'Mật khẩu không trùng nhau';
					header('Location: '.site_url('admin/cau_hinh'));
					exit;
				}									
			}
			
			$res = $this->General->updateItem('user', $data_update, array('id' => $user_detail_login['id']));			
			if($res){
				//gan lai cho session
				$data_user = $this->General->getItemsNoneActiveRecord("SELECT * FROM user WHERE id = ".$user_detail_login['id']." && loai_user = 3");
				$_SESSION['login_admin_info'] = $data_user['0'];
				$_SESSION['success'] = 'Cập nhật thông tin thành công.';				
				header('Location: '.site_url('admin/cau_hinh'));
				exit;
			}else{
				$_SESSION['error'] = 'Cập nhật thông tin thất bại.';
				header('Location: '.site_url('admin/cau_hinh'));
				exit;
			}
		}else{
			$_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin';
			header('Location: '.site_url('admin/cau_hinh'));
			exit;
		}
	}
	
	function do_action(){		
		if($this->input->post()){
			$data = $this->input->post();
			if($data['check_item'] != NULL){		
				$list_item = implode(',', $data['check_item']);
				switch($data['action']){
					case 0: 
						$this->General->updateNoneActiveRecord("Update don_hang SET trang_thai_don_hang = 1 WHERE id IN (".$list_item.") && trang_thai_don_hang = 0");						
						break;
					case 1: 							
						$this->General->updateNoneActiveRecord("Update don_hang SET xoa = 1 WHERE id IN (".$list_item.")");						
						break;
					case 2: 													
						$this->General->updateNoneActiveRecord("Update don_hang SET xoa = 0 WHERE id IN (".$list_item.")");
						break;						
				}
				$_SESSION['success'] = "Hoàn tất";
				if(isset($_SESSION['url_refer']) && $_SESSION['url_refer'] != ""){
					header('Location: '.$_SESSION['url_refer']);
					exit;
				} else {
					header('Location: '.site_url('admin/danh_sach_don_hang'));
					exit;
				}	
			}else{
				if(isset($_SESSION['url_refer']) && $_SESSION['url_refer'] != ""){
					header('Location: '.$_SESSION['url_refer']);
					exit;
				} else {
					header('Location: '.site_url('admin/danh_sach_don_hang'));
					exit;
				}				
			}			
		} else {			
			if(isset($_SESSION['url_refer']) && $_SESSION['url_refer'] != ""){
				header('Location: '.$_SESSION['url_refer']);
				exit;
			} else {
				header('Location: '.site_url('admin/danh_sach_don_hang'));
				exit;
			}
		}
	}
	
	function do_action_khach_hang(){		
		if($this->input->post()){
			$data = $this->input->post();
			if($data['check_item'] != NULL){		
				$list_item = implode(',', $data['check_item']);
				switch($data['action']){					
					case 1: 							
						$this->General->updateNoneActiveRecord("Update user SET xoa = 1 WHERE id IN (".$list_item.") && loai_user = 1 ");						
						break;
					case 2: 													
						$this->General->updateNoneActiveRecord("Update user SET xoa = 0 WHERE id IN (".$list_item.") and loai_user = 1");
						break;						
				}
				$_SESSION['success'] = "Hoàn tất";
				if(isset($_SESSION['url_refer']) && $_SESSION['url_refer'] != ""){
					header('Location: '.$_SESSION['url_refer']);
					exit;
				} else {
					header('Location: '.site_url('admin/danh_sach_khach_hang'));
					exit;
				}	
			}else{
				if(isset($_SESSION['url_refer']) && $_SESSION['url_refer'] != ""){
					header('Location: '.$_SESSION['url_refer']);
					exit;
				} else {
					header('Location: '.site_url('admin/danh_sach_khach_hang'));
					exit;
				}				
			}			
		} else {			
			if(isset($_SESSION['url_refer']) && $_SESSION['url_refer'] != ""){
				header('Location: '.$_SESSION['url_refer']);
				exit;
			} else {
				header('Location: '.site_url('admin/danh_sach_khach_hang'));
				exit;
			}
		}
	}
	
	function do_action_giao_nhan(){		
		if($this->input->post()){
			$data = $this->input->post();
			if($data['check_item'] != NULL){		
				$list_item = implode(',', $data['check_item']);
				switch($data['action']){					
					case 1: 							
						$this->General->updateNoneActiveRecord("Update user SET xoa = 1 WHERE id IN (".$list_item.") and loai_user = 2");						
						break;
					case 2: 													
						$this->General->updateNoneActiveRecord("Update user SET xoa = 0 WHERE id IN (".$list_item.") and loai_user = 2");
						break;						
				}
				$_SESSION['success'] = "Hoàn tất";
				if(isset($_SESSION['url_refer']) && $_SESSION['url_refer'] != ""){
					header('Location: '.$_SESSION['url_refer']);
					exit;
				} else {
					header('Location: '.site_url('admin/danh_sach_khach_hang'));
					exit;
				}	
			}else{
				if(isset($_SESSION['url_refer']) && $_SESSION['url_refer'] != ""){
					header('Location: '.$_SESSION['url_refer']);
					exit;
				} else {
					header('Location: '.site_url('admin/danh_sach_khach_hang'));
					exit;
				}				
			}			
		} else {			
			if(isset($_SESSION['url_refer']) && $_SESSION['url_refer'] != ""){
				header('Location: '.$_SESSION['url_refer']);
				exit;
			} else {
				header('Location: '.site_url('admin/danh_sach_khach_hang'));
				exit;
			}
		}
	}
	
	function danh_sach_giao_nhan(){
		
		if(isset($_SESSION['login_admin_confirm']) && $_SESSION['login_admin_confirm'] == 1 && isset($_SESSION['login_admin_info']) && $_SESSION['login_admin_info'] != NULL){
			$user_detail_login =  $_SESSION['login_admin_info'];
		}else{
			$_SESSION['error'] = "Bạn phải đăng nhập trước khi xem trang này";
			header("Location: ".site_url("admin/login"));
			exit;
		}
		
		$head_data['title'] = "Danh sách giao nhận";
		$this->load->view('admin/partial/head',$head_data);
		
		/*PAGINATION*/
		 // pagination
		 $per_page = LIST_LIMIT;
		 
		 //$total_books = $this->Pagination_model->getTotal($table_name);		
		 $total_books = $this->General->getItemsNoneActiveRecord("Select count(*) as  total_gn From user where loai_user = 2 Order By ngay_tao DESC");
		 $this->load->library('pagination');
		 $config['total_rows'] = $total_books['0']['total_gn'];
		 $config['per_page'] = $per_page;
		 $config['next_link'] = '';
		 $config['prev_link'] = '';
		 $config['num_tag_open'] = '<li>';
		 $config['num_tag_close'] = '</li>';
		 $config['num_links']	= 5;
		 $config['cur_tag_open'] = '<li class="active"><a>';
		 $config['cur_tag_close'] = '</a></li>';
		 $config['base_url'] = base_url().'admin/danh_sach_giao_nhan/';
		 $config['uri_segment']	= 3; 
		 # Khởi tạo phân trang 
		 $this->pagination->initialize($config); 
		 # Tạo link phân trang 
		 $data['pagination'] = $this->pagination->create_links();		
		 $offset = ($this->uri->segment(3)=='') ? 0 : $this->uri->segment(3);		
         $limit = array('num_record' => $per_page, 'start' => $offset);		 
		/*End PAGINATION*/		
				
		//refer	URL
		if(!isset($_SESSION['url_refer'])){
			$_SESSION['url_refer'] = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		}else{
			unset($_SESSION['url_refer']);
			$_SESSION['url_refer'] = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		}	
			
		$danh_sach_giao_nhan = $this->General->getItemsNoneActiveRecord("Select * From user where loai_user = 2 Order By ngay_tao DESC LIMIT ".$offset.",".$per_page);
		$data['danh_sach'] = $danh_sach_giao_nhan;
		$data['tong'] = $total_books['0']['total_gn'];
		$this->load->view('admin/danh_sach_giao_nhan', $data);
	}
	
	function danh_sach_khach_hang(){
		
		if(isset($_SESSION['login_admin_confirm']) && $_SESSION['login_admin_confirm'] == 1 && isset($_SESSION['login_admin_info']) && $_SESSION['login_admin_info'] != NULL){
			$user_detail_login =  $_SESSION['login_admin_info'];
		}else{
			$_SESSION['error'] = "Bạn phải đăng nhập trước khi xem trang này";
			header("Location: ".site_url("admin/login"));
			exit;
		}
		
		$head_data['title'] = "Danh sách khách hàng";
		$this->load->view('admin/partial/head',$head_data);
		
		/*PAGINATION*/
		 // pagination
		 $per_page = LIST_LIMIT;
		 
		 //$total_books = $this->Pagination_model->getTotal($table_name);		
		 $total_books = $this->General->getItemsNoneActiveRecord("Select count(*) as  total_user From user where loai_user = 1 Order By ngay_tao DESC");
		 $this->load->library('pagination');
		 $config['total_rows'] = $total_books['0']['total_user'];
		 $config['per_page'] = $per_page;
		 $config['next_link'] = '';
		 $config['prev_link'] = '';
		 $config['num_tag_open'] = '<li>';
		 $config['num_tag_close'] = '</li>';
		 $config['num_links']	= 5;
		 $config['cur_tag_open'] = '<li class="active"><a>';
		 $config['cur_tag_close'] = '</a></li>';
		 $config['base_url'] = base_url().'admin/danh_sach_khach_hang/';
		 $config['uri_segment']	= 3; 
		 # Khởi tạo phân trang 
		 $this->pagination->initialize($config); 
		 # Tạo link phân trang 
		 $data['pagination'] = $this->pagination->create_links();		
		 $offset = ($this->uri->segment(3)=='') ? 0 : $this->uri->segment(3);		
         $limit = array('num_record' => $per_page, 'start' => $offset);		 
		/*End PAGINATION*/		
				
		//refer	URL
		if(!isset($_SESSION['url_refer'])){
			$_SESSION['url_refer'] = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		}else{
			unset($_SESSION['url_refer']);
			$_SESSION['url_refer'] = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		}	
			
		$danh_sach_khach_hang = $this->General->getItemsNoneActiveRecord("Select * From user where loai_user = 1 Order By ngay_tao DESC LIMIT ".$offset.",".$per_page);
		$data['tong'] = $total_books['0']['total_user'];
		$data['danh_sach'] = $danh_sach_khach_hang;
		$this->load->view('admin/danh_sach_khach_hang', $data);
	}
	function thong_ke(){
		$str = '';
		$str_ldh_0 = '';
		$str_ldh_4 = '';	
		$str_ldh_5 = '';
		$str_ldh_6 = '';		
		
		for($i=11 ; $i>=0 ; $i--){
			
			$str .= "'".date('d-m-Y', strtotime("-$i days"))."',";
			
			$ngay = strtotime("-$i days");
			$ngay_from = strtotime(date('d-m-Y 00:00:00', $ngay));
			$ngay_to = strtotime(date('d-m-Y 23:59:59', $ngay));
						
			$don_hang_0 = $this->General->getItemsNoneActiveRecord("SELECT COUNT(*) as countDonHang FROM don_hang WHERE  ngay_tao >= '".$ngay_from."' and ngay_tao <= '".$ngay_to."' and xoa = 0 and trang_thai_don_hang = 0");		
			$don_hang_4 = $this->General->getItemsNoneActiveRecord("SELECT COUNT(*) as countDonHang FROM don_hang WHERE  ngay_tao >= '".$ngay_from."' and ngay_tao <= '".$ngay_to."' and xoa = 0 and trang_thai_don_hang = 4");		
			$don_hang_5 = $this->General->getItemsNoneActiveRecord("SELECT COUNT(*) as countDonHang FROM don_hang WHERE  ngay_tao >= '".$ngay_from."' and ngay_tao <= '".$ngay_to."' and xoa = 0 and trang_thai_don_hang = 5");		
			$don_hang_6 = $this->General->getItemsNoneActiveRecord("SELECT COUNT(*) as countDonHang FROM don_hang WHERE  ngay_tao >= '".$ngay_from."' and ngay_tao <= '".$ngay_to."' and xoa = 0 and trang_thai_don_hang = 6");		
			
			$str_ldh_0 .= $don_hang_0['0']['countDonHang'] . ',';					
			$str_ldh_4 .= $don_hang_4['0']['countDonHang'] . ',';					
			$str_ldh_5 .= $don_hang_5['0']['countDonHang'] . ',';					
			$str_ldh_6 .= $don_hang_6['0']['countDonHang'] . ',';					
		}			
		
		$data['danh_sach_ngay'] = rtrim($str , ',');
		
		$data['danh_sach_don_hang_0'] = rtrim($str_ldh_0 , ',');
		$data['danh_sach_don_hang_4'] = rtrim($str_ldh_4 , ',');
		$data['danh_sach_don_hang_5'] = rtrim($str_ldh_5 , ',');
		$data['danh_sach_don_hang_6'] = rtrim($str_ldh_6 , ',');

		$this->load->view('admin/chart', $data);
	}
	
	function tim_kiem_giao_nhan(){
		if(isset($_SESSION['login_admin_confirm']) && $_SESSION['login_admin_confirm'] == 1 && isset($_SESSION['login_admin_info']) && $_SESSION['login_admin_info'] != NULL){
			$user_detail_login =  $_SESSION['login_admin_info'];
		}else{
			$_SESSION['error'] = "Bạn phải đăng nhập trước khi thực hiện thao tác này";
			header("Location: ".site_url("admin/danh_sach_giao_nhan"));
			exit;
		}
		
		if(!isset($_GET['s']) || empty($_GET['s'])){
			header('Location: '.site_url('admin/danh_sach_giao_nhan'));
			exit;
		}
		
		/*if(strlen($_GET['s']) < 3){
			$_SESSION['error'] = "Chuỗi cần tìm kiếm phải lớn  hơn 3 ký tự";
			header('Location: '.site_url('admin/danh_sach_giao_nhan'));
			exit;
		}*/
		$s = $_GET['s'];			
		
		/*PAGINATION*/
		 // pagination
		 $per_page = LIST_LIMIT;
		 
		 //$total_books = $this->Pagination_model->getTotal($table_name);		
		 $total_books = $this->General->getItemsNoneActiveRecord("Select count(*) as  total_gn From user WHERE loai_user = 2 and (ten like '%".$s."%' or ten like '%".$s."%' or ten like '%".$s."%' or id = '%".$s."%' or email = '%".$s."%') Order By ngay_tao DESC");
		 
		 $this->load->library('pagination');
		 $config['total_rows'] = $total_books['0']['total_gn'];
		 $config['per_page'] = $per_page;
		 $config['next_link'] = '';
		 $config['prev_link'] = '';
		 $config['num_tag_open'] = '<li>';
		 $config['num_tag_close'] = '</li>';
		 $config['num_links']	= 5;
		 $config['cur_tag_open'] = '<li class="active"><a>';
		 $config['cur_tag_close'] = '</a></li>';
		 $config['page_query_string'] = TRUE;
		 $config['base_url'] = base_url().'admin/tim_kiem_giao_nhan/?s='.$s;		
		 //$config['uri_segment']	= 3; 
		 # Khởi tạo phân trang 
		 $this->pagination->initialize($config); 
		 # Tạo link phân trang 
		 $data['pagination'] = $this->pagination->create_links();		
		 $offset = ($this->input->get('per_page')=='') ? 0 : $this->input->get('per_page');		
         $limit = array('num_record' => $per_page, 'start' => $offset);		 
		/*End PAGINATION*/				
		$res_tim_kiem = $this->General->getItemsNoneActiveRecord("SELECT * FROM user where loai_user = 2 and (ten like '%".$s."%' or dien_thoai like '%".$s."%' or dia_chi like '%".$s."%' or email = '%".$s."%' or id = '%".$s."%') Order By ngay_tao DESC LIMIT ".$offset.",".$per_page);
			
		//refer	URL
		if(!isset($_SESSION['url_refer'])){
			$_SESSION['url_refer'] = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		}else{
			unset($_SESSION['url_refer']);
			$_SESSION['url_refer'] = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		}
		
		$head_data['title'] = "Tìm kiếm giao nhận";
		$this->load->view('admin/partial/head',$head_data);
		$data['tong'] = $total_books['0']['total_gn'];
		$data['danh_sach'] = $res_tim_kiem;
		$this->load->view('admin/danh_sach_giao_nhan', $data);
	}
	function tim_kiem_khach_hang(){
		if(isset($_SESSION['login_admin_confirm']) && $_SESSION['login_admin_confirm'] == 1 && isset($_SESSION['login_admin_info']) && $_SESSION['login_admin_info'] != NULL){
			$user_detail_login =  $_SESSION['login_admin_info'];
		}else{
			$_SESSION['error'] = "Bạn phải đăng nhập trước khi thực hiện thao tác này";
			header("Location: ".site_url("admin/danh_sach_khach_hang"));
			exit;
		}
		
		if(!isset($_GET['s']) || empty($_GET['s'])){
			header('Location: '.site_url('admin/danh_sach_khach_hang'));
			exit;
		}
		
		/*if(strlen($_GET['s']) < 3){
			$_SESSION['error'] = "Chuỗi cần tìm kiếm phải lớn  hơn 3 ký tự";
			header('Location: '.site_url('admin/danh_sach_giao_nhan'));
			exit;
		}*/
		$s = $_GET['s'];			
		
		/*PAGINATION*/
		 // pagination
		 $per_page = LIST_LIMIT;
		 
		 //$total_books = $this->Pagination_model->getTotal($table_name);		
		 $total_books = $this->General->getItemsNoneActiveRecord("Select count(*) as  total_gn From user WHERE loai_user = 1 and (ten like '%".$s."%' or ten like '%".$s."%' or ten like '%".$s."%' or id = '%".$s."%' or email = '%".$s."%') Order By ngay_tao DESC");
		 
		 $this->load->library('pagination');
		 $config['total_rows'] = $total_books['0']['total_gn'];
		 $config['per_page'] = $per_page;
		 $config['next_link'] = '';
		 $config['prev_link'] = '';
		 $config['num_tag_open'] = '<li>';
		 $config['num_tag_close'] = '</li>';
		 $config['num_links']	= 5;
		 $config['cur_tag_open'] = '<li class="active"><a>';
		 $config['cur_tag_close'] = '</a></li>';
		 $config['page_query_string'] = TRUE;
		 $config['base_url'] = base_url().'admin/tim_kiem_giao_nhan/?s='.$s;		
		 //$config['uri_segment']	= 3; 
		 # Khởi tạo phân trang 
		 $this->pagination->initialize($config); 
		 # Tạo link phân trang 
		 $data['pagination'] = $this->pagination->create_links();		
		 $offset = ($this->input->get('per_page')=='') ? 0 : $this->input->get('per_page');		
         $limit = array('num_record' => $per_page, 'start' => $offset);		 
		/*End PAGINATION*/				
		$res_tim_kiem = $this->General->getItemsNoneActiveRecord("SELECT * FROM user where loai_user = 1 and (ten like '%".$s."%' or dien_thoai like '%".$s."%' or dia_chi like '%".$s."%' or email = '%".$s."%' or id = '%".$s."%') Order By ngay_tao DESC LIMIT ".$offset.",".$per_page);
			
		//refer	URL
		if(!isset($_SESSION['url_refer'])){
			$_SESSION['url_refer'] = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		}else{
			unset($_SESSION['url_refer']);
			$_SESSION['url_refer'] = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		}
		
		$head_data['title'] = "Tìm kiếm giao nhận";
		$this->load->view('admin/partial/head',$head_data);
		$data['tong'] = $total_books['0']['total_gn'];
		$data['danh_sach'] = $res_tim_kiem;
		$this->load->view('admin/danh_sach_giao_nhan', $data);
	}
	
	function xoa_giao_nhan($ma_giao_nhan){
		if(isset($_SESSION['login_admin_confirm']) && $_SESSION['login_admin_confirm'] == 1 && isset($_SESSION['login_admin_info']) && $_SESSION['login_admin_info'] != NULL){
			$user_detail_login =  $_SESSION['login_admin_info'];
		}else{
			$_SESSION['error'] = "Bạn phải đăng nhập trước khi thực hiện thao tác này";
			header("Location: ".site_url("admin/login"));
			exit;
		}
		
		if(isset($ma_giao_nhan) && $ma_giao_nhan != ''){
			$don_hang = $this->General->getItemsNoneActiveRecord("Select count(*) as countDonHang From user Where id = ".$ma_giao_nhan);
			if($don_hang['0']['countDonHang'] == 1){
				$res = $this->General->updateItem('user', array('xoa' => '1'), array('id' => $ma_giao_nhan, 'loai_user' => 2));
				if($res){
					$_SESSION['success'] = 'Xóa giao nhận thành công';
					header('Location: '.site_url('admin/danh_sach_giao_nhan'));
					exit;
				}else{
					$_SESSION['error'] = 'Xóa giao nhận thất bại';
					header('Location: '.site_url('admin/danh_sach_giao_nhan'));
					exit;
				}
				
			}else{
				$_SESSION['error'] = 'Giao nhận không tồn tại hoặc đã bị khóa bởi người quản trị';
				header('Location: '.site_url('admin/danh_sach_giao_nhan'));
				exit;
			}			
		}else{
			header('Location: '.site_url('admin/danh_sach_giao_nhan'));
			exit;
		}
	}
	
	function xoa_khach_hang($ma_khach_hang){
		if(isset($_SESSION['login_admin_confirm']) && $_SESSION['login_admin_confirm'] == 1 && isset($_SESSION['login_admin_info']) && $_SESSION['login_admin_info'] != NULL){
			$user_detail_login =  $_SESSION['login_admin_info'];
		}else{
			$_SESSION['error'] = "Bạn phải đăng nhập trước khi thực hiện thao tác này";
			header("Location: ".site_url("admin/login"));
			exit;
		}
		
		if(isset($ma_khach_hang) && $ma_khach_hang != ''){
			$don_hang = $this->General->getItemsNoneActiveRecord("Select count(*) as countDonHang From user Where id = ".$ma_khach_hang);
			if($don_hang['0']['countDonHang'] == 1){
				$res = $this->General->updateItem('user', array('xoa' => '1'), array('id' => $ma_khach_hang, 'loai_user' => 1));
				if($res){
					$_SESSION['success'] = 'Xóa khách hàng thành công';
					header('Location: '.site_url('admin/danh_sach_khach_hang'));
					exit;
				}else{
					$_SESSION['error'] = 'Xóa khách hàng thất bại';
					header('Location: '.site_url('admin/danh_sach_khach_hang'));
					exit;
				}				
			}else{
				$_SESSION['error'] = 'Khách hàng không tồn tại hoặc đã bị khóa bởi người quản trị';
				header('Location: '.site_url('admin/danh_sach_khach_hang'));
				exit;
			}			
		}else{
			header('Location: '.site_url('admin/danh_sach_khach_hang'));
			exit;
		}
	}
	
	function xoa_don_hang($ma_don_hang){
		if(isset($_SESSION['login_admin_confirm']) && $_SESSION['login_admin_confirm'] == 1 && isset($_SESSION['login_admin_info']) && $_SESSION['login_admin_info'] != NULL){
			$user_detail_login =  $_SESSION['login_admin_info'];
		}else{
			$_SESSION['error'] = "Bạn phải đăng nhập trước khi thực hiện thao tác này";
			header("Location: ".site_url("admin/login"));
			exit;
		}
		
		if(isset($ma_don_hang) && $ma_don_hang != ''){
			$don_hang = $this->General->getItemsNoneActiveRecord("Select count(*) as countDonHang From don_hang Where id = ".$ma_don_hang);
			if($don_hang['0']['countDonHang'] == 1){
				$res = $this->General->updateItem('don_hang', array('xoa' => '1'), array('id' => $ma_don_hang));
				if($res){
					$_SESSION['success'] = 'Xóa đơn hàng thành công';
					header('Location: '.site_url('admin/danh_sach_don_hang'));
					exit;
				}else{
					$_SESSION['error'] = 'Xóa đơn hàng thất bại';
					header('Location: '.site_url('admin/danh_sach_don_hang'));
					exit;
				}				
			}else{
				$_SESSION['error'] = 'Đơn hàng không tồn tại hoặc đã bị khóa bởi người quản trị';
				header('Location: '.site_url('admin/danh_sach_don_hang'));
				exit;
			}			
		}else{
			header('Location: '.site_url('admin/danh_sach_don_hang'));
			exit;
		}
	}
	
	function them_giao_nhan(){
		$head_data['title'] = "Thêm mới giao nhận";
		$this->load->view('admin/partial/head',$head_data);
		
		$this->load->view('admin/them_giao_nhan');
	}
	
	function submit_them_giao_nhan(){	
		if($this->input->post()){
			$data = $this->input->post();			
				if($data['ten'] == ''){					
					$_SESSION['error'] = 'Bạn chưa điền họ tên';
					
					header('Location: '.site_url('admin/them_giao_nhan'));
					exit;
				}
				if($data['email'] == ''){					
					$_SESSION['error'] = 'Bạn chưa điền email';
					
					header('Location: '.site_url('admin/them_giao_nhan'));
					exit;
				}				
				if($data['mat_khau'] == '' || $data['re_mat_khau'] == ''){
					$_SESSION['error'] = 'Bạn chưa điền mật khẩu';
					
					header('Location: '.site_url('admin/them_giao_nhan'));
					exit;
				}
				if($data['mat_khau'] !=  $data['re_mat_khau']){
					$_SESSION['error'] = 'Mật khẩu không trùng nhau';
					
					header('Location: '.site_url('admin/them_giao_nhan'));
					exit;
				}
				if($data['dia_chi'] == ''){
					$_SESSION['error'] = 'Bạn chưa điền địa chỉ';
					
					header('Location: '.site_url('admin/them_giao_nhan'));
					exit;
				}
				if($data['dien_thoai'] == ''){
					$_SESSION['error'] = 'Bạn chưa điền số điện thoại';
					
					header('Location: '.site_url('admin/them_giao_nhan'));
					exit;
				}				
				$res_count_user = $this->General->getItemsNoneActiveRecord("Select count(*) as countUser From user Where email = '".$data['email']."'");
				if($res_count_user['0']['countUser'] == 1){
					$_SESSION['error'] = 'Email đã tồn tại. Vui lòng chọn email khác để đăng ký. Xin cảm ơn.';
					
					header('Location: '.site_url('admin/them_giao_nhan'));
					exit;
				}								
				$ma_kich_hoat = substr(md5(time().$data['email']),2,7);				
				$res = $this->General->insertItem('user', array('ten' => $data['ten'], 
																'password' => md5($data['re_mat_khau']), 
																'email' => $data['email'], 
																'dia_chi' => $data['dia_chi'], 
																'dien_thoai' => $data['dien_thoai'],																
																'ngay_tao' => time(),
																'loai_user' => 2,
																'xac_nhan' => 1)
												);
				if($res) {				
					$_SESSION['success'] ='Thêm giao nhận thành công';						
					header('Location: '.site_url('admin/danh_sach_giao_nhan'));
					exit;					
				}else{
					$_SESSION['success'] ='Thêm giao nhận thất bại. Vui lòng thử lại.';					
					header('Location: '.site_url('admin/danh_sach_giao_nhan'));
					exit;
				}			
		} else {
			$_SESSION['error'] ='Vui lòng điền đầy đủ thông tin';
			
			header('Location: '.site_url('admin/them_giao_nhan'));
			exit;
		}	
	}
	
	function cap_nhat_giao_nhan($ma_giao_nhan){
		if(isset($_SESSION['login_admin_confirm']) && $_SESSION['login_admin_confirm'] == 1 && isset($_SESSION['login_admin_info']) && $_SESSION['login_admin_info'] != NULL){
			$user_detail_login =  $_SESSION['login_admin_info'];
		}else{
			$_SESSION['error'] = "Bạn phải đăng nhập trước khi thực hiện thao tác này";
			header("Location: ".site_url("admin/login"));
			exit;
		}
		
		if(isset($ma_giao_nhan) && $ma_giao_nhan != ''){
			$thong_tin_giao_nhan = $this->General->getItemsNoneActiveRecord("Select * From user Where id = ".$ma_giao_nhan." and loai_user = 2");			
			if(count($thong_tin_giao_nhan) == 1){
				$data['don_hang'] = $thong_tin_giao_nhan['0'];
				$head_data['title'] = "Cập nhật thông tin giao nhận";
				$this->load->view('admin/partial/head',$head_data);
				
				$data['ds_nhan_vien'] = $this->General->getItemsNoneActiveRecord("Select id, ten From user Where loai_user = 2");							 
				$detail_don_hang = $this->General->getItemsNoneActiveRecord("Select * From user Where id =".$ma_giao_nhan." and loai_user = 2");							 
				$data['giao_nhan'] = $detail_don_hang['0'];
				
				$this->load->view('admin/cap_nhat_giao_nhan', $data);
			}else{
				$_SESSION['error'] = 'Đơn hàng không tồn tại hoặc bị khóa bởi người quản trị';
				header('Location: '.site_url('admin/danh_sach_giao_nhan'));
				exit;
			}			
		}
		
		
	}
	
	
	function submit_cap_nhat_giao_nhan(){
		if(isset($_SESSION['login_admin_confirm']) && $_SESSION['login_admin_confirm'] == 1 && isset($_SESSION['login_admin_info']) && $_SESSION['login_admin_info'] != NULL){
			$user_detail_login =  $_SESSION['login_giao_nhan_info'];
		}else{
			$_SESSION['error'] = "Bạn phải đăng nhập trước khi thực hiện thao tác này";
			header("Location: ".site_url("admin/login"));
			exit;
		}
		
		if($this->input->post()){
			$data = $this->input->post();			
			if($data['ten'] == ''){
				$_SESSION['ten'] = 'Vui lòng điền tên';
				header('Location: '.site_url('admin/cap_nhat_giao_nhan'));
				exit;
			}
			if($data['dia_chi'] == ''){
				$_SESSION['error'] = 'Vui lòng điền địa chỉ';
				header('Location: '.site_url('admin/cap_nhat_giao_nhan'));
				exit;
			}
			if($data['dien_thoai'] == ''){
				$_SESSION['error'] = 'Vui lòng điền số điện thoại';
				header('Location: '.site_url('admin/cap_nhat_giao_nhan'));
				exit;
			}	
			if($data['email'] == ''){
				$_SESSION['error'] = 'Vui lòng điền email';
				header('Location: '.site_url('admin/cap_nhat_giao_nhan'));
				exit;
			}			
			
			$data_update = array(	
									'ten' => $data['ten'],
									'dia_chi' => $data['dia_chi'], 
									'dien_thoai' => $data['dien_thoai'],								
									'email' => $data['email'],
									'khu_vuc' => $data['tinh_tp'],
									'quan_huyen' =>$data['quan_huyen']																		
								);
			if($data['password'] == "" && $data['re_password'] != ""){
				if($data['password'] == $data['re_password']){
					$data_update['password'] = md5($data['password']);
				}else{
					$_SESSION['error'] = 'Mật khẩu không trùng nhau';
					header('Location: '.site_url('giao_nhan/cau_hinh'));
					exit;
				}									
			}
			
			$res = $this->General->updateItem('user', $data_update, array('id' => $user_detail_login['id']));			
			if($res){
				//gan lai cho session
				$data_user = $this->General->getItemsNoneActiveRecord("SELECT * FROM user WHERE id = ".$user_detail_login['id']." && loai_user = 2");
				$_SESSION['login_giao_nhan_info'] = $data_user['0'];
				$_SESSION['success'] = 'Cập nhật thông tin thành công.';				
				header('Location: '.site_url('giao_nhan/cau_hinh'));
				exit;
			}else{
				$_SESSION['error'] = 'Cập nhật thông tin thất bại.';
				header('Location: '.site_url('giao_nhan/cau_hinh'));
				exit;
			}
		}else{
			$_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin';
			header('Location: '.site_url('giao_nhan/cau_hinh'));
			exit;
		}
	}
	
	function tim_kiem_don_hang(){
		if(isset($_SESSION['login_admin_confirm']) && $_SESSION['login_admin_confirm'] == 1 && isset($_SESSION['login_admin_info']) && $_SESSION['login_admin_info'] != NULL){
			$user_detail_login =  $_SESSION['login_admin_info'];
		}else{
			$_SESSION['error'] = "Bạn phải đăng nhập trước khi thực hiện thao tác này";
			header("Location: ".site_url("admin/danh_sach_don_hang"));
			exit;
		}
		
		if(!$this->input->get()){
			header('Location: '.site_url('admin/danh_sach_don_hang'));
			exit;
		}
				
		$data = $this->input->get();
		$where = " WHERE 1 ";
		$ngay_tao = '';
		if(isset($data['ngay_tao']) && !empty($data['ngay_tao'])){
			$ngay_tao = $data['ngay_tao'];
			$arrDate = explode('/',$data['ngay_tao']);
			$ngay_from = mktime(0,0,0,$arrDate['1'],$arrDate['0'],$arrDate['2']);
			$ngay_to = mktime(23,59,59,$arrDate['1'],$arrDate['0'],$arrDate['2']);			
			$where .= " && ngay_tao >= ".$ngay_from." && ngay_tao <= ".$ngay_to." ";
		}
		$trang_thai_don_hang = '';
		if(isset($data['trang_thai_don_hang']) && $data['trang_thai_don_hang'] != 'all' && !empty($data['trang_thai_don_hang']) ){
			$trang_thai_don_hang = $data['trang_thai_don_hang'];			
			$where .= " && trang_thai_don_hang = ".$trang_thai_don_hang." ";
		}
		$ma_don_hang = '';
		if(isset($data['ma_don_hang']) && !empty($data['ma_don_hang']) ){
			$ma_don_hang = $data['ma_don_hang'];
			$where .= " && id = ".$ma_don_hang." ";
		}
		
		/*PAGINATION*/
		 // pagination
		 $per_page = LIST_LIMIT;
		 
		 //$total_books = $this->Pagination_model->getTotal($table_name);		
		 $total_books = $this->General->getItemsNoneActiveRecord("Select count(*) as  total_ads From don_hang ".$where." Order By ngay_tao DESC");
		 
		 $this->load->library('pagination');
		 $config['total_rows'] = $total_books['0']['total_ads'];
		 $config['per_page'] = $per_page;
		 $config['next_link'] = '';
		 $config['prev_link'] = '';
		 $config['num_tag_open'] = '<li>';
		 $config['num_tag_close'] = '</li>';
		 $config['num_links']	= 5;
		 $config['cur_tag_open'] = '<li class="active"><a>';
		 $config['cur_tag_close'] = '</a></li>';
		 $config['page_query_string'] = TRUE;
		 $config['base_url'] = base_url().'admin/tim_kiem_don_hang?ma_don_hang='.$ma_don_hang.'&trang_thai_don_hang='.$trang_thai_don_hang.'&ngay_from='.$ngay_tao;		
		 //$config['uri_segment']	= 3; 
		 # Khởi tạo phân trang 
		 $this->pagination->initialize($config); 
		 # Tạo link phân trang 
		 $data['pagination'] = $this->pagination->create_links();		
		 $offset = ($this->input->get('per_page')=='') ? 0 : $this->input->get('per_page');		
         $limit = array('num_record' => $per_page, 'start' => $offset);		 
		/*End PAGINATION*/		
		
		$res_tim_kiem = $this->General->getItemsNoneActiveRecord("SELECT * FROM don_hang ".$where." Order By ngay_tao DESC LIMIT ".$offset.",".$per_page);
		if(count($res_tim_kiem) > 0){
			foreach($res_tim_kiem as $key => $dh){
				if($dh['id_giao_nhan'] != 0 && !empty($dh['id_giao_nhan'] )){
					$res_gn = $this->General->getItemsNoneActiveRecord("Select ten from user where id = ".$dh['id_giao_nhan']." and loai_user = 2");			
					$res_tim_kiem[$key]['ten'] = $res_gn['0']['ten'];
				}		
			}
		}
		
		
		$head_data['title'] = "Tìm kiếm đơn hàng";
		$this->load->view('admin/partial/head',$head_data);
		
		$data['danh_sach'] = $res_tim_kiem;
		
		$data['tong'] = $total_books['0']['total_ads'];
		$this->load->view('admin/danh_sach_don_hang', $data);
	}
	
	function cap_nhat($ma_don_hang){
		if(isset($ma_don_hang) && $ma_don_hang != ''){
			$thong_tin_don_hang = $this->General->getItemsNoneActiveRecord("Select * From don_hang Where id = ".$ma_don_hang);			
			if(count($thong_tin_don_hang) == 1){
				$data['don_hang'] = $thong_tin_don_hang['0'];
				$head_data['title'] = "Chỉnh sửa đơn hàng";
				$this->load->view('admin/partial/head',$head_data);
				
				$this->load->view('admin/cap_nhat',$data);
			}else{
				$_SESSION['error'] = 'Đơn hàng không tồn tại hoặc bị khóa bởi người quản trị';
				header('Location: '.site_url('admin/danh_sach_don_hang'));
				exit;
			}			
		}
	}
	
	function submit_cap_nhat(){
		if(isset($_SESSION['login_admin_confirm']) && $_SESSION['login_admin_confirm'] == 1 && isset($_SESSION['login_admin_info']) && $_SESSION['login_admin_info'] != NULL){
			$user_detail_login =  $_SESSION['login_admin_info'];
		}else{
			$_SESSION['error'] = "Bạn phải đăng nhập trước khi xem trang này";
			header("Location: ".site_url("admin/login"));
			exit;
		}
		
		if($this->input->post()){
			$data = $this->input->post();
			$ma_don_hang = $data['ma_don_hang'];
			if($data['dia_chi_kho'] == ''){
				$_SESSION['error'] = 'Vui lòng điền địa chỉ lấy hàng';
				header('Location: '.site_url('admin/cap_nhat/'.$ma_don_hang));
				exit;
			}
			if($data['ten_hang_hoa'] == '' || $data['so_luong'] == '' || $data['khoi_luong'] == '' || $data['tong_gia_tri'] == '' ){
				$_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin hàng hóa';
				header('Location: '.site_url('admin/cap_nhat/'.$ma_don_hang));
				exit;
			}
			if($data['ten_nguoi_nhan'] == '' || $data['so_dien_thoai'] == '' || $data['dia_chi_nguoi_nhan'] == '' || $data['tinh_tp'] == ''  || $data['quan_huyen'] == ''){
				$_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin người nhận hàng';
				header('Location: '.site_url('admin/cap_nhat/'.$ma_don_hang));
				exit;
			}
			
			//thêm vào đơn hàng
			$is_cod = 0;
			$cod = 0;
			if(isset($data['dich_vu']['cod']) && $data['dich_vu']['cod'] == 'yes'){
				$is_cod = 1;
				$cod = $data['tong_gia_tri'];
			}
			$is_free = 0;
			if(isset($data['dich_vu']['free']) && $data['dich_vu']['free'] == 'yes'){
				$is_free = 1;				
			}
			$is_bao_hiem = 0;
			if(isset($data['dich_vu']['bao_hiem']) && $data['dich_vu']['bao_hiem'] == 'yes'){
				$is_bao_hiem = 1;
			}
			$is_hang_de_vo = 0;
			if(isset($data['dich_vu']['hang_de_vo']) && $data['dich_vu']['hang_de_vo'] == 'yes'){
				$is_hang_de_vo = 1;
			}
			
			//tinh phi giao hang
			$phi_giao_hang = 0;
			
			$data_update = array(										
									'hinh_thuc_giao_hang' => $data['dich_vu_van_chuyen'], 
									'dia_chi_lay_hang' => $data['dia_chi_kho'],								
									'is_cod' => $is_cod,
									'is_free' => $is_free,
									'is_bao_hiem' => $is_bao_hiem,
									'is_de_vo' => $is_hang_de_vo,								
									'ten_nguoi_nhan' => $data['ten_nguoi_nhan'],
									'dien_thoai_nguoi_nhan' => $data['so_dien_thoai'],
									'email_nguoi_nhan' => $data['email_nguoi_nhan'],
									'dia_chi_giao_hang' => $data['dia_chi_nguoi_nhan'],
									'tong_tien' => $data['tong_gia_tri'],
									'ten_hang_hoa' => $data['ten_hang_hoa'],
									'khoi_luong' => $data['khoi_luong'],
									'so_luong' => $data['so_luong'],														
									'cod' => $cod,
									'phi_giao_hang' => $phi_giao_hang,
									'khu_vuc' => $data['tinh_tp'],
									'quan_huyen' => $data['quan_huyen'],
									'mo_ta' => $data['mo_ta'],
									'ghi_chu' => $data['ghi_chu'],														
								);
			$res = $this->General->updateItem('don_hang', $data_update, array('id' => $ma_don_hang));			
			if($res){
				$_SESSION['success'] = 'Cập nhật đơn hàng thành công. Đơn hàng của bạn sẽ được xử lý trong vòng 12-24h giờ làm việc. Xin cảm ơn';
				header('Location: '.site_url('admin/danh_sach_don_hang'));
				exit;
			}else{
				$_SESSION['error'] = 'Cập nhật đơn hàng thất bại. Vui lòng kiểm tra lại thông tin đơn hàng';
				header('Location: '.site_url('admin/cap_nhat/'.$ma_don_hang));
				exit;
			}
		}else{
			$_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin đơn hàng';
			header('Location: '.site_url('admin/cap_nhat/'.$ma_don_hang));
			exit;
		}
	}
}
?>