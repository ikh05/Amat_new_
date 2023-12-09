<?php 

class Login extends Controller{
	public function index($error = null){
		$data = [];
		// mengambil data dari from masuk
		if(isset($_SESSION['masuk'])){
			$data['masuk'] = $_SESSION['masuk'];
			unset($_SESSION['masuk']);
		}
		// mengambul data daru from daftar
		if(isset($_SESSION['daftar'])){
			$data['daftar'] = $_SESSION['daftar'];
			unset($_SESSION['daftar']);
		}
		// set Error
		if(!is_null($error)) 
			$data['error'] = $this->model('Mass_model')->getError($error);
		
		$this->view('Login/index', $data);
	}
	public function masuk(){
		$status = $this->model('User_model')->masuk($_POST);
		switch ($status){
			case 1:
				header('Location: '.BASE_URL.'Home');
				exit();
			default:
				header('Location: '.BASE_URL.'Login/index/'.$status);
				exit();
		};
	}
	public function daftar(){
		// username, email, pass, nama, jenis-Kelamin
		$status = $this->model('User_model')->daftar($_POST);
		switch ($status){
			case 1:
				header('Location: '.BASE_URL.'Home');
				exit();
			default:
				header('Location: '.BASE_URL.'Login/index/'.$status);
				exit();
		};
	}
	public function lupaPass($username){
		$status = $this->model('User_model')->lupaPass($username);
		switch ($status) {
			case 1:
				// harusnya lempar ke halaman masukkan kode verifikasi
				header('Location: '.BASE_URL.'Login/index/'.$status);
				break;
			default:
				header('Location: '.BASE_URL.'Login/index/'.$status);
				break;
		}
	}
	public function keluar (){
		unset($_SESSION[LOGIN]);
		header('Location: '.BASE_URL.'Login/index/er00');
		exit();
	}
}