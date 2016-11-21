<?php
session_start();
class Giao_nhan extends CI_Controller {  
    function __construct(){
        parent::__construct();
		$this->load->model('General');	
		$this->load->library('My_PHPMailer');	
		$this->load->model('Pagination_model');		
	}
	
	function index(){
		if(isset($_SESSION['login_giao_nhan_confirm']) && $_SESSION['login_giao_nhan_confirm'] == 1 && isset($_SESSION['login_giao_nhan_info']) && $_SESSION['login_giao_nhan_info'] != NULL){
			header("Location: ".site_url("giao_nhan/danh_sach_don_hang"));
		}else{
			header("Location: ".site_url("giao_nhan/login"));
		}
	}
	
	function login(){
		$this->load->view('giao_nhan/dang_nhap');
	}
	
	function submit_log(){
		if($this->input->post()){	
			$data = $this->input->post();
			if($data['email'] == ''){					
				$_SESSION['error'] = 'Vui lòng điền email đăng nhập';				
				header('Location: '.site_url('giao_nhan/login'));
				exit;
			}				
			if($data['mat_khau'] == '' ){
				$_SESSION['error'] = 'Vui lòng điền mật khẩu';
				header('Location: '.site_url('giao_nhan/login'));
				exit;
			}
			
			$res_count_user = $this->General->getItemsNoneActiveRecord("Select count(*) as countUser From user Where email = '".$data['email']."' && password = '".md5($data['mat_khau'])."' && loai_user = 2");
			if($res_count_user['0']['countUser'] == 0){
				$_SESSION['error'] = 'Tài khoản hoặc mật khẩu không đúng. Vui lòng thử lại';
				header('Location: '.site_url('giao_nhan/login'));
				exit;
			}	
			
			$res_info_user = $this->General->getItemsNoneActiveRecord("Select * From user Where email = '".$data['email']."' && password = '".md5($data['mat_khau'])."' && loai_user = 2");
			$_SESSION['login_giao_nhan_confirm'] = '1';
			$_SESSION['login_giao_nhan_info'] = $res_info_user['0'];
			
			$_SESSION['success'] = 'Ðăng nhập thành công';
			header('Location: '.site_url('giao_nhan/danh_sach_don_hang'));
			exit;			
		} else {
			$_SESSION['error'] = 'Vui lòng điền email và mật khẩu';
			header('Location: '.site_url('giao_nhan/login'));
			exit;
		}	
	}
	function danh_sach_don_hang(){
		if(isset($_SESSION['login_giao_nhan_confirm']) && $_SESSION['login_giao_nhan_confirm'] == 1 && isset($_SESSION['login_giao_nhan_info']) && $_SESSION['login_giao_nhan_info'] != NULL){
			$user_detail_login =  $_SESSION['login_giao_nhan_info'];
		}else{
			$_SESSION['error'] = "Bạn phải đăng nhập trước khi xem trang này";
			header("Location: ".site_url("giao_nhan/login"));
			exit;
		}
		
		$head_data['title'] = "Danh sách đơn hàng";
		$this->load->view('giao_nhan/partial/head',$head_data);
		
		$loai = 'all';
		if(isset($_GET['loai']) && $_GET['loai'] != ''){
			$loai = $this->input->get('loai');		
		}
		/*PAGINATION*/
		 // pagination
		 $per_page = LIST_LIMIT;
		 
		 //$total_books = $this->Pagination_model->getTotal($table_name);
		 if($loai == 'all'){
			$total_books = $this->General->getItemsNoneActiveRecord("Select count(*) as  total_ads From don_hang WHERE id_giao_nhan = ".$user_detail_login['id']." Order By ngay_tao DESC");
		 } else {
			$total_books = $this->General->getItemsNoneActiveRecord("Select count(*) as  total_ads From don_hang WHERE id_giao_nhan = ".$user_detail_login['id']." and trang_thai_don_hang = ".$loai." Order By ngay_tao DESC");
		 }
		 
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
		 $config['base_url'] = base_url().'giao_nhan/danh_sach_don_hang?loai='.$loai;
		 $config['uri_segment']	= 3; 
		 # Khởi tạo phân trang 
		 $this->pagination->initialize($config); 
		 # Tạo link phân trang 
		 $data['pagination'] = $this->pagination->create_links();		
		 //$offset = ($this->uri->segment(3)=='') ? 0 : $this->uri->segment(3);		
		 $offset = ($this->input->get('per_page')=='') ? 0 : $this->input->get('per_page');
         $limit = array('num_record' => $per_page, 'start' => $offset);		 
		/*End PAGINATION*/		
		if($loai == 'all'){
			$danh_sach_don_hang = $this->General->getItemsNoneActiveRecord("Select * From don_hang WHERE id_giao_nhan = ".$user_detail_login['id']." Order By ngay_tao DESC LIMIT ".$offset.",".$per_page);			
		}else{
			$danh_sach_don_hang = $this->General->getItemsNoneActiveRecord("Select * From don_hang WHERE id_giao_nhan = ".$user_detail_login['id']." and trang_thai_don_hang = ".$loai." Order By ngay_tao DESC LIMIT ".$offset.",".$per_page);			
		}
		
		$data['danh_sach'] = $danh_sach_don_hang;
		$data['tong'] = $total_books['0']['total_ads'];
		$data['page_title'] = "Danh sách đơn hàng ";
		switch($loai){
			case '0':	$data['page_title'] .= 'chờ xác nhận';
				break;
			case '1':	$data['page_title'] .= 'đã xác nhận';
				break;
			case '2':	$data['page_title'] .= 'đang lấy hàng';
				break;								
			case '3':	$data['page_title'] .= 'đang giao';
				break;		
			case '4':	$data['page_title'] .= 'giao thành công';
				break;		
			case '5':	$data['page_title'] .= 'giao lỗi';
				break;		
			case '6':	$data['page_title'] .= 'đã hủy';
				break;	
			case 'all': $data['page_title'] .= '';
				break;
		} 
		$this->load->view('giao_nhan/danh_sach_don_hang', $data);
	}
	
