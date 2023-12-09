<?php 

include_once 'BRasional.php';

class BReal {
	protected $rasional;
	protected $irasional;
	protected $akar;
	protected $nilai;
	protected $isComplex;
	function __construct($a = 1, $b = 1, $c = 2 , $isComplex = FALSE){
		if(is_numeric($b)) $b = ($b == 0) ? 1 : $b;
		$this->setNilai('rasional', $a);
		$this->setNilai('irasional', $b);
		$this->setNilai('akar', $c);
		if(!$isComplex){
			$this->irasional = Bilangan::abs($this->irasional);
		} 
		$this->isComplex = $isComplex;

		// echo "<br> rasional = ".Bilangan::print($this->rasional);
		// echo "<br> irasional = ".Bilangan::print($this->irasional);
		// echo "<br> akar = ".Bilangan::print($this->akar);

		// echo "Real >> __construct | baris ".__LINE__." | nilai dari irasional = ".Bilangan::print($this->irasional)."<br>";
		// echo "Real >> __construct | baris ".__LINE__." | nilai dari bilangan = ".Bilangan::print($this)."<br>";

		$this->nilai = $this->rasional->getNilai() * abs($this->irasional->getNilai()) ** (1/$this->akar->getNilai());
	}


	/* SET */
	protected function setNilai($posisi, $nilai){
		if(is_object($nilai)){
			// echo "Real >> setNilai | baris ".__LINE__." | nilai dari $posisi = ".Bilangan::print($nilai)."<br>";
			$this->$posisi = $nilai;
		}elseif(is_array($nilai)){
			// echo "Real >> setNilai | baris ".__LINE__." | nilai berupa array .<br>";
			$this->$posisi = new BRasional ($nilai[0], $nilai[1]);
		}elseif(is_numeric($nilai)){
			// echo "Real >> setNilai | baris ".__LINE__." | nilai berupa numeric .<br>";
			$this->$posisi = new BRasional ($nilai);
		}
	}

	/* GET */
	public function getAkar(){
		return Bilangan::clone($this->akar);
	}
	public function getRasional(){
		return Bilangan::clone($this->rasional);
	}
	public function getIrasional(){
		return Bilangan::clone($this->irasional);
	}
	public function getIsComplex(){
		return $this->isComplex;
	}
	public function bisaDioprasikan($a, $op = 'tambah'){
		$hasil = TRUE;
		switch ($op) {
			case 'tambah':
			case 'kurang':
				$hasil = ($hasil && $this->irasional->getNilai() == $a->getIrasional()->getNilai());
			case 'kali':
			case 'bagi':
				$hasil = ($hasil && $this->akar->getNilai() == $a->getAkar()->getNilai());
				break;	
		}
		return $hasil;
	}
	public function getNilai(){
		return $this->nilai;
	}
	public function clone(){
		$rasional = Bilangan::clone($this->rasional);
		$irasional = Bilangan::clone($this->irasional);
		$akar = Bilangan::clone($this->akar);
		return new BReal($rasional, $irasional, $akar, $this->isComplex);
	}




