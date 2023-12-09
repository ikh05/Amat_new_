<?php 
class Home extends Controller{
	public function index(){
		$data['user'] = $_SESSION[LOGIN];
		$data['judul'] = 'Home';
		$this->view('templates/baseMenu', $data);
	}
	public function potralMenu($isi = 'beranda'){
		$data['menu'] = $this->json('menu', $isi);
		$data['header'] = $isi;
		$this->potralView('Home/index', $data);
	} 
	public function tutorial(){
		$data['user'] = $_SESSION[LOGIN];
		$data['judul'] = 'Tutorial';
		$this->view('Home/tutorial', $data);
	}
	public function setting(){
		$this->potralView('Home/setting');
	}
}