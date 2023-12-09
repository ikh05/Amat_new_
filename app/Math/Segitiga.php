<?php 

include_once 'BangunDatar.php';

class Segitiga extends BangunDatar{
	protected $hA, $hB, $hC;
	protected $pAB, $pAC, $pBC;
	protected $tAB, $tAC, $tBC;
	protected $jenis;

	function __construct(){
		if(get_class($this) == 'Segitiga'){
			$jenis = ['SegitigaSiku'];
			$ambil = $jenis[array_rand($jenis)];
			include_once "$ambil.php";
			$this->bangun = new $ambil;
		}else{
			$this->randHuruf();
			$this->keliling = $this->setKeliling();
			if(is_array($this->keliling)){
				foreach ($this->keliling as $key => $value) {
					$this->keliling[$key] = $value->sederhanakan(TRUE, TRUE);
				}
			}else{
				$this->keliling = $this->keliling->sederhanakan(TRUE, TRUE);
			}
			$this->luas = $this->setLuas();
			$this->luas = $this->luas->sederhanakan(TRUE, TRUE);
			// echo "Segitiga >> __construct >> baris ".__LINE__." | luas menggunakan ".var_dump($this->luas)." <br>";
		}
	}

	
	/* RANDOM */
	protected function randHuruf($banyak = 3){
		$huruf = parent::randHuruf(3);
		$this->hA = $huruf[0];
		$this->hB = $huruf[1];
		$this->hC = $huruf[2];
	}
	protected function randSisi($ras, $ir = FALSE){
		return parent::randSisi($ras, $ir);
	}

	/** HITUNG / SET
	 * panjang semua sisi,
	 * keliling
	 *  
	*/
	// Luas
	protected function setLuas(){
		// if(is_null($this->luas)){

			// cek apakah bisa pakai a*t/2
			$data = ['AB', 'BC', 'AC'];
			foreach ($data as $value) {
				$p = 'p'.$value;
				$t = 't'.$value;
				if(!is_null($this->$p) && !is_null($this->$t)){
					// echo "Segitiga >> setLuas >> baris ".__LINE__." | luas menggunakan $value <br>";
					return $this->setLuas_at($p, $t);
				}
			}

			// echo "Segitiga >> setLuas >> baris ".__LINE__." | masuk ke sini <br>";
			// // cek apakah bisa pakai keliling
			// if(!is_array($this->keliling) && !is_null($this->keliling)){
			// 	return $this->setLuas_Sisi();
			// }

			// cek 2 sisi 1 sudut
			// $data = [['pAB', 'pAC', 'sinA'],['pAB', 'pBC', 'sinB'],['pBC', 'pAC', 'sinC']];
			// foreach ($data as $value) {
			// 	$a = $value[0];
			// 	$b = $value[1];
			// 	$c = $value[2];
			// 	if(isset($this->$a) && isset($this->$b) && isset($this->$c)){
			// 		if(!is_null($this->$a) && !is_null($this->$b) && !is_null($this->$c)){
			// 			return $this->setLuas_2sisi1sudut($value);
			// 		}
			// 	}
			// }

			// cek 2 sudut 1 sisi
			// coming soon, saat rand bisa 2 sudut 1 sisi

			// kembalikan nilai yang ada
		// }
		return $this->luas;
	}
	protected function setLuas_2sisi1sudut($value){
		$dua = new BReal(2);
		$a = $value[0];
		$b = $value[1];
		$c = $value[2];
		$hasil = Bilangan::operasi(Bilangan::operasi(Bilangan::operasi($this->$a, $this->$b, '*'), $this->$c, '*'), $dua, '/');
		return Bilangan::sederhanakan($hasil);
	}
	protected function setLuas_at($p, $t){
		$dua = new BReal(2);
		// echo "Segitiga >> setLuas_at >> baris ".__LINE__." | p = {$p}"."<br>";
		return Bilangan::operasi(Bilangan::operasi($this->$p, $this->$t, '*'), $dua, '/');
	}
	protected function setLuas_Sisi(){
		$dua = new BReal(2);
		if(is_null($this->keliling)){
			$this->keliling = $this->setKeliling();
		}
		$s = Bilangan::operasi($this->keliling, $dua, '/');
		$sa = Bilangan::operasi($s, $this->pBC, '-');
		$sb = Bilangan::operasi($s, $this->pAC, '-');
		$sc = Bilangan::operasi($s, $this->pAB, '-');
		$s = Bilangan::operasi($s, $sa, '*');
		$s = Bilangan::operasi($s, $sb, '*');
		$s = Bilangan::operasi($s, $sc, '*');

		$s = $s->tarikAkar();
		$sqrt = $s->getRasional();
		$hasil = new Bilanagan(1, $sqrt, 2, $s->getIsComplex());
		return Bilangan::sederhanakan($hasil);
	}
	