	/* OPERASI */
	public function tambah (BReal $value){
		$new_Rasional = Bilangan::operasi($this->rasional, $value->getRasional(), '+');
		return new BReal($new_Rasional, $this->irasional, $this->akar, $this->isComplex);
	}
	public function kurang (BReal $value){
		$new_Rasional = Bilangan::operasi($this->rasional, $value->getRasional(), '-');
		return new BReal($new_Rasional, $this->irasional, $this->akar, $this->isComplex);
	}
	public function kali(BReal $value){
		$new_Rasional = Bilangan::operasi($this->rasional, $value->getRasional(), '*');
		$new_Irasional = Bilangan::operasi($this->irasional, $value->getIrasional(), '*');
		return new BReal($new_Rasional, $new_Irasional, $this->akar, $this->isComplex);
	}
	public function bagi(BReal $value){
		$new_Rasional = Bilangan::operasi($this->rasional, $value->getRasional(), '/');
		$new_Irasional = Bilangan::operasi($this->irasional, $value->getIrasional(), '/');
		// echo "Real >> Bagi >> bagian iRasional = ".Bilangan::print($this->irasional)."<br>";
		// echo "Real >> Bagi >> bagian iRasional = ".Bilangan::print($value->getIrasional())."<br>";
		// echo "Real >> Bagi >> ".__LINE__."new iRasional = ".Bilangan::print($new_Irasional)."<br>";
		$hasil = new BReal($new_Rasional, $new_Irasional, $this->akar, $this->isComplex);
		// echo "Real >> Bagi >> hasil Pembagian = ".Bilangan::print($hasil)."<br>";
		return new BReal($new_Rasional, $new_Irasional, $this->akar, $this->isComplex);
	}
	public function sederhanakan($ras = TRUE, $ir = FALSE){
		$rasional = ($ras) ? $this->rasional->sederhanakan() : $this->rasional->clone();
		$irasional = ($ir) ? $this->irasional->sederhanakan() : $this->irasional->clone();
		return new BReal($rasional, $irasional, $this->akar, $this->isComplex);
	}
	public function invers(){
		$rasional = $this->rasional->invers();
		return new BReal($rasional, $this->irasional, $this->akar, $this->isComplex);
	}
	public function abs(){
		return new BReal (Bilangan::abs($this->rasional), $this->irasional, $this->akar, $this->isComplex);
	}
	public function tarikAkar(){
		$ir = Bilangan::clone($this->irasional);
		$pangkat = $this->akar->getPenyebut();
		$f_pembilang = Bilangan::getFaktor($ir->getPembilang() ** $pangkat);
		$f_penyebut = Bilangan::getFaktor($ir->getPenyebut() ** $pangkat);

		$hasilPembilang = $this->hasilTarikAkar($f_pembilang);
		$hasilPenyebut = $this->hasilTarikAkar($f_penyebut);

		$hasilRasional = new BRasional($hasilPembilang[0], $hasilPenyebut[0]);
		$hasilRasional = Bilangan::operasi($this->rasional, $hasilRasional, '*');
		$hasilIrasional = new BRasional($hasilPembilang[1], $hasilPenyebut[1]);

		return new BReal($hasilRasional, $hasilIrasional, $this->akar, $this->isComplex);
	}

	protected function hasilTarikAkar($faktor){
		$akar = $this->akar->getPembilang();
		$hasil = 1;
		$hasilAkar = 1;
		foreach ($faktor as $key => $value) {
			$hasil *= pow($key, floor($value/$akar));
			$hasilAkar *= pow($key, $value%$akar);
		}
		return [$hasil, $hasilAkar];
	}
	public function sekawan($a = null){
		return (is_null($a)) ? Bilangan::clone($this) : [Bilangan::clone($this), Bilangan::invers($a)];
	}
	public function rasoinalkan(){
		$clone = Bilangan::clone($this);
		if($this->irasional->getPenyebut() != 1){
			$pembilang = new BReal($this->rasional->getPembilang(), $this->irasional->getPembilang());
			$penyebut = new BReal($this->rasional->getPenyebut(), $this->irasional->getPenyebut());
			$sekawan = $penyebut->sekawan();

			$a = Bilangan::print([[$pembilang],'.',[$sekawan]]);
			$b = Bilangan::print([[$penyebut],'.',[$sekawan]]);

			// echo "sebelum dikalikan dengan sekawan = ".Bilangan::printFrac($a, $b)."<br>";

			$pembilang = Bilangan::operasi($pembilang, $sekawan, '*');
			$penyebut = Bilangan::operasi($penyebut, $sekawan, '*');

			// echo "setelah dikalikan dengan sekawan = ".Bilangan::printFrac($pembilang, $penyebut)."<br>";

			$pembilang = $pembilang->tarikAkar();
			$penyebut = $penyebut->tarikAkar();
			
			// echo "setelah tarikAkar = ".Bilangan::printFrac($pembilang, $penyebut)."<br>";

			$hasil = Bilangan::operasi($pembilang, $penyebut, '/')->sederhanakan(TRUE, TRUE);
			// echo " hasil Akhir = ".Bilangan::print($hasil)."<br>";

			return $hasil;
		}
		return $clone;
	}



	/* PRINT */
	public function print(){
		if($this->rasional->getNilai() == 0){
			return 0;
		}else{
			$hasil = '';
			// Rasional
			if(($this->rasional->getNilaiSTR() == '1/1' || $this->rasional->getNilaiSTR() == '-1/1') && $this->irasional->getNilaiSTR() != '1/1'){
				$this->rasional->setOneIsValid(FALSE);
			}
			$hasil .= Bilangan::print($this->rasional);

			// Irasional
			if($this->irasional->getNilaiSTR() != '1/1' && $this->irasional->getNilai() > 0){
				// Akar
				if($this->akar->getNilaiSTR() == '2/1') $hasil .= Bilangan::printSqrt($this->irasional);
				else $hasil .= Bilangan::printSqrtN($this->irasional, $this->akar);
			}
			return $hasil;
		}
	}
}