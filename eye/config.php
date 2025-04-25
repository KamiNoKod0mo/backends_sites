<?php
	$autoload = function($class){
		include('php/'.$class.'.php');
	};
	spl_autoload_register($autoload);
	date_default_timezone_set('America/Sao_Paulo');


	//Conectar com banco de dados!
	define('HOST','localhost');
	define('USER','carlos');
	define('PASSWORD','1234');
	define('DATABASE','GODeyeDB');



?>