<?php 

class Tugas extends Controller{
	public function index($potral = null){
		$data['user'] = $_SESSION[LOGIN];
		$data['judul'] = 'Tugas';
		if(is_null($potral)){
			$data['template'] = 'baseHome';
			$this->view('Tugas/index', $data);
		}else{
			$this->potralView('Tugas/index', $data);
		}
	}
}