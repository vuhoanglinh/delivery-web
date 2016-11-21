<?php
session_start();
class Khach_hang extends CI_Controller {  
    function __construct(){
        parent::__construct();
		$this->load->model('General');	
		$this->load->library('My_PHPMailer');	
		$this->load->model('Pagination_model');		
	}	
	function index(){
		if(isset($_SESSION['login_confirm']) && $_SESSION['login_confirm'] == 1 && isset($_SESSION['login_info']) && $_SESSION['login_info'] != NULL){
			header("Location: ".site_url("khach_hang/danh_sach"));
		}else{
			header("Location: ".site_url("khach_hang/login"));
		}
	}
	
	function login(){
		$this->load->view('khach_hang/dang_nhap');
	}
	
	function verify(){
		$this->load->view('khach_hang/verify');
	}
	
	function submit_verify(){
		if($this->input->post()){
			$data = $this->input->post();
			if($data['email'] == ''){
				$_SESSION['error'] ='Vui lòng điền email của tài khoản cần kích hoạt';			
				header('Location: '.site_url('khach_hang/verify'));
				exit;
			}
			if($data['email'] == ''){
				$_SESSION['error'] ='Bạn chưa điền mã kích hoạt';			
				header('Location: '.site_url('khach_hang/verify'));
				exit;
			}
			
			$res_check_user = $this->General->getItemsNoneActiveRecord("Select count(*) countUser From user Where email = '".$data['email']."' && ma_kich_hoat = '".$data['ma_kich_hoat']."' && xac_nhan = 0");
			if($res_check_user['0']['countUser'] == 1){
				//kich hoat
				$res = $this->General->updateItem('user', array('xac_nhan' => 1), array('email' => $data['email']));
				if($res){
					$_SESSION['success'] ='Kích hoạt tài khoản thành công';			
					header('Location: '.site_url('khach_hang/login'));
					exit;
				}else{
					$_SESSION['error'] ='Kích hoạt tài khoản thất bại. Vui lòng thử lại hoặc liên lạc với chúng tôi.';			
					header('Location: '.site_url('khach_hang/verify'));
					exit;
				}				
			}
		}else{
			$_SESSION['error'] ='Vui lòng điền đầy đủ thông tin';			
			header('Location: '.site_url('khach_hang/verify'));
			exit;
		}
	}	
	
	function register(){		
		$this->load->view('khach_hang/dang_ky');
	}
	
	function submit_reg(){	
		if($this->input->post()){
			$data = $this->input->post();
			if(isset($data['term']) && $data['term'] == 'on'){				
				if($data['ten'] == ''){					
					$_SESSION['error'] = 'Bạn chưa điền họ tên';
					
					header('Location: '.site_url('khach_hang/register'));
					exit;
				}
				if($data['email'] == ''){					
					$_SESSION['error'] = 'Bạn chưa điền email';
					
					header('Location: '.site_url('khach_hang/register'));
					exit;
				}				
				if($data['mat_khau'] == '' || $data['re_mat_khau'] == ''){
					$_SESSION['error'] = 'Bạn chưa điền mật khẩu';
					
					header('Location: '.site_url('khach_hang/register'));
					exit;
				}
				if($data['mat_khau'] !=  $data['re_mat_khau']){
					$_SESSION['error'] = 'Mật khẩu không trùng nhau';
					
					header('Location: '.site_url('khach_hang/register'));
					exit;
				}
				if($data['dia_chi'] == ''){
					$_SESSION['error'] = 'Bạn chưa điền địa chỉ';
					
					header('Location: '.site_url('khach_hang/register'));
					exit;
				}
				if($data['dien_thoai'] == ''){
					$_SESSION['error'] = 'Bạn chưa điền số điện thoại';
					
					header('Location: '.site_url('khach_hang/register'));
					exit;
				}				
				$res_count_user = $this->General->getItemsNoneActiveRecord("Select count(*) as countUser From user Where email = '".$data['email']."'");
				if($res_count_user['0']['countUser'] == 1){
					$_SESSION['error'] = 'Email đã tồn tại. Vui lòng chọn email khác để đăng ký.';
					header('Location: '.site_url('khach_hang/register'));
					exit;
				}								
				$ma_kich_hoat = substr(md5(time().$data['email']),2,7);				
				$res = $this->General->insertItem('user', array('ten' => $data['ten'], 
																'password' => md5($data['re_mat_khau']), 
																'email' => $data['email'], 
																'dia_chi' => $data['dia_chi'], 
																'dien_thoai' => $data['dien_thoai'],
																'ma_kich_hoat' => $ma_kich_hoat,
																'ngay_tao' => time(),
																'loai_user' => 1)
												);
				if($res) {
				$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
				$mail->CharSet = 'UTF-8';
				$mail->IsSMTP();					
				$mail->Host       = "smtp.gmail.com"; // SMTP server
				$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
				$mail->SMTPSecure = "tls"; //Phương thức mã hóa thư - ssl hoặc tls
				$mail->SMTPAuth   = true; //Xác thực SMTP				
				$mail->Port       = 587;                    // set the SMTP port for the GMAIL server
				$mail->Username   = "huongthien1993@gmail.com"; // SMTP account username
				$mail->Password   = "Honghoapn1";        // SMTP account password 
				
				$mail->AddAddress($data['email'] , $data['ten']);						
				$mail->SetFrom('huongthien1993@gmail.com', 'Administrator');//config in contants								
				$mail->Subject = "Mã kích hoạt tài khoản";
				$mail->Body = "Chào ".$data['ten'].",\n".
                      "Mã kích hoạt tài khoản của bạn là: ".$ma_kich_hoat."<br>".
					  "Vui lòng truy cập đường dẫn dưới đây để kích hoạt tài khoản: <br>".
					  URL_VERIFY.
					  "<br>Cảm ơn,\n\n";      
					try{
						$mail->Send();
						$_SESSION['success'] ='Chúc mừng bạn đã đăng ký tài khoản thành công. Vui lòng kiểm tra email để lấy mã kích hoạt tài khoản.';						
						header('Location: '.site_url('khach_hang/login'));
						exit;
					}catch (phpmailerException $e) {
					  //echo $e->errorMessage(); //Pretty error messages from PHPMailer
					} catch (Exception $e) {
					  //echo $e->getMessage(); //Boring error messages from anything else!
					}
					$_SESSION['success'] ='Chúc mừng bạn đã đăng ký tài khoản thành công. Vui lòng kiểm tra email để lấy mã kích hoạt tài khoản.';						
					header('Location: '.site_url('khach_hang/login'));
					exit;					
				}else{
					$_SESSION['success'] ='Đăng ký tài khoản thất bại. Vui lòng thử lại.';					
					header('Location: '.site_url('khach_hang/register'));
					exit;
				}
			}else{
				$_SESSION['error'] ='Vui lòng đồng ý với điều khoản và quy tắc';				
				header('Location: '.site_url('khach_hang/register'));
				exit;
			}
		} else {
			$_SESSION['error'] ='Vui lòng điền đầy đủ thông tin';
			
			header('Location: '.site_url('khach_hang/login'));
			exit;
		}	
	}
	
