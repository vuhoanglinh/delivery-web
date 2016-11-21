<?php

class Oauth_Login extends CI_Controller {

public $user = "";

public function __construct() {
parent::__construct();

// Load facebook library and pass associative array which contains appId and secret key
$this->load->library('facebook', array('appId' => '1420355971604779', 'secret' => 'fde38f0c42da216ef390f2bb28a6addf'));

// Get user's login information
$this->user = $this->facebook->getUser();
}

// Store user information and send to profile page
public function index() {
if ($this->user) {
$data['user_profile'] = $this->facebook->api('/me/');
echo "Thanh cong";
echo "<pre>";
print_r($data);
echo "</pre>";
exit;
// Get logout url of facebook
$data['logout_url'] = $this->facebook->getLogoutUrl(array('next' => base_url() . 'oauth_login/logout'));

// Send data to profile page
$this->load->view('profile', $data);
} else {

// Store users facebook login url
$data['login_url'] = $this->facebook->getLoginUrl();
echo "That bai";
}
}

// Logout from facebook
public function logout() {

// Destroy session
session_destroy();

// Redirect to baseurl
redirect(base_url());
}

}
?>