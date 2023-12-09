<?php 

class Bilangan{

	public static function clone($value){
		if(is_object($value)) return $value->clone();
		return clone $value;
	}
	public function clone_delete(&$value){
		$clone = self::clone($value);
		unset($value);
		return $value;
	}

	public static function setNilai(&$siapa, $nama, $nilai){
		if(is_object($siapa)){
			$siapa->setNilai($nama, $nilai);
		}
	}


	/* OPERASI */
	protected static function operasi_1($a, $b, $op = 'tambah'){
		$a_isArray = is_array($a) ? TRUE : FALSE;
		$b_isArray = is_array($b) ? TRUE : FALSE;
		if($a_isArray && $b_isArray){
			foreach ($a as $keyA => $valueA) {
				foreach ($b as $keyB => $valueB) {
					if($valueA->bisaDioprasikan($valueB, $op)){
						$a[$keyA]->$op($valueB);
						unset($b[$keyB]);
					}
				}
			}
		}elseif($a_isArray){
			foreach ($a as $key => $value) {
				if($b->bisaDioprasikan($value, $op)){
					$b = $b->$op($value);
					unset($a[$key]);
				}
			}
		}elseif($b_isArray){
			foreach ($b as $key => $value) {
				if($a->bisaDioprasikan($value, $op)){
					$a = $a->$op($value);
					unset($b[$key]);
				}
			}
		}else{
			if($a->bisaDioprasikan($b)){
				return $a->$op($b);
			}
		}
		$hasil = [];
		if($a_isArray && count($a) > 0) $hasil = array_merge($hasil, $a);
		else $hasil []= $a;
		if($b_isArray && count($b) > 0) $hasil = array_merge($hasil, $b);
		else $hasil []= $b;
		return $hasil;
	}
	protected static function operasi_2($a, $b, $op = 'kali'){
		$a_isArray = is_array($a) ? TRUE : FALSE;
		$b_isArray = is_array($b) ? TRUE : FALSE;

		// echo "operasi = $op <br>";
		// echo "a_isArray = $a_isArray <br>";
		// echo "b_isArray = $b_isArray <br>";

		if($a_isArray && $b_isArray){
			if($op == 'bagi') return "Core >> Bilangan.php >> operasi_2 >> Baris ".__LINE__." | masih belum bisa pembagian";
		}elseif($a_isArray){
			foreach ($a as $key => $value) {
				if($b->bisaDioprasikan($value, $op)){
					$a[$key] = $value->$op($b);
				}
			}
		}elseif($b_isArray){
			if($op == 'bagi') return "Core >> Bilangan.php >> operasi_2 >> Baris ".__LINE__." | masih belum bisa pembagian";
		}else{
			if($a->bisaDioprasikan($b, $op)){
				// echo "Bilangan >> Operasi 2 >> bisa dioperasikan <br>";

				return $a->$op($b);
			}
				// echo "Bilangan >> Operasi 2 >> tidak bisa dioperasikan <br>";
		}
		return $a;
	}

	public static function operasi($a, $b, $op = 'tambah'){
		$op = strtolower($op);
		if($op == '+') $op = 'tambah';
		elseif($op == '-') $op = 'kurang';
		elseif($op == '*' || $op == 'x' || $op == '.') $op = 'kali';
		elseif($op == '/' || $op == ':') $op = 'bagi';

		if($op == 'tambah' || $op == 'kurang') return self::operasi_1($a, $b, $op); 
		elseif($op == 'kali' || $op == 'bagi') return self::operasi_2($a, $b, $op); 
		else return 'operasi tidak diketahui!';
	}
	/* ABS */
	static public function abs($value){
		if(is_object($value)){
			return $value->abs();
		}elseif(is_numeric($value)){
			return abs($value);
		}elseif (is_array($value)) {
			foreach ($value as $k => $v) {
				$value[$k] = self::abs($v);
			}
			return $value;
		}
	}

	/* PRIMA */
	static public function prima($max){
		$hasil = [];
		for ($i=2; $i <= $max; $i++) {
			$isPrima = TRUE;
			for ($pembagi = ($i-1); $pembagi > ($i/2); $pembagi--) { 
				if($i % $pembagi == 0) $isPrima = FALSE;
			}
			if($isPrima) $hasil []= $i;
		}
		return $hasil;
	}