	function submit_log(){
		if($this->input->post()){	
			$data = $this->input->post();
			if($data['email'] == ''){					
				$_SESSION['error'] = 'Vui lòng điền email đăng nhập';				
				header('Location: '.site_url('khach_hang/login'));
				exit;
			}				
			if($data['mat_khau'] == '' ){
				$_SESSION['error'] = 'Vui lòng điền mật khẩu';
				header('Location: '.site_url('khach_hang/login'));
				exit;
			}
			
			$res_count_user = $this->General->getItemsNoneActiveRecord("Select count(*) as countUser From user Where email = '".$data['email']."' && password = '".md5($data['mat_khau'])."' && loai_user = 1");
			if($res_count_user['0']['countUser'] == 0){
				$_SESSION['error'] = 'Tài khoản hoặc mật khẩu không đúng. Vui lòng thử lại';
				header('Location: '.site_url('khach_hang/login'));
				exit;
			}	
						
			
			$res_info_user = $this->General->getItemsNoneActiveRecord("Select * From user Where email = '".$data['email']."' && password = '".md5($data['mat_khau'])."' && loai_user = 1");
			
			//kiem tra xac nhan email
			if($res_info_user['0']['xac_nhan'] == 0){
				$_SESSION['error'] = 'Tài khoản của bạn chưa được kích hoạt. Vui lòng kiểm tra email kích hoạt hoặc nhấn vào <a href="'.site_url('khach_hang/gui_lai_ma_xac_nhan').'" style="text-decoration:underline;">đây</a> để nhận lại mã kích hoạt.';
				header('Location: '.site_url('khach_hang/login'));
				exit;
 			}
			
			//kiem tra xoa
			if($res_info_user['0']['xoa'] == 1){
				$_SESSION['error'] = 'Tài khoản của bạn đã bị khóa.\n Vui lòng liên hệ với người quản trị để biết thêm chi tiết.';
				header('Location: '.site_url('khach_hang/login'));
				exit;
 			}
			
			
			$_SESSION['login_confirm'] = '1';
			$_SESSION['login_info'] = $res_info_user['0'];
			
			$_SESSION['success'] = 'Đăng nhập thành công';
			header('Location: '.site_url('khach_hang/danh_sach'));
			exit;			
		} else {
			$_SESSION['error'] = 'Vui lòng điền email và mật khẩu';
			header('Location: '.site_url('khach_hang/login'));
			exit;
		}	
	}
	
