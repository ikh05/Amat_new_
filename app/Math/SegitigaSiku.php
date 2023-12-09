<?php 

include_once 'Segitiga.php';

/** Batasan Segitiga Siku-siku
 * akar pada panjang sisi adalah akar pangkat 2
*/
class SegitigaSiku extends Segitiga{
	protected $siku;
	public static $countId = 1;
	function __construct($ras = [5,30], $ir = FALSE){
		// echo "didalam SegitigaSiku <br>";
		$this->id = '__BDSSK-'.self::$countId;
		self::$countId ++;
		$this->jenis = 'Segitiga Siku-siku';
		$this->siku = $this->randSiku();
		$this->randSisi($ras, $ir);

		$this->setTinggi();
		// parent::__construct();
		parent::__construct();
		$this->setTinggi();
		parent::__construct();
	}

	/* RANDOM */
	protected function randSiku(){
		$sisi = ['hA', 'hB', 'hC'];
		return $sisi[array_rand($sisi)];
	}
	protected function randSisi($ras, $ir = FALSE){
		switch ($this->siku) {
			case 'hA':
				$this->pAB = parent::randSisi($ras, $ir);
				$this->pAC = parent::randSisi($ras, $ir);
				$this->pBC = $this->phytagoras($this->pAC, $this->pAB);
				break;
			case 'hB':
				$this->pAB = parent::randSisi($ras, $ir);
				$this->pBC = parent::randSisi($ras, $ir);
				$this->pAC = $this->phytagoras($this->pBC, $this->pAB);
				break;
			case 'hC':
				$this->pBC = parent::randSisi($ras, $ir);
				$this->pAC = parent::randSisi($ras, $ir);
				$this->pAB = $this->phytagoras($this->pAC, $this->pBC);
				break;
		}
	}
	protected function randTripel(Array $ras = [1, 70]){
		// buat array tripel yang berada di rentan
		$tripel = [];
		for ($a = 1; $a < $ras[1]-1; $a++) { 
			for ($b=$a+1; $b < $ras[1] ; $b++) { 
				// 3 dan 4
				$v1 = $a*$a + $b*$b; /*3.3 + 4.4 = 9 + 16 = 25*/
				$v2 = 2*$a*$b; /*2.3.4 = 24*/
				$v3 = $b*$b - $a*$a;
				if($v1 < $ras[1] && $v2 < $ras[1] && $v3 < $ras[1] && $v1 > $ras[0] && $v2 > $ras[0] && $v3 > $ras[0]){
					$tripel []= [$v1, $v2, $v3];
				}
			}
		}

		if(count($tripel) > 0){
			$sisi = $tripel[array_rand($tripel)];
			$v1 = $sisi[0];
			$v2 = $sisi[1];
			Bilangan::cekMinMax($v2, $v1);
			$terpendek = [$v2, $sisi[2]];
			$v2 = mt_rand(0,1);
			if($this->siku == 'hA'){
				$this->pBC = new BReal($v1);
				$this->pAB = new BReal($terpendek[$v2]);
				$this->pAC = new BReal($terpendek[$v2 ? 0 : 1]);
			}elseif($this->siku == 'hB'){
				$this->pAC = new BReal($v1);
				$this->pAB = new BReal($terpendek[$v2]);
				$this->pBC = new BReal($terpendek[$v2 ? 0 : 1]);

			}else{
				$this->pAB = new BReal($v1);
				$this->pBC = new BReal($terpendek[$v2]);
				$this->pAC = new BReal($terpendek[$v2 ? 0 : 1]);

			}
			$this->setTinggi();
			parent::__construct();
			$this->setTinggi();
			parent::__construct();
		}
	}

	/* SETTING */
	public function setting($value){
		if(isset($value['tripel'])){
			// hilangkan simbol selain angka, '-', dan ','
			$string = preg_replace("/[^0-9-,]/", "", $value['tripel']);
			$ras = explode(",",$string);
			if(isset($ras[1])){
				$this->randTripel($ras);
			}else{
				$this->randTripel();
			}
		}
		if(in_array('trigonometri', $value)){
			$this->setTrigonometri();
		}
		if(in_array('sudut', $value)){
			$this->setTrigonometri();
			$this->setSudut();
		}
	}



	/* HITUNG / SET*/
	// Set Nilai
	public function setNilai($nama, $nilai){
		$this->$nama = $nilai;
	}
	// Tinggi
	protected function setTinggi($t = NULL){
		switch ($this->siku) {
			case 'hA':
				$this->tAB = $this->pAC;
				$this->tAC = $this->pAB;
				$this->tBC = parent::setTinggi('tBC');
				break;
			case 'hB':
				$this->tAB = $this->pBC;
				$this->tBC = $this->pAB;
				$this->tAC = parent::setTinggi('tAC');
				break;
			case 'hC':
				$this->tBC = $this->pAC;
				$this->tAC = $this->pBC;
				$this->tAB = parent::setTinggi('tAB');
				break;
		}
	}

