<?php 

// cek apakah sudah login
$url = strtolower($_SERVER['REDIRECT_URL']);
if(isset($_SESSION[LOGIN]) && strpos($url, 'public/login/keluar') <= 0){
	if(strpos($url, 'public/login') > 0){
		// kirim ke Home
		header("Location: ".BASE_URL."Home");
		exit();
	}
}elseif(strpos($url, 'public/login/keluar') <= 0){
	if(strpos($url, 'public/login') == 0){
		header("Location: ".BASE_URL."Login/index/er21");
		exit();
	}
}