	// Keliling
	protected function setKeliling(){
		// cek apakah pAB, pBC, dan pAC ada dan bukan null
		if(!is_null($this->pAB) && !is_null($this->pBC) && !is_null($this->pAC)){
			$hasil = Bilangan::operasi($this->pAB, Bilangan::operasi($this->pBC, $this->pAC, '+'), '+');
			return Bilangan::sederhanakan($hasil);
		}
		return $this->keliling;
	}
	// Tinggi
	protected function setTinggi($t){
		$dua = new BReal(2);
		$p = $t;
		$p[0] = 'p';
		if(is_null($this->luas)){
			$this->setLuas();
		}

		// 1 sisi dan 1 sudut yang bersesuaian >> pBC dan cosA
		return (!is_null($this->luas)) ?
			Bilangan::operasi(Bilangan::operasi($this->luas, $dua, 'x'), $this->$p, '/') : 
			$this->luas;
	}

	/* GET */
	public function clone($allPropertys = NULL){
		if(is_null($allPropertys)) $allPropertys = get_object_vars($this);
		unset($allPropertys['hA']);
		unset($allPropertys['hB']);
		unset($allPropertys['hC']);
		return parent::clone($allPropertys);
	}
	public function getBangun (){
		return $this->bangun->getBangun();
	}

	/* PRINT */
	public function print ($soal = ''){
		if(strpos($soal, $this->id)){
			$soal = str_replace($this->id.'__hA', $this->hA, $soal);
			$soal = str_replace($this->id.'__hB', $this->hB, $soal);
			$soal = str_replace($this->id.'__hC', $this->hC, $soal);
			$soal = str_replace($this->id.'__pAB', Bilangan::print($this->pAB), $soal);
			$soal = str_replace($this->id.'__pBC', Bilangan::print($this->pBC), $soal);
			$soal = str_replace($this->id.'__pAC', Bilangan::print($this->pAC), $soal);
		}else{
			$soal = str_replace('__hA', $this->hA, $soal);
			$soal = str_replace('__hB', $this->hB, $soal);
			$soal = str_replace('__hC', $this->hC, $soal);
			$soal = str_replace('__pAB', Bilangan::print($this->pAB), $soal);
			$soal = str_replace('__pBC', Bilangan::print($this->pBC), $soal);
			$soal = str_replace('__pAC', Bilangan::print($this->pAC), $soal);
		}
		return parent::print($soal);
	}

	protected function phytagoras($a, $b, $ditanyakan = 'miring'){
		// Bisa menjadi bilangan rasional
		$a_kuadrat = Bilangan::operasi($a, $a, 'kali')->tarikAkar();
		$b_kuadrat = Bilangan::operasi($b, $b, 'kali')->tarikAkar();
		if($ditanyakan == 'miring'){
			$sqrt = Bilangan::operasi($a_kuadrat, $b_kuadrat, '+');
		}else{
			$sqrt = Bilangan::operasi($a_kuadrat, $b_kuadrat, '-');
		}
		$sqrt = Bilangan::abs($sqrt->getRasional());
		$hasil = new BReal(1, $sqrt, 2, $a->getIsComplex());
		return $hasil->tarikAkar();
	}

}