	// phytagoras
	protected function phytagoras($a, $b, $ditanykan = null){
		// Bisa menjadi bilangan rasional
		$a_kuadrat = Bilangan::operasi($a, $a, 'kali')->tarikAkar();
		$b_kuadrat = Bilangan::operasi($b, $b, 'kali')->tarikAkar();
		$sqrt = Bilangan::operasi($a_kuadrat, $b_kuadrat, '+');
		$sqrt = $sqrt->getRasional();
		$hasil = new BReal(1, $sqrt, 2, $a->getIsComplex());
		return $hasil->tarikAkar();
	}

	// trigonometri
	protected function setTrigonometri(){
		include_once 'Trigonometri.php';
		$this->setCos();
		$this->setSin();
		$this->setTan();
	}
	protected function setCos(){
		switch ($this->siku) {
			case 'hA':
				$this->cosA = new BReal(0);
				$this->cosB = Trigonometri::cos($this->pAB, $this->pBC);
				$this->cosC = Trigonometri::cos($this->pAC, $this->pBC);
				break;
			case 'hB':
				$this->cosA = Trigonometri::cos($this->pAB, $this->pAC);
				$this->cosB = new BReal(0);
				$this->cosC = Trigonometri::cos($this->pBC, $this->pAC);
				break;
			case 'hC':
				$this->cosA = Trigonometri::cos($this->pAC, $this->pAB);
				$this->cosB = Trigonometri::cos($this->pBC, $this->pAB);
				$this->cosC = new BReal(0);
				break;
		}
	}
	protected function setSin(){
		switch ($this->siku) {
			case 'hA':
				$this->sinA = new BReal(1);
				$this->sinB = Trigonometri::sin($this->pAC, $this->pBC);
				$this->sinC = Trigonometri::sin($this->pAB, $this->pBC);
				break;
			case 'hB':
				$this->sinA = Trigonometri::sin($this->pBC, $this->pAC);
				$this->sinB = new BReal(1);
				$this->sinC = Trigonometri::sin($this->pAB, $this->pAC);
				break;
			case 'hC':
				$this->sinA = Trigonometri::sin($this->pAC, $this->pAB);
				$this->sinB = Trigonometri::sin($this->pBC, $this->pAB);
				$this->sinC = new BReal(1);
				break;
		}
	}
	protected function setTan(){
		switch ($this->siku) {
			case 'hA':
				$this->tanA = '-';
				$this->tanB = Trigonometri::tan($this->pAC, $this->pAB);
				$this->tanC = Trigonometri::tan($this->pAB, $this->pAC);
				break;
			case 'hB':
				$this->tanA = Trigonometri::tan($this->pBC, $this->pAB);
				$this->tanB = '-';
				$this->tanC = Trigonometri::tan($this->pAC, $this->pBC);
				break;
			case 'hC':
				$this->tanA = Trigonometri::tan($this->pBC, $this->pAC);
				$this->tanB = Trigonometri::tan($this->pAC, $this->pBC);
				$this->tanC = '-';
				break;
		}
	}

	// sudut
	protected function setSudut(){
		switch ($this->siku) {
			case 'hA':
				$this->sudutA = 90;
				$this->sudutB = round(rad2deg(acos($this->cosB->getNilai())),2);
				$this->sudutC = round(rad2deg(acos($this->cosC->getNilai())),2);
				break;
			case 'hB':
				$this->sudutA = round(rad2deg(acos($this->cosA->getNilai())),2);
				$this->sudutB = 90;
				$this->sudutC = round(rad2deg(acos($this->cosC->getNilai())),2);
				break;
			case 'hC':
				$this->sudutA = round(rad2deg(acos($this->cosA->getNilai())),2);
				$this->sudutB = round(rad2deg(acos($this->cosB->getNilai())),2);
				$this->sudutC = 90;
				break;
		}
	}


	// Trasformasi
	public function dilatasi(Array $skala = [1]){
		$skala = new BReal((isset($skala[1])) ? $skala : $skala[0]); 
		$clone = Bilangan::clone($this);
		$clone->pAB = Bilangan::operasi($this->pAB, $skala, '*');
		$clone->pAC = Bilangan::operasi($this->pAC, $skala, '*');
		$clone->pBC = Bilangan::operasi($this->pBC, $skala, '*');
		$clone->tAB = Bilangan::operasi($this->tAB, $skala, '*');
		$clone->tAC = Bilangan::operasi($this->tAC, $skala, '*');
		$clone->tBC = Bilangan::operasi($this->tBC, $skala, '*');
		$clone->keliling = Bilangan::operasi($this->keliling, $skala, '*');
		$clone->luas = Bilangan::operasi($this->luas, Bilangan::operasi($skala, $skala, '*'), '*');

		return $clone;
	}


