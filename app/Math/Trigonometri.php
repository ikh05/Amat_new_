<?php 

include_once 'core/Bilangan.php';

class Trigonometri{
	public static function cos($samping, $miring){
		return Bilangan::operasi($samping, $miring, '/');
	}
	public static function sin($depan, $miring){
		return Bilangan::operasi($depan, $miring, '/');
	}
	public static function tan($depan, $samping){
		return Bilangan::operasi($depan, $samping, '/');
	}
	
}