	/* KPK */
	static public function kpk($a=1, $b=1){
		if(is_numeric($a) && is_numeric($b)){
			$buffA = abs($a);
			$buffB = abs($b);
			while ($buffA != $buffB) {
				($buffA > $buffB) ? $buffB += abs($b) : $buffA += abs($a); 
			}
			return $buffA;
		}
	}
	/* FPB */
	static public function fpb($a = 1, $b = 1){
		if(is_numeric($a) && is_numeric($b)){
			$kpk = self::kpk($a, $b);
			$kali = abs($a*$b);
			return $kali/$kpk;
		}
	}

	/* FAKTOR */
	public static function getFaktor($a){
		$hasil = [1];
		$i = 2;
		while($a != 1){
			if($a%$i == 0){
				$a /= $i;
				$hasil []= $i;
			}else{
				$i++;
			}
		}
		return array_count_values($hasil);
	}

	public static function sederhanakan ($value){
		if(is_object($value)){
			return $value->sederhanakan();
		}elseif(is_array($value)){
			$hasil = [];
			foreach ($value as $k => $v) {
				$hasil []= self::sederhanakan($v);
			}
			return $hasil;
		}
	}
	public function invers ($value){
		if(is_object($value)){
			return $this->invers();
		}elseif(is_numeric($value)){
			return (-1)*$value;
		}
	}

	/* CEK */
	// min max
	public static function cekMinMax(&$a, &$b){
		if(is_numeric($a) && is_numeric($b)){
			if($a > $b){
				$buff = $a;
				$a = $b;
				$b = $buff;
			}
		}
	}




	/* PRINT */
	public static function print ($value){
		if(is_object($value))
			return "<span class='katex'>".$value->print()."</span>";
		else if(is_array($value)){
			if(is_array($value[0]))
				return "<span class='katex'>".self::printMultiSuper($value)."</span>";
			else
				return "<span class='katex'>".self::printMulti($value)."</span>";
		}
		else
			return "<span class='katex'> {$value} </span>";
	}


	/**
	 * $value = [3,4akar3,-5/3] 
	*/
	protected static function printMulti($value){
		$hasil = self::print($value[0]);
		unset($value[0]);
		foreach ($value as $k => $v) {
			if(is_object($v)){
				if($v->getNilai() > 0) $hasil .= '+';
			}elseif(is_string($v)){
				if($v[0] != '-') $hasil .= '+';
			}elseif(is_numeric($v)){
				if($v > 0) $hasil .= '+';
			}
			$hasil .= self::print($v);
		}
		return $hasil;
	}

	/**
	 * $value = [[3,4akar3,-5/3],'+',[3]]
	*/
	protected static function printMultiSuper ($value){
		$hasil = "(".self::printMulti($value[0]).")";
		for($i=1; $i <count($value); $i++) {
			$hasil .= ($value[$i]."(".self::printMulti($value[$i+1]).")");
			// if($value[$i] != "="){
			// }else{
				// $hasil .= ($value[$i].self::printMulti($value[$i+1]));
			// }
			$i++;
		}
		return $hasil;
	}

	public static function printFrac ($a, $b){
		$a_clone = self::print($a);
		$b_clone = self::print($b);
		return "<span class='katex'> \\frac{{$a_clone}}{{$b_clone}}</span>";
	}
	public static function printSqrt ($a){
		$a_clone = self::print($a);
		return "<span class='katex'>\\sqrt{{$a_clone}}</span>";
	}
	public static function printSqrtN($a, $b){
		$a_clone = self::print($a);
		$b_clone = self::print($b);
		return "<span class='katex'>\\sqrt[{$b_clone}]{{$a_clone}}</span>";	
	}
	public static function printPower($a, $b=2){
		$a_clone = self::print($a);
		$b_clone = self::print($b);
		if(is_array($a)){
			return "<span class='katex'>({{$a_clone}})^{{$b_clone}}</span>";
		}
		return "<span class='katex'>{{$a_clone}}^{{$b_clone}}</span>";
	}
	
}