	function gui_lai_ma_xac_nhan(){
		$this->load->view('khach_hang/resend_active');
	}
	function submit_resend_active(){
		if($this->input->post('email')){
			$email = $this->input->post('email');	
			$res_count_user = $this->General->getItemsNoneActiveRecord("Select * From user Where email = '".$email."'");
			
			if(count($res_count_user) == 0){
				$_SESSION['error'] ='Email này không tồn tại. Vui lòng điền email của tài khoản bạn cần gửi lại mã kích hoạt';						
				header('Location: '.site_url('khach_hang/gui_lai_ma_xac_nhan'));
				exit;
			}
			
			if($res_count_user['0']['xoa'] == 1){
				$_SESSION['error'] ='Tài khoản này đã bị khóa. Vui lòng liên hệ với người quản trị để biết thêm chi tiết';						
				header('Location: '.site_url('khach_hang/login'));
				exit;
			}
			

			$ma_kich_hoat = substr(md5(time().$email),2,7);		
			$res = $this->General->updateItem('user', array('ma_kich_hoat' => $ma_kich_hoat), array('email' => $email));
			if($res) {
				$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
				$mail->CharSet = 'UTF-8';
				$mail->IsSMTP();					
				$mail->Host       = "smtp.gmail.com"; // SMTP server
				$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
				$mail->SMTPSecure = "tls"; //Phương thức mã hóa thư - ssl hoặc tls
				$mail->SMTPAuth   = true; //Xác thực SMTP				
				$mail->Port       = 587;                    // set the SMTP port for the GMAIL server
				$mail->Username   = "huongthien1993@gmail.com"; // SMTP account username
				$mail->Password   = "Honghoapn1";        // SMTP account password 
				
				$mail->AddAddress($email , $res_count_user['0']['ten']);						
				$mail->SetFrom('huongthien1993@gmail.com', 'Administrator');//config in contants								
				$mail->Subject = "Mã kích hoạt tài khoản";
				$mail->Body = "Chào ".$res_count_user['0']['ten'].",\n".
                      "Mã kích hoạt tài khoản của bạn là: ".$ma_kich_hoat."\n".
					  "Vui lòng truy cập đường dẫn dưới đây để kích hoạt tài khoản: \n".
					  URL_VERIFY.
					  "\nCảm ơn,\n\n";      
					try{
						$mail->Send();
						$_SESSION['success'] ='Mã kích hoạt đã được gửi đến email của bạn. Vui lòng kiểm tra email để lấy mã kích hoạt tài khoản.';						
						header('Location: '.site_url('khach_hang/login'));
						exit;
					}catch (phpmailerException $e) {
					  //echo $e->errorMessage(); //Pretty error messages from PHPMailer
					} catch (Exception $e) {
					  //echo $e->getMessage(); //Boring error messages from anything else!
					}
					$_SESSION['success'] ='Mã kích hoạt đã được gửi đến email của bạn. Vui lòng kiểm tra email để lấy mã kích hoạt tài khoản.';
					header('Location: '.site_url('khach_hang/login'));
					exit;	
			}else{
				$_SESSION['error'] = 'Có lỗi trong quá trình xử lý. Vui lòng thử lại';
				header('Location: '.site_url('khach_hang/gui_lai_ma_xac_nhan'));
				exit;
			}					
		}else{
			$_SESSION['error'] = 'Vui lòng điền email của bạn để chúng tôi gửi lại mã kích hoạt';
			header('Location: '.site_url('khach_hang/gui_lai_ma_xac_nhan'));
			exit;
		}
	}
	
	function quen_mat_khau(){
		$this->load->view('khach_hang/quen_mat_khau');
	}
	
	function submit_lost_pass(){
		if($this->input->post('email')){
			$email = $this->input->post('email');	
			$res_count_user = $this->General->getItemsNoneActiveRecord("Select * From user Where email = '".$email."'");
			
			if(count($res_count_user) == 0){
				$_SESSION['error'] ='Email này không tồn tại. Vui lòng điền email của tài khoản bạn cần gửi lại mật khẩu';						
				header('Location: '.site_url('khach_hang/quen_mat_khau'));
				exit;
			}
			
			if($res_count_user['0']['xoa'] == 1){
				$_SESSION['error'] ='Tài khoản này đã bị khóa. Vui lòng liên hệ với người quản trị để biết thêm chi tiết';						
				header('Location: '.site_url('khach_hang/login'));
				exit;
			}					
			
			$mat_khau_moi = substr(md5(time().$email),2,6);		
			$res = $this->General->updateItem('user', array('password' => md5($mat_khau_moi)), array('email' => $email));
			if($res) {
				$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
				$mail->CharSet = 'UTF-8';
				$mail->IsSMTP();					
				$mail->Host       = "smtp.gmail.com"; // SMTP server
				$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
				$mail->SMTPSecure = "tls"; //Phương thức mã hóa thư - ssl hoặc tls
				$mail->SMTPAuth   = true; //Xác thực SMTP				
				$mail->Port       = 587;                    // set the SMTP port for the GMAIL server
				$mail->Username   = "huongthien1993@gmail.com"; // SMTP account username
				$mail->Password   = "Honghoapn1";        // SMTP account password 
				
				$mail->AddAddress($email , $res_count_user['0']['ten']);						
				$mail->SetFrom('huongthien1993@gmail.com', 'Administrator');//config in contants								
				$mail->Subject = "Mật khẩu mới";
				$mail->Body = "Chào ".$res_count_user['0']['ten'].",\n".
                      "Mật khẩu mới của bạn là: ".$mat_khau_moi."\n".					  
					  "\nCảm ơn,\n\n";      
					try{
						$mail->Send();
						$_SESSION['success'] = 'Mật khẩu đã được gửi đến email của bạn. Vui lòng kiểm tra email để lấy mật khẩu mới.';						
						header('Location: '.site_url('khach_hang/login'));
						exit;
					}catch (phpmailerException $e) {
					  //echo $e->errorMessage(); //Pretty error messages from PHPMailer
					} catch (Exception $e) {
					  //echo $e->getMessage(); //Boring error messages from anything else!
					}
					$_SESSION['success'] = 'Mật khẩu đã được gửi đến email của bạn. Vui lòng kiểm tra email để lấy mật khẩu mới.';						
					header('Location: '.site_url('khach_hang/login'));
					exit;	
			}else{
				$_SESSION['error'] = 'Có lỗi trong quá trình xử lý. Vui lòng thử lại';
				header('Location: '.site_url('khach_hang/quen_mat_khau'));
				exit;
			}					
		}else{
			$_SESSION['error'] = 'Vui lòng điền email của bạn để chúng tôi gửi lại mật khẩu mới';
			header('Location: '.site_url('khach_hang/quen_mat_khau'));
			exit;
		}
	}
	