	function chi_tiet_don_hang($ma_don_hang){
		if(isset($ma_don_hang) && $ma_don_hang != ''){
			$thong_tin_don_hang = $this->General->getItemsNoneActiveRecord("Select * From don_hang Where id = ".$ma_don_hang);			
			if(count($thong_tin_don_hang) == 1){
				$data['don_hang'] = $thong_tin_don_hang['0'];
				$head_data['title'] = "Chi tiết đơn hàng";
				$this->load->view('giao_nhan/partial/head',$head_data);
				
				$this->load->view('giao_nhan/chi_tiet_don_hang',$data);
			}else{
				$_SESSION['error'] = 'Đơn hàng không tồn tại hoặc bị khóa bởi người quản trị';
				header('Location: '.site_url('giao_nhan/danh_sach_don_hang'));
				exit;
			}			
		}	
	}
	
	function cap_nhat_don_hang($ma_don_hang){
		if(isset($ma_don_hang) && $ma_don_hang != ''){
			$thong_tin_don_hang = $this->General->getItemsNoneActiveRecord("Select * From don_hang Where id = ".$ma_don_hang);			
			if(count($thong_tin_don_hang) == 1){
				$data['don_hang'] = $thong_tin_don_hang['0'];
				$head_data['title'] = "Cập nhật đơn hàng";
				$this->load->view('giao_nhan/partial/head',$head_data);
				
				$data['ds_nhan_vien'] = $this->General->getItemsNoneActiveRecord("Select id, ten From user Where loai_user = 2");							 
				$detail_don_hang = $this->General->getItemsNoneActiveRecord("Select * From don_hang Where id =".$ma_don_hang);							 
				$data['don_hang'] = $detail_don_hang['0'];
				
				$this->load->view('giao_nhan/cap_nhat_don_hang',$data);
			}else{
				$_SESSION['error'] = 'Đơn hàng không tồn tại hoặc bị khóa bởi người quản trị';
				header('Location: '.site_url('giao_nhan/danh_sach'));
				exit;
			}			
		}
	}
	
	function submit_cap_nhat_don_hang($ma_don_hang){
		if($this->input->post()){
			$data = $this->input->post();
			$ma_don_hang = $data['ma_don_hang'];					
			
			if($data['trang_thai_don_hang'] == ""){
				$_SESSION['error'] = 'Bạn chưa chọn trạng thái đơn hàng';
				header('Location: '.site_url('giao_nhan/cap_nhat_don_hang/'.$ma_don_hang));
				exit;
			}
			
			if($data['trang_thai_don_hang'] == 5 && $data['ly_do'] == ""){
				$_SESSION['error'] = 'Bạn phải điền lý do giao hàng lỗi';
				header('Location: '.site_url('giao_nhan/cap_nhat_don_hang/'.$ma_don_hang));
				exit;
			}
			//cap nhat
			$data_update = array('trang_thai_don_hang' => $data['trang_thai_don_hang'],
								'ly_do' => $data['ly_do']
								);
			$res = $this->General->updateItem('don_hang', $data_update, array('id' => $ma_don_hang));
			if($res){
				$_SESSION['success'] = 'Cập nhật đơn hàng thành công';
				header('Location: '.site_url('giao_nhan/danh_sach_don_hang'));
				exit;
			}else{
				$_SESSION['error'] = 'Cập nhật đơn hàng thất bại';
				header('Location: '.site_url('giao_nhan/cap_nhat_don_hang/'.$ma_don_hang));
				exit;
			}
		}else{
			$_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin đơn hàng';
			header('Location: '.site_url('giao_nhan/cap_nhat_don_hang/'.$ma_don_hang));
			exit;
		}
	}
	function logout(){
		unset($_SESSION['login_giao_nhan_confirm']);
		unset($_SESSION['login_giao_nhan_info']);
		$_SESSION['success'] = 'Bạn đã đăng xuất';
		header('Location: '.site_url('giao_nhan/login'));
		exit;
	}
	
