<?php 

class Profil extends Controller{
	function index(){
		$data['user'] = $_SESSION[LOGIN];
		$data['judul'] = 'Profil';
		$this->view('templates/baseMenu', $data);
	}
	public function potralMenu(){
		$data['user'] = $_SESSION[LOGIN];
		$this->potralView('Profil/index', $data);
	} 
}