	function danh_sach(){
		
		if(isset($_SESSION['login_confirm']) && $_SESSION['login_confirm'] == 1 && isset($_SESSION['login_info']) && $_SESSION['login_info'] != NULL){
			$user_detail_login =  $_SESSION['login_info'];
		}else{
			$_SESSION['error'] = "Bạn phải đăng nhập trước khi xem trang này";
			header("Location: ".site_url("khach_hang/login"));
			exit;
		}
		
		$head_data['title'] = "Danh sách đơn hàng";
		$this->load->view('khach_hang/partial/head',$head_data);
		
		/*PAGINATION*/
		 // pagination
		 $per_page = LIST_LIMIT;
		 
		 //$total_books = $this->Pagination_model->getTotal($table_name);		
		 $total_books = $this->General->getItemsNoneActiveRecord("Select count(*) as  total_ads From don_hang where id_khach_hang = ".$user_detail_login['id']." Order By ngay_tao DESC");
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
		 $config['base_url'] = base_url().'khach_hang/danh_sach/';
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
			
		$danh_sach_don_hang = $this->General->getItemsNoneActiveRecord("Select * From don_hang where id_khach_hang = ".$user_detail_login['id']." Order By ngay_tao DESC LIMIT ".$offset.",".$per_page);
		$data['danh_sach'] = $danh_sach_don_hang;
		$this->load->view('khach_hang/danh_sach', $data);
	}
	
	function tao_don_hang(){
		$head_data['title'] = "Tạo mới đơn hàng";
		$this->load->view('khach_hang/partial/head',$head_data);
				
		$this->load->view('khach_hang/tao_moi');
	}
	