	function tim_kiem(){
		if(isset($_SESSION['login_giao_nhan_confirm']) && $_SESSION['login_giao_nhan_confirm'] == 1 && isset($_SESSION['login_giao_nhan_info']) && $_SESSION['login_giao_nhan_info'] != NULL){
			$user_detail_login =  $_SESSION['login_giao_nhan_info'];
		}else{
			$_SESSION['error'] = "Bạn phải đăng nhập trước khi thực hiện thao tác này";
			header("Location: ".site_url("giao_nhan/danh_sach_don_hang"));
			exit;
		}
		
		if(!isset($_GET['s']) || empty($_GET['s'])){
			header('Location: '.site_url('giao_nhan/danh_sach_don_hang'));
			exit;
		}
		
		if(strlen($_GET['s']) < 3){
			$_SESSION['error'] = "Chuỗi cần tìm kiếm phải lớn  hơn 3 ký tự";
			header('Location: '.site_url('giao_nhan/danh_sach_don_hang'));
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
		 $config['base_url'] = base_url().'giao_nhan/tim_kiem/?s='.$s;		
		 //$config['uri_segment']	= 3; 
		 # Khởi tạo phân trang 
		 $this->pagination->initialize($config); 
		 # Tạo link phân trang 
		 $data['pagination'] = $this->pagination->create_links();		
		 $offset = ($this->input->get('per_page')=='') ? 0 : $this->input->get('per_page');		
         $limit = array('num_record' => $per_page, 'start' => $offset);		 
		/*End PAGINATION*/		
		
		$res_tim_kiem = $this->General->getItemsNoneActiveRecord("SELECT * FROM don_hang Order By ngay_tao DESC LIMIT ".$offset.",".$per_page);			
		
		$head_data['title'] = "Tìm kiếm đơn hàng";
		$this->load->view('giao_nhan/partial/head',$head_data);
		$data['page_title'] = "Danh sách đơn hàng";
		$data['tong'] = $total_books['0']['total_ads'];
		$data['danh_sach'] = $res_tim_kiem;
		$this->load->view('giao_nhan/danh_sach_don_hang', $data);
	}
	
	function cau_hinh(){
		if(isset($_SESSION['login_giao_nhan_confirm']) && $_SESSION['login_giao_nhan_confirm'] == 1 && isset($_SESSION['login_giao_nhan_info']) && $_SESSION['login_giao_nhan_info'] != NULL){
			$user_detail_login =  $_SESSION['login_giao_nhan_info'];
		}else{
			$_SESSION['error'] = "Bạn phải đăng nhập trước khi thực hiện thao tác này";
			header("Location: ".site_url("giao_nhan/login"));
			exit;
		}
		
		$head_data['title'] = "Thiết lập tài khoản";
		$this->load->view('giao_nhan/partial/head',$head_data);
		
		$rs_detail = $this->General->getItemsNoneActiveRecord("Select * From user Where id = ".$user_detail_login['id']." and loai_user = 2");
		$data['giao_nhan'] = $rs_detail['0'];
	
		$this->load->view('giao_nhan/cau_hinh', $data);
	}
	
	function submit_cau_hinh(){
		if(isset($_SESSION['login_giao_nhan_confirm']) && $_SESSION['login_giao_nhan_confirm'] == 1 && isset($_SESSION['login_giao_nhan_info']) && $_SESSION['login_giao_nhan_info'] != NULL){
			$user_detail_login =  $_SESSION['login_giao_nhan_info'];
		}else{
			$_SESSION['error'] = "Bạn phải đăng nhập trước khi thực hiện thao tác này";
			header("Location: ".site_url("giao_nhan/login"));
			exit;
		}
		
		if($this->input->post()){
			$data = $this->input->post();			
			if($data['ten'] == ''){
				$_SESSION['ten'] = 'Vui lòng điền tên';
				header('Location: '.site_url('giao_nhan/cau_hinh'));
				exit;
			}
			if($data['dia_chi'] == ''){
				$_SESSION['error'] = 'Vui lòng điền địa chỉ';
				header('Location: '.site_url('giao_nhan/cau_hinh'));
				exit;
			}
			if($data['dien_thoai'] == ''){
				$_SESSION['error'] = 'Vui lòng điền số điện thoại';
				header('Location: '.site_url('giao_nhan/cau_hinh'));
				exit;
			}	
			if($data['email'] == ''){
				$_SESSION['error'] = 'Vui lòng điền email';
				header('Location: '.site_url('giao_nhan/cau_hinh'));
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

}
?>