	/* GET */
	public function clone ($allPropertys = NULL){
		if(is_null($allPropertys)) $allPropertys = get_object_vars($this);
		return parent::clone($allPropertys);
	}
	public function getBangun (){
		return $this;
	}

	/* PRINT */
	public function print($soal = ''){
		$siku = $this->siku;
		if($soal == ''){
			// normal
			// var_dump($this->pAC);
			$soal .= "Sebuah $this->jenis $this->hA$this->hB$this->hC dengan id $this->id yang memiliki: <br>
				 - Siku-siku di titik {$this->$siku} <br>
				 - panjang sisi $this->hA$this->hB = ".Bilangan::print($this->pAB)."<br>
				 - panjang sisi $this->hA$this->hC = ".Bilangan::print($this->pAC)."<br>
				 - panjang sisi $this->hB$this->hC = ".Bilangan::print($this->pBC)."<br>
				 - keliling = ".Bilangan::print($this->keliling)."<br>
				 - luas = ".Bilangan::print($this->luas)."<br>";
				// trigonometri
			if(isset($this->cosA)){
				$soal .= "- cos$this->hA = ".Bilangan::print($this->cosA)."<br>
				 - sin$this->hA = ".Bilangan::print($this->sinA)."<br>";
			}
			// sudut
			if(isset($this->sudutA)){
				$soal .= "- sudut $this->hA = ".Bilangan::print($this->sudutA)."<br>
				 - sudut $this->hB = ".Bilangan::print($this->sudutB)."<br>
				 - sudut $this->hC = ".Bilangan::print($this->sudutC)."<br>"; 
			}
		}else{
			// cek apakah ada __BDSSK-1 didalam soal
			if(strpos($soal, $this->id)){
				$soal = str_replace($this->id.'__jenis', $this->jenis, $soal);
				$soal = str_replace($this->id.'__siku', $this->$siku, $soal);
				if(isset($this->cosA)){
					$soal = str_replace($this->id.'__cosA', Bilangan::print($this->cosA), $soal);
					$soal = str_replace($this->id.'__cosB', Bilangan::print($this->cosB), $soal);
					$soal = str_replace($this->id.'__cosC', Bilangan::print($this->cosC), $soal);
					$soal = str_replace($this->id.'__sinA', Bilangan::print($this->sinA), $soal);
					$soal = str_replace($this->id.'__sinB', Bilangan::print($this->sinB), $soal);
					$soal = str_replace($this->id.'__sinC', Bilangan::print($this->sinC), $soal);
					$soal = str_replace($this->id.'__tanA', Bilangan::print($this->tanA), $soal);
					$soal = str_replace($this->id.'__tanB', Bilangan::print($this->tanB), $soal);
					$soal = str_replace($this->id.'__tanC', Bilangan::print($this->tanC), $soal);
				}
				if(isset($this->sudutA)){
					$soal = str_replace($this->id.'__sudutA', Bilangan($this->sudutA), $soal);
					$soal = str_replace($this->id.'__sudutB', Bilangan($this->sudutB), $soal);
					$soal = str_replace($this->id.'__sudutC', Bilangan($this->sudutC), $soal);
				}
			}else{
				$soal = str_replace('__jenis', $this->jenis, $soal);
				$soal = str_replace('__siku', $this->$siku, $soal);
				if(isset($this->cosA)){
					$soal = str_replace('__cosA', Bilangan::print($this->cosA), $soal);
					$soal = str_replace('__cosB', Bilangan::print($this->cosB), $soal);
					$soal = str_replace('__cosC', Bilangan::print($this->cosC), $soal);
					$soal = str_replace('__sinA', Bilangan::print($this->sinA), $soal);
					$soal = str_replace('__sinB', Bilangan::print($this->sinB), $soal);
					$soal = str_replace('__sinC', Bilangan::print($this->sinC), $soal);
					$soal = str_replace('__tanA', Bilangan::print($this->tanA), $soal);
					$soal = str_replace('__tanB', Bilangan::print($this->tanB), $soal);
					$soal = str_replace('__tanC', Bilangan::print($this->tanC), $soal);
				}
				if(isset($this->sudutA)){
					$soal = str_replace('__sudutA', Bilangan::print($this->sudutA), $soal);
					$soal = str_replace('__sudutB', Bilangan::print($this->sudutB), $soal);
					$soal = str_replace('__sudutC', Bilangan::print($this->sudutC), $soal);
				}
			}
		}
		return parent::print($soal);
	}



}