<?php 

include_once 'BangunDatar.php';	

class Persegi extends BangunDatar{
	protected $hA, $hB, $hC, $hD;
	protected $pS;
	protected $jenis;
	public static $countId = 1;

	function __construct($ras = [5,30], $ir = FALSE){
		$this->id = '__BDP-'.self::$countId;
		self::$countId ++;
		$this->jenis = 'Persegi';
		$this->pS = $this->randSisi($ras, $ir);
		$this->randHuruf();
		$this->luas = $this->setLuas();
		$this->keliling = $this->setKeliling();
	}

	/* RANDOM */
	protected function randHuruf($banyak = 4){
		$huruf = parent::randHuruf(4);
		$this->hA = $huruf[0];
		$this->hB = $huruf[1];
		$this->hC = $huruf[2];
		$this->hD = $huruf[3];
	}

	/* SETTING */
	/* SETTING */
	public function setting($value){
		if(in_array('sudut', $value)){
			$this->setSudut();
		}
	}

	/* SET */
	protected function setLuas(){
		$luas = Bilangan::operasi($this->pS, $this->pS, '*');
		return $luas->tarikAkar();
	}
	protected function setKeliling(){
		$empat = new BReal(4);
		return Bilangan::operasi($this->pS, $empat, '*');
	}
	protected function setSudut(){
		$this->sudut = 90;
	}

	/* GET */
	public function getBangun(){
		return $this;
	}


	/* PRINT */
	public function print ($soal = ''){
		if($soal == ''){
			$soal .= "Sebuah $this->jenis $this->hA$this->hB$this->hC$this->hD dengan id $this->id yang memiliki: <br>
				 - panjang sisi = ".Bilangan::print($this->pS)."<br>
				 - keliling = ".Bilangan::print($this->keliling)."<br>
				 - luas = ".Bilangan::print($this->luas)."<br>";
			if(isset($this->sudut)){
				$soal .= "Sudut = ".Bilangan::print($this->sudut);
			}
		}else{

		}

		return $soal;
	}

}