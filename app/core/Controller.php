<?php 


class Controller{
	public function potralView($view, $data = []){
		// error
		if(isset($data['error']))
			if(!is_null($data['error'])) $this->view_error($data['error']);
		// massager
		if(isset($data['massager']))
			if(!is_null($data['massager'])) $this->view_massager($data['massager']);
		// isi
		include_once "../app/views/$view.php";
	}
	public function view($view, $data = []){
		// header
		$this->view_header();
		// error
		if(isset($data['error']))
			if(!is_null($data['error'])) $this->view_error($data['error']);
		// massager
		if(isset($data['massager']))
			if(!is_null($data['massager'])) $this->view_massager($data['massager']);
		// isi halaman
		include_once "../app/views/$view.php";
		// footer
		$this->view_footer();
	}
	protected function view_error($error = null){
		include_once '../app/views/templates/massages/error.php';
	}
	protected function view_massager($massager = null){
		include_once '../app/views/templates/massages/massager.php';
	}
	protected function view_header(){
		include_once '../app/views/templates/header_footer/header.php';
		include_once '../app/views/templates/header_footer/headerend.php';
	}
	protected function view_footer(){
		include_once '../app/views/templates/header_footer/footer.php';
		include_once '../app/views/templates/header_footer/footerend.php';
	}
	public function model($model){
		include_once ('../app/models/'.$model.'.php');
		return new $model;
	}
	public function math($math){
		include_once ('../app/math/'.$math.'.php');
	}
	public function json($repo, $key = null){
		if(file_exists("../app/Json/$repo.json")){
			if (is_string($key)) $key = strtolower($key);
			$json = json_decode(file_get_contents("../app/Json/$repo.json"), TRUE);
			return is_null($key) ? $json : $json[$key];
		}
	}
}
