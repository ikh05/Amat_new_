<?php


// Set Data Base Data Base
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http";
$httpHost = $protocol.'://'.$_SERVER['HTTP_HOST'];
$host = 'sql302.epizy.com';
$user = 'epiz_33681374';
$pass = 'zTJKLfMKRz';
$db_name = 'epiz_33681374_AMat';
if($_SERVER['HTTP_HOST'] == 'localhost'){
	$httpHost .='/amat.new';
	$host = 'localhost';
	$user = 'root';
	$pass = '';
	$db_name = 'amat';
}
define('BASE_URL', "$httpHost/public/");
define('DB_HOST', $host);
define('DB_USER', $user);
define('DB_PASS', $pass);
define('DB_NAME', $db_name);



// set id Login
define('ID', session_id());
define('LOGIN', 'login_AMAT_NEW'.ID);


// set satuan panjang
define('SATUAN_PANJANG', [	'1000'	=> 'km',
							'100'	=> 'hm', 
							'10'	=> 'dam', 
							'1'		=> 'm', 
							'0.1'	=> 'dm', 
							'0.01'	=> 'cm', 
							'0.001'	=> 'mm']);

