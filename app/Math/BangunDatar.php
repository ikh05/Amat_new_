<?php 

include_once 'BReal.php';

class BangunDatar{
	protected $id;
	protected $luas;
	protected $keliling;

	public function __construct(){
		if(get_class($this) == 'BangunDatar'){
			$jenis = ['Segitiga', 'Persegi'];
			$ambil = $jenis[array_rand($jenis)];
			include_once "$ambil.php";
			$this->bangun = new $ambil;
		}
	}
	/* RANDOM */
	protected function randSisi($ras, $ir = FALSE){
		// nilai harus di positifkan kan
		$ras = Bilangan::abs($ras);
		$ir = Bilangan::abs($ir);

		// cek nilai ras dan ir jika array, agar [0] < [1];
		if(is_array($ras)) Bilangan::cekMinMax($ras[0], $ras[1]);
		if(is_array($ir)) Bilangan::cekMinMax($ir[0], $ir[1]);

		// Rasional
		if(is_array($ras)){
			$ras = mt_rand($ras[0], $ras[1]);
		}elseif(is_numeric($ras)){
			$ras = new BRasional($ras);
		}

		// Irasional
		if(!$ir){
			$ir = new BRasional();
		}else{
			if(is_array($ir)){
				$buff = [];
				for ($i=$ir[0]; $i <= $ir[1]; $i++) {
					$sqrt = sqrt($i);
					if((round($sqrt) != $sqrt)){
						$buff []= $i;
					}
				}

				if($ir[0] <= 1 && $ir[1] >= 1) $buff[] = 1;
				$ir = (count($buff) == 0) ? 1 : $buff[array_rand($buff)];
			}elseif(is_numeric($ir)){
				$sqrt = sqrt($ir);
				$ir = ($sqrt != round($sqrt)) ? $ir : 1;
			}
		}


		// Akar
		$hasil = new BReal($ras, $ir);
		return $hasil;
	}
	protected function randHuruf($banyak){
		$angka = mt_rand(11,36 - $banyak);
		$hasil = [];
		for ($i=0; $i < $banyak; $i++) { 
			$hasil []= strtoupper(base_convert($angka+$i, 10, 36));
		}
		return $hasil; /*hasil berupa array*/
	}

	/* GET */
	public function clone($allPropertys = NULL){
		if(is_null($allPropertys)) $allPropertys = get_object_vars($this);
		unset($allPropertys['id']);
		$class = get_class($this);
		$clone = new $class ();
		foreach ($allPropertys as $key => $value) {
			Bilangan::setNilai($clone, $key, $value);
		}
		return $clone;
	}
	public function getBangun (){
		return $this->bangun->getBangun();
	}


	/* PRINT */
	public function print($soal = ''){
		if(strpos($soal, $this->id)){
			$soal = str_replace($this->id.'__luas', Bilangan::print($this->luas), $soal);
			$soal = str_replace($this->id.'__keliling', Bilangan::print($this->keliling), $soal);
		}else{
			$soal = str_replace('__luas', Bilangan::print($this->luas), $soal);
			$soal = str_replace('__keliling', Bilangan::print($this->keliling), $soal);
		}
		return $soal;
	}
}