	function submit_creat(){
		if(isset($_SESSION['login_confirm']) && $_SESSION['login_confirm'] == 1 && isset($_SESSION['login_info']) && $_SESSION['login_info'] != NULL){
			$user_detail_login =  $_SESSION['login_info'];
		}else{
			$_SESSION['error'] = "Bạn phải đăng nhập trước khi xem trang này";
			header("Location: ".site_url("khach_hang/login"));
			exit;
		}
		
		if($this->input->post()){
			$data = $this->input->post();
			if($data['dia_chi_kho'] == ''){
				$_SESSION['error'] = 'Vui lòng điền địa chỉ lấy hàng';
				header('Location: '.site_url('khach_hang/tao_don_hang'));
				exit;
			}
			if($data['ten_hang_hoa'] == '' || $data['so_luong'] == '' || $data['khoi_luong'] == '' || $data['tong_gia_tri'] == '' ){
				$_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin hàng hóa';
				header('Location: '.site_url('khach_hang/tao_don_hang'));
				exit;
			}
			if($data['ten_nguoi_nhan'] == '' || $data['so_dien_thoai'] == '' || $data['dia_chi_nguoi_nhan'] == '' || $data['tinh_tp'] == ''  || $data['quan_huyen'] == ''){
				$_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin người nhận hàng';
				header('Location: '.site_url('khach_hang/tao_don_hang'));
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
			
			$data_insert = array(	
									'id_khach_hang' => $user_detail_login['id'],
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
									'ngay_tao' => time()							
								);
			$res = $this->General->insertItem('don_hang', $data_insert);			
			if($res){
				$_SESSION['success'] = 'Tạo đơn hàng thành công. Đơn hàng của bạn sẽ được xử lý trong vòng 12-24h giờ làm việc. Xin cảm ơn';
				header('Location: '.site_url('khach_hang/danh_sach'));
				exit;
			}else{
				$_SESSION['error'] = 'Tạo mới đơn hàng thất bại. Vui lòng kiểm tra lại thông tin đơn hàng';
				header('Location: '.site_url('khach_hang/tao_don_hang'));
				exit;
			}
		}else{
			$_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin đơn hàng';
			header('Location: '.site_url('khach_hang/tao_don_hang'));
			exit;
		}
	}
	
	function lien_he(){
		$head_data['title'] = "Liên hệ";
		$this->load->view('khach_hang/partial/head',$head_data);
		
		
		$this->load->view('khach_hang/lien_he');
	}
	
	function submit_lien_he(){
		if(isset($_SESSION['login_confirm']) && $_SESSION['login_confirm'] == 1 && isset($_SESSION['login_info']) && $_SESSION['login_info'] != NULL){
			$user_detail_login =  $_SESSION['login_info'];
		}else{
			$_SESSION['error'] = "Bạn phải đăng nhập trước khi thực hiện thao tác này";
			header("Location: ".site_url("khach_hang/login"));
			exit;
		}
		
		if($this->input->post()){
			$data = $this->input->post();	
			$_SESSION['last_data'] = $this->input->post();
			if($data['ten'] == ''){
				$_SESSION['error'] = 'Bạn chưa điền tên';
				header('Location: '.site_url('khach_hang/lien_he'));
				exit;
			}
			if($data['email'] == ''){
				$_SESSION['error'] = 'Bạn chưa điền email';
				header('Location: '.site_url('khach_hang/lien_he'));
				exit;
			}
			if($data['tieu_de'] == ''){
				$_SESSION['error'] = 'Bạn chưa điền tiêu đề';
				header('Location: '.site_url('khach_hang/lien_he'));
				exit;
			}
			if($data['noi_dung'] == ''){
				$_SESSION['error'] = 'Bạn chưa điền nội dung';
				header('Location: '.site_url('khach_hang/lien_he'));
				exit;
			}
			
			//thêm vào liên hệ
						
			$data_insert = array(	
									'id_khach_hang' => $user_detail_login['id'],
									'ten' => $data['ten'], 
									'dien_thoai' => $data['dien_thoai'],								
									'email' => $data['email'],
									'tieu_de' => $data['tieu_de'],
									'noi_dung' => $data['noi_dung'],
									'ngay_tao' => time()																										
								);
			$res = $this->General->insertItem('lien_he', $data_insert);			
			if($res){
				unset($_SESSION['last_data']);
				$_SESSION['success'] = 'Yêu cầu của bạn đã được gửi. Chúng tôi sẽ cố gắng trả lời sớm nhất cho bạn';
				header('Location: '.site_url('khach_hang/danh_sach'));
				exit;
			}else{
				$_SESSION['error'] = 'Gửi yêu cầu thất bại. Vui lòng thử lại';
				header('Location: '.site_url('khach_hang/lien_he'));
				exit;
			}
		}else{
			$_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin';
			header('Location: '.site_url('khach_hang/lien_he'));
			exit;
		}
	}
	
	function cap_nhat($ma_don_hang){
		if(isset($ma_don_hang) && $ma_don_hang != ''){
			$thong_tin_don_hang = $this->General->getItemsNoneActiveRecord("Select * From don_hang Where id = ".$ma_don_hang);			
			if(count($thong_tin_don_hang) == 1){
				$data['don_hang'] = $thong_tin_don_hang['0'];
				$head_data['title'] = "Chỉnh sửa đơn hàng";
				$this->load->view('khach_hang/partial/head',$head_data);
				
				$this->load->view('khach_hang/cap_nhat',$data);
			}else{
				$_SESSION['error'] = 'Đơn hàng không tồn tại hoặc bị khóa bởi người quản trị';
				header('Location: '.site_url('khach_hang/danh_sach'));
				exit;
			}			
		}
	}
	
	function submit_cap_nhat(){
		if(isset($_SESSION['login_confirm']) && $_SESSION['login_confirm'] == 1 && isset($_SESSION['login_info']) && $_SESSION['login_info'] != NULL){
			$user_detail_login =  $_SESSION['login_info'];
		}else{
			$_SESSION['error'] = "Bạn phải đăng nhập trước khi xem trang này";
			header("Location: ".site_url("khach_hang/login"));
			exit;
		}
		
		if($this->input->post()){
			$data = $this->input->post();
			$ma_don_hang = $data['ma_don_hang'];
			if($data['dia_chi_kho'] == ''){
				$_SESSION['error'] = 'Vui lòng điền địa chỉ lấy hàng';
				header('Location: '.site_url('khach_hang/cap_nhat/'.$ma_don_hang));
				exit;
			}
			if($data['ten_hang_hoa'] == '' || $data['so_luong'] == '' || $data['khoi_luong'] == '' || $data['tong_gia_tri'] == '' ){
				$_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin hàng hóa';
				header('Location: '.site_url('khach_hang/cap_nhat/'.$ma_don_hang));
				exit;
			}
			if($data['ten_nguoi_nhan'] == '' || $data['so_dien_thoai'] == '' || $data['dia_chi_nguoi_nhan'] == '' || $data['tinh_tp'] == ''  || $data['quan_huyen'] == ''){
				$_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin người nhận hàng';
				header('Location: '.site_url('khach_hang/cap_nhat/'.$ma_don_hang));
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
									'id_khach_hang' => $user_detail_login['id'],
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
				header('Location: '.site_url('khach_hang/danh_sach'));
				exit;
			}else{
				$_SESSION['error'] = 'Cập nhật đơn hàng thất bại. Vui lòng kiểm tra lại thông tin đơn hàng';
				header('Location: '.site_url('khach_hang/cap_nhat/'.$ma_don_hang));
				exit;
			}
		}else{
			$_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin đơn hàng';
			header('Location: '.site_url('khach_hang/cap_nhat/'.$ma_don_hang));
			exit;
		}
	}
	
	function xoa($ma_don_hang){
		if(isset($_SESSION['login_confirm']) && $_SESSION['login_confirm'] == 1 && isset($_SESSION['login_info']) && $_SESSION['login_info'] != NULL){
			$user_detail_login =  $_SESSION['login_info'];
		}else{
			$_SESSION['error'] = "Bạn phải đăng nhập trước khi thực hiện thao tác này";
			header("Location: ".site_url("khach_hang/login"));
			exit;
		}
		
		if(isset($ma_don_hang) && $ma_don_hang != ''){
			$don_hang = $this->General->getItemsNoneActiveRecord("Select count(*) as countDonHang From don_hang Where id = ".$ma_don_hang." and id_khach_hang = ".$user_detail_login['id']);
			if($don_hang['0']['countDonHang'] == 1){
				$res = $this->General->updateItem('don_hang', array('xoa' => '1'), array('id' => $ma_don_hang));
				if($res){
					$_SESSION['success'] = 'Xóa đơn hàng thành công';
					header('Location: '.site_url('khach_hang/danh_sach'));
					exit;
				}else{
					$_SESSION['error'] = 'Xóa đơn hàng thất bại';
					header('Location: '.site_url('khach_hang/danh_sach'));
					exit;
				}
				
			}else{
				$_SESSION['error'] = 'Đơn hàng không tồn tại hoặc bị khóa bởi người quản trị';
				header('Location: '.site_url('khach_hang/danh_sach'));
				exit;
			}			
		}else{
			header('Location: '.site_url('khach_hang/danh_sach'));
			exit;
		}
	}
	
	function chi_tiet($ma_don_hang){
		if(isset($_SESSION['login_confirm']) && $_SESSION['login_confirm'] == 1 && isset($_SESSION['login_info']) && $_SESSION['login_info'] != NULL){
			$user_detail_login =  $_SESSION['login_info'];
		}else{
			$_SESSION['error'] = "Bạn phải đăng nhập trước khi xem trang này";
			header("Location: ".site_url("khach_hang/login"));
			exit;
		}
		
		if(isset($ma_don_hang) && $ma_don_hang != ''){
			$thong_tin_don_hang = $this->General->getItemsNoneActiveRecord("Select * From don_hang Where id = ".$ma_don_hang." and id_khach_hang = ".$user_detail_login['id']);			
			if(count($thong_tin_don_hang) == 1){
				$data['don_hang'] = $thong_tin_don_hang['0'];
				$head_data['title'] = "Chi tiết đơn hàng";
				$this->load->view('khach_hang/partial/head',$head_data);
				
				$this->load->view('khach_hang/chi_tiet',$data);
			}else{
				$_SESSION['error'] = 'Đơn hàng không tồn tại hoặc bị khóa bởi người quản trị';
				header('Location: '.site_url('khach_hang/danh_sach'));
				exit;
			}			
		}else{
			header('Location: '.site_url('khach_hang/danh_sach'));
			exit;
		}	
	}
	
	function logout(){
		unset($_SESSION['login_confirm']);
		unset($_SESSION['login_info']);
		$_SESSION['success'] = 'Bạn đã đăng xuất';
		header('Location: '.site_url('khach_hang/login'));
		exit;
	}
	
	function tim_kiem(){
		if(isset($_SESSION['login_confirm']) && $_SESSION['login_confirm'] == 1 && isset($_SESSION['login_info']) && $_SESSION['login_info'] != NULL){
			$user_detail_login =  $_SESSION['login_info'];
		}else{
			$_SESSION['error'] = "Bạn phải đăng nhập trước khi thực hiện thao tác này";
			header("Location: ".site_url("khach_hang/login"));
			exit;
		}
		
		if(!isset($_GET['s']) || empty($_GET['s'])){
			header('Location: '.site_url('khach_hang/danh_sach'));
			exit;
		}
		
		if(strlen($_GET['s']) < 3){
			$_SESSION['error'] = "Chuỗi cần tìm kiếm phải lớn  hơn 3 ký tự";
			header('Location: '.site_url('khach_hang/danh_sach'));
			exit;
		}
		$s = $_GET['s'];
		
		/*PAGINATION*/
		 // pagination
		 $per_page = LIST_LIMIT;
		 
		 //$total_books = $this->Pagination_model->getTotal($table_name);		
		 $total_books = $this->General->getItemsNoneActiveRecord("Select count(*) as  total_ads From don_hang WHERE (dien_thoai_nguoi_nhan like '%".$s."%' or id = '%".$s."%') and id_khach_hang = ".$user_detail_login['id']." Order By ngay_tao DESC");
		 
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
		 $config['base_url'] = base_url().'khach_hang/tim_kiem/?s='.$s;		
		 //$config['uri_segment']	= 3; 
		 # Khởi tạo phân trang 
		 $this->pagination->initialize($config); 
		 # Tạo link phân trang 
		 $data['pagination'] = $this->pagination->create_links();		
		 $offset = ($this->input->get('per_page')=='') ? 0 : $this->input->get('per_page');		
         $limit = array('num_record' => $per_page, 'start' => $offset);		 
		/*End PAGINATION*/		
		
		
		$res_tim_kiem = $this->General->getItemsNoneActiveRecord("SELECT * FROM don_hang WHERE id_khach_hang = ".$user_detail_login['id']." and (dien_thoai_nguoi_nhan like '%".$s."%' or id = '%".$s."%') Order By ngay_tao DESC LIMIT ".$offset.",".$per_page);
			
		
		$head_data['title'] = "Tìm kiếm đơn hàng";
		$this->load->view('khach_hang/partial/head',$head_data);
		
		$data['danh_sach'] = $res_tim_kiem;
		$this->load->view('khach_hang/danh_sach', $data);
	}
	
	function huy_don_hang($ma_don_hang){
		if(isset($_SESSION['login_confirm']) && $_SESSION['login_confirm'] == 1 && isset($_SESSION['login_info']) && $_SESSION['login_info'] != NULL){
			$user_detail_login =  $_SESSION['login_info'];
		}else{
			$_SESSION['error'] = "Bạn phải đăng nhập trước khi thực hiện thao tác này";
			header("Location: ".site_url("khach_hang/login"));
			exit;
		}
		
		if(isset($ma_don_hang) && $ma_don_hang != ''){
			$thong_tin_don_hang = $this->General->getItemsNoneActiveRecord("Select count(*) as countDonHang From don_hang Where id = ".$ma_don_hang);			
			if($thong_tin_don_hang['0']['countDonHang'] == 1){											
				$res = $this->General->updateItem("don_hang", array('trang_thai_don_hang' => 6), array('id' => $ma_don_hang, 'id_khach_hang' => $user_detail_login['id']));
				if($res){
					$_SESSION['success'] = "Hủy đơn hàng thành công";
					header("Location: ".site_url("khach_hang/danh_sach"));
					exit;
				}else{
					$_SESSION['error'] = "Hủy đơn hàng thất bại. Vui lòng thử lại";
					header("Location: ".site_url("khach_hang/danh_sach"));
					exit;
				}
			}else{
				$_SESSION['error'] = 'Đơn hàng không tồn tại hoặc bị khóa bởi người quản trị';
				header('Location: '.site_url('khach_hang/danh_sach'));
				exit;
			}	
		}
	}
	
	function cau_hinh(){
		if(isset($_SESSION['login_confirm']) && $_SESSION['login_confirm'] == 1 && isset($_SESSION['login_info']) && $_SESSION['login_info'] != NULL){
			$user_detail_login =  $_SESSION['login_info'];
		}else{
			$_SESSION['error'] = "Bạn phải đăng nhập trước khi thực hiện thao tác này";
			header("Location: ".site_url("khach_hang/login"));
			exit;
		}
		
		$head_data['title'] = "Thiết lập tài khoản";
		$this->load->view('khach_hang/partial/head',$head_data);
		
		$rs_detail = $this->General->getItemsNoneActiveRecord("Select * From user Where id = ".$user_detail_login['id']." and loai_user = 1");
		$data['khach_hang'] = $rs_detail['0'];
	
		$this->load->view('khach_hang/cau_hinh', $data);
	}
	
	function submit_cau_hinh(){
		if(isset($_SESSION['login_confirm']) && $_SESSION['login_confirm'] == 1 && isset($_SESSION['login_info']) && $_SESSION['login_info'] != NULL){
			$user_detail_login =  $_SESSION['login_info'];
		}else{
			$_SESSION['error'] = "Bạn phải đăng nhập trước khi thực hiện thao tác này";
			header("Location: ".site_url("khach_hang/login"));
			exit;
		}
		
		if($this->input->post()){
			$data = $this->input->post();			
			if($data['ten'] == ''){
				$_SESSION['ten'] = 'Vui lòng điền tên';
				header('Location: '.site_url('khach_hang/cau_hinh'));
				exit;
			}
			if($data['dia_chi'] == ''){
				$_SESSION['error'] = 'Vui lòng điền địa chỉ';
				header('Location: '.site_url('khach_hang/cau_hinh'));
				exit;
			}
			if($data['dien_thoai'] == ''){
				$_SESSION['error'] = 'Vui lòng điền số điện thoại';
				header('Location: '.site_url('khach_hang/cau_hinh'));
				exit;
			}	
			if($data['email'] == ''){
				$_SESSION['error'] = 'Vui lòng điền email';
				header('Location: '.site_url('khach_hang/cau_hinh'));
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
					header('Location: '.site_url('khach_hang/cau_hinh'));
					exit;
				}									
			}
			
			$res = $this->General->updateItem('user', $data_update, array('id' => $user_detail_login['id']));			
			if($res){
				//gan lai cho session
				$data_user = $this->General->getItemsNoneActiveRecord("SELECT * FROM user WHERE id = ".$user_detail_login['id']." && loai_user = 1");
				$_SESSION['login_info'] = $data_user['0'];
				$_SESSION['success'] = 'Cập nhật thông tin thành công.';				
				header('Location: '.site_url('khach_hang/cau_hinh'));
				exit;
			}else{
				$_SESSION['error'] = 'Cập nhật thông tin thất bại.';
				header('Location: '.site_url('khach_hang/cau_hinh'));
				exit;
			}
		}else{
			$_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin';
			header('Location: '.site_url('khach_hang/cau_hinh'));
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
					header('Location: '.site_url('khach_hang/danh_sach'));
					exit;
				}	
			}else{
				if(isset($_SESSION['url_refer']) && $_SESSION['url_refer'] != ""){
					header('Location: '.$_SESSION['url_refer']);
					exit;
				} else {
					header('Location: '.site_url('khach_hang/danh_sach'));
					exit;
				}				
			}			
		} else {			
			if(isset($_SESSION['url_refer']) && $_SESSION['url_refer'] != ""){
				header('Location: '.$_SESSION['url_refer']);
				exit;
			} else {
				header('Location: '.site_url('khach_hang/danh_sach'));
				exit;
			}
		}
	}
	
	function login_facebook(){
		if($this->input->post()){
			$data = $this->input->post();
			$res_check_user = $this->General->getItemsNoneActiveRecord("SELECT * FROM user WHERE email = '".$data['email']."'");
			if(count($res_check_user) == 0){
				//chưa đăng nhập bằng fb, tạo mới tk
				$_SESSION['data_fb'] = $data;
				header("Location: ".site_url('khach_hang/bo_sung_thong_tin'));
				exit;
			}
			
			if($res_check_user['0']['xac_nhan'] == 0){
				//kiem tra xac nhan email			
				$_SESSION['error'] = 'Tài khoản của bạn chưa được kích hoạt. Vui lòng kiểm tra email kích hoạt hoặc nhấn vào <a href="'.site_url('khach_hang/gui_lai_ma_xac_nhan').'" style="text-decoration:underline;">đây</a> để nhận lại mã kích hoạt.';
				header("Location: ".site_url('khach_hang/login'));
				exit;
			}
						
			if($res_check_user['0']['xoa'] == 1){
				$_SESSION['error'] = 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ với người quản trị để biết thêm chi tiết.';
				header('Location: '.site_url('khach_hang/login'));
				exit;
 			}			
			
			$_SESSION['login_confirm'] = '1';
			$_SESSION['login_info'] = $res_check_user['0'];
			
			$_SESSION['success'] = 'Đăng nhập thành công';
			header('Location: '.site_url('khach_hang/danh_sach'));
			exit;			
		}else{
			$_SESSION['error'] = 'Đăng nhập thất bại';
			header('Location: '.site_url('khach_hang/login'));
			exit;
		}
	}
	
	function bo_sung_thong_tin(){
		$this->load->view('khach_hang/bo_sung_thong_tin');
	}
	
	function submit_bo_sung_thong_tin(){	
		if($this->input->post()){
			$data = $this->input->post();							
				$_SESSION['data_fb'] = $data;
				
				if($data['ten'] == ''){					
					$_SESSION['error'] = 'Bạn chưa điền họ tên';					
					header('Location: '.site_url('khach_hang/bo_sung_thong_tin'));
					exit;
				}
				if($data['email'] == ''){					
					$_SESSION['error'] = 'Bạn chưa điền email';
					
					header('Location: '.site_url('khach_hang/bo_sung_thong_tin'));
					exit;
				}				
				if($data['mat_khau'] == '' || $data['re_mat_khau'] == ''){
					$_SESSION['error'] = 'Bạn chưa điền mật khẩu';
					
					header('Location: '.site_url('khach_hang/bo_sung_thong_tin'));
					exit;
				}
				if($data['mat_khau'] !=  $data['re_mat_khau']){
					$_SESSION['error'] = 'Mật khẩu không trùng nhau';
					
					header('Location: '.site_url('khach_hang/bo_sung_thong_tin'));
					exit;
				}
				if($data['dia_chi'] == ''){
					$_SESSION['error'] = 'Bạn chưa điền địa chỉ';
					
					header('Location: '.site_url('khach_hang/bo_sung_thong_tin'));
					exit;
				}
				if($data['dien_thoai'] == ''){
					$_SESSION['error'] = 'Bạn chưa điền số điện thoại';
					
					header('Location: '.site_url('khach_hang/bo_sung_thong_tin'));
					exit;
				}								
										
				$ma_kich_hoat = substr(md5(time().$data['email']),2,7);				
				$res = $this->General->insertItem('user', array('ten' => $data['ten'], 
																'password' => md5($data['re_mat_khau']), 
																'email' => $data['email'], 
																'dia_chi' => $data['dia_chi'], 
																'dien_thoai' => $data['dien_thoai'],
																'ma_kich_hoat' => $ma_kich_hoat,
																'ngay_tao' => time(),
																'loai_user' => 1)
												);
				if($res) {
				$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
				$mail->CharSet = 'UTF-8';
				$mail->IsSMTP();					
				$mail->Host       = "smtp.gmail.com"; // SMTP server
				$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
				$mail->SMTPSecure = "tls"; //Phương thức mã hóa thư - ssl hoặc tls
				$mail->SMTPAuth   = true; //Xác thực SMTP				
				$mail->Port       = 587;                    // set the SMTP port for the GMAIL server
				$mail->Username   = "huongthien1993@gmail.com"; // SMTP account username
				$mail->Password   = "Honghoapn1";        // SMTP account password 
				
				$mail->AddAddress($data['email'] , $data['ten']);						
				$mail->SetFrom('huongthien1993@gmail.com', 'Administrator');//config in contants								
				$mail->Subject = "Mã kích hoạt tài khoản";
				$mail->Body = "Chào ".$data['ten'].",\n".
                      "Mã kích hoạt tài khoản của bạn là: ".$ma_kich_hoat."\n".
					  "Vui lòng truy cập đường dẫn dưới đây để kích hoạt tài khoản: \n".
					  URL_VERIFY.
					  "<br>Cảm ơn,\n\n";      
					try{
						$mail->Send();
						$_SESSION['success'] ='Chúc mừng bạn đã đăng tài khoản thành công. Vui lòng kiểm tra email để lấy mã kích hoạt tài khoản.';						
						header('Location: '.site_url('khach_hang/login'));
						exit;
					}catch (phpmailerException $e) {
					  //echo $e->errorMessage(); //Pretty error messages from PHPMailer
					} catch (Exception $e) {
					  //echo $e->getMessage(); //Boring error messages from anything else!
					}
					$_SESSION['success'] ='Chúc mừng bạn đã đăng ký tài khoản thành công. Vui lòng kiểm tra email để lấy mã kích hoạt tài khoản.';						
					header('Location: '.site_url('khach_hang/login'));
					exit;					
				}else{
					$_SESSION['success'] ='Đăng ký tài khoản thất bại. Vui lòng thử lại.';					
					header('Location: '.site_url('khach_hang/bo_sung_thong_tin'));
					exit;
				}			
		} else {
			$_SESSION['error'] ='Vui lòng điền đầy đủ thông tin';
			
			header('Location: '.site_url('khach_hang/login'));
			exit;
		}	
	}
}