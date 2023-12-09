<?php 


class User_model{
	private $tabel = 'user';
	private $db;
	public function __construct(){
		$this->db = new Database;
	}

	public function getAllUsers(){
		$this->db->query('SELECT * FROM '.$this->tabel);
		return $this->db->resultSet();
	}
	public function getUserByUsername($username){
		$this->db->query("SELECT * FROM ".$this->tabel." WHERE username=:username");
		$this->db->bind('username', $username);
		return $this->db->single();
	}
	public function getUserByEmail($email){
		$this->db->query("SELECT * FROM ".$this->tabel." WHERE email=:email");
		$this->db->bind('email', $email);
		return $this->db->single();
	}
	
	public function masuk($data){
		// iterasi masuk
		$data['iterasi_masuk'] ++;

		$_SESSION ['masuk'] = $data;
		$username = htmlspecialchars($data['username']);
		$password = htmlspecialchars($data['password']);

		// Cek data user
		if(filter_var($username, FILTER_VALIDATE_EMAIL)){
			$akun = $this->getUserByEmail($username);
		}
		else{
			$akun = $this->getUserByUsername($username);
		}
		if(!$akun){
			return "Er01";
		}

		// Periksa Pass
		$akun_pass = $akun['password'];
		if(password_verify($password, $akun_pass)){
			$_SESSION[LOGIN] = $akun;
			unset($_SESSION['masuk']);
			return 1;
		}else{
			return ($data['iterasi_masuk'] > 3) ? "Er03" : "Er02";
		}
	}
	public function daftar($data){
		$_SESSION ['daftar'] = $data;
		$nama = htmlspecialchars($data['nama']);

		// cek Username
		$username = htmlspecialchars($data['username']);
		$akunUser = $this->getUserByUsername($username);
		if(is_array($akunUser)){
			return "Er11";
		}


		// // cek email
		// $akunEmail = $this->getUserByEmail($email);
		// if($akunEmail){
		// 	return "Email sudah digunakan! Silahkan gunakan Username lain!";
		// }


		// enkripsi password
		$password = htmlspecialchars($data['password']);
		$konfPass = htmlspecialchars($data['konfpassword']);
		if($password !== $konfPass){
			return 'er12';
		}
		$enkripsi = password_hash($password, PASSWORD_DEFAULT);


		// cek jenis kelamin
		$jk = 'unknown';
		if(isset($data['jk'])){
			if(strtolower($data['jk']) == 'laki-laki') $jk = 'laki-laki';
			else if(strtolower($data['jk']) == 'perempuan') $jk = 'perempuan';
		}

		// foto profil
		if($jk === 'laki-laki') $foto = '1.png';
		else if($jk == 'perempuan') $foto = '2.png';
		else $foto = 'unknown.svg';


		// simpan data ke dataBase user
		$this->db->query("INSERT INTO ".$this->tabel." VALUES ('', :nama, :username, '', '', :password, :foto, '' )");
		$this->db->bind('nama', $nama);
		$this->db->bind('username', $username);
		$this->db->bind('password', $enkripsi);
		$this->db->bind('foto', $foto);
		$this->db->execute();


		$akun = $this->getUserByUsername($username);
		$_SESSION[LOGIN] = $akun;
		unset($_SESSION['daftar']);
		return 1;
	}

	public function lupaPass($username){
		$user = $this->getUserByUsername($username);
		if(!isset($user['username'])){
			return 'er01';
		}elseif($user['email'] === ''){
			return 'er31';
		}else{
			return 'er30';
		}
	}
}