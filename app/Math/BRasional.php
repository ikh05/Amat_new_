<?php

include_once 'core/Bilangan.php';

class BRasional{
	protected $pembilang, $penyebut;
	protected $nilai;
	protected $oneIsValid;
	protected $campuran = FALSE;
	function __construct($a = 1, $b = 1, $oneIsValid = TRUE){
		$this->setNilai($a, $b);
		$this->nilai = $a/$b;
		$this->oneIsValid = $oneIsValid;
	}

	/* SET */
	public function setOneIsValid($bool = TRUE){
		$this->oneIsValid = $bool;
	}
	public function setCampuran($bool = TRUE){
		$this->campuran = $bool;
	}
	public function setNilai($a, $b){
		
		if(is_object($b)){
			if($b->getNilai() < 0){
				$a = Bilangan::invers($a);
				$b = Bilangan::abs($b);
			}elseif($b->getNilai() == 0){
				$b = 1;
			}
		}
		if(is_numeric($b)){
			if($b < 0){
				$a = Bilangan::invers($a);
				$b = Bilangan::abs($b);
			}elseif($b == 0){
				$b = 1;
			}
		}
		$this->pembilang = $a;
		$this->penyebut = $b;
	}
	


	/* GET */
	public function getPenyebut(){
		return $this->penyebut;
	}
	public function getPembilang(){
		return $this->pembilang;
	}
	public function getNilai(){
		return $this->nilai;
	}
	public function getFpb(){
		return Bilangan::fpb($this->pembilang, $this->penyebut);
	}
	public function bisaDioprasikan($a, $op = 0){
		return TRUE;
	}
	public function getNilaiSTR(){
		return "{$this->pembilang}/{$this->penyebut}";
	}
	public function clone (){
		return new BRasional($this->pembilang, $this->penyebut, $this->oneIsValid);
	}


	/* OPERASI */
	public function tambah(BRasional $a){
		// ambil komponen a
		$a_penyebut = $a->getPenyebut();
		
		/** Menyamakan penyebut
		 * cari kpk dari penyebut
		 * kalikan ke pembilang agar nilainya tetap
		*/
		$kpk = Bilangan::kpk($this->penyebut, $a_penyebut);
		$pembilang = $this->pembilang * $kpk / $this->penyebut;
		$a_pembilang = $a->getPembilang() * $kpk / $a_penyebut;
		return new BRasional(($pembilang+$a_pembilang), $kpk ,$this->oneIsValid);
	}
	public function kurang(BRasional $a){
		// ambil komponen a
		$a_penyebut = $a->getPenyebut();
		$kpk = Bilangan::kpk($this->penyebut, $a_penyebut);
		$pembilang = $this->pembilang * $kpk / $this->penyebut;
		$a_pembilang = $a->getPembilang() * $kpk / $a_penyebut;
		return new BRasional(($pembilang-$a_pembilang), $kpk ,$this->oneIsValid);
	}
	public function kali(BRasional $a){
		$pembilang = $this->pembilang * $a->getPembilang();
		$penyebut = $this->penyebut * $a->getPenyebut();
		return new BRasional($pembilang, $penyebut, $this->oneIsValid);
	}
	public function bagi(BRasional $a){
		$pembilang = $this->pembilang * $a->getPenyebut();
		$penyebut = $this->penyebut * $a->getPembilang();
		return new BRasional($pembilang, $penyebut, $this->oneIsValid);
	}
	public function abs(){
		return new BRasional(abs($this->pembilang), $this->penyebut, $this->oneIsValid);
	}
	public function invers(){
		return new BRasional($this->pembilang*(-1), $this->penyebut, $this->oneIsValid);
	}

	public function sederhanakan(){
		/**
		 * cari FPB dari bilangan
		 * bagi penyebut dan pembilang dengan FPB
		*/
		$fpb = $this->getFpb();
		$pembilang = $this->pembilang / $fpb;
		$penyebut = $this->penyebut / $fpb;
		return new BRasional($pembilang, $penyebut, $this->oneIsValid);
	}




	/* PRINT */
	public function print(){
		if($this->pembilang == 0) return 0;
		return $this->campuran ? $this->printCampuran() : $this->printBiasa();
	}
	protected function printCampuran($a=null, $b=null){
		$a = is_null($a) ? $this->pembilang : $a;
		$b = is_null($b) ? $this->penyebut : $b;
		$bulat = floor($a/$b);
		$a = $a % $b;

		if($bulat == 0) return $this->printBiasa($a, $b);
		if($a == 0) return $bulat;
		return $bulat.$this->printBiasa($a, $b);
	}
	/** a/b
	 * a = 0 | b != 0 => 0 v
	 * a > 1 | b != 1 => a/b  
	 * a < 0 | b != 1 => a/b dengan - didepan
	 * a = 1 | b = 1 => 1 jika oneIsValid, '' v
	 * a = -1 | b = 1 => -1 jika oneIsValid, '-' v 
	*/
	protected function printBiasa($a=null, $b=null){
		$a = is_null($a) ? $this->pembilang : $a;
		$b = is_null($b) ? $this->penyebut : $b;
		if($a == 1 && $b == 1 ) return ($this->oneIsValid) ? 1 : "";
		if($a == -1 && $b == 1) return ($this->oneIsValid) ? -1 : "-";
		if($b == 1) return $a;
		if($a < 0 && $b != 1) return "-".Bilangan::printFrac(abs($a), $b);
		return Bilangan::printFrac($a, $b);
	}

}