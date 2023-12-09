<?php 


class Mass_model {
	public function getError($key){
		$key = strtolower($key);
		$err = [];
		$err ['er00']= 'Selamat Datang! Silahkan login!';
		$err ['er01']= 'Username/Email tidak ditemukan!'; 
		$err ['er02']= 'Password salah!';
		$err ['er03']= 'Password salah! Apakah anda ingin mengubah password <button class="btn lupaPass">~ Ya ~</button>';
		$err ['er11']= 'Username sudah digunakan!';
		$err ['er12']= 'Password dan Konfirmasi Password yang anda masukkan berbeda!';
		$err ['er21']= 'Anda belum login!';
		$err ['er30']= 'fitur lupa password belum diaktifkan, silahkan buat akun baru atau hubungi admin';
		$err ['er31']= 'tidak dapat melakukan upah password dikarenakan akun  tidak memiliki email yang terkait. Silahkan buat akun baru atau hubungi admin!';
		return (array_key_exists($key, $err)) ? $err[$key] : null;
	}
	public function getMess($key){
		$key = strtolower($key);
		if(!is_null($key)){
			$mass = [];
			$mass ['up01']= 'Terdapat pembaharuan di profil, silahkan lengkapi data anda!';
			return (array_key_exists($key, $mass)) ? $mass[$key] : null;
		}
		else
			return null